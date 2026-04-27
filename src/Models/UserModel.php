<?php

namespace Nhom2\QuanlyDatsanThethao\Models;

use Nhom2\QuanlyDatsanThethao\Database;
use PDO;

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Tìm người dùng bằng Email
     */
    public function findUserByEmail($email)
    {
        // Giả sử tên cột trong DB của bạn vẫn là 'username' hoặc bạn đã đổi thành 'email'
        // Ở đây tôi để là cột 'email' cho đúng ý bạn.
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo người dùng mới với Email
     */
    public function createUser($name, $email, $password, $phone = null)
    {
        // Kiểm tra email tồn tại
        if ($this->findUserByEmail($email)) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Đổi tên cột username thành email trong câu lệnh INSERT
        $sql = "INSERT INTO users (name, email, password, phone) 
                VALUES (:name, :email, :password, :phone)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':phone', $phone);

        return $stmt->execute();
    }

    /**
     * Lấy danh sách toàn bộ người dùng
     */
    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users

WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // HÀM THÊM MỚI: Cập nhật thông tin sinh viên (bài 03)
    public function updateUser($id, $name, $email, $phone, $password = '')
{
    try {
        if (!empty($password)) {
            // Trường hợp có đổi mật khẩu mới
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, password = :password WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':password', $hashedPassword);
        } else {
            // Trường hợp không đổi mật khẩu (giữ nguyên pass cũ)
            $sql = "UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        return $stmt->execute();
    } catch (\PDOException $e) {
        // Ghi log lỗi để debug nếu cần
        error_log($e->getMessage());
        return false;
    }
}
}
