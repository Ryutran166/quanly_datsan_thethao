<style>
/* ===== COURTS PAGE — SPORTHUB ===== */

/* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap');

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Be Vietnam Pro', sans-serif;
    background: #f0f2f5;
    color: #1a1a2e;
}

/* ===== NAVBAR ===== */
.navbar {
    background: #0d1117;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 32px;
    height: 60px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 12px rgba(0,0,0,0.4);
}

.navbar-brand {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.5px;
    text-decoration: none;
}

.navbar-brand span {
    color: #00d084;
}

.navbar-nav {
    display: flex;
    align-items: center;
    gap: 2px;
    list-style: none;
}

.navbar-nav a {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 13px;
    font-size: 13px;
    font-weight: 500;
    color: #c9cdd4;
    text-decoration: none;
    border-radius: 6px;
    white-space: nowrap;
    transition: background 0.18s, color 0.18s;
}

.navbar-nav a:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
}

.navbar-nav a.active {
    background: #00d084;
    color: #0d1117;
    font-weight: 700;
}

.navbar-nav a i {
    font-size: 12px;
    opacity: 0.8;
}

.navbar-user {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}

.navbar-user .avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #00d084;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0d1117;
    font-size: 15px;
}

/* ===== PAGE WRAPPER ===== */
.courts-wrapper {
    max-width: 1280px;
    margin: 0 auto;
    padding: 28px 24px 48px;
}

/* ===== TOP BAR (Add button) ===== */
.topbar {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 16px;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #00d084;
    color: #0d1117;
    font-size: 13px;
    font-weight: 700;
    padding: 9px 18px;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.18s, transform 0.15s;
    box-shadow: 0 2px 8px rgba(0,208,132,0.3);
}

.btn-add:hover {
    background: #00b872;
    transform: translateY(-1px);
}

/* ===== TOOLBAR (Search + stats) ===== */
.toolbar {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    flex: 0 0 340px;
}

.search-wrap .ico {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #8a909b;
    font-size: 13px;
    pointer-events: none;
}

.search-wrap input {
    width: 100%;
    padding: 10px 14px 10px 38px;
    border: 1.5px solid #e2e5ea;
    border-radius: 10px;
    font-size: 13.5px;
    font-family: inherit;
    background: #fff;
    color: #1a1a2e;
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
}

.search-wrap input:focus {
    border-color: #00d084;
    box-shadow: 0 0 0 3px rgba(0,208,132,0.12);
}

.search-wrap input::placeholder {
    color: #aab0bb;
}

/* ===== STATS CHIPS ===== */
.stats-chips {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.stat-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    background: #fff;
    border: 1.5px solid #e2e5ea;
    color: #444;
}

.stat-chip .dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
}

.stat-chip .dot.grey  { background: #9aa0ab; }
.stat-chip .dot.green { background: #00d084; }
.stat-chip .dot.red   { background: #f04444; }

/* ===== CARD GRID ===== */
.card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

@media (max-width: 1024px) {
    .card-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .card-grid { grid-template-columns: 1fr; }
    .search-wrap { flex: 1 1 100%; }
}

/* ===== COURT CARD ===== */
.court-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    transition: box-shadow 0.2s, transform 0.2s;
}

.court-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.13);
    transform: translateY(-3px);
}

/* ===== CARD IMAGE ===== */
.court-img-wrap {
    position: relative;
    height: 190px;
    overflow: hidden;
}

.court-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}

.court-card:hover .court-img-wrap img {
    transform: scale(1.04);
}

/* ===== CARD BODY ===== */
.card-body {
    padding: 14px 16px 16px;
}

/* ===== OWNER CHIP ===== */
.owner-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 8px;
}

.owner-chip.mine {
    background: rgba(0,208,132,0.12);
    color: #00a86b;
}

.owner-chip.other {
    background: rgba(90,100,120,0.1);
    color: #5a6478;
}

/* ===== COURT NAME ===== */
.court-name {
    font-size: 18px;
    font-weight: 800;
    color: #0d1117;
    margin-bottom: 14px;
    line-height: 1.25;
}

/* ===== CARD FOOTER ===== */
.card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.inline-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1.5px solid #e2e5ea;
    background: #f8f9fb;
    color: #5a6478;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    text-decoration: none;
    transition: background 0.16s, border-color 0.16s, color 0.16s;
}

.action-btn:hover {
    background: #eef0f4;
    border-color: #c5cad4;
    color: #1a1a2e;
}

