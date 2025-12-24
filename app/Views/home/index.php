<!-- Intro Section -->
<section class="intro-section">
    <div class="intro-inner">
        <h1>Welcome to <?= htmlspecialchars(FOOTER_TITLE) ?></h1>
        <p class="lead"><?= htmlspecialchars(FOOTER_DESCRIPTION) ?></p>
        <p><a href="<?= BASE_URL ?>/about" class="btn">Learn more</a></p>
    </div>
</section>

<!-- Gestions Cards -->
<section class="gestions-section">
    <h2>Management Areas</h2>
    <div class="gestions-grid">
        <div class="gestion-card bg-pink">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1521295121783-8a321d551ad2?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <h3>Ideas Management</h3>
            <p>Submit and review ideas, collaborate with creators and follow progress from concept to startup.</p>
            <a href="<?= BASE_URL ?>/ideas" class="btn">Open Ideas</a>
        </div>
        <div class="gestion-card bg-yellow">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1603575448360-7f0a7a9a6b7a?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <h3>Investments</h3>
            <p>Manage investments, view opportunities and support projects that match your interests.</p>
            <a href="<?= BASE_URL ?>/investments" class="btn">Open Investments</a>
        </div>
        <div class="gestion-card bg-green">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1503424886301-1a0b6a7c9f0e?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <h3>Events Management</h3>
            <p>Create and manage events, register participants and keep the community engaged.</p>
            <a href="<?= BASE_URL ?>/events" class="btn">Open Events</a>
        </div>
        <div class="gestion-card bg-blue">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <h3>Jobs & Hiring</h3>
            <p>Post job offers, review applications and connect talent with growing teams.</p>
            <a href="<?= BASE_URL ?>/jobs" class="btn">Open Jobs</a>
        </div>
    </div>
</section>

<!-- carousel removed: using large gestions cards instead -->

<!-- About excerpt on home page -->
<section class="about-section">
    <div class="about-card">
        <h2><?= htmlspecialchars(FOOTER_TITLE) ?></h2>
        <p><?= htmlspecialchars(FOOTER_DESCRIPTION) ?></p>
        <p style="margin-top:12px;"><a href="#site-footer" class="btn">Learn more</a></p>
    </div>
</section>
