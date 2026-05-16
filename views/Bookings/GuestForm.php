
<style>
/* Container chính */
.booking-container {
    max-width: 450px;
    margin: 40px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.booking-container h2 {
    text-align: center;
    color: #2d3436;
    margin-bottom: 25px;
    font-size: 1.5rem;
}

/* Group từng hàng */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #636e72;
    font-size: 0.9rem;
}

/* Style cho Input */
.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #dfe6e9;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-sizing: border-box; /* Đảm bảo padding không làm tràn khung */
}

.form-group input:focus {
    outline: none;
    border-color: #00b894; /* Màu xanh lá (hợp với sân cỏ/thể thao) */
    box-shadow: 0 0 8px rgba(0, 184, 148, 0.2);
}

/* Nút bấm */
.btn-submit {
    width: 100%;
    padding: 14px;
    background-color: #00b894;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s transform 0.2s;
    margin-top: 10px;
}

.btn-submit:hover {
    background-color: #009475;
    transform: translateY(-1px);
}

.btn-submit:active {
    transform: translateY(1px);
}
</style>
<div class="booking-container">
    <h2>Nhập thông tin đặt sân</h2>
    
    <form action="index.php?action=confirm_booking" method="POST" class="booking-form">
        <!-- Các input ẩn giữ nguyên -->
        <input type="hidden" name="court_id" value="<?= $courtId ?>">
        <input type="hidden" name="slot_id" value="<?= htmlspecialchars($slotIds) ?>">
        <input type="hidden" name="booking_date" value="<?= $date ?>">
        <input type="hidden" name="selected_service_ids" value="<?= htmlspecialchars((string)($selectedServiceIds ?? '')) ?>">
        <input type="hidden" name="payment_method" value="<?= htmlspecialchars((string)($paymentMethod ?? 'cash')) ?>">

        <div class="form-group">
            <label for="customer_name">Họ và tên</label>
            <input type="text" id="customer_name" name="customer_name" placeholder="Họ tên" required>
        </div>

        <div class="form-group">
            <label for="customer_phone">Số điện thoại</label>
            <input type="tel" id="customer_phone" name="customer_phone" placeholder="Nhập số điện thoại để liên lạc" required>
        </div>

        <button type="submit" class="btn-submit">Xác nhận đặt sân ngay</button>
    </form>
</div>
