<div class="auth-container">
    <p style="text-align: center; color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px;">Focus on technology innovation</p>
    
    <div class="auth-card">
        <h2 class="auth-title">Bienvenue sur votre plateforme de gestion intelligente</h2>
        
        <div class="auth-tabs">
            <button class="auth-tab active" onclick="switchAuthTab('login')">Connexion</button>
            <button class="auth-tab" onclick="switchAuthTab('register')">Inscription</button>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-error" style="margin: 15px 0;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form id="login-form" action="<?= BASE_URL ?>/login" method="POST" class="auth-form active">
            <div class="auth-field">
                <label>EMAIL</label>
                <input type="email" name="email" placeholder="helloworld@gmail.com" required>
            </div>
            <div class="auth-field">
                <label>MOT DE PASSE</label>
                <input type="password" name="password" placeholder="••••••••••••" required>
            </div>
            <div style="text-align: right; margin-bottom: 20px;">
                <a href="#" style="color: #7d84ff; font-size: 0.9rem; text-decoration: none;">Mot de passe oublié ?</a>
            </div>
            <button type="submit" class="auth-submit">SE CONNECTER</button>
        </form>

        <!-- Register Form -->
        <form id="register-form" action="<?= BASE_URL ?>/register" method="POST" class="auth-form">
            <div class="auth-field">
                <label>NOM COMPLET</label>
                <input type="text" name="name" placeholder="John Doe" required>
            </div>
            <div class="auth-field">
                <label>EMAIL</label>
                <input type="email" name="email" placeholder="your@email.com" required>
            </div>
            <div class="auth-field">
                <label>MOT DE PASSE</label>
                <input type="password" name="password" placeholder="Create a strong password" required>
            </div>
            <button type="submit" class="auth-submit">S'INSCRIRE</button>
        </form>
    </div>
</div>

<script>
function switchAuthTab(type) {
    const tabs = document.querySelectorAll('.auth-tab');
    const forms = document.querySelectorAll('.auth-form');
    
    tabs.forEach(t => t.classList.remove('active'));
    forms.forEach(f => f.classList.remove('active'));
    
    if (type === 'login') {
        tabs[0].classList.add('active');
        forms[0].classList.add('active');
    } else {
        tabs[1].classList.add('active');
        forms[1].classList.add('active');
    }
}

// Check URL hash to switch tab on load
window.addEventListener('load', () => {
    if (window.location.hash === '#register') {
        switchAuthTab('register');
    }
});
</script>

<style>
.auth-container {
    max-width: 450px;
    margin: 80px auto;
}

.auth-card {
    background: #2a2d4e;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}

.auth-title {
    color: white;
    text-align: center;
    font-size: 1.5rem;
    line-height: 1.4;
    margin-bottom: 40px;
    font-weight: 500;
}

.auth-tabs {
    display: flex;
    border-bottom: 2px solid #3d426a;
    margin-bottom: 30px;
}

.auth-tab {
    flex: 1;
    background: none;
    border: none;
    color: #888;
    padding: 15px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s;
    position: relative;
    border-bottom: 3px solid transparent;
}

.auth-tab.active {
    color: white;
}

.auth-tab.active::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 20%;
    right: 20%;
    height: 3px;
    background: linear-gradient(to right, #7d84ff, #4cc9f0);
    border-radius: 3px;
}

.auth-form {
    display: none;
}

.auth-form.active {
    display: block;
}

.auth-field {
    margin-bottom: 25px;
}

.auth-field label {
    display: block;
    color: #bbb;
    font-size: 0.8rem;
    margin-bottom: 10px;
    font-weight: 600;
    letter-spacing: 1px;
}

.auth-field input {
    width: 100%;
    padding: 15px;
    background: #e9efff;
    border: none;
    border-radius: 10px;
    color: #333;
    font-size: 1rem;
}

.auth-submit {
    width: 100%;
    padding: 15px;
    background: linear-gradient(to right, #7d84ff, #5b64e8);
    border: none;
    border-radius: 30px;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    letter-spacing: 1px;
    transition: transform 0.2s;
}

.auth-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(125, 132, 255, 0.4);
}
</style>
