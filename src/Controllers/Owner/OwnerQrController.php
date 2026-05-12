<?php
// src/Controllers/Owner/OwnerQrController.php
namespace Nhom2\QuanlyDatsanThethao\Controllers\Owner;

use Nhom2\QuanlyDatsanThethao\Controllers\BaseController;
use Nhom2\QuanlyDatsanThethao\Database;

class OwnerQrController extends BaseController
{
    public function settings(): void
    {
        $ownerId = $_SESSION['user_id'] ?? null;
        if (!$ownerId) {
            header('Location: index.php?action=login');
            exit();
        }


        $pdo = Database::getInstance()->getConnection();

        // Owner nhập VietQR, nên lấy trực tiếp từ users
        // Nếu DB chưa có cột VietQR thì trả về empty để view không crash
        $stmt = $pdo->prepare('SELECT vietqr_bank_code, vietqr_account_number, vietqr_account_name FROM users WHERE id = :owner_id LIMIT 1');
        $stmt->execute([':owner_id' => (int)$ownerId]);
        $vietqr = $stmt->fetch(\PDO::FETCH_ASSOC) ?: [];

        require_once PROJECT_ROOT . '/views/owner/qr/OwnerQrSettings.php';




    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit();
        }

        $ownerId = $_SESSION['user_id'] ?? null;
        if (!$ownerId) {
            header('Location: index.php');
            exit();
        }

        $vietqr_account_name = trim((string)($_POST['vietqr_account_name'] ?? ''));
        $vietqr_bank_code = trim((string)($_POST['vietqr_bank_code'] ?? ''));
        $vietqr_account_number = trim((string)($_POST['vietqr_account_number'] ?? ''));

        if ($vietqr_account_name === '' || $vietqr_bank_code === '' || $vietqr_account_number === '') {
            header('Location: index.php?action=owner_qr_settings&error=missing');
            exit();
        }

        $pdo = Database::getInstance()->getConnection();

        $stmt = $pdo->prepare('UPDATE users SET vietqr_bank_code = :vietqr_bank_code, vietqr_account_number = :vietqr_account_number, vietqr_account_name = :vietqr_account_name WHERE id = :owner_id');
        $stmt->execute([
            ':vietqr_bank_code' => $vietqr_bank_code,
            ':vietqr_account_number' => $vietqr_account_number,
            ':vietqr_account_name' => $vietqr_account_name,
            ':owner_id' => (int)$ownerId
        ]);

        header('Location: index.php?action=owner_qr_settings&success=saved');
        exit();
    }
}

