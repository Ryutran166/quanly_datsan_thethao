<?php require_once PROJECT_ROOT . '/views/layout/header.php'; ?>

<style>
body {
    background: #f4f6fb;
    font-family: 'Segoe UI', sans-serif;
}

.card-box {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.title {
    font-size: 26px;
    font-weight: 800;
    margin-bottom: 20px;
}

.form-control, .form-select {
    border-radius: 10px;
    padding: 12px;
}

.btn-save {
    background: #28a745;
    color: white;
    padding: 14px;
    border-radius: 12px;
    font-weight: 700;
    border: none;
    width: 100%;
    transition: 0.3s;
}

.btn-save:hover {
    background: #218838;
    transform: translateY(-2px);
}

.img-preview {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 12px;
    margin-top: 10px;
    display: none;
}
</style>

<div class="container py-5">

    <div class="card-box">

        <div class="title">➕ Thêm sân mới</div>

        <form action="index.php?action=add" method="POST">

            <!-- TÊN SÂN -->
            <div class="mb-3">
                <label class="form-label">Tên sân</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- GIÁ -->
            <div class="mb-3">
                <label class="form-label">Giá / giờ</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <!-- ĐỊA CHỈ -->
            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control">
            </div>

            <!-- ẢNH (LINK) -->
            <div class="mb-3">
                <label class="form-label">Link ảnh sân</label>
                <input type="text" name="image" class="form-control"
                       placeholder="https://images.unsplash.com/...">
            </div>

            <!-- PREVIEW -->
            <img id="preview" class="img-preview">

            <!-- STATUS -->
            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="available">Trống</option>
                    <option value="booked">Đã đặt</option>
                </select>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-save">
                💾 Lưu sân
            </button>

        </form>
    </div>
</div>

<script>
// preview ảnh
document.querySelector('input[name="image"]').addEventListener('input', function () {
    const img = document.getElementById('preview');
    if (this.value) {
        img.src = this.value;
        img.style.display = 'block';
    } else {
        img.style.display = 'none';
    }
});
</script>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>