<h2>Pending Approvals</h2>

<h3>Ideas</h3>
<?php if (empty($ideas)): ?>
    <p>No pending ideas.</p>
<?php else: ?>
    <?php foreach ($ideas as $idea): ?>
    <div class="card">
        <h4><?= htmlspecialchars($idea['title']) ?> (by <?= htmlspecialchars($idea['author_name']) ?>)</h4>
        <p><?= htmlspecialchars($idea['description']) ?></p>
        <a href="<?= BASE_URL ?>/admin/approve?type=idea&id=<?= $idea['id'] ?>" class="btn" style="background-color: #2a9d8f;">Approve</a>
        <a href="<?= BASE_URL ?>/admin/reject?type=idea&id=<?= $idea['id'] ?>" class="btn" style="background-color: #e63946;">Reject</a>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<h3>Job Offers</h3>
<?php if (empty($jobs)): ?>
    <p>No pending jobs.</p>
<?php else: ?>
    <?php foreach ($jobs as $job): ?>
    <div class="card">
        <h4><?= htmlspecialchars($job['title']) ?> at <?= htmlspecialchars($job['company']) ?></h4>
        <p><?= htmlspecialchars($job['description']) ?></p>
        <a href="<?= BASE_URL ?>/admin/approve?type=job&id=<?= $job['id'] ?>" class="btn" style="background-color: #2a9d8f;">Approve</a>
        <a href="<?= BASE_URL ?>/admin/reject?type=job&id=<?= $job['id'] ?>" class="btn" style="background-color: #e63946;">Reject</a>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<h3>Events</h3>
<?php if (empty($events)): ?>
    <p>No pending events.</p>
<?php else: ?>
    <?php foreach ($events as $event): ?>
    <div class="card">
        <h4><?= htmlspecialchars($event['title']) ?> (<?= $event['date'] ?>)</h4>
        <p><?= htmlspecialchars($event['description']) ?></p>
        <a href="<?= BASE_URL ?>/admin/approve?type=event&id=<?= $event['id'] ?>" class="btn" style="background-color: #2a9d8f;">Approve</a>
        <a href="<?= BASE_URL ?>/admin/reject?type=event&id=<?= $event['id'] ?>" class="btn" style="background-color: #e63946;">Reject</a>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
