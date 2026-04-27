<?php
// views/layout/header.php
$current_action = $_GET['action'] ?? 'index';

function isActive($action, $current_action)
{
    // Các action liên quan đến Sân
    $court_actions = ['courts', 'index', 'add', 'edit', 'update', 'delete', 'booking'];
    // Các action liên quan đến User
    $user_actions = ['user', 'add_user', 'edit_user', 'update_user', 'delete_user'];

    if ($action === 'courts' && in_array($current_action, $court_actions)) return 'active';
    if ($action === 'user' && in_array($current_action, $user_actions)) return 'active';
    
    return ($action === $current_action) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #28a745;
            --dark-color: #1a1a1a;
            --text-light: #ffffff;
            --bg-body: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            padding-top: 70px;
        }

        /* --- Thanh Navigation Bar --- */
        .navbar {
            background-color: var(--dark-color);
            color: var(--text-light);
            padding: 0 5%;
            position: fixed;
            top: 0;
            left: 0;
            width: 90%; /* Bù trừ cho padding 5% hai bên */
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100%;
        }

        .nav-links li { height: 100%; }

        .nav-links li a {
            display: flex;
            align-items: center;
            color: #ccc;
            text-decoration: none;
            padding: 0 20px;
            height: 100%;
            transition: all 0.3s;
            font-weight: 500;
            border-bottom: 3px solid transparent;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            color: var(--text-light);
            background-color: #333;
            border-bottom: 3px solid var(--primary-color);
        }

        /* --- Menu User (Dropdown) --- */
        .user-menu {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .user-name {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .user-name:hover { background: #333; }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 20px;
            text-decoration: none;
            display: block;
            font-size: 0.95rem;
            transition: background 0.2s;
        }

        .dropdown-content a i { margin-right: 10px; width: 20px; }

        .dropdown-content a:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }

        .user-menu.show .dropdown-content { display: block; }

        /* Container điều chỉnh cho đẹp */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="nav-brand">SPORT<span style="color:white">HUB</span></a>
        
        <ul class="nav-links">
            <li>
                <a href="index.php?action=courts" class="<?= isActive('courts', $current_action); ?>">
                     Danh sách sân
                </a>
            </li>
            <li>
                <a href="index.php?action=user" class="<?= isActive('user', $current_action); ?>">
                     Quản trị User
                </a>
            </li>
        </ul>

        <div class="user-menu" id="user-menu-dropdown">
            <div class="user-name">
                <i class="fas fa-user-circle fa-lg me-1"></i>
                <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
            </div>
            <div class="dropdown-content">
                <a href="index.php?action=change_password"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                 <a href="index.php?action=my_bookings">
        <i class="fas fa-calendar-check"></i> Lịch sử đặt sân
    </a>
                <div style="border-top: 1px solid #eee;"></div>
                <a href="index.php?action=logout" style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenu = document.getElementById('user-menu-dropdown');
            if (userMenu) {
                userMenu.addEventListener('click', function(e) {
                    this.classList.toggle('show');
                    e.stopPropagation();
                });
            }
            document.addEventListener('click', function() {
                if (userMenu) userMenu.classList.remove('show');
            });
        });
    </script>
    <div class="container">