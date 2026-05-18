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

    // ─── REVENUE REPORT ───────────────────────────────────────────

    public function revenueReport(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $year      = (int)($_GET['year'] ?? date('Y'));
        $dateFrom  = trim((string)($_GET['date_from'] ?? ''));
        $dateTo    = trim((string)($_GET['date_to'] ?? ''));
        $viewMode  = trim((string)($_GET['view'] ?? 'month')); // month | day

        $totalRevenue      = $model->getTotalRevenue($dateFrom, $dateTo);
        $revenueByMonth    = $model->getRevenueByMonth($year);
        $revenueByCourt    = $model->getRevenueByCourt($dateFrom, $dateTo);
        $revenueByMethod   = $model->getRevenueByPaymentMethod($dateFrom, $dateTo);

        $revenueByDay = [];
        if ($viewMode === 'day' && $dateFrom !== '' && $dateTo !== '') {
            $revenueByDay = $model->getRevenueByDay($dateFrom, $dateTo);
        }

        require_once PROJECT_ROOT . '/views/admin/reports/RevenueReport.php';
    }

    public function revenueReportExport(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));
        $type     = trim((string)($_GET['type'] ?? 'revenue')); // revenue | booking

        if ($type === 'booking') {
            $rows = $model->getBookingExportData($dateFrom, $dateTo);
            $filename = 'bao_cao_dat_san_' . date('Ymd') . '.csv';
            $headers = ['Mã đặt sân', 'Tên khách hàng', 'Số điện thoại', 'Sân', 'Ngày đặt', 'Trạng thái', 'Thanh toán', 'Số phút', 'Doanh thu (đ)', 'Ngày tạo'];
            $mapper = fn($r) => [
                $r['id'], $r['customer_name'], $r['customer_phone'],
                $r['court_name'], $r['booking_date'], $r['status'],
                $r['payment_method'] === 'qr' ? 'QR' : 'Tiền mặt',
                $r['total_mins'],
                number_format($r['revenue'], 0, ',', '.'),
                $r['created_at'],
            ];
        } else {
            $rows = $model->getRevenueExportData($dateFrom, $dateTo);
            $filename = 'bao_cao_doanh_thu_' . date('Ymd') . '.csv';
            $headers = ['Mã đặt sân', 'Tên khách hàng', 'Số điện thoại', 'Sân', 'Ngày đặt', 'Thanh toán', 'Số phút', 'Doanh thu (đ)', 'Ngày tạo'];
            $mapper = fn($r) => [
                $r['id'], $r['customer_name'], $r['customer_phone'],
                $r['court_name'], $r['booking_date'],
                $r['payment_method'] === 'qr' ? 'QR' : 'Tiền mặt',
                $r['total_mins'],
                number_format($r['revenue'], 0, ',', '.'),
                $r['created_at'],
            ];
        }

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $out = fopen('php://output', 'w');
        // UTF-8 BOM for Excel
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, $headers);
        foreach ($rows as $r) {
            fputcsv($out, $mapper($r));
        }
        fclose($out);
        exit();
    }

    // ─── BOOKING REPORT ───────────────────────────────────────────

    public function bookingReport(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));

        $statsByStatus  = $model->getBookingStatsByStatus($dateFrom, $dateTo);
        $byCourt        = $model->getBookingsByCourt($dateFrom, $dateTo);
        $byDay          = ($dateFrom !== '' && $dateTo !== '')
                          ? $model->getBookingsByDay($dateFrom, $dateTo)
                          : [];

        require_once PROJECT_ROOT . '/views/admin/reports/BookingReport.php';
    }

    // ─── CUSTOMER REPORT ──────────────────────────────────────────

    public function customerReport(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $year    = (int)($_GET['year'] ?? date('Y'));
        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));

        $totalCustomers        = $model->getTotalCustomers();
        $newThisMonth          = $model->getNewCustomersThisMonth();
        $newByMonth            = $model->getNewCustomersByMonth($year);
        $topCustomers          = $model->getTopCustomersByBooking($dateFrom, $dateTo);
        $customerList          = $model->getCustomerList($dateFrom, $dateTo);

        require_once PROJECT_ROOT . '/views/admin/reports/CustomerReport.php';
    }

    public function customerReportExport(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $model = new \Nhom2\QuanlyDatsanThethao\Models\ReportModel($pdo);

        $dateFrom = trim((string)($_GET['date_from'] ?? ''));
        $dateTo   = trim((string)($_GET['date_to'] ?? ''));
        $rows     = $model->getCustomerList($dateFrom, $dateTo);

        $filename = 'bao_cao_khach_hang_' . date('Ymd') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['Tên', 'Email', 'Số điện thoại', 'Ngày đăng ký', 'Số lần đặt', 'Tổng chi tiêu']);
        foreach ($rows as $r) {
            fputcsv($out, [
                $r['name'], $r['email'], $r['phone'] ?? '', $r['created_at'],
                $r['booking_count'], number_format($r['total_spent'], 0, ',', '.'),
            ]);
        }
        fclose($out);
        exit();
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

