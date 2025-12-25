<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Réinitialiser le mot de passe</h2>

        <?php if (isset($error)): ?>
            <div class="alert" style="margin: 15px 0; color: #fff; background: #e54d42; padding: 12px; border-radius: 8px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!isset($error) || isset($selector)): ?>
        <form action="<?= BASE_URL ?>/reset" method="POST" style="margin-top:20px;">
            <input type="hidden" name="selector" value="<?= isset($selector) ? htmlspecialchars($selector) : '' ?>">
            <input type="hidden" name="validator" value="<?= isset($validator) ? htmlspecialchars($validator) : '' ?>">

            <div class="auth-field">
                <label>NOUVEAU MOT DE PASSE</label>
                <input type="password" name="password" autocomplete="new-password" placeholder="Create a strong password" required>
            </div>
            <div class="auth-field">
                <label>CONFIRMER LE MOT DE PASSE</label>
                <input type="password" name="password_confirm" autocomplete="new-password" placeholder="Confirm password" required>
            </div>
            <button type="submit" class="auth-submit">Réinitialiser le mot de passe</button>
            <div style="margin-top:12px; text-align:center;">
                <a href="<?= BASE_URL ?>/login" style="color:#7d84ff; text-decoration:none;">Retour à la connexion</a>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<!-- auth styles moved to global stylesheet for consistency -->
