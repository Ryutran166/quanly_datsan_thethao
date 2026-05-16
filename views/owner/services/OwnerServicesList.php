<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
/** @var array $services */
/** @var int $courtId */
/** @var array $filters */
/** @var int $page */
/** @var int $totalPages */
?>

<div style="max-width: 1100px; margin: 0 auto; padding: 18px 0;">

    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom: 14px;">
        <div>
            <h2 style="font-size:20px; margin:0;">Quản lý dịch vụ</h2>
            <div style="color:#64748b; font-size:13px; margin-top:6px;">
                Sân: <b><?= htmlspecialchars((string)($court['name'] ?? ($courtName ?? ''))) ?></b>
            </div>
        </div>

        <a href="index.php?action=owner_service_create&court_id=<?= (int)($courtId ?? ($_GET['court_id'] ?? 0)) ?>"
           style="display:inline-block; padding:10px 14px; background:#00c07f; color:#fff; border-radius:10px; text-decoration:none; font-weight:800;">
            + Thêm dịch vụ
        </a>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] !== ''): ?>
        <div class="flash-message flash-success">Thao tác thành công.</div>
    <?php endif; ?>

    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:14px;">
        <form method="GET" action="index.php" style="display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end;">
            <input type="hidden" name="action" value="owner_services">
            <input type="hidden" name="court_id" value="<?= (int)($_GET['court_id'] ?? 0) ?>">

            <div style="flex: 1; min-width: 220px;">
                <label style="display:block; font-size:12px; color:#64748b; margin-bottom:6px; font-weight:700;">Từ khóa</label>
                <input type="text" name="keyword" value="<?= htmlspecialchars((string)($_GET['keyword'] ?? '')) ?>"
                       placeholder="Tên dịch vụ hoặc mô tả"
                       style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e2e8f0;">
            </div>

            <div style="width: 200px;">
                <label style="display:block; font-size:12px; color:#64748b; margin-bottom:6px; font-weight:700;">Trạng thái</label>
                <select name="status" style="width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e2e8f0;">
                    <option value="" <?= (($_GET['status'] ?? '') === '') ? 'selected' : '' ?>>Tất cả</option>
                    <option value="active" <?= (($_GET['status'] ?? '') === 'active') ? 'selected' : '' ?>>active</option>
                    <option value="inactive" <?= (($_GET['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>inactive</option>
                </select>
            </div>

            <button type="submit" style="padding:10px 14px; background:#0f172a; color:#fff; border:none; border-radius:10px; font-weight:800; cursor:pointer;">
                Tìm kiếm
            </button>
        </form>
    </div>

    <div style="margin-top: 14px; background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden;">
        <div style="padding:12px 14px; background:#f8fafc; font-weight:900; font-size:13px; color:#0f172a; display:flex; gap:10px; align-items:center; justify-content:space-between;">
            <span>Danh sách dịch vụ</span>
            <a href="index.php?action=owner_my_courts" style="display:inline-flex; align-items:center; gap:7px; padding:7px 12px; background:#e2e8f0; color:#0f172a; border-radius:10px; text-decoration:none; font-weight:900;">
                ← Về sân của tôi
            </a>
        </div>

        <div style="padding:14px;">
            <?php if (empty($services ?? [])): ?>
                <div style="color:#64748b; font-size:14px;">Chưa có dịch vụ.</div>
            <?php else: ?>
                <div style="display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap:12px;">
                    <?php foreach ($services as $s): ?>
                        <div style="border:1px solid #e2e8f0; border-radius:14px; padding:12px;">
                            <div style="display:flex; justify-content:space-between; gap:10px;">
                                <div>
                                    <div style="font-weight:900;">
                                        Tên dịch vụ: <?= htmlspecialchars((string)($s['service_name'] ?? '')) ?>
                                    </div>
                                    <div style="color:#64748b; font-size:13px; margin-top:4px;">
                                        Sân: <?= htmlspecialchars((string)($s['court_name'] ?? '')) ?>
                                    </div>
                                </div>
                                <div style="text-align:right;">
                                    <div style="font-weight:900; color:#00c07f;"><?= number_format((float)$s['price'], 2, ',', '.') ?> đ</div>
                                    <div style="margin-top:6px; font-size:12px; font-weight:900; color:<?= ($s['status']==='active') ? '#065f46' : '#be123c' ?>;">
                                        <?= htmlspecialchars((string)$s['status']) ?>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($s['description'])): ?>
                                <div style="color:#64748b; font-size:13px; margin-top:8px;">
                                    <?= htmlspecialchars((string)$s['description']) ?>
                                </div>
                            <?php endif; ?>

                            <div style="display:flex; gap:10px; margin-top:12px; flex-wrap:wrap;">
                                <a href="index.php?action=owner_service_edit&id=<?= (int)$s['id'] ?>"
                                   style="padding:8px 10px; background:#e2e8f0; color:#0f172a; border-radius:10px; text-decoration:none; font-weight:800;">
                                    Sửa
                                </a>

                                <a href="index.php?action=owner_service_toggle_status&id=<?= (int)$s['id'] ?>"
                                   style="padding:8px 10px; background:#0f172a; color:#fff; border-radius:10px; text-decoration:none; font-weight:800;">
                                    Toggle
                                </a>

                                <a href="index.php?action=owner_service_delete&id=<?= (int)$s['id'] ?>"
                                   onclick="return confirm('Xóa dịch vụ này?')"
                                   style="padding:8px 10px; background:#fee2e2; color:#b91c1c; border-radius:10px; text-decoration:none; font-weight:800;">
                                    Xóa
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
</div>

</div>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>


