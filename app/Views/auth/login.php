<?php
// Use the same split modal layout as register for consistent UX
?>
<div class="auth-modal-wrapper">
    <div class="auth-modal-card" role="dialog" aria-labelledby="login-title">
        <div class="auth-modal-left">
            <h1 id="login-title" class="modal-welcome">WELCOME!</h1>
            <p class="modal-sub">Connect to your account below.</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-error" style="margin: 12px 0;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form id="login-form" action="<?= BASE_URL ?>/login" method="POST">
                <label for="email">Email</label>
                <input id="email" class="modal-input" type="email" name="email" required>

                <label for="password">Password</label>
                <input id="password" class="modal-input" type="password" name="password" required>

                <div class="modal-actions">
                    <a class="link-muted" id="modal-forgot" href="<?= BASE_URL ?>/forgot">Mot de passe oublié ?</a>
                    <button type="submit" class="modal-btn">Se connecter</button>
                </div>
            </form>

            <p style="margin-top:12px">Don't have an account? <a href="#" class="open-register-modal">Sign up now</a></p>
        </div>
        <div class="auth-modal-right" aria-hidden="true"></div>
    </div>
</div>

<style>
/* reuse register modal styles but slightly narrower */
.auth-modal-wrapper { display:flex; align-items:center; justify-content:center; min-height:70vh; padding: 40px; }
.auth-modal-card { width:720px; max-width:96%; border-radius:12px; overflow:hidden; display:flex; box-shadow:0 25px 50px rgba(0,0,0,0.45); }
.auth-modal-left { background:#fff; padding:34px; width:52%; color:#2b2b2b; }
.auth-modal-right { width:48%; background-image: url('https://images.unsplash.com/photo-1512486130939-2c4f79935e4f?auto=format&fit=crop&w=1000&q=80'); background-size:cover; background-position:center; }
.modal-welcome { margin:0 0 6px; font-size:28px; letter-spacing:1px; font-weight:700 }
.modal-sub { margin:0 0 18px; color:#666; }
.modal-input { width:100%; padding:12px 14px; margin:8px 0 14px; border-radius:10px; border: none; background:#eef6ff; font-size:15px }
.modal-actions { display:flex; align-items:center; justify-content:space-between; margin-top:8px }
.modal-btn { background:#ffffff; border:none; padding:10px 26px; border-radius:30px; box-shadow:0 6px 18px rgba(0,0,0,0.08); cursor:pointer; font-weight:600; color:#6b4b3b }
.link-muted { color:#8b6f66; text-decoration:none; font-size:0.95rem }
@media (max-width:720px){ .auth-modal-card{flex-direction:column} .auth-modal-right{height:180px;width:100%} .auth-modal-left{width:100%} }
</style>
