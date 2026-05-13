<?php require_once PROJECT_ROOT . '/views/layout/header.php'; ?>

<style>
    :root {
        --primary: #00c07f;
        --primary-dark: #00a06a;
        --primary-soft: #e6faf3;
        --dark: #0f172a;
        --mid: #475569;
        --muted: #94a3b8;
        --border: #e2e8f0;
        --surface: #fff;
        --page-bg: #f1f5f9;
    }

    .rp-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 36px 24px 60px;
    }

    .rp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .rp-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: var(--dark);
        letter-spacing: -.4px;
        margin: 0;
    }

    .rp-header h1 span {
        color: var(--primary);
    }

    .btn-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--mid);
        cursor: pointer;
        text-decoration: none;
        transition: all .15s;
    }

    .btn:hover {
        background: var(--page-bg);
    }

    .btn-primary {
        background: var(--primary);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 2px 8px rgba(0, 192, 127, .25);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-export {
        background: #1e293b;
        color: #fff;
        border-color: transparent;
    }

    .btn-export:hover {
        background: #334155;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media(max-width:900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:520px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 20px 20px 18px;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--muted);
        letter-spacing: .4px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: var(--dark);
        letter-spacing: -.5px;
    }

    .stat-value.green {
        color: var(--primary);
    }

    .stat-sub {
        font-size: 12px;
        color: var(--muted);
        margin-top: 4px;
        font-weight: 600;
    }

    .filter-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 22px;
    }

    .filter-row {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
        min-width: 140px;
    }

    .field label {
        font-size: 12px;
        font-weight: 800;
        color: var(--mid);
    }

    .input,
    .select {
        padding: 9px 12px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        color: var(--dark);
        background: #fff;
        outline: none;
    }

    .input:focus,
    .select:focus {
        border-color: rgba(0, 192, 127, .6);
        box-shadow: 0 0 0 3px rgba(0, 192, 127, .12);
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
        margin-bottom: 22px;
    }

    @media(max-width:860px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 20px;
    }

    .chart-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 16px;
    }

    .table-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }

    .table-head {
        padding: 14px 18px;
        border-bottom: 1.5px solid var(--border);
    }

    .table-head h3 {
        font-size: 14px;
        font-weight: 800;
        color: var(--dark);
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th,
    td {
        padding: 11px 16px;
        font-size: 13px;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }

    th {
        background: var(--page-bg);
        font-weight: 800;
        color: var(--mid);
    }

    td {
        font-weight: 600;
        color: var(--dark);
    }

    tr:last-child td {
        border-bottom: none;
    }

    .text-right {
        text-align: right;
    }

    .text-green {
        color: var(--primary);
        font-weight: 800;
    }

    .empty-state {
        padding: 40px;
        text-align: center;
        color: var(--muted);
        font-weight: 700;
    }
</style>

<div class="rp-page">

    <div class="rp-header">
        <h1><span>Báo cáo</span> Doanh Thu</h1>
        <div class="btn-group">
            <a href="index.php?action=owner_report_revenue_export&type=revenue&date_from=<?= urlencode($_GET['date_from'] ?? '') ?>&date_to=<?= urlencode($_GET['date_to'] ?? '') ?>" class="btn btn-export">
                <i class="fas fa-file-csv"></i> Xuất Doanh Thu
            </a>
            <!-- <a href="index.php?action=owner_report_revenue_export&type=booking&date_from=<?= urlencode($_GET['date_from'] ?? '') ?>&date_to=<?= urlencode($_GET['date_to'] ?? '') ?>" class="btn btn-export">
                <i class="fas fa-file-csv"></i> Xuất CSV Đặt Sân
            </a> -->
        </div>
    </div>

    <div class="filter-card">
        <form method="get" action="index.php">
            <input type="hidden" name="action" value="owner_report_revenue" />
            <div class="filter-row">
                <div class="field">
                    <label>Từ ngày</label>
                    <input class="input" type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>" />
                </div>
                <div class="field">
                    <label>Đến ngày</label>
                    <input class="input" type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>" />
                </div>
                <div class="field">
                    <label>Năm (biểu đồ tháng)</label>
                    <select class="select" name="year">
                        <?php for ($y = date('Y'); $y >= date('Y') - 4; $y--): ?>
                            <option value="<?= $y ?>" <?= ($y === $year) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="field" style="flex:0">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                </div>
                <div class="field" style="flex:0">
                    <label>&nbsp;</label>
                    <a href="index.php?action=owner_report_revenue" class="btn">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <?php
    $totalBookingsAll = array_sum(array_column($revenueByCourt, 'booking_count'));
    $cashRevenue = 0;
    $qrRevenue = 0;
    foreach ($revenueByMethod as $m) {
        if ($m['payment_method'] === 'cash') $cashRevenue = $m['revenue'];
        if ($m['payment_method'] === 'qr')   $qrRevenue   = $m['revenue'];
    }
    ?>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Tổng doanh thu</div>
            <div class="stat-value green"><?= number_format($totalRevenue, 0, ',', '.') ?>đ</div>
            <div class="stat-sub">Chỉ tính đặt sân Confirmed</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Số đặt sân</div>
            <div class="stat-value"><?= $totalBookingsAll ?></div>
            <div class="stat-sub">Tổng đặt sân đã xác nhận</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tiền mặt</div>
            <div class="stat-value"><?= number_format($cashRevenue, 0, ',', '.') ?>đ</div>
            <div class="stat-sub">Thanh toán tiền mặt</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">QR Code</div>
            <div class="stat-value"><?= number_format($qrRevenue, 0, ',', '.') ?>đ</div>
            <div class="stat-sub">Thanh toán QR</div>
        </div>
    </div>

    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-title">Doanh thu theo tháng – <?= $year ?></div>
            <canvas id="chartMonth" height="90"></canvas>
        </div>
        <div class="chart-card">
            <div class="chart-title">Cơ cấu thanh toán</div>
            <canvas id="chartMethod" height="160"></canvas>
        </div>
    </div>

    <?php if (!empty($revenueByDay)): ?>
        <div class="chart-card" style="margin-bottom:22px;">
            <div class="chart-title">Doanh thu theo ngày</div>
            <canvas id="chartDay" height="70"></canvas>
        </div>
    <?php endif; ?>

    <div class="table-card">
        <div class="table-head">
            <h3>Doanh thu theo sân</h3>
        </div>
        <?php if (empty($revenueByCourt)): ?>
            <div class="empty-state">Không có dữ liệu</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Sân</th>
                        <th class="text-right">Số lần đặt</th>
                        <th class="text-right">Doanh thu</th>
                        <th class="text-right">Tỷ lệ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($revenueByCourt as $court): ?>
                        <tr>
                            <td><?= htmlspecialchars($court['court_name']) ?></td>
                            <td class="text-right"><?= $court['booking_count'] ?></td>
                            <td class="text-right text-green"><?= number_format($court['revenue'], 0, ',', '.') ?>đ</td>
                            <td class="text-right"><?= $totalRevenue > 0 ? number_format($court['revenue'] / $totalRevenue * 100, 1) : 0 ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    (function() {
        const primary = '#00c07f';
        new Chart(document.getElementById('chartMonth'), {
            type: 'bar',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Doanh thu (đ)',
                    data: <?= json_encode(array_column($revenueByMonth, 'revenue')) ?>,
                    backgroundColor: 'rgba(0,192,127,.25)',
                    borderColor: primary,
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: v => (v / 1000000).toFixed(1) + 'M'
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        <?php
        $methodLabels = [];
        $methodData = [];
        foreach ($revenueByMethod as $m) {
            $methodLabels[] = $m['payment_method'] === 'qr' ? 'QR Code' : 'Tiền mặt';
            $methodData[]   = $m['revenue'];
        }
        ?>
        const methodData = <?= json_encode($methodData) ?>;
        if (methodData.length > 0) {
            new Chart(document.getElementById('chartMethod'), {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($methodLabels) ?>,
                    datasets: [{
                        data: methodData,
                        backgroundColor: ['#3b82f6', '#00c07f'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    weight: '700'
                                },
                                padding: 14
                            }
                        }
                    },
                    cutout: '68%'
                }
            });
        }

        <?php if (!empty($revenueByDay)): ?>
            new Chart(document.getElementById('chartDay'), {
                type: 'line',
                data: {
                    labels: <?= json_encode(array_column($revenueByDay, 'day')) ?>,
                    datasets: [{
                        label: 'Doanh thu (đ)',
                        data: <?= json_encode(array_column($revenueByDay, 'revenue')) ?>,
                        borderColor: primary,
                        backgroundColor: 'rgba(0,192,127,.08)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: primary
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: v => (v / 1000000).toFixed(1) + 'M'
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        <?php endif; ?>
    })();
</script>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>