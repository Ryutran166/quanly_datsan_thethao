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
            <?php if (!empty($slots)): ?>
                <div style="padding:10px 0; border-bottom:1px solid #eee; font-size:0.9rem;">

                    <div style="margin-bottom:10px; color:#888;">
                        Khung giờ đã đặt
                    </div>

                    <?php foreach ($slots as $slot): ?>
                        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:8px 12px;
            margin-bottom:8px;
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:8px;
        ">
                            <span style="color:#444;">
                                <?= substr($slot['start_time'], 0, 5) ?>
                                -
                                <?= substr($slot['end_time'], 0, 5) ?>
                            </span>

                            <span style="
                background:#d1fae5;
                color:#059669;
                padding:4px 10px;
                border-radius:999px;
                font-size:12px;
                font-weight:600;
            ">
                                Đã xác nhận
                            </span>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>

            <?php
                $pm = $_GET['payment_method'] ?? 'cash';

                $courtPrice = (float)($court['price'] ?? 0);
                $slotsCount = (!empty($slots) ? count($slots) : 0);

                // Fallback: court price * slot count (nếu không truy được booking trong DB)
                $total = (!empty($court) ? (int)round($courtPrice * $slotsCount) : 0);

                // Lấy total_amount (đã bao gồm: tiền sân + tổng giá dịch vụ)
                // từ DB để đảm bảo luôn đúng khi user chọn dịch vụ.
                $pdo = \Nhom2\QuanlyDatsanThethao\Database::getInstance()->getConnection();

                $slotIdsForQuery = array_map('intval', array_column((array)$slots, 'id'));
                if (!empty($slotIdsForQuery)) {
                    $slotIn = implode(',', array_fill(0, count($slotIdsForQuery), '?'));

                    if (empty($bookingId ?? 0)) {
                        // Lấy booking_id phù hợp nhất (đủ các slot)
                        $stmtBooking = $pdo->prepare(
                            "SELECT bd.booking_id
                             FROM booking_details bd
                             JOIN bookings b ON b.id = bd.booking_id
                             WHERE b.court_id = ? AND b.booking_date = ?
                               AND bd.slot_id IN ($slotIn)
                             GROUP BY bd.booking_id
                             HAVING COUNT(DISTINCT bd.slot_id) = ?
                             LIMIT 1"
                        );

                        $params = array_merge([(int)($court['id'] ?? 0), (string)$date], $slotIdsForQuery);
                        $stmtBooking->execute(array_merge($params, [count($slotIdsForQuery)]));
                        $bookingRow = $stmtBooking->fetch(PDO::FETCH_ASSOC);
                        $bookingId = (int)($bookingRow['booking_id'] ?? 0);
                    }

                    if ($bookingId > 0) {
                        $stmtTotals = $pdo->prepare(
                            "SELECT COALESCE(total_amount, 0) AS total
                             FROM bookings
                             WHERE id = ?"
                        );
                        $stmtTotals->execute([$bookingId]);
                        $dbTotal = (float)($stmtTotals->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

                        if ($dbTotal > 0) {
                            $total = (int)round($dbTotal);
                        }
                    }
                }
            ?>

            <div style="display:flex; justify-content:space-between; padding:10px 0; font-size:0.9rem;">
                <span style="color:#888;">Tổng tiền</span>
                <strong style="color:#059669;"><?= number_format((float)$total, 0, ',', '.') ?> VNĐ</strong>
            </div>


            <div style="display:flex; justify-content:space-between; padding:10px 0; font-size:0.9rem;">
                <span style="color:#888;">Phương thức thanh toán</span>
                <strong style="color:#111;">
                    <?= ($pm === 'qr') ? 'Chuyển khoản bằng QR' : 'Thanh toán trực tiếp'; ?>
                </strong>
            </div>

            <!-- <?php if ($pm === 'qr' && !empty($bookingId ?? 0)): ?>
                <div style="padding:14px 0 4px; border-top:1px solid #eee; text-align:center;">
                    <div style="font-weight:700; color:#111; margin-bottom:10px;">Quét mã để thanh toán</div>
                    <div id="savedVietQrWrap" style="width:190px; height:190px; margin:0 auto; border:1px solid #e5e7eb; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#888; font-size:13px;">
                        Đang tạo QR...
                    </div>
                    <div id="savedVietQrError" style="display:none; color:#be123c; font-size:12px; font-weight:700; margin-top:10px;"></div>
                </div>
            <?php endif; ?>
 -->


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

<!-- <?php if ($pm === 'qr' && !empty($bookingId ?? 0)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const wrap = document.getElementById('savedVietQrWrap');
            const error = document.getElementById('savedVietQrError');
            if (!wrap) return;

            try {
                const url = 'index.php?' + new URLSearchParams({
                    action: 'get_vietqr_image',
                    booking_id: '<?= (int)$bookingId ?>',
                    court_id: '<?= (int)($court['id'] ?? 0) ?>',
                    description: 'BOOKING<?= (int)$bookingId ?>'
                }).toString();
                const res = await fetch(url);
                const data = await res.json();

                if (!data || data.success === false || !data.qr_image) {
                    throw new Error(data?.error || 'Không tạo được QR');
                }

                // wrap.innerHTML = '';
                // const img = document.createElement('img');
                // // img.src = data.qr_image + '&_=' + Date.now();
                // // img.alt = 'VietQR thanh toán';
                // img.style.width = '170px';
                // img.style.height = '170px';
                // img.style.objectFit = 'contain';
                // wrap.appendChild(img);
            } catch (err) {
                wrap.textContent = '';
                if (error) {
                    error.textContent = 'Không tạo được VietQR. Vui lòng kiểm tra cấu hình ngân hàng.';
                    error.style.display = 'block';
                }
            }
        });
    </script>
<?php endif; ?> -->
