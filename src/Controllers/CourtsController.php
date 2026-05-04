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
                'owner_id' => $ownerId
            ]);
        }

        header("Location:index.php?action=courts");
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
                    'image'  => $image
                ]);
            }
        }

        header("Location:index.php?action=courts");
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

        // Danh sách khung giờ cố định
        $timeSlots = [
            ['id' => 1,  'start_time' => '06:00:00', 'end_time' => '07:00:00'],
            ['id' => 2,  'start_time' => '07:00:00', 'end_time' => '08:00:00'],
            ['id' => 3,  'start_time' => '08:00:00', 'end_time' => '09:00:00'],
            ['id' => 4,  'start_time' => '09:00:00', 'end_time' => '10:00:00'],
            ['id' => 5,  'start_time' => '10:00:00', 'end_time' => '11:00:00'],
            ['id' => 6,  'start_time' => '14:00:00', 'end_time' => '15:00:00'],
            ['id' => 7,  'start_time' => '15:00:00', 'end_time' => '16:00:00'],
            ['id' => 8,  'start_time' => '16:00:00', 'end_time' => '17:00:00'],
            ['id' => 9,  'start_time' => '17:00:00', 'end_time' => '18:00:00'],
            ['id' => 10, 'start_time' => '18:00:00', 'end_time' => '19:00:00'],
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
            'status'         => 'Confirmed',
            'user_id'        => $userId,
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
}
