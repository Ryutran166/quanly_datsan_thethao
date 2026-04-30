<style>
    .user-list-container {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 15px; /* Tạo khoảng cách giữa các hàng */
    }
    .table-modern th {
        color: #9ea0a5;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 10px 20px;
        border-bottom: 1px solid #f0f1f3;
    }
    .table-modern tbody tr {
        background-color: #fff;
        transition: transform 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .table-modern tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .table-modern td {
        padding: 15px 20px;
        vertical-align: middle;
    }
    /* Avatar giả lập */
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #343a40;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }
    /* Badge phong cách hiện đại */
    .badge-role {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: bold;
        background: #f1f3f9;
        color: #5e72e4;
    }
    .status-active {
        color: #2dce89;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
    }
    .status-active::before {
        content: "●";
        font-size: 12px;
    }
    .action-btns a {
        color: #adb5bd;
        margin: 0 8px;
        transition: 0.3s;
    }
    .action-btns a:hover {
        color: #5e72e4;
    }
</style>
<div class="user-list-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-weight: 700; color: #32325d; margin: 0;">Danh sách người dùng hệ thống</h2>
        <a href="index.php?action=add_user" class="btn btn-primary" style="background: #2dce89; border: none; border-radius: 8px; padding: 10px 20px; font-weight: 600;">
            <i class="fa fa-plus me-2"></i> Thêm User mới
        </a>
    </div>

    <table class="table-modern">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email / Số điện thoại</th>
                <th>Role</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="avatar-circle">
                                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #32325d;"><?= htmlspecialchars($user['name']) ?></div>
                                    <div style="font-size: 0.8rem; color: #8898aa;">@<?= strtolower(explode(' ', $user['name'])[0]) ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: #525f7f; font-size: 0.9rem;"><?= htmlspecialchars($user['email']) ?></div>
                            <div style="font-size: 0.8rem; color: #8898aa;"><?= htmlspecialchars($user['phone'] ?? '---') ?></div>
                        </td>
                        <td>
                            <span class="badge-role">CUSTOMER</span>
                        </td>
                        <td>
                            <span class="status-active">Active</span>
                        </td>
                        <td style="text-align: right;" class="action-btns">
                            <a href="index.php?action=edit_user&id=<?= $user['id'] ?>" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?action=delete_user&id=<?= $user['id'] ?>" 
                               style="color: #fb6340;" 
                               onclick="return confirm('Xóa user này?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 50px; color: #adb5bd;">
                        <i class="fas fa-user-slash d-block mb-2" style="font-size: 2rem;"></i>
                        Không có người dùng nào.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>