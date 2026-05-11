<?php
// views/admin/contacts/ContactsList.php
// Hiển thị danh sách tin nhắn liên hệ
?>

<style>
    .page-title {
        font-size: 24px;
        font-weight: 800;
        margin: 24px 0 14px;
    }

    .card {
        background: #fff;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        padding: 12px 10px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: top;
        font-size: 13px;
    }

    th {
        text-align: left;
        font-weight: 800;
        color: #0f172a;
        background: #f8fafc;
    }

    .empty-state {
        padding: 18px;
        border: 1.5px dashed #e2e8f0;
        border-radius: 12px;
        color: #64748b;
        font-weight: 700;
        font-size: 13px;
        margin-top: 10px;
    }

    .message-cell {
        max-width: 520px;
        white-space: pre-wrap;
        word-break: break-word;
        color: #334155;
    }

    .meta {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        margin-top: 6px;
    }
</style>

<div class="page-title">📩 Tin nhắn Liên hệ</div>

<div class="card">
    <?php if (empty($contacts)): ?>
        <div class="empty-state">Chưa có tin nhắn nào.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width: 160px;">Người gửi</th>
                    <th style="width: 220px;">Email</th>
                    <th>Nội dung</th>
                    <th style="width: 180px;">Thời gian</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $c): ?>
                    <tr>
                        <td>
                            <div style="font-weight:800;color:#0f172a;"><?= htmlspecialchars($c['name'] ?? '') ?></div>
                        </td>
                        <td><?= htmlspecialchars($c['email'] ?? '') ?></td>
                        <td class="message-cell"><?= htmlspecialchars($c['message'] ?? '') ?></td>
                        <td>
                            <div class="meta"><?= htmlspecialchars($c['submitted_at'] ?? '') ?></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

