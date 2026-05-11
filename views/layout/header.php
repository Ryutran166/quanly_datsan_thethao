<?php
// views/layout/header.php
$current_action = $_GET['action'] ?? 'index';

function isActive($action, $current_action)
{
    $court_actions = ['courts', 'index', 'add', 'edit', 'update', 'delete', 'booking'];
    $user_actions  = ['user', 'add_user', 'edit_user', 'update_user', 'delete_user'];

    if ($action === 'courts' && in_array($current_action, $court_actions)) return 'active';
    if ($action === 'user'   && in_array($current_action, $user_actions))  return 'active';
    if ($action === 'my_bookings' && $current_action === 'my_bookings') return 'active';

    return ($action === $current_action) ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* ── Reset & base ── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Flash message */
        .flash-message {
            margin: 0 auto 16px;
            width: 100%;
            max-width: 980px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
        }

        .flash-message.flash-success {
            background: rgba(0, 192, 127, .12);
            border: 1.5px solid rgba(0, 192, 127, .25);
            color: #065f46;
        }

        .flash-message.flash-error {
            background: rgba(244, 63, 94, .10);
            border: 1.5px solid rgba(244, 63, 94, .22);
            color: #be123c;
        }


        :root {
            --primary: #00c07f;
            --primary-dark: #00a06a;
            --dark: #0f172a;
            --nav-bg: #0f172a;
            --nav-border: rgba(255, 255, 255, .07);
            --text-muted: #94a3b8;
            --surface: #ffffff;
            --page-bg: #f1f5f9;
            --border: #e2e8f0;
            --danger: #f43f5e;
        }

        html {
            overflow-y: scroll;
        }

        body {
            /* push content below the two-row nav (64 + 52 = 116px) */
            padding-top: 116px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--page-bg);
            color: var(--dark);
            -webkit-font-smoothing: antialiased;
        }

        /* ════════════════════════════
           TOP NAV  (brand + user)
        ════════════════════════════ */
        .nav-top {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 64px;
            background: var(--nav-bg);
            display: flex;
            align-items: center;
            padding: 0 28px;
            justify-content: space-between;
            z-index: 1000;
            border-bottom: 1px solid var(--nav-border);
        }

        /* Brand */
        .nav-brand {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -.3px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .brand-sport {
            color: var(--primary);
        }

        .brand-hub {
            color: #fff;
        }

        /* tiny green dot accent */
        .brand-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--primary);
            margin-bottom: 10px;
        }

        /* ── User area ── */
        .nav-user {
            position: relative;
            display: flex;
            align-items: center;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: background .2s;
            user-select: none;
        }

        .user-trigger:hover {
            background: rgba(255, 255, 255, .07);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(0, 192, 127, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 15px;
            flex-shrink: 0;
        }

        .user-name-text {
            font-size: 14px;
            font-weight: 600;
            color: #e2e8f0;
            max-width: 140px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-caret {
            color: var(--text-muted);
            font-size: 11px;
            transition: transform .25s;
        }

        .nav-user.open .user-caret {
            transform: rotate(180deg);
        }

        /* Dropdown */
        .user-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 210px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, .12);
            overflow: hidden;
            z-index: 9999;
        }

        .nav-user.open .user-dropdown {
            display: block;
        }

        .dropdown-header {
            padding: 14px 16px 10px;
            border-bottom: 1.5px solid var(--border);
        }

        .dropdown-header span {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark);
        }

        .dropdown-header small {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            text-decoration: none;
            transition: background .15s, color .15s;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
        }

        .dropdown-item:hover {
            background: var(--page-bg);
            color: var(--dark);
        }

        .dropdown-item:hover i {
            color: var(--primary);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        .dropdown-item.danger {
            color: var(--danger);
        }

        .dropdown-item.danger i {
            color: var(--danger);
        }

        .dropdown-item.danger:hover {
            background: #fff1f3;
        }

        /* Login button */
        .btn-login {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            background: var(--primary);
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            transition: background .2s, transform .15s;
            box-shadow: 0 2px 8px rgba(0, 192, 127, .3);
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* ════════════════════════════
           SUB NAV  (page links)
        ════════════════════════════ */
        .nav-sub {
            position: fixed;
            top: 64px;
            left: 0;
            width: 100%;
            height: 52px;
            background: rgba(15, 23, 42, .92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--nav-border);
            z-index: 999;
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 4px;
        }

        .sub-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 15px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #94a3b8;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .sub-link i {
            font-size: 12px;
        }

        .sub-link:hover {
            background: rgba(0, 192, 127, .1);
            color: var(--primary);
        }

        .sub-link.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(0, 192, 127, .3);
        }

        /* ── Page container ── */
        .container {
            width: 100%;
            max-width: 100%;
            padding: 0;
        }
    </style>
