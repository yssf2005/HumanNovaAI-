<div class="section-header">
    <h2>📅 Upcoming Events</h2>
    <a href="<?= BASE_URL ?>/events/create" class="btn">+ Create Event</a>
</div>

<!-- Search -->
<div class="card" style="margin-bottom: 25px;">
    <form action="<?= BASE_URL ?>/events" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" 
               placeholder="🔍 Search events..." 
               style="flex: 1; min-width: 200px; padding: 12px 20px; border-radius: 25px; border: 2px solid #e0e0e0;">
        <button type="submit" class="btn">Search</button>
        <?php if (!empty($search)): ?>
            <a href="<?= BASE_URL ?>/events" class="btn btn-secondary">Clear</a>
        <?php endif; ?>
    </form>
</div>

<div class="card-grid">
    <?php foreach ($events as $event): ?>
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <h3><?= htmlspecialchars($event['title']) ?></h3>
            <span class="badge badge-success">📅 Event</span>
        </div>
        <p style="font-weight: 600; color: var(--primary); margin: 10px 0;">
            🗓️ <?= date('F d, Y - H:i', strtotime($event['date'])) ?>
        </p>
        <p style="margin: 5px 0;">
            📍 <strong><?= htmlspecialchars($event['location']) ?></strong>
        </p>
        <p style="margin: 10px 0; color: #666;"><?= nl2br(htmlspecialchars(substr($event['description'], 0, 100))) ?>...</p>
        
        <div style="margin-top: 15px; display: flex; gap: 5px; flex-wrap: wrap;">
            <?php if ($event['is_participating'] ?? false): ?>
                <button class="btn btn-secondary btn-sm" disabled>✅ Registered</button>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/events/participate?id=<?= $event['id'] ?>" class="btn btn-success btn-sm">🎟️ Participate</a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                <a href="<?= BASE_URL ?>/events/edit?id=<?= $event['id'] ?>" class="btn btn-secondary btn-sm">✏️ Edit</a>
                <a href="<?= BASE_URL ?>/events/delete?id=<?= $event['id'] ?>" class="btn btn-sm delete-link" style="background: #e63946;">🗑️</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($events)): ?>
<div class="card" style="text-align: center; padding: 50px;">
    <h3>No events <?= !empty($search) ? 'found' : 'scheduled' ?>!</h3>
    <p><?= !empty($search) ? 'Try a different search term.' : 'Check back later or create your own event.' ?></p>
    <a href="<?= BASE_URL ?>/events/create" class="btn" style="margin-top: 15px;">Create Event</a>
</div>
<?php endif; ?>

<!-- Pagination -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="<?= BASE_URL ?>/events?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" 
           class="btn <?= ($page ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
