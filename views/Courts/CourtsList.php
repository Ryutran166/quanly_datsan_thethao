<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
?>

<title>Quản Lý Sân</title>

<style>
:root{
    --primary:#2dce89;
    --dark:#32325d;
    --gray:#8898aa;
    --light:#f8f9fe;
    --danger:#f5365c;
}

body{
    background:#1a1a1a !important;  
}

/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.page-title{
    font-size:32px;
    font-weight:800;
    color:var(--dark);
    margin:0;
}

.page-desc{
    color:var(--gray);
    margin-top:5px;
}

/* SEARCH */
.search-box{
    background:white;
    padding:12px 18px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,.05);
    display:flex;
    align-items:center;
    gap:10px;
}

.search-box input{
    border:none;
    outline:none;
    width:260px;
}

/* GRID */
.card-container{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:25px;
}

/* CARD */
.court-card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 0 2rem rgba(136,152,170,.15);
    transition:.3s;
}

.court-card:hover{
    transform:translateY(-8px);
    box-shadow:0 0 3rem rgba(136,152,170,.25);
}

.court-image{
    width:100%;
    height:210px;
    object-fit:cover;
}

/* BODY */
.card-body{
    padding:20px;
}

.badge-status{
    display:inline-block;
    padding:6px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
    margin-bottom:12px;
}

.available{
    background:#eafaf1;
    color:var(--primary);
}

.booked{
    background:#ffe5e5;
    color:var(--danger);
}

.court-name{
    font-size:22px;
    font-weight:700;
    color:var(--dark);
    margin-bottom:8px;
}

.price{
    font-size:24px;
    font-weight:800;
    color:var(--primary);
}

.price small{
    font-size:14px;
    color:var(--gray);
}

/* BUTTONS */
.card-footer {
    margin-top:18px;
    display:flex;
    justify-content: flex-end; 
    align-items:center;
}
.action-left{
    display:flex;
    gap:10px;
}

.btn-icon{
    width:38px;
    height:38px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid #ddd;
    color:#666;
    text-decoration:none;
}

.btn-icon:hover{
    background:#f8f9fa;
}

.btn-delete:hover{
    color:var(--danger);
}

.btn-book{
    background:var(--primary);
    color:white;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.btn-book:hover{
    opacity:.9;
    color:white;
}

/* EMPTY */
.empty-box{
    grid-column:1/-1;
    text-align:center;
    padding:80px;
    background:white;
    border-radius:16px;
}
</style>

<div class="container py-5">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h1 class="page-title">Quản lý sân</h1>
            <p class="page-desc">
                Quản lý danh sách sân thể thao của trung tâm
            </p>
        </div>

        <!-- FIXED -->
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="index.php?action=create"
            class="btn btn-success px-4 py-2 rounded-pill">
                + Thêm sân mới
            </a>
        <?php endif; ?>

    </div>

    <!-- SEARCH -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <form action="index.php" method="GET" class="search-box">
            <i class="fa fa-search text-muted"></i>

            <input type="hidden" name="action" value="index">

            <input type="text"
                   name="keyword"
                   placeholder="Tìm kiếm tên sân..."
                   value="<?= htmlspecialchars($keyword ?? '') ?>">
        </form>

    </div>

    <!-- LIST -->
    <div class="card-container">

        <?php if(!empty($courts)): ?>
            <?php foreach($courts as $court): ?>

                <div class="court-card">

                    <img class="court-image"
                         src="<?= !empty($court['image']) ? $court['image'] : 'https://images.unsplash.com/photo-1599474924187-334a4ae593c1?q=80&w=600' ?>">

                    <div class="card-body">

                        <div class="badge-status <?= $court['status'] == 'available' ? 'available' : 'booked' ?>">
                            <?= $court['status'] == 'available' ? 'Trống' : 'Đã đặt' ?>
                        </div>

                        <div class="court-name">
                            <?= htmlspecialchars($court['name']) ?>
                        </div>

                        <div class="price">
                            <?= number_format($court['price']) ?>
                            <small>VNĐ / giờ</small>
                        </div>

                        <div class="card-footer">

                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <div class="action-left">

                                    <a href="index.php?action=edit&id=<?= $court['id'] ?>"
                                    class="btn-icon">
                                        <i class="fa fa-pen"></i>
                                    </a>

                                    <a href="index.php?action=delete&id=<?= $court['id'] ?>"
                                    class="btn-icon btn-delete"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </div>
                            <?php endif; ?>

                            <a href="index.php?action=booking&id=<?= $court['id'] ?>"
                               class="btn-book">
                                Đặt sân
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-box">
                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png"
                     width="100"
                     style="opacity:.25">

                <p class="mt-3 text-muted">
                    Không tìm thấy sân nào
                </p>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>