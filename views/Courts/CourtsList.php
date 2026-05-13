<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
?>


<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #00c07f;
        --primary-dark: #00a06a;
        --primary-soft: #e6faf3;
        --danger: #f43f5e;
        --danger-soft: #fff1f3;
        --dark: #0f172a;
        --mid: #475569;
        --muted: #94a3b8;
        --border: #e2e8f0;
        --surface: #ffffff;
        --page-bg: #f1f5f9;
        --card-shadow: 0 1px 3px rgba(15, 23, 42, .06), 0 4px 16px rgba(15, 23, 42, .06);
        --card-hover-shadow: 0 8px 32px rgba(15, 23, 42, .12);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: var(--page-bg) !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--dark);
    }

    /* ── Page wrapper ── */
    .courts-wrapper {
        max-width: 1280px;
        margin: 0 auto;
        padding: 40px 24px 60px;
    }

    /* ── Top bar ── */
    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .topbar-title {
        font-size: 26px;
        font-weight: 800;
        color: var(--dark);
        letter-spacing: -.5px;
    }

    .topbar-title span {
        color: var(--primary);
    }

    /* ── Search & actions row ── */
    .toolbar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
        max-width: 380px;
    }

    .search-wrap .ico {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 14px;
        pointer-events: none;
    }

    .search-wrap input[type="text"] {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        font-family: inherit;
        font-size: 14px;
        color: var(--dark);
        background: var(--surface);
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .search-wrap input[type="text"]:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 192, 127, .12);
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: var(--primary);
        color: #fff;
        font-family: inherit;
        font-size: 14px;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        text-decoration: none;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 2px 8px rgba(0, 192, 127, .3);
        white-space: nowrap;
    }

    .btn-add:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0, 192, 127, .35);
    }

    .btn-add:active {
        transform: scale(.97);
    }

    /* ── Stats strip ── */
    .stats-strip {
        display: flex;
        gap: 12px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 40px;
        padding: 6px 16px 6px 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--mid);
    }

    .stat-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .stat-dot.green {
        background: var(--primary);
    }

    .stat-dot.red {
        background: var(--danger);
    }

    .stat-dot.gray {
        background: var(--muted);
    }

    /* ── Card grid ── */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }

    /* ── Court card ── */
    .court-card {
        background: var(--surface);
        border-radius: 20px;
        overflow: hidden;
        border: 1.5px solid var(--border);
        box-shadow: var(--card-shadow);
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s;
        display: flex;
        flex-direction: column;
    }

    .court-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-hover-shadow);
        border-color: #cbd5e1;
    }

    /* image */
    .court-img-wrap {
        position: relative;
        height: 196px;
        overflow: hidden;
    }

    .court-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s ease;
    }

    .court-card:hover .court-img-wrap img {
        transform: scale(1.04);
    }

    /* status badge on image */
    .img-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .3px;
        backdrop-filter: blur(6px);
    }

    .img-badge.available {
        background: rgba(230, 250, 243, .92);
        color: #00875a;
        border: 1px solid rgba(0, 192, 127, .25);
    }

    .img-badge.booked {
        background: rgba(255, 241, 243, .92);
        color: #be123c;
        border: 1px solid rgba(244, 63, 94, .2);
    }

    /* quick-action buttons on image (top-right) */
    .img-actions {
        position: absolute;
        top: 12px;
        right: 12px;
        display: flex;
        gap: 6px;
        opacity: 0;
        transform: translateY(-4px);
        transition: opacity .25s, transform .25s;
    }

    .court-card:hover .img-actions {
        opacity: 1;
        transform: translateY(0);
    }

    .img-btn {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 13px;
        backdrop-filter: blur(8px);
        transition: background .15s, transform .15s;
    }

    .img-btn:active {
        transform: scale(.92);
    }

    .img-btn.edit {
        background: rgba(255, 255, 255, .88);
        color: var(--mid);
        border: 1px solid rgba(255, 255, 255, .5);
    }

    .img-btn.edit:hover {
        background: #fff;
        color: var(--dark);
    }

    .img-btn.del {
        background: rgba(244, 63, 94, .15);
        color: var(--danger);
        border: 1px solid rgba(244, 63, 94, .25);
    }

    .img-btn.del:hover {
        background: rgba(244, 63, 94, .25);
    }

    /* card body */
    .card-body {
        padding: 18px 20px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .owner-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
        letter-spacing: .3px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .owner-chip.mine {
        color: var(--primary);
    }

    .court-name {
        font-size: 19px;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 12px;
        line-height: 1.25;
    }

    .price-row {
        display: flex;
        align-items: baseline;
        gap: 4px;
        margin-bottom: 18px;
    }

    .price-amount {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary);
        letter-spacing: -.5px;
    }

    .price-unit {
        font-size: 13px;
        color: var(--muted);
        font-weight: 500;
    }

    /* footer */
    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1.5px solid var(--border);
        margin-top: auto;
    }

    .btn-book {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 20px;
        background: var(--primary);
        color: #fff;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
        transition: background .2s, transform .15s, box-shadow .2s;
        box-shadow: 0 2px 6px rgba(0, 192, 127, .25);
    }

    .btn-book:hover {
        background: var(--primary-dark);
        box-shadow: 0 4px 12px rgba(0, 192, 127, .3);
        transform: translateY(-1px);
    }

    .btn-book:active {
        transform: scale(.96);
    }

    /* desktop edit/delete — fallback when card NOT hovered (show inline) */
    .inline-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 13px;
        border: 1.5px solid var(--border);
        color: var(--mid);
        transition: background .15s, color .15s, border-color .15s;
    }

    .action-btn:hover {
        background: var(--page-bg);
        border-color: #cbd5e1;
    }

    .action-btn.danger:hover {
        background: var(--danger-soft);
        color: var(--danger);
        border-color: rgba(244, 63, 94, .3);
    }

    /* ── Empty state ── */
    .empty-state {
        grid-column: 1/-1;
        text-align: center;
        padding: 80px 40px;
        background: var(--surface);
        border-radius: 20px;
        border: 1.5px dashed var(--border);
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        background: var(--primary-soft);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 16px;
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--muted);
    }

    /* ── Pagination ── */
    .pagi {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 36px;
        flex-wrap: wrap;
    }

    .pagi a {
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--mid);
        transition: background .15s, border-color .15s, color .15s;
    }

    .pagi a:hover {
        background: var(--page-bg);
        border-color: #cbd5e1;
        color: var(--dark);
    }

    .pagi a.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }


    .court-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .5);

        display: flex;
        align-items: center;
        justify-content: center;

        opacity: 0;
        visibility: hidden;

        transition: .3s;

        z-index: 9999;
    }

    .court-modal.show {
        opacity: 1;
        visibility: visible;
    }

    .court-modal-content {
        width: 90%;
        max-width: 700px;

        background: white;

        border-radius: 20px;

        overflow: hidden;

        position: relative;
    }

    .modal-image-wrap {
        height: 320px;
    }

    .modal-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 15px;

        width: 40px;
        height: 40px;

        border: none;
        border-radius: 50%;

        font-size: 24px;

        cursor: pointer;
    }

    .court-modal-content {
        transform: scale(.9);
        transition: .3s;
    }

    .court-modal.show .court-modal-content {
        transform: scale(1);
    }

    #modalStatus {
        display: inline-block;
        margin-top: 10px;
        padding: 6px 12px;
        border-radius: 20px;
        background: #e6faf3;
        color: #00a06a;
        font-weight: 600;
        font-size: 13px;
    }

    .modal-address {
        display: flex;
        align-items: center;
        gap: 8px;

        margin: 14px 0 18px;

        color: var(--mid);
        font-size: 15px;
        font-weight: 500;
    }

    .modal-address i {
        color: var(--primary);
    }
