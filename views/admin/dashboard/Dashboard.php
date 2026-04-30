<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Hệ thống đặt sân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .stat-card { border: none; border-radius: 10px; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Gọi Sidebar dùng chung -->
        <?php include PROJECT_ROOT . '/views/admin/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tổng quan hệ thống</h1>
                <div class="text-muted">Xin chào, <strong><?php echo $_SESSION['admin_email'] ?? 'Admin'; ?></strong></div>
            </div>

            <!-- Stats Cards -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card stat-card bg-primary text-white mb-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6>Người dùng</h6><h3><?php echo $stats['total_users'] ?? 0; ?></h3></div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card bg-success text-white mb-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div><h6>Tổng số sân</h6><h3><?php echo $stats['total_courts'] ?? 0; ?></h3></div>
                            <i class="fas fa-map-marker-alt fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <!-- ... giữ nguyên các card khác ... -->
            </div>

            <!-- Recent Activity Table -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white"><strong>Đơn đặt sân gần đây</strong></div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>ID</th><th>Khách hàng</th><th>Sân</th><th>Ngày</th><th>Trạng thái</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>#101</td><td>Nguyễn Văn A</td><td>Sân cầu lông A1</td><td>2024-05-20</td><td><span class="badge bg-success">Đã xác nhận</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>