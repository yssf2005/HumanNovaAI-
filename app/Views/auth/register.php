<div class="auth-container">
	<div class="auth-card">
		<h2 class="auth-title">Bienvenue sur votre plateforme de gestion intelligente</h2>

		<div class="auth-tabs">
			<button id="tab-login" class="auth-tab" onclick="goLogin()">Connexion</button>
			<button id="tab-register" class="auth-tab active">Inscription</button>
		</div>

		<?php if (isset($error)): ?>
			<div class="alert alert-error" style="margin: 15px 0;"><?= htmlspecialchars($error) ?></div>
		<?php endif; ?>

		<?php
			// Detect localhost by HOST header or BASE_URL
			$host = $_SERVER['HTTP_HOST'] ?? '';
			$isLocal = false;
			if ($host) {
				$lh = strtolower($host);
				if (strpos($lh, 'localhost') !== false || $lh === '127.0.0.1') {
					$isLocal = true;
				}
			} else {
				$isLocal = (stripos(BASE_URL, 'localhost') !== false || stripos(BASE_URL, '127.0.0.1') !== false);
			}

			$missingRecaptcha = (!defined('RECAPTCHA_SITE_KEY') || !RECAPTCHA_SITE_KEY);
			// Show the notice when keys are missing AND (enforce is true OR not running on localhost)
			if ($missingRecaptcha && (defined('RECAPTCHA_ENFORCE') && RECAPTCHA_ENFORCE || !$isLocal)):
		?>
			<div style="margin:12px 0; background:#fff3cd; color:#856404; padding:10px; border-radius:6px; font-size:0.95rem;">
				reCAPTCHA n'est pas configuré — pour activer, définissez <strong>RECAPTCHA_SITE_KEY</strong> et <strong>RECAPTCHA_SECRET</strong> dans <em>config/config.php</em> ou via vos variables d'environnement. Sur localhost la vérification CAPTCHA est ignorée par défaut.
			</div>
		<?php endif; ?>

		<form id="register-form" action="<?= BASE_URL ?>/register" method="POST" class="auth-form active">
			<div class="auth-field">
				<label>Prénom</label>
				<input type="text" name="prenom" value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>" placeholder="Prénom" required>
			</div>
			<div class="auth-field">
				<label>Nom</label>
				<input type="text" name="nom" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>" placeholder="Nom" required>
			</div>
			<div class="auth-field">
				<label>Numéro de téléphone</label>
				<input type="tel" name="num_tel" value="<?= isset($_POST['num_tel']) ? htmlspecialchars($_POST['num_tel']) : '' ?>" placeholder="+33 6 12 34 56 78">
			</div>
			<div class="auth-field">
				<label>EMAIL</label>
				<input type="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" placeholder="you@email.com" required>
			</div>
			<div class="auth-field">
				<label>MOT DE PASSE</label>
				<input type="password" name="password" placeholder="Create a strong password" required>
			</div>
			<div class="auth-field">
				<label>CONFIRMER LE MOT DE PASSE</label>
				<input type="password" name="password_confirm" placeholder="Confirm password" required>
			</div>
			<?php if (defined('RECAPTCHA_SITE_KEY') && RECAPTCHA_SITE_KEY): ?>
				<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="">
				<script src="https://www.google.com/recaptcha/api.js?render=<?= RECAPTCHA_SITE_KEY ?>" async defer></script>
				<script>
				// Execute reCAPTCHA v3 and set token before submitting
				function setRecaptchaToken() {
					if (typeof grecaptcha === 'undefined') return;
					grecaptcha.ready(function() {
						grecaptcha.execute('<?= RECAPTCHA_SITE_KEY ?>', {action: 'register'}).then(function(token) {
							var el = document.getElementById('g-recaptcha-response');
							if (el) el.value = token;
						});
					});
				}

				// Acquire token on load and before submit
				document.addEventListener('DOMContentLoaded', function(){
					setRecaptchaToken();
					var form = document.getElementById('register-form');
					if (form) {
						form.addEventListener('submit', function(e){
							// ensure token present; refresh synchronously isn't possible, so allow short delay
							var el = document.getElementById('g-recaptcha-response');
							if (el && !el.value) {
								e.preventDefault();
								setRecaptchaToken();
								setTimeout(function(){ form.submit(); }, 800);
							}
						});
					}
				});
				// Debug: log grecaptcha status and token periodically (remove in production)
				(function(){
					function logStatus(){
						var present = typeof grecaptcha !== 'undefined';
						var token = document.getElementById('g-recaptcha-response') ? document.getElementById('g-recaptcha-response').value : '';
						console.debug('[reCAPTCHA debug] grecaptcha present:', present, ' token length:', token ? token.length : 0, token ? token.substring(0,10) + '...' : '');
					}
					setTimeout(logStatus, 1000);
					setTimeout(logStatus, 3000);
					setTimeout(logStatus, 6000);
					var interval = setInterval(logStatus, 5000);
					// stop after 30s
					setTimeout(function(){ clearInterval(interval); }, 30000);
				})();
				</script>
			<?php endif; ?>
			<button type="submit" class="auth-submit">S'INSCRIRE</button>
		</form>
	</div>
</div>

<script>
function goLogin() {
	window.location.href = "<?= BASE_URL ?>/login";
}

// Ensure register tab appears active on load (visual only)
window.addEventListener('load', function(){
	const loginTab = document.getElementById('tab-login');
	const registerTab = document.getElementById('tab-register');
	if (loginTab) loginTab.classList.remove('active');
	if (registerTab) registerTab.classList.add('active');
});
</script>

<style>
.auth-container { max-width: 480px; margin: 60px auto; }
.auth-card { background: #2a2d4e; padding: 36px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.45); color: #fff }
.auth-title { text-align: center; margin-bottom: 12px; font-size: 1.2rem }
.auth-tabs { display:flex; border-bottom:2px solid #3d426a; margin:12px 0 20px }
.auth-tab { flex:1; background:none; border:none; color:#888; padding:12px; cursor:pointer; font-size:1rem; font-weight:500; position:relative; border-bottom:3px solid transparent }
.auth-tab.active { color:#fff }
.auth-tab.active::after { content:''; position:absolute; bottom:-3px; left:20%; right:20%; height:3px; background:linear-gradient(to right,#7d84ff,#4cc9f0); border-radius:3px }
.auth-field { margin-bottom:18px }
.auth-field label { display:block; color:#bbb; font-size:0.85rem; margin-bottom:8px; font-weight:600 }
.auth-field input { width:100%; padding:12px; border-radius:8px; border:none; font-size:1rem }
.auth-submit { width:100%; padding:12px; border-radius:8px; background:linear-gradient(to right,#7d84ff,#5b64e8); border:none; color:#fff; font-weight:700 }
</style>
