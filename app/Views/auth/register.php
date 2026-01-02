<?php
// Modal-style register page: split card with form on left and image on right
?>
<div class="auth-modal-wrapper">
	<div class="auth-modal-card" role="dialog" aria-labelledby="register-title">
		<div class="auth-modal-left">
			<h1 id="register-title" class="modal-welcome">WELCOME!</h1>
			<p class="modal-sub">Create your account below.</p>

			<?php if (isset($error)): ?>
				<div class="alert alert-error" style="margin: 12px 0;"><?= htmlspecialchars($error) ?></div>
			<?php endif; ?>

			<form id="register-form" action="<?= BASE_URL ?>/register" method="POST">
				<label for="prenom">Prénom</label>
				<input id="prenom" class="modal-input" type="text" name="prenom" value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>" required>

				<label for="nom">Nom</label>
				<input id="nom" class="modal-input" type="text" name="nom" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>" required>

				<label for="num_tel">Numéro de téléphone</label>
				<input id="num_tel" class="modal-input" type="tel" name="num_tel" value="<?= isset($_POST['num_tel']) ? htmlspecialchars($_POST['num_tel']) : '' ?>" placeholder="+33 6 12 34 56 78">

				<label for="email">Email</label>
				<input id="email" class="modal-input" type="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>

				<label for="password">Password</label>
				<input id="password" class="modal-input" type="password" name="password" required>

				<label for="password_confirm">Confirm Password</label>
				<input id="password_confirm" class="modal-input" type="password" name="password_confirm" required>

				<div class="modal-actions">
					<a class="link-muted open-login-modal" href="#">Already have an account? Login</a>
					<button type="submit" class="modal-btn">Sign up</button>
				</div>
			</form>
		</div>
		<div class="auth-modal-right" aria-hidden="true"></div>
	</div>
</div>

<style>
/* Modal-like split card matching the provided login modal appearance */
.auth-modal-wrapper { display:flex; align-items:center; justify-content:center; min-height:70vh; padding: 40px; }
.auth-modal-card { width:760px; max-width:96%; border-radius:12px; overflow:hidden; display:flex; box-shadow:0 25px 50px rgba(0,0,0,0.45); }
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
