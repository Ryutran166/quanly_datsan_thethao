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

    // ─── REVENUE REPORT ───────────────────────────────────────────

    public function revenueReport(): void
    {
        $ownerId = (int)($_SESSION['user_id'] ?? 0);
        if (!$ownerId) { header('Location: index.php'); exit(); }

        $pdo   = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $year     = (int)($_GET['year'] ?? date('Y'));
        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));

        $totalRevenue    = $model->getOwnerTotalRevenue($ownerId, $dateFrom, $dateTo);
        $revenueByMonth  = $model->getOwnerRevenueByMonth($ownerId, $year);
        $revenueByCourt  = $model->getOwnerRevenueByCourt($ownerId, $dateFrom, $dateTo);
        $revenueByMethod = $model->getOwnerRevenueByPaymentMethod($ownerId, $dateFrom, $dateTo);

        $revenueByDay = [];
        if ($dateFrom !== '' && $dateTo !== '') {
            $revenueByDay = $model->getOwnerRevenueByDay($ownerId, $dateFrom, $dateTo);
        }

        require_once PROJECT_ROOT . '/views/owner/reports/RevenueReport.php';
    }

    public function revenueReportExport(): void
    {
        $ownerId = (int)($_SESSION['user_id'] ?? 0);
        if (!$ownerId) { header('Location: index.php'); exit(); }

        $pdo      = Database::getInstance()->getConnection();
        $model    = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);
        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));
        $type     = trim((string)($_GET['type'] ?? 'revenue'));

        if ($type === 'booking') {
            $rows     = $model->getOwnerBookingExportData($ownerId, $dateFrom, $dateTo);
            $filename = 'bao_cao_dat_san_' . date('Ymd') . '.csv';
            $headers  = ['Mã đặt sân', 'Tên khách hàng', 'Số điện thoại', 'Sân', 'Ngày đặt', 'Trạng thái', 'Thanh toán', 'Số phút', 'Doanh thu (đ)', 'Ngày tạo'];
            $mapper   = fn($r) => [
                $r['id'], $r['customer_name'], $r['customer_phone'],
                $r['court_name'], $r['booking_date'], $r['status'],
                $r['payment_method'] === 'qr' ? 'QR' : 'Tiền mặt',
                $r['total_mins'], number_format($r['revenue'], 0, ',', '.'), $r['created_at'],
            ];
        } else {
            $rows     = $model->getOwnerRevenueExportData($ownerId, $dateFrom, $dateTo);
            $filename = 'bao_cao_doanh_thu_' . date('Ymd') . '.csv';
            $headers  = ['Mã đặt sân', 'Tên khách hàng', 'Số điện thoại', 'Sân', 'Ngày đặt', 'Thanh toán', 'Số phút', 'Doanh thu (đ)', 'Ngày tạo'];
            $mapper   = fn($r) => [
                $r['id'], $r['customer_name'], $r['customer_phone'],
                $r['court_name'], $r['booking_date'],
                $r['payment_method'] === 'qr' ? 'QR' : 'Tiền mặt',
                $r['total_mins'], number_format($r['revenue'], 0, ',', '.'), $r['created_at'],
            ];
        }

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, $headers);
        foreach ($rows as $r) { fputcsv($out, $mapper($r)); }
        fclose($out);
        exit();
    }

    // ─── BOOKING REPORT ───────────────────────────────────────────

    public function bookingReport(): void
    {
        $ownerId = (int)($_SESSION['user_id'] ?? 0);
        if (!$ownerId) { header('Location: index.php'); exit(); }

        $pdo   = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));

        $statsByStatus = $model->getOwnerBookingStatsByStatus($ownerId, $dateFrom, $dateTo);
        $byCourt       = $model->getOwnerBookingsByCourt($ownerId, $dateFrom, $dateTo);

        require_once PROJECT_ROOT . '/views/owner/reports/BookingReport.php';
    }

    // ─── CUSTOMER REPORT (OWNER) ────────────────────────────────

    public function customerReport(): void
    {
        $ownerId = (int)($_SESSION['user_id'] ?? 0);
        if (!$ownerId) { header('Location: index.php'); exit(); }

        $pdo   = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $year     = (int)($_GET['year'] ?? date('Y'));
        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));

        $totalCustomers = $model->getOwnerTotalCustomers($ownerId);
        $newThisMonth   = $model->getOwnerNewCustomersThisMonth($ownerId);
        $newByMonth     = $model->getOwnerNewCustomersByMonth($ownerId, $year);
        $topCustomers   = $model->getOwnerTopCustomersByBooking($ownerId, $dateFrom, $dateTo);
        $customerList   = $model->getOwnerCustomerList($ownerId, $dateFrom, $dateTo);

        require_once PROJECT_ROOT . '/views/owner/reports/CustomerReport.php';
    }

    public function customerReportExport(): void
    {
        $ownerId = (int)($_SESSION['user_id'] ?? 0);
        if (!$ownerId) { header('Location: index.php'); exit(); }

        $pdo   = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));

        $rows = $model->getOwnerCustomerList($ownerId, $dateFrom, $dateTo);

        $filename = 'bao_cao_khach_hang_' . date('Ymd') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['Tên', 'Email', 'Số điện thoại', 'Ngày đăng ký', 'Số lần đặt', 'Tổng chi tiêu']);

        foreach ($rows as $r) {
            fputcsv($out, [
                $r['name'],
                $r['email'],
                $r['phone'] ?? '',
                $r['created_at'],
                $r['booking_count'],
                number_format((float)$r['total_spent'], 0, ',', '.'),
            ]);
        }

        fclose($out);
        exit();
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

            // Luôn lấy total_amount đúng theo bảng bookings.
            // Nếu DB null/empty thì hiển thị 0 (không tự tính lại để tránh lệch với booking_services).
            $b['total_amount'] = (float)($b['total_amount'] ?? 0);

        }
        unset($b);

        return $base;
    }
}

