<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>👋 Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>!</h2>
        <p>Here's your activity overview on PILLAR</p>
    </div>
    <a href="<?= BASE_URL ?>/profile" class="action-link action-small" style="display: flex; align-items: center; gap: 8px;">
        Edit Profile
    </a>
</div>

<h3 style="margin-bottom: 15px;">Your Statistics</h3>
<div class="stats-grid">
    <div class="stat-card">
        
        <span class="stat-number"><?= $stats['ideas'] ?? 0 ?></span>
        <span class="stat-label">Ideas Submitted</span>
    </div>
    <div class="stat-card">
        
        <span class="stat-number"><?= $stats['investments'] ?? 0 ?></span>
        <span class="stat-label">Investments Made</span>
    </div>
    <div class="stat-card">
        
        <span class="stat-number"><?= $stats['events'] ?? 0 ?></span>
        <span class="stat-label">Events Joined</span>
    </div>
    <div class="stat-card">
        
        <span class="stat-number"><?= $stats['posts'] ?? 0 ?></span>
        <span class="stat-label">Blog Posts</span>
    </div>
    <div class="stat-card">
        
        <span class="stat-number"><?= $stats['comments'] ?? 0 ?></span>
        <span class="stat-label">Comments</span>
    </div>
</div>

<h3 style="margin: 30px 0 15px;">Quick Actions</h3>
<div class="card-grid">
    <div class="card">
        <h3>My Ideas</h3>
        <p>Submit and track your innovations.</p>
        <a href="<?= BASE_URL ?>/my-ideas" class="action-link action-small">View Ideas</a>
        <button type="button" class="action-link action-warn action-small modal-trigger" data-modal="ideaModal" onclick="(function(){ if(window.Pillar && window.Pillar.openModal){ window.Pillar.openModal('ideaModal'); return; } var m=document.getElementById('ideaModal'); var b=document.getElementById('modalBackdrop'); if(m && b){ m.classList.add('open'); m.setAttribute('aria-hidden','false'); b.classList.add('open'); b.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } })();">+ New Idea</button>
    </div>
    <div class="card">
        <h3>Investments</h3>
        <p>View your investment portfolio.</p>
        <a href="<?= BASE_URL ?>/my-investments" class="action-link action-small">My Investments</a>
    </div>
    <div class="card">
        <h3>Job Board</h3>
        <p>Find new opportunities.</p>
        <a href="<?= BASE_URL ?>/jobs" class="action-link action-small">Browse Jobs</a>
        <button type="button" class="action-link action-warn action-small modal-trigger" data-modal="jobModal" onclick="(function(){ if(window.Pillar && window.Pillar.openModal){ window.Pillar.openModal('jobModal'); return; } var m=document.getElementById('jobModal'); var b=document.getElementById('modalBackdrop'); if(m && b){ m.classList.add('open'); m.setAttribute('aria-hidden','false'); b.classList.add('open'); b.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } })();">+ Post Job</button>
    </div>
    <div class="card">
        <h3>📋 My Applications</h3>
        <p>Track your job applications.</p>
        <a href="<?= BASE_URL ?>/my-applications" class="action-link action-small">View Applications</a>
    </div>
    <div class="card">
        <h3>Events</h3>
        <p>Join upcoming events.</p>
        <a href="<?= BASE_URL ?>/events" class="action-link action-small">Browse Events</a>
        <button type="button" class="action-link action-warn action-small modal-trigger" data-modal="eventModal" onclick="(function(){ if(window.Pillar && window.Pillar.openModal){ window.Pillar.openModal('eventModal'); return; } var m=document.getElementById('eventModal'); var b=document.getElementById('modalBackdrop'); if(m && b){ m.classList.add('open'); m.setAttribute('aria-hidden','false'); b.classList.add('open'); b.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } })();">+ Create Event</button>
    </div>
    <div class="card">
        <h3>Social Feed</h3>
        <p>Share and connect with others.</p>
        <a href="<?= BASE_URL ?>/feed" class="action-link action-small">Go to Feed</a>
    </div>
</div>
