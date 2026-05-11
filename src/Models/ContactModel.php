<?php
// src/Models/ContactModel.php
namespace Nhom2\QuanlyDatsanThethao\Models;

use Nhom2\QuanlyDatsanThethao\Database;
use PDO;

class ContactModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Lưu một liên hệ mới vào CSDL
     */
    public function saveContact($name, $email, $message)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO contacts (name, email, message) VALUES

(:name, :email, :message)"
        );
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($name)));
        $stmt->bindParam(':email', htmlspecialchars(strip_tags($email)));
        $stmt->bindParam(':message', htmlspecialchars(strip_tags($message)));

        return $stmt->execute();
    }

    /**
     * Lấy danh sách tin nhắn liên hệ (admin dùng)
     */
    public function getAllContacts()
    {
        $stmt = $this->conn->prepare(
            "SELECT id, name, email, message, submitted_at
             FROM contacts
             ORDER BY submitted_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

