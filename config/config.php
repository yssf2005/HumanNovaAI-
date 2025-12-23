<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'innovation_platform');
define('BASE_URL', 'http://localhost/projet2/public');
// Mail configuration (updated to use your Gmail SMTP settings)
define('MAIL_DRIVER', 'smtp'); // 'mail' or 'smtp' or 'phpmailer' (if PHPMailer installed)
define('MAIL_FROM_ADDRESS', 'espsytunisia@gmail.com');
define('MAIL_FROM_NAME', 'PRO MANGEAI');
define('MAIL_SMTP_HOST', 'smtp.gmail.com');
define('MAIL_SMTP_PORT', 587);
define('MAIL_SMTP_USER', 'espsytunisia@gmail.com');
define('MAIL_SMTP_PASS', 'isae zjyl bkjm aiyv');
define('MAIL_SMTP_SECURE', 'tls'); // 'tls' or 'ssl' or ''
// If a .env file exists, load simple KEY=VALUE pairs into environment for local development (non-recursive, no interpolation)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
	$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		$line = trim($line);
		if ($line === '' || strpos($line, '#') === 0) continue;
		if (strpos($line, '=') === false) continue;
		list($k, $v) = explode('=', $line, 2);
		$k = trim($k);
		$v = trim($v);
		// remove surrounding quotes if present
		if ((substr($v,0,1) === '"' && substr($v,-1) === '"') || (substr($v,0,1) === "'" && substr($v,-1) === "'")) {
			$v = substr($v,1,-1);
		}
		// only set if not already in environment
		if (getenv($k) === false) {
			putenv("$k=$v");
			$_ENV[$k] = $v;
			$_SERVER[$k] = $v;
		}
	}
}

// reCAPTCHA settings (prefer environment variables)
define('RECAPTCHA_SITE_KEY', getenv('RECAPTCHA_SITE_KEY') !== false ? getenv('RECAPTCHA_SITE_KEY') : 'your_site_key_here');
define('RECAPTCHA_SECRET', getenv('RECAPTCHA_SECRET') !== false ? getenv('RECAPTCHA_SECRET') : 'your_secret_here');
define('RECAPTCHA_ENFORCE', getenv('RECAPTCHA_ENFORCE') !== false ? (bool)filter_var(getenv('RECAPTCHA_ENFORCE'), FILTER_VALIDATE_BOOLEAN) : false); // set true in production
define('RECAPTCHA_MIN_SCORE', getenv('RECAPTCHA_MIN_SCORE') !== false ? (float)getenv('RECAPTCHA_MIN_SCORE') : 0.5);

// Footer / site info (can be overridden via environment variables or .env)
define('FOOTER_TITLE', getenv('FOOTER_TITLE') !== false ? getenv('FOOTER_TITLE') : 'PRO MANGEAI');
define('FOOTER_DESCRIPTION', getenv('FOOTER_DESCRIPTION') !== false ? getenv('FOOTER_DESCRIPTION') : 'Connecting ideas, talent and capital — a place to launch and grow projects.');
define('FOOTER_EMAIL', getenv('FOOTER_EMAIL') !== false ? getenv('FOOTER_EMAIL') : 'support@promangeai.com');
define('FOOTER_PHONE', getenv('FOOTER_PHONE') !== false ? getenv('FOOTER_PHONE') : '+216 00 000 000');
// JSON array of {label, href} for footer links; href may be absolute or start with '/'
define('FOOTER_LINKS_JSON', getenv('FOOTER_LINKS_JSON') !== false ? getenv('FOOTER_LINKS_JSON') : '[{"label":"Home","href":"/"},{"label":"Contact","href":"/contact"},{"label":"Privacy","href":"/privacy"}]');

