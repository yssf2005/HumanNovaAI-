<div class="auth-container">
        <div class="auth-card">
                <h2 class="auth-title">Bienvenue sur votre plateforme de gestion intelligente</h2>

                <div class="auth-tabs">
                        <button id="tab-login" class="auth-tab active" onclick="switchAuthTab('login')">Connexion</button>
                        <button id="tab-register" class="auth-tab" onclick="goRegister()">Inscription</button>
                </div>

                <?php if (isset($error)): ?>
                        <div class="alert alert-error" style="margin: 15px 0;"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form id="login-form" action="<?= BASE_URL ?>/login" method="POST">
                        <div class="auth-field">
                                <label>EMAIL</label>
                                <input type="email" name="email" autocomplete="email" placeholder="helloworld@gmail.com" required>
                        </div>
                        <div class="auth-field">
                                <label>MOT DE PASSE</label>
                                <input type="password" name="password" autocomplete="current-password" placeholder="••••••••••••" required>
                        </div>
                        <div style="text-align: right; margin-bottom: 20px;">
                                <a href="<?= BASE_URL ?>/forgot" style="color: #7d84ff; font-size: 0.9rem; text-decoration: none;">Mot de passe oublié ?</a>
                        </div>
                        <button type="submit" class="auth-submit">SE CONNECTER</button>
                </form>
        </div>
</div>

<script>
function switchAuthTab(type) {
        // purely visual here; keep the login tab active by default
        const loginTab = document.getElementById('tab-login');
        const registerTab = document.getElementById('tab-register');
        if (type === 'login') {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
        }
}

function goRegister() {
        window.location.href = "<?= BASE_URL ?>/register";
}

// Ensure login tab is active on load
window.addEventListener('load', () => switchAuthTab('login'));
</script>

<style>
.auth-container { max-width: 450px; margin: 80px auto; }
.auth-card { background: #2a2d4e; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); color:#fff }
.auth-title { text-align:center; margin-bottom:12px; font-size:1.2rem }
.auth-tabs { display:flex; border-bottom:2px solid #3d426a; margin:16px 0 22px }
.auth-tab { flex:1; background:none; border:none; color:#888; padding:12px; cursor:pointer; font-size:1rem; font-weight:500; position:relative; border-bottom:3px solid transparent }
.auth-tab.active { color:#fff }
.auth-tab.active::after { content:''; position:absolute; bottom:-3px; left:20%; right:20%; height:3px; background:linear-gradient(to right,#7d84ff,#4cc9f0); border-radius:3px }
.auth-field { margin-bottom:20px }
.auth-field label { display:block; color:#bbb; margin-bottom:8px; font-weight:600 }
.auth-field input { width:100%; padding:12px; border-radius:8px; border:none; font-size:1rem }
.auth-submit { width:100%; padding:12px; border-radius:8px; background:linear-gradient(to right,#7d84ff,#5b64e8); border:none; color:#fff; font-weight:700 }
</style>
