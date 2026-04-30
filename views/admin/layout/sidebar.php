<style>
    .sidebar { 
        min-height: 100vh; 
        background: #343a40; 
        color: white; 
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }
    .sidebar .nav-link { 
        color: rgba(255,255,255,.8); 
        padding: 12px 20px;
    }
    .sidebar .nav-link:hover { 
        color: white; 
        background: #495057; 
    }
    .sidebar .nav-link.active { 
        background: #0d6efd; 
        color: white; 
    }
</style>

<nav class="col-md-2 d-none d-md-block sidebar py-4">
    <h4 class="text-center mb-4">ADMIN PANEL</h4>
    <ul class="nav flex-column">
        <?php 
            $uri = $_SERVER['REQUEST_URI'];
        ?>
        <li class="nav-item">
            <a class="nav-link <?php echo (strpos($uri, 'dashboard') !== false) ? 'active' : ''; ?>" href="/admin/dashboard">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (strpos($uri, 'courts') !== false) ? 'active' : ''; ?>" href="/admin/courts">
                <i class="fas fa-table-tennis me-2"></i> Quản lý sân
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (strpos($uri, 'users') !== false) ? 'active' : ''; ?>" href="/admin/users">
                <i class="fas fa-users me-2"></i> Quản lý người dùng
            </a>
        </li>
        <hr>
        <li class="nav-item">
            <a class="nav-link text-danger" href="/logout">
                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
            </a>
        </li>
    </ul>
</nav>