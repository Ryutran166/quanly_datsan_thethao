<style>
    .court-edit-page {
        max-width: 500px;
        margin: 50px auto;
        font-family: 'Segoe UI', sans-serif;
    }

    .court-edit-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .court-edit-card h1 {
        margin-bottom: 20px;
    }

    .court-edit-card input,
    .court-edit-card select {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .court-edit-card button {
        width: 100%;
        padding: 12px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .court-edit-card button:hover {
        background: #218838;
    }

    .court-edit-card a {
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
        color: #007bff;
    }

    /* ═══════════════════════════════
   SERVICE MANAGE BOX
═══════════════════════════════ */

    .service-manage-box {
        margin-top: 18px;
        padding: 20px;
        border-radius: 18px;
        border: 1.5px solid #e2e8f0;
        background: linear-gradient(135deg,
                #ffffff 0%,
                #f8fffc 100%);
        transition: all .22s ease;
    }

    .service-manage-box:hover {
        border-color: rgba(0, 192, 127, .28);
        box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }

    .service-manage-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 18px;
    }

    .service-manage-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: rgba(0, 192, 127, .12);
        color: #00c07f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .service-manage-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .service-manage-desc {
        font-size: 13px;
        line-height: 1.6;
        color: #64748b;
    }

    .service-manage-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 13px;
        border-radius: 14px;
        background: linear-gradient(135deg,
                #00c07f 0%,
                #00a06a 100%);
        color: #fff !important;
        text-decoration: none;
        font-weight: 800;
        font-size: 14px;
        transition: all .2s ease;
        box-shadow: 0 6px 18px rgba(0, 192, 127, .25);
    }

    .service-manage-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 192, 127, .3);
    }

    .service-manage-btn i {
        font-size: 14px;
    }
</style>

<div class="court-edit-page">
    <div class="court-edit-card">
        <h1>Chỉnh sửa sân</h1>

        <form action="index.php?action=update" method="POST" enctype="multipart/form-data">


            <input type="hidden" name="id" value="<?= $court['id'] ?>">
            <input type="hidden" name="old_image" value="<?= $court['image'] ?>">

            <label>Tên sân</label>
            <input type="text" name="name"
                value="<?= htmlspecialchars($court['name']) ?>" required>

            <label>Giá (VNĐ / 30 phút)</label>
            <input type="number" name="price"
                value="<?= $court['price'] ?>" required>

            <label>Địa chỉ sân</label>
            <input type="text" name="address"
                value="<?= $court['address'] ?>" required>

            <!-- <label>Trạng thái</label>
                <select name="status">
                    <option value="available" <?= $court['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                    <option value="booked" <?= $court['status'] == 'booked' ? 'selected' : '' ?>>Booked</option>
                    <option value="maintenance" <?= $court['status'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                </select> -->

            <p>Ảnh hiện tại:</p>
            <img src="/quanly_datsan_thethao/public/upload/img_courts/<?= htmlspecialchars($court['image']) ?>"
                width="120" height="100">

            <label>Chọn ảnh mới</label>
            <input type="file" name="image">
            <!-- ═════════ QUẢN LÝ DỊCH VỤ ═════════ -->
            <div class="service-manage-box">

                <div class="service-manage-header">

                    <div class="service-manage-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>

                    <div>
                        <div class="service-manage-title">
                            Dịch vụ của sân
                        </div>

                        <div class="service-manage-desc">
                            Quản lý các dịch vụ đi kèm như
                        </div>
                    </div>

                </div>

                <a
                    href="index.php?action=owner_services&court_id=<?= (int)($court['id'] ?? 0) ?>"
                    class="service-manage-btn">

                    <i class="fas fa-cog"></i>
                    Quản lý dịch vụ

                </a>

            </div>


            <button type="submit">Lưu thay đổi</button>

        </form>

        <a href="index.php?action=index">← Quay về danh sách</a>
    </div>
</div>