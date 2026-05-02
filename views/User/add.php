<div style="max-width: 500px; margin: 0 auto;">
    <h2>Thêm người dùng mới</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="index.php?action=do_add_user" method="POST" style="border:1px solid #ddd; padding:25px; border-radius:8px;">

        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="phone">
        </div>

        <div class="form-group">
            <label>Vai trò</label>
            <select name="role" required>
                <option value="customer">Customer</option>
                <option value="owner">Owner</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label>Mật khẩu tạm thời</label>
            <input type="password" name="password" required>
        </div>

        <div style="margin-top:20px; display:flex; gap:10px;">
            <button type="submit" style="background:#28a745; flex:1;">Lưu người dùng</button>

            <a href="index.php?action=user"
               style="padding:10px;background:#6c757d;color:white;text-decoration:none;border-radius:4px;">
               Hủy
            </a>
        </div>

    </form>
</div>