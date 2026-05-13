<?php
// public/index.php
session_start();
define('PROJECT_ROOT', dirname(__DIR__));
require_once __DIR__ . '/../vendor/autoload.php';

use Nhom2\QuanlyDatsanThethao\Controllers\CourtsController;
use Nhom2\QuanlyDatsanThethao\Controllers\UserController;
use Nhom2\QuanlyDatsanThethao\Controllers\Admin\AdminController;
use Nhom2\QuanlyDatsanThethao\Controllers\PageController;

$action = $_GET['action'] ?? 'index';

$protected_actions = [
    'create',
    'add',
    'do_add_user',
    'edit',
    'update',
    'delete',
    // 'confirm_booking',
    'my_bookings',
    'cancel_booking',
    'user',
    'add_user',
    'edit_user',
    'update_user',
    'delete_user',
    'change_password',
    'do_change_password',

    // Payment search module
    'owner_payment_search',
    'owner_payment_search_ajax',
    'admin_payment_search',
    'admin_payment_search_ajax',
];

if (in_array($action, $protected_actions) && !isset($_SESSION['user_id'])) {
    header("Location:index.php?action=login");
    exit();
}
$role_only_actions = [
    // Admin
    'user','add_user','edit_user','update_user','delete_user','do_add_user',
    'admin_bookings','admin_cancel_booking','admin_confirm_booking',

    // Owner
    'owner_bookings','owner_confirm_booking','owner_qr_settings','owner_qr_settings_update','get_owner_qr_content',

    // Admin payment search
    'admin_payment_search','admin_payment_search_ajax',
    // Admin reports
    'admin_report_revenue','admin_report_booking','admin_report_customer',
    'admin_report_revenue_export','admin_report_customer_export',
    // Owner reports
    // 'owner_report_revenue','owner_report_booking','owner_report_revenue_export',
    // 'owner_report_customer','owner_report_customer_export',
    ];
if (in_array($action, $role_only_actions)) {
    $role = strtolower(trim($_SESSION['user_role'] ?? ''));

    $allowed = match ($action) {
        'admin_bookings', 'admin_cancel_booking', 'admin_confirm_booking' => ['admin'],
        'admin_report_revenue', 'admin_report_booking', 'admin_report_customer',
        'admin_report_revenue_export', 'admin_report_customer_export' => ['admin'],
        'owner_report_revenue', 'owner_report_booking', 'owner_report_revenue_export' => ['owner'],
        'owner_bookings', 'owner_confirm_booking', 'owner_qr_settings', 'owner_qr_settings_update' => ['owner'],
        'get_owner_qr_content' => ['owner'],
        default => ['admin'], // các action user/quản trị còn lại chỉ admin
    };

    if (!in_array($role, $allowed, true)) {
        error_log("[DEBUG] Deny action={$action} role={$role} user_id=" . ($_SESSION['user_id'] ?? 'null'));
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
    case 'do_change_password':
    case 'change_password':
        $controller = new UserController();
        break;
    case 'contact':
    case 'submit_contact':
    case 'contact_admin':
        $controller = new PageController();
        break;

    // COURTS
    default:
        $controller = new CourtsController();
        break;
}

switch ($action) {
    case 'contact':
        $role = strtolower(trim($_SESSION['user_role'] ?? ''));
        if ($role === 'admin') {
            $controller->adminContacts();
        } else {
            $controller->showContactForm();
        }
        break;

    case 'submit_contact':
        $controller->submitContact();
        break;

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

    case 'change_password':
        $controller->showChangePasswordForm();
        break;
    case 'do_change_password':
        $controller->handleChangePassword();
        break;
    case 'user':
        $controller->index();
        break;

    case 'add_user':
        $controller->add();
        break;
    case 'do_add_user':
        $controller->store();
        break;

    case 'edit_user':
        $controller->edit();
        break;

    case 'update_user':
        $controller->update();
        break;

    case 'delete_user':
        $controller->delete();
        break;

    // ADMIN BOOKINGS
    case 'admin_bookings':
        $adminController = new AdminController();
        $adminController->bookings();
        break;

    case 'admin_cancel_booking':
        $adminController = new AdminController();
        $adminController->cancelBooking();
        break;

    case 'admin_confirm_booking':
        $adminController = new AdminController();
        $adminController->confirmBooking();
        break;

    case 'admin_payment_search':
        $adminController = new AdminController();
        $adminController->paymentSearch();
        break;

    case 'admin_payment_search_ajax':
        $adminController = new AdminController();
        $adminController->paymentSearchAjax();
        break;

    case 'admin_report_revenue':
        $adminController = new AdminController();
        $adminController->revenueReport();
        break;

    case 'admin_report_revenue_export':
        $adminController = new AdminController();
        $adminController->revenueReportExport();
        break;

    case 'admin_report_booking':
        $adminController = new AdminController();
        $adminController->bookingReport();
        break;

    case 'admin_report_customer':
        $adminController = new AdminController();
        $adminController->customerReport();
        break;

    case 'admin_report_customer_export':
        $adminController = new AdminController();
        $adminController->customerReportExport();
        break;

    // OWNER BOOKINGS
    case 'owner_bookings':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->bookings();
        break;

    case 'owner_confirm_booking':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->confirmBooking();
        break;

    case 'owner_report_revenue':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->revenueReport();
        break;

    case 'owner_report_revenue_export':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->revenueReportExport();
        break;

    case 'owner_report_booking':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->bookingReport();
        break;

    case 'owner_report_customer':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->customerReport();
        break;

    case 'owner_report_customer_export':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->customerReportExport();
        break;


    case 'owner_payment_search':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->paymentSearch();
        break;

    case 'owner_payment_search_ajax':
        $ownerController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerController();
        $ownerController->paymentSearchAjax();
        break;

    case 'owner_qr_settings':
        $ownerQrController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerQrController();
        $ownerQrController->settings();
        break;

    case 'owner_qr_settings_update':
        $ownerQrController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerQrController();
        $ownerQrController->update();
        break;

    case 'owner_my_courts':
        $ownerCourtsController = new \Nhom2\QuanlyDatsanThethao\Controllers\Owner\OwnerCourtsController();
        $ownerCourtsController->myCourts();
        break;


    case 'get_owner_qr_content':
        $courtsQrController = new \Nhom2\QuanlyDatsanThethao\Controllers\CourtsQrController();
        $courtsQrController->getQrContent();
        break;

    case 'get_vietqr_image':
        $vietQrController = new \Nhom2\QuanlyDatsanThethao\Controllers\VietQrController();
        $vietQrController->getVietqrImage();
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
    case 'check_booking':
        $controller->check_booking();
        break;

    case 'court_detail':
        $controller->courtDetail();
        break;

    case 'guest_form':
        $controller->guest_form();
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
