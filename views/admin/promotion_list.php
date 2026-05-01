<style>
body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    margin:0;

    /* FIX CHE HEADER (navbar + sub-navbar) */
    padding-top:140px;
}

/* CONTAINER */
.container{
    max-width:1200px;
    margin:auto;
    padding:20px 25px; /* tránh dính sát header */
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

h2{
    margin:0;
    color:#333;
}

/* BUTTON */
.add-btn{
    padding:10px 15px;
    background:#28a745;
    color:white;
    text-decoration:none;
    border-radius:6px;
}

.add-btn:hover{
    background:#218838;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

th{
    background:#007bff;
    color:white;
    padding:12px;
    text-align:left;
    font-size:14px;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

tr:hover{
    background:#f1f7ff;
}

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    color:white;
    display:inline-block;
}

.active{
    background:#28a745;
}

.inactive{
    background:#dc3545;
}

.code{
    font-weight:bold;
    color:#ff6600;
}

.small{
    font-size:13px;
    color:#555;
}
</style>

<div class="container">

<div class="header">
    <h2>📢 Danh sách khuyến mãi</h2>
    <a class="add-btn" href="index.php?action=create_promotion">+ Thêm khuyến mãi</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Nội dung</th>
        <th>Mã code</th>
        <th>Loại</th>
        <th>Giảm %</th>
        <th>Ngày bắt đầu</th>
        <th>Ngày kết thúc</th>
        <th>Còn lại</th>
        <th>Trạng thái</th>
    </tr>

    <?php foreach($promotions as $p): ?>

    <?php
        // FIX NGÀY AN TOÀN
        $start = strtotime($p['ngay_bat_dau']);
        $end = strtotime($p['ngay_ket_thuc']);
        $now = time();

        if(!$start || !$end){
            $remain = 0;
        } else {
            $remain = ceil(($end - $now) / 86400);
            if($remain < 0) $remain = 0;
        }
    ?>

    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['tieu_de'] ?></td>
        <td><?= $p['noi_dung'] ?></td>
        <td class="code"><?= $p['code'] ?></td>
        <td><?= $p['loai'] ?></td>
        <td><?= $p['giam_phan_tram'] ?>%</td>
        <td><?= $p['ngay_bat_dau'] ?></td>
        <td><?= $p['ngay_ket_thuc'] ?></td>

        <td class="small">
            <?= $remain ?> ngày
        </td>

        <td>
            <?php if($p['trang_thai'] == 'active'): ?>
                <span class="status active">Đang hoạt động</span>
            <?php else: ?>
                <span class="status inactive">Ngừng</span>
            <?php endif; ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

</div>