<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary:      #00c07f;
        --primary-dark: #00a06a;
        --primary-soft: #e6faf3;
        --warning:      #f59e0b;
        --warning-soft: #fffbeb;
        --danger:       #f43f5e;
        --danger-soft:  #fff1f3;
        --dark:         #0f172a;
        --mid:          #475569;
        --muted:        #94a3b8;
        --border:       #e2e8f0;
        --surface:      #ffffff;
        --page-bg:      #f1f5f9;
    }

    .ab-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 24px 60px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .ab-header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ab-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: var(--dark);
        letter-spacing: -.5px;
        margin: 0;
    }

    .ab-header h1 span { color: var(--primary); }

    .total-chip {
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        background: var(--surface);
        border: 1.5px solid var(--border);
        padding: 5px 14px;
        border-radius: 20px;
    }

    .ab-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .ab-alert.success { background: var(--primary-soft); color: #065f46; border: 1.5px solid rgba(0,192,127,.25); }
    .ab-alert.error   { background: var(--danger-soft);  color: #be123c; border: 1.5px solid rgba(244,63,94,.2); }

    .ab-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 24px;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 14px;
        padding: 5px;
        width: fit-content;
        flex-wrap: wrap;
    }

    .ab-tab {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        text-decoration: none;
        transition: background .18s, color .18s;
        white-space: nowrap;
    }

    .ab-tab:hover { color: var(--dark); background: var(--page-bg); }
    .ab-tab.active { background: var(--primary); color: #fff; box-shadow: 0 2px 8px rgba(0,192,127,.3); }

    .tab-count {
        font-size: 11px;
        font-weight: 700;
        padding: 1px 7px;
        border-radius: 20px;
        background: rgba(255,255,255,.25);
    }

    .ab-tab:not(.active) .tab-count { background: var(--page-bg); color: var(--mid); }

    .s-badge {
        display: inline-block;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
    }

    .s-badge.pending   { background: var(--warning-soft); color: #92400e; border: 1px solid rgba(245,158,11,.2); }
    .s-badge.confirmed { background: var(--primary-soft); color: #065f46; }
    .s-badge.cancelled { background: var(--danger-soft);  color: #be123c; }

    .ab-list { display: flex; flex-direction: column; gap: 14px; }

    .ab-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 18px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: box-shadow .2s, border-color .2s;
    }

    .ab-card:hover {
        box-shadow: 0 4px 20px rgba(15,23,42,.08);
        border-color: #cbd5e1;
    }

    .ab-card.pending   { border-left: 4px solid var(--warning); }
    .ab-card.confirmed { border-left: 4px solid var(--primary); }
    .ab-card.cancelled { border-left: 4px solid var(--danger); opacity: .8; }

    .ab-info { flex: 1; min-width: 0; }

    .ab-top {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .ab-court-name {
        font-size: 16px;
        font-weight: 800;
        color: var(--dark);
    }

    .ab-meta {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 6px 20px;
        font-size: 12px;
        font-weight: 500;
        color: var(--mid);
        margin-bottom: 4px;
    }

    .ab-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .ab-meta-item i { color: var(--primary); font-size: 11px; width: 12px; }

    .ab-id {
        font-size: 11px;
        color: var(--muted);
        font-weight: 500;
        margin-top: 4px;
    }

    .ab-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-ok {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 16px;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s, transform .15s;
        box-shadow: 0 2px 6px rgba(0,192,127,.25);
        white-space: nowrap;
    }
    .btn-ok:hover { background: var(--primary-dark); transform: translateY(-1px); }

    .btn-disabled {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 16px;
        background: var(--page-bg);
        color: var(--mid);
        border: 1.5px dashed var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: default;
        white-space: nowrap;
    }

    .ab-empty {
        text-align: center;
        padding: 70px 30px;
        background: var(--surface);
        border: 1.5px dashed var(--border);
        border-radius: 20px;
    }

    .ab-empty-icon {
        width: 60px;
        height: 60px;
        background: var(--page-bg);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin: 0 auto 16px;
    }

    .ab-empty h3 { font-size: 17px; font-weight: 700; color: var(--dark); margin: 0 0 5px; }
    .ab-empty p  { font-size: 13px; color: var(--muted); margin: 0; }
</style>

<div class="ab-page">
    <?php
        $pending = $pending ?? [];
        $confirmed = $confirmed ?? [];
        $cancelled = $cancelled ?? [];
    ?>

    <div class="ab-header">
        <h1>Quản lý <span>đặt sân</span></h1>
        <?php
            $totalAll = count($pending) + count($confirmed) + count($cancelled);
        ?>
        <span class="total-chip"><?= $totalAll ?> booking</span>

        <a href="?action=owner_payment_search" class="btn-ok" style="height:fit-content; padding:8px 14px;">
            <i class="fas fa-filter" style="font-size:11px;"></i> Tìm kiếm đơn 
        </a>
    </div>


    <?php if (!empty($_GET['success'])): ?>
        <div class="ab-alert success">
            <i class="fas fa-check-circle"></i>
            Đã xác nhận booking thành công!
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
        <div class="ab-alert error">
            <i class="fas fa-exclamation-triangle"></i>
            Có lỗi xảy ra. Vui lòng thử lại.
        </div>
    <?php endif; ?>

    <?php
        $tabs = [
            'all'       => ['label' => 'Tất cả',        'icon' => 'fa-list',          'count' => $totalAll],
            'pending'  => ['label' => 'Chờ xác nhận', 'icon' => 'fa-hourglass-half','count' => count($pending)],
            'confirmed'=> ['label' => 'Đã xác nhận',  'icon' => 'fa-check',         'count' => count($confirmed)],
            'cancelled'=> ['label' => 'Đã hủy',       'icon' => 'fa-xmark',         'count' => count($cancelled)],
        ];
        $activeTab = $_GET['tab'] ?? 'all';
    ?>

    <div class="ab-tabs">
        <?php foreach ($tabs as $key => $tab): ?>
            <a href="?action=owner_bookings&tab=<?= $key ?>" class="ab-tab <?= $activeTab === $key ? 'active' : '' ?>">
                <i class="fas <?= $tab['icon'] ?>" style="font-size:11px;"></i>
                <?= $tab['label'] ?>
                <?php if ($tab['count'] > 0): ?>
                    <span class="tab-count"><?= $tab['count'] ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php
        $displayList = match($activeTab) {
            'pending'   => $pending,
            'confirmed' => $confirmed,
            'cancelled' => $cancelled,
            default     => array_merge($pending, $confirmed, $cancelled),
        };
    ?>

    <?php if (empty($displayList)): ?>
        <div class="ab-empty">
            <div class="ab-empty-icon">📌</div>
            <h3>Không có booking nào</h3>
            <p>Danh mục này hiện chưa có dữ liệu.</p>
        </div>
    <?php else: ?>
        <div class="ab-list">
            <?php foreach ($displayList as $b): ?>
                <?php $statusKey = strtolower($b['status']); ?>
                <div class="ab-card <?= $statusKey ?>">
                    <div class="ab-info">
                        <div class="ab-top">
                            <span class="ab-court-name"><?= htmlspecialchars($b['court_name']) ?></span>
                            <span class="s-badge <?= $statusKey ?>">
                                <?= match($statusKey) {
                                    'pending' => '⏳ Chờ xác nhận',
                                    'confirmed' => '✓ Đã xác nhận',
                                    'cancelled' => '✕ Đã hủy',
                                    default => $b['status']
                                } ?>
                            </span>
                        </div>

                        <div class="ab-meta">
                            <div class="ab-meta-item">
                                <i class="fas fa-user"></i>
                                <?= htmlspecialchars($b['customer_name']) ?>
                            </div>
                            <div class="ab-meta-item">
                                <i class="fas fa-phone"></i>
                                <?= htmlspecialchars($b['customer_phone'] ?: '—') ?>
                            </div>
                            <div class="ab-meta-item">
                                <i class="fas fa-calendar"></i>
                                <?= date('d/m/Y', strtotime($b['booking_date'])) ?>
                            </div>
                            

                            <div class="ab-meta-item">
                                <i class="fas fa-tag"></i>
                                <?= number_format($b['total_amount'] ?? ($b['price'] ?? 0)) ?> VNĐ
                            </div>

                            <div class="ab-meta-item">
                                <i class="fas fa-credit-card"></i>
                                <?php
                                    $pm = strtolower((string)($b['payment_method'] ?? 'cash'));
                                    $pmLabel = match($pm) {
                                        'qr'   => 'Chuyển khoản bằng QR',
                                        'cash' => 'Thanh toán trực tiếp',
                                        default => $pm,
                                    };
                                ?>
                                <?= htmlspecialchars($pmLabel) ?>
                            </div>

                        </div>

                        <div class="ab-id"># Booking ID: <?= (int)$b['id'] ?></div>

                        <?php if (!empty($b['slots'])): ?>
                            <div style="margin-top:10px; font-size:12px; color:var(--mid);">
                                <div style="font-weight:800; color:var(--dark); margin-bottom:6px;">Khung giờ:</div>
                                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                                    <?php foreach ($b['slots'] as $s): ?>
                                        <span style="padding:4px 10px; border:1px solid var(--border); border-radius:999px; background:#fff;">
                                            <?= substr($s['start_time'],0,5) ?>-<?= substr($s['end_time'],0,5) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="ab-actions">
                        <?php
                            $ownerConfirmed = !empty($b['owner_confirmed_at']);
                            if (!$ownerConfirmed && strtolower($b['status']) !== 'cancelled'):
                        ?>
                            <a href="?action=owner_confirm_booking&id=<?= (int)$b['id'] ?>" class="btn-ok" onclick="return confirm('Xác nhận booking này?')">
                                <i class="fas fa-check" style="font-size:11px;"></i> Xác nhận
                            </a>
                        <?php else: ?>
                            <span class="btn-disabled"><i class="fas fa-check" style="font-size:11px;"></i> Đã xác nhận</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>


