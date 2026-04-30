<div style="max-width: 500px; margin: 0 auto;">
    <h2>Thêm người dùng mới</h2>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="index.php?action=do_add_user" method="POST" style="border: 1px solid #ddd; padding: 25px; border-radius: 8px;">
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="name" placeholder="Nhập họ tên" required>
        </div>

        <div class="form-group">
            <label>Địa chỉ Email</label>
            <input type="email" name="email" placeholder="email@vi-du.com" required>
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="phone" placeholder="Nhập số điện thoại">
        </div>

        <div class="form-group">
            <label>Mật khẩu tạm thời</label>
            <input type="password" name="password" placeholder="********" required>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" style="background-color: #28a745; flex: 1;">Lưu người dùng</button>
            <a href="index.php?action=user" style="display: inline-block; padding: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Hủy</a>
        </div>
    </form>
</div>