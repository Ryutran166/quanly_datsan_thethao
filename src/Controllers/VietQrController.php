<?php
// src/Controllers/VietQrController.php
namespace Nhom2\QuanlyDatsanThethao\Controllers;

use Nhom2\QuanlyDatsanThethao\Database;
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
        $bookingId = (int)($_GET['booking_id'] ?? 0);
        $amount = (string)($_GET['amount'] ?? '');
        $description = (string)($_GET['description'] ?? '');
        $slotIds = $this->parseIds((string)($_GET['slot_ids'] ?? ''));
        $serviceIds = $this->parseIds((string)($_GET['service_ids'] ?? ''));

        if (!$courtId && !$bookingId) {
            echo json_encode(['success' => false, 'error' => 'invalid_court_id']);
            exit();
        }

        if ($bookingId > 0) {
            $stmt = $this->conn->prepare(
                "SELECT b.court_id, COALESCE(b.total_amount, 0) AS total_amount
                 FROM bookings b
                 WHERE b.id = :booking_id
                 LIMIT 1"
            );
            $stmt->execute([':booking_id' => $bookingId]);
            $booking = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$booking) {
                echo json_encode(['success' => false, 'error' => 'booking_not_found']);
                exit();
            }

            if ($courtId > 0 && (int)$booking['court_id'] !== $courtId) {
                echo json_encode(['success' => false, 'error' => 'booking_court_mismatch']);
                exit();
            }

            $courtId = (int)$booking['court_id'];
            $amount = (string)$booking['total_amount'];
        } elseif ($courtId > 0 && !empty($slotIds)) {
            $amount = (string)$this->calculateBookingPreviewAmount($courtId, $slotIds, $serviceIds);
        }

        $amount = trim($amount);
        if ($amount === '' || (float)str_replace(',', '.', $amount) <= 0) {
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

        $amountNormalized = (string)max(0, (int)round((float)str_replace(',', '.', trim($amount))));


        $qrUrl = 'https://img.vietqr.io/image/'
            . urlencode($bankCode) . '-'
            . urlencode($accountNumber) . '-compact2.png'
            . '?amount=' . urlencode($amountNormalized)
            . '&addInfo=' . urlencode($description)
            . '&accountName=' . urlencode($accountName);


        echo json_encode([
            'success' => true,
            'qr_image' => $qrUrl,
            'amount' => $amountNormalized,
            'source' => $bookingId > 0 ? 'booking_total_amount' : (!empty($slotIds) ? 'server_preview_total' : 'request_amount'),
        ]);
        exit();

       
    }

    private function parseIds(string $raw): array
    {
        $raw = str_replace([' ', ';'], [',', ','], trim($raw));
        return array_values(array_unique(array_filter(array_map('intval', explode(',', $raw)), fn($id) => $id > 0)));
    }

    private function calculateBookingPreviewAmount(int $courtId, array $slotIds, array $serviceIds): float
    {
        $stmt = $this->conn->prepare('SELECT price FROM courts WHERE id = :court_id LIMIT 1');
        $stmt->execute([':court_id' => $courtId]);
        $courtPrice = (float)($stmt->fetch(PDO::FETCH_ASSOC)['price'] ?? 0);

        $inSlots = implode(',', array_fill(0, count($slotIds), '?'));
        $slotStmt = $this->conn->prepare(
            "SELECT COALESCE(SUM(COALESCE(price_modifier, 1)), 0) AS total_modifier
             FROM time_slots
             WHERE id IN ($inSlots)"
        );
        $slotStmt->execute($slotIds);
        $total = $courtPrice * (float)($slotStmt->fetch(PDO::FETCH_ASSOC)['total_modifier'] ?? 0);

        if (!empty($serviceIds)) {
            $inServices = implode(',', array_fill(0, count($serviceIds), '?'));
            $serviceStmt = $this->conn->prepare(
                "SELECT COALESCE(SUM(s.price), 0) AS total
                 FROM services s
                 WHERE s.court_id = ?
                   AND s.status = 'active'
                   AND s.id IN ($inServices)"
            );
            $serviceStmt->execute(array_merge([$courtId], $serviceIds));
            $total += (float)($serviceStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
        }

        return $total;
    }
}
