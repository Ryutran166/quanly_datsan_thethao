<?php
// public/index.php
session_start();
define('PROJECT_ROOT', dirname(__DIR__));
require_once __DIR__ . '/../vendor/autoload.php';

use Nhom2\QuanlyDatsanThethao\Controllers\CourtsController;
use Nhom2\QuanlyDatsanThethao\Controllers\UserController;
use Nhom2\QuanlyDatsanThethao\Controllers\AdminController;

$action = $_GET['action'] ?? 'home';    

$protected_actions = [
    'create',
    'add',
    'do_add_user',
    'edit',
    'update',
    'delete',
    'confirm_booking',
    'my_bookings',
    'cancel_booking',
    'user',
    'add_user',
    'edit_user',
    'update_user',
    'delete_user'
];

if (in_array($action, $protected_actions) && !isset($_SESSION['user_id'])) {
    header("Location:index.php?action=login");
    exit();
}
$admin_actions = [
    'admin_dashboard', 
    'user',
    'add_user',
    'edit_user',
    'update_user',
    'delete_user',
    'create',
    'add',
    'do_add_user',
    'edit',
    'update',
    'delete',
    'promotion',
    'create_promotion',
    'store_promotion'
];

if (in_array($action, $admin_actions)) {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header("Location:index.php");
        exit();
    }
} 

/* ===============================
   CHỌN CONTROLLER
================================= */
switch ($action) {

    // ===== USER =====
    case 'login':
    case 'register':
    case 'do_login':
    case 'do_register':
    case 'logout':
    case 'user':
    case 'add_user':
    case 'do_add_user':
    case 'edit_user':
    case 'update_user':
    case 'delete_user':
    case 'promotion':
    case 'create_promotion':
    case 'store_promotion':
    case 'check_voucher':
        $controller = new UserController();
        break;


    // ===== ADMIN =====
    case 'admin_dashboard':
        $controller = new UserController();
        break;

    // ===== COURTS =====
    default:
        $controller = new CourtsController();
        break;
}


switch ($action) {

    // ===== USER =====
    case 'login':
        $controller->showLoginForm();
        break;

    case 'register':
        $controller->showRegisterForm();
        break;

    case 'do_login':
        $controller->login();
        break;

    case 'logout':
        $controller->logout();
        break;

    case 'user':
        $controller->index();
        break;

    // ===== ADMIN =====
    case 'admin_dashboard':
        $controller->dashboard();
        break;

    case 'promotion':
        $controller->promotion();
        break;

    case 'create_promotion':
        $controller->createPromotion();
        break;

    case 'store_promotion':
        $controller->storePromotion();
        break;

    case 'check_voucher':
        $controller->checkVoucher();
        break;

    case 'redirect_home':
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            header("Location:index.php?action=admin_dashboard");
        } else {
            header("Location:index.php?action=home");
        }
        exit();

    // ===== COURTS =====
    case 'home':
        $controller->home();
        break;

    case 'index':
        $controller->index();
        break;

    case 'create':
        $controller->create();
        break;

    case 'add':
        $controller->add();
        break;

    case 'edit':
        $controller->edit();
        break;

    case 'update':
        $controller->update();
        break;

    case 'delete':
        $controller->delete();
        break;

    case 'booking':
        $controller->booking();
        break;

    case 'confirm_booking':
        $controller->confirm_booking();
        break;

    case 'booking_success':
        $controller->booking_success();
        break;

    case 'my_bookings':
        $controller->my_bookings();
        break;

    case 'cancel_booking':
        $controller->cancel_booking();
        break;

    default:
        $controller->home();
        break;
}