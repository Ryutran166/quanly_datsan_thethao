<?php
function statusBadge(string $status, string $date): string {
    $status = strtolower($status);
    if ($status === 'cancelled')
        return '<span class="status-badge cancelled">Đã hủy</span>';
    if (strtotime($date) < strtotime('today'))
        return '<span class="status-badge done">Đã xong</span>';
    return '<span class="status-badge confirmed">Đã xác nhận</span>';
}
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary:      #00c07f;
        --primary-dark: #00a06a;
        --primary-soft: #e6faf3;
        --danger:       #f43f5e;
        --danger-soft:  #fff1f3;
        --dark:         #0f172a;
        --mid:          #475569;
        --muted:        #94a3b8;
        --border:       #e2e8f0;
        --surface:      #ffffff;
        --page-bg:      #f1f5f9;
    }

    .mb-page {
        max-width: 860px;
        margin: 0 auto;
        padding: 40px 24px 60px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* ── Page header ── */
    .mb-header { margin-bottom: 28px; }
    .mb-header h2 {
        font-size: 26px;
        font-weight: 800;
        color: var(--dark);
        letter-spacing: -.5px;
        margin: 0 0 4px;
    }
    .mb-header p { font-size: 14px; color: var(--muted); margin: 0; font-weight: 500; }

    /* ── Alerts ── */
    .mb-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .mb-alert.success { background: var(--primary-soft); color: #065f46; border: 1.5px solid rgba(0,192,127,.25); }
    .mb-alert.error   { background: var(--danger-soft);  color: #be123c; border: 1.5px solid rgba(244,63,94,.2); }

    /* ── Tabs ── */
    .mb-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 24px;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 5px;
        width: fit-content;
    }

    .mb-tab {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        text-decoration: none;
        transition: background .18s, color .18s;
        white-space: nowrap;
    }

    .mb-tab:hover { color: var(--dark); background: var(--page-bg); }

    .mb-tab.active {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 2px 8px rgba(0,192,127,.3);
    }

    .tab-count {
        font-size: 11px;
        font-weight: 700;
        padding: 1px 7px;
        border-radius: 20px;
        background: rgba(255,255,255,.25);
        color: inherit;
    }

    .mb-tab:not(.active) .tab-count {
        background: var(--page-bg);
        color: var(--mid);
    }

    /* ── Status badges ── */
    .status-badge {
        display: inline-block;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
    }
    .status-badge.confirmed { background: var(--primary-soft); color: #065f46; }
    .status-badge.done      { background: var(--page-bg); color: var(--mid); }
    .status-badge.cancelled { background: var(--danger-soft); color: #be123c; }

    /* ── Booking list ── */
    .booking-list { display: flex; flex-direction: column; gap: 14px; }

    .booking-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 18px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: box-shadow .2s, border-color .2s;
    }

    .booking-card:hover {
        box-shadow: 0 4px 20px rgba(15,23,42,.08);
        border-color: #cbd5e1;
    }

    /* court image */
    .booking-img {
        width: 82px;
        height: 82px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
        background: var(--page-bg);
    }

    /* info block */
    .booking-info { flex: 1; min-width: 0; }

    .booking-top {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .booking-name {
        font-size: 16px;
        font-weight: 800;
        color: var(--dark);
    }

    .booking-meta {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        font-size: 13px;
        color: var(--mid);
        font-weight: 500;
        margin-bottom: 6px;
    }

    .booking-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .booking-meta i { color: var(--primary); font-size: 12px; }

    .booking-created {
        font-size: 11px;
        color: var(--muted);
        font-weight: 500;
    }

    /* action buttons */
    .booking-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-rebook {
        padding: 8px 18px;
        background: var(--page-bg);
        color: var(--mid);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: background .15s, color .15s, border-color .15s;
        white-space: nowrap;
    }
    .btn-rebook:hover { background: var(--border); color: var(--dark); }

    .btn-cancel {
        padding: 8px 18px;
        background: var(--danger-soft);
        color: var(--danger);
        border: 1.5px solid rgba(244,63,94,.2);
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: background .15s;
        white-space: nowrap;
    }
    .btn-cancel:hover { background: #fecdd3; }

    /* ── Empty state ── */
    .mb-empty {
        text-align: center;
        padding: 70px 30px;
        background: var(--surface);
        border: 1.5px dashed var(--border);
        border-radius: 20px;
    }

    .empty-icon {
        width: 60px; height: 60px;
        background: var(--page-bg);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px;
        margin: 0 auto 16px;
    }

    .mb-empty h3 { font-size: 17px; font-weight: 700; color: var(--dark); margin: 0 0 6px; }
    .mb-empty p  { font-size: 13px; color: var(--muted); margin: 0 0 20px; }

    .btn-go-book {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 22px;
        background: var(--primary);
        color: #fff;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,192,127,.3);
        transition: background .2s, transform .15s;
    }
    .btn-go-book:hover { background: var(--primary-dark); transform: translateY(-1px); }
</style>

<div class="mb-page">

    <!-- Header -->
    <div class="mb-header">
        <h2>Lịch sử đặt sân</h2>
        <p>Quản lý các lịch đặt sân của bạn</p>
    </div>

    <!-- Alerts -->
    <?php if (!empty($_GET['success']) && $_GET['success'] === 'cancelled'): ?>
        <div class="mb-alert success">
            <i class="fas fa-check-circle"></i>
            Hủy lịch thành công. Tiền sẽ được hoàn trong 1–3 ngày làm việc.
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error']) && $_GET['error'] === 'cannot_cancel'): ?>
        <div class="mb-alert error">
            <i class="fas fa-exclamation-triangle"></i>
            Không thể hủy. Lịch đặt còn dưới 12 tiếng hoặc không tồn tại.
        </div>
    <?php endif; ?>

    <!-- Tabs -->
    <?php
    $tabs = [
        'upcoming'  => ['label' => 'Sắp tới',  'icon' => 'fa-clock',         'count' => count($upcoming)],
        'past'      => ['label' => 'Đã xong',  'icon' => 'fa-check',         'count' => count($past)],
        'cancelled' => ['label' => 'Đã hủy',   'icon' => 'fa-xmark',         'count' => count($cancelled)],
    ];
    $activeTab = $_GET['tab'] ?? 'upcoming';
    ?>

    <div class="mb-tabs">
        <?php foreach ($tabs as $key => $tab): ?>
            <a href="index.php?action=my_bookings&tab=<?= $key ?>"
               class="mb-tab <?= $activeTab === $key ? 'active' : '' ?>">
                <i class="fas <?= $tab['icon'] ?>" style="font-size:12px;"></i>
                <?= $tab['label'] ?>
                <?php if ($tab['count'] > 0): ?>
                    <span class="tab-count"><?= $tab['count'] ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Booking list -->
    <?php
    $displayList = match($activeTab) {
        'past'      => $past,
        'cancelled' => $cancelled,
        default     => $upcoming,
    };
    ?>

    <?php if (empty($displayList)): ?>

        <div class="mb-empty">
            <div class="empty-icon">📅</div>
            <h3>Không có lịch đặt nào</h3>
            <p>
                <?= match($activeTab) {
                    'past'      => 'Bạn chưa có lịch đặt đã hoàn thành.',
                    'cancelled' => 'Bạn chưa có lịch đặt nào bị hủy.',
                    default     => 'Bạn chưa có lịch đặt sân sắp tới.',
                } ?>
            </p>
            <?php if ($activeTab === 'upcoming'): ?>
                <a href="index.php?action=index" class="btn-go-book">
                    <i class="fas fa-plus" style="font-size:12px;"></i> Đặt sân ngay
                </a>
            <?php endif; ?>
        </div>

    <?php else: ?>

        <div class="booking-list">
            <?php foreach ($displayList as $b):
                $canCancel = $b['booking_status'] === 'confirmed'
                          && strtotime($b['booking_date'] . ' ' . $b['start_time']) - time() > 12 * 3600;
            ?>
            <div class="booking-card">

                <img class="booking-img"
                     src="<?= htmlspecialchars($b['image_url'] ?? 'assets/images/default-court.jpg') ?>"
                     alt="<?= htmlspecialchars($b['court_name']) ?>">

                <div class="booking-info">
                    <div class="booking-top">
                        <span class="booking-name"><?= htmlspecialchars($b['court_name']) ?></span>
                        <?= statusBadge($b['booking_status'], $b['booking_date']) ?>
                    </div>

                    <div class="booking-meta">
                        <span>
                            <i class="fas fa-calendar"></i>
                            <?= date('d/m/Y', strtotime($b['booking_date'])) ?>
                        </span>
                        <span>
                            <i class="fas fa-clock"></i>
                            <?= substr($b['start_time'],0,5) ?> – <?= substr($b['end_time'],0,5) ?>
                        </span>
                        <span>
                            <i class="fas fa-tag"></i>
                            <?= number_format($b['price']) ?> VNĐ
                        </span>
                    </div>

                    <div class="booking-created">
                        Đặt lúc <?= date('H:i · d/m/Y', strtotime($b['created_at'])) ?>
                    </div>
                </div>

                <div class="booking-actions">
                    <a href="index.php?action=booking&id=<?= (int)$b['court_id'] ?>"
                       class="btn-rebook">
                        <i class="fas fa-rotate-right" style="font-size:11px;margin-right:4px;"></i>Đặt lại
                    </a>
                    <?php if ($canCancel): ?>
                        <a href="index.php?action=cancel_booking&id=<?= (int)$b['booking_id'] ?>"
                           class="btn-cancel"
                           onclick="return confirm('Bạn chắc chắn muốn hủy lịch này?')">
                            <i class="fas fa-xmark" style="font-size:11px;margin-right:4px;"></i>Hủy lịch
                        </a>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>