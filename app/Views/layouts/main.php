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
</head>
<body>
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
                <a href="<?= BASE_URL ?>/logout">Logout</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/login">Login</a>
                <a href="<?= BASE_URL ?>/register">Register</a>
            <?php endif; ?>
            <form action="<?= BASE_URL ?>/search" method="GET">
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
        // Remove existing notifications
        const existing = document.querySelector('.notification-popup');
        if (existing) existing.remove();
        
        // Create notification
        const notification = document.createElement('div');
        notification.className = `notification-popup ${type}`;
        
        const icons = {
            success: '✅',
            error: '❌',
            info: 'ℹ️'
        };
        
        notification.innerHTML = `
            <div class="notification-icon">${icons[type] || icons.info}</div>
            <div class="notification-content">
                <h4>${title}</h4>
                <p>${message}</p>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">×</button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 3000);
    }
    
    // Check for success/error messages from PHP
    <?php if (isset($_SESSION['notification'])): ?>
        showNotification(
            '<?= $_SESSION['notification']['type'] ?? 'info' ?>',
            '<?= $_SESSION['notification']['title'] ?? 'Notification' ?>',
            '<?= addslashes($_SESSION['notification']['message'] ?? '') ?>'
        );
        <?php unset($_SESSION['notification']); ?>
    <?php endif; ?>
    </script>
    <script src="<?= BASE_URL ?>/js/chatbot.js"></script>
</body>
</html>
