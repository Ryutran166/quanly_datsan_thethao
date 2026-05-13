<?php
require_once PROJECT_ROOT . '/views/layout/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{--primary:#00c07f;--primary-dark:#00a06a;--primary-soft:#e6faf3;--warning:#f59e0b;--warning-soft:#fffbeb;--danger:#f43f5e;--danger-soft:#fff1f3;--dark:#0f172a;--mid:#475569;--muted:#94a3b8;--border:#e2e8f0;--surface:#fff;--page-bg:#f1f5f9;}
.ab-page{max-width:1100px;margin:0 auto;padding:40px 24px 60px;font-family:'Plus Jakarta Sans',sans-serif;}
.ab-header{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:12px;}
.ab-header h1{font-size:26px;font-weight:800;color:var(--dark);letter-spacing:-.5px;margin:0;}
.ab-header h1 span{color:var(--primary);} 
.total-chip{font-size:13px;font-weight:700;color:var(--muted);background:var(--surface);border:1.5px solid var(--border);padding:5px 14px;border-radius:20px;}

.search-card{background:var(--surface);border:1.5px solid var(--border);border-radius:18px;padding:16px 16px;margin-bottom:16px;}
.search-grid{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;}
@media (max-width:900px){.search-grid{grid-template-columns:1fr 1fr;}}
@media (max-width:520px){.search-grid{grid-template-columns:1fr;}}
.field label{display:block;font-size:12px;font-weight:800;color:var(--mid);margin:0 0 6px;}
.input,.select{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:12px;background:#fff;color:#0f172a;outline:none;font-size:13px;}
.input:focus,.select:focus{border-color:rgba(0,192,127,.6);box-shadow:0 0 0 4px rgba(0,192,127,.15);} 
.actions-row{display:flex;gap:10px;align-items:center;margin-top:12px;flex-wrap:wrap;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 14px;border-radius:12px;font-size:13px;font-weight:800;text-decoration:none;cursor:pointer;border:1.5px solid var(--border);background:var(--surface);color:var(--mid);}
.btn-primary{border:0;background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(0,192,127,.25);} 
.btn-primary:hover{background:var(--primary-dark);} 
.btn-ghost{background:var(--page-bg);} 

.s-badge{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11px;font-weight:900;letter-spacing:.2px;}
.s-badge.pending{background:var(--warning-soft);color:#92400e;border:1px solid rgba(245,158,11,.2);} 
.s-badge.confirmed{background:var(--primary-soft);color:#065f46;border:1px solid rgba(0,192,127,.2);} 
.s-badge.cancelled,.s-badge.locked{background:var(--danger-soft);color:#be123c;border:1px solid rgba(244,63,94,.2);} 

.table-wrap{background:var(--surface);border:1.5px solid var(--border);border-radius:18px;overflow:hidden;}
.table{width:100%;border-collapse:separate;border-spacing:0;}
.th,.td{padding:12px 12px;font-size:13px;vertical-align:middle;}
.th{background:var(--page-bg);color:var(--mid);font-weight:900;text-align:left;border-bottom:1.5px solid var(--border);} 
.tr{border-bottom:1.5px solid var(--border);} 
.td{color:#0f172a;font-weight:600;} 
.muted{color:var(--muted);font-weight:700;}
@media (max-width:860px){.hide-mobile{display:none;}}

.pagination{display:flex;gap:10px;align-items:center;justify-content:space-between;padding:14px 14px;background:#fff;}
.pager-left{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.page-link{display:inline-flex;align-items:center;justify-content:center;padding:8px 12px;border-radius:12px;border:1.5px solid var(--border);background:var(--surface);color:var(--mid);text-decoration:none;font-weight:900;font-size:13px;}
.page-link.active{background:var(--primary);border-color:var(--primary);color:#fff;}

.ajax-loading{display:none;align-items:center;gap:10px;color:var(--mid);font-weight:900;padding:10px 0;}
.ajax-loading.show{display:flex;}
.spinner{width:18px;height:18px;border-radius:50%;border:3px solid rgba(0,192,127,.2);border-top-color:var(--primary);animation:spin .8s linear infinite;}
@keyframes spin{from{transform:rotate(0)}to{transform:rotate(360deg)}}
</style>

<div class="ab-page">
  

    <div class="search-card">
        <form id="paymentSearchForm" method="get" action="index.php" autocomplete="off">
            <input type="hidden" name="action" value="admin_payment_search" />

            <div class="search-grid">
                <div class="field">
                    <label>Mã booking / tên khách / số điện thoại</label>
                    <input class="input" type="text" name="keyword" placeholder="Ví dụ: #1, Trần Thanh Long, 0939..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" />
                </div>

                <div class="field">
                    <label>Trạng thái thanh toán</label>
                    <?php $ps = $_GET['payment_status'] ?? ''; ?>
                    <select class="select" name="payment_status">
                        <option value="" <?= $ps===''?'selected':'' ?>>Tất cả</option>
                        <option value="Pending" <?= $ps==='Pending'?'selected':'' ?>>Pending</option>
                        <option value="Confirmed" <?= $ps==='Confirmed'?'selected':'' ?>>Confirmed</option>
                        <option value="Cancelled" <?= $ps==='Cancelled'?'selected':'' ?>>Cancelled</option>
                        <option value="Locked" <?= $ps==='Locked'?'selected':'' ?>>Locked</option>
                    </select>
                </div>

                <div class="field">
                    <label>Phương thức thanh toán</label>
                    <?php $pm = $_GET['payment_method'] ?? ''; ?>
                    <select class="select" name="payment_method">
                        <option value="" <?= $pm===''?'selected':'' ?>>Tất cả</option>
                        <option value="cash" <?= $pm==='cash'?'selected':'' ?>>Tiền mặt</option>
                        <option value="qr" <?= $pm==='qr'?'selected':'' ?>>QR</option>
                    </select>
                </div>

                <div class="field">
                    <label>Ngày đặt sân</label>
                    <input class="input" type="date" name="booking_date" value="<?= htmlspecialchars($_GET['booking_date'] ?? '') ?>" />
                </div>
            </div>

            <div class="actions-row">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
                <button class="btn btn-ghost" type="button" id="resetPaymentFilter">
                    <i class="fas fa-rotate-left"></i> Reset
                </button>

                <div class="ajax-loading" id="ajaxLoading">
                    <span class="spinner"></span>
                    Đang tải...
                </div>
            </div>
        </form>
    </div>

    <div id="paymentResults">
        <?php
        require_once PROJECT_ROOT . '/views/admin/bookings/partials/AdminPaymentSearchResults.php';
        ?>
    </div>
</div>

<script>
(function(){
    const form = document.getElementById('paymentSearchForm');
    const results = document.getElementById('paymentResults');
    const resetBtn = document.getElementById('resetPaymentFilter');
    const loading = document.getElementById('ajaxLoading');

    function buildQuery(params){
        return new URLSearchParams(params).toString();
    }

    function collectParams(){
        const fd = new FormData(form);
        const params = {};
        fd.forEach((v,k)=>{ params[k]=v; });
        const page = new URLSearchParams(window.location.search).get('page');
        if (page) params['page'] = page;
        return params;
    }

    async function fetchResults(page=1){
        const params = collectParams();
        params['page'] = page;
        params['action'] = 'admin_payment_search_ajax';

        loading.classList.add('show');
        try{
            const resp = await fetch('index.php?' + buildQuery(params), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const html = await resp.text();
            results.innerHTML = html;
        }catch(e){
            results.innerHTML = '<div style="padding:18px;color:#be123c;font-weight:900;">Lỗi tải kết quả</div>';
        }finally{
            loading.classList.remove('show');
        }
    }

    form.addEventListener('submit', function(e){
        e.preventDefault();
        const params = collectParams();
        delete params['action'];

        const u = new URL(window.location.href);
        Object.keys(params).forEach(k => { u.searchParams.set(k, params[k]); });
        u.searchParams.set('action','admin_payment_search');
        u.searchParams.delete('page');
        history.replaceState({}, '', u);

        fetchResults(1);
    });

    resetBtn.addEventListener('click', function(){
        const u = new URL(window.location.href);
        ['keyword','payment_status','payment_method','booking_date','page','action'].forEach(k=>u.searchParams.delete(k));
        u.searchParams.set('action','admin_payment_search');
        history.replaceState({}, '', u);
        form.querySelector('input[name="keyword"]').value = '';
        form.querySelector('select[name="payment_status"]').value = '';
        form.querySelector('select[name="payment_method"]').value = '';
        form.querySelector('input[name="booking_date"]').value = '';
        fetchResults(1);
    });

    results.addEventListener('click', function(e){
        const a = e.target.closest('a[data-page]');
        if(!a) return;
        e.preventDefault();
        const page = parseInt(a.getAttribute('data-page') || '1',10);
        fetchResults(page);
    });
})();
</script>

<?php
require_once PROJECT_ROOT . '/views/layout/footer.php';


