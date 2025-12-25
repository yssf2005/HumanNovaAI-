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

<!-- Gestions Cards (show one at a time) -->
<section class="gestions-section gestions-single">
    <h2>Management Areas</h2>
    <div class="gestions-grid">
        <div class="gestion-card bg-pink">
            <figure class="card-figure" aria-hidden="true">
                <img src="https://source.unsplash.com/featured/?brainstorm,idea,innovation" alt="Ideas" loading="lazy">
            </figure>
            <div class="card-content">
                <h3>Ideas Management</h3>
                <p>Capture, refine and prioritize ideas. Invite collaborators, collect feedback, and track the status of proposals as they move from concept to validated project.</p>
                <p class="muted">Features: idea submission forms, commenting, tagging, and status workflows.</p>
                <button type="button" class="btn modal-trigger" data-modal="ideaModal">Submit Idea</button>
            </div>
        </div>
        <div class="gestion-card bg-yellow">
            <figure class="card-figure" aria-hidden="true">
                <img src="https://source.unsplash.com/featured/?investment,finance,startup" alt="Investments" loading="lazy">
            </figure>
            <div class="card-content">
                <h3>Investments</h3>
                <p>Discover vetted projects and manage funding activities. Track commitments, monitor ROI, and coordinate investment rounds with contributors and founders.</p>
                <p class="muted">Features: investment dashboards, pledges, transaction history, and notifications.</p>
                <a href="<?= BASE_URL ?>/investments" class="btn">Open Investments</a>
            </div>
        </div>
        <div class="gestion-card bg-green">
            <figure class="card-figure" aria-hidden="true">
                <img src="https://source.unsplash.com/featured/?conference,event,workshop" alt="Events" loading="lazy">
            </figure>
            <div class="card-content">
                <h3>Events Management</h3>
                <p>Plan and promote events, manage registrations, and engage attendees. Use event pages, ticketing, and attendee lists to run meetups, workshops, and conferences.</p>
                <p class="muted">Features: event pages, RSVPs, attendee export, and calendar integration.</p>
                <button type="button" class="btn modal-trigger" data-modal="eventModal">Create Event</button>
            </div>
        </div>
        <div class="gestion-card bg-blue">
            <figure class="card-figure" aria-hidden="true">
                <img src="https://source.unsplash.com/featured/?jobs,hiring,recruitment" alt="Jobs and hiring" loading="lazy">
            </figure>
            <div class="card-content">
                <h3>Jobs & Hiring</h3>
                <p>Post roles, manage applications, and communicate with candidates. Build talent pipelines and shortlist applicants with integrated CV review features.</p>
                <p class="muted">Features: job listings, application tracking, messaging, and candidate profiles.</p>
                <button type="button" class="btn modal-trigger" data-modal="jobModal">Create Job</button>
            </div>
        </div>
        
        <!-- Contact card -->
        <div class="gestion-card bg-blue">
            <figure class="card-figure" aria-hidden="true">
                <img src="https://source.unsplash.com/featured/?support,helpdesk,contact" alt="Contact Support" loading="lazy">
            </figure>
            <div class="card-content">
                <h3>Contact Us</h3>
                <p>Need help or want to talk partnerships? Reach our support and partnerships team for assistance.</p>
                <p class="muted">Support: help@promangeai.com — typical response within 1 business day.</p>
                <a href="<?= BASE_URL ?>/contact" class="btn">Contact</a>
            </div>
        </div>

        <!-- Privacy card -->
        <div class="gestion-card bg-pink">
            <figure class="card-figure" aria-hidden="true">
                <img src="https://source.unsplash.com/featured/?privacy,security,data" alt="Privacy and security" loading="lazy">
            </figure>
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

    <!-- Modals for quick create -->
    <div class="modal-backdrop" id="modalBackdrop" aria-hidden="true"></div>

    <!-- Idea modal -->
    <div class="modal large" id="ideaModal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-inner">
            <button class="close-btn" data-close>&times;</button>
            <h3>Submit an Idea</h3>
            <form method="post" action="<?= BASE_URL ?>/ideas/create">
                <label>Title<br><input name="title" required></label>
                <label>Description<br><textarea name="description" rows="6" required></textarea></label>
                <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Submit</button> <button type="button" class="btn" data-close>Cancel</button></div>
            </form>
        </div>
    </div>

    <!-- Job modal -->
    <div class="modal large" id="jobModal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-inner">
            <button class="close-btn" data-close>&times;</button>
            <h3>Create a Job</h3>
            <form method="post" action="<?= BASE_URL ?>/jobs/create">
                <label>Title<br><input name="title" required></label>
                <label>Location<br><input name="location"></label>
                <label>Description<br><textarea name="description" rows="6" required></textarea></label>
                <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Create</button> <button type="button" class="btn" data-close>Cancel</button></div>
            </form>
        </div>
    </div>

    <!-- Event modal -->
    <div class="modal large" id="eventModal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-inner">
            <button class="close-btn" data-close>&times;</button>
            <h3>Create an Event</h3>
            <form method="post" action="<?= BASE_URL ?>/events/create">
                <label>Title<br><input name="title" required></label>
                <label>Date<br><input type="date" name="date"></label>
                <label>Description<br><textarea name="description" rows="6" required></textarea></label>
                <div style="margin-top:12px;"><button class="btn btn-solid" type="submit">Create</button> <button type="button" class="btn" data-close>Cancel</button></div>
            </form>
        </div>
    </div>

