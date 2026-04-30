<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers\Admin;

use Nhom2\QuanlyDatsanThethao\Models\UserModel;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        // Sử dụng hằng số PROJECT_ROOT đã định nghĩa ở index.php
        require_once PROJECT_ROOT . '/views/User/login.php';
    }

    /**
     * Xử lý logic đăng nhập
     */
    // Trong hàm login()
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy 'email' thay vì 'username'
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ email và mật khẩu.";
                require_once PROJECT_ROOT . '/views/User/login.php';
                return;
            }

            // Gọi đúng hàm tìm theo Email trong Model
            $user = $this->userModel->findUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                header('Location: index.php?action=home');
                exit();
            } else {
                $error = "Email hoặc mật khẩu không chính xác.";
                require_once PROJECT_ROOT . '/views/User/login.php';
            }
        }
    }

    /**
     * Hiển thị form đăng ký
     */
    public function showRegisterForm()
    {
        require_once PROJECT_ROOT . '/views/User/register.php';
    }

    /**
     * Xử lý logic đăng ký
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Lấy dữ liệu từ FORM
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? ''; // Quan trọng: Phải lấy biến này
            $phone = $_POST['phone'] ?? '';

            // 2. Kiểm tra trống các trường bắt buộc
            if (empty($name) || empty($email) || empty($password)) {
                $error = "Vui lòng điền đầy đủ các trường bắt buộc.";
                require_once PROJECT_ROOT . '/views/User/register.php';
                return;
            }

            // 3. Kiểm tra mật khẩu khớp nhau
            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp.";
                require_once PROJECT_ROOT . '/views/User/register.php';
                return;
            }

            // 4. Gọi Model để tạo user (truyền đủ 4 tham số)
            $result = $this->userModel->createUser($name, $email, $password, $phone);

            if ($result) {
                // Đăng ký thành công -> Chuyển sang trang đăng nhập
                header('Location: index.php?action=login&status=registered');
                exit();
            } else {
                $error = "Email này đã được đăng ký. Vui lòng chọn email khác.";
                require_once PROJECT_ROOT . '/views/User/register.php';
            }
        } else {
            // Nếu không phải POST (truy cập trực tiếp), hiển thị form trắng
            $this->showRegisterForm();
        }
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        session_unset();
        session_destroy();

        // Xóa cookie session nếu có
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        header('Location: index.php?action=home');
        exit();
    }

    public function index()
    {
        // 1. Lấy dữ liệu từ Model
        $users = $this->userModel->getAllUsers();

        // 2. Truyền dữ liệu vào view
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/User/UserList.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    // src/Controllers/UserController.php

    /**
     * Hiển thị form thêm user mới (Dùng chung giao diện với Register nhưng tiêu đề khác)
     */
    public function add()
    {
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/User/add.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    /**
     * Xử lý lưu User mới từ trang quản trị
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';

            // Kiểm tra trống
            if (empty($name) || empty($email) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin.";
                require_once PROJECT_ROOT . '/views/layout/header.php';
                require_once PROJECT_ROOT . '/views/User/add.php';
                require_once PROJECT_ROOT . '/views/layout/footer.php';
                return;
            }

            $result = $this->userModel->createUser($name, $email, $password, $phone);

            if ($result) {
                // Thêm thành công -> Quay về trang danh sách user
                header('Location: index.php?action=user&status=added');
                exit();
            } else {
                $error = "Email đã tồn tại trong hệ thống.";
                require_once PROJECT_ROOT . '/views/layout/header.php';
                require_once PROJECT_ROOT . '/views/User/add.php';
                require_once PROJECT_ROOT . '/views/layout/footer.php';
            }
        }
    }

    /**
     * Hiển thị form chỉnh sửa người dùng
     */
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=user');
            exit();
        }

        // Lấy thông tin từ model
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            header('Location: index.php?action=user');
            exit();
        }

        // SỬA LỖI ĐƯỜNG DẪN Ở ĐÂY: Sử dụng PROJECT_ROOT và đúng tên file edit.php
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/User/UserEdit.php'; 
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    /**
     * Xử lý cập nhật dữ liệu người dùng
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            
            // Lấy mật khẩu nếu admin muốn đổi mật khẩu cho user
            $password = $_POST['password'] ?? ''; 

            if ($id && !empty($name) && !empty($email)) {
                // Gọi model để cập nhật
                $this->userModel->updateUser($id, $name, $email, $phone, $password);
                header('Location: index.php?action=user&status=updated');
                exit();
            }
        }
        header('Location: index.php?action=user');
        exit();
    }
}
