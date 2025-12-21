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
