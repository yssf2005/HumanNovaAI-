<div class="dashboard-header">
    <h2>Admin Dashboard</h2>
    <p>Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?>! Manage your platform.</p>
</div>

<h3 style="margin-bottom: 15px;">Platform Statistics</h3>
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon"></span>
        <span class="stat-number"><?= $stats['users'] ?? 0 ?></span>
        <span class="stat-label">Total Users</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon"></span>
        <span class="stat-number"><?= $stats['ideas'] ?? 0 ?></span>
        <span class="stat-label">Total Ideas</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon"></span>
        <span class="stat-number"><?= $stats['jobs'] ?? 0 ?></span>
        <span class="stat-label">Job Offers</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon"></span>
        <span class="stat-number"><?= $stats['events'] ?? 0 ?></span>
        <span class="stat-label">Events</span>
    </div>
    <div class="stat-card" style="border-left-color: #e76f51;">
        <span class="stat-icon"></span>
        <span class="stat-number"><?= $stats['pending'] ?? 0 ?></span>
        <span class="stat-label">Pending Approvals</span>
    </div>
</div>

    <h3 style="margin: 30px 0 15px;">Admin Actions</h3>
<div class="card-grid">
    <div class="card" style="border-left: 4px solid #e76f51;">
        <h3>Pending Approvals</h3>
        <p>Review submitted content.</p>
        <a href="<?= BASE_URL ?>/admin/approvals" class="btn" style="background: linear-gradient(135deg, #e76f51, #c75b42);">Review Queue</a>
    </div>
    <div class="card">
        <h3>Manage Ideas</h3>
        <p>View and moderate ideas.</p>
        <a href="<?= BASE_URL ?>/ideas" class="btn">View All</a>
    </div>
    <div class="card">
        <h3>Job Offers</h3>
        <p>Post and manage jobs.</p>
        <a href="<?= BASE_URL ?>/jobs" class="btn">View Jobs</a>
        <button type="button" class="btn btn-warning btn-sm modal-trigger" data-modal="jobModal" onclick="(function(){ if(window.Pillar && window.Pillar.openModal){ window.Pillar.openModal('jobModal'); return; } var m=document.getElementById('jobModal'); var b=document.getElementById('modalBackdrop'); if(m && b){ m.classList.add('open'); m.setAttribute('aria-hidden','false'); b.classList.add('open'); b.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } })();">+ New</button>
    </div>
    <div class="card">
        <h3>Events</h3>
        <p>Organize events.</p>
        <a href="<?= BASE_URL ?>/events" class="btn">View Events</a>
        <button type="button" class="btn btn-warning btn-sm modal-trigger" data-modal="eventModal" onclick="(function(){ if(window.Pillar && window.Pillar.openModal){ window.Pillar.openModal('eventModal'); return; } var m=document.getElementById('eventModal'); var b=document.getElementById('modalBackdrop'); if(m && b){ m.classList.add('open'); m.setAttribute('aria-hidden','false'); b.classList.add('open'); b.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden'; } })();">+ New</button>
    </div>
</div>
