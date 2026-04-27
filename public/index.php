<?php
// public/index.php
session_start();
define('PROJECT_ROOT', dirname(__DIR__));
require_once __DIR__ . '/../vendor/autoload.php';

use Nhom2\QuanlyDatsanThethao\Controllers\CourtsController;
use Nhom2\QuanlyDatsanThethao\Controllers\UserController;

$action = $_GET['action'] ?? 'index';

$public_actions = ['login', 'register', 'do_login', 'do_register'];

if (!in_array($action, $public_actions) && !isset($_SESSION['user_id'])) {
    header("Location:index.php?action=login");
    exit();
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

/* ===============================
   THỰC THI ACTION
================================= */
switch ($action) {

    /* ---------- USER ---------- */
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


    /* ---------- COURTS ---------- */

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

    case 'index':
    default:
        $controller->index();
        break;
}