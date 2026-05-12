<?php
// src/Controllers/CourtsQrController.php
namespace Nhom2\QuanlyDatsanThethao\Controllers;

use Nhom2\QuanlyDatsanThethao\Database;
use Nhom2\QuanlyDatsanThethao\Models\CourtsQrModel;

class CourtsQrController
{
    public function getQrContent(): void
    {
        // Giữ nguyên tên action trong route (get_owner_qr_content), nhưng đổi dữ liệu trả về
        header('Content-Type: application/json; charset=utf-8');

        $courtId = (int)($_GET['court_id'] ?? 0);
        if (!$courtId) {
            echo json_encode(['success' => false, 'error' => 'invalid_court_id']);
            exit();
        }

        $model = new CourtsQrModel();
        $qrImage = $model->getQrImageByCourtId($courtId);


        echo json_encode([
            'success' => true,
            'qr_image' => $qrImage,
        ]);
        exit();
    }

}

