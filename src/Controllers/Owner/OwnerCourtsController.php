<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers\Owner;

use Nhom2\QuanlyDatsanThethao\Controllers\CourtsController;
use Nhom2\QuanlyDatsanThethao\Models\CourtsModel;

class OwnerCourtsController extends CourtsController
{
    public function myCourts(): void
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'owner') {
            header('Location: index.php');
            exit();
        }

        $recordsPerPage = 6;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $offset = ($currentPage - 1) * $recordsPerPage;
        $keyword = $_GET['keyword'] ?? null;

        $ownerId = (int)$_SESSION['user_id'];

        $courtsModel = new CourtsModel();
        $result = $courtsModel->getCourtsByOwnerWithPaging(
            $ownerId,
            $keyword,
            $recordsPerPage,
            $offset
        );

        $courts = $result['data'];
        $totalRecords = (int)$result['total'];
        $totalPages = (int)ceil($totalRecords / $recordsPerPage);

        require_once PROJECT_ROOT . '/views/owner/courts/MyCourtsList.php';
    }
}


