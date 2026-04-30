<?php
namespace Nhom2\QuanlyDatsanThethao\Controllers\Admin;

use Nhom2\QuanlyDatsanThethao\Models\UserModel; // Import Model vào đây

class AuthController {
    
    public function showLoginForm() {
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            header("Location: /admin");
            exit;
        }
        require_once PROJECT_ROOT . '/views/admin/auth/login.php';
    }

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->findUserByEmail($email);

            // Kiểm tra: Có user không? Password khớp không? Và có phải Admin không?
            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] === 'admin') {
                    // Đăng nhập thành công
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = $user['role']; 
                    $_SESSION['admin_email'] = $user['email'];
                    
                    header("Location: /admin/dashboard");
                    exit;
                } else {
                    $error = "Bạn không có quyền truy cập khu vực quản trị!";
                }
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không chính xác!";
            }
            
            // Nếu có lỗi, load lại view kèm thông báo
            require_once PROJECT_ROOT . '/views/admin/auth/login.php';
        }
    }
    
    public function logout() {
        // Xóa toàn bộ session liên quan để an toàn
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        unset($_SESSION['admin_email']);
        session_destroy(); 
        
        header("Location: /login-admin");
        exit;
    }
}