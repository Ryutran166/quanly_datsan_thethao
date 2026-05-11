<style>
    @import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap');

    * {
        font-family: 'Be Vietnam Pro', sans-serif;
    }

    body, .main-content {
        background-color: #f4f6fb !important;
        color: #64748b;
    }

    /* ===== CONTAINER ===== */
    .user-list-container {
        background: transparent;
        border-radius: 0;
        padding: 32px 24px;
        box-shadow: none;
    }

    /* ===== HEADER ROW ===== */
    .user-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .user-list-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #64748b;
        margin: 0;
    }

    .user-list-title span {
        color: #22c55e;
    }

    /* ===== SEARCH BOX ===== */
    .search-box {
        display: flex;
        gap: 10px;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 12px;
    }

    .search-box i {
        color: #64748b;
        font-size: 0.9rem;
    }

    .search-box input {
        background: transparent;
        border: none;
        outline: none;
        color: #64748b;
        font-size: 0.9rem;
        min-width: 220px;
        padding: 4px 0;
    }

    .search-box input::placeholder {
        color: #64748b;
    }

    .search-box button {
        background: #22c55e;
        color: #0f1623;
        border: none;
        padding: 8px 18px;
        border-radius: 7px;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.85rem;
        transition: background 0.2s;
    }

    .search-box button:hover {
        background: #16a34a;
    }

    /* ===== ADD BUTTON ===== */
    .btn-add-user {
        background: #22c55e;
        color: #0f1623 !important;
        border: none;
        border-radius: 10px;
        padding: 10px 22px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s, transform 0.15s;
    }

    .btn-add-user:hover {
        background: #16a34a;
        transform: translateY(-1px);
    }

    /* ===== TABLE ===== */
    .table-modern {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table-modern thead tr {
        background: transparent;
    }

    .table-modern th {
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        padding: 12px 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-modern tbody tr {
        background: #ffffff;
        border-radius: 12px;
        transition: background 0.2s, transform 0.15s;
        border-bottom: 6px solid #f4f6fb;
    }

    .table-modern tbody tr:first-child td:first-child { border-top-left-radius: 10px; }
    .table-modern tbody tr:first-child td:last-child  { border-top-right-radius: 10px; }
    .table-modern tbody tr:last-child  td:first-child { border-bottom-left-radius: 10px; }
    .table-modern tbody tr:last-child  td:last-child  { border-bottom-right-radius: 10px; }

    .table-modern tbody tr:hover {
        background: #f0fdf4;
        transform: translateY(-1px);
    }

    .table-modern td {
        padding: 16px 20px;
        vertical-align: middle;
        border: none;
    }

    /* ===== AVATAR ===== */
    .user-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .avatar-circle {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0f1623;
        font-weight: 800;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .user-name {
        font-weight: 700;
        color: #64748b;
        font-size: 0.95rem;
    }

    .user-handle {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 2px;
    }

    /* ===== EMAIL/PHONE ===== */
    .contact-email {
        color: #64748b;
        font-size: 0.88rem;
    }

    .contact-phone {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 3px;
    }

    /* ===== ROLE BADGE ===== */
    .badge-role {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        background: rgba(34, 197, 94, 0.12);
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.25);
    }

    /* ===== STATUS ===== */
    .status-active {
        color: #22c55e;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 6px #22c55e;
        flex-shrink: 0;
    }

    /* ===== ACTION BUTTONS ===== */
    .action-btns {
        display: flex;
        justify-content: flex-end;
        gap: 6px;
    }

    .action-btns a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        color: #64748b;
        background: #f1f5f9;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.85rem;
    }

    .action-btns a:hover {
        background: #22c55e;
        color: #0f1623;
    }

    .action-btns a.delete-btn:hover {
        background: #ef4444;
        color: white;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #cbd5e1;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        display: block;
    }

    /* ===== PAGINATION ===== */
    .pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .pagination a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 9px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.88rem;
        transition: all 0.2s;
    }

    .pagination a.active {
        background: #22c55e;
        color: #0f1623;
    }

    .pagination a.inactive {
        background: #ffffff;
        color: #64748b;
    }

    .pagination a.inactive:hover {
        background: #f1f5f9;
        color: #64748b;
    }
</style>

<div class="user-list-container">

    <div class="user-list-header">

        <h1 class="user-list-title">
            <?php if (!empty($keyword)): ?>
                Kết quả tìm kiếm: '<span><?= htmlspecialchars($keyword) ?></span>'
            <?php else: ?>
                Quản lý <span>người dùng</span>
            <?php endif; ?>
        </h1>

        <form action="index.php" method="GET" class="search-box">
            <input type="hidden" name="action" value="user">
            <i class="fas fa-search"></i>
            <input type="text"
                name="keyword"
                placeholder="Tìm kiếm theo tên..."
                value="<?= htmlspecialchars($keyword ?? '') ?>">
            <button type="submit">Tìm kiếm</button>
        </form>

        <a href="index.php?action=add_user" class="btn-add-user">
            <i class="fa fa-plus"></i> Thêm User mới
        </a>

    </div>

    <table class="table-modern">
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>Email / SĐT</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th style="text-align:right;">Thao tác</th>
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
                                    <div class="user-name"><?= htmlspecialchars($user['name']) ?></div>
                                    <div class="user-handle">@<?= strtolower(explode(' ', $user['name'])[0]) ?></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="contact-email"><?= htmlspecialchars($user['email']) ?></div>
                            <div class="contact-phone"><?= htmlspecialchars($user['phone'] ?? '---') ?></div>
                        </td>

                        <td>
                            <span class="badge-role"><?= strtoupper($user['role']) ?></span>
                        </td>

                        <td>
                            <span class="status-active">
                                <span class="status-dot"></span>
                                Active
                            </span>
                        </td>

                        <td>
                            <div class="action-btns">
                                <a href="index.php?action=edit_user&id=<?= $user['id'] ?>" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?action=delete_user&id=<?= $user['id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Xóa user này?')"
                                    title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="fas fa-user-slash"></i>
                            Không có người dùng nào.
                        </div>
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

    <!-- PHÂN TRANG -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="index.php?action=user&keyword=<?= urlencode($keyword ?? '') ?>&page=<?= $i ?>"
               class="<?= ($i == $currentPage) ? 'active' : 'inactive' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

</div>