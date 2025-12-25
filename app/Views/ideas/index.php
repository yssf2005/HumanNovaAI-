<div class="section-header">
    <h2>💡 Innovation Ideas</h2>
    <div style="display:flex;gap:8px;align-items:center;">
        <a href="<?= BASE_URL ?>/ideas/create" class="btn">+ Submit Idea</a>
        <button type="button" class="btn modal-trigger" data-modal="ideaModal">Quick Submit</button>
    </div>
</div>

<!-- Search -->
<div class="card" style="margin-bottom: 25px;">
    <form action="<?= BASE_URL ?>/ideas" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" 
               placeholder="🔍 Search ideas..." 
               style="flex: 1; min-width: 200px; padding: 12px 20px; border-radius: 25px; border: 2px solid #e0e0e0;">
        <button type="submit" class="btn">Search</button>
        <?php if (!empty($search)): ?>
            <a href="<?= BASE_URL ?>/ideas" class="btn btn-secondary">Clear</a>
        <?php endif; ?>
    </form>
</div>

<div class="card-grid">
    <?php foreach ($ideas as $idea): ?>
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <h3><?= htmlspecialchars($idea['title']) ?></h3>
            <span class="badge badge-primary">💡 Idea</span>
        </div>
        <p style="margin: 10px 0;"><?= nl2br(htmlspecialchars(substr($idea['description'], 0, 150))) ?>...</p>
        <p style="font-size: 0.85rem; color: #666;">
            By <strong><?= htmlspecialchars($idea['author_name'] ?? 'Unknown') ?></strong>
        </p>
        <div style="margin-top: 15px; display: flex; gap: 5px; flex-wrap: wrap;">
            <a href="<?= BASE_URL ?>/invest?idea_id=<?= $idea['id'] ?>" class="btn btn-success btn-sm">💰 Invest</a>
            <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $idea['user_id'] || $_SESSION['user_role'] == 'admin')): ?>
                <a href="<?= BASE_URL ?>/ideas/edit?id=<?= $idea['id'] ?>" class="btn btn-secondary btn-sm">✏️ Edit</a>
                <a href="<?= BASE_URL ?>/ideas/delete?id=<?= $idea['id'] ?>" class="btn btn-sm delete-link" style="background: #e63946;">🗑️</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($ideas)): ?>
<div class="card" style="text-align: center; padding: 50px;">
    <h3>No ideas <?= !empty($search) ? 'found' : 'yet' ?>!</h3>
    <p><?= !empty($search) ? 'Try a different search term.' : 'Be the first to submit an innovative idea.' ?></p>
    <a href="<?= BASE_URL ?>/ideas/create" class="btn" style="margin-top: 15px;">Submit Your Idea</a>
</div>
<?php endif; ?>

<!-- Pagination -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
    <?php 
    $baseUrl = isset($myIdeas) ? BASE_URL . '/ideas/my-ideas' : BASE_URL . '/ideas';
    for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= $baseUrl ?>?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" 
           class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>

<!-- Idea modal (quick-submit) -->
<div class="modal large" id="ideaModal" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-inner">
        <button class="close-btn" data-close>&times;</button>
        <h3>Submit an Idea</h3>
        <form method="post" action="<?= BASE_URL ?>/ideas/store">
            <label>Title<br><input name="title" required></label>
            <label>Description<br><textarea name="description" rows="6" required></textarea></label>
            <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Submit</button> <button type="button" class="btn" data-close>Cancel</button></div>
        </form>
    </div>
</div>
