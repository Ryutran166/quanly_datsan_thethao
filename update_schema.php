<?php
// Script để cập nhật database schema
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/database.php';

use Nhom2\QuanlyDatsanThethao\Database;

try {
    $pdo = Database::getInstance()->getConnection();

    // Thêm cột user_id vào bookings nếu chưa có
    $stmt = $pdo->query("SHOW COLUMNS FROM bookings LIKE 'user_id'");
    if ($stmt->rowCount() === 0) {
        $pdo->exec("ALTER TABLE bookings ADD COLUMN user_id INT(11) DEFAULT NULL AFTER status");
    }

    // Thêm cột address vào courts nếu chưa có
    $stmt = $pdo->query("SHOW COLUMNS FROM courts LIKE 'address'");
    if ($stmt->rowCount() === 0) {
        $pdo->exec("ALTER TABLE courts ADD COLUMN address VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'địa chỉ sân' AFTER status");
    }

    // Thêm cột payment_method vào bookings nếu chưa có
    $stmt = $pdo->query("SHOW COLUMNS FROM bookings LIKE 'payment_method'");
    if ($stmt->rowCount() === 0) {
        $pdo->exec("ALTER TABLE bookings ADD COLUMN payment_method ENUM('cash','qr') DEFAULT 'cash' AFTER status");
    }

    echo "Đã cập nhật schema database thành công!\n";
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>

