<?php
namespace Nhom2\QuanlyDatsanThethao\Controllers;

use Nhom2\QuanlyDatsanThethao\Models\PromotionModel;

class AdminController {
    private $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    public function dashboard()
    {
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/admin/dashboard.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }
    public function checkVoucher()
    {
        $code = $_GET['code'] ?? '';

        $voucher = $this->promotionModel->findByCode($code);

        if ($voucher && $voucher['trang_thai'] == 'active') {
            echo json_encode([
                'success' => true,
                'discount' => $voucher['phan_tram_giam']
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    // Danh sách khuyến mãi
    public function promotion()
    {
        $promotions = $this->promotionModel->getAll();

        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/admin/promotion_list.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    // Form thêm
    public function createPromotion()
    {
        require_once PROJECT_ROOT . '/views/layout/header.php';
        require_once PROJECT_ROOT . '/views/admin/promotion_create.php';
        require_once PROJECT_ROOT . '/views/layout/footer.php';
    }

    // Lưu DB
    public function storePromotion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->promotionModel->create([
                'tieu_de' => $_POST['tieu_de'],
                'noi_dung' => $_POST['noi_dung'],
                'hinh_anh' => $_POST['hinh_anh'],
                'ngay_bat_dau' => $_POST['ngay_bat_dau'],
                'ngay_ket_thuc' => $_POST['ngay_ket_thuc'],
                'trang_thai' => $_POST['trang_thai']
            ]);
        }

        header("Location:index.php?action=promotion");
        exit();
    }

    public function logout()
        {
            session_start();
            $_SESSION = [];
            session_destroy();

            header("Location: index.php?action=login");
            exit();
        }
}