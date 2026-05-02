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
    background: white;
}

form input,
form select {
    display: block;
    margin-bottom: 10px;
    width: 95%;
    padding: 8px;
}

form button {
    padding: 10px 15px;
    background-color: #007bff;
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

        <label>Vai trò:</label>
        <select name="role" required>
            <option value="customer" <?= ($user['role'] == 'customer') ? 'selected' : '' ?>>
                Customer
            </option>
            <option value="owner" <?= ($user['role'] == 'owner') ? 'selected' : '' ?>>
                Owner
            </option>
            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>
                Admin
            </option>
        </select>

        <button type="submit">Lưu thay đổi</button>
    </form>

    <p><a href="index.php?action=user">Quay về</a></p>
</div>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>