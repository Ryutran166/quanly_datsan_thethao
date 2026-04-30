<?php
// public/index.php
session_start();
define('PROJECT_ROOT', dirname(__DIR__));
require_once __DIR__ . '/../vendor/autoload.php';

use Nhom2\QuanlyDatsanThethao\Controllers\Admin\AdminController;
use Nhom2\QuanlyDatsanThethao\Controllers\Admin\CourtsController as AdminCourtsController;
use Nhom2\QuanlyDatsanThethao\Controllers\Admin\UserController as AdminUserController;
use Nhom2\QuanlyDatsanThethao\Controllers\Admin\AuthController as AdminAuthController;
use Nhom2\QuanlyDatsanThethao\Controllers\Client\CourtsController as ClientCourtsController;
use Nhom2\QuanlyDatsanThethao\Controllers\Client\AuthController as ClientAuthController; 

// Lấy đường dẫn hiện tại
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = rtrim($request_uri, '/'); // loại bỏ dấu / thừa ở cuối

// ======================
// PHÂN BIỆT ADMIN hay CLIENT
// ======================
$is_admin_route = str_starts_with($request_uri, '/admin');

// ======================
// PROTECTION (Bảo vệ route)
// ======================
$public_admin_routes = ['/login-admin', '/do-login-admin'];
if ($is_admin_route) {
    // Nếu là route admin nhưng chưa đăng nhập và không phải trang login
    if (!in_array($request_uri, $public_admin_routes)) {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: /login-admin");
            exit();
        }
    }
} else {
    // Bảo vệ route khách hàng (login required)
    $protected_client_actions = ['/my_bookings', '/cancel_booking', '/confirm_booking'];
    if (in_array($request_uri, $protected_client_actions) && !isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit();
    }
}

// ======================
// CHỌN CONTROLLER
// ======================
$controller = null;

if ($is_admin_route || $request_uri === '/login-admin' || $request_uri === '/do-login-admin') {
    if (strpos($request_uri, '/admin/user') === 0) {
        $controller = new AdminUserController();
    } else if (strpos($request_uri, '/admin/court') === 0) {
        $controller = new AdminCourtsController();
    } else if ($request_uri === '/login-admin' || $request_uri === '/do-login-admin') {
        $controller = new AdminAuthController(); // <--- Dùng Controller Admin
    } else {
        $controller = new AdminController();
    }
} else {
    if (in_array($request_uri, ['/login', '/register', '/do_login', '/do_register', '/logout'])) {
        $controller = new ClientAuthController(); // <--- Dùng Controller Client
    } else {
        $controller = new ClientCourtsController();
    }
}

// ======================
// DISPATCH - XỬ LÝ ACTION
// ======================
switch ($request_uri) {

    // ==================== CLIENT ROUTES ====================
    case '/':
    case '/home':
        $controller->home();
        break;

    case '/login':
        $controller->showLoginForm();
        break;

    case '/register':
        $controller->showRegisterForm();
        break;

    case '/do_login':
        $controller->login();
        break;

    case '/do_register':
        $controller->register();
        break;

   case '/logout':
        // Nếu là admin đang log, ưu tiên dùng logout của admin
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            $adminAuth = new AdminAuthController();
            $adminAuth->logout();
        } else {
            $controller->logout(); // Client logout
        }
    break;

    case '/booking':
        $controller->booking();
        break;

    case '/confirm_booking':
        $controller->confirm_booking();
        break;

    case '/my_bookings':
        $controller->my_bookings();
        break;

    case '/cancel_booking':
        $controller->cancel_booking();
        break;

    // ==================== ADMIN AUTH ROUTES ====================
    case '/login-admin':
        $controller->showLoginForm(); // Đảm bảo hàm này load đúng views/admin/login.php
        break;

    case '/do-login-admin':
        $controller->login(); // Hàm xử lý logic đăng nhập admin
        break;

    // ==================== ADMIN ROUTES ====================
    case '/admin':
    case '/admin/dashboard':
        $controller->dashboard();
        break;

    case '/admin/courts':
    case '/admin/courts/list':
        $controller->index();
        break;

    case '/admin/courts/create':
        $controller->create();
        break;

    case '/admin/courts/add':
        $controller->add();
        break;

    case '/admin/courts/edit':
        $controller->edit();
        break;

    case '/admin/courts/update':
        $controller->update();
        break;

    case '/admin/courts/delete':
        $controller->delete();
        break;

    case '/admin/users':
    case '/admin/users/list':
        $controller->index();
        break;

    case '/admin/users/add':
        $controller->add();
        break;

    case '/admin/users/edit':
        $controller->edit();
        break;

    case '/admin/users/update':
        $controller->update();
        break;

    case '/admin/users/delete':
        $controller->delete();
        break;

    default:
        if ($is_admin_route) {
            $controller->dashboard();   // fallback cho admin
        } else {
            $controller->home();        // fallback cho client
        }
        break;
}