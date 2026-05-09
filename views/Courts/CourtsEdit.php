<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sân</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 20px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <h1>Chỉnh sửa sân</h1>

            <form action="index.php?action=update" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?= $court['id'] ?>">
                <input type="hidden" name="old_image" value="<?= $court['image'] ?>">

                <label>Tên sân</label>
                <input type="text" name="name"
                    value="<?= htmlspecialchars($court['name']) ?>" required>

                <label>Giá (VNĐ / giờ)</label>
                <input type="number" name="price"
                    value="<?= $court['price'] ?>" required>

                <label>Địa chỉ sân</label>
                <input  type ="text" name="address" 
                    value="<?=$court['address']?>" required>

                <label>Trạng thái</label>
                <select name="status">
                    <option value="available" <?= $court['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                    <option value="booked" <?= $court['status'] == 'booked' ? 'selected' : '' ?>>Booked</option>
                    <option value="maintenance" <?= $court['status'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                </select>

                <p>Ảnh hiện tại:</p>
                <img src="/quanly_datsan_thethao/public/upload/img_courts/<?= htmlspecialchars($court['image']) ?>"
                    width="120" height="100">

                <label>Chọn ảnh mới</label>
                <input type="file" name="image">

                <button type="submit">Lưu thay đổi</button>

            </form>

            <a href="index.php?action=index">← Quay về danh sách</a>
        </div>
    </div>

</body>

</html>