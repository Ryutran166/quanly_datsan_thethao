<?php
// Hàm badge trạng thái
function statusBadge(string $status, string $date): string {
    if ($status === 'cancelled') 
        return '<span style="background:#fee2e2;color:#b91c1c;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">Đã hủy</span>';
    if (strtotime($date) < strtotime('today'))
        return '<span style="background:#f3f4f6;color:#6b7280;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">Đã xong</span>';
    return '<span style="background:#dcfce7;color:#15803d;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">Đã xác nhận</span>';
}
?>

<div style="max-width:900px; margin:0 auto; padding:24px 20px; font-family:'Inter',sans-serif;">

    <!-- Header -->
    <div style="margin-bottom:28px;">
        <h2 style="font-size:1.4rem; font-weight:700; margin:0 0 4px;">Lịch sử đặt sân</h2>
        <p style="color:#888; font-size:0.9rem; margin:0;">Quản lý các lịch đặt sân của bạn</p>
    </div>

    <!-- Thông báo -->
    <?php if (!empty($_GET['success']) && $_GET['success'] === 'cancelled'): ?>
        <div style="background:#dcfce7; border-left:4px solid #16a34a; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; color:#15803d;">
            ✅ Hủy lịch thành công. Tiền sẽ được hoàn trong 1–3 ngày làm việc.
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error']) && $_GET['error'] === 'cannot_cancel'): ?>
        <div style="background:#fee2e2; border-left:4px solid #dc2626; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; color:#b91c1c;">
            ⚠️ Không thể hủy. Lịch đặt còn dưới 12 tiếng hoặc không tồn tại.
        </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div style="display:flex; gap:8px; margin-bottom:24px; border-bottom:1px solid #eee; padding-bottom:0;">
        <?php
        $tabs = [
            'upcoming'  => ['label' => 'Sắp tới',  'count' => count($upcoming)],
            'past'      => ['label' => 'Đã xong',  'count' => count($past)],
            'cancelled' => ['label' => 'Đã hủy',   'count' => count($cancelled)],
        ];
        $activeTab = $_GET['tab'] ?? 'upcoming';
        foreach ($tabs as $key => $tab):
        ?>
            <a href="index.php?action=my_bookings&tab=<?= $key ?>"
               style="padding:10px 18px; font-size:0.9rem; font-weight:500; text-decoration:none; border-bottom:2px solid <?= $activeTab === $key ? '#198754' : 'transparent' ?>; color:<?= $activeTab === $key ? '#198754' : '#888' ?>; margin-bottom:-1px; display:flex; align-items:center; gap:6px;">
                <?= $tab['label'] ?>
                <?php if ($tab['count'] > 0): ?>
                    <span style="background:<?= $activeTab === $key ? '#198754' : '#e5e7eb' ?>;color:<?= $activeTab === $key ? '#fff' : '#6b7280' ?>;font-size:11px;padding:1px 7px;border-radius:20px;">
                        <?= $tab['count'] ?>
                    </span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Danh sách booking -->
    <?php
    $displayList = match($activeTab) {
        'past'      => $past,
        'cancelled' => $cancelled,
        default     => $upcoming,
    };
    ?>

    <?php if (empty($displayList)): ?>
        <div style="text-align:center; padding:60px 20px; color:#aaa;">
            <i class="fas fa-calendar-times" style="font-size:2.5rem; margin-bottom:16px; display:block;"></i>
            <p style="font-size:0.95rem; margin:0;">Không có lịch đặt nào.</p>
            <?php if ($activeTab === 'upcoming'): ?>
                <a href="index.php?action=courts"
                   style="display:inline-block; margin-top:16px; padding:10px 24px; background:#198754; color:#fff; border-radius:8px; text-decoration:none; font-size:0.9rem; font-weight:500;">
                    Đặt sân ngay
                </a>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <div style="display:flex; flex-direction:column; gap:14px;">
        <?php foreach ($displayList as $b): ?>
            <?php
            $canCancel = $b['booking_status'] === 'confirmed'
                      && strtotime($b['booking_date'] . ' ' . $b['start_time']) - time() > 12 * 3600;
            ?>
            <div style="background:#fff; border:1px solid #eee; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:20px; box-shadow:0 1px 4px rgba(0,0,0,0.04);">

                <!-- Ảnh sân -->
                <img src="<?= htmlspecialchars($b['image_url'] ?? 'assets/images/default-court.jpg') ?>"
                     alt="court"
                     style="width:80px; height:80px; border-radius:10px; object-fit:cover; flex-shrink:0; background:#f3f4f6;">

                <!-- Thông tin -->
                <div style="flex:1; min-width:0;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px; flex-wrap:wrap;">
                        <strong style="font-size:1rem;"><?= htmlspecialchars($b['court_name']) ?></strong>
                        <?= statusBadge($b['booking_status'], $b['booking_date']) ?>
                    </div>

                    <div style="display:flex; gap:20px; flex-wrap:wrap; font-size:0.85rem; color:#666;">
                        <span>
                            <i class="fas fa-calendar" style="color:#198754; margin-right:4px;"></i>
                            <?= date('d/m/Y', strtotime($b['booking_date'])) ?>
                        </span>
                        <span>
                            <i class="fas fa-clock" style="color:#198754; margin-right:4px;"></i>
                            <?= substr($b['start_time'],0,5) ?> – <?= substr($b['end_time'],0,5) ?>
                        </span>
                        <span>
                            <i class="fas fa-tag" style="color:#198754; margin-right:4px;"></i>
                            <?= number_format($b['price']) ?> VNĐ
                        </span>
                    </div>

                    <div style="font-size:0.78rem; color:#bbb; margin-top:6px;">
                        Đặt lúc: <?= date('H:i d/m/Y', strtotime($b['created_at'])) ?>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div style="display:flex; flex-direction:column; gap:8px; flex-shrink:0;">
                    <a href="index.php?action=booking&id=<?= (int)$b['court_id'] ?>"
                       style="padding:8px 16px; background:#f3f4f6; color:#444; border-radius:8px; text-decoration:none; font-size:0.85rem; font-weight:500; text-align:center;">
                        Đặt lại
                    </a>
                    <?php if ($canCancel): ?>
                        <a href="index.php?action=cancel_booking&id=<?= (int)$b['booking_id'] ?>"
                           onclick="return confirm('Bạn chắc chắn muốn hủy lịch này?')"
                           style="padding:8px 16px; background:#fee2e2; color:#b91c1c; border-radius:8px; text-decoration:none; font-size:0.85rem; font-weight:500; text-align:center;">
                            Hủy lịch
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>