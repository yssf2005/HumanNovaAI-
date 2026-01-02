<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PILLAR</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/home-theme.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* modal-section visibility helper (shared with main layout) */
        .modal-section { display: none; }
        .modal-section.visible { display: block; }
        .modal-cta { display:flex; gap:12px; margin:12px 0 18px }
        .modal-cta a { padding:10px 18px; border-radius:8px; text-decoration:none; font-weight:700 }
        .modal-cta .cta-login { background:linear-gradient(to right,#5b64e8,#3f4fcf); color:#fff }
        .modal-cta .cta-register { background:#fff; color:#6b6b67; border:1px solid rgba(0,0,0,0.06) }
    </style>
</head>
<body>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?= $content ?>

    <!-- Keep notifications & chatbot available for auth pages but hide the main navbar -->
    <script>
    function showNotification(type, title, message) {
        const existing = document.querySelector('.notification-popup');
        if (existing) existing.remove();
        const notification = document.createElement('div');
        notification.className = `notification-popup ${type}`;
        const icons = { success: '✅', error: '❌', info: 'ℹ️' };
        notification.innerHTML = `
            <div class="notification-icon">${icons[type] || icons.info}</div>
            <div class="notification-content">
                <h4>${title}</h4>
                <p>${message}</p>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">×</button>
        `;
        document.body.appendChild(notification);
        setTimeout(() => { if (notification.parentElement) notification.remove(); }, 3000);
    }

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
    <script src="<?= BASE_URL ?>/js/custom-login-modal.js"></script>
</body>
</html>
