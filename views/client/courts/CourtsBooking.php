<?php if (!empty($_GET['error'])): ?>
    <div class="alert alert-danger" style="margin: 15px 20px;">
        <?php if ($_GET['error'] === 'slot_taken'): ?>
            ⚠️ Khung giờ này vừa được đặt bởi người khác. Vui lòng chọn giờ khác.
        <?php else: ?>
            ⚠️ Đã xảy ra lỗi. Vui lòng thử lại.
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (!empty($_GET['success'])): ?>
    <div class="alert alert-success" style="margin: 15px 20px;">
        ✅ Đặt sân thành công!
    </div>
<?php endif; ?>

<form action="index.php?action=confirm_booking" method="POST">

    <!-- ✅ Hidden fields để gửi dữ liệu -->
    <input type="hidden" name="court_id"     value="<?= (int)$court['id'] ?>">
    <input type="hidden" name="booking_date" value="<?= htmlspecialchars($date) ?>">
    <input type="hidden" name="slot_id"      id="selected_slot_id" value="">

    <div class="booking-container" style="display:flex; gap:20px; padding:20px; font-family:'Inter',sans-serif;">

        <!-- ===== BẢNG CHỌN GIỜ ===== -->
       <!-- ===== BẢNG CHỌN GIỜ ===== -->
<div class="schedule-section" style="flex:2; background:#fff; padding:24px; border-radius:12px; border:1px solid #eee; box-shadow:0 2px 8px rgba(0,0,0,0.04);">

    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
        <div>
            <p style="margin:0; font-size:15px; font-weight:600;"><?= htmlspecialchars($court['name']) ?></p>
            <p style="margin:0; font-size:13px; color:#888;">Chọn khung giờ phù hợp</p>
        </div>
        <input type="date" name="display_date" value="<?= htmlspecialchars($date) ?>"
               class="form-control" style="width:160px; font-size:13px;"
               min="<?= date('Y-m-d') ?>"
               onchange="window.location.href='index.php?action=booking&id=<?= (int)$court['id'] ?>&date='+this.value">
    </div>

    <!-- Legend -->
    <div style="display:flex; gap:16px; font-size:12px; color:#888; margin-bottom:20px;">
        <span style="display:flex; align-items:center; gap:5px;">
            <span style="width:10px;height:10px;border-radius:50%;background:#fff;border:1px solid #ccc;display:inline-block;"></span> Trống
        </span>
        <span style="display:flex; align-items:center; gap:5px;">
            <span style="width:10px;height:10px;border-radius:50%;background:#198754;display:inline-block;"></span> Đang chọn
        </span>
        <span style="display:flex; align-items:center; gap:5px;">
            <span style="width:10px;height:10px;border-radius:50%;background:#e9ecef;display:inline-block;"></span> Đã đặt
        </span>
    </div>

    <!-- Nhóm: Buổi sáng -->
    <p style="font-size:11px; font-weight:600; color:#aaa; letter-spacing:0.07em; text-transform:uppercase; margin:0 0 10px;">Buổi sáng</p>
    <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:10px; margin-bottom:24px;">
        <?php foreach ($timeSlots as $slot):
            if ($slot['start_time'] >= '12:00:00') continue;
            $isBooked = in_array($slot['id'], $bookedSlots);
        ?>
        <button type="button"
            class="<?= $isBooked ? 'slot-booked' : 'slot-available' ?>"
            style="display:flex;flex-direction:column;align-items:center;justify-content:center;
                   padding:12px 6px;border-radius:8px;border:1px solid <?= $isBooked ? '#e9ecef' : '#ddd' ?>;
                   background:<?= $isBooked ? '#f8f9fa' : '#fff' ?>;
                   cursor:<?= $isBooked ? 'not-allowed' : 'pointer' ?>;
                   min-height:72px; gap:4px; transition:all 0.15s;"
            <?= !$isBooked ? "data-slot-id=\"{$slot['id']}\" data-time=\"" . substr($slot['start_time'],0,5) . " - " . substr($slot['end_time'],0,5) . "\" onclick=\"selectSlot(this)\"" : "disabled" ?>>
            <span style="width:6px;height:6px;border-radius:50%;background:<?= $isBooked ? '#ccc' : '#198754' ?>;display:block;"></span>
            <span style="font-size:14px;font-weight:600;color:<?= $isBooked ? '#adb5bd' : '#212529' ?>;"><?= substr($slot['start_time'],0,5) ?></span>
            <span style="font-size:11px;color:<?= $isBooked ? '#ccc' : '#888' ?>;">– <?= substr($slot['end_time'],0,5) ?></span>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- Nhóm: Buổi chiều -->
    <p style="font-size:11px; font-weight:600; color:#aaa; letter-spacing:0.07em; text-transform:uppercase; margin:0 0 10px;">Buổi chiều</p>
    <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:10px;">
        <?php foreach ($timeSlots as $slot):
            if ($slot['start_time'] < '12:00:00') continue;
            $isBooked = in_array($slot['id'], $bookedSlots);
        ?>
        <button type="button"
            class="<?= $isBooked ? 'slot-booked' : 'slot-available' ?>"
            style="display:flex;flex-direction:column;align-items:center;justify-content:center;
                   padding:12px 6px;border-radius:8px;border:1px solid <?= $isBooked ? '#e9ecef' : '#ddd' ?>;
                   background:<?= $isBooked ? '#f8f9fa' : '#fff' ?>;
                   cursor:<?= $isBooked ? 'not-allowed' : 'pointer' ?>;
                   min-height:72px; gap:4px; transition:all 0.15s;"
            <?= !$isBooked ? "data-slot-id=\"{$slot['id']}\" data-time=\"" . substr($slot['start_time'],0,5) . " - " . substr($slot['end_time'],0,5) . "\" onclick=\"selectSlot(this)\"" : "disabled" ?>>
            <span style="width:6px;height:6px;border-radius:50%;background:<?= $isBooked ? '#ccc' : '#198754' ?>;display:block;"></span>
            <span style="font-size:14px;font-weight:600;color:<?= $isBooked ? '#adb5bd' : '#212529' ?>;"><?= substr($slot['start_time'],0,5) ?></span>
            <span style="font-size:11px;color:<?= $isBooked ? '#ccc' : '#888' ?>;">– <?= substr($slot['end_time'],0,5) ?></span>
        </button>
        <?php endforeach; ?>
    </div>