</style>

<div class="courts-wrapper">

    <!-- Top bar -->
    <div class="topbar">
        
        <?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'owner'])): ?>
            <a href="index.php?action=create" class="btn-add">
                <i class="fa fa-plus" style="font-size:12px;"></i>
                Thêm sân mới
            </a>
        <?php endif; ?>
    </div>

    <!-- Toolbar: search -->
    <div class="toolbar">
        <form action="index.php" method="GET" class="search-wrap">
            <span class="ico"><i class="fa fa-search"></i></span>
            <input type="hidden" name="action" value="index">
            <input type="text"
                name="keyword"
                placeholder="Tìm kiếm tên sân..."
                value="<?= htmlspecialchars($keyword ?? '') ?>">
        </form>
    </div>

    <!-- Stats strip -->
    <?php if (!empty($courts)): ?>
        <div class="stats-strip">
            <?php
            $total     = count($courts);
            $available = count(array_filter($courts, fn($c) => $c['status'] == 'available'));
            $booked    = $total - $available;
            ?>
            <div class="stat-pill">
                <span class="stat-dot gray"></span>
                <?= $total ?> sân
            </div>
            <div class="stat-pill">
                <span class="stat-dot green"></span>
                <?= $available ?> đang trống
            </div>
            <div class="stat-pill">
                <span class="stat-dot red"></span>
                <?= $booked ?> đã đặt
            </div>
        </div>
    <?php endif; ?>

    <!-- Card grid -->
    <div class="card-grid">

        <?php if (!empty($courts)): ?>
            <?php foreach ($courts as $court): ?>

                <?php
                $canEdit = false;
                if (isset($_SESSION['user_role'])) {
                    if ($_SESSION['user_role'] == 'admin') {
                        $canEdit = true;
                    } elseif ($_SESSION['user_role'] == 'owner' && $court['owner_id'] == $_SESSION['user_id']) {
                        $canEdit = true;
                    }
                }
                $isAvailable = $court['status'] == 'available';
                $isMine      = isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'owner' && $court['owner_id'] == $_SESSION['user_id'];
                ?>

                <div class="court-card"
                    data-id="<?= $court['id'] ?>">

                    <!-- Image -->
                    <div class="court-img-wrap">
                        <?php if (!empty($court['image'])): ?>
                            <img src="/quanly_datsan_thethao/public/upload/img_courts/<?= htmlspecialchars($court['image']) ?>"
                                alt="Court Image">
                        <?php else: ?>
                            <img src="/quanly_datsan_thethao/public/upload/img_courts/default.png"
                                alt="Default Image">
                        <?php endif; ?>
                        <!-- <span class="img-badge <?= $isAvailable ? 'available' : 'booked' ?>">
                            <?= $isAvailable ? '● Trống' : '● Đã đặt' ?>
                        </span> -->

                        <!-- <?php if ($canEdit): ?>
                        <div class="img-actions">
                            <a href="index.php?action=edit&id=<?= $court['id'] ?>" class="img-btn edit" title="Chỉnh sửa">
                                <i class="fa fa-pen"></i>
                            </a>
                            <a href="index.php?action=delete&id=<?= $court['id'] ?>"
                               class="img-btn del" title="Xóa"
                               onclick="return confirm('Bạn chắc chắn muốn xóa sân này?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                        <?php endif; ?> -->
                    </div>

                    <!-- Body -->
                    <div class="card-body">

                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'owner'): ?>
                            <div class="owner-chip <?= $isMine ? 'mine' : '' ?>">
                                <i class="fa fa-<?= $isMine ? 'star' : 'user' ?>" style="font-size:10px;"></i>
                                <?= $isMine ? 'Sân của bạn' : 'Sân của chủ khác' ?>
                            </div>
                        <?php endif; ?>

                        <div class="court-name"><?= htmlspecialchars($court['name']) ?></div>

                        <!-- <div class="price-row">
                            <span class="price-amount"><?= number_format($court['price']) ?></span>
                            <span class="price-unit">VNĐ / giờ</span>
                        </div> -->

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

                            <a href="index.php?action=booking&id=<?= $court['id'] ?>" class="btn-book">
                                Đặt sân <i class="fa fa-arrow-right" style="font-size:11px;"></i>
                            </a>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-state">
                <div class="empty-icon">🏟️</div>
                <h3>Không tìm thấy sân nào</h3>
                <p>Thử tìm kiếm với từ khóa khác hoặc thêm sân mới.</p>
            </div>

        <?php endif; ?>

    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="pagi">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?action=index&keyword=<?= urlencode($keyword ?? '') ?>&page=<?= $i ?>"
                    class="<?= ($i == $currentPage) ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

    <div class="court-modal" id="courtModal">

        <div class="court-modal-content">

            <button class="modal-close" id="closeModal">
                &times;
            </button>

            <div class="modal-image-wrap">
                <img id="modalImage">
            </div>

            <div class="modal-body">

                <h2 id="modalName"></h2>

                <!-- <div class="modal-price">
                    <span id="modalPrice"></span>
                    <small>VNĐ / giờ</small>
                </div> -->
                <div class="modal-address">
                    <i class="fa fa-location-dot"></i>
                    <span id="modalAddress"></span>
                </div>

                <div class="modal-address">
                    <i class="fa fa-phone"></i>
                    <span id="modalOwnerPhone"></span>
                </div>

                <p>
                    <strong>Trạng thái:</strong>
                    <span id="modalStatus"></span>
                </p>

                <a href="#" class="btn-book" id="modalBookingBtn">
                    Đặt sân
                </a>


            </div>

        </div>

    </div>
