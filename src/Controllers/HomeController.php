<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers;

use Nhom2\QuanlyDatsanThethao\Models\TinTucModel;
use Nhom2\QuanlyDatsanThethao\Models\KhuyenMaiModel;
use Nhom2\QuanlyDatsanThethao\Models\SanModel;

class HomeController {

    public function home() {

        $tinTucModel = new TinTucModel();
        $khuyenMaiModel = new KhuyenMaiModel();
        $sanModel = new SanModel();

        // ✅ FIX QUAN TRỌNG
        $data = [];

        $data['tinTuc'] = $tinTucModel->getLatest(6) ?? [];
        $data['khuyenMai'] = $khuyenMaiModel->getActive() ?? [];
        $data['sanNoiBat'] = $sanModel->getFeatured(6) ?? [];

        require __DIR__ . '/../../views/Home/Home.php';
    }
}