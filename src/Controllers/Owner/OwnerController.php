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

    public function paymentSearch(): void
    {
        $ownerId = (int)($_SESSION['user_id'] ?? 0);
        if (!$ownerId) {
            header('Location: index.php');
            exit();
        }

        $filters = $this->collectPaymentSearchFilters();
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));

        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\BookingModel($pdo);

        $total = 0;
        $results = $model->searchPaymentBookingsForOwner($ownerId, $filters, $page, $perPage, $total);

        require_once PROJECT_ROOT . '/views/owner/bookings/OwnerPaymentSearch.php';
    }

    public function paymentSearchAjax(): void
    {
        if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') {
            http_response_code(400);
            echo 'Bad Request';
            exit();
        }

        $ownerId = (int)($_SESSION['user_id'] ?? 0);
        if (!$ownerId) {
            http_response_code(401);
            echo 'Unauthorized';
            exit();
        }

        $filters = $this->collectPaymentSearchFilters();
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));

        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\BookingModel($pdo);

        $total = 0;
        $results = $model->searchPaymentBookingsForOwner($ownerId, $filters, $page, $perPage, $total);

        $currentPage = $page;
        $totalPages = (int)ceil($total / $perPage);

        require_once PROJECT_ROOT . '/views/owner/bookings/partials/OwnerPaymentSearchResults.php';
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

    private function getBookingsByOwner(int $ownerId): array
    {
        $pdo = Database::getInstance()->getConnection();


        // Lấy booking (1 card = 1 booking_id). Không JOIN booking_details để tránh nhân bản.
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
                c.price
             FROM bookings b
             JOIN courts c ON b.court_id = c.id
             WHERE c.owner_id = ? AND b.status != 'Cancelled'
             ORDER BY b.created_at DESC"
        );

        $stmt->execute([$ownerId]);
        $base = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Lấy slots theo từng booking để hiển thị nhiều giờ trong 1 card
        $bookingIds = array_map(fn($x) => (int)$x['id'], $base);
        if (empty($bookingIds)) {
            return $base;
        }

        $in = implode(',', array_fill(0, count($bookingIds), '?'));
        $stmt2 = $pdo->prepare(
            "SELECT bd.booking_id, ts.start_time, ts.end_time
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

            // total_amount: nếu booking.total_amount null thì tính theo court.price * time_slots.price_modifier
            if (!array_key_exists('total_amount', $b) || $b['total_amount'] === null || $b['total_amount'] === '') {
                $courtPrice = (float)($b['price'] ?? 0);
                $total = 0.0;
                foreach ($b['slots'] as $s) {
                    $modifier = isset($s['price_modifier']) ? (float)$s['price_modifier'] : 1.0;
                    $total += $courtPrice * $modifier;
                }
                $b['total_amount'] = $total;
            }
        }
        unset($b);

        return $base;
    }
}

