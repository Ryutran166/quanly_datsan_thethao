<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sân - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>body { background-color: #f8f9fa; }</style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Gọi Sidebar dùng chung -->
        <?php include PROJECT_ROOT . '/views/admin/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quản lý danh sách sân</h1>
                <a href="/admin/courts/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm sân mới
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th><th>Hình ảnh</th><th>Tên sân</th><th>Loại sân</th><th>Giá (giờ)</th><th>Trạng thái</th><th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($courts)): ?>
                                    <?php foreach ($courts as $court): ?>
                                        <tr>
                                            <td>#<?php echo $court['id']; ?></td>
                                            <td><img src="/public/uploads/<?php echo $court['image'] ?? 'default-court.jpg'; ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                                            <td><strong><?php echo $court['name']; ?></strong></td>
                                            <td><?php echo $court['type']; ?></td>
                                            <td><?php echo number_format($court['price'], 0, ',', '.'); ?>đ</td>
                                            <td>
                                                <span class="badge <?php echo $court['status'] === 'available' ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo $court['status'] === 'available' ? 'Sẵn sàng' : 'Đang sửa chữa'; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="/admin/courts/edit?id=<?php echo $court['id']; ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                                    <a href="/admin/courts/delete?id=<?php echo $court['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa sân?')"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="7" class="text-center text-muted">Chưa có dữ liệu sân.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>