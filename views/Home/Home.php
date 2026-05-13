<?php
// Tin tức mẫu (static)
$tinTuc = [
    [
        'tieu_de' => 'Khai trương sân cầu lông tiêu chuẩn quốc tế tại Cái Răng',
        'tom_tat' => 'SportHub vừa khai trương thêm 2 sân cầu lông đạt tiêu chuẩn quốc tế tại khu vực Cái Răng, Cần Thơ với hệ thống đèn LED chiếu sáng hiện đại.',
        'ngay'    => '10/05/2026',
        'icon'    => 'fa-newspaper',
        'mau'     => '#e6faf3',
        'mau_icon'=> '#00c07f',
    ],
    [
        'tieu_de' => 'Hướng dẫn đặt sân online chỉ trong 2 phút',
        'tom_tat' => 'Với giao diện mới được cải tiến, bạn có thể chọn sân, chọn giờ và xác nhận đặt sân hoàn toàn trực tuyến mà không cần gọi điện.',
        'ngay'    => '07/05/2026',
        'icon'    => 'fa-mobile-alt',
        'mau'     => '#eff6ff',
        'mau_icon'=> '#3b82f6',
    ],
    [
        'tieu_de' => 'Lịch thi đấu giao lưu cầu lông tháng 6/2026',
        'tom_tat' => 'SportHub phối hợp tổ chức giải giao lưu cầu lông mở rộng dành cho mọi trình độ. Đăng ký tham dự ngay để nhận ưu đãi đặt sân miễn phí.',
        'ngay'    => '05/05/2026',
        'icon'    => 'fa-trophy',
        'mau'     => '#fff7ed',
        'mau_icon'=> '#f59e0b',
    ],
];

// Khuyến mãi mẫu (static)
$khuyenMai = [
    [
        'tieu_de'   => 'Giảm 20% khung giờ sáng',
        'noi_dung'  => 'Đặt sân từ 6:00 – 9:00 sáng, giảm ngay 20% cho tất cả các sân. Áp dụng đến hết tháng 6/2026.',
        'badge'     => '-20%',
        'han'       => 'Hết hạn: 30/06/2026',
        'mau_badge' => '#00c07f',
        'icon'      => 'fa-sun',
    ],
    [
        'tieu_de'   => 'Combo 10 buổi – tiết kiệm 15%',
        'noi_dung'  => 'Mua gói 10 buổi liên tiếp tại cùng một sân, tiết kiệm 15% so với giá lẻ. Dùng thả ga cả tháng.',
        'badge'     => '10 buổi',
        'han'       => 'Áp dụng thường xuyên',
        'mau_badge' => '#3b82f6',
        'icon'      => 'fa-layer-group',
    ],
    [
        'tieu_de'   => 'Thành viên mới – buổi đầu miễn phí',
        'noi_dung'  => 'Đăng ký tài khoản mới và đặt sân lần đầu, bạn được tặng 1 buổi chơi miễn phí (tối đa 100.000đ).',
        'badge'     => 'FREE',
        'han'       => 'Dành cho tài khoản mới',
        'mau_badge' => '#f59e0b',
        'icon'      => 'fa-gift',
    ],
];
?>

<style>
:root {
    --primary: #00c07f;
    --primary-dark: #00a06a;
    --primary-soft: #e6faf3;
    --dark: #0f172a;
    --mid: #475569;
    --muted: #94a3b8;
    --border: #e2e8f0;
    --surface: #ffffff;
    --page-bg: #f1f5f9;
}

/* ── Layout ── */
.home-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 36px 24px 72px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── Section header ── */
.sec-head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 22px;
}
.sec-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--dark);
    letter-spacing: -.4px;
}
.sec-title span { color: var(--primary); }
.sec-more {
    font-size: 13px;
    font-weight: 700;
    color: var(--primary);
    text-decoration: none;
}
.sec-more:hover { text-decoration: underline; }

