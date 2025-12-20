<div class="section-header">
    <h2>💰 <?= isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ? 'All Investments' : 'My Investments' ?></h2>
    <a href="<?= BASE_URL ?>/ideas" class="btn">Browse Ideas to Invest</a>
</div>

<?php if (empty($investments)): ?>
<div class="card" style="text-align: center; padding: 50px;">
    <h3>No investments yet!</h3>
    <p>Browse ideas and make your first investment.</p>
    <a href="<?= BASE_URL ?>/ideas" class="btn" style="margin-top: 15px;">Browse Ideas</a>
</div>
<?php else: ?>

<div class="card-grid">
    <?php foreach ($investments as $inv): ?>
    <div class="card" style="border-left: 4px solid #2a9d8f;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <h3><?= htmlspecialchars($inv['idea_title'] ?? 'Idea #' . $inv['idea_id']) ?></h3>
            <span class="badge badge-success">💰 Investment</span>
        </div>
        <p style="font-size: 2rem; font-weight: 700; color: #2a9d8f; margin: 15px 0;">
            $<?= number_format($inv['amount'], 2) ?>
        </p>
        <p style="font-size: 0.85rem; color: #666;">
            📅 Invested on <?= date('M d, Y', strtotime($inv['created_at'])) ?>
        </p>
        <?php if (isset($inv['investor_name'])): ?>
        <p style="font-size: 0.85rem; color: #666;">
            👤 By <?= htmlspecialchars($inv['investor_name']) ?>
        </p>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<!-- Pagination -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= BASE_URL ?>/investments?page=<?= $i ?>" 
           class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
