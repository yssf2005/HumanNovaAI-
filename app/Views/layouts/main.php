<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovation Platform</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/home-theme.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
    <style>
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
    header nav { display: flex; gap: 12px; align-items: center; }
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

    <header>
        <a href="<?= BASE_URL ?>/" class="logo">🚀 Innovate</a>
        <nav>
            <a href="<?= BASE_URL ?>/">Home</a>
            <a href="<?= BASE_URL ?>/ideas">💡 Ideas</a>
            <a href="<?= BASE_URL ?>/investments">💰 Investments</a>
            <a href="<?= BASE_URL ?>/jobs">💼 Offers</a>
            <a href="<?= BASE_URL ?>/events">📅 Events</a>
            <a href="<?= BASE_URL ?>/feed">📸 Blog</a>
            

            <?php if (isset($_SESSION['user_id'])): ?>
                <div style="margin-left:auto;display:flex;align-items:center;gap:10px;position:relative;">
                    <div class="notif-bell" id="notif-bell" title="Notifications">
                        <span style="font-size:20px;">🔔</span>
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
                    <a href="<?= BASE_URL ?>/settings" class="nav-icon" title="Settings" style="margin-left:6px;">⚙️</a>
                </div>
            <?php else: ?>
                <div style="margin-left:auto;display:flex;gap:10px;align-items:center;">
                    <a href="<?= BASE_URL ?>/login">Login</a>
                    <a href="<?= BASE_URL ?>/register">Register</a>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/search" method="GET" style="margin-left:12px;">
                <input type="text" name="q" placeholder="🔍 Search...">
            </form>
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

    <!-- Chatbot Widget -->
    <div id="chatbot-widget">
        <div id="chatbot-icon">💬</div>
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
    <script src="<?= BASE_URL ?>/js/chatbot.js"></script>
</body>
</html>
