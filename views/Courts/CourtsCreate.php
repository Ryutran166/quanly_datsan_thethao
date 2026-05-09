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

    /* ── Page wrapper ── */
    .page-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    /* ── Page header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 36px;
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

    /* ── Grid ── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
        align-items: start;
    }

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

    /* ── Form rows ── */
    .row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .field { display: flex; flex-direction: column; }

    .field + .field,
    .row-2 + .row-2,
    .row-2 + .field,
    .field + .row-2 { margin-top: 20px; }

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

    textarea.form-control { resize: vertical; min-height: 130px; }

    /* Price input group */
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
        font-weight: 700;
        color: var(--label);
    }

    .input-group .form-control {
        border: none;
        border-radius: 0;
        box-shadow: none;
        background: transparent;
    }

    /* ── Right column ── */
    .right-col { display: flex; flex-direction: column; gap: 20px; }

    /* ── Upload zone ── */
    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius);
        padding: 38px 20px;
        text-align: center;
        background: #fafbfd;
        cursor: pointer;
        transition: border-color .25s, background .25s;
        position: relative;
    }

    .upload-zone:hover {
        border-color: var(--green);
        background: #f0fef4;
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-zone .upload-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: #eef9f1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        color: var(--green);
        font-size: 1.4rem;
    }

    .upload-zone h6 {
        font-size: .95rem;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 6px;
    }

    .upload-zone p {
        font-size: .78rem;
        color: var(--label);
    }

    .upload-zone .btn-browse {
        display: inline-block;
        margin-top: 14px;
        background: var(--navy);
        color: #fff;
        padding: 8px 22px;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 700;
        pointer-events: none;
    }

    /* Image preview */
    #preview-wrap {
        display: none;
        margin-top: 14px;
        border-radius: 10px;
        overflow: hidden;
    }

    #preview-wrap img {
        width: 100%;
        max-height: 180px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* ── Save button ── */
    .btn-save {
        width: 100%;
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
        letter-spacing: .02em;
    }

    .btn-save:hover {
        background: var(--green-dk);
        transform: translateY(-1px);
    }

    /* ── Status badge selector ── */
    .status-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 0;
    }

    .status-opt input { display: none; }

    .status-opt label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 2px solid var(--border);
        border-radius: 10px;
        padding: 12px 6px;
        cursor: pointer;
        font-size: .75rem;
        font-weight: 700;
        color: var(--label);
        text-transform: uppercase;
        letter-spacing: .04em;
        transition: all .2s;
        background: #fafbfd;
    }

    .status-opt label .dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        display: block;
    }

    .status-opt input:checked + label {
        border-color: var(--navy);
        background: var(--navy);
        color: #fff;
    }

    .dot-available { background: var(--green); }
    .dot-booked    { background: #f59e0b; }
    .dot-maint     { background: #ef4444; }

    /* ── Summary hint card ── */
    .hint-card {
        background: var(--navy);
        border-radius: var(--radius);
        padding: 22px 24px;
        color: #94adc4;
        font-size: .8rem;
        line-height: 1.7;
    }

    .hint-card strong { color: #fff; font-weight: 700; display: block; margin-bottom: 10px; font-size: .9rem; }

    .hint-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
        border-top: 1px solid rgba(255,255,255,.06);
    }

    .hint-item i { color: var(--green); width: 16px; text-align: center; }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .form-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-wrap">

    <!-- Header -->
    <div class="page-header">
        <h1>Thêm <span>sân mới</span></h1>
        <a href="index.php?action=index" class="btn-back">
            <i class="fa fa-arrow-left"></i> Về trang trước
        </a>
    </div>

    <form action="index.php?action=add" method="POST" enctype="multipart/form-data">
        <div class="form-grid">

            <!-- ── LEFT: Basic info ── -->
            <div class="card">
                <div class="card-title">
                    <div class="icon-wrap"><i class="fa fa-info-circle"></i></div>
                    Thông tin cơ bản
                </div>

                <div class="row-2">
                    <div class="field">
                        <label class="lbl">Tên Sân</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Center Court 01" required>
                    </div>
                    <div class="field">
                        <label class="lbl">Loại Sân</label>
                        <select name="type" class="form-select">
                            <option value="Football">⚽ Football</option>
                            <option value="Badminton">🏸 Badminton</option>
                            <option value="Tennis">🎾 Tennis</option>
                        </select>
                    </div>
                </div>

                <div class="row-2">
                    <div class="field">
                        <label class="lbl">Giá theo giờ (VNĐ)</label>
                        <div class="input-group">
                            <span class="input-group-text">₫</span>
                            <input type="number" name="price" class="form-control" placeholder="300,000" required>
                        </div>
                    </div>
                    <div class="field">
                        <!-- spacer, status moved below -->
                    </div>
                </div>

                <div class="field">
                    <label class="lbl">Trạng thái</label>
                    <div class="status-grid">
                        <div class="status-opt">
                            <input type="radio" name="status" id="s_avail" value="available" checked>
                            <label for="s_avail">
                                <span class="dot dot-available"></span>
                                Available
                            </label>
                        </div>
                        <div class="status-opt">
                            <input type="radio" name="status" id="s_booked" value="booked">
                            <label for="s_booked">
                                <span class="dot dot-booked"></span>
                                Booked
                            </label>
                        </div>
                        <div class="status-opt">
                            <input type="radio" name="status" id="s_maint" value="maintenance">
                            <label for="s_maint">
                                <span class="dot dot-maint"></span>
                                Maintenance
                            </label>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="lbl">Địa chỉ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                        <input type="text" name="address" class="form-control" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố" required>
                    </div>
                </div>

                <div class="field">
                    <label class="lbl">Mô tả</label>
                    <textarea name="description" class="form-control" placeholder="Mô tả bề mặt sân, hệ thống chiếu sáng và các quy định..."></textarea>
                </div>
            </div>

            <!-- ── RIGHT: Image + Save ── -->
            <div class="right-col">

                <!-- Image upload -->
                <div class="card">
                    <div class="card-title">
                        <div class="icon-wrap"><i class="fa fa-image"></i></div>
                        Ảnh sân
                    </div>

                    <div class="upload-zone" id="uploadZone">
                        <input type="file" id="image" name="image" accept="image/*">
                        <div class="upload-icon"><i class="fa fa-cloud-upload-alt"></i></div>
                        <h6>Kéo & thả ảnh vào đây</h6>
                        <p>Hỗ trợ PNG, JPG tối đa 10MB</p>
                        <span class="btn-browse">Chọn tệp</span>

                        <div id="preview-wrap">
                            <img id="preview-img" src="" alt="Preview">
                        </div>
                    </div>
                </div>

                <!-- Tips card -->
                <div class="hint-card">
                    <strong><i class="fa fa-lightbulb" style="color:var(--green);margin-right:8px"></i>Lưu ý</strong>
                    <div class="hint-item"><i class="fa fa-check"></i> Ảnh sắc nét giúp tăng lượt đặt sân</div>
                    <div class="hint-item"><i class="fa fa-check"></i> Đặt giá hợp lý theo khu vực</div>
                    <div class="hint-item"><i class="fa fa-check"></i> Mô tả rõ tiện ích và quy định sân</div>
                </div>

                <!-- Save -->
                <button type="submit" class="btn-save">
                    <i class="fa fa-save"></i> Lưu thông tin sân
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.getElementById('preview-wrap');
            const img  = document.getElementById('preview-img');
            img.src = e.target.result;
            wrap.style.display = 'block';
            document.querySelector('.upload-zone .upload-icon').style.display = 'none';
            document.querySelector('.upload-zone h6').style.display = 'none';
            document.querySelector('.upload-zone p').style.display = 'none';
            document.querySelector('.btn-browse').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    // Drag & drop highlight
    const zone = document.getElementById('uploadZone');
    ['dragover','dragenter'].forEach(e => zone.addEventListener(e, ev => {
        ev.preventDefault(); zone.style.borderColor = 'var(--green)'; zone.style.background = '#f0fef4';
    }));
    ['dragleave','drop'].forEach(e => zone.addEventListener(e, () => {
        zone.style.borderColor = ''; zone.style.background = '';
    }));
</script>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>