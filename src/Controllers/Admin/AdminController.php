<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers\Admin;

use Nhom2\QuanlyDatsanThethao\Models\CourtsModel;
use Nhom2\QuanlyDatsanThethao\Database;

class AdminController
{
    private $courtsModel;

    public function __construct()
    {
        $this->courtsModel = new CourtsModel();
    }

    public function dashboard()
{
    $courts = $this->courtsModel->getAllCourts();
    $stats = [
        'total_users'  => 10,            
        'total_courts' => count($courts), 
        'new_bookings' => 5,              
        'revenue'      => '1.500.000đ'    
    ];
    $totalCourts = count($courts);
    require_once PROJECT_ROOT . '/views/admin/dashboard/Dashboard.php'; 
}
}
