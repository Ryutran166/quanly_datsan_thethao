<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers\Client;

use Nhom2\QuanlyDatsanThethao\Models\CourtsModel;
use Nhom2\QuanlyDatsanThethao\Models\BookingModel;
use Nhom2\QuanlyDatsanThethao\Models\UserModel;
use Nhom2\QuanlyDatsanThethao\Database;

class CourtsController
{
    private $courtsModel;
    private $bookingModel;
    private $userModel;

    public function __construct()
    {
        $pdo = Database::getInstance()->getConnection();
        $this->courtsModel = new CourtsModel();
        $this->bookingModel = new BookingModel($pdo);
        $this->userModel = new UserModel();
    }

    public function home()
    {
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Home/Home.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    public function index()
    {
        $keyword = $_GET['keyword'] ?? null;
        $courts = $this->courtsModel->getAllCourts($keyword);

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/client/courts/list.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    public function booking()
    {
        $id   = (int) ($_GET['id']   ?? 0);
        $date = $_GET['date'] ?? date('Y-m-d');

        // Validate ngày hợp lệ
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $date = date('Y-m-d');
        }

        if (!$id) {
            header("Location: /?error=invalid_court_id");
            exit();
        }

        $court = $this->courtsModel->getCourtById($id);
        if (!$court) {
            header("Location: /?error=court_not_found");
            exit();
        }

        // Danh sách khung giờ cố định
        $timeSlots = [
            ['id'=>1,  'start_time'=>'06:00:00', 'end_time'=>'07:00:00'],
            ['id'=>2,  'start_time'=>'07:00:00', 'end_time'=>'08:00:00'],
            ['id'=>3,  'start_time'=>'08:00:00', 'end_time'=>'09:00:00'],
            ['id'=>4,  'start_time'=>'09:00:00', 'end_time'=>'10:00:00'],
            ['id'=>5,  'start_time'=>'10:00:00', 'end_time'=>'11:00:00'],
            ['id'=>6,  'start_time'=>'14:00:00', 'end_time'=>'15:00:00'],
            ['id'=>7,  'start_time'=>'15:00:00', 'end_time'=>'16:00:00'],
            ['id'=>8,  'start_time'=>'16:00:00', 'end_time'=>'17:00:00'],
            ['id'=>9,  'start_time'=>'17:00:00', 'end_time'=>'18:00:00'],
            ['id'=>10, 'start_time'=>'18:00:00', 'end_time'=>'19:00:00'],
        ];

        $bookedSlots = $this->bookingModel->getBookedSlots($id, $date);

        extract([
            'court'       => $court,
            'date'        => $date,
            'timeSlots'   => $timeSlots,
            'bookedSlots' => $bookedSlots,
        ]);

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/client/courts/booking.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    public function confirm_booking()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /");
            exit();
        }

        $courtId  = (int) ($_POST['court_id']  ?? 0);
        $slotId   = (int) ($_POST['slot_id']   ?? 0);
        $date     = $_POST['booking_date'] ?? '';

        // Validate đầu vào
        if (!$courtId || !$slotId || !$date) {
            header("Location: /?error=missing_data");
            exit();
        }

        // Check nếu chưa login
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        // Kiểm tra slot chưa bị đặt (tránh double-booking)
        $alreadyBooked = $this->bookingModel->getBookedSlots($courtId, $date);
        if (in_array($slotId, $alreadyBooked)) {
            header("Location: /booking?id=$courtId&date=$date&error=slot_taken");
            exit();
        }

        // Lưu booking vào DB
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        $this->bookingModel->createBooking([
            'court_id'       => $courtId,
            'slot_id'        => $slotId,
            'booking_date'   => $date,
            'customer_name'  => $user['name'] ?? 'Khách hàng',
            'customer_phone' => $user['phone'] ?? null,
            'status'         => 'confirmed',
        ]);

        header("Location: /my_bookings?success=1");
        exit();
    }

    public function my_bookings()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        // TODO: Thêm method getBookingsByUserId vào BookingModel nếu cần
        // Tạm thời chỉ hiển thị trang
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Courts/MyBookings.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    public function cancel_booking()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $bookingId = (int) ($_GET['id'] ?? 0);
        if (!$bookingId) {
            header("Location: /my_bookings?error=invalid_booking");
            exit();
        }

        // TODO: Thêm method cancelBooking vào BookingModel
        // $this->bookingModel->cancelBooking($bookingId);

        header("Location: /my_bookings?success=cancelled");
        exit();
    }
}