<!-- About section (embedded) -->
<section id="about" class="about-section" style="padding:48px 0;margin-top:18px;">
    <div style="max-width:980px;margin:0 auto;padding:0 18px;display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;align-items:start;">
        <div class="about-card">
            <h3>About</h3>
            <p style="color:var(--muted);">PromanageAI is a collaborative platform that connects creators, investors, and talent to turn ideas into real products, projects, and organisations. We combine clear workflows, collaboration tools, and intelligent assistance so teams can execute with discipline and focus.</p>
        </div>

        <div class="about-card">
            <h3>Vision</h3>
            <p style="color:var(--muted);">We aim to be the place where ideas are discovered, funded, built, and launched — efficiently, transparently, and collaboratively. Our ambition is to remove friction from the path between concept and delivery so good work reaches the world faster and more reliably.</p>
        </div>

        <div class="about-card">
            <h3>What We Do</h3>
            <p style="color:var(--muted);">PromanageAI provides a unified environment where ideas are submitted, shaped, sourced, and advanced. Creators capture and refine concepts with structure. Investors discover vetted projects and support them early. Talent joins teams and contributes meaningfully. Teams plan, hire, and execute — all in one place.</p>
        </div>

        <div class="about-card">
            <h3>How We&rsquo;re Different</h3>
            <ul style="color:var(--muted);margin:0 0 0 18px;padding:0;">
                <li><strong>Idea-first:</strong> Focus on the evolution and structure of ideas, not volume or vanity metrics.</li>
                <li><strong>Collaboration over clutter:</strong> Tools reduce friction and highlight progress.</li>
                <li><strong>AI-assisted, not AI-driven:</strong> Features augment human judgement; they surface options, not answers.</li>
                <li><strong>Elegant simplicity:</strong> Powerful capabilities presented with clarity and restraint.</li>
            </ul>
        </div>

        <div class="about-card">
            <h3>Built for Builders</h3>
            <p style="color:var(--muted);">Entrepreneurs, investors, designers, engineers — anyone serious about turning ideas into outcomes. If you prioritise execution, clarity, and long-term impact, this platform is built for you.</p>
        </div>

        <div class="about-card">
            <h3>Philosophy</h3>
            <p style="color:var(--muted);font-weight:600;">Strong ideas deserve strong execution. Strong execution requires the right people and the right structure. PromanageAI brings them together.</p>
        </div>
        
        <div class="about-card">
            <h3>Contact</h3>
            <p style="color:var(--muted);">Need help or partnerships? Email our team at <a href="mailto:<?= htmlspecialchars(FOOTER_EMAIL) ?>"><?= htmlspecialchars(FOOTER_EMAIL) ?></a> or visit the <a href="<?= BASE_URL ?>/contact">contact page</a>.</p>
        </div>

        <div class="about-card">
            <h3>Privacy</h3>
            <p style="color:var(--muted);">We prioritise privacy and data protection. Read our practices on the <a href="<?= BASE_URL ?>/privacy">privacy page</a> to learn how we handle data and requests.</p>
        </div>
    </div>
</section>
