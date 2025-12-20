<div class="section-header">
    <h2>🔍 Search Results</h2>
</div>

<?php if (!empty($query)): ?>
<p style="margin-bottom: 20px;">Showing results for: <strong>"<?= htmlspecialchars($query) ?>"</strong></p>
<?php endif; ?>

<?php if (empty($results)): ?>
<div class="card" style="text-align: center; padding: 50px;">
    <h3>No results found</h3>
    <p>Try a different search term.</p>
</div>
<?php else: ?>

<div class="card-grid">
    <?php foreach ($results as $result): ?>
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <h3><?= htmlspecialchars($result['title']) ?></h3>
            <span class="badge badge-primary"><?= $result['type'] ?></span>
        </div>
        <p style="margin: 10px 0; color: #666;"><?= htmlspecialchars(substr($result['description'], 0, 100)) ?>...</p>
        
        <?php 
        $link = match($result['type']) {
            'Idea' => BASE_URL . '/ideas',
            'Job' => BASE_URL . '/jobs',
            'Event' => BASE_URL . '/events',
            default => '#'
        };
        ?>
        <a href="<?= $link ?>" class="btn btn-sm">View Details</a>
    </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<div style="margin-top: 30px;">
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px; margin-bottom: 30px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>/search?q=<?= urlencode($query) ?>&page=<?= $i ?>" 
               class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/search" method="GET" style="display: flex; gap: 10px; max-width: 500px;">
        <input type="text" name="q" value="<?= htmlspecialchars($query ?? '') ?>" placeholder="Search again..." style="flex: 1; padding: 12px 20px; border-radius: 25px; border: 2px solid #e0e0e0;">
        <button type="submit" class="btn">Search</button>
    </form>
</div>
