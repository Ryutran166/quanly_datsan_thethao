<?php
/** @var int $courtId */
$action = 'owner_service_store';
$courtId = (int)($_GET['court_id'] ?? 0);
?>

<div style="max-width: 900px; margin: 0 auto; padding: 18px 0;">
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:16px;">
        <h2 style="margin:0 0 14px; font-size:20px;">Thêm dịch vụ</h2>

        <form method="POST" action="index.php?action=owner_service_store">
            <input type="hidden" name="court_id" value="<?= (int)$courtId ?>">

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                <div style="grid-column: 1 / -1;">
                    <label style="display:block; font-size:12px; color:#64748b; margin-bottom:6px; font-weight:800;">Tên dịch vụ</label>
                    <input type="text" name="service_name" required
                           style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e2e8f0;" />
                </div>

                <div>
                    <label style="display:block; font-size:12px; color:#64748b; margin-bottom:6px; font-weight:800;">Giá</label>
                    <input type="number" step="0.01" name="price" required min="0"
                           style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e2e8f0;" />
                </div>

                <div>
                    <label style="display:block; font-size:12px; color:#64748b; margin-bottom:6px; font-weight:800;">Trạng thái</label>
                    <select name="status" style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e2e8f0;">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="display:block; font-size:12px; color:#64748b; margin-bottom:6px; font-weight:800;">Mô tả</label>
                    <textarea name="description" rows="4"
                              style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e2e8f0;"></textarea>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:14px;">
                <button type="submit"
                        style="padding:10px 14px; background:#0f172a; color:#fff; border:none; border-radius:10px; font-weight:900; cursor:pointer;">
                    Lưu
                </button>
                <a href="index.php?action=owner_services&court_id=<?= (int)$courtId ?>"
                   style="padding:10px 14px; background:#e2e8f0; color:#0f172a; border-radius:10px; text-decoration:none; font-weight:900; display:inline-flex; align-items:center;">
                    Quay lại
                </a>
            </div>

            <?php if (isset($_GET['error']) && $_GET['error'] !== ''): ?>
                <div class="flash-message flash-error" style="margin-top:14px;">
                    Dữ liệu không hợp lệ.
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

