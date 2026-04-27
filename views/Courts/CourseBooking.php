<form action="index.php?action=confirm_booking" method="POST">
    <input type="hidden" name="court_id" value="<?= $court['id'] ?>">
    <input type="hidden" name="booking_date" value="<?= $date ?? date('Y-m-d') ?>">
    <input type="hidden" name="slot_id" id="selected_slot_id" value="">

    <div class="booking-container" style="display: flex; gap: 20px; padding: 20px; font-family: 'Inter', sans-serif;">
        
        <div class="schedule-section" style="flex: 2; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <div class="filters" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <input type="date" name="display_date" value="<?= $date ?? date('Y-m-d') ?>" 
                       class="form-control" style="width: 200px;" onchange="window.location.href='index.php?action=booking&id=<?= $court['id'] ?>&date='+this.value">
                <div class="legend" style="font-size: 0.85rem; display: flex; gap: 15px;">
                    <span><i class="fa fa-square" style="color: #f8f9fa; border: 1px solid #ddd;"></i> Trống</span>
                    <span><i class="fa fa-lock" style="color: #e9ecef;"></i> Đã đặt</span>
                    <span><i class="fa fa-square" style="color: #198754;"></i> Đang chọn</span>
                </div>
            </div>

            <table class="table table-bordered text-center" style="vertical-align: middle;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 150px;">Khung giờ</th>
                        <?php foreach ($timeSlots as $slot): ?>
                            <th><?= substr($slot['start_time'], 0, 5) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($court['name']) ?></strong><br>
                            <small class="text-muted">Tiêu chuẩn</small>
                        </td>
                        <?php foreach ($timeSlots as $slot): ?>
                            <?php 
                                $isBooked = in_array($slot['id'], $bookedSlots); 
                                $class = $isBooked ? 'slot-booked' : 'slot-available';
                                $style = $isBooked ? 'background: #e9ecef; color: #adb5bd; cursor: not-allowed;' : 'cursor: pointer; transition: 0.2s;';
                            ?>
                            <td class="<?= $class ?>" 
                                style="<?= $style ?>"
                                data-slot-id="<?= $slot['id'] ?>"
                                data-time="<?= substr($slot['start_time'], 0, 5) ?> - <?= substr($slot['end_time'], 0, 5) ?>"
                                onclick="<?= !$isBooked ? "selectSlot(this)" : "" ?>">
                                <?php if ($isBooked): ?>
                                    <i class="fa fa-lock"></i>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="summary-section" style="flex: 1; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3 style="font-weight: 700; font-size: 1.4rem; margin-bottom: 20px;">Thông tin đặt sân</h3>
            
            <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span class="text-muted">Tên sân</span>
                <strong><?= htmlspecialchars($court['name']) ?></strong>
            </div>
            <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span class="text-muted">Ngày đặt</span>
                <strong><?= date('d/m/Y', strtotime($date ?? date('Y-m-d'))) ?></strong>
            </div>
            <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span class="text-muted">Giờ đã chọn</span>
                <strong id="display-time" class="text-success">Chưa chọn</strong>
            </div>
            <div class="info-row" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span class="text-muted">Đơn giá</span>
                <strong><?= number_format($court['price']) ?> VNĐ/giờ</strong>
            </div>

            <hr style="margin: 25px 0;">

            <div class="total-amount" style="background: #f0f9ff; padding: 20px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600;">Tổng cộng</span>
                <strong style="color: #198754; font-size: 1.4rem;" id="display-total">0 VNĐ</strong>
            </div>

            <button type="submit" id="btn-confirm" disabled class="btn btn-success w-100 mt-4 py-3" style="font-weight: bold; font-size: 1.1rem; border-radius: 10px;">
                Xác nhận đặt sân <i class="fas fa-chevron-right ms-2"></i>
            </button>

            <div style="margin-top: 25px; font-size: 0.85rem; color: #6c757d; background: #fff8f0; padding: 15px; border-radius: 8px; border-left: 4px solid #fd7e14;">
                <i class="fa fa-info-circle me-2"></i> Chính sách: Bạn có thể hủy lịch trước 12 tiếng để được hoàn tiền.
            </div>
        </div>
    </div>
</form>

<script>
function selectSlot(element) {
    // 1. Xóa lựa chọn cũ
    document.querySelectorAll('.slot-available').forEach(el => {
        el.style.background = 'white';
    });

    // 2. Đánh dấu ô đang chọn
    element.style.background = '#198754';
    
    // 3. Cập nhật dữ liệu vào Form và Summary
    const slotId = element.getAttribute('data-slot-id');
    const timeRange = element.getAttribute('data-time');
    
    document.getElementById('selected_slot_id').value = slotId;
    document.getElementById('display-time').innerText = timeRange;
    document.getElementById('display-total').innerText = '<?= number_format($court['price']) ?> VNĐ';
    
    // 4. Mở khóa nút xác nhận
    document.getElementById('btn-confirm').disabled = false;
}
</script>