</head>

<body>

    <!-- ══ TOP NAV ══ -->
    <nav class="nav-top">

        <a href="index.php?action=home" class="nav-brand">
            <span class="brand-sport">SPORT</span><span class="brand-hub">HUB</span>
            <span class="brand-dot"></span>
        </a>

        <?php if (isset($_SESSION['user_id'])): ?>

            <div class="nav-user" id="nav-user">

                <div class="user-trigger">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="user-name-text">
                        <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                    </span>
                    <i class="fas fa-chevron-down user-caret"></i>
                </div>

                <div class="user-dropdown">

                    <div class="dropdown-header">
                        <span><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>
                        <small>
                            <?php
                            $role = strtolower(trim($_SESSION['user_role'] ?? ''));
                            echo match ($role) {
                                'admin' => '⚙️ Quản trị viên',
                                'owner' => '🏟️ Chủ sân',
                                default => '👤 Người dùng',
                            };
                            ?>
                        </small>
                    </div>
                    <a href="index.php?action=change_password" class="dropdown-item">
                        <i class="fas fa-key"></i> Đổi mật khẩu
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="index.php?action=logout" class="dropdown-item danger">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>

                </div>
            </div>

        <?php else: ?>
            <a href="index.php?action=login" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Đăng nhập
            </a>
        <?php endif; ?>

    </nav>

    <!-- ══ SUB NAV ══ -->
    <nav class="nav-sub">
        <a href="index.php?action=home" class="sub-link <?= isActive('home', $current_action) ?>">
            <i class="fas fa-house"></i> Trang chủ
        </a>
        <a href="index.php?action=index" class="sub-link <?= isActive('courts', $current_action) ?>">
            <i class="fas fa-table-tennis-paddle-ball"></i> Danh sách sân
        </a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?action=my_bookings" class="sub-link <?= isActive('my_bookings', $current_action) ?>">
                <i class="fas fa-calendar-check"></i> Lịch sử đặt sân
            </a>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="index.php?action=user" class="sub-link <?= isActive('user', $current_action); ?>">
                Quản lý User
            </a>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="index.php?action=admin_bookings" class="sub-link <?= isActive('admin_bookings', $current_action); ?>">
                <i class="fas fa-calendar-alt"></i> Quản lý đặt sân
            </a>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'owner'): ?>
            <a href="index.php?action=owner_bookings" class="sub-link <?= isActive('owner_bookings', $current_action); ?>">
                <i class="fas fa-calendar-alt"></i> Quản lý đặt sân
            </a>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): 
            $role = strtolower(trim($_SESSION['user_role'] ?? ''));
            $actionLink = ($role === 'admin') ? 'contact' : 'contact';
        ?>
            <a href="index.php?action=<?= htmlspecialchars($actionLink) ?>" class="sub-link <?= isActive('contact', $current_action) ?>">
                Liên hệ 
            </a>
        <?php endif; ?>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navUser = document.getElementById('nav-user');
            if (!navUser) return;

            navUser.addEventListener('click', function(e) {
                this.classList.toggle('open');
                e.stopPropagation();
            });

            document.addEventListener('click', function() {
                navUser.classList.remove('open');
            });
        });
    </script>

    <?php
        // Flash messages (hiển thị sau redirect)
        if (class_exists('Nhom2\\QuanlyDatsanThethao\\Core\\FlashMessage')) {
            \Nhom2\QuanlyDatsanThethao\Core\FlashMessage::display();
        }
    ?>

    <div class="container">
