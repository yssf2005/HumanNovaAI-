<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PILLAR</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/home-theme.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Flaticon UIcons removed (icons disabled) -->
    <style>
    body { font-family: 'Poppins', sans-serif; }

    /* Notifications UI */
    .notif-bell { position: relative; display: inline-block; margin-right: 12px; cursor: pointer; }
    .notif-bell .badge { position: absolute; top: -6px; right: -6px; background: #e74c3c; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; }
    .notif-dropdown { display: none; position: absolute; right: 0; top: 40px; width: 320px; background: white; border: 1px solid #ddd; box-shadow: 0 6px 18px rgba(0,0,0,0.08); border-radius: 6px; z-index: 9999; }
    .notif-dropdown.visible { display: block; }
    .notif-item { padding: 10px; border-bottom: 1px solid #f1f1f1; font-size: 14px; }
    .notif-item.unread { background: #f7fbff; }
    .notif-item small { color: #888; display:block; margin-top:6px; }
    .notif-empty { padding: 12px; color: #666; }

    .logo { font-weight: 700; color: #00a8ff; text-decoration: none; }
    .site-header{display:flex;align-items:center;gap:12px;padding:8px 12px;transition:box-shadow .18s ease,background .18s ease,backdrop-filter .18s ease}
    .site-header nav { display: flex; gap: 12px; align-items: center; flex:1 }
    .nav-links{margin-left:auto;display:flex;gap:12px;align-items:center;transform:translateX(-6px);transition:transform .14s ease}
    .nav-actions{display:flex;align-items:center;gap:10px;transform:translateX(-4px)}
    /* center the search visually without reordering DOM (slightly left-shifted for balance) */
    .header-search{position:absolute;left:49%;transform:translateX(-53%);width:420px;max-width:56%;transition:transform .14s ease,left .14s ease}
    .header-search input{width:100%;padding:8px 12px;border-radius:18px;border:1px solid rgba(0,0,0,0.08);outline:none}
    .nav-icon { font-size: 18px; padding:6px; border-radius:6px; color:inherit; text-decoration:none; }
    .nav-icon:hover { background: rgba(255,255,255,0.03); }
    </style>
</head>
<body>
    <?php
    $notifItems = [];
    $notifUnread = 0;
    if (isset($_SESSION['user_id'])) {
        try {
            $notifModel = new \App\Models\Notification();
            $notifUnread = $notifModel->getUnreadCount($_SESSION['user_id']);
            $notifItems = $notifModel->getForUser($_SESSION['user_id'], 8);
        } catch (Exception $e) {
            // ignore
        }
    }
    ?>

    <header class="site-header">
        <a href="<?= BASE_URL ?>/" class="logo">
            <img src="<?= BASE_URL ?>/images/pillar-logo.svg" alt="PILLAR" style="height:36px;display:inline-block;vertical-align:middle">
        </a>
        <nav>
            <form action="<?= BASE_URL ?>/search" method="GET" class="header-search" aria-label="Site search">
                <input type="text" name="q" placeholder="Search ideas..." />
            </form>
            <div class="nav-links">
                <a href="<?= BASE_URL ?>/">Home</a>
                <div class="nav-dropdown">
                    <a href="<?= BASE_URL ?>/ideas" class="drop-toggle">Ideas ▾</a>
                    <div class="dropdown-menu" aria-hidden="true">
                        <a href="<?= BASE_URL ?>/ideas">All Ideas</a>
                        <a href="<?= BASE_URL ?>/investments">Investments</a>
                    </div>
                </div>
                <div class="nav-dropdown">
                    <a href="<?= BASE_URL ?>/jobs" class="drop-toggle">Offers ▾</a>
                    <div class="dropdown-menu" aria-hidden="true">
                        <a href="<?= BASE_URL ?>/jobs">All Offers</a>
                        <a href="<?= BASE_URL ?>/jobs/my_offers">My Offers</a>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/events">Events</a>
                <a href="<?= BASE_URL ?>/feed">Blog</a>
            </div>
            

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="nav-actions" style="display:flex;align-items:center;gap:10px;position:relative;z-index:5;">
                    <div class="notif-bell" id="notif-bell" title="Notifications">
                        <span style="font-size:14px;line-height:1;vertical-align:middle">Notifications</span>
                        <?php if ($notifUnread > 0): ?>
                            <span class="badge" id="notif-count"><?= $notifUnread ?></span>
                        <?php else: ?>
                            <span class="badge" id="notif-count" style="display:none;">0</span>
                        <?php endif; ?>
                        <div class="notif-dropdown" id="notif-dropdown">
                            <?php if (empty($notifItems)): ?>
                                <div class="notif-empty">No notifications</div>
                            <?php else: ?>
                                <?php foreach ($notifItems as $n): ?>
                                    <div class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>">
                                        <div><?= htmlspecialchars($n['message']) ?></div>
                                        <small><?= htmlspecialchars($n['actor_name'] ?? '') ?> • <?= $n['created_at'] ?></small>
                                    </div>
                                <?php endforeach; ?>
                                <div style="text-align:center;padding:8px;"><a href="<?= BASE_URL ?>/notifications">View all</a></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="<?= BASE_URL ?>/logout">Logout</a>
                    <a href="<?= BASE_URL ?>/settings" class="nav-icon" title="Settings" style="margin-left:6px;">Settings</a>
                </div>
            <?php else: ?>
                <div style="margin-left:auto;display:flex;gap:10px;align-items:center;">
                    <a href="#" id="customLoginModalBtn">Login</a>
                    <a href="<?= BASE_URL ?>/register">Register</a>
                </div>
            <?php endif; ?>

            <!-- search moved to before Home -->
        </nav>
    </header>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </div>

    <?php
    // Include the shared footer partial from layouts for reuse
    include_once __DIR__ . '/footer.php';
    ?>

    <!-- Global modal backdrop for site-wide modals -->
    <div id="modalBackdrop" class="modal-backdrop" aria-hidden="true"></div>

        <!-- Custom Login Modal (from provided template) -->
        <div class="custom-modal" id="customLoginModal" aria-hidden="true">
            <div class="custom-modal-container">
                <div class="custom-modal-left">
                    <h1 class="custom-modal-title">Welcome!</h1>
                    <p class="custom-modal-desc">Connect to your account below.</p>
                    <form id="custom-login-form" action="<?= BASE_URL ?>/login" method="POST" autocomplete="on">
                        <div class="input-block">
                            <label for="custom-login-email" class="input-label">Email</label>
                            <input type="email" name="email" id="custom-login-email" placeholder="Email" required>
                        </div>
                        <div class="input-block">
                            <label for="custom-login-password" class="input-label">Password</label>
                            <input type="password" name="password" id="custom-login-password" placeholder="Password" required>
                        </div>
                        <div class="custom-modal-buttons">
                            <a href="<?= BASE_URL ?>/forgot">Forgot your password?</a>
                            <button type="submit" class="input-button">Login</button>
                        </div>
                    </form>
                    <p class="sign-up">Don't have an account? <a href="<?= BASE_URL ?>/register">Sign up now</a></p>
                </div>
                <div class="custom-modal-right">
                    <img src="https://images.unsplash.com/photo-1512486130939-2c4f79935e4f?auto=format&fit=crop&w=1000&q=80" alt="">
                </div>
                <button class="icon-button custom-close-button" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M 25 3 C 12.86158 3 3 12.86158 3 25 C 3 37.13842 12.86158 47 25 47 C 37.13842 47 47 37.13842 47 25 C 47 12.86158 37.13842 3 25 3 z M 25 5 C 36.05754 5 45 13.94246 45 25 C 45 36.05754 36.05754 45 25 45 C 13.94246 45 5 36.05754 5 25 C 5 13.94246 13.94246 5 25 5 z M 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.980469 15.990234 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 z"></path></svg>
                </button>
            </div>
            <button class="custom-modal-button" id="customLoginModalOpenBtn">Click here to login</button>
        </div>

    <!-- Chatbot Widget -->
    <div id="chatbot-widget">
        <div id="chatbot-icon">Chat</div>
        <div id="chatbot-window">
             <div id="chatbot-header">
                 <span>🤖 Assistant</span>
                 <span id="close-chat" style="cursor:pointer;">&times;</span>
             </div>
             <div id="chatbot-messages"></div>
             <div id="chatbot-input">
                 <input type="text" id="chat-msg" placeholder="Type a message...">
                 <button onclick="sendMessage()" class="btn btn-sm">Send</button>
             </div>
         </div>
    </div>

    <!-- Notification System -->
    <script>
    function showNotification(type, title, message) {
        const existing = document.querySelector('.notification-popup');
        if (existing) existing.remove();

        const notification = document.createElement('div');
        notification.className = `notification-popup ${type}`;

        const icons = { success: '✅', error: '❌', info: 'ℹ️' };

        notification.innerHTML = `\
            <div class="notification-icon">${icons[type] || icons.info}</div>\
            <div class="notification-content">\
                <h4>${title}</h4>\
                <p>${message}</p>\
            </div>\
            <button class="notification-close" onclick="this.parentElement.remove()">×</button>`;

        document.body.appendChild(notification);
        setTimeout(() => { if (notification.parentElement) notification.remove(); }, 3000);
    }

    // Notifications bell behaviour
    (function(){
        const bell = document.getElementById('notif-bell');
        const dropdown = document.getElementById('notif-dropdown');
        if (bell && dropdown) {
            bell.addEventListener('click', function(e){
                e.stopPropagation();
                dropdown.classList.toggle('visible');
                if (dropdown.classList.contains('visible')) {
                    fetch('<?= BASE_URL ?>/scripts/mark_notifications_read.php', { method: 'POST', credentials: 'same-origin' })
                        .then(r => r.json()).then(data => {
                            if (data.success) {
                                const badge = document.getElementById('notif-count');
                                if (badge) badge.style.display = 'none';
                                document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
                            }
                        }).catch(()=>{});
                }
            });
            document.addEventListener('click', function(){ dropdown.classList.remove('visible'); });
        }
    })();

    // Show PHP flash notification if present
    <?php if (isset($_SESSION['notification'])): 
        $n = $_SESSION['notification'];
        $type = $n['type'] ?? 'info';
        $title = $n['title'] ?? 'Notification';
        $message = $n['message'] ?? '';
    ?>
        showNotification(<?= json_encode($type) ?>, <?= json_encode($title) ?>, <?= json_encode($message) ?>);
    <?php unset($_SESSION['notification']); endif; ?>
    </script>
    <script>
    // Smooth scroll for in-page anchors (e.g., Learn more -> #site-footer)
    (function(){
        document.addEventListener('click', function(e){
            const a = e.target.closest && e.target.closest('a');
            if (!a) return;
            const href = a.getAttribute('href') || '';
            if (href.startsWith('#')) {
                const id = href.slice(1);
                const el = document.getElementById(id);
                if (el) {
                    e.preventDefault();
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    history.replaceState && history.replaceState(null, '', href);
                }
            }
        });
    })();
    </script>
    <script>
    // Dropdown toggle (click to open for touch devices)
    (function(){
        document.querySelectorAll('.drop-toggle').forEach(function(toggle){
            toggle.addEventListener('click', function(e){
                // on small screens, toggle the menu
                const menu = toggle.nextElementSibling;
                if (!menu) return;
                menu.classList.toggle('open');
                e.preventDefault();
            });
        });
        document.addEventListener('click', function(e){
            if (!e.target.closest('.nav-dropdown')) {
                document.querySelectorAll('.dropdown-menu.open').forEach(m=>m.classList.remove('open'));
            }
        });
    })();
    </script>
    <script src="<?= BASE_URL ?>/js/custom-login-modal.js"></script>
    <script>
    (function(){
        var header = document.querySelector('.site-header');
        if (!header) return;
        function onScroll(){
            if (window.pageYOffset > 8) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
        }
        window.addEventListener('scroll', onScroll, {passive:true});
        onScroll();
    })();
    </script>
    <script src="<?= BASE_URL ?>/js/chatbot.js"></script>
    <script src="<?= BASE_URL ?>/js/home-animations.js"></script>
</body>
</html>
