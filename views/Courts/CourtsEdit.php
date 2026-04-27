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
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

h1 {
    margin-bottom: 20px;
}

input, select {
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

        <form action="index.php?action=update" method="POST">

            <input type="hidden" name="id" value="<?php echo $court['id']; ?>">

            <label>Tên sân</label>
            <input type="text" name="name"
                value="<?php echo htmlspecialchars($court['name']); ?>"
                required>

            <label>Giá (VNĐ / giờ)</label>
            <input type="number" name="price"
                value="<?php echo $court['price']; ?>"
                required>

            <label>Trạng thái</label>
            <select name="status">
                <option value="available"
                    <?php if($court['status']=='available') echo 'selected'; ?>>
                    Available
                </option>

                <option value="booked"
                    <?php if($court['status']=='booked') echo 'selected'; ?>>
                    Booked
                </option>

                <option value="maintenance"
                    <?php if($court['status']=='maintenance') echo 'selected'; ?>>
                    Maintenance
                </option>
            </select>

            <label>Link ảnh</label>
            <input type="text" name="image_url"
                value="<?php echo $court['image_url']; ?>">

            <button type="submit">Lưu thay đổi</button>
        </form>

        <a href="index.php">← Quay về danh sách</a>
    </div>
</div>

</body>
</html>