/* ── HERO ── */
.hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #00503a 100%);
    border-radius: 20px;
    padding: 60px 48px;
    margin-bottom: 52px;
    position: relative;
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2300c07f' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.hero-content { position: relative; z-index: 1; max-width: 600px; }
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(0,192,127,.2);
    border: 1px solid rgba(0,192,127,.35);
    color: #4ade80;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    margin-bottom: 18px;
    letter-spacing: .3px;
}
.hero h1 {
    font-size: 40px;
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    letter-spacing: -.6px;
    margin: 0 0 14px;
}
.hero h1 span { color: var(--primary); }
.hero p {
    font-size: 16px;
    color: #94a3b8;
    margin: 0 0 28px;
    line-height: 1.6;
}
.hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }
.btn-hero-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary);
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 12px;
    text-decoration: none;
    box-shadow: 0 4px 16px rgba(0,192,127,.35);
    transition: background .2s, transform .15s;
}
.btn-hero-primary:hover { background: var(--primary-dark); transform: translateY(-2px); color: #fff; }
.btn-hero-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.08);
    border: 1.5px solid rgba(255,255,255,.15);
    color: #e2e8f0;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 12px;
    text-decoration: none;
    transition: background .2s;
}
.btn-hero-ghost:hover { background: rgba(255,255,255,.14); color: #fff; }

/* Hero stats */
.hero-stats {
    display: flex;
    gap: 32px;
    margin-top: 36px;
    padding-top: 28px;
    border-top: 1px solid rgba(255,255,255,.08);
}
.hero-stat-value {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
}
.hero-stat-label {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
    font-weight: 600;
}

/* Hero decoration */
.hero-deco {
    position: absolute;
    right: 48px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 120px;
    opacity: .06;
    pointer-events: none;
}

/* ── KHUYẾN MÃI ── */
.promo-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 52px;
}
@media (max-width: 900px) { .promo-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 580px) { .promo-grid { grid-template-columns: 1fr; } }

.promo-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 18px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.promo-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,.1);
    transform: translateY(-3px);
}
.promo-badge {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 900;
    color: #fff;
    margin-bottom: 14px;
}
.promo-icon {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 28px;
    opacity: .12;
}
.promo-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 8px;
}
.promo-desc {
    font-size: 13px;
    color: var(--mid);
    line-height: 1.6;
    margin-bottom: 14px;
}
.promo-deadline {
    font-size: 11px;
    font-weight: 700;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ── COURTS (featured) ── */
.courts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 52px;
}
@media (max-width: 900px) { .courts-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 580px) { .courts-grid { grid-template-columns: 1fr; } }

.court-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.court-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); transform: translateY(-3px); }
.court-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 36px;
}
.court-img img { width: 100%; height: 100%; object-fit: cover; }
.court-body { padding: 16px; }
.court-name {
    font-size: 15px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 4px;
}
.court-addr {
    font-size: 12px;
    color: var(--muted);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.court-price {
    font-size: 18px;
    font-weight: 800;
    color: var(--primary);
}
.court-price span { font-size: 12px; font-weight: 600; color: var(--muted); }
.court-foot {
    padding: 0 16px 16px;
}
.btn-book {
    display: block;
    text-align: center;
    background: var(--primary);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    padding: 10px;
    border-radius: 10px;
    text-decoration: none;
    transition: background .2s;
}
.btn-book:hover { background: var(--primary-dark); color: #fff; }
.status-dot {
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--primary);
    margin-right: 4px;
    vertical-align: middle;
}

/* ── TIN TỨC ── */
.news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 52px;
}
@media (max-width: 900px) { .news-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 580px) { .news-grid { grid-template-columns: 1fr; } }

