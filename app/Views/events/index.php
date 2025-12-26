<div class="section-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2>Events</h2>
    <div style="display:flex;gap:8px;align-items:center;">
        <button type="button" class="btn modal-trigger" data-modal="eventModal" onclick="(function(){ if(window.Pillar && window.Pillar.openModal){ window.Pillar.openModal('eventModal'); return; } var m=document.getElementById('eventModal'); var b=document.getElementById('modalBackdrop'); if(m && b){ m.classList.add('open'); m.setAttribute('aria-hidden','false'); b.classList.add('open'); b.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } })();">+ Create Event</button>
    </div>
</div>

<!-- Search -->
<div class="card" style="margin-bottom: 18px;">
    <form action="<?= BASE_URL ?>/events" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search events..." style="flex:1; min-width:180px; padding:10px 16px; border-radius:20px; border:1px solid #e6e6e6;">
        <button type="submit" class="btn">Search</button>
        <?php if (!empty($search)): ?><a href="<?= BASE_URL ?>/events" class="btn btn-secondary">Clear</a><?php endif; ?>
    </form>
</div>

<!-- Upcoming events -->
<h3 style="margin-top:6px;">Upcoming Events</h3>
<div class="card-grid">
    <?php if (!empty($upcoming)): foreach ($upcoming as $event): ?>
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:start;">
            <h3><?= htmlspecialchars($event['title']) ?></h3>
            <span class="badge badge-info">Soon</span>
        </div>
        <p style="font-weight:700;color:var(--primary);margin:8px 0;"><?= date('F d, Y - H:i', strtotime($event['date'])) ?></p>
        <p><strong><?= htmlspecialchars($event['location']) ?></strong></p>
        <p style="color:#666;"><?= nl2br(htmlspecialchars(substr($event['description'],0,120))) ?>...</p>
        <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap;">
            <?php if ($event['is_participating'] ?? false): ?><button class="btn btn-secondary btn-sm" disabled>Registered</button>
            <?php else: ?><a href="<?= BASE_URL ?>/events/participate?id=<?= $event['id'] ?>" class="btn btn-success btn-sm">Participate</a><?php endif; ?>
            <a href="<?= BASE_URL ?>/events/edit?id=<?= $event['id'] ?>" class="btn btn-secondary btn-sm" style="<?php if(!isset($_SESSION['user_role'])||$_SESSION['user_role']!='admin'){echo 'display:none;';} ?>">Edit</a>
        </div>
    </div>
    <?php endforeach; else: ?>
        <div class="card" style="text-align:center; padding:30px;">No upcoming events.</div>
    <?php endif; ?>
</div>

<!-- Recent events -->
<h3 style="margin-top:20px;">Recent Events</h3>
<div class="card-grid">
    <?php if (!empty($recent)): foreach ($recent as $event): ?>
    <div class="card">
        <h4><?= htmlspecialchars($event['title']) ?></h4>
        <p style="font-size:0.95rem;color:#666;">Added <?= date('M d, Y', strtotime($event['created_at'] ?? $event['date'])) ?> — <?= date('M d, Y', strtotime($event['date'])) ?></p>
        <p><?= nl2br(htmlspecialchars(substr($event['description'],0,100))) ?>...</p>
    </div>
    <?php endforeach; else: ?>
        <div class="card" style="text-align:center; padding:20px;">No recent events.</div>
    <?php endif; ?>
</div>

<!-- Past events directory -->
<h3 style="margin-top:20px;">Past Events</h3>
<?php if (!empty($pastEvents)): ?>
    <div class="card-grid">
        <?php foreach ($pastEvents as $event): ?>
        <div class="card">
            <h4><?= htmlspecialchars($event['title']) ?></h4>
            <p style="font-size:0.95rem;color:#666;">Occurred <?= date('M d, Y', strtotime($event['date'])) ?></p>
            <p><?= nl2br(htmlspecialchars(substr($event['description'],0,160))) ?>...</p>
            <div style="margin-top:10px;">
                <a href="<?= BASE_URL ?>/events/edit?id=<?= $event['id'] ?>" class="btn btn-secondary btn-sm" style="<?php if(!isset($_SESSION['user_role'])||$_SESSION['user_role']!='admin'){echo 'display:none;';} ?>">Edit</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($pastTotalPages) && $pastTotalPages > 1): ?>
    <div style="display:flex;justify-content:center;gap:8px;margin-top:18px;">
        <?php for ($i = 1; $i <= $pastTotalPages; $i++): ?>
            <a href="<?= BASE_URL ?>/events?past_page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" class="btn <?= ($pastPage ?? 1) == $i ? '' : 'btn-secondary' ?> btn-sm"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
<?php else: ?>
    <div class="card" style="text-align:center;padding:20px;">No past events found.</div>
<?php endif; ?>

<!-- Event modal (quick-create) -->
<div class="modal large" id="eventModal" role="dialog" aria-modal="true" aria-hidden="true">
  <div class="modal-inner">
    <button class="close-btn" data-close>&times;</button>
    <h3>Create an Event</h3>
    <form method="post" action="<?= BASE_URL ?>/events/store">
      <label>Title<br><input name="title" required></label>
      <label>Date<br><input type="datetime-local" name="date"></label>
      <label>Location<br><input name="location"></label>
      <label>Description<br><textarea name="description" rows="6" required></textarea></label>
      <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Create</button> <button type="button" class="btn" data-close>Cancel</button></div>
    </form>
  </div>
</div>
