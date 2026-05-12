<?php
// src/Controllers/VietQrController.php
namespace Nhom2\QuanlyDatsanThethao\Controllers;

use Nhom2\QuanlyDatsanThethao\Database;
use Nhom2\QuanlyDatsanThethao\Services\VietQrGenerator;
use PDO;

class VietQrController
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getVietqrImage(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $courtId = (int)($_GET['court_id'] ?? 0);
        $amount = (string)($_GET['amount'] ?? '');
        $description = (string)($_GET['description'] ?? '');

        if (!$courtId) {
            echo json_encode(['success' => false, 'error' => 'invalid_court_id']);
            exit();
        }

        // Basic amount validation
        $amount = trim($amount);
        if ($amount === '') {
            echo json_encode(['success' => false, 'error' => 'missing_amount']);
            exit();
        }

        // Query owner + VietQR fields
        $stmt = $this->conn->prepare('SELECT vietqr_bank_code, vietqr_account_number, vietqr_account_name FROM users WHERE id = (SELECT owner_id FROM courts WHERE id = :court_id LIMIT 1) LIMIT 1');
        $stmt->execute([':court_id' => $courtId]);
        $owner = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$owner) {
            echo json_encode(['success' => false, 'error' => 'owner_not_found_or_missing_vietqr']);
            exit();
        }

        $bankCode = trim((string)($owner['vietqr_bank_code'] ?? ''));
        $accountNumber = trim((string)($owner['vietqr_account_number'] ?? ''));
        $accountName = trim((string)($owner['vietqr_account_name'] ?? ''));

        if ($bankCode === '' || $accountNumber === '' || $accountName === '') {
            // Trả về thêm debug để biết field nào đang trống
            $missing = [];
            if ($bankCode === '') $missing[] = 'vietqr_bank_code';
            if ($accountNumber === '') $missing[] = 'vietqr_account_number';
            if ($accountName === '') $missing[] = 'vietqr_account_name';
            echo json_encode([
                'success' => false,
                'error' => 'vietqr_not_configured',
                'missing' => $missing,
            ]);
            exit();
        }

        $payload = VietQrGenerator::buildPayload([
            'account_name' => $accountName,
            'account_number' => $accountNumber,
            'bank_code' => $bankCode,
            'amount' => $amount,
            'description' => $description,
        ]);

        // Use Google Chart API to render QR image from payload
        // Dùng VietQR API trực tiếp
        $qrUrl = 'https://img.vietqr.io/image/'
            . urlencode($bankCode) . '-'
            . urlencode($accountNumber) . '-compact2.png'
            . '?amount=' . urlencode($amount)
            . '&addInfo=' . urlencode($description)
            . '&accountName=' . urlencode($accountName);

        echo json_encode(['success' => true, 'qr_image' => $qrUrl]);
        exit();

       
    }
}
