<?php

namespace Nhom2\QuanlyDatsanThethao\Models;

use PDO;

class KhuyenMaiModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost;dbname=datsan_thethao_db", "root", "");
    }

    // Lấy khuyến mãi đang hoạt động
    public function getActive()
    {
        $sql = "SELECT * FROM khuyen_mai 
                WHERE trang_thai = 1 
                AND ngay_ket_thuc >= CURDATE()
                ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM khuyen_mai ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}