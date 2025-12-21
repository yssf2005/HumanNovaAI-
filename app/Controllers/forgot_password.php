<?php

    namespace App\Controllers;

    use App\core\Controller;
    use App\Models\User;
    use App\Services\Mailer;
    require_once __DIR__ . '/../Services/Mailer.php';
    require_once __DIR__ . '/../config/config.php';

    // Helper functions for generating and hashing tokens
    function generateResetToken(): string {
        return bin2hex(random_bytes(32));
    }

    function hashToken(string $token): string {
        return hash('sha256', $token);
    }

    // sanitize input
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    if (!$email){
        //generic response to avoid leaking info
        http_response_code(200);
        echo json_encode(['message' => 'if your email is registered, you will get a reset link']);
        exit;
    }
    
    //rate-limit e.g., 3 requests per hour per ip
    $ip = $_SERVER['REMOTE_ADDR'];
    
    //find user by email
    $userModel = new User();
    $user = $userModel->findByEmail($email);
    if (!$user) {
        http_response_code(200);
        echo json_encode(['message' => 'if your email is registered, you will get a reset link']);
        exit;
    }

    //create token
    $token = generateResetToken();
    $tokenHash = hashToken($token);
    $expiresAt = date('Y-m-d H:i:s', time() + 3600); //1 hour expiry

    //store hashed token
    try {
        $dbHost = defined('DB_HOST') ? DB_HOST : getenv('DB_HOST');
        $dbName = defined('DB_NAME') ? DB_NAME : getenv('DB_NAME');
        $dbUser = defined('DB_USER') ? DB_USER : getenv('DB_USER');
        $dbPass = defined('DB_PASS') ? DB_PASS : getenv('DB_PASS');

        $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
        $db = new \PDO($dsn, $dbUser, $dbPass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Internal server error.']);
        exit;
    }

    $stmt = $db->prepare('INSERT INTO password_resets (user_id, token_hash, expires_at, ip_address) VALUES (?,?,?,?)');
    $stmt->execute([$user->id, $tokenHash, $expiresAt, $ip]);

    
// build reset link (do NOT include user id or other sensitive info if possible)
$resetLink = BASE_URL . '/reset_password.php?token=' . urlencode($token) . '&email=' . urlencode($email);

// send email (Mailer::send returns boolean)
$subject = 'Password reset request';
$body = "<p>Someone requested a password reset. Click the link below to reset your password (valid for 1 hour):</p>
<p><a href=\"{$resetLink}\">Reset password</a></p>
<p>If you didn't request this, ignore this email.</p>";

if (class_exists('\App\Services\Mailer')) {
    Mailer::send($email, $subject, $body);
} else {
    // fallback to PHP mail() if the Mailer service is not available
    $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
    @mail($email, $subject, $body, $headers);
}

// generic response
echo json_encode(['message' => 'If that email exists we sent a reset link.']);
?>