<?php if (!empty($_GET['error'])): ?>
    <div class="booking-alert booking-alert--error">
        <i class="fas fa-exclamation-triangle"></i>
        <?php if ($_GET['error'] === 'slot_taken'): ?>
            Khung giờ này vừa được đặt bởi người khác. Vui lòng chọn giờ khác.
        <?php else: ?>
            Đã xảy ra lỗi. Vui lòng thử lại.
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (!empty($_GET['success'])): ?>
    <div class="booking-alert booking-alert--success">
        <i class="fas fa-check-circle"></i> Đặt sân thành công!
    </div>
<?php endif; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #00c07f;
        --primary-dark: #00a06a;
        --primary-soft: #e6faf3;
        --danger: #f43f5e;
        --danger-soft: #fff1f3;
        --dark: #0f172a;
        --mid: #475569;
        --muted: #94a3b8;
        --border: #e2e8f0;
        --surface: #ffffff;
        --page-bg: #f1f5f9;
    }

    .booking-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 36px 24px 60px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* ── Alerts ── */
    .booking-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        margin: 0 auto 20px;
        max-width: 1100px;
        padding-left: 24px;
        padding-right: 24px;
    }

    .booking-alert--error {
        background: var(--danger-soft);
        color: #be123c;
        border: 1.5px solid rgba(244, 63, 94, .2);
    }

    .booking-alert--success {
        background: var(--primary-soft);
        color: #065f46;
        border: 1.5px solid rgba(0, 192, 127, .25);
    }

    /* ── Layout ── */

    @media (max-width: 820px) {
        .booking-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ── Shared card ── */
    .bk-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 20px;
        padding: 28px;
    }

    /* ── Section title ── */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        margin: 0 0 14px;
    }

    /* ── Schedule header ── */
    .schedule-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 22px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .court-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--dark);
        margin: 0 0 4px;
    }

    .court-subtitle {
        font-size: 13px;
        color: var(--muted);
        margin: 0;
        font-weight: 500;
    }

    /* Date picker */
    .date-input {
        padding: 9px 13px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        background: var(--page-bg);
        outline: none;
        cursor: pointer;
        transition: border-color .2s, box-shadow .2s;
    }

    .date-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 192, 127, .1);
    }

    /* ── Legend ── */
    .legend {
        display: flex;
        gap: 18px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
    }

    .legend-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .legend-dot.free {
        background: #fff;
        border: 1.5px solid var(--border);
    }

    .legend-dot.chosen {
        background: var(--primary);
    }

    .legend-dot.taken {
        background: #e2e8f0;
    }

    /* ── Slot grid ── */
    .slot-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin-bottom: 28px;
    }

    @media (max-width: 560px) {
        .slot-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* ── Slot button ── */
    .slot-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 13px 6px;
        min-height: 76px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--surface);
        cursor: pointer;
        transition: background .18s, border-color .18s, transform .15s;
        font-family: inherit;
    }

    .slot-btn:not(:disabled):hover {
        border-color: var(--primary);
        background: var(--primary-soft);
        transform: translateY(-2px);
    }

    .slot-btn.selected {
        background: var(--primary);
        border-color: var(--primary-dark);
    }

    .slot-btn:disabled {
        background: var(--page-bg);
        border-color: #e9ecef;
        cursor: not-allowed;
        opacity: .7;
    }

    .slot-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--primary);
        transition: background .18s;
    }

    .slot-btn.selected .slot-dot {
        background: rgba(255, 255, 255, .7);
    }

    .slot-btn:disabled .slot-dot {
        background: #cbd5e1;
    }

    .slot-time {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
        transition: color .18s;
    }

    .slot-btn.selected .slot-time {
        color: #fff;
    }

    .slot-btn:disabled .slot-time {
        color: var(--muted);
    }

    .slot-end {
        font-size: 11px;
        font-weight: 500;
        color: var(--muted);
        transition: color .18s;
    }

    .slot-btn.selected .slot-end {
        color: rgba(255, 255, 255, .75);
    }

    .slot-btn:disabled .slot-end {
        color: #cbd5e1;
    }

    /* ── Divider between session groups ── */
    .session-divider {
        height: 1px;
        background: var(--border);
        margin: 4px 0 20px;
    }

    /* ═══════════════════════════════
       SUMMARY PANEL
    ═══════════════════════════════ */
    .summary-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--dark);
        margin: 0 0 22px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
    }

    .info-row:last-of-type {
        border-bottom: none;
    }

    .info-label {
        color: var(--muted);
        font-weight: 500;
    }

    .info-value {
        font-weight: 700;
        color: var(--dark);
        text-align: right;
    }

    .info-value.highlight {
        color: var(--primary);
    }

    /* Total box */
    .total-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary-soft);
        border: 1.5px solid rgba(0, 192, 127, .2);
        border-radius: 12px;
        padding: 16px 18px;
        margin: 20px 0;
    }

    .total-label {
        font-size: 14px;
        font-weight: 700;
        color: var(--dark);
    }

    .total-amount {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary);
        letter-spacing: -.5px;
    }

    /* Confirm button */
    .btn-confirm {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px;
        background: var(--primary);
        color: #fff;
        font-family: inherit;
        font-size: 15px;
        font-weight: 800;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 3px 10px rgba(0, 192, 127, .3);
    }

    .btn-confirm:not(:disabled):hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(0, 192, 127, .35);
    }

    .btn-confirm:disabled {
        background: #e2e8f0;
        color: var(--muted);
        box-shadow: none;
        cursor: not-allowed;
    }

    /* Policy note */
    .policy-note {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        margin-top: 16px;
        padding: 13px 15px;
        background: #fff8f0;
        border: 1.5px solid rgba(253, 126, 20, .2);
        border-radius: 12px;
        font-size: 12px;
        color: #92400e;
        line-height: 1.55;
    }

    /* Giao diện Bảng lịch trình mới */
    .booking-table-container {
        width: 100%;
        overflow-x: auto;
        /* Cuộn ngang trên mobile */
        background: var(--surface);
        border-radius: 16px;
        border: 1px solid var(--border);
    }

    .booking-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
        /* Đảm bảo bảng không bị quá hẹp */
    }

    .booking-table th,
    .booking-table td {
        border: 1px solid #f0f2f5;
        padding: 12px 8px;
        text-align: center;
    }

    .booking-table thead th {
        background: #f8fafc;
        color: var(--mid);
        font-size: 13px;
        font-weight: 700;
    }

    .court-col {
        width: 150px;
        background: #f8fafc;
        text-align: left !important;
        padding-left: 20px !important;
    }

    .court-name {
        font-weight: 700;
        color: var(--dark);
        display: block;
    }

    .court-type {
        font-size: 10px;
        text-transform: uppercase;
        color: var(--primary);
        font-weight: 800;
    }

    /* Các ô slot trong bảng */
    .cell-slot {
        width: 100px;
        height: 50px;
        padding: 4px !important;
    }

    .slot-item {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: #fff;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slot-item:hover:not(.booked) {
        border-color: var(--primary);
        background: var(--primary-soft);
    }

    .slot-item.booked {
        background: #e2e8f0;
        cursor: not-allowed;
        border: none;
    }

    .slot-item.booked i {
        color: #94a3b8;
        font-size: 12px;
    }

    .slot-item.selected {
        background: var(--primary) !important;
        border-color: var(--primary-dark) !important;
    }
