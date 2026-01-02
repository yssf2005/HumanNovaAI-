<?php // Make forgot page match modal-style layout ?>
<div class="auth-modal-wrapper">
    <div class="auth-modal-card" role="dialog" aria-labelledby="forgot-title">
        <div class="auth-modal-left">
            <h1 id="forgot-title" class="modal-welcome">RÉINITIALISATION DU MOT DE PASSE</h1>

            <?php if (isset($message)): ?>
                <div class="alert" style="margin: 12px 0; color: #222; background: #e9f6ff; padding: 12px; border-radius: 8px;"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/forgot" method="POST">
                <label for="email">EMAIL</label>
                <input id="email" class="modal-input" type="email" name="email" autocomplete="email" placeholder="you@example.com" required>

                <div style="margin-top:18px; display:flex; justify-content:center;">
                    <button type="submit" class="modal-btn">Envoyer le lien de réinitialisation</button>
                </div>

                <div style="margin-top:16px; text-align:center;">
                    <a href="#" class="open-login-modal" style="color:#7d84ff; text-decoration:none;">Retour à la connexion</a>
                </div>
            </form>
        </div>
        <div class="auth-modal-right" aria-hidden="true"></div>
    </div>
</div>
