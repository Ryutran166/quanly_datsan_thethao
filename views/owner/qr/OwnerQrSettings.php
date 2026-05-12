<?php
// views/owner/qr/OwnerQrSettings.php

$success = $_GET['success'] ?? null;
$error = $_GET['error'] ?? null;

$vietqr = $vietqr ?? [];

require_once PROJECT_ROOT . '/views/layout/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">


<style>
    :root {
        --primary:      #00c07f;
        --primary-dark: #00a06a;
        --primary-soft: #e6faf3;
        --danger:       #f43f5e;
        --danger-soft:  #fff1f3;
        --dark:         #0f172a;
        --mid:          #475569;
        --muted:        #94a3b8;
        --border:       #e2e8f0;
        --surface:      #ffffff;
        --page-bg:      #f1f5f9;
    }

    .page {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 24px 60px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }

    .header h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: var(--dark);
    }

    .header h1 span { color: var(--primary); }

    .alert {
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 13px;
        margin-bottom: 14px;
        border: 1.5px solid var(--border);
    }

    .alert.success {
        background: var(--primary-soft);
        border-color: rgba(0,192,127,.25);
        color: #065f46;
    }

    .alert.error {
        background: var(--danger-soft);
        border-color: rgba(244,63,94,.25);
        color: #be123c;
    }

    .card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,.03);
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: var(--mid);
        margin-bottom: 8px;
    }

    input[type="text"], textarea, select {
        width: 100%;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--page-bg);
        font-size: 14px;
        font-family: inherit;
        font-weight: 600;
        outline: none;
        margin-bottom: 12px;
    }

    textarea { min-height: 110px; resize: vertical; }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 12px;
        background: var(--primary);
        color: #fff;
        border: none;
        font-weight: 900;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn:hover { background: var(--primary-dark); }

    .small-note {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.6;
        margin-top: 10px;
        font-weight: 600;
    }

    .qr-preview {
        display: flex;
        gap: 18px;
        align-items: flex-start;
        flex-wrap: wrap;
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid var(--border);
    }

    .qr-box {
        width: 240px;
        height: 240px;
        border: 1.5px dashed var(--border);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: var(--muted);
        font-weight: 900;
    }

    .qr-desc {
        flex: 1;
        min-width: 260px;
    }

    .qr-desc h3 {
        margin: 0 0 8px;
        font-size: 16px;
        font-weight: 900;
        color: var(--dark);
    }

    .qr-desc p {
        margin: 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
        font-weight: 700;
    }
</style>

<div class="page">
    <?php if ($success): ?>
        <div class="alert success"><i class="fas fa-check-circle"></i> Đã lưu nội dung QR.</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert error"><i class="fas fa-exclamation-triangle"></i> Không thể lưu. Vui lòng thử lại.</div>
    <?php endif; ?>

    <div class="card">
        <form action="index.php?action=owner_qr_settings_update" method="POST">
            <div style="display:grid; grid-template-columns:1fr; gap:10px;">
                <label for="vietqr_account_name">Tên người thụ hưởng (account name)</label>
                <input type="text" name="vietqr_account_name" id="vietqr_account_name" value="<?= htmlspecialchars($vietqr['vietqr_account_name'] ?? '') ?>" required>

                <label for="vietqr_bank_code">Mã ngân hàng VietQR (bank code)</label>
                <input type="text" name="vietqr_bank_code" id="vietqr_bank_code" value="<?= htmlspecialchars($vietqr['vietqr_bank_code'] ?? '') ?>" required>

                <label for="vietqr_account_number">Số tài khoản (account number)</label>
                <input type="text" name="vietqr_account_number" id="vietqr_account_number" value="<?= htmlspecialchars($vietqr['vietqr_account_number'] ?? '') ?>" required>
            </div>

            <button type="submit" class="btn" onclick="return confirm('Lưu thông tin VietQR cho owner?')">
                <i class="fas fa-save"></i> Lưu VietQR
            </button>

            <div class="small-note">
                QR sẽ được tạo động theo số tiền khi người dùng chọn "Chuyển khoản bằng QR".
            </div>
        </form>
    </div>
</div>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';
?>





