<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'innovation_platform');
define('BASE_URL', 'http://localhost/projet2/public');

// Mail configuration - do NOT commit real credentials to public repos
define('MAIL_DRIVER', 'smtp');
define('MAIL_SMTP_HOST', 'smtp.gmail.com');
define('MAIL_SMTP_PORT', 587);
define('MAIL_SMTP_USER', 'espsytunisia@gmail.com');
define('MAIL_SMTP_PASS', 'isae zjyl bkjm aiyv');
define('MAIL_SMTP_SECURE', 'tls');
define('MAIL_FROM_ADDRESS', MAIL_SMTP_USER);
define('MAIL_FROM_NAME', 'PRO MANGEAI');

// For Gmail, prefer app passwords or OAuth2; avoid plain account passwords when possible.

// Token pepper used to harden stored token hashes (keep secret, do NOT commit changes)
// Preferred: set via environment variable `TOKEN_PEPPER` on the server.
if (getenv('TOKEN_PEPPER') && getenv('TOKEN_PEPPER') !== false) {
	define('TOKEN_PEPPER', getenv('TOKEN_PEPPER'));
} else {
	define('TOKEN_PEPPER', 'replace_this_with_a_long_random_secret_and_store_safely');
}

// Google reCAPTCHA - set these in your environment or replace with real keys on the server.
// To enable, put your site key in RECAPTCHA_SITE_KEY and secret in RECAPTCHA_SECRET.
if (getenv('RECAPTCHA_SITE_KEY') && getenv('RECAPTCHA_SITE_KEY') !== false) {
    define('RECAPTCHA_SITE_KEY', getenv('RECAPTCHA_SITE_KEY'));
} else {
    // Fallback to configured site key
    define('RECAPTCHA_SITE_KEY', '6LfpfDMsAAAAAKyGv0OMQXIo9x0GRTtNS11zO6Tp');
}

if (getenv('RECAPTCHA_SECRET') && getenv('RECAPTCHA_SECRET') !== false) {
    define('RECAPTCHA_SECRET', getenv('RECAPTCHA_SECRET'));
} else {
    // Fallback to configured secret
    define('RECAPTCHA_SECRET', '6LfpfDMsAAAAAF6BhuODBOX79jKxtbXvi2vkZGlk');
}

// Optionally enforce reCAPTCHA even on localhost (set to '1' or 'true' in env to enforce)
if (getenv('RECAPTCHA_ENFORCE') && getenv('RECAPTCHA_ENFORCE') !== false) {
    $val = strtolower(trim((string)getenv('RECAPTCHA_ENFORCE')));
    define('RECAPTCHA_ENFORCE', in_array($val, ['1', 'true', 'yes'], true));
} else {
    define('RECAPTCHA_ENFORCE', false);
}

// Minimum acceptable score for reCAPTCHA v3 (0.0 - 1.0). Increase to be stricter.
if (getenv('RECAPTCHA_MIN_SCORE') && getenv('RECAPTCHA_MIN_SCORE') !== false) {
    $score = (float) getenv('RECAPTCHA_MIN_SCORE');
    define('RECAPTCHA_MIN_SCORE', $score);
} else {
    define('RECAPTCHA_MIN_SCORE', 0.5);
}
