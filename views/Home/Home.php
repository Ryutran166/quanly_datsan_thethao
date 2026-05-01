<?php
$data = $data ?? [
    'khuyenMai' => [],
    'sanNoiBat' => [],
    'tinTuc' => []
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f7, #f8f9fa);
            font-family: 'Segoe UI', sans-serif;
        }

        .section-title {
            font-weight: 700;
            margin: 40px 0 20px;
            font-size: 22px;
        }

        /* BANNER */
        .banner {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 50px;
            border-radius: 16px;
            text-align: center;
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            transition: 0.3s;
            position: relative;
        }

        .card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .img-box {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }

        /* SCROLL NGANG */
        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 10px 5px 20px;
            scroll-behavior: smooth;
            cursor: grab;
        }

        .horizontal-scroll:active {
            cursor: grabbing;
        }

        .scroll-card {
            min-width: 260px;
            flex-shrink: 0;
        }

        .scroll-card .card {
            background: linear-gradient(135deg, #fff, #f1f3f5);
            padding: 15px;
        }

        .price {
            font-weight: bold;
            color: #28a745;
        }

        /* HOVER BOOK */
        .book-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: 0.3s;
        }

        .card:hover .book-overlay {
            opacity: 1;
        }

        .book-overlay a {
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-book{
            display:block;
            text-align:center;
            background:#28a745;
            color:white;
            padding:10px;
            border-radius:10px;
            font-weight:600;
            text-decoration:none;
            transition:0.2s;
            margin-top:10px;
        }

        .btn-book:hover{
            background:#218838;
            transform:scale(1.03);
            color:white;
        }


    </style>
</head>

<body>

<div class="container-fluid px-4 py-4">

    <!-- BANNER -->
    <div class="banner mb-4">
        <h1>Hệ thống đặt sân thể thao</h1>
        <p>Đặt sân nhanh - giá tốt - dễ sử dụng</p>
    </div>

    <!-- KHUYẾN MÃI -->
    <h3 class="section-title">🔥 Khuyến mãi</h3>

    <div class="row">
        <?php foreach ($data['khuyenMai'] ?? [] as $km): ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">

                    <?php if (!empty($km['hinh_anh'])): ?>
                        <img src="/quanly_datsan_thethao/uploads/<?= $km['hinh_anh'] ?>" class="img-box">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5><?= $km['tieu_de'] ?></h5>
                        <p><?= $km['noi_dung'] ?></p>
                        <small>
                            <?= $km['ngay_bat_dau'] ?> → <?= $km['ngay_ket_thuc'] ?>
                        </small>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- SÂN NỔI BẬT -->
    <h3 id="san-noi-bat" class="section-title">🏟️ Sân nổi bật</h3>

    <?php if (!empty($data['sanNoiBat'])): ?>

    <div class="horizontal-scroll" id="slider">

        <?php foreach ($data['sanNoiBat'] as $san): ?>
            <?php $img = $san['image'] ?? null; ?>

            <div class="scroll-card">
                <div class="card h-100 shadow-sm">

                    <!-- IMAGE -->
                    <?php if (!empty($img)): ?>
                        <img src="/quanly_datsan_thethao/uploads/<?= $img ?>" class="img-box">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x180?text=No+Image" class="img-box">
                    <?php endif; ?>

                    <!-- CONTENT -->
                    <div class="card-body d-flex flex-column">

                        <h5 class="mb-1">
                            <?= htmlspecialchars($san['name']) ?>
                        </h5>

                        <p class="price mb-3">
                            💰 <?= number_format($san['price']) ?>đ / giờ
                        </p>

                        <!-- NÚT CHUYỂN SANG DANH SÁCH / BOOKING FLOW -->
                        <a href="index.php?action=index"
                        class="btn btn-success mt-auto w-100 shadow-sm">
                            🏟️ Đặt sân ngay
                        </a>

                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <?php else: ?>
        <p class="text-muted">Chưa có sân nổi bật</p>
    <?php endif; ?>

    <!-- NÚT CHUNG BÊN NGOÀI -->
    <div class="text-center mt-4">
        <a href="index.php?action=index"
        class="btn btn-lg btn-success px-4 py-2 shadow">
            🏟️ Xem tất cả sân & đặt sân
        </a>
    </div>

    <!-- TIN TỨC -->
    <h3 class="section-title">📰 Tin tức mới</h3>

    <div class="row">
        <?php foreach ($data['tinTuc'] ?? [] as $tin): ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">

                    <?php if (!empty($tin['hinh_anh'])): ?>
                        <img src="/quanly_datsan_thethao/uploads/<?= $tin['hinh_anh'] ?>" class="img-box">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5><?= $tin['tieu_de'] ?></h5>
                        <p><?= substr($tin['noi_dung'], 0, 100) ?>...</p>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- AUTO SCROLL + DRAG -->
<script>
const slider = document.getElementById('slider');

// drag
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
});

slider.addEventListener('mouseleave', () => isDown = false);
slider.addEventListener('mouseup', () => isDown = false);

slider.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 2;
    slider.scrollLeft = scrollLeft - walk;
});

// auto scroll
setInterval(() => {
    slider.scrollLeft += 1;

    if (slider.scrollLeft >= slider.scrollWidth - slider.clientWidth) {
        slider.scrollLeft = 0;
    }
}, 20);
</script>

</body>
</html>