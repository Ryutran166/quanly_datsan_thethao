<?php
// Script để tạo dữ liệu mẫu cho courts
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/database.php';

use Nhom2\QuanlyDatsanThethao\Database;

try {
    $pdo = Database::getInstance()->getConnection();

    // Dữ liệu mẫu cho courts
    $sampleCourts = [
        [
            'name' => 'Sân Bóng Đá Mini A1',
            'price' => 500000.00,
            'status' => 'available',
            'address' => '123 Đường ABC, Quận 1, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=400',
            'owner_id' => 11
        ],
        [
            'name' => 'Sân Tennis Pro B2',
            'price' => 400000.00,
            'status' => 'available',
            'address' => '456 Đường XYZ, Quận 2, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400',
            'owner_id' => 11
        ],
        [
            'name' => 'Sân Cầu Lông VIP C3',
            'price' => 250000.00,
            'status' => 'available',
            'address' => '789 Đường DEF, Quận 3, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=400',
            'owner_id' => 11
        ],
        [
            'name' => 'Sân Bóng Rổ D4',
            'price' => 350000.00,
            'status' => 'available',
            'address' => '321 Đường GHI, Quận 4, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400',
            'owner_id' => 11
        ],
        [
            'name' => 'Sân Bơi Olympic E5',
            'price' => 600000.00,
            'status' => 'available',
            'address' => '654 Đường JKL, Quận 5, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?w=400',
            'owner_id' => 11
        ],
        [
            'name' => 'Sân Golf Mini F6',
            'price' => 800000.00,
            'status' => 'available',
            'address' => '987 Đường MNO, Quận 6, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1587174486073-ae3f4e4e4b5b?w=400',
            'owner_id' => 11
        ],
        [
            'name' => 'Sân Bowling G7',
            'price' => 200000.00,
            'status' => 'available',
            'address' => '147 Đường PQR, Quận 7, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=400',
            'owner_id' => 11
        ],
        [
            'name' => 'Sân Billiards H8',
            'price' => 150000.00,
            'status' => 'available',
            'address' => '258 Đường STU, Quận 8, TP.HCM',
            'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400',
            'owner_id' => 11
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO courts (name, price, status, address, image_url) VALUES (?, ?, ?, ?, ?)");

    foreach ($sampleCourts as $court) {
        $stmt->execute([
            $court['name'],
            $court['price'],
            $court['status'],
            $court['address'],
            $court['image_url']
        ]);
    }

    echo "Đã tạo thành công " . count($sampleCourts) . " sân mẫu!\n";

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>