</div>

        <!-- ===== SUMMARY ===== -->
        <div class="summary-section" style="flex:1; background:#fff; padding:25px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.05); border:1px solid #eee;">
            <h3 style="font-weight:700; font-size:1.3rem; margin-bottom:20px;">Thông tin đặt sân</h3>

            <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                <span class="text-muted">Tên sân</span>
                <strong><?= htmlspecialchars($court['name']) ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                <span class="text-muted">Ngày đặt</span>
                <strong><?= date('d/m/Y', strtotime($date)) ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                <span class="text-muted">Giờ đã chọn</span>
                <strong id="display-time" class="text-success">Chưa chọn</strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                <span class="text-muted">Đơn giá</span>
                <strong><?= number_format($court['price']) ?> VNĐ/giờ</strong>
            </div>

            <hr style="margin:20px 0;">

            <div style="background:#f0f9ff; padding:18px; border-radius:10px; display:flex; justify-content:space-between; align-items:center;">
                <span style="font-weight:600;">Tổng cộng</span>
                <strong id="display-total" style="color:#198754; font-size:1.3rem;">0 VNĐ</strong>
            </div>

            <button type="submit" id="btn-confirm" disabled
                    class="btn btn-success"
                    style="width:100%; margin-top:1rem; padding:12px 0; font-weight:bold;  font-size:1.05rem; border-radius:10px; background: blue; color: white; outline:none;border:none;">
                Xác nhận đặt sân
            </button>

            <div style="margin-top:20px; font-size:0.85rem; color:#6c757d; background:#fff8f0; padding:14px; border-radius:8px; border-left:4px solid #fd7e14;">
                <i class="fa fa-info-circle me-2"></i>
                Chính sách: Bạn có thể hủy lịch trước 12 tiếng để được hoàn tiền.
            </div>
        </div>
    </div>
</form>

<script>
const PRICE = <?= (int)$court['price'] ?>;
let selectedBtn = null;

function selectSlot(btn) {
    if (selectedBtn) {
        selectedBtn.style.background = '#fff';
        selectedBtn.style.borderColor = '#ddd';
        selectedBtn.style.color = '#212529';
        selectedBtn.querySelectorAll('span')[0].style.background = '#198754'; // dot
        selectedBtn.querySelectorAll('span')[1].style.color = '#212529';
        selectedBtn.querySelectorAll('span')[2].style.color = '#888';
    }
    btn.style.background = '#198754';
    btn.style.borderColor = '#157347';
    btn.querySelectorAll('span')[0].style.background = '#fff';
    btn.querySelectorAll('span')[1].style.color = '#fff';
    btn.querySelectorAll('span')[2].style.color = '#c8f0e3';
    selectedBtn = btn;

    document.getElementById('selected_slot_id').value = btn.getAttribute('data-slot-id');
    document.getElementById('display-time').innerText  = btn.getAttribute('data-time');
    document.getElementById('display-total').innerText = PRICE.toLocaleString('vi-VN') + ' VNĐ';
    document.getElementById('btn-confirm').disabled = false;
}
</script>