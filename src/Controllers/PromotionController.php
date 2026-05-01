<?php

namespace Nhom2\QuanlyDatsanThethao\Controllers;

class PromotionController
{
    public function claim()
    {
        session_start();

        $userId = $_SESSION['user_id'];
        $promotionId = $_GET['id'] ?? null;

        if (!$promotionId) {
            die("Thiếu ID voucher");
        }

        $promo = $this->promotionModel->getById($promotionId);

        if (!$promo) {
            die("Không tồn tại");
        }

        $ngayNhan = date('Y-m-d H:i:s');

        if ($promo['loai'] == 'personal') {
            $ngayHetHan = date('Y-m-d H:i:s', strtotime("+{$promo['so_ngay_hieu_luc']} days"));
        } else {
            $ngayHetHan = $promo['ngay_ket_thuc'];
        }

        $sql = "INSERT INTO user_khuyen_mai 
                (user_id, promotion_id, ngay_nhan, ngay_het_han)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $promotionId, $ngayNhan, $ngayHetHan]);

        header("Location: index.php?action=my_voucher");
        exit();
    }
}