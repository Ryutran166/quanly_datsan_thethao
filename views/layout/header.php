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

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        :root { 
            --primary-color: #28a745;
            --dark-color: #1a1a1a;
            --text-light: #ffffff;
            --bg-body: #f8f9fa;
        }


       body {
            padding-top: 120px;
            font-family: 'Inter', Arial, sans-serif;
            background: #1a1a1a;
            font-weight: 400;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        /* --- Thanh Navigation Bar --- */
        .navbar {
            background-color: var(--dark-color);
            color: var(--text-light);
            padding: 0 5%;
            position: fixed;
            top: 0;
            left: 0;
            width: 90%;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .nav-brand {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1px;
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

        .navbar-top {
            height: 70px;
            min-height: 70px;
            width: 100%;
            background: #1a1a1a;
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        .sub-navbar {
            z-index: 9999;
            position: fixed;
            top: 70px;  
            left: 0;
            width: 100%;
            background: rgba(26,26,26,0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #333;
            z-index: 999;
        }

        .nav-inner {
            width: 100%;
            padding: 0 25px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sub-inner {
            max-width: 1600px;
            margin: 0 auto;
            padding: 12px 30px;

            display: flex;
            gap: 12px;
            align-items: center;
        }

        .sub-inner a {
            color: #aaa;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            transition: all 0.25s ease;
            font-weight: 500;
        }

        /* Hover */
        .sub-inner a:hover {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        /* Active */
        .sub-inner a.active {
            background: #28a745;
            color: white;
            box-shadow: 0 4px 12px rgba(40,167,69,0.4);
        }
        /* LOGIN BUTTON */
        .login-btn {
            color: white;
            background: #28a745;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
        }



        /* --- Menu User--- */
        .user-menu {
            position: static;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .user-name {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
        }

        .user-name i {
            font-size: 24px;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        
        .user-name:hover { background: #333; }

        .dropdown-content {
            display: none;
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 9999;
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

        * {
            box-sizing: border-box;
        }

        html {
            overflow-y: scroll;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            max-width: 100%;
             padding: 0;
        }
    </style>
</head>
<body>
<!-- NAVBAR TOP -->
<nav class="navbar-top">
    <div class="nav-inner">
    <a href="index.php?action=home" class="nav-brand">
        SPORT<span style="color:white">HUB</span>
    </a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-menu" id="user-menu-dropdown">
            <div class="user-name">
                <i class="fas fa-user-circle"></i>
                <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
            </div>
            
            <div class="dropdown-content">

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                   
                <?php endif; ?>
                <a href="index.php?action=change_password">
                    <i class="fas fa-key"></i> Đổi mật khẩu
                </a>

                <a href="index.php?action=my_bookings">
                    <i class="fas fa-calendar-check"></i> Lịch sử đặt sân
                </a>

                <div style="border-top: 1px solid #eee;"></div>

                <a href="index.php?action=logout" style="color:#dc3545;">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>
    <?php else: ?>
        <a href="index.php?action=login" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Đăng nhập
        </a>
    <?php endif; ?>
    </div>
</nav>

<!-- SUB NAVBAR -->
<div class="sub-navbar">
    <div class="sub-inner">
        <a href="index.php?action=home" class="<?= isActive('home', $current_action); ?>">
            Trang chủ
        </a>
        <a href="index.php?action=index" class="<?= isActive('courts', $current_action); ?>">
            Danh sách sân
        </a>
        <a href="index.php?action=user" class="<?= isActive('user', $current_action); ?>">
            Quản trị User
        </a>

     </div>
</div>

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