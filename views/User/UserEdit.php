<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
?>

<style>
.container-form {
    max-width: 600px;
    margin: auto;
}

form {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background:white;
}

form input {
    display: block;
    margin-bottom: 10px;
    width: 95%;
    padding: 8px;
}

form button {
    padding: 10px 15px;
    background-color:#007bff;
    color: white;
    border: none;
    cursor: pointer;
}
</style>

<div class="container-form">
    <h1>Chỉnh sửa thông tin User</h1>

    <form action="index.php?action=update_user" method="POST">
        <input type="hidden" name="id" value="<?= $user['id']; ?>">

        <label>Họ và Tên:</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($user['name']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($user['email']); ?>" required>

        <label>SĐT:</label>
        <input type="text" name="phone"
               value="<?= htmlspecialchars($user['phone']); ?>" required>

        <button type="submit">Lưu thay đổi</button>
    </form>

    <p><a href="index.php">Quay về</a></p>
</div>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>