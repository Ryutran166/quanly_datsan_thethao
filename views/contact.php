<?php

use Nhom2\QuanlyDatsanThethao\Core\FlashMessage; ?>
<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
?>
<meta charset="UTF-8">
<title>Liên hệ với chúng tôi</title>
<style>
    .contact-wrapper {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .contact-card {
        background: #fff;
        padding: 30px 40px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .contact-card h1 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 26px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #00c07f;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 192, 127, 0.1);
    }

    .form-group textarea {
        min-height: 140px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #00c07f;
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.2s;
    }

    button:hover {
        background: #00a06a;
    }

    .nav-link {
        text-align: center;
        margin-top: 20px;
    }

    .nav-link a {
        color: #00c07f;
        font-weight: 600;
        text-decoration: none;
    }

    /* Flash */
    .flash-message {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: #fff;
    }

    .flash-success {
        background: #28a745;
    }

    .flash-error {
        background: #dc3545;
    }
</style>

<div class="contact-wrapper">
    <div class="contact-card">
        <h1>Liên hệ với chúng tôi</h1>

        <?php FlashMessage::display(); ?>

        <form action="index.php?action=submit_contact" method="POST">
            <div class="form-group">
                <label>Họ và Tên</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="message" required></textarea>
            </div>

            <button type="submit">Gửi</button>
        </form>

        
    </div>
</div>