<?php
// public/index.php
session_start();
define('PROJECT_ROOT', dirname(__DIR__));
require_once __DIR__ . '/../vendor/autoload.php';

use Nhom2\QuanlyDatsanThethao\Controllers\CourtsController;
use Nhom2\QuanlyDatsanThethao\Controllers\UserController;

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
    'delete'
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

    // USER
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
        $controller = new UserController();
        break;

    // COURTS
    default:
        $controller = new CourtsController();
        break;
}


switch ($action) {

    case 'login':
        $controller->showLoginForm();
        break;

    case 'register':
        $controller->showRegisterForm();
        break;

    case 'do_login':
        $controller->login();
        break;

    case 'do_register':
        $controller->register();
        break;

    case 'logout':
        $controller->logout();
        break;

    case 'user':
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



    case 'home':
        $controller->home();
        break;

    case 'index':
        $controller->index(); 
        break;

    default:
        $controller->home();
        break;
}