</div>


<script>
    const modal = document.getElementById('courtModal');

    // Click card
    document.querySelectorAll('.court-card').forEach(card => {

        card.addEventListener('click', async function(e) {

            // Không mở popup khi click nút/link
            if (e.target.closest('a')) return;

            const id = this.dataset.id;

            try {

                const response = await fetch(
                    `index.php?action=court_detail&id=${id}`
                );

                const data = await response.json();

                if (!data.success) {
                    alert('Không lấy được dữ liệu sân');
                    return;
                }

                const court = data.court;

                // Gán dữ liệu popup
                document.getElementById('modalName').innerText =
                    court.name;

                // document.getElementById('modalPrice').innerText =
                //     Number(court.price).toLocaleString();
                    
                document.getElementById('modalAddress').innerText =
                    court.address || 'Chưa cập nhật địa chỉ';

                document.getElementById('modalStatus').innerText =
                    court.status;

                const phone = court.owner_phone || court.owner && court.owner.phone || court.phone;
                const modalPhoneEl = document.getElementById('modalOwnerPhone');
                if (modalPhoneEl) {
                    modalPhoneEl.innerText = phone || 'Chưa cập nhật số điện thoại';
                }


                document.getElementById('modalImage').src =
                    court.image ?
                    `/quanly_datsan_thethao/public/upload/img_courts/${court.image}` :
                    `/quanly_datsan_thethao/public/upload/img_courts/default.png`;

                document.getElementById('modalBookingBtn').href =
                    `index.php?action=booking&id=${court.id}`;

                // Hiện popup
                modal.classList.add('show');

            } catch (err) {

                console.log(err);
                alert('Có lỗi xảy ra');

            }

        });

    });

    // Close button
    const closeBtn = document.getElementById('closeModal');

    if (closeBtn) {

        closeBtn.addEventListener('click', () => {

            modal.classList.remove('show');

        });

    }

    // Click nền để đóng
    modal.addEventListener('click', function(e) {

        if (e.target === modal) {

            modal.classList.remove('show');

        }

    });
</script>


<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>