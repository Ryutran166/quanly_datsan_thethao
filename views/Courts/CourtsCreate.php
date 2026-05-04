<?php require_once PROJECT_ROOT . '/views/layout/header.php'; ?>

<style>
    :root {
        --bg-body: #f8f9fe;
        --card-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
        --primary-navy: #0a2540;
    }

    body {
        background-color: var(--bg-body);
        font-family: 'Inter', sans-serif;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: ">";
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .custom-card {
        background: #ffffff;
        border: none;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        padding: 30px;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #525f7f;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 12px;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #5e72e4;
        box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1);
    }

    /* Media Upload Area */
    .upload-zone {
        border: 2px dashed #e9ecef;
        border-radius: 15px;
        padding: 40px 20px;
        text-align: center;
        background-color: #fcfdfe;
        cursor: pointer;
        transition: border-color 0.3s;
    }

    .upload-zone:hover {
        border-color: #5e72e4;
    }

    .btn-save {
        background-color: var(--primary-navy);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        width: 100%;
        margin-top: 20px;
    }

    .spec-item {
        font-size: 0.8rem;
        color: #8898aa;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
    }
</style>

<div class="container py-5">
    <div class="mb-5">
        <h2 style="font-weight: 800; color: var(--primary-navy);">Thêm sân mới</h2>
    </div>

    <form action="index.php?action=add" method="POST"
        enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="custom-card h-100">
                    <div class="form-section-title">
                        <div class="bg-light p-2 rounded-circle text-success"><i class="fa fa-info-circle"></i></div>
                        Basic Information
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên Sân</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Center Court 01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Loại Sân</label>
                            <select name="type" class="form-select">
                                <option value="Football">Football</option>
                                <option value="Badminton">Badminton</option>
                                <option value="Tennis">Tennis</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Giá theo giờ</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" name="price" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="available">Available</option>
                                <option value="booked">Booked</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Detail the court surface, lighting, and any specific rules..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="custom-card mb-4">
                    <h5 class="fw-bold mb-4" style="color: var(--primary-navy);">Ảnh sân</h5>

                    <div class="upload-zone mb-3" onclick="document.getElementById('image').click()">
                        <i class="fa fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h6 class="fw-bold">Drag & Drop images here</h6>
                        <p class="text-muted small">Support PNG, JPG up to 10MB</p>
                        <button type="button" class="btn btn-sm btn-dark px-4 rounded-pill">Browse Files</button>
                        <input type="file" id="image" name="image">
                    </div>
                </div>

                <button type="submit" class="btn btn-save shadow-sm">
                    Save Court Details
                </button>
                <a href="index.php?action=index" class="btn btn-link w-100 text-muted mt-2 text-decoration-none small">Về trang trước</a>
            </div>
        </div>
    </form>
</div>

<?php require_once PROJECT_ROOT . '/views/layout/footer.php'; ?>