</style>

<div class="booking-page">

    <form action="index.php?action=check_booking" method="POST">

        <input type="hidden" name="court_id" value="<?= (int)$court['id'] ?>">
        <input type="hidden" name="booking_date" value="<?= htmlspecialchars($date) ?>">
        <input type="hidden" name="slot_id" id="selected_slot_ids" value="">
        <input type="hidden" name="payment_method" id="payment_method" value="cash">
        <input type="hidden" name="selected_service_ids" id="selected_service_ids" value="">

        <!-- Services data (for JS total/service ids) -->
        <?php
            // $services is provided by CourtsController::booking()
            // Keep a map of id => price for total/service calculation.
        ?>
        <?php foreach (($services ?? []) as $sv): ?>
            <input type="hidden" class="svc-price" data-sid="<?= (int)($sv['id'] ?? 0) ?>" value="<?= (float)($sv['price'] ?? 0) ?>">
        <?php endforeach; ?>


        <div class="booking-layout">

            <!-- ══ LEFT: Slot picker ══ -->
            <div class="bk-card">

                <div class="schedule-header">
                    <div>
                        <h2 class="court-title"><?= htmlspecialchars($court['name']) ?></h2>
                        <p class="court-subtitle">Chọn khung giờ phù hợp</p>
                    </div>

                    <input type="date"
                        name="display_date"
                        value="<?= htmlspecialchars($date) ?>"
                        class="date-input"
                        min="<?= date('Y-m-d') ?>"
                        onchange="window.location.href='index.php?action=booking&id=<?= (int)$court['id'] ?>&date='+this.value">
                </div>

                <!-- Legend -->
                <div class="legend">
                    <div class="legend-item"><span class="legend-dot free"></span> Còn trống</div>
                    <div class="legend-item"><span class="legend-dot chosen"></span> Đang chọn</div>
                    <div class="legend-item"><span class="legend-dot taken"></span> Đã đặt</div>
                </div>

                <div class="booking-table-container">
                    <table class="booking-table">

                        <!-- HEADER -->
                        <thead>
                            <tr>
                                <th class="court-col">Sân / Giờ</th>
                                <?php foreach ($timeSlots as $slot): ?>
                                    <th><?= substr($slot['start_time'], 0, 5) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>

                        <!-- BODY -->
                        <tbody>
                            <tr>
                                <!-- TÊN SÂN -->
                                <td class="court-col">
                                    <span class="court-name"><?= htmlspecialchars($court['name']) ?></span>
                                    <span class="court-type">Sân thể thao</span>
                                </td>

                                <!-- SLOT -->
                                <?php foreach ($timeSlots as $slot):
                                    $isBooked = in_array($slot['id'], $bookedSlots);
                                ?>
                                    <td class="cell-slot">
                                        <div class="slot-item <?= $isBooked ? 'booked' : '' ?>"
                                            <?= $isBooked ? '' : "onclick=\"selectSlot(this)\"" ?>
                                            data-slot-id="<?= $slot['id'] ?>"
                                            data-time="<?= substr($slot['start_time'], 0, 5) ?> - <?= substr($slot['end_time'], 0, 5) ?>">

                                            <?php if ($isBooked): ?>
                                                <i class="fas fa-times"></i>
                                            <?php else: ?>
                                                <i class="fas fa-check"></i>
                                            <?php endif; ?>

                                        </div>
                                    </td>
                                <?php endforeach; ?>

                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>

            <!-- ══ RIGHT: Summary ══ -->
            <div class="bk-card">

                <h3 class="summary-title">Thông tin đặt sân</h3>

                <div class="info-row">
                    <span class="info-label">Tên sân</span>
                    <span class="info-value"><?= htmlspecialchars($court['name']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ngày đặt</span>
                    <span class="info-value"><?= date('d/m/Y', strtotime($date)) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Giờ chơi</span>
                    <span class="info-value highlight" id="display-time">Chưa chọn</span>
                </div>
                <div class="total-box">
                    <span class="total-label">Tổng cộng</span>
                    <span class="total-amount" id="display-total">— VNĐ</span>
                </div>

                <!-- Payment method -->
                <div style="margin-top:14px;">
                    <div class="section-label" style="margin:0 0 10px;">Phương thức thanh toán</div>

                    <label style="display:flex; align-items:center; gap:10px; padding:12px 14px; border:1.5px solid var(--border); border-radius:12px; background:var(--surface); cursor:pointer; margin-bottom:10px;">
                        <input type="radio" name="payment_method_radio" value="cash" checked style="width:18px; height:18px; accent-color: var(--primary);">
                        <span style="font-weight:800; color:var(--dark);">Thanh toán trực tiếp</span>
                    </label>

                    <label style="display:flex; align-items:center; gap:10px; padding:12px 14px; border:1.5px solid var(--border); border-radius:12px; background:var(--surface); cursor:pointer;">
                        <input type="radio" name="payment_method_radio" value="qr" style="width:18px; height:18px; accent-color: var(--primary);">
                        <span style="font-weight:800; color:var(--dark);">Chuyển khoản bằng QR</span>
                    </label>

                    <div id="qr-box" style="display:none; margin-top:12px; padding:14px; border:1.5px dashed rgba(0,192,127,.35); border-radius:12px; background:#f6fffb;">
                        <div style="font-weight:800; color:#065f46; margin-bottom:8px;">Quét mã để chuyển khoản</div>
                        <div id="qrPreviewWrap" style="width:180px; height:180px; margin:0 auto; background:#fff; border:1px solid #e5e7eb; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#64748b; font-weight:700; text-align:center; padding:14px; line-height:1.45;">
                            Chọn khung giờ để tạo QR.
                        </div>
                        <div id="qrError" style="display:none; text-align:center; margin-top:10px; color:#be123c; font-size:12px; font-weight:800;">
                            Owner chưa cấu hình ảnh QR.

                        </div>
                        <div style="text-align:center; margin-top:10px; color:#64748b; font-size:12px; font-weight:700;">
                            Hãy đưa hình ảnh thanh toán thành công của bạn khi đến sân chơi nhé
                        </div>
                    </div>
                </div>

                <!-- Services (dịch vụ) -->
                <?php if (!empty($services ?? [])): ?>
                    <div style="margin-top:18px;">
                        <div class="section-label" style="margin:0 0 10px;">Chọn dịch vụ</div>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <?php foreach ($services as $sv):
                                $sid = (int)($sv['id'] ?? 0);
                                $sPrice = (float)($sv['price'] ?? 0);
                                $checked = false;
                            ?>
                                <label style="display:flex; align-items:flex-start; gap:10px; padding:12px 14px; border:1.5px solid var(--border); border-radius:12px; background:var(--surface); cursor:pointer;">
                                    <input type="checkbox" class="svc-checkbox" value="<?= $sid ?>" data-service-price="<?= $sPrice ?>" style="margin-top:3px; accent-color: var(--primary);">
                                    <div style="flex:1;">
                                        <div style="font-weight:900; color:var(--dark); font-size:13px;">
                                            <?= htmlspecialchars((string)($sv['service_name'] ?? '')) ?>
                                        </div>
                                        <div style="font-weight:800; color:var(--mid); font-size:12px; margin-top:4px;">
                                            + <?= number_format($sPrice, 0, '.', ',') ?> VNĐ
                                        </div>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <button type="submit" id="btn-confirm" class="btn-confirm" disabled>
                    <i class="fas fa-check"></i> Xác nhận đặt sân
                </button>


                <div class="policy-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Bạn có thể hủy lịch trước <strong>12 tiếng</strong> để được hoàn tiền đầy đủ.</span>
                </div>

            </div>

        </div>

    </form>
</div>

<script>
    const PRICE = <?= (int)$court['price'] ?>;

    let selectedSlots = [];

    function selectSlot(btn) {

        const slotId = btn.dataset.slotId;
        const slotTime = btn.dataset.time;

        // Nếu đã chọn -> bỏ chọn
        if (selectedSlots.find(slot => slot.id === slotId)) {

            selectedSlots = selectedSlots.filter(slot => slot.id !== slotId);

            btn.classList.remove('selected');

        } else {

            // Thêm slot mới
            selectedSlots.push({
                id: slotId,
                time: slotTime
            });

            btn.classList.add('selected');
        }

        // Cập nhật hidden input
        document.getElementById('selected_slot_ids').value =
            selectedSlots.map(slot => slot.id).join(',');

        // Hiển thị thời gian
        if (selectedSlots.length > 0) {

            document.getElementById('display-time').innerText =
                selectedSlots.map(slot => slot.time).join(', ');

        } else {

            document.getElementById('display-time').innerText = 'Chưa chọn';
        }

        // Tổng tiền
        // Tổng tiền: sân + dịch vụ đã chọn
        let servicesTotal = 0;
        document.querySelectorAll('.svc-checkbox:checked').forEach(chk => {
            const pv = parseFloat(chk.dataset.servicePrice || '0');
            if (!isNaN(pv)) servicesTotal += pv;
        });

        const courtTotal = PRICE * selectedSlots.length;
        const total = courtTotal + servicesTotal;

        document.getElementById('display-total').innerText =
            total.toLocaleString('vi-VN') + ' VNĐ';

        // Disable nút nếu chưa chọn slot
        document.getElementById('btn-confirm').disabled =
            selectedSlots.length === 0;

        renderVietQrImageIfNeeded();

    }
    // Payment toggle
    const paymentMethodInput = document.getElementById('payment_method');
    const qrBox = document.getElementById('qr-box');
    let qrRequestSeq = 0;

    // Khi user chọn slot (tổng tiền thay đổi) và đang chọn QR => cập nhật VietQR
    document.addEventListener('DOMContentLoaded', () => {
        // debug
        // console.log('PRICE', PRICE);
    });

    function syncPaymentUI(method) {
        paymentMethodInput.value = method;
        if (method === 'qr') {
            qrBox.style.display = 'block';
        } else {
            qrBox.style.display = 'none';
        }
    }

    // Services selection -> fill hidden input selected_service_ids
    function syncSelectedServicesIds() {
        const hidden = document.getElementById('selected_service_ids');
        if (!hidden) return;

        const checks = document.querySelectorAll('.svc-checkbox');
        const ids = [];
        checks.forEach(chk => {
            if (chk.checked) {
                ids.push(String(chk.value));
            }
        });

        hidden.value = ids.join(',');

        // Update total price shown (court price + services price)
        const selectedServicePrices = [];
        // svc-price hidden inputs keep id=>price
        const priceNodes = document.querySelectorAll('.svc-price');
        const priceById = {};
        priceNodes.forEach(n => {
            const sid = String(n.dataset.sid || '');
            const pv = parseFloat(n.value || '0');
            if (sid) priceById[sid] = pv;
        });

        const servicesTotal = ids.reduce((sum, sid) => sum + (priceById[sid] || 0), 0);
        const courtTotal = PRICE * selectedSlots.length;
        const grandTotal = courtTotal + servicesTotal;

        const totalEl = document.getElementById('display-total');
        if (totalEl) {
            totalEl.innerText = grandTotal.toLocaleString('vi-VN') + ' VNĐ';
        }
    }

    document.querySelectorAll('.svc-checkbox').forEach(chk => {
        chk.addEventListener('change', () => {
            syncSelectedServicesIds();
            renderVietQrImageIfNeeded();
        });
    });

    document.querySelectorAll('input[name="payment_method_radio"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            syncPaymentUI(e.target.value);
        });
    });

    function showError(msg) {
        const err = document.getElementById('qrError');
        if (!err) return;
        if (msg) err.textContent = msg;
        err.style.display = 'block';
    }

    function hideError() {
        const err = document.getElementById('qrError');
        if (!err) return;
        err.style.display = 'none';
    }

    function getSelectedServiceIds() {
        return Array.from(document.querySelectorAll('.svc-checkbox:checked')).map(chk => chk.value);
    }

    async function renderVietQrImageIfNeeded() {
        if (paymentMethodInput.value !== 'qr') return;
        const previewWrap = document.getElementById('qrPreviewWrap');
        if (!previewWrap) return;
        hideError();

        if (selectedSlots.length === 0) {
            previewWrap.textContent = 'Chọn khung giờ để tạo QR.';
            return;
        }

        const currentSeq = ++qrRequestSeq;
        previewWrap.textContent = 'Đang tạo QR...';

        try {
            const params = new URLSearchParams({
                action: 'get_vietqr_image',
                court_id: '<?= (int)$court['id'] ?>',
                slot_ids: selectedSlots.map(slot => slot.id).join(','),
                service_ids: getSelectedServiceIds().join(','),
                description: 'DAT SAN <?= (int)$court['id'] ?>'
            });

            const res = await fetch('index.php?' + params.toString(), { method: 'GET' });
            const data = await res.json();

            if (currentSeq !== qrRequestSeq) return;

            if (!data || data.success === false || !data.qr_image) {
                throw new Error(data?.error || 'Không tạo được QR');
            }

            previewWrap.innerHTML = '';
            const img = document.createElement('img');
            img.src = data.qr_image + '&_=' + Date.now();
            img.alt = 'VietQR thanh toán';
            img.style.width = '160px';
            img.style.height = '160px';
            img.style.objectFit = 'contain';
            previewWrap.appendChild(img);
        } catch (err) {
            if (currentSeq !== qrRequestSeq) return;
            previewWrap.textContent = '';
            showError('Không tạo được VietQR. Vui lòng kiểm tra cấu hình ngân hàng.');
        }
    }

    function attachPaymentListener() {
        document.querySelectorAll('input[name="payment_method_radio"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                syncPaymentUI(e.target.value);
                renderVietQrImageIfNeeded();
            });
        });
    }

    attachPaymentListener();
    syncPaymentUI(paymentMethodInput.value);

    if (paymentMethodInput.value === 'qr') {
        renderVietQrImageIfNeeded();
    }
</script>


