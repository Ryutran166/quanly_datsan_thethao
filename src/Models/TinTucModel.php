<?php

namespace Nhom2\QuanlyDatsanThethao\Models;

use PDO;

class TinTucModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost;dbname=datsan_thethao_db", "root", "");
    }

    // Lấy tin mới nhất
    public function getLatest($limit = 6)
    {
        $sql = "SELECT * FROM tin_tuc 
                WHERE trang_thai = 1 
                ORDER BY ngay_dang DESC 
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM tin_tuc ORDER BY ngay_dang DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}