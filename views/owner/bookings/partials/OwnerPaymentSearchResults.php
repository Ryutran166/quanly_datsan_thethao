<?php
// Partial results for module "Tìm kiếm thanh toán" (Owner)

$results = $results ?? [];
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? (isset($total, $perPage) ? (int)ceil($total / $perPage) : 1);
$perPage = 10;
$total = $total ?? 0;

if (empty($results)) {
    echo '<div style="padding:24px; text-align:center; color:#7c8aa0; font-weight:900;">Không có booking phù hợp.</div>';
    return;
}

function paymentStatusBadge($status){
    $key = strtolower((string)$status);
    $label = match($key){
        'pending' => '⏳ Chưa thanh toán',
        'confirmed' => '✓ Đã thanh toán',
        'cancelled' => '✕ Đã hủy',
        'locked' => '🔒 Locked',
        default => $status,
    };
    return '<span class="s-badge '.htmlspecialchars($key).'">'.htmlspecialchars($label).'</span>';
}

function paymentMethodLabel($pm){
    $pm = strtolower((string)$pm);
    return match($pm){
        'qr' => 'QR',
        'cash' => 'Tiền mặt',
        default => $pm ?: '—'
    };
}
?>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th class="th">Booking ID</th>
                <th class="th">Khách hàng</th>
                <th class="th hide-mobile">Sân</th>
                <th class="th">Ngày</th>
                <th class="th">Khung giờ</th>
                <th class="th">Tổng tiền</th>
                <th class="th hide-mobile">Phương thức</th>
                <th class="th">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($results as $b):
            $statusKey = strtolower((string)($b['status'] ?? ''));
            $slots = $b['slots'] ?? [];
        ?>
            <tr class="tr">
                <td class="td">#<?= (int)$b['id'] ?></td>
                <td class="td">
                    <div style="font-weight:1000;"><?= htmlspecialchars($b['customer_name'] ?? '') ?></div>
                    <div class="muted" style="font-weight:900; font-size:12px;"><?= htmlspecialchars($b['customer_phone'] ?? '') ?></div>
                </td>
                <td class="td hide-mobile"><?= htmlspecialchars($b['court_name'] ?? '') ?></td>
                <td class="td"><?= htmlspecialchars(date('d/m/Y', strtotime((string)$b['booking_date']))) ?></td>
                <td class="td">
                    <?php if(!empty($slots)): ?>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;">
                            <?php foreach($slots as $s): ?>
                                <span style="padding:4px 10px;border:1px solid var(--border);border-radius:999px;background:#fff;font-weight:1000; font-size:12px;">
                                    <?= htmlspecialchars(substr((string)$s['start_time'],0,5)) ?>-<?= htmlspecialchars(substr((string)$s['end_time'],0,5)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>—<?php endif; ?>
                </td>
                <td class="td"><?= number_format((float)($b['total_amount'] ?? 0), 0, '.', ',') ?> VNĐ</td>
                <td class="td hide-mobile"><?= htmlspecialchars(paymentMethodLabel($b['payment_method'] ?? 'cash')) ?></td>
                <td class="td"><?php echo paymentStatusBadge($b['status'] ?? ''); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
// pagination (server-side). Keep filter values in URL handled by JS/history.
$baseParams = [];
$baseParams['action'] = ($results ? 'owner_payment_search_ajax' : 'owner_payment_search_ajax');

$prevPage = max(1, (int)$currentPage - 1);
$nextPage = min((int)$totalPages, (int)$currentPage + 1);
?>

<div class="pagination">
    <div class="pager-left">
        <a class="page-link" href="#" data-page="<?= $prevPage ?>">← Prev</a>
        <span style="font-weight:1000;color:var(--mid);">Trang <b style="color:var(--primary);"><?= (int)$currentPage ?></b> / <?= (int)$totalPages ?></span>
        <a class="page-link" href="#" data-page="<?= $nextPage ?>">Next →</a>
    </div>
    <div style="font-weight:900;color:var(--muted);">Tổng: <b style="color:var(--dark);"><?= (int)$total ?></b> booking</div>
</div>