.news-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 18px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: box-shadow .2s, transform .2s;
}
.news-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); transform: translateY(-3px); }
.news-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.news-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--dark);
    line-height: 1.4;
}
.news-desc {
    font-size: 13px;
    color: var(--mid);
    line-height: 1.6;
    flex: 1;
}
.news-date {
    font-size: 11px;
    font-weight: 700;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 5px;
}
.news-read {
    font-size: 12px;
    font-weight: 700;
    color: var(--primary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.news-read:hover { text-decoration: underline; }

/* ── CTA ── */
.cta-band {
    background: linear-gradient(135deg, var(--primary), #00a06a);
    border-radius: 20px;
    padding: 44px 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
}
.cta-text h2 { font-size: 24px; font-weight: 800; color: #fff; margin: 0 0 6px; }
.cta-text p  { font-size: 14px; color: rgba(255,255,255,.8); margin: 0; }
.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: var(--primary);
    font-size: 14px;
    font-weight: 800;
    padding: 13px 28px;
    border-radius: 12px;
    text-decoration: none;
    white-space: nowrap;
    transition: transform .15s, box-shadow .15s;
    box-shadow: 0 4px 16px rgba(0,0,0,.15);
}
.btn-cta:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.2); color: var(--primary); }
</style>

<div class="home-wrap">

    <!-- ══ HERO ══ -->
    <div class="hero">
        <div class="hero-deco"><i class="fas fa-table-tennis-paddle-ball"></i></div>
        <div class="hero-content">
            <div class="hero-badge"><i class="fas fa-circle" style="font-size:6px"></i> Hệ thống đặt sân #1 Cần Thơ</div>
            <h1>Đặt sân thể thao<br><span>nhanh – dễ – tiết kiệm</span></h1>
            <p>Chọn sân, chọn giờ và xác nhận đặt chỗ chỉ trong vài giây. Không cần gọi điện, không cần chờ đợi.</p>
            <div class="hero-btns">
                <a href="index.php?action=index" class="btn-hero-primary">
                    <i class="fas fa-calendar-plus"></i> Đặt sân ngay
                </a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="index.php?action=register" class="btn-hero-ghost">
                    <i class="fas fa-user-plus"></i> Đăng ký miễn phí
                </a>
                <?php endif; ?>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-value">5+</div>
                    <div class="hero-stat-label">Sân hoạt động</div>
                </div>
                <div>
                    <div class="hero-stat-value">100+</div>
                    <div class="hero-stat-label">Lượt đặt sân</div>
                </div>
                <div>
                    <div class="hero-stat-value">24/7</div>
                    <div class="hero-stat-label">Đặt online</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ KHUYẾN MÃI ══ -->
    <div class="sec-head">
        <div class="sec-title">🔥 <span>Khuyến mãi</span> nổi bật</div>
    </div>
    <div class="promo-grid">
        <?php foreach ($khuyenMai as $km): ?>
        <div class="promo-card">
            <i class="fas <?= $km['icon'] ?> promo-icon"></i>
            <div class="promo-badge" style="background:<?= $km['mau_badge'] ?>"><?= $km['badge'] ?></div>
            <div class="promo-title"><?= htmlspecialchars($km['tieu_de']) ?></div>
            <div class="promo-desc"><?= htmlspecialchars($km['noi_dung']) ?></div>
            <div class="promo-deadline"><i class="fas fa-clock"></i> <?= htmlspecialchars($km['han']) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ══ TIN TỨC ══ -->
    <div class="sec-head">
        <div class="sec-title">📰 <span>Tin tức</span> mới nhất</div>
    </div>
    <div class="news-grid">
        <?php foreach ($tinTuc as $tin): ?>
        <div class="news-card">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="news-icon-wrap" style="background:<?= $tin['mau'] ?>">
                    <i class="fas <?= $tin['icon'] ?>" style="color:<?= $tin['mau_icon'] ?>"></i>
                </div>
                <div class="news-date"><i class="fas fa-calendar-alt"></i> <?= $tin['ngay'] ?></div>
            </div>
            <div class="news-title"><?= htmlspecialchars($tin['tieu_de']) ?></div>
            <div class="news-desc"><?= htmlspecialchars($tin['tom_tat']) ?></div>
            <a href="index.php?action=index" class="news-read">
                Xem thêm <i class="fas fa-arrow-right" style="font-size:10px"></i>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ══ CTA ══ -->
    <div class="cta-band">
        <div class="cta-text">
            <h2>Sẵn sàng chơi chưa?</h2>
            <p>Hàng chục khung giờ trống mỗi ngày đang chờ bạn đặt.</p>
        </div>
        <a href="index.php?action=index" class="btn-cta">
            <i class="fas fa-table-tennis-paddle-ball"></i> Xem sân & đặt ngay
        </a>
    </div>

</div>
