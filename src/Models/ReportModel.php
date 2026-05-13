<?php
// src/Models/ReportModel.php
namespace Nhom2\QuanlyDatsanThethao\Models;

use PDO;

class ReportModel
{
    private PDO $pdo;

    // 1 giờ = 100,000đ
    const PRICE_PER_HOUR = 100000;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // ─── HELPERS ──────────────────────────────────────────────────

    /**
     * JOIN lấy tổng phút slot của mỗi booking.
     * Nếu booking không có slot → total_mins = NULL → dùng mặc định 60 phút.
     */
    private function slotJoin(): string
    {
        // Gom tổng phút + tổng doanh thu theo booking_id để tránh nhân bản khi booking_details có nhiều dòng.
        return "LEFT JOIN (
                    SELECT bd.booking_id,
                           SUM(TIMESTAMPDIFF(MINUTE, ts.start_time, ts.end_time)) AS total_mins,
                           SUM(c.price * COALESCE(ts.price_modifier, 1)) AS total_amount
                    FROM booking_details bd
                    JOIN time_slots ts ON bd.slot_id = ts.id
                    JOIN bookings b ON b.id = bd.booking_id
                    JOIN courts c ON c.id = b.court_id
                    GROUP BY bd.booking_id
                ) sd ON sd.booking_id = b.id";
    }


    /**
     * Biểu thức SQL tính doanh thu.
     * - Ưu tiên sd.total_amount = court_price * price_modifier theo từng slot.
     * - Nếu booking không có slot hoặc tổng_amount bị null/0 → fallback theo tổng phút.
     */
    private function revenueExpr(): string
    {
        return "CASE
                    WHEN sd.total_amount IS NOT NULL AND sd.total_amount > 0
                        THEN sd.total_amount
                    WHEN sd.total_mins IS NOT NULL AND sd.total_mins > 0
                        THEN sd.total_mins / 60.0 * " . self::PRICE_PER_HOUR . "
                    ELSE " . self::PRICE_PER_HOUR . "
                END";
    }

    private function buildDateWhere(string $col, string $dateFrom, string $dateTo): array
    {
        $where  = ['1=1'];
        $params = [];
        if ($dateFrom !== '') {
            $where[]             = "{$col} >= :date_from";
            $params[':date_from'] = $dateFrom;
        }
        if ($dateTo !== '') {
            $where[]            = "{$col} <= :date_to";
            $params[':date_to'] = $dateTo;
        }
        return [$where, $params];
    }

    // ─── REVENUE REPORT ───────────────────────────────────────────

    public function getTotalRevenue(string $dateFrom = '', string $dateTo = ''): float
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[] = "b.status = 'Confirmed'";
        $rev     = $this->revenueExpr();

        $sql = "SELECT COALESCE(SUM({$rev}), 0) AS total
                FROM bookings b
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (float)($stmt->fetchColumn() ?? 0);
    }

    public function getRevenueByDay(string $dateFrom, string $dateTo): array
    {
        $rev = $this->revenueExpr();

        $sql = "SELECT DATE(b.booking_date) AS day,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                " . $this->slotJoin() . "
                WHERE b.status = 'Confirmed'
                  AND b.booking_date BETWEEN :from AND :to
                GROUP BY DATE(b.booking_date)
                ORDER BY day ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':from' => $dateFrom, ':to' => $dateTo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRevenueByMonth(int $year): array
    {
        $rev = $this->revenueExpr();

        $sql = "SELECT MONTH(b.booking_date) AS month,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                " . $this->slotJoin() . "
                WHERE b.status = 'Confirmed'
                  AND YEAR(b.booking_date) = :year
                GROUP BY MONTH(b.booking_date)
                ORDER BY month ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [];
        foreach ($rows as $r) {
            $map[(int)$r['month']] = $r;
        }
        $result = [];
        for ($m = 1; $m <= 12; $m++) {
            $result[] = $map[$m] ?? ['month' => $m, 'revenue' => 0, 'booking_count' => 0];
        }
        return $result;
    }

    public function getRevenueByCourt(string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[] = "b.status = 'Confirmed'";
        $rev     = $this->revenueExpr();

        $sql = "SELECT c.name AS court_name,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.court_id, c.name
                ORDER BY revenue DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRevenueByPaymentMethod(string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[] = "b.status = 'Confirmed'";
        $rev     = $this->revenueExpr();

        $sql = "SELECT b.payment_method,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.payment_method";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── BOOKING REPORT ───────────────────────────────────────────

    public function getBookingStatsByStatus(string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);

        $sql = "SELECT b.status, COUNT(*) AS count
                FROM bookings b
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.status";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = ['Pending' => 0, 'Confirmed' => 0, 'Cancelled' => 0, 'Locked' => 0];
        foreach ($rows as $r) {
            $map[$r['status']] = (int)$r['count'];
        }
        return $map;
    }

    public function getBookingsByCourt(string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);

        $sql = "SELECT c.name AS court_name,
                       COUNT(*) AS total,
                       SUM(CASE WHEN b.status='Confirmed' THEN 1 ELSE 0 END) AS confirmed,
                       SUM(CASE WHEN b.status='Cancelled' THEN 1 ELSE 0 END) AS cancelled
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.court_id, c.name
                ORDER BY total DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingsByDay(string $dateFrom, string $dateTo): array
    {
        $sql = "SELECT DATE(b.booking_date) AS day, COUNT(*) AS total
                FROM bookings b
                WHERE b.booking_date BETWEEN :from AND :to
                GROUP BY DATE(b.booking_date)
                ORDER BY day ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':from' => $dateFrom, ':to' => $dateTo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── CUSTOMER REPORT ──────────────────────────────────────────

    public function getNewCustomersByMonth(int $year): array
    {
        $sql = "SELECT MONTH(u.created_at) AS month, COUNT(*) AS count
                FROM users u
                WHERE u.role = 'customer'
                  AND YEAR(u.created_at) = :year
                GROUP BY MONTH(u.created_at)
                ORDER BY month ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [];
        foreach ($rows as $r) {
            $map[(int)$r['month']] = (int)$r['count'];
        }
        $result = [];
        for ($m = 1; $m <= 12; $m++) {
            $result[] = ['month' => $m, 'count' => $map[$m] ?? 0];
        }
        return $result;
    }

    public function getTotalCustomers(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'customer'");
        return (int)$stmt->fetchColumn();
    }

    public function getNewCustomersThisMonth(): int
    {
        $stmt = $this->pdo->query(
            "SELECT COUNT(*) FROM users
             WHERE role = 'customer'
               AND YEAR(created_at) = YEAR(CURDATE())
               AND MONTH(created_at) = MONTH(CURDATE())"
        );
        return (int)$stmt->fetchColumn();
    }

    public function getTopCustomersByBooking(string $dateFrom = '', string $dateTo = '', int $limit = 10): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[] = "b.status = 'Confirmed'";
        $where[] = "b.user_id IS NOT NULL";
        $rev     = $this->revenueExpr();

        $sql = "SELECT u.name, u.email, u.phone,
                       COUNT(*) AS booking_count,
                       SUM({$rev}) AS total_spent
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.user_id, u.name, u.email, u.phone
                ORDER BY booking_count DESC
                LIMIT :lim";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerList(string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('u.created_at', $dateFrom, $dateTo);
        $where[] = "u.role = 'customer'";

        $sql = "SELECT u.id, u.name, u.email, u.phone, u.created_at,
                       (SELECT COUNT(*) FROM bookings b2
                        WHERE b2.user_id = u.id AND b2.status = 'Confirmed') AS booking_count,
                       (SELECT COALESCE(SUM(
                           CASE WHEN sd2.total_mins IS NOT NULL AND sd2.total_mins > 0
                               THEN sd2.total_mins / 60.0 * " . self::PRICE_PER_HOUR . "
                               ELSE " . self::PRICE_PER_HOUR . "
                           END
                       ), 0)
                        FROM bookings b3
                        LEFT JOIN (
                            SELECT bd.booking_id,
                                   SUM(TIMESTAMPDIFF(MINUTE, ts.start_time, ts.end_time)) AS total_mins
                            FROM booking_details bd JOIN time_slots ts ON bd.slot_id = ts.id
                            GROUP BY bd.booking_id
                        ) sd2 ON sd2.booking_id = b3.id
                        WHERE b3.user_id = u.id AND b3.status = 'Confirmed') AS total_spent
                FROM users u
                WHERE " . implode(' AND ', $where) . "
                ORDER BY u.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── EXPORT DATA ──────────────────────────────────────────────

    public function getRevenueExportData(string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[] = "b.status = 'Confirmed'";
        $rev     = $this->revenueExpr();

        $sql = "SELECT b.id, b.customer_name, b.customer_phone,
                       c.name AS court_name, b.booking_date,
                       b.payment_method,
                       COALESCE(sd.total_mins, 60) AS total_mins,
                       ({$rev}) AS revenue,
                       b.created_at
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                ORDER BY b.booking_date DESC, b.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingExportData(string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $rev = $this->revenueExpr();

        $sql = "SELECT b.id, b.customer_name, b.customer_phone,
                       c.name AS court_name, b.booking_date,
                       b.status, b.payment_method,
                       COALESCE(sd.total_mins, 60) AS total_mins,
                       ({$rev}) AS revenue,
                       b.created_at
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                ORDER BY b.booking_date DESC, b.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── OWNER REPORT ─────────────────────────────────────────────

    public function getOwnerTotalRevenue(int $ownerId, string $dateFrom = '', string $dateTo = ''): float
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[]            = "b.status = 'Confirmed'";
        $where[]            = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;
        $rev = $this->revenueExpr();

        $sql = "SELECT COALESCE(SUM({$rev}), 0) AS total
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (float)($stmt->fetchColumn() ?? 0);
    }

    public function getOwnerRevenueByMonth(int $ownerId, int $year): array
    {
        $rev = $this->revenueExpr();

        $sql = "SELECT MONTH(b.booking_date) AS month,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE b.status = 'Confirmed'
                  AND c.owner_id = :owner_id
                  AND YEAR(b.booking_date) = :year
                GROUP BY MONTH(b.booking_date)
                ORDER BY month ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':owner_id' => $ownerId, ':year' => $year]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [];
        foreach ($rows as $r) {
            $map[(int)$r['month']] = $r;
        }
        $result = [];
        for ($m = 1; $m <= 12; $m++) {
            $result[] = $map[$m] ?? ['month' => $m, 'revenue' => 0, 'booking_count' => 0];
        }
        return $result;
    }

    public function getOwnerRevenueByDay(int $ownerId, string $dateFrom, string $dateTo): array
    {
        $rev = $this->revenueExpr();

        $sql = "SELECT DATE(b.booking_date) AS day,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE b.status = 'Confirmed'
                  AND c.owner_id = :owner_id
                  AND b.booking_date BETWEEN :from AND :to
                GROUP BY DATE(b.booking_date)
                ORDER BY day ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':owner_id' => $ownerId, ':from' => $dateFrom, ':to' => $dateTo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOwnerRevenueByCourt(int $ownerId, string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[]            = "b.status = 'Confirmed'";
        $where[]            = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;
        $rev = $this->revenueExpr();

        $sql = "SELECT c.name AS court_name,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.court_id, c.name
                ORDER BY revenue DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOwnerRevenueByPaymentMethod(int $ownerId, string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[]            = "b.status = 'Confirmed'";
        $where[]            = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;
        $rev = $this->revenueExpr();

        $sql = "SELECT b.payment_method,
                       SUM({$rev}) AS revenue,
                       COUNT(*) AS booking_count
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.payment_method";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOwnerBookingStatsByStatus(int $ownerId, string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[]            = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;

        $sql = "SELECT b.status, COUNT(*) AS count
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.status";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = ['Pending' => 0, 'Confirmed' => 0, 'Cancelled' => 0, 'Locked' => 0];
        foreach ($rows as $r) {
            $map[$r['status']] = (int)$r['count'];
        }
        return $map;
    }

    public function getOwnerBookingsByCourt(int $ownerId, string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[]            = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;

        $sql = "SELECT c.name AS court_name,
                       COUNT(*) AS total,
                       SUM(CASE WHEN b.status='Confirmed' THEN 1 ELSE 0 END) AS confirmed,
                       SUM(CASE WHEN b.status='Cancelled' THEN 1 ELSE 0 END) AS cancelled
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.court_id, c.name
                ORDER BY total DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOwnerRevenueExportData(int $ownerId, string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[]            = "b.status = 'Confirmed'";
        $where[]            = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;
        $rev = $this->revenueExpr();

        $sql = "SELECT b.id, b.customer_name, b.customer_phone,
                       c.name AS court_name, b.booking_date,
                       b.payment_method,
                       COALESCE(sd.total_mins, 60) AS total_mins,
                       ({$rev}) AS revenue,
                       b.created_at
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                ORDER BY b.booking_date DESC, b.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOwnerBookingExportData(int $ownerId, string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[]            = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;
        $rev = $this->revenueExpr();

        $sql = "SELECT b.id, b.customer_name, b.customer_phone,
                       c.name AS court_name, b.booking_date,
                       b.status, b.payment_method,
                       COALESCE(sd.total_mins, 60) AS total_mins,
                       ({$rev}) AS revenue,
                       b.created_at
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                ORDER BY b.booking_date DESC, b.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── OWNER CUSTOMER REPORT ───────────────────────────────────

    public function getOwnerTotalCustomers(int $ownerId): int
    {
        $sql = "SELECT COUNT(*)
                FROM users u
                WHERE u.role = 'customer'
                  AND EXISTS (
                      SELECT 1
                      FROM bookings b
                      JOIN courts c ON b.court_id = c.id
                      WHERE b.user_id = u.id
                        AND b.status = 'Confirmed'
                        AND c.owner_id = :owner_id
                  )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':owner_id' => $ownerId]);
        return (int)($stmt->fetchColumn() ?? 0);
    }

    public function getOwnerNewCustomersThisMonth(int $ownerId): int
    {
        $sql = "SELECT COUNT(*)
                FROM users u
                WHERE u.role = 'customer'
                  AND YEAR(u.created_at) = YEAR(CURDATE())
                  AND MONTH(u.created_at) = MONTH(CURDATE())
                  AND EXISTS (
                      SELECT 1
                      FROM bookings b
                      JOIN courts c ON b.court_id = c.id
                      WHERE b.user_id = u.id
                        AND b.status = 'Confirmed'
                        AND c.owner_id = :owner_id
                  )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':owner_id' => $ownerId]);
        return (int)($stmt->fetchColumn() ?? 0);
    }

    public function getOwnerNewCustomersByMonth(int $ownerId, int $year): array
    {
        // 12 tháng luôn đủ để chart không lỗi
        $sql = "SELECT MONTH(u.created_at) AS month, COUNT(*) AS count
                FROM users u
                WHERE u.role = 'customer'
                  AND YEAR(u.created_at) = :year
                  AND EXISTS (
                      SELECT 1
                      FROM bookings b
                      JOIN courts c ON b.court_id = c.id
                      WHERE b.user_id = u.id
                        AND b.status = 'Confirmed'
                        AND c.owner_id = :owner_id
                  )
                GROUP BY MONTH(u.created_at)
                ORDER BY month ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year, ':owner_id' => $ownerId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $map = [];
        foreach ($rows as $r) {
            $map[(int)$r['month']] = (int)$r['count'];
        }

        $result = [];
        for ($m = 1; $m <= 12; $m++) {
            $result[] = ['month' => $m, 'count' => $map[$m] ?? 0];
        }
        return $result;
    }

    public function getOwnerTopCustomersByBooking(int $ownerId, string $dateFrom = '', string $dateTo = '', int $limit = 10): array
    {
        [$where, $params] = $this->buildDateWhere('b.booking_date', $dateFrom, $dateTo);
        $where[] = "b.status = 'Confirmed'";
        $where[] = "b.user_id IS NOT NULL";
        $where[] = "c.owner_id = :owner_id";
        $params[':owner_id'] = $ownerId;

        $rev = $this->revenueExpr();

        $sql = "SELECT u.name, u.email, u.phone,
                       COUNT(*) AS booking_count,
                       SUM({$rev}) AS total_spent
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                JOIN courts c ON b.court_id = c.id
                " . $this->slotJoin() . "
                WHERE " . implode(' AND ', $where) . "
                GROUP BY b.user_id, u.name, u.email, u.phone
                ORDER BY booking_count DESC
                LIMIT :lim";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOwnerCustomerList(int $ownerId, string $dateFrom = '', string $dateTo = ''): array
    {
        [$where, $params] = $this->buildDateWhere('u.created_at', $dateFrom, $dateTo);
        $where[] = "u.role = 'customer'";
        $where[] = "EXISTS (
            SELECT 1
            FROM bookings b4
            JOIN courts c4 ON b4.court_id = c4.id
            WHERE b4.user_id = u.id
              AND b4.status = 'Confirmed'
              AND c4.owner_id = :owner_id
        )";
        $params[':owner_id'] = $ownerId;

        $sql = "SELECT u.id, u.name, u.email, u.phone, u.created_at,
                       (SELECT COUNT(*)
                        FROM bookings b2
                        JOIN courts c2 ON b2.court_id = c2.id
                        WHERE b2.user_id = u.id
                          AND b2.status = 'Confirmed'
                          AND c2.owner_id = :owner_id) AS booking_count,
                       (SELECT COALESCE(SUM(
                           CASE
                               WHEN sd2.total_mins IS NOT NULL AND sd2.total_mins > 0
                                   THEN sd2.total_mins / 60.0 * " . self::PRICE_PER_HOUR . "
                               ELSE " . self::PRICE_PER_HOUR . "
                           END
                       ), 0)
                        FROM bookings b3
                        JOIN courts c3 ON b3.court_id = c3.id
                        LEFT JOIN (
                            SELECT bd.booking_id,
                                   SUM(TIMESTAMPDIFF(MINUTE, ts.start_time, ts.end_time)) AS total_mins
                            FROM booking_details bd
                            JOIN time_slots ts ON bd.slot_id = ts.id
                            GROUP BY bd.booking_id
                        ) sd2 ON sd2.booking_id = b3.id
                        WHERE b3.user_id = u.id
                          AND b3.status = 'Confirmed'
                          AND c3.owner_id = :owner_id) AS total_spent
                FROM users u
                WHERE " . implode(' AND ', $where) . "
                ORDER BY u.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

