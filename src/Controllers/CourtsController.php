<?php
// src/Controllers/CourtsController.php

namespace Nhom2\QuanlyDatsanThethao\Controllers;

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
        $recordsPerPage = 6;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $offset = ($currentPage - 1) * $recordsPerPage;

        $keyword = $_GET['keyword'] ?? null;

        $result = $this->courtsModel->getCourts(
            $keyword,
            $recordsPerPage,
            $offset
        );

        $courts = $result['data'];
        $totalRecords = $result['total'];

        $totalPages = ceil($totalRecords / $recordsPerPage);

        require_once PROJECT_ROOT . '/views/Courts/CourtsList.php';
    }
    /* =============================
       FORM THÊM
    ============================== */
    public function create()
    {
        if (
            !isset($_SESSION['user_role']) ||
            !in_array($_SESSION['user_role'], ['admin', 'owner'])
        ) {
            die("Bạn không có quyền thêm sân.");
        }

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Courts/CourtsCreate.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    /* =============================
       INSERT
    ============================== */
    public function add()
    {
        if (
            !isset($_SESSION['user_role']) ||
            !in_array($_SESSION['user_role'], ['admin', 'owner'])
        ) {
            die("Không có quyền.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $ownerId = $_SESSION['user_id'];
            $image = null;

            // ✅ Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

                $uploadDir = '/public/upload/img_courts/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $fileName;

                // Di chuyển file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = $fileName;
                }
            }

            // ✅ Lưu vào DB
            $this->courtsModel->addCourts([
                'name'     => $_POST['name'],
                'price'    => $_POST['price'],
                'status'   => 'available',
                'image'    => $image,
                'address'  => $_POST['address'],
                'owner_id' => $ownerId
            ]);
        }

        header("Location:index.php?action=index");
        exit();
    }

    /* =============================
       FORM EDIT
    ============================== */
    public function edit()
    {
        $id = $_GET['id'];
        $court = $this->courtsModel->getCourtById($id);

        if (!$court) {
            die("Sân không tồn tại.");
        }

        if (
            $_SESSION['user_role'] == 'owner' &&
            $court['owner_id'] != $_SESSION['user_id']
        ) {
            die("Bạn không được sửa sân người khác.");
        }

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

            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $address =  $_POST['address'];
            $status = $_POST['status'] ?? 'available';

            $oldImage = $_POST['old_image'] ?? null;
            $image = $oldImage; // mặc định giữ ảnh cũ

            // ✅ Upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

                $targetDir = "/public/upload/img_courts/";

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $filename = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

                    $image = $filename;

                    // ✅ Xóa ảnh cũ
                    if ($oldImage && file_exists($targetDir . $oldImage)) {
                        unlink($targetDir . $oldImage);
                    }
                } else {
                    die("Upload ảnh thất bại");
                }
            }

            if ($id && !empty($name) && !empty($price)) {

                $this->courtsModel->updateCourt($id, [
                    'name'   => $name,
                    'price'  => $price,
                    'status' => $status,
                    'image'  => $image,
                    'address' => $address
                ]);
            }
        }

        header("Location:index.php?action=index");
        exit();
    }
    /* =============================
       DELETE
    ============================== */
    public function delete()
    {
        $id = $_GET['id'];
        $court = $this->courtsModel->getCourtById($id);

        if (
            $_SESSION['user_role'] == 'owner' &&
            $court['owner_id'] != $_SESSION['user_id']
        ) {
            die("Không được xoá sân người khác.");
        }

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

        // Danh sách khung giờ cố định\
        $timeSlots = [
            ['id' => 1,  'start_time' => '06:00:00', 'end_time' => '07:00:00'],
            ['id' => 2,  'start_time' => '06:30:00', 'end_time' => '07:30:00'],
            ['id' => 3,  'start_time' => '07:00:00', 'end_time' => '08:00:00'],
            ['id' => 4,  'start_time' => '07:30:00', 'end_time' => '08:30:00'],
            ['id' => 5,  'start_time' => '08:00:00', 'end_time' => '09:00:00'],
            ['id' => 6,  'start_time' => '08:30:00', 'end_time' => '09:30:00'],
            ['id' => 7,  'start_time' => '09:00:00', 'end_time' => '10:00:00'],
            ['id' => 8,  'start_time' => '09:30:00', 'end_time' => '10:30:00'],
            ['id' => 9,  'start_time' => '10:00:00', 'end_time' => '11:00:00'],
            ['id' => 10, 'start_time' => '10:30:00', 'end_time' => '11:30:00'],
            ['id' => 11, 'start_time' => '11:00:00', 'end_time' => '12:00:00'],
            ['id' => 12, 'start_time' => '11:30:00', 'end_time' => '12:30:00'],
            ['id' => 13, 'start_time' => '12:00:00', 'end_time' => '13:00:00'],
            ['id' => 14, 'start_time' => '12:30:00', 'end_time' => '13:30:00'],
            ['id' => 15, 'start_time' => '13:00:00', 'end_time' => '14:00:00'],
            ['id' => 16, 'start_time' => '13:30:00', 'end_time' => '14:30:00'],
            ['id' => 17, 'start_time' => '14:00:00', 'end_time' => '15:00:00'],
            ['id' => 18, 'start_time' => '14:30:00', 'end_time' => '15:30:00'],
            ['id' => 19, 'start_time' => '15:00:00', 'end_time' => '16:00:00'],
            ['id' => 20, 'start_time' => '15:30:00', 'end_time' => '16:30:00'],
            ['id' => 21, 'start_time' => '16:00:00', 'end_time' => '17:00:00'],
            ['id' => 22, 'start_time' => '16:30:00', 'end_time' => '17:30:00'],
            ['id' => 23, 'start_time' => '17:00:00', 'end_time' => '18:00:00'],
            ['id' => 24, 'start_time' => '17:30:00', 'end_time' => '18:30:00'],
            ['id' => 25, 'start_time' => '18:00:00', 'end_time' => '19:00:00'],
            ['id' => 26, 'start_time' => '18:30:00', 'end_time' => '19:30:00'],
            ['id' => 27, 'start_time' => '19:00:00', 'end_time' => '20:00:00'],
            ['id' => 28, 'start_time' => '19:30:00', 'end_time' => '20:30:00'],
            ['id' => 29, 'start_time' => '20:00:00', 'end_time' => '21:00:00'],
            ['id' => 30, 'start_time' => '20:30:00', 'end_time' => '21:30:00'],
            ['id' => 31, 'start_time' => '21:00:00', 'end_time' => '22:00:00'],
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

        if (!$courtId || !$slotId || !$date) {
            header("Location: index.php?error=missing_data");
            exit();
        }

        // check trùng slot
        $alreadyBooked = $this->bookingModel->getBookedSlots($courtId, $date);
        if (in_array($slotId, $alreadyBooked)) {
            header("Location: index.php?action=booking&id=$courtId&date=$date&error=slot_taken");
            exit();
        }

        // =========================
        // LOGIN 
        // =========================

        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            $user = $this->userModel->getUserById($userId);
            $customerName  = $user['name'];
            $customerPhone = $user['phone'];
        } else {
            $customerName  = $_POST['customer_name'] ?? '';
            $customerPhone = $_POST['customer_phone'] ?? '';
        }

        // =========================
        // LƯU DB
        // =========================

        $this->bookingModel->createBooking([
            'court_id'       => $courtId,
            'slot_id'        => $slotId,
            'booking_date'   => $date,
            'customer_name'  => $customerName,
            'customer_phone' => $customerPhone,
            'status'         => 'Confirmed',
            'user_id'        => $userId, // null nếu guest
        ]);

        header("Location: index.php?action=booking_success&court_id=$courtId&date=$date&slot_id=$slotId");
        exit();
    }

    public function guest_form()
    {
        $courtId = $_GET['court_id'] ?? 0;
        $slotId  = $_GET['slot_id'] ?? 0;
        $date    = $_GET['date'] ?? '';

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/Bookings/GuestForm.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    public function check_booking()
    {
        $courtId = $_POST['court_id'] ?? 0;
        $slotId  = $_POST['slot_id'] ?? 0;
        $date    = $_POST['booking_date'] ?? '';

        if (!$courtId || !$slotId || !$date) {
            header("Location: index.php?error=missing_data");
            exit();
        }

        //  Nếu đã login → submit thẳng bằng POST
        if (isset($_SESSION['user_id'])) {

            $_POST['court_id']     = $courtId;
            $_POST['slot_id']      = $slotId;
            $_POST['booking_date'] = $date;

            $this->confirm_booking(); // gọi trực tiếp
            return;
        }

        //  chưa login → sang form nhập
        header("Location: index.php?action=guest_form"
            . "&court_id=$courtId&slot_id=$slotId&date=$date");
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
        $upcoming  = array_filter(
            $bookings,
            fn($b) =>
            strtolower($b['booking_status']) === 'confirmed' && strtotime($b['booking_date']) >= strtotime('today')
        );
        $past      = array_filter(
            $bookings,
            fn($b) =>
            strtotime($b['booking_date']) < strtotime('today')
        );
        $cancelled = array_filter(
            $bookings,
            fn($b) =>
            strtolower($b['booking_status']) === 'cancelled'
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

    // HÀM HELPER ĐỂ XỬ LÝ UPLOAD
    private function handleUpload($file)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Lỗi upload file.'];
        }
        $targetDir = PROJECT_ROOT . "/public/upload/img_courts/";

        $fileName = uniqid() . '-' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo(
            $targetFile,

            PATHINFO_EXTENSION
        ));

        // Kiểm tra định dạng file
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            return ['error' => 'Chỉ cho phép upload file ảnh (JPG, JPEG, PNG, GIF).'];
        }
        // Di chuyển file
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return ['filename' => $fileName];
        } else {
            return ['error' => 'Đã có lỗi xảy ra khi upload file.'];
        }
    }

    public function courtDetail()
    {
        if (!isset($_GET['id'])) {
            echo json_encode([
                'success' => false
            ]);
            exit;
        }

        $id = (int) $_GET['id'];

        $courtModel = new CourtsModel();

        $court = $courtModel->getCourtById($id);

        if (!$court) {
            echo json_encode([
                'success' => false
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'court' => $court
        ]);
    }
}
