<?php

namespace Nhom2\QuanlyDatsanThethao\Models;

use Nhom2\QuanlyDatsanThethao\Database;
use PDO;

class UserModel
{
    private $conn;

    public function __construct()
    {
        // Kết nối thông qua lớp Database Singleton của bạn
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Tìm người dùng bằng Email (Dùng để đăng nhập)
     */
    public function findUserByEmail($email)
    {
        // Thêm SELECT * để lấy cả cột role và password
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo người dùng mới (Dành cho chức năng đăng ký)
     */
    public function createUser($name, $email, $password, $phone = null, $role = 'customer')
    {
        if ($this->findUserByEmail($email)) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Thêm cột role vào câu lệnh INSERT
        $sql = "INSERT INTO users (name, email, password, phone, role) 
                VALUES (:name, :email, :password, :phone, :role)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    /**
     * Lấy danh sách toàn bộ người dùng (Dành cho Admin quản lý)
     */
    public function getAllUsers()
    {
        // Lấy thêm cột role để hiển thị trong bảng quản lý users
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, role FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function updateUser($id, $name, $email, $phone, $role, $password = '')
    {
        try {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                // Thêm cập nhật role
                $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, role = :role, password = :password WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':password', $hashedPassword);
            } else {
                // Thêm cập nhật role
                $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, role = :role WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
            }

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':role', $role);

            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}