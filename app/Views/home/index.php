<!-- Intro Section -->
<section class="intro-section">
    <div class="intro-inner">
        <h1>Welcome to <?= htmlspecialchars(FOOTER_TITLE) ?></h1>
        <p class="lead">A collaborative platform that connects creators, investors, and talent — bringing ideas to life through tools for idea submission, funding, hiring and events. Start exploring or manage your projects with the tools below.</p>
        <p class="intro-sub">Whether you're pitching an idea, scouting investments, hiring talent, or organizing events, our platform helps you run the full lifecycle from discovery to growth.</p>
        <p><a href="<?= BASE_URL ?>/about" class="btn">Learn more about the platform</a></p>
    </div>
</section>

<!-- include homepage animations script -->
<script src="<?= BASE_URL ?>/js/home-animations.js"></script>

<!-- Gestions Cards -->
<section class="gestions-section">
    <h2>Management Areas</h2>
    <div class="gestions-grid">
        <div class="gestion-card bg-pink">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1521295121783-8a321d551ad2?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <div class="card-content">
                <h3>Ideas Management</h3>
                <p>Capture, refine and prioritize ideas. Invite collaborators, collect feedback, and track the status of proposals as they move from concept to validated project.</p>
                <p class="muted">Features: idea submission forms, commenting, tagging, and status workflows.</p>
                <a href="<?= BASE_URL ?>/ideas" class="btn">Open Ideas</a>
            </div>
        </div>
        <div class="gestion-card bg-yellow">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1603575448360-7f0a7a9a6b7a?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <div class="card-content">
                <h3>Investments</h3>
                <p>Discover vetted projects and manage funding activities. Track commitments, monitor ROI, and coordinate investment rounds with contributors and founders.</p>
                <p class="muted">Features: investment dashboards, pledges, transaction history, and notifications.</p>
                <a href="<?= BASE_URL ?>/investments" class="btn">Open Investments</a>
            </div>
        </div>
        <div class="gestion-card bg-green">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1503424886301-1a0b6a7c9f0e?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <div class="card-content">
                <h3>Events Management</h3>
                <p>Plan and promote events, manage registrations, and engage attendees. Use event pages, ticketing, and attendee lists to run meetups, workshops, and conferences.</p>
                <p class="muted">Features: event pages, RSVPs, attendee export, and calendar integration.</p>
                <a href="<?= BASE_URL ?>/events" class="btn">Open Events</a>
            </div>
        </div>
        <div class="gestion-card bg-blue">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <div class="card-content">
                <h3>Jobs & Hiring</h3>
                <p>Post roles, manage applications, and communicate with candidates. Build talent pipelines and shortlist applicants with integrated CV review features.</p>
                <p class="muted">Features: job listings, application tracking, messaging, and candidate profiles.</p>
                <a href="<?= BASE_URL ?>/jobs" class="btn">Open Jobs</a>
            </div>
        </div>
        
        <!-- Contact card -->
        <div class="gestion-card bg-blue">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1526378727286-50a66f0f4b6a?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <div class="card-content">
                <h3>Contact Us</h3>
                <p>Need help or want to talk partnerships? Reach our support and partnerships team for assistance.</p>
                <p class="muted">Support: help@promangeai.com — typical response within 1 business day.</p>
                <a href="<?= BASE_URL ?>/contact" class="btn">Contact</a>
            </div>
        </div>

        <!-- Privacy card -->
        <div class="gestion-card bg-pink">
            <div class="card-preview" style="background-image: url('https://images.unsplash.com/photo-1508780709619-79562169bc64?q=80&w=1200&auto=format&fit=crop')" aria-hidden="true"></div>
            <div class="card-content">
                <h3>Privacy & Terms</h3>
                <p>Learn about how we protect your data and the terms that govern platform usage. We prioritize security and transparency.</p>
                <p class="muted">Features: data access, deletion requests, and clear terms of service.</p>
                <a href="<?= BASE_URL ?>/privacy" class="btn">Privacy</a>
            </div>
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
