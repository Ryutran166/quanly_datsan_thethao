<div style="min-height:60vh; display:flex; align-items:center; justify-content:center; padding:40px 20px; font-family:'Inter',sans-serif;">
    <div style="background:#fff; border-radius:16px; border:1px solid #eee; box-shadow:0 4px 20px rgba(0,0,0,0.06); padding:48px 40px; max-width:480px; width:100%; text-align:center;">

        <!-- Icon thành công -->
        <div style="width:72px; height:72px; border-radius:50%; background:#d1fae5; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h2 style="font-size:1.5rem; font-weight:700; color:#111; margin:0 0 8px;">Đặt sân thành công!</h2>
        <p style="color:#888; font-size:0.95rem; margin:0 0 32px;">Thông tin lịch đặt của bạn được xác nhận bên dưới.</p>

        <!-- Thông tin booking -->
        <div style="background:#f9fafb; border-radius:10px; padding:20px; text-align:left; margin-bottom:28px;">
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; font-size:0.9rem;">
                <span style="color:#888;">Sân</span>
                <strong><?= htmlspecialchars($court['name']) ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; font-size:0.9rem;">
                <span style="color:#888;">Ngày</span>
                <strong><?= date('d/m/Y', strtotime($date)) ?></strong>
            </div>
            <?php if ($slot): ?>
            <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; font-size:0.9rem;">
                <span style="color:#888;">Giờ</span>
                <strong><?= substr($slot['start_time'],0,5) ?> – <?= substr($slot['end_time'],0,5) ?></strong>
            </div>
            <?php endif; ?>
            <div style="display:flex; justify-content:space-between; padding:10px 0; font-size:0.9rem;">
                <span style="color:#888;">Tổng tiền</span>
                <strong style="color:#059669;"><?= number_format($court['price']) ?> VNĐ</strong>
            </div>
        </div>

        <!-- Nút hành động -->
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="index.php?action=booking&id=<?= (int)$court['id'] ?>"
               style="display:block; padding:12px; background:#198754; color:#fff; border-radius:10px; text-decoration:none; font-weight:600; font-size:0.95rem;">
                Đặt thêm khung giờ khác
            </a>
            <a href="index.php"
               style="display:block; padding:12px; background:#f3f4f6; color:#444; border-radius:10px; text-decoration:none; font-weight:500; font-size:0.95rem;">
                Về trang chủ
            </a>
        </div>

    </div>
</div>