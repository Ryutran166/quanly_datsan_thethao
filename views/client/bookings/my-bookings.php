<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
?>

<div style="max-width:900px; margin:0 auto; padding:24px 20px; font-family:'Inter',sans-serif;">

    <!-- Header -->
    <div style="margin-bottom:28px;">
        <h2 style="font-size:1.4rem; font-weight:700; margin:0 0 4px;">Lịch sử đặt sân</h2>
        <p style="color:#888; font-size:0.9rem; margin:0;">Quản lý các lịch đặt sân của bạn</p>
    </div>

    <!-- Thông báo -->
    <?php if (!empty($_GET['success'])): ?>
        <div style="background:#dcfce7; border-left:4px solid #16a34a; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; color:#15803d;">
            ✅ Hủy lịch thành công.
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
        <div style="background:#fee2e2; border-left:4px solid #dc2626; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:0.9rem; color:#b91c1c;">
            ⚠️ Không thể hủy lịch. Vui lòng thử lại.
        </div>
    <?php endif; ?>

    <!-- Danh sách trống -->
    <div style="text-align:center; padding:60px 20px; color:#aaa;">
        <i class="fas fa-calendar-times" style="font-size:2.5rem; margin-bottom:16px; display:block;"></i>
        <p style="font-size:0.95rem; margin:0;">Bạn chưa có lịch đặt sân nào.</p>
        <a href="/"
           style="display:inline-block; margin-top:16px; padding:10px 24px; background:#198754; color:#fff; border-radius:8px; text-decoration:none; font-size:0.9rem; font-weight:500;">
            Đặt sân ngay
        </a>
    </div>

</div>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>
