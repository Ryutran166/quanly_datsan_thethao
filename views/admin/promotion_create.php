<style>
body{
    background:#1a1a1a;
    font-family: 'Inter', sans-serif;
}

.form-container{
    max-width:650px;
    margin:80px auto;
    background:#fff;
    padding:40px;
    border-radius:18px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
}

.form-title{
    text-align:center;
    font-size:22px;
    font-weight:700;
    margin-bottom:30px;
}

.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    font-weight:600;
    margin-bottom:6px;
    color:#333;
}

input, select, textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid #ddd;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:0.2s;
}

input:focus, textarea:focus, select:focus{
    border-color:#28a745;
    box-shadow:0 0 0 3px rgba(40,167,69,0.15);
}

textarea{
    min-height:100px;
    resize:none;
}

.row{
    display:flex;
    gap:12px;
}

.row .form-group{
    flex:1;
}

.btn-submit{
    width:100%;
    padding:14px;
    background:#28a745;
    border:none;
    color:#fff;
    font-size:16px;
    font-weight:700;
    border-radius:12px;
    cursor:pointer;
    transition:0.2s;
}

.btn-submit:hover{
    background:#219a3b;
}

.note{
    font-size:12px;
    color:#888;
    margin-top:4px;
}
</style>

<div class="form-container">

    <div class="form-title">🎁 TẠO VOUCHER / KHUYẾN MÃI</div>

    <form method="POST" action="index.php?action=store_promotion" enctype="multipart/form-data">

        <!-- TIÊU ĐỀ -->
        <div class="form-group">
            <label>Tiêu đề</label>
            <input type="text" name="tieu_de" required placeholder="VD: Giảm 20% đặt sân cuối tuần">
        </div>

        <!-- NỘI DUNG -->
        <div class="form-group">
            <label>Nội dung</label>
            <textarea name="noi_dung" placeholder="Mô tả chi tiết khuyến mãi..."></textarea>
        </div>

        <!-- CODE + % GIẢM -->
        <div class="row">
            <div class="form-group">
                <label>Mã voucher</label>
                <input type="text" name="code" required placeholder="VD: SPORT20">
                <div class="note">Mã khách hàng nhập khi đặt sân</div>
            </div>

            <div class="form-group">
                <label>Giảm (%)</label>
                <input type="number" name="giam_phan_tram" min="1" max="100" required placeholder="VD: 20">
            </div>
        </div>

        <!-- LOẠI -->
        <div class="form-group">
            <label>Loại voucher</label>
            <select name="loai" required>
                <option value="global">🌍 Toàn hệ thống</option>
                <option value="personal">👤 Cá nhân</option>
            </select>
        </div>

        <!-- THỜI GIAN -->
        <div class="col-md-6">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="ngay_bat_dau" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" name="ngay_ket_thuc" class="form-control" required>
        </div>

        <!-- HIỆU LỰC -->
        <div class="form-group">
            <label>Số ngày hiệu lực</label>
            <input type="number" name="so_ngay_hieu_luc" placeholder="VD: 7">
        </div>

        <!-- ẢNH -->
        <div class="form-group">
            <label>Hình ảnh</label>
            <input type="file" name="hinh_anh">
        </div>

        <!-- TRẠNG THÁI -->
        <div class="form-group">
            <label>Trạng thái</label>
            <select name="trang_thai">
                <option value="active">✅ Hoạt động</option>
                <option value="inactive">⛔ Ẩn</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">🚀 Tạo voucher</button>

    </form>
</div>

<script>
    const today = new Date().toISOString().split('T')[0];

    document.querySelectorAll('input[type="date"]').forEach(el => {
        el.min = today;
    });
</script>