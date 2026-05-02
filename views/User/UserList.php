<style>
    .user-list-container {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 15px;
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
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
    }

    .table-modern tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .table-modern td {
        padding: 15px 20px;
        vertical-align: middle;
    }

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

    .search-box {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-box input {
        padding: 10px 14px;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        min-width: 250px;
    }

    .search-box button {
        background: #5e72e4;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
    }

    .pagination a:hover {
        background: #5e72e4 !important;
        color: white !important;
    }
</style>

<div class="user-list-container">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">

        <h1 style="font-weight:700; color:#32325d; margin:0;">
            <?php
            if (!empty($keyword)) {
                echo "Kết quả tìm kiếm cho: '" . htmlspecialchars($keyword) . "'";
            } else {
                echo "Danh sách người dùng hệ thống";
            }
            ?>
        </h1>

        <form action="index.php" method="GET" class="search-box">
            <input type="hidden" name="action" value="user">

            <input type="text"
                name="keyword"
                placeholder="Tìm kiếm theo tên..."
                value="<?= htmlspecialchars($keyword ?? '') ?>">

            <button type="submit">Tìm kiếm</button>
        </form>

        <a href="index.php?action=add_user"
            class="btn btn-primary"
            style="background:#2dce89; border:none; border-radius:8px; padding:10px 20px; font-weight:600;">
            <i class="fa fa-plus me-2"></i> Thêm User mới
        </a>

    </div>

    <table class="table-modern">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email / SĐT</th>
                <th>Role</th>
                <th>Status</th>
                <th style="text-align:right;">Actions</th>
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
                                    <div style="font-weight:600; color:#32325d;">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </div>

                                    <div style="font-size:0.8rem; color:#8898aa;">
                                        @<?= strtolower(explode(' ', $user['name'])[0]) ?>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div style="color:#525f7f; font-size:0.9rem;">
                                <?= htmlspecialchars($user['email']) ?>
                            </div>

                            <div style="font-size:0.8rem; color:#8898aa;">
                                <?= htmlspecialchars($user['phone'] ?? '---') ?>
                            </div>
                        </td>

                        <td>
                            <span class="badge-role">
                                <?= strtoupper($user['role']) ?>
                            </span>
                        </td>

                        <td>
                            <span class="status-active">Active</span>
                        </td>

                        <td style="text-align:right;" class="action-btns">

                            <a href="index.php?action=edit_user&id=<?= $user['id'] ?>" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="index.php?action=delete_user&id=<?= $user['id'] ?>"
                                onclick="return confirm('Xóa user này?')"
                                style="color:#fb6340;"
                                title="Xóa">
                                <i class="fas fa-trash"></i>
                            </a>

                        </td>

                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="5" style="text-align:center; padding:50px; color:#adb5bd;">
                        <i class="fas fa-user-slash d-block mb-2" style="font-size:2rem;"></i>
                        Không có người dùng nào.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>
    <!-- PHÂN TRANG -->
    <div class="pagination" style="margin-top:25px; text-align:center;">

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>

            <a href="index.php?action=user&keyword=<?= urlencode($keyword ?? '') ?>&page=<?= $i ?>"
                style="
                    display:inline-block;
                    padding:8px 14px;
                    margin:0 4px;
                    border-radius:8px;
                    text-decoration:none;
                    font-weight:600;
                    background:<?= ($i == $currentPage) ? '#5e72e4' : '#f1f3f9' ?>;
                    color:<?= ($i == $currentPage) ? 'white' : '#32325d' ?>;
                ">
                <?= $i ?>
            </a>

        <?php endfor; ?>
    </div>
</div>