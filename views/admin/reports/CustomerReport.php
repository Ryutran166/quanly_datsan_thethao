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
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;}
@media(max-width:700px){.stats-grid{grid-template-columns:1fr;}}
.stat-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;padding:20px 20px 18px;}
.stat-label{font-size:12px;font-weight:700;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;margin-bottom:8px;}
.stat-value{font-size:26px;font-weight:800;color:var(--dark);letter-spacing:-.5px;}
.stat-value.green{color:var(--primary);}
.stat-sub{font-size:12px;color:var(--muted);margin-top:4px;font-weight:600;}

/* Filter */
.filter-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;padding:18px 20px;margin-bottom:22px;}
.filter-row{display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end;}
.field{display:flex;flex-direction:column;gap:5px;flex:1;min-width:140px;}
.field label{font-size:12px;font-weight:800;color:var(--mid);}
.input,.select{padding:9px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:13px;color:var(--dark);background:#fff;outline:none;}
.input:focus,.select:focus{border-color:rgba(0,192,127,.6);box-shadow:0 0 0 3px rgba(0,192,127,.12);}

/* Chart */
.chart-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;padding:20px;margin-bottom:22px;}
.chart-title{font-size:14px;font-weight:800;color:var(--dark);margin-bottom:16px;}

/* Tables */
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:22px;}
@media(max-width:860px){.two-col{grid-template-columns:1fr;}}
.table-card{background:var(--surface);border:1.5px solid var(--border);border-radius:16px;overflow:hidden;margin-bottom:22px;}
.table-head{padding:14px 18px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.table-head h3{font-size:14px;font-weight:800;color:var(--dark);margin:0;}
table{width:100%;border-collapse:separate;border-spacing:0;}
th,td{padding:11px 16px;font-size:13px;text-align:left;border-bottom:1px solid var(--border);}
th{background:var(--page-bg);font-weight:800;color:var(--mid);}
td{font-weight:600;color:var(--dark);}
tr:last-child td{border-bottom:none;}
.text-right{text-align:right;}
.text-green{color:var(--primary);font-weight:800;}
.text-muted{color:var(--muted);}
.medal{font-size:16px;}
.empty-state{padding:40px;text-align:center;color:var(--muted);font-weight:700;}
</style>

<div class="rp-page">

    <div class="rp-header">
        <h1><span>Báo cáo</span> Khách Hàng</h1>
        <a href="index.php?action=admin_report_customer_export&date_from=<?= urlencode($_GET['date_from'] ?? '') ?>&date_to=<?= urlencode($_GET['date_to'] ?? '') ?>" class="btn btn-export">
            <i class="fas fa-file-csv"></i> Xuất CSV
        </a>
    </div>

    <!-- Filter -->
    <div class="filter-card">
        <form method="get" action="index.php">
            <input type="hidden" name="action" value="admin_report_customer" />
            <div class="filter-row">
                <div class="field">
                    <label>Ngày đăng ký từ</label>
                    <input class="input" type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>" />
                </div>
                <div class="field">
                    <label>Đến ngày</label>
                    <input class="input" type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>" />
                </div>
                <div class="field">
                    <label>Năm (biểu đồ)</label>
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
                    <a href="index.php?action=admin_report_customer" class="btn">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Stat cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Tổng khách hàng</div>
            <div class="stat-value"><?= $totalCustomers ?></div>
            <div class="stat-sub">Tất cả tài khoản customer</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Khách mới tháng này</div>
            <div class="stat-value green"><?= $newThisMonth ?></div>
            <div class="stat-sub"><?= date('m/Y') ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Khách đang lọc</div>
            <div class="stat-value"><?= count($customerList) ?></div>
            <div class="stat-sub">Trong khoảng thời gian đã chọn</div>
        </div>
    </div>

    <!-- Chart: new customers by month -->
    <div class="chart-card">
        <div class="chart-title">Khách hàng mới theo tháng – <?= $year ?></div>
        <canvas id="chartCustomers" height="70"></canvas>
    </div>

    <!-- Top customers + customer list -->
    <div class="two-col">
        <!-- Top customers -->
        <div class="table-card" style="margin-bottom:0">
            <div class="table-head"><h3>Top khách hàng đặt sân nhiều nhất</h3></div>
            <?php if (empty($topCustomers)): ?>
                <div class="empty-state">Không có dữ liệu</div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th class="text-right">Số lần</th>
                        <th class="text-right">Chi tiêu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topCustomers as $i => $c): ?>
                    <tr>
                        <td>
                            <?php if ($i === 0) echo '<span class="medal">🥇</span>';
                            elseif ($i === 1) echo '<span class="medal">🥈</span>';
                            elseif ($i === 2) echo '<span class="medal">🥉</span>';
                            else echo $i + 1; ?>
                        </td>
                        <td>
                            <div style="font-weight:700"><?= htmlspecialchars($c['name']) ?></div>
                            <div class="text-muted" style="font-size:11px"><?= htmlspecialchars($c['phone'] ?? '') ?></div>
                        </td>
                        <td class="text-right"><?= $c['booking_count'] ?></td>
                        <td class="text-right text-green"><?= number_format($c['total_spent'], 0, ',', '.') ?>đ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <!-- New customer list (recent 10) -->
        <div class="table-card" style="margin-bottom:0">
            <div class="table-head"><h3>Danh sách khách hàng mới</h3></div>
            <?php if (empty($customerList)): ?>
                <div class="empty-state">Không có dữ liệu</div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Ngày đăng ký</th>
                        <th class="text-right">Đặt sân</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($customerList, 0, 15) as $c): ?>
                    <tr>
                        <td>
                            <div style="font-weight:700"><?= htmlspecialchars($c['name']) ?></div>
                            <div class="text-muted" style="font-size:11px"><?= htmlspecialchars($c['email']) ?></div>
                        </td>
                        <td style="color:var(--muted);font-size:12px"><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
                        <td class="text-right"><?= $c['booking_count'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (count($customerList) > 15): ?>
                <div style="padding:10px 16px;font-size:12px;color:var(--muted);font-weight:700;">
                    ... và <?= count($customerList) - 15 ?> khách hàng khác. Xuất CSV để xem đầy đủ.
                </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    const labels = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];
    const data   = <?= json_encode(array_column($newByMonth, 'count')) ?>;

    new Chart(document.getElementById('chartCustomers'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Khách hàng mới',
                data,
                backgroundColor: 'rgba(0,192,127,.25)',
                borderColor: '#00c07f',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });
})();
</script>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>
