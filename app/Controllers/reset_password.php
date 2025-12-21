<?php
// GET: show form if token valid
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if (!class_exists('Database')) {
    class Database {
        private $pdo;
        public function getConnection() {
            if ($this->pdo instanceof PDO) {
                return $this->pdo;
            }
            // Default to a local SQLite DB; change DSN to your MySQL/MariaDB DSN if needed.
            $dsn = 'sqlite:' . __DIR__ . '/../data/app.db';
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        }
    }
}

if (!class_exists('User')) {
    class User {
        public $id;
        public $email;
        public static function findByEmail($email) {
            $db = (new Database())->getConnection();
            $stmt = $db->prepare('SELECT id, email FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) { return null; }
            $u = new self();
            $u->id = $row['id'];
            $u->email = $row['email'];
            return $u;
        }
    }
}

if (!function_exists('hashToken')) {
    function hashToken($token) {
        return hash('sha256', (string)$token);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // basic validation
    if (!$token || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid reset link.";
        exit;
    }
    // lookup user and token record
    $db = (new Database())->getConnection();
    $user = User::findByEmail($email);
    if (!$user) { echo "Invalid reset link."; exit; }

    $tokenHash = hashToken($token);
    $stmt = $db->prepare('SELECT * FROM password_resets WHERE user_id = ? AND token_hash = ? AND used = 0 AND expires_at > NOW() LIMIT 1');
    $stmt->execute([$user->id, $tokenHash]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) { echo "Reset link expired or invalid."; exit; }

    // render a form (include a CSRF token) that posts to same URL with new_password and csrf
    // <form method="POST"> ... <input type="hidden" name="token" value="..."> ...</form>
    // (Don't echo raw token to the page in production; you can keep it in a hidden field for POST)
    // ...
    exit;
}

// POST: process password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $email = $_POST['email'] ?? '';
    $newPassword = $_POST['password'] ?? '';

    // validate inputs
    if (!$token || !$email || !$newPassword) { http_response_code(400); echo "Missing fields."; exit; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { echo "Invalid request."; exit; }
    // validate password strength server-side (length, complexity)
    if (strlen($newPassword) < 8) { echo "Password too short."; exit; }

    // verify CSRF token here

    $db = (new Database())->getConnection();
    $user = User::findByEmail($email);
    if (!$user) { echo "Invalid request."; exit; }

    $tokenHash = hashToken($token);
    $stmt = $db->prepare('SELECT * FROM password_resets WHERE user_id = ? AND token_hash = ? AND used = 0 AND expires_at > NOW() LIMIT 1');
    $stmt->execute([$user->id, $tokenHash]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) { echo "Invalid or expired token."; exit; }

    // safe compare (both are hashes but still use hash_equals)
    if (!hash_equals($row['token_hash'], $tokenHash)) { echo "Invalid token."; exit; }

    // update user password
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $upd = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
    $upd->execute([$passwordHash, $user->id]);

    // mark token used and optionally cleanup other tokens
    $mark = $db->prepare('UPDATE password_resets SET used = 1 WHERE id = ?');
    $mark->execute([$row['id']]);
    $cleanup = $db->prepare('DELETE FROM password_resets WHERE user_id = ? AND used = 0');
    $cleanup->execute([$user->id]);

    echo "Password has been reset successfully.";
}   