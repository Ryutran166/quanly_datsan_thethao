<style>
.admin-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    padding: 30px;
}

.admin-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px 20px;
    text-align: center;
    font-size: 30px;
    text-decoration: none;
    color: #333;
    border: 1px solid #eee;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.2s;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.admin-card span {
    font-size: 16px;
    font-weight: 600;
}

.admin-card:hover {
    transform: translateY(-5px);
    background: #0d6efd;
    color: #fff;
}
</style>



<h2 style="text-align:center; margin-top:20px;">Trang quản trị</h2>

<p style="text-align:center; font-size:16px;">
    Xin chào ADMIN: <strong><?= $_SESSION['user_name'] ?></strong>
</p>

<hr style="margin:20px 0;">

<div class="admin-container">

    <a href="index.php?action=user" class="admin-card">
        👤
        <span>Quản lý User</span>
    </a>

    <a href="index.php?action=index" class="admin-card">
        ⚽
        <span>Quản lý sân</span>
    </a>

    <a href="index.php?action=promotion" class="admin-card">
        🎁
        <span>Khuyến mãi</span>
    </a>

    <a href="index.php?action=redirect_home" class="admin-card">
        🏠
        <span>Trang chủ</span>
    </a>

</div>