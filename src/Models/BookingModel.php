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
             WHERE b.court_id = ? AND b.booking_date = ? AND b.status != 'cancelled'"
        );
        $stmt->execute([$courtId, $date]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // [3, 7, ...]
    }

    public function createBooking(array $data): void {
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare(
            "INSERT INTO bookings (court_id, customer_name, customer_phone, booking_date, status)
             VALUES (:court_id, :customer_name, :customer_phone, :booking_date, :status)"
        );

        $stmt->execute([
            ':court_id'       => $data['court_id'],
            ':customer_name'  => $data['customer_name'] ?? 'Khách hàng',
            ':customer_phone' => $data['customer_phone'] ?? null,
            ':booking_date'   => $data['booking_date'],
            ':status'         => $data['status'] ?? 'Pending',
        ]);

        $bookingId = $this->pdo->lastInsertId();

        $detailStmt = $this->pdo->prepare(
            "INSERT INTO booking_details (booking_id, slot_id)
             VALUES (:booking_id, :slot_id)"
        );
        $detailStmt->execute([
            ':booking_id' => $bookingId,
            ':slot_id'    => $data['slot_id'],
        ]);

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
    $stmt = $this->pdo->prepare("
        SELECT 
            b.id            AS booking_id,
            b.booking_date,
            b.status        AS booking_status,
            b.created_at,
            c.name          AS court_name,
            c.price,
            c.image_url,
            ts.start_time,
            ts.end_time
        FROM bookings b
        JOIN courts         c  ON b.court_id = c.id
        JOIN booking_details bd ON b.id      = bd.booking_id
        JOIN time_slots     ts ON bd.slot_id  = ts.id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC, ts.start_time ASC
    ");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        UPDATE bookings SET status = 'cancelled'
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$bookingId, $userId]);
    return true;
}
}