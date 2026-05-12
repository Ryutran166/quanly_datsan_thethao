<?php
// src/Models/CourtsQrModel.php
namespace Nhom2\QuanlyDatsanThethao\Models;

use Nhom2\QuanlyDatsanThethao\Database;
use PDO;

class CourtsQrModel
{
    private PDO $conn;


    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Lấy ảnh QR cho sân (qr_image) - trả về đường dẫn URL hiển thị trên web
     */
    public function getQrImageByCourtId(int $courtId): ?string
    {
        $stmt = $this->conn->prepare('SELECT qr_image FROM courts WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $courtId]);
        $val = $stmt->fetchColumn();
        if ($val === false || $val === null) return null;
        $s = (string)$val;
        $s = trim($s);
        if ($s === '') return null;

        // Nếu đã lưu sẵn dạng đường dẫn URL đầy đủ thì trả về luôn
        if (str_starts_with($s, 'http://') || str_starts_with($s, 'https://')) {
            return $s;
        }

        // Ngược lại, coi như lưu path tương đối từ /public
        // Ví dụ: public/upload/qr/abc.png hoặc upload/qr/abc.png
        $s = str_replace('\\', '/', $s);
        $s = ltrim($s, '/');
        if (str_starts_with($s, 'public/')) {
            return '/' . $s;
        }
        return '/public/' . $s;
    }

}

