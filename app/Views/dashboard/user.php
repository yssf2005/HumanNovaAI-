<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>👋 Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>!</h2>
        <p>Here's your activity overview on PILLAR</p>
    </div>
    <a href="<?= BASE_URL ?>/profile" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
        ⚙️ Edit Profile
    </a>
</div>

<h3 style="margin-bottom: 15px;">📊 Your Statistics</h3>
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon">💡</span>
        <span class="stat-number"><?= $stats['ideas'] ?? 0 ?></span>
        <span class="stat-label">Ideas Submitted</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">💰</span>
        <span class="stat-number"><?= $stats['investments'] ?? 0 ?></span>
        <span class="stat-label">Investments Made</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">📅</span>
        <span class="stat-number"><?= $stats['events'] ?? 0 ?></span>
        <span class="stat-label">Events Joined</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">📝</span>
        <span class="stat-number"><?= $stats['posts'] ?? 0 ?></span>
        <span class="stat-label">Blog Posts</span>
    </div>
    <div class="stat-card">
        <span class="stat-icon">💬</span>
        <span class="stat-number"><?= $stats['comments'] ?? 0 ?></span>
        <span class="stat-label">Comments</span>
    </div>
</div>

<h3 style="margin: 30px 0 15px;">⚡ Quick Actions</h3>
<div class="card-grid">
    <div class="card">
        <h3>💡 My Ideas</h3>
        <p>Submit and track your innovations.</p>
        <a href="<?= BASE_URL ?>/my-ideas" class="btn">View Ideas</a>
        <a href="<?= BASE_URL ?>/ideas/create" class="btn btn-warning btn-sm">+ New Idea</a>
    </div>
    <div class="card">
        <h3>💰 Investments</h3>
        <p>View your investment portfolio.</p>
        <a href="<?= BASE_URL ?>/my-investments" class="btn">My Investments</a>
    </div>
    <div class="card">
        <h3>💼 Job Board</h3>
        <p>Find new opportunities.</p>
        <a href="<?= BASE_URL ?>/jobs" class="btn">Browse Jobs</a>
        <a href="<?= BASE_URL ?>/jobs/create" class="btn btn-warning btn-sm">+ Post Job</a>
    </div>
    <div class="card">
        <h3>📋 My Applications</h3>
        <p>Track your job applications.</p>
        <a href="<?= BASE_URL ?>/my-applications" class="btn">View Applications</a>
    </div>
    <div class="card">
        <h3>📅 Events</h3>
        <p>Join upcoming events.</p>
        <a href="<?= BASE_URL ?>/events" class="btn">Browse Events</a>
        <a href="<?= BASE_URL ?>/events/create" class="btn btn-warning btn-sm">+ Create Event</a>
    </div>
    <div class="card">
        <h3>📸 Social Feed</h3>
        <p>Share and connect with others.</p>
        <a href="<?= BASE_URL ?>/feed" class="btn">Go to Feed</a>
    </div>
</div>
