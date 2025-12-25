<div class="section-header">
    <h2>💼 Career Opportunities</h2>
    <div style="display:flex;gap:8px;align-items:center;">
        <a href="<?= BASE_URL ?>/jobs/create" class="btn">+ Post Job</a>
        <button type="button" class="btn modal-trigger" data-modal="jobModal">Quick Post</button>
    </div>
</div>

<!-- Search and Filter -->
<div class="card" style="margin-bottom: 25px;">
    <form action="<?= BASE_URL ?>/jobs" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" 
               placeholder="🔍 Search jobs..." 
               style="flex: 1; min-width: 200px; padding: 12px 20px; border-radius: 25px; border: 2px solid #e0e0e0;">
        
        <select name="category" style="padding: 12px 20px; border-radius: 25px; border: 2px solid #e0e0e0;">
            <option value="">All Categories</option>
            <option value="Technology" <?= ($category ?? '') === 'Technology' ? 'selected' : '' ?>>💻 Technology</option>
            <option value="Marketing" <?= ($category ?? '') === 'Marketing' ? 'selected' : '' ?>>📢 Marketing</option>
            <option value="Finance" <?= ($category ?? '') === 'Finance' ? 'selected' : '' ?>>💰 Finance</option>
            <option value="Design" <?= ($category ?? '') === 'Design' ? 'selected' : '' ?>>🎨 Design</option>
            <option value="Sales" <?= ($category ?? '') === 'Sales' ? 'selected' : '' ?>>📈 Sales</option>
            <option value="HR" <?= ($category ?? '') === 'HR' ? 'selected' : '' ?>>👥 Human Resources</option>
            <option value="Other" <?= ($category ?? '') === 'Other' ? 'selected' : '' ?>>📦 Other</option>
        </select>
        
        <button type="submit" class="btn">Filter</button>
        <?php if (!empty($search) || !empty($category)): ?>
            <a href="<?= BASE_URL ?>/jobs" class="btn btn-secondary">Clear</a>
        <?php endif; ?>
    </form>
</div>

<div class="card-grid">
    <?php foreach ($jobs as $job): ?>
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <h3><?= htmlspecialchars($job['title']) ?></h3>
            <span class="badge"><?= htmlspecialchars($job['category'] ?? 'General') ?></span>
        </div>
        <p style="font-weight: 600; color: var(--secondary); margin: 5px 0;">
            🏢 <?= htmlspecialchars($job['company']) ?>
        </p>
        <p style="margin: 10px 0; color: #666;"><?= nl2br(htmlspecialchars(substr($job['description'], 0, 120))) ?>...</p>
        <p style="font-size: 0.8rem; color: #999;">
            📅 Posted <?= date('M d, Y', strtotime($job['created_at'])) ?>
        </p>
        <div style="margin-top: 15px; display: flex; gap: 5px; flex-wrap: wrap;">
            <a href="<?= BASE_URL ?>/apply?job_id=<?= $job['id'] ?>" class="btn btn-success btn-sm">📝 Apply Now</a>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                <a href="<?= BASE_URL ?>/jobs/edit?id=<?= $job['id'] ?>" class="btn btn-secondary btn-sm">✏️ Edit</a>
                <a href="<?= BASE_URL ?>/jobs/delete?id=<?= $job['id'] ?>" class="btn btn-sm delete-link" style="background: #e63946;">🗑️</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($jobs)): ?>
<div class="card" style="text-align: center; padding: 50px;">
    <h3>No job openings found!</h3>
    <p><?= !empty($search) || !empty($category) ? 'Try adjusting your filters.' : 'Check back later for new opportunities.' ?></p>
</div>
<?php endif; ?>

<!-- Job modal (quick-post) -->
<div class="modal large" id="jobModal" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-inner">
        <button class="close-btn" data-close>&times;</button>
        <h3>Create a Job</h3>
        <form method="post" action="<?= BASE_URL ?>/jobs/store">
            <label>Title<br><input name="title" required></label>
            <label>Company<br><input name="company"></label>
            <label>Category<br>
                <select name="category">
                    <option value="">Select</option>
                    <option>Technology</option>
                    <option>Marketing</option>
                    <option>Finance</option>
                    <option>Design</option>
                </select>
            </label>
            <label>Description<br><textarea name="description" rows="6" required></textarea></label>
            <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Create</button> <button type="button" class="btn" data-close>Cancel</button></div>
        </form>
    </div>
</div>

<!-- Pagination -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= BASE_URL ?>/jobs?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($category) ? '&category=' . urlencode($category) : '' ?>" 
           class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