.action-btn.danger:hover {
    background: #fff0f0;
    border-color: #f8b4b4;
    color: #e53e3e;
}

.btn-book {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #00d084;
    color: #0d1117;
    font-size: 13.5px;
    font-weight: 700;
    padding: 9px 20px;
    border-radius: 9px;
    text-decoration: none;
    transition: background 0.18s, transform 0.15s;
    box-shadow: 0 2px 8px rgba(0,208,132,0.25);
}

.btn-book:hover {
    background: #00b872;
    transform: translateY(-1px);
}

/* ===== EMPTY STATE ===== */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 24px;
    background: #fff;
    border-radius: 16px;
    color: #8a909b;
}

.empty-icon {
    font-size: 56px;
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 700;
    color: #3a3f4e;
    margin-bottom: 8px;
}

.empty-state p {
    font-size: 14px;
}

/* ===== PAGINATION ===== */
.pagi {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 36px;
    flex-wrap: wrap;
}

.pagi a {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    color: #5a6478;
    background: #fff;
    border: 1.5px solid #e2e5ea;
    transition: all 0.16s;
}

.pagi a:hover {
    background: #f0faf6;
    border-color: #00d084;
    color: #00a86b;
}

.pagi a.active {
    background: #00d084;
    border-color: #00d084;
    color: #0d1117;
}
</style>
<?php
$keyword      = $keyword      ?? '';
$currentPage  = $currentPage  ?? 1;
$totalPages   = $totalPages   ?? 0;

// Stats calculation
$totalCourts   = count($courts ?? []);
$availableCnt  = 0; // replace with real query if available
$bookedCnt     = 0; // replace with real query if available

require_once PROJECT_ROOT . '/views/layout/header.php';
?>

<div class="courts-wrapper">

    <!-- ===== TOOLBAR ===== -->
    <div class="toolbar">
        <!-- Search -->
        <form action="index.php" method="GET" class="search-wrap">
            <span class="ico"><i class="fa fa-search"></i></span>
            <input type="hidden" name="action" value="owner_my_courts">
            <input type="text"
                   name="keyword"
                   placeholder="Tìm kiếm tên sân..."
                   value="<?= htmlspecialchars($keyword) ?>">
        </form>

        <!-- Add button (right-aligned via margin-left:auto) -->
        <a href="index.php?action=create" class="btn-add" style="margin-left:auto">
            <i class="fa fa-plus" style="font-size:11px;"></i>
            Thêm sân mới
        </a>
    </div>

    <!-- ===== CARD GRID ===== -->
    <div class="card-grid">
        <?php if (!empty($courts)): ?>
            <?php foreach ($courts as $court): ?>
                <?php
                // Adjust logic as needed — currently every court in this view is "mine"
                $isMine   = true;
                $canEdit  = true;
                ?>

                <div class="court-card" data-id="<?= $court['id'] ?>">

                    <!-- Image -->
                    <div class="court-img-wrap">
                        <?php if (!empty($court['image'])): ?>
                            <img src="/quanly_datsan_thethao/public/upload/img_courts/<?= htmlspecialchars($court['image']) ?>"
                                 alt="<?= htmlspecialchars($court['name']) ?>">
                        <?php else: ?>
                            <img src="/quanly_datsan_thethao/public/upload/img_courts/default.png"
                                 alt="Default Image">
                        <?php endif; ?>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Court name -->
                        <div class="court-name"><?= htmlspecialchars($court['name']) ?></div>

                        <!-- Footer: actions + book button -->
                        <div class="card-footer">
                            <?php if ($canEdit): ?>
                                <div class="inline-actions">
                                    <a href="index.php?action=edit&id=<?= $court['id'] ?>"
                                       class="action-btn" title="Chỉnh sửa">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="index.php?action=delete&id=<?= $court['id'] ?>"
                                       class="action-btn danger" title="Xóa"
                                       onclick="return confirm('Bạn chắc chắn muốn xóa sân này?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">🏟️</div>
                <h3>Không tìm thấy sân nào</h3>
                <p>Thử tìm kiếm với từ khóa khác.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- ===== PAGINATION ===== -->
    <?php if ($totalPages > 1): ?>
        <div class="pagi">
            <?php for ($i = 1; $i <= (int)$totalPages; $i++): ?>
                <a href="index.php?action=owner_my_courts&keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"
                   class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>