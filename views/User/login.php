<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        :root {
            --primary-green: #28a745;
            --text-dark: #1a3a32;
            --bg-light: #f0f4f8;
            --border-color: #d1d9e0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Header logo giả lập */
        .header-nav {
            position: absolute;
            top: 20px;
            width: 90%;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            color: var(--text-dark);
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-sizing: border-box;
        }

        h1 {
            color: var(--primary-green);
            margin-bottom: 10px;
            font-size: 24px;
        }

        h2 {
            color: var(--text-dark);
            margin-bottom: 5px;
            font-size: 20px;
        }

        p.subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 13px;
            color: #444;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            transition: border 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-green);
        }

        .flex-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-green);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        .divider {
            margin: 30px 0;
            border-top: 1px solid #eee;
            position: relative;
        }

        .divider span {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 0 10px;
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
        }

        .btn-secondary {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px dashed #007bff;
            border-radius: 8px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        footer-text {
            margin-top: 20px;
            font-size: 11px;
            color: #888;
        }

        .error {
            color: #d9534f;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .back-home {
            display: block;
            margin-top: 15px;
            font-size: 13px;
            color: #666;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-home:hover {
            color: var(--primary-green);
        }

    </style>

<body>
    <div class="header-nav">
        <span>CourtConnect</span>
        <span style="font-weight: normal; font-size: 13px;">Support</span>
    </div>

    <div class="container">
        <h1>Đặt sân thể thao</h1>
        <h2>Chào mừng trở lại</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="index.php?action=do_login" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="name@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <div class="flex-row">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" style="width: auto; margin-right: 8px;"> Remember me
                </label>
                <a href="#" style="color: var(--primary-green); text-decoration: none;">Forgot password?</a>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>

        <div class="divider"><span>Don't have an account?</span></div>

        <a href="index.php?action=register" class="btn-secondary">Sign up</a>
        <a href="index.php?action=home" class="back-home">← Quay lại trang chủ</a>
    </div>

    <div class="footer-text" style="margin-top: 20px; font-size: 11px; color: #888;">
        Secure, encrypted login powered by CourtConnect
    </div>
</body>

</html>