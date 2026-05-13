<?php
// src/Models/BookingModel.php
namespace Nhom2\QuanlyDatsanThethao\Models;

use PDO;

class BookingModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Trả về mảng slot_id đã đặt theo court + date
    public function getBookedSlots(int $courtId, string $date): array {
        $stmt = $this->pdo->prepare(
            "SELECT bd.slot_id FROM bookings b 
             JOIN booking_details bd ON b.id = bd.booking_id 
             WHERE b.court_id = ? AND b.booking_date = ? AND b.status != 'Cancelled'"
        );
        $stmt->execute([$courtId, $date]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // [3, 7, ...]
    }

    public function createBooking(array $data): void {
        // Backward-compatible: tạo 1 booking cho đúng 1 slot_id
        $slotIds = [];
        if (isset($data['slot_id'])) {
            $slotIds[] = (int)$data['slot_id'];
        }

        $this->createBookingWithSlots($data, $slotIds);
    }

    public function createBookingWithSlots(array $data, array $slotIds): void {
        $slotIds = array_values(array_filter(array_map('intval', $slotIds), fn($x) => $x > 0));
        if (empty($slotIds)) {
            throw new \InvalidArgumentException('slotIds rỗng');
        }

        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare(
            "INSERT INTO bookings (court_id, customer_name, customer_phone, booking_date, status, user_id, payment_method)
             VALUES (:court_id, :customer_name, :customer_phone, :booking_date, :status, :user_id, :payment_method)"
        );
        $stmt->execute([
            ':court_id'          => $data['court_id'],
            ':customer_name'     => $data['customer_name'] ?? 'Khách hàng',
            ':customer_phone'    => $data['customer_phone'] ?? null,
            ':booking_date'      => $data['booking_date'],
            ':status'            => $data['status'] ?? 'Pending',
            ':user_id'           => $data['user_id'] ?? null,
            ':payment_method'   => $data['payment_method'] ?? 'cash',
        ]);

        $bookingId = (int)$this->pdo->lastInsertId();

        $detailStmt = $this->pdo->prepare(
            "INSERT INTO booking_details (booking_id, slot_id)
             VALUES (:booking_id, :slot_id)"
        );

        foreach ($slotIds as $slotId) {
            $detailStmt->execute([
                ':booking_id' => $bookingId,
                ':slot_id'    => $slotId,
            ]);
        }

        $this->pdo->commit();
    }


    public function getSlotById(int $slotId): ?array
        {
            $stmt = $this->pdo->prepare("SELECT * FROM time_slots WHERE id = ?");
            $stmt->execute([$slotId]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        }
    public function getBookingsByUser(int $userId): array
{
    // 1 card = 1 booking (group theo b.id).
    // NOTE: Để hiển thị cả mục "Đã hủy" trong MyBookings, không loại bỏ status Cancelled.
    $stmt = $this->pdo->prepare(
        "SELECT
            b.id            AS booking_id,
            b.court_id,
            b.booking_date,
            b.status        AS booking_status,
            b.payment_method,
            b.created_at,
            c.name          AS court_name,
            c.price         AS court_price,
            c.image,
            b.total_amount
        FROM bookings b
        JOIN courts c ON b.court_id = c.id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC, b.created_at DESC"
    );

    $stmt->execute([$userId]);
    $base = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$base) return [];

    $bookingIds = array_map(fn($r) => (int)$r['booking_id'], $base);
    $in = implode(',', array_fill(0, count($bookingIds), '?'));

    $slotStmt = $this->pdo->prepare(
        "SELECT
            bd.booking_id,
            ts.start_time,
            ts.end_time,
            ts.price_modifier
        FROM booking_details bd
        JOIN time_slots ts ON bd.slot_id = ts.id
        WHERE bd.booking_id IN ($in)
        ORDER BY bd.booking_id ASC, ts.start_time ASC"
    );
    $slotStmt->execute($bookingIds);
    $slotRows = $slotStmt->fetchAll(PDO::FETCH_ASSOC);

    $slotsByBooking = [];
    foreach ($slotRows as $sr) {
        $bid = (int)$sr['booking_id'];
        $slotsByBooking[$bid][] = $sr;
    }

    $result = [];
    foreach ($base as $r) {
        $bid = (int)$r['booking_id'];
        $slots = $slotsByBooking[$bid] ?? [];

        $totalAmount = $r['total_amount'] ?? null;
        if ($totalAmount === null || $totalAmount === '') {
            $totalAmount = 0.0;
            $courtPrice = (float)($r['court_price'] ?? 0);
            foreach ($slots as $s) {
                $modifier = isset($s['price_modifier']) ? (float)$s['price_modifier'] : 1.0;
                $totalAmount += $courtPrice * $modifier;
            }
        }

        // Chuẩn hoá field để MyBookings.php render thống nhất
        $result[] = [
            'booking_id' => $bid,
            'court_id' => (int)$r['court_id'],
            'booking_date' => $r['booking_date'],
            'booking_status' => $r['booking_status'],
            'payment_method' => $r['payment_method'],
            'created_at' => $r['created_at'],
            'court_name' => $r['court_name'],
            'image_url' => $r['image'],
            'slots' => $slots,
            'total_amount' => (float)$totalAmount,
        ];
    }

    return $result;
}


public function cancelBooking(int $bookingId, int $userId): bool
{
    // Chỉ cho hủy nếu còn hơn 12 tiếng
    $stmt = $this->pdo->prepare("
        SELECT b.booking_date, ts.start_time
        FROM bookings b
        JOIN booking_details bd ON b.id     = bd.booking_id
        JOIN time_slots      ts ON bd.slot_id = ts.id
        WHERE b.id = ? AND b.user_id = ?
    ");
    $stmt->execute([$bookingId, $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) return false;

    $bookingTime = strtotime($row['booking_date'] . ' ' . $row['start_time']);
    $hoursDiff   = ($bookingTime - time()) / 3600;

    if ($hoursDiff < 12) return false; // Không đủ điều kiện hủy

    $stmt = $this->pdo->prepare("
        UPDATE bookings SET status = 'Cancelled'
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$bookingId, $userId]);
    return true;
}

    /**
     * Search module: Tìm kiếm thanh toán (thuộc Owner)
     */
    public function searchPaymentBookingsForOwner(int $ownerId, array $filters, int $page, int $perPage, int &$total): array
    {
        $keyword = trim((string)($filters['keyword'] ?? ''));
        $paymentStatus = trim((string)($filters['payment_status'] ?? ''));
        $paymentMethod = trim((string)($filters['payment_method'] ?? ''));
        $bookingDate = trim((string)($filters['booking_date'] ?? ''));

        $where = ["c.owner_id = :owner_id", "b.status != 'Cancelled'"];
        $params = [':owner_id' => $ownerId];

        if ($keyword !== '') {
            $where[] = "(CAST(b.id AS CHAR) LIKE :kw OR b.customer_name LIKE :kw OR b.customer_phone LIKE :kw)";
            $params[':kw'] = '%' . $keyword . '%';
        }

        if ($paymentStatus !== '') {
            $where[] = "b.status = :payment_status";
            $params[':payment_status'] = $paymentStatus;
        }

        if ($paymentMethod !== '') {
            $where[] = "b.payment_method = :payment_method";
            $params[':payment_method'] = $paymentMethod;
        }

        if ($bookingDate !== '') {
            $where[] = "b.booking_date = :booking_date";
            $params[':booking_date'] = $bookingDate;
        }

        $whereSql = implode(' AND ', $where);

        $countSql = "SELECT COUNT(DISTINCT b.id) AS total
                      FROM bookings b
                      JOIN courts c ON b.court_id = c.id
                      WHERE {$whereSql}";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)($countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

        $offset = max(0, ($page - 1) * $perPage);

        $sql = "SELECT
                    b.id,
                    b.court_id,
                    b.customer_name,
                    b.customer_phone,
                    b.booking_date,
                    b.status,
                    b.payment_method,
                    b.total_amount,
                    b.created_at,
                    c.name AS court_name,
                    c.price AS court_price
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                WHERE {$whereSql}
                GROUP BY b.id
                ORDER BY b.booking_date DESC, b.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) return [];

        $bookingIds = array_map(fn($r) => (int)$r['id'], $rows);
        $in = implode(',', array_fill(0, count($bookingIds), '?'));

        $slotSql = "SELECT bd.booking_id, ts.start_time, ts.end_time
                     FROM booking_details bd
                     JOIN time_slots ts ON bd.slot_id = ts.id
                     WHERE bd.booking_id IN ({$in})
                     ORDER BY bd.booking_id ASC, ts.start_time ASC";
        $slotStmt = $this->pdo->prepare($slotSql);
        $slotStmt->execute($bookingIds);
        $slotRows = $slotStmt->fetchAll(PDO::FETCH_ASSOC);

        $slotsByBooking = [];
        foreach ($slotRows as $sr) {
            $bid = (int)$sr['booking_id'];
            $slotsByBooking[$bid][] = $sr;
        }

        $result = [];
        foreach ($rows as $r) {
            $bid = (int)$r['id'];
            $totalAmount = $r['total_amount'];
            if ($totalAmount === null || $totalAmount === '') {
                $totalAmount = 0;
                $courtPrice = (float)$r['court_price'];
                foreach (($slotsByBooking[$bid] ?? []) as $s) {
                    $modifier = isset($s['price_modifier']) ? (float)$s['price_modifier'] : 1.0;
                    $totalAmount += $courtPrice * $modifier;
                }
            }

            $result[] = [
                'id' => $bid,
                'court_id' => (int)$r['court_id'],
                'customer_name' => $r['customer_name'],
                'customer_phone' => $r['customer_phone'],
                'booking_date' => $r['booking_date'],
                'status' => $r['status'],
                'payment_method' => $r['payment_method'],
                'total_amount' => (float)$totalAmount,
                'court_name' => $r['court_name'],
                'slots' => $slotsByBooking[$bid] ?? [],
            ];
        }

        return $result;
    }

    /** Search module: Tìm kiếm thanh toán (thuộc Admin) */
    public function searchPaymentBookingsForAdmin(array $filters, int $page, int $perPage, int &$total): array
    {
        $keyword = trim((string)($filters['keyword'] ?? ''));
        $paymentStatus = trim((string)($filters['payment_status'] ?? ''));
        $paymentMethod = trim((string)($filters['payment_method'] ?? ''));
        $bookingDate = trim((string)($filters['booking_date'] ?? ''));

        $where = ["b.status != 'Cancelled'"];
        $params = [];

        if ($keyword !== '') {
            $where[] = "(CAST(b.id AS CHAR) LIKE :kw OR b.customer_name LIKE :kw OR b.customer_phone LIKE :kw)";
            $params[':kw'] = '%' . $keyword . '%';
        }

        if ($paymentStatus !== '') {
            $where[] = "b.status = :payment_status";
            $params[':payment_status'] = $paymentStatus;
        }

        if ($paymentMethod !== '') {
            $where[] = "b.payment_method = :payment_method";
            $params[':payment_method'] = $paymentMethod;
        }

        if ($bookingDate !== '') {
            $where[] = "b.booking_date = :booking_date";
            $params[':booking_date'] = $bookingDate;
        }

        $whereSql = implode(' AND ', $where);

        $countSql = "SELECT COUNT(DISTINCT b.id) AS total
                      FROM bookings b
                      JOIN courts c ON b.court_id = c.id
                      WHERE {$whereSql}";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)($countStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

        $offset = max(0, ($page - 1) * $perPage);

        $sql = "SELECT
                    b.id,
                    b.court_id,
                    b.customer_name,
                    b.customer_phone,
                    b.booking_date,
                    b.status,
                    b.payment_method,
                    b.total_amount,
                    b.created_at,
                    c.name AS court_name,
                    c.price AS court_price
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                WHERE {$whereSql}
                GROUP BY b.id
                ORDER BY b.booking_date DESC, b.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) return [];

        $bookingIds = array_map(fn($r) => (int)$r['id'], $rows);
        $in = implode(',', array_fill(0, count($bookingIds), '?'));

        $slotSql = "SELECT bd.booking_id, ts.start_time, ts.end_time
                     FROM booking_details bd
                     JOIN time_slots ts ON bd.slot_id = ts.id
                     WHERE bd.booking_id IN ({$in})
                     ORDER BY bd.booking_id ASC, ts.start_time ASC";
        $slotStmt = $this->pdo->prepare($slotSql);
        $slotStmt->execute($bookingIds);
        $slotRows = $slotStmt->fetchAll(PDO::FETCH_ASSOC);

        $slotsByBooking = [];
        foreach ($slotRows as $sr) {
            $bid = (int)$sr['booking_id'];
            $slotsByBooking[$bid][] = $sr;
        }

        $result = [];
        foreach ($rows as $r) {
            $bid = (int)$r['id'];
            $totalAmount = $r['total_amount'];
            if ($totalAmount === null || $totalAmount === '') {
                $totalAmount = count($slotsByBooking[$bid] ?? []) * (float)$r['court_price'];
            }

            $result[] = [
                'id' => $bid,
                'court_id' => (int)$r['court_id'],
                'customer_name' => $r['customer_name'],
                'customer_phone' => $r['customer_phone'],
                'booking_date' => $r['booking_date'],
                'status' => $r['status'],
                'payment_method' => $r['payment_method'],
                'total_amount' => (float)$totalAmount,
                'court_name' => $r['court_name'],
                'slots' => $slotsByBooking[$bid] ?? [],
            ];
        }

        return $result;
    }
}

