<?php require_once PROJECT_ROOT . '/views/layout/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --navy:     #0d1b2a;
        --navy-mid: #1a2e44;
        --green:    #00c853;
        --green-dk: #00a846;
        --bg:       #eef2f7;
        --card-bg:  #ffffff;
        --label:    #64748b;
        --border:   #dde3ee;
        --shadow:   0 4px 24px rgba(13,27,42,.08);
        --radius:   16px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        font-family: 'Sora', sans-serif;
        color: var(--navy);
    }

    .page-wrap {
        max-width: 680px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    /* ── Page header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--navy);
    }

    .page-header h1 span { color: var(--green); }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--navy);
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        transition: background .2s;
    }

    .btn-back:hover { background: var(--navy-mid); color: #fff; }

    /* ── Card ── */
    .card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 32px;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 28px;
    }

    .card-title .icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #eef9f1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--green);
        font-size: 1rem;
    }

    /* ── Error alert ── */
    .alert-error {
        background: #fff5f5;
        border: 1.5px solid #fecaca;
        color: #dc2626;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: .85rem;
        font-weight: 600;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ── Fields ── */
    .row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .field { display: flex; flex-direction: column; }
    .field + .field,
    .row-2 + .field,
    .field + .row-2,
    .row-2 + .row-2 { margin-top: 20px; }

    label.lbl {
        font-size: .78rem;
        font-weight: 700;
        color: var(--label);
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 13px 16px;
        font-family: 'Sora', sans-serif;
        font-size: .9rem;
        color: var(--navy);
        background: #fafbfd;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(0,200,83,.12);
        background: #fff;
    }

    /* Input group (icon prefix) */
    .input-group {
        display: flex;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        background: #fafbfd;
        transition: border-color .2s, box-shadow .2s;
    }

    .input-group:focus-within {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(0,200,83,.12);
    }

    .input-group-text {
        background: #f1f5f9;
        border: none;
        padding: 13px 14px;
        font-size: .85rem;
        color: var(--label);
        display: flex;
        align-items: center;
    }

    .input-group .form-control {
        border: none;
        border-radius: 0;
        box-shadow: none;
        background: transparent;
    }

    /* Password toggle */
    .pw-wrap {
        display: flex;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        background: #fafbfd;
        transition: border-color .2s, box-shadow .2s;
    }

    .pw-wrap:focus-within {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(0,200,83,.12);
    }

    .pw-wrap .form-control {
        border: none;
        border-radius: 0;
        box-shadow: none;
        background: transparent;
        flex: 1;
    }

    .pw-toggle {
        background: none;
        border: none;
        padding: 0 14px;
        color: var(--label);
        cursor: pointer;
        font-size: .9rem;
    }

    .pw-toggle:hover { color: var(--navy); }

    /* ── Role selector ── */
    .role-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .role-opt input { display: none; }

    .role-opt label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 2px solid var(--border);
        border-radius: 10px;
        padding: 14px 6px;
        cursor: pointer;
        font-size: .75rem;
        font-weight: 700;
        color: var(--label);
        text-transform: uppercase;
        letter-spacing: .04em;
        transition: all .2s;
        background: #fafbfd;
    }

    .role-opt label i { font-size: 1.1rem; }

    .role-opt input:checked + label {
        border-color: var(--navy);
        background: var(--navy);
        color: #fff;
    }

    /* ── Actions ── */
    .actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .btn-save {
        flex: 1;
        padding: 15px;
        background: var(--green);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Sora', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-save:hover {
        background: var(--green-dk);
        transform: translateY(-1px);
    }

    .btn-cancel {
        padding: 15px 24px;
        background: #f1f5f9;
        color: var(--label);
        border: none;
        border-radius: 12px;
        font-family: 'Sora', sans-serif;
        font-size: .9rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background .2s;
    }

    .btn-cancel:hover { background: #e2e8f0; color: var(--navy); }

    @media (max-width: 600px) {
        .row-2 { grid-template-columns: 1fr; }
        .role-grid { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="page-wrap">

    <div class="page-header">
        <h1>Thêm <span>người dùng</span></h1>
        <a href="index.php?action=user" class="btn-back">
            <i class="fa fa-arrow-left"></i> Về trang trước
        </a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert-error">
            <i class="fa fa-exclamation-circle"></i>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-title">
            <div class="icon-wrap"><i class="fa fa-user-plus"></i></div>
            Thông tin người dùng
        </div>

        <form action="index.php?action=do_add_user" method="POST">

            <div class="row-2">
                <div class="field">
                    <label class="lbl">Họ và tên</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" required>
                    </div>
                </div>
                <div class="field">
                    <label class="lbl">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        <input type="text" name="phone" class="form-control" placeholder="0901 234 567">
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="lbl">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                </div>
            </div>

            <div class="field">
                <label class="lbl">Vai trò</label>
                <div class="role-grid">
                    <div class="role-opt">
                        <input type="radio" name="role" id="r_customer" value="customer" checked>
                        <label for="r_customer">
                            <i class="fa fa-user"></i>
                            Customer
                        </label>
                    </div>
                    <div class="role-opt">
                        <input type="radio" name="role" id="r_owner" value="owner">
                        <label for="r_owner">
                            <i class="fa fa-store"></i>
                            Owner
                        </label>
                    </div>
                    <div class="role-opt">
                        <input type="radio" name="role" id="r_admin" value="admin">
                        <label for="r_admin">
                            <i class="fa fa-shield-alt"></i>
                            Admin
                        </label>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="lbl">Mật khẩu tạm thời</label>
                <div class="pw-wrap">
                    <span class="input-group-text" style="background:#f1f5f9;border:none;padding:13px 14px;color:var(--label);">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="pw" class="form-control" placeholder="Tối thiểu 8 ký tự" required>
                    <button type="button" class="pw-toggle" onclick="togglePw()">
                        <i class="fa fa-eye" id="pw-icon"></i>
                    </button>
                </div>
            </div>

            <div class="actions">
                <a href="index.php?action=user" class="btn-cancel">
                    <i class="fa fa-times"></i> Hủy
                </a>
                <button type="submit" class="btn-save">
                    <i class="fa fa-save"></i> Lưu người dùng
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function togglePw() {
        const pw   = document.getElementById('pw');
        const icon = document.getElementById('pw-icon');
        const show = pw.type === 'password';
        pw.type    = show ? 'text' : 'password';
        icon.className = show ? 'fa fa-eye-slash' : 'fa fa-eye';
    }
</script>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>