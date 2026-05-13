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

    public function paymentSearch(): void
    {
        $filters = $this->collectPaymentSearchFilters();
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));

        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\BookingModel($pdo);

        $total = 0;
        $results = $model->searchPaymentBookingsForAdmin($filters, $page, $perPage, $total);

        require_once PROJECT_ROOT . '/views/admin/bookings/AdminPaymentSearch.php';
    }

    public function paymentSearchAjax(): void
    {
        if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') {
            http_response_code(400);
            echo 'Bad Request';
            exit();
        }

        $filters = $this->collectPaymentSearchFilters();
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));

        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\BookingModel($pdo);

        $total = 0;
        $results = $model->searchPaymentBookingsForAdmin($filters, $page, $perPage, $total);

        $currentPage = $page;
        $totalPages = (int)ceil($total / $perPage);

        require_once PROJECT_ROOT . '/views/admin/bookings/partials/AdminPaymentSearchResults.php';
    }

    private function collectPaymentSearchFilters(): array
    {
        return [
            'keyword' => trim((string)($_GET['keyword'] ?? '')),
            'payment_status' => trim((string)($_GET['payment_status'] ?? '')),
            'payment_method' => trim((string)($_GET['payment_method'] ?? '')),
            'booking_date' => trim((string)($_GET['booking_date'] ?? '')),
        ];
    }


    // Danh sách tất cả bookings cho admin
    public function bookings()
    {
        $bookings = $this->getAllBookings();

        $pending = array_filter($bookings, fn($b) => strtolower($b['status']) === 'pending');
        $confirmed = array_filter($bookings, fn($b) => strtolower($b['status']) === 'confirmed');
        $cancelled = array_filter($bookings, fn($b) => strtolower($b['status']) === 'cancelled');

        require_once PROJECT_ROOT . '/views/admin/bookings/BookingsList.php';
    }

    // Hủy booking bởi admin
    public function cancelBooking()
    {
        $bookingId = (int)($_GET['id'] ?? 0);

        if (!$bookingId) {
            header("Location: index.php?action=admin_bookings&error=invalid_id");
            exit();
        }

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
        $stmt->execute([$bookingId]);

        header("Location: index.php?action=admin_bookings&success=cancelled");
        exit();
    }

    // Xác nhận booking
    public function confirmBooking()
    {
        $bookingId = (int)($_GET['id'] ?? 0);

        if (!$bookingId) {
            header("Location: index.php?action=admin_bookings&error=invalid_id");
            exit();
        }

        $pdo = Database::getInstance()->getConnection();

        $updateSql = "UPDATE bookings SET admin_confirmed_at = NOW(), status = 'Confirmed' WHERE id = ?";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([$bookingId]);

        header("Location: index.php?action=admin_bookings&success=confirmed");
        exit();
    }

    // Helper: Lấy tất cả bookings (mỗi booking.id = 1 card, kèm danh sách slots)
    private function getAllBookings(): array
    {
        $pdo = Database::getInstance()->getConnection();

        // Lấy booking header (không join booking_details để tránh nhân bản)
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
                c.name AS court_name,
                c.price
            FROM bookings b
            JOIN courts c ON b.court_id = c.id
            WHERE b.status != 'Cancelled'
            ORDER BY b.created_at DESC"
        );
        $stmt->execute();
        $base = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $bookingIds = array_map(fn($x) => (int)$x['id'], $base);
        if (empty($bookingIds)) {
            return $base;
        }

        $in = implode(',', array_fill(0, count($bookingIds), '?'));

        // Lấy slots theo từng booking
        $stmt2 = $pdo->prepare(
            "SELECT
                bd.booking_id,
                ts.start_time,
                ts.end_time
             FROM booking_details bd
             JOIN time_slots ts ON bd.slot_id = ts.id
             WHERE bd.booking_id IN ($in)
             ORDER BY bd.booking_id ASC, ts.start_time ASC"
        );
        $stmt2->execute($bookingIds);
        $rows = $stmt2->fetchAll(\PDO::FETCH_ASSOC);

        $slotsByBooking = [];
        foreach ($rows as $r) {
            $bid = (int)$r['booking_id'];
            $slotsByBooking[$bid][] = $r;
        }

        foreach ($base as &$b) {
            $b['slots'] = $slotsByBooking[(int)$b['id']] ?? [];
        }
        unset($b);

        return $base;
    }
}

