<div class="section-header">
    <h2>💼 My Applications</h2>
</div>

<?php if (empty($candidatures)): ?>
<div class="card" style="text-align:center;padding:40px;">
    <h3>No applications yet</h3>
    <p>You haven't applied to any offers. Browse <a href="<?= BASE_URL ?>/jobs">offers</a> and apply to see them here.</p>
</div>
<?php else: ?>
<div class="card-grid">
    <?php foreach ($candidatures as $c): ?>
    <div class="card">
        <h3><?= htmlspecialchars($c['job_title']) ?></h3>
        <p style="font-weight:600;color:var(--secondary);">🏢 <?= htmlspecialchars($c['company']) ?></p>
        <p style="color:#666;"><?= nl2br(htmlspecialchars(substr($c['cover_letter'] ?? '', 0, 220))) ?><?php if (strlen($c['cover_letter'] ?? '') > 220) echo '...'; ?></p>
        <p style="font-size:0.85rem;color:#999;">Applied <?= date('M d, Y', strtotime($c['created_at'])) ?></p>
        <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap">
            <a href="<?= BASE_URL ?>/jobs" class="btn btn-sm">View Offers</a>
            <a href="<?= BASE_URL ?>/candidatures/view?id=<?= $c['id'] ?>" class="btn btn-outline btn-sm">View</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="display:flex;justify-content:center;gap:10px;margin-top:20px;">
    <?php for ($i=1;$i<=$totalPages;$i++): ?>
        <a href="<?= BASE_URL ?>/jobs/my_offers?page=<?= $i ?>" class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm"><?= $i ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>
