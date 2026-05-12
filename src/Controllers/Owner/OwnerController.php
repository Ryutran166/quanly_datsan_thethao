<?php
// src/Controllers/Owner/OwnerController.php
namespace Nhom2\QuanlyDatsanThethao\Controllers\Owner;

use Nhom2\QuanlyDatsanThethao\Controllers\BaseController;
use Nhom2\QuanlyDatsanThethao\Database;

class OwnerController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    // Danh sách bookings thuộc các sân của chủ sân
    public function bookings(): void
    {
        $ownerId = $_SESSION['user_id'] ?? null;
        if (!$ownerId) {
            header('Location: index.php');
            exit();
        }

        $bookings = $this->getBookingsByOwner($ownerId);

        $pending = array_filter($bookings, fn($b) => strtolower($b['status']) === 'pending');
        $confirmed = array_filter($bookings, fn($b) => strtolower($b['status']) === 'confirmed');
        $cancelled = array_filter($bookings, fn($b) => strtolower($b['status']) === 'cancelled');

        require_once PROJECT_ROOT . '/views/owner/bookings/OwnerBookingsList.php';
    }

    // Chủ sân xác nhận booking
    public function confirmBooking(): void
    {
        $bookingId = (int)($_GET['id'] ?? 0);
        if (!$bookingId) {
            header('Location: index.php?action=owner_bookings&error=invalid_id');
            exit();
        }

        $ownerId = $_SESSION['user_id'] ?? null;
        if (!$ownerId) {
            header('Location: index.php');
            exit();
        }

        $pdo = Database::getInstance()->getConnection();

        // Kiểm tra booking thuộc owner và lấy admin_confirmed_at
        $checkStmt = $pdo->prepare(
            "SELECT b.status, b.admin_confirmed_at
             FROM bookings b
             JOIN courts c ON b.court_id = c.id
             WHERE b.id = ? AND c.owner_id = ? AND b.status != 'Cancelled'"
        );
        $checkStmt->execute([$bookingId, $ownerId]);
        $row = $checkStmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            header('Location: index.php?action=owner_bookings&error=invalid_id');
            exit();
        }

        // Theo yêu cầu: owner xác nhận thì chuyển ngay booking sang Confirmed.
        // (Admin cũng vẫn có thể bấm xác nhận sau, nhưng status đã là Confirmed.)
        $updateSql = "UPDATE bookings SET owner_confirmed_at = NOW(), status = 'Confirmed' WHERE id = ?";


        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([$bookingId]);

        header('Location: index.php?action=owner_bookings&success=confirmed');
        exit();
    }

    private function getBookingsByOwner(int $ownerId): array
    {
        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare(
            "SELECT
                b.id,
                b.court_id,
                b.customer_name,
                b.customer_phone,
                b.booking_date,
                b.status,
                b.payment_method,
                b.created_at,
                b.admin_confirmed_at,
                b.owner_confirmed_at,
                c.name AS court_name,
                c.price,
                ts.start_time,
                ts.end_time
             FROM bookings b
             JOIN courts c ON b.court_id = c.id
             JOIN booking_details bd ON b.id = bd.booking_id
             JOIN time_slots ts ON bd.slot_id = ts.id
             WHERE c.owner_id = ?
             ORDER BY b.created_at DESC"
        );

        $stmt->execute([$ownerId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

