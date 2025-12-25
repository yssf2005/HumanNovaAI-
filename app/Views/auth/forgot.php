<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Réinitialisation du mot de passe</h2>

        <?php if (isset($message)): ?>
            <div class="alert" style="margin: 15px 0; color: #222; background: #e9f6ff; padding: 12px; border-radius: 8px;"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/forgot" method="POST" style="margin-top:20px;">
            <div class="auth-field">
                <label>EMAIL</label>
                <input type="email" name="email" autocomplete="email" placeholder="you@example.com" required>
            </div>
            <button type="submit" class="auth-submit">Envoyer le lien de réinitialisation</button>
            <div style="margin-top:12px; text-align:center;">
                <a href="<?= BASE_URL ?>/login" style="color:#7d84ff; text-decoration:none;">Retour à la connexion</a>
            </div>
        </form>
    </div>
</div>

<!-- auth styles moved to global stylesheet for consistency -->
