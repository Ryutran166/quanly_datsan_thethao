<?php

namespace Nhom2\QuanlyDatsanThethao\Models;

use PDO;

class SanModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO(
            "mysql:host=localhost;dbname=datsan_thethao_db;charset=utf8",
            "root",
            ""
        );
    }

    // Lấy sân nổi bật
    public function getFeatured($limit = 6)
    {
        $sql = "SELECT * FROM courts 
                WHERE status = 'available'
                ORDER BY id DESC 
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT id, name, price, status, address, image FROM courts";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}