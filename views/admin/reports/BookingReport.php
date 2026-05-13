<?php require_once PROJECT_ROOT . '/views/layout/header.php'; ?>

<style>
:root{--primary:#00c07f;--primary-dark:#00a06a;--primary-soft:#e6faf3;--warning:#f59e0b;--warning-soft:#fffbeb;--danger:#f43f5e;--danger-soft:#fff1f3;--dark:#0f172a;--mid:#475569;--muted:#94a3b8;--border:#e2e8f0;--surface:#fff;--page-bg:#f1f5f9;}
.rp-page{max-width:1200px;margin:0 auto;padding:36px 24px 60px;}
.rp-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;}
.rp-header h1{font-size:26px;font-weight:800;color:var(--dark);letter-spacing:-.4px;margin:0;}
.rp-header h1 span{color:var(--primary);}
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:12px;font-size:13px;font-weight:700;border:1.5px solid var(--border);background:var(--surface);color:var(--mid);cursor:pointer;text-decoration:none;transition:all .15s;}
.btn:hover{background:var(--page-bg);}
.btn-primary{background:var(--primary);color:#fff;border-color:transparent;box-shadow:0 2px 8px rgba(0,192,127,.25);}
.btn-primary:hover{background:var(--primary-dark);}
.btn-export{background:#1e293b;color:#fff;border-color:transparent;}
.btn-export:hover{background:#334155;}

/* Stats */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;}
@media(max-width:900px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:520px){.stats-grid{grid-template-columns:1fr;}}
.stat-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;padding:20px 20px 18px;}
.stat-label{font-size:12px;font-weight:700;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;margin-bottom:8px;}
.stat-value{font-size:26px;font-weight:800;color:var(--dark);letter-spacing:-.5px;}
.stat-value.green{color:var(--primary);}
.stat-value.warning{color:var(--warning);}
.stat-value.danger{color:var(--danger);}
.stat-sub{font-size:12px;color:var(--muted);margin-top:4px;font-weight:600;}

/* Filter */
.filter-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;padding:18px 20px;margin-bottom:22px;}
.filter-row{display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;}
.field{display:flex;flex-direction:column;gap:5px;flex:1;min-width:140px;}
.field label{font-size:12px;font-weight:800;color:var(--mid);}
.input,.select{padding:9px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;color:var(--dark);background:#fff;outline:none;}
.input:focus,.select:focus{border-color:rgba(0,192,127,.6);box-shadow:0 0 0 3px rgba(0,192,127,.12);}

/* Charts */
.charts-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:22px;}
@media(max-width:860px){.charts-grid{grid-template-columns:1fr;}}
.chart-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;padding:20px;}
.chart-title{font-size:14px;font-weight:800;color:var(--dark);margin-bottom:16px;}

/* Table */
.table-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;overflow:hidden;margin-bottom:22px;}
.table-head{padding:14px 18px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.table-head h3{font-size:14px;font-weight:800;color:var(--dark);margin:0;}
table{width:100%;border-collapse:separate;border-spacing:0;}
th,td{padding:11px 16px;font-size:13px;text-align:left;border-bottom:1px solid var(--border);}
th{background:var(--page-bg);font-weight:800;color:var(--mid);}
td{font-weight:600;color:var(--dark);}
tr:last-child td{border-bottom:none;}
.text-right{text-align:right;}
.text-green{color:var(--primary);}
.text-warning{color:var(--warning);}
.text-danger{color:var(--danger);}
.badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:800;}
.badge-confirmed{background:var(--primary-soft);color:#065f46;border:1px solid rgba(0,192,127,.25);}
.badge-pending{background:var(--warning-soft);color:#92400e;border:1px solid rgba(245,158,11,.2);}
.badge-cancelled{background:var(--danger-soft);color:#be123c;border:1px solid rgba(244,63,94,.2);}
.empty-state{padding:40px;text-align:center;color:var(--muted);font-weight:700;}
</style>

<div class="rp-page">

    <div class="rp-header">
        <h1><span>Báo cáo</span> Đặt Sân</h1>
        <a href="index.php?action=admin_report_revenue_export&type=booking&date_from=<?= urlencode($_GET['date_from'] ?? '') ?>&date_to=<?= urlencode($_GET['date_to'] ?? '') ?>" class="btn btn-export">
            <i class="fas fa-file-csv"></i> Xuất báo cáo đặt sân
        </a>
    </div>

    <!-- Filter -->
    <div class="filter-card">
        <form method="get" action="index.php">
            <input type="hidden" name="action" value="admin_report_booking" />
            <div class="filter-row">
                <div class="field">
                    <label>Từ ngày</label>
                    <input class="input" type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>" />
                </div>
                <div class="field">
                    <label>Đến ngày</label>
                    <input class="input" type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>" />
                </div>
                <div class="field" style="flex:0">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Lọc</button>
                </div>
                <div class="field" style="flex:0">
                    <label>&nbsp;</label>
                    <a href="index.php?action=admin_report_booking" class="btn">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Stat cards -->
    <?php
    $total     = array_sum($statsByStatus);
    $confirmed = $statsByStatus['Confirmed'] ?? 0;
    $pending   = $statsByStatus['Pending']   ?? 0;
    $cancelled = $statsByStatus['Cancelled'] ?? 0;
    ?>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Tổng đặt sân</div>
            <div class="stat-value"><?= $total ?></div>
            <div class="stat-sub">Tất cả trạng thái</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Đã xác nhận</div>
            <div class="stat-value green"><?= $confirmed ?></div>
            <div class="stat-sub"><?= $total > 0 ? number_format($confirmed/$total*100,1) : 0 ?>% tổng</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Chờ xác nhận</div>
            <div class="stat-value warning"><?= $pending ?></div>
            <div class="stat-sub"><?= $total > 0 ? number_format($pending/$total*100,1) : 0 ?>% tổng</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Đã hủy</div>
            <div class="stat-value danger"><?= $cancelled ?></div>
            <div class="stat-sub"><?= $total > 0 ? number_format($cancelled/$total*100,1) : 0 ?>% tổng</div>
        </div>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-title">Tỷ lệ trạng thái đặt sân</div>
            <canvas id="chartStatus" height="160"></canvas>
        </div>
        <?php if (!empty($byDay)): ?>
        <div class="chart-card">
            <div class="chart-title">Số lượng đặt sân theo ngày</div>
            <canvas id="chartDay" height="160"></canvas>
        </div>
        <?php else: ?>
        <div class="chart-card">
            <div class="chart-title">Đặt sân theo sân</div>
            <canvas id="chartCourt" height="160"></canvas>
        </div>
        <?php endif; ?>
    </div>

    <!-- By court table -->
    <div class="table-card">
        <div class="table-head">
            <h3>Thống kê theo sân</h3>
        </div>
        <?php if (empty($byCourt)): ?>
            <div class="empty-state">Không có dữ liệu</div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Sân</th>
                    <th class="text-right">Tổng đặt</th>
                    <th class="text-right">Đã xác nhận</th>
                    <th class="text-right">Đã hủy</th>
                    <th class="text-right">Tỷ lệ hủy</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($byCourt as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['court_name']) ?></td>
                    <td class="text-right"><?= $c['total'] ?></td>
                    <td class="text-right text-green"><?= $c['confirmed'] ?></td>
                    <td class="text-right text-danger"><?= $c['cancelled'] ?></td>
                    <td class="text-right">
                        <?= $c['total'] > 0 ? number_format($c['cancelled']/$c['total']*100, 1) : 0 ?>%
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    // Status doughnut
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Đã xác nhận', 'Chờ xác nhận', 'Đã hủy'],
            datasets: [{
                data: [<?= $confirmed ?>, <?= $pending ?>, <?= $cancelled ?>],
                backgroundColor: ['#00c07f','#f59e0b','#f43f5e'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom', labels: { font: { weight: '700' }, padding: 14 } } },
            cutout: '68%',
        }
    });

    <?php if (!empty($byDay)): ?>
    new Chart(document.getElementById('chartDay'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($byDay, 'day')) ?>,
            datasets: [{
                label: 'Số đặt sân',
                data: <?= json_encode(array_column($byDay, 'total')) ?>,
                backgroundColor: 'rgba(0,192,127,.25)',
                borderColor: '#00c07f',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { x: { grid: { display: false } } } }
    });
    <?php else: ?>
    new Chart(document.getElementById('chartCourt'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($byCourt, 'court_name')) ?>,
            datasets: [
                { label: 'Đã xác nhận', data: <?= json_encode(array_column($byCourt, 'confirmed')) ?>, backgroundColor: '#00c07f', borderRadius: 5 },
                { label: 'Đã hủy',      data: <?= json_encode(array_column($byCourt, 'cancelled')) ?>, backgroundColor: '#f43f5e', borderRadius: 5 },
            ]
        },
        options: {
            plugins: { legend: { position: 'bottom', labels: { font: { weight: '700' }, padding: 12 } } },
            scales: { x: { stacked: false, grid: { display: false } }, y: { beginAtZero: true } }
        }
    });
    <?php endif; ?>
})();
</script>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>
