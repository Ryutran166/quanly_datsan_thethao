<?php


namespace Nhom2\QuanlyDatsanThethao\Models;

use Nhom2\QuanlyDatsanThethao\Database;

class PromotionModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        return $this->pdo->query("SELECT * FROM khuyen_mai ORDER BY id DESC")->fetchAll();
    }

    public function getByCode($code)
    {
        $sql = "SELECT * FROM khuyen_mai 
                WHERE code = ?
                AND trang_thai = 'active'
                AND (ngay_ket_thuc IS NULL OR ngay_ket_thuc >= CURDATE())
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$code]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $discount = max(0, min(100, (int)$data['giam_phan_tram']));

        $sql = "INSERT INTO khuyen_mai 
        (tieu_de, noi_dung, hinh_anh, code, loai, giam_phan_tram, so_ngay_hieu_luc, ngay_bat_dau, ngay_ket_thuc, trang_thai)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['tieu_de'],
            $data['noi_dung'],
            $data['hinh_anh'],
            $data['code'],
            $data['loai'] ?? 'public',
            $discount,
            $data['so_ngay_hieu_luc'] ?? null,
            $data['ngay_bat_dau'] ?? null,
            $data['ngay_ket_thuc'] ?? null,
            $data['trang_thai'] ?? 'active'
        ]);
    }
}