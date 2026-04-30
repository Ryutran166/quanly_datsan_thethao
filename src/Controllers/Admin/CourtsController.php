<?php
// src/Controllers/Admin/CourtsController.php

namespace Nhom2\QuanlyDatsanThethao\Controllers\Admin;

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


    /* =============================
       DANH SÁCH SÂN
    ============================== */
   public function index()
    {
        $keyword = $_GET['keyword'] ?? null;

        // Tạm thời comment dòng gọi Model này lại để dùng data mẫu
        // $courts = $this->courtsModel->getAllCourts($keyword);

        // Dữ liệu mẫu (Mock Data)
        $courts = [
            [
                'id' => 1,
                'name' => 'Sân Cầu Lông Sky Light',
                'type' => 'Thảm Victor',
                'price' => 80000,
                'status' => 'available',
                'image' => 'court1.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Sân Tennis Riverside',
                'type' => 'Sân cứng',
                'price' => 150000,
                'status' => 'available',
                'image' => 'court2.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Sân Bóng Đá Mini A1',
                'type' => 'Cỏ nhân tạo',
                'price' => 250000,
                'status' => 'maintenance',
                'image' => 'court3.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Sân Cầu Lông Thành Công',
                'type' => 'Thảm Yonex',
                'price' => 90000,
                'status' => 'available',
                'image' => null // Test trường hợp không có ảnh
            ]
        ];

        // Giả lập tính năng tìm kiếm theo từ khóa nếu muốn test search
        if ($keyword) {
            $courts = array_filter($courts, function($court) use ($keyword) {
                return strpos(strtolower($court['name']), strtolower($keyword)) !== false;
            });
        }

        require_once PROJECT_ROOT . '/views/admin/courts/CourtsList.php';
    }

    /* =============================
       FORM THÊM
    ============================== */
    public function create()
    {
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Courts/CourtsCreate.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    /* =============================
       INSERT
    ============================== */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->courtsModel->addCourts([
                'name'      => $_POST['name'],
                'price'     => $_POST['price'],
                'status'    => 'available',
                'image_url' => $_POST['image_url']
            ]);
        }

        header("Location:index.php");
        exit();
    }

    /* =============================
       FORM EDIT
    ============================== */
    public function edit()
    {
        $id = $_GET['id'];

        $court = $this->courtsModel->getCourtById($id);

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Courts/CourtsEdit.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    /* =============================
       UPDATE
    ============================== */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'status' => $_POST['status'],
                'image_url' => $_POST['image_url']
            ];

            $this->courtsModel->updateCourt($id, $data);
        }

        header("Location:index.php");
        exit();
    }

    /* =============================
       DELETE
    ============================== */
    public function delete()
    {
        $id = $_GET['id'];

        $this->courtsModel->deleteCourt($id);

        header("Location:index.php");
        exit();
    }

    /* =============================
       BOOKING PAGE
    ============================== */
    public function booking()
    {
        $id   = (int) ($_GET['id']   ?? 0);
        $date = $_GET['date'] ?? date('Y-m-d');

        // Validate ngày hợp lệ
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $date = date('Y-m-d');
        }

        if (!$id) {
            header("Location: index.php?error=invalid_court_id");
            exit();
        }

        $court = $this->courtsModel->getCourtById($id);
        if (!$court) {
            header("Location: index.php?error=court_not_found");
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
        require_once PROJECT_ROOT . '/views/Courts/CourtsBooking.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }


    public function confirm_booking()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php");
            exit();
        }

        $courtId  = (int) ($_POST['court_id']  ?? 0);
        $slotId   = (int) ($_POST['slot_id']   ?? 0);
        $date     = $_POST['booking_date'] ?? '';

        // Validate đầu vào
        if (!$courtId || !$slotId || !$date) {
            header("Location: index.php?error=missing_data");
            exit();
        }

        // Kiểm tra slot chưa bị đặt (tránh double-booking)
        $alreadyBooked = $this->bookingModel->getBookedSlots($courtId, $date);
        if (in_array($slotId, $alreadyBooked)) {
            header("Location: index.php?action=booking&id=$courtId&date=$date&error=slot_taken");
            exit();
        }

        // Lưu booking vào DB
        $userId = $_SESSION['user_id'] ?? null; // cần login
        $user = $this->userModel->getUserById($userId);
        $this->bookingModel->createBooking([
            'court_id'       => $courtId,
            'slot_id'        => $slotId,
            'booking_date'   => $date,
            'customer_name'  => $user['name'] ?? 'Khách hàng',
            'customer_phone' => $user['phone'] ?? null,
            'status'         => 'confirmed',
        ]);

         header("Location: index.php?action=booking_success&court_id=$courtId&date=$date&slot_id=$slotId");
    exit();
    }

    public function booking_success()
{
    $courtId = (int) ($_GET['court_id'] ?? 0);
    $slotId  = (int) ($_GET['slot_id']  ?? 0);
    $date    =        $_GET['date']      ?? '';

    $court = $this->courtsModel->getCourtById($courtId);
    $slot  = $this->bookingModel->getSlotById($slotId);

    if (!$court) {
        header("Location: index.php");
        exit();
    }

    require_once PROJECT_ROOT . '/views/layout/header.php';
    require_once PROJECT_ROOT . '/views/Courts/BookingSuccess.php';
    require_once PROJECT_ROOT . '/views/layout/footer.php';
}

public function my_bookings()
{
    $userId   = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        header("Location: index.php?action=login");
        exit();
    }

    $bookings = $this->bookingModel->getBookingsByUser($userId);

    // Nhóm theo trạng thái
    $upcoming  = array_filter($bookings, fn($b) => 
        $b['booking_status'] === 'confirmed' && strtotime($b['booking_date']) >= strtotime('today')
    );
    $past      = array_filter($bookings, fn($b) => 
        strtotime($b['booking_date']) < strtotime('today')
    );
    $cancelled = array_filter($bookings, fn($b) => 
        $b['booking_status'] === 'cancelled'
    );

    require_once PROJECT_ROOT . '/views/layout/header.php';
    require_once PROJECT_ROOT . '/views/Bookings/MyBookings.php';
    require_once PROJECT_ROOT . '/views/layout/footer.php';
}

public function cancel_booking()
{
    $bookingId = (int) ($_GET['id']  ?? 0);
    $userId    = $_SESSION['user_id'] ?? null;

    if (!$bookingId || !$userId) {
        header("Location: index.php?action=my_bookings");
        exit();
    }

    $success = $this->bookingModel->cancelBooking($bookingId, $userId);

    if ($success) {
        header("Location: index.php?action=my_bookings&success=cancelled");
    } else {
        header("Location: index.php?action=my_bookings&error=cannot_cancel");
    }
    exit();
}
}