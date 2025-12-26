<div class="section-header">
    <h2>📋 My Job Applications</h2>
    <a href="<?= BASE_URL ?>/jobs" class="btn">Browse More Jobs</a>
</div>

<?php if (empty($candidatures)): ?>
<div class="card" style="text-align: center; padding: 50px;">
    <h3>No applications yet!</h3>
    <p>Browse job offers and apply to start your journey.</p>
    <a href="<?= BASE_URL ?>/jobs" class="btn" style="margin-top: 15px;">Browse Jobs</a>
</div>
<?php else: ?>

<div class="card-grid">
    <?php foreach ($candidatures as $app): ?>
    <div class="card" style="border-left: 4px solid #457b9d;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <h3><?= htmlspecialchars($app['job_title'] ?? 'Job #' . $app['job_id']) ?></h3>
            <span class="badge"><?= ucfirst($app['status'] ?? 'pending') ?></span>
        </div>
        <p style="margin: 10px 0; color: #666;">
            <?= htmlspecialchars($app['company'] ?? 'Company') ?>
        </p>
        <p style="font-size: 0.85rem; color: #999;">
            Applied on <?= date('M d, Y', strtotime($app['created_at'])) ?>
        </p>
        <?php if (!empty($app['cover_letter'])): ?>
        <details style="margin-top: 10px;">
            <summary style="cursor: pointer; color: var(--primary);">View Cover Letter</summary>
            <p style="margin-top: 10px; padding: 10px; background: #f9f9f9; border-radius: 8px;">
                <?= nl2br(htmlspecialchars($app['cover_letter'])) ?>
            </p>
        </details>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<!-- Pagination -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= BASE_URL ?>/my-applications?page=<?= $i ?>" 
           class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
