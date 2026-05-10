<?php
// src/Controllers/Admin/AdminController.php
namespace Nhom2\QuanlyDatsanThethao\Controllers\Admin;

use Nhom2\QuanlyDatsanThethao\Controllers\BaseController;
use Nhom2\QuanlyDatsanThethao\Database;

class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    // Danh sách tất cả bookings cho admin
    public function bookings()
    {
        // Lấy tất cả bookings với thông tin chi tiết
        $bookings = $this->getAllBookings();

        // Nhóm theo trạng thái
        $pending = array_filter($bookings, fn($b) => strtolower($b['status']) === 'pending');
        $confirmed = array_filter($bookings, fn($b) => strtolower($b['status']) === 'confirmed');
        $cancelled = array_filter($bookings, fn($b) => strtolower($b['status']) === 'cancelled');

        require_once PROJECT_ROOT . '/views/admin/bookings/BookingsList.php';
    }

    // Hủy booking bởi admin
    public function cancelBooking()
    {
        $bookingId = (int) ($_GET['id'] ?? 0);

        if (!$bookingId) {
            header("Location: index.php?action=admin_bookings&error=invalid_id");
            exit();
        }

        // Cập nhật trạng thái thành cancelled
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
        $stmt->execute([$bookingId]);

        header("Location: index.php?action=admin_bookings&success=cancelled");
        exit();
    }

    // Xác nhận booking
    public function confirmBooking()
    {
        $bookingId = (int) ($_GET['id'] ?? 0);

        if (!$bookingId) {
            header("Location: index.php?action=admin_bookings&error=invalid_id");
            exit();
        }

        // Admin bấm xác nhận thì chuyển ngay sang Confirmed (theo yêu cầu)
        $pdo = Database::getInstance()->getConnection();

        $updateSql = "UPDATE bookings SET admin_confirmed_at = NOW(), status = 'Confirmed' WHERE id = ?";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([$bookingId]);

        header("Location: index.php?action=admin_bookings&success=confirmed");
        exit();

    }

    // Helper: Lấy tất cả bookings
    private function getAllBookings()
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT
                b.id,
                b.court_id,
                b.customer_name,
                b.customer_phone,
                b.booking_date,
                b.status,
                b.created_at,
                c.name AS court_name,
                c.price,
                ts.start_time,
                ts.end_time
            FROM bookings b
            JOIN courts c ON b.court_id = c.id
            JOIN booking_details bd ON b.id = bd.booking_id
            JOIN time_slots ts ON bd.slot_id = ts.id
            ORDER BY b.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>