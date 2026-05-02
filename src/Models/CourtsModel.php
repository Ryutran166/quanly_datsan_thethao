<?php

namespace Nhom2\QuanlyDatsanThethao\Models;

use Nhom2\QuanlyDatsanThethao\Database;
use PDO;

class CourtsModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }


    // Lấy tất cả sân và tìm kiếm theo tên
    public function getAllCourts($keyword = null)
    {
        // Bắt đầu câu lệnh SQL
        $sql = "SELECT * FROM courts";
        // Nếu có từ khóa tìm kiếm, thêm điều kiện WHERE
        if ($keyword) {
            // Sử dụng LIKE để tìm kiếm gần đúng
            $sql .= " WHERE name LIKE :keyword";
        }
        $sql .= " ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        // Nếu có từ khóa, gán giá trị cho tham số :keyword
        if ($keyword) {
            // Thêm dấu % vào hai bên từ khóa để tìm kiếm bất kỳ vị trí nào trong chuỗi
            $searchKeyword = "%{$keyword}%";
            $stmt->bindParam(':keyword', $searchKeyword);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Thêm sân mới
    public function addCourts($data)
    {
        $stmt = $this->conn->prepare("
        INSERT INTO courts
        (name, price, status, image_url, owner_id)
        VALUES
        (:name, :price, :status, :image_url, :owner_id)
    ");

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':price', $data['price']);
        $stmt->bindValue(':status', $data['status'] ?? 'available');
        $stmt->bindValue(':image_url', $data['image_url'] ?? null);
        $stmt->bindValue(':owner_id', $data['owner_id']);

        return $stmt->execute();
    }



    public function getCourtById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM courts WHERE id = :id
        ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateCourt($id, $data)
    {
        $stmt = $this->conn->prepare("
        UPDATE courts 
        SET name = :name,
            price = :price,
            status = :status,
            image_url = :image_url
        WHERE id = :id
    ");

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($data['name']));
        $price = $data['price'];
        $status = $data['status'] ?? 'available';
        $image = $data['image_url'] ?? null;

        // Bind
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':image_url', $image);

        return $stmt->execute();
    }


    public function deleteCourt($id)
    {
        $stmt = $this->conn->prepare("
        DELETE FROM courts WHERE id = :id
    ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getCourtsByOwner($ownerId)
    {
        $stmt = $this->conn->prepare("
        SELECT * FROM courts
        WHERE owner_id = :owner_id
        ORDER BY id DESC
    ");

        $stmt->bindParam(':owner_id', $ownerId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCourts($keyword = null, $limit = 6, $offset = 0)
{
    // Đếm tổng số sân
    $sqlCount = "SELECT COUNT(*) FROM courts";
    $params = [];

    if ($keyword) {
        $sqlCount .= " WHERE name LIKE :keyword";
        $params[':keyword'] = "%{$keyword}%";
    }

    $stmtCount = $this->conn->prepare($sqlCount);
    $stmtCount->execute($params);
    $totalRecords = $stmtCount->fetchColumn();


    // Lấy dữ liệu phân trang
    $sqlData = "SELECT * FROM courts";

    if ($keyword) {
        $sqlData .= " WHERE name LIKE :keyword";
    }

    $sqlData .= "
        ORDER BY id DESC
        LIMIT :limit
        OFFSET :offset
    ";

    $stmtData = $this->conn->prepare($sqlData);

    if ($keyword) {
        $stmtData->bindValue(':keyword', "%{$keyword}%");
    }

    $stmtData->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmtData->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmtData->execute();

    $courts = $stmtData->fetchAll(PDO::FETCH_ASSOC);

    return [
        'data' => $courts,
        'total' => $totalRecords
    ];
}
}
