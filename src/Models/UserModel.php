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
     * Tìm user theo email
     */
    public function findUserByEmail($email)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM users 
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm user mới
     */
    public function createUser($name, $email, $password, $phone = null, $role = 'customer')
    {
        // Kiểm tra email tồn tại
        if ($this->findUserByEmail($email)) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "
            INSERT INTO users (
                name,
                email,
                password,
                phone,
                role
            )
            VALUES (
                :name,
                :email,
                :password,
                :phone,
                :role
            )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    /**
     * Lấy toàn bộ user + tìm kiếm
     */
    public function getAllUsers($keyword = null)
    {
        $sql = "SELECT * FROM users";

        if (!empty($keyword)) {
            $sql .= "
                WHERE name LIKE :keyword
                OR email LIKE :keyword
                OR phone LIKE :keyword
                OR role LIKE :keyword
            ";
        }

        $sql .= " ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);

        if (!empty($keyword)) {
            $searchKeyword = "%{$keyword}%";
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy user theo ID
     */
    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM users 
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsers($keyword = null, $limit = 5, $offset = 0)
    {
        // ===============================
        // BƯỚC 1: ĐẾM TỔNG USER
        // ===============================
        $sqlCount = "SELECT COUNT(*) FROM users";
        $params = [];

        if ($keyword) {
            $sqlCount .= "
            WHERE name LIKE :keyword
            OR email LIKE :keyword
            OR phone LIKE :keyword
            OR role LIKE :keyword
        ";

            $params[':keyword'] = "%{$keyword}%";
        }

        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);

        $totalRecords = $stmtCount->fetchColumn();


        // ===============================
        // BƯỚC 2: LẤY DỮ LIỆU PHÂN TRANG
        // ===============================
        $sqlData = "SELECT * FROM users";

        if ($keyword) {
            $sqlData .= "
            WHERE name LIKE :keyword
            OR email LIKE :keyword
            OR phone LIKE :keyword
            OR role LIKE :keyword
        ";
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

        $users = $stmtData->fetchAll(PDO::FETCH_ASSOC);


        // ===============================
        // BƯỚC 3: TRẢ KẾT QUẢ
        // ===============================
        return [
            'data'  => $users,
            'total' => $totalRecords
        ];
    }

    /**
     * Cập nhật user
     */
    public function updateUser($id, $name, $email, $phone, $password = '', $role = 'customer')
    {
        try {

            if (!empty($password)) {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "
                    UPDATE users 
                    SET 
                        name = :name,
                        email = :email,
                        phone = :phone,
                        password = :password,
                        role = :role
                    WHERE id = :id
                ";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':password', $hashedPassword);
            } else {

                $sql = "
                    UPDATE users 
                    SET 
                        name = :name,
                        email = :email,
                        phone = :phone,
                        role = :role
                    WHERE id = :id
                ";

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

    /**
     * HÀM MỚI: Cập nhật mật khẩu cho người dùng
     */
    public function updatePassword($id, $newPassword)
    {
        // Băm mật khẩu mới trước khi lưu
        $passwordHash = password_hash(
            $newPassword,

            PASSWORD_DEFAULT
        );

        $stmt = $this->conn->prepare(
            "UPDATE users SET password = :password WHERE id = :id"
        );
        $stmt->bindParam(':password', $passwordHash);

        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    /**
     * Xóa user
     */
    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM users 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
