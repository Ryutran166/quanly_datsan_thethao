<?php
namespace Nhom2\QuanlyDatsanThethao\Services;

class VietQrGenerator
{
    /**
     * Generate VietQR payload (QR content string)
     *
     * Format (phổ biến theo spec VietQR/EMV):
     * 00{01}0100
     * ...
     * Trong thực tế, nhiều nhà cung cấp chỉ cần payload đúng định dạng TLV.
     *
     * Lưu ý: Code dưới đây tạo payload theo cấu trúc TLV thông dụng.
     */
    public static function buildPayload(array $data): string
    {
        $merchantName = (string)($data['account_name'] ?? '');
        $accountNumber = (string)($data['account_number'] ?? '');
        $bankCode = (string)($data['bank_code'] ?? '');
        $amount = (string)($data['amount'] ?? '');
        $description = (string)($data['description'] ?? '');
        $currency = '704'; // VND

        $merchantName = self::normalize($merchantName, 1, 100);
        $accountNumber = self::normalize($accountNumber, 1, 30);
        $bankCode = self::normalize($bankCode, 1, 10);
        $amount = self::formatAmount($amount);
        $description = self::normalize($description, 0, 200);

        // 1) Payload template VietQR TLV
        // top-level
        $payload = '';

        // [00] Payload Format Indicator
        $payload .= self::tlv('00', '01');

        // [01] Point of Initiation Method
        $payload .= self::tlv('01', '12');

        // [38] Merchant Account Information (sub-templates)
        $sub = '';
        // [00] Bank Code
        $sub .= self::tlv('00', $bankCode);
        // [01] Transfer Account Number
        $sub .= self::tlv('01', $accountNumber);
        // [02] Transfer Account Name
        if ($merchantName !== '') {
            $sub .= self::tlv('02', $merchantName);
        }
        $payload .= self::tlv('38', $sub);

        // [52] Merchant Category Code
        $payload .= self::tlv('52', '0000');

        // [53] Transaction Currency
        $payload .= self::tlv('53', $currency);

        // [54] Transaction Amount
        $payload .= self::tlv('54', $amount);

        // [58] Country Code (VN)
        $payload .= self::tlv('58', 'VN');

        // [62] Additional Data Field Template
        $add = '';
        if ($description !== '') {
            // [01] Bill Number / Purpose of payment
            $add .= self::tlv('01', $description);
        }
        // Chỗ trống có thể thêm
        $payload .= self::tlv('62', $add);

        // [63] CRC placeholder
        // VietQR: CRC16/CCITT
        $withoutCrc = $payload . '6304';
        $crc = self::crc16ccitt($withoutCrc);
        $payloadFinal = $withoutCrc . strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));

        return $payloadFinal;
    }

    private static function tlv(string $tag, string $value): string
    {
        // tag: 2 digits, value length in digits (2 for most tags)
        $value = (string)$value;
        $len = strlen($value);
        return $tag . str_pad((string)$len, 2, '0', STR_PAD_LEFT) . $value;
    }

    private static function formatAmount(string $amount): string
    {
        // amount should be numeric; keep 0 decimals (VietQR thường dùng số nguyên)
        $amount = trim($amount);
        if ($amount === '') return '0';
        $amount = str_replace(',', '.', $amount);
        $num = (float)$amount;
        if ($num < 0) $num = 0;

        // VietQR yêu cầu dạng số nguyên VND (thường)
        return (string)intval(round($num));
    }

    private static function normalize(string $s, int $minLen, int $maxLen): string
    {
        $s = trim($s);
        if ($minLen === 0 && $s === '') return '';
        if ($s === '') return str_repeat(' ', $minLen);
        // VietQR ASCII nên hạn chế ký tự đặc biệt
        $s = preg_replace('/[^0-9A-Za-zÀ-ỹ\s\-_.]/u', '', $s) ?? '';
        $s = trim($s);
        if (mb_strlen($s, 'UTF-8') < $minLen) {
            // fallback
            return str_pad($s, $minLen, ' ');
        }
        if (mb_strlen($s, 'UTF-8') > $maxLen) {
            return mb_substr($s, 0, $maxLen, 'UTF-8');
        }
        return $s;
    }

    // CRC16-CCITT (0xFFFF)
    private static function crc16ccitt(string $data): int
    {
        $crc = 0xFFFF;
        $len = strlen($data);

        for ($i = 0; $i < $len; $i++) {
            $crc ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if (($crc & 0x8000) !== 0) {
                    $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }

        return $crc & 0xFFFF;
    }
}

