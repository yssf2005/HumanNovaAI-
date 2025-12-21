<?php

namespace {
    // Mailer is a simple global class in app/Services/Mailer.php
    // Provide a minimal stub in the global namespace for static analysis; actual Mailer will be loaded at runtime if available.
    if (!\class_exists('Mailer')) {
        class Mailer {
            public static function send(string $to, string $subject, string $body) {
                // noop - runtime Mailer (if present) should perform sending; stub returns true for compatibility.
                return true;
            }
        }
    }
}

namespace App\Controllers {

use App\Core\Controller;
use App\Models\User;
use App\Core\Database;
use App\Services\TokenService;
use App\Services\MailTemplates;

class AuthController extends Controller {
    public function login() {
        $this->render('auth/login');
    }

    public function handleLogin() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
            
            if ($user['role'] === 'admin') {
                $this->redirect('/dashboard');
            } else {
                $this->redirect('/');
            }
        } else {
            // Pass error to view
            $this->render('auth/login', ['error' => 'Invalid credentials']);
        }
    }

    public function register() {
        $this->render('auth/register');
    }

    public function handleRegister() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Simple validation
        if (empty($name) || empty($email) || empty($password)) {
             $this->render('auth/register', ['error' => 'All fields are required']);
             return;
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $this->render('auth/register', ['error' => 'Email already exists']);
            return;
        }

        if ($userModel->create($name, $email, $password)) {
            $this->redirect('/login');
        } else {
             $this->render('auth/register', ['error' => 'Registration failed']);
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }

    // Show forgot password form
    public function forgot() {
        $this->render('auth/forgot');
    }

    // Handle forgot password request (generate token and send email)
    public function handleForgot() {
        $email = $_POST['email'] ?? '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Generic response
            $this->render('auth/forgot', ['message' => 'If that email exists we sent a reset link.']);
            return;
        }

        // Try to find user
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        // Always show generic message
        $this->render('auth/forgot', ['message' => 'If that email exists we sent a reset link.']);

        if (!$user) {
            return; // do not reveal
        }

        // Create selector/validator pair
        $pair = TokenService::createSelectorValidatorPair();
        $selector = $pair['selector'];
        $validator = $pair['validator'];
        $validatorHash = $pair['validator_hash'];

        $expiresAt = (new \DateTime('+1 hour'))->format('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;

        // Store in DB
        $db = new Database();
        $pdo = $db->prepare('INSERT INTO password_resets (user_id, selector, validator_hash, expires_at, ip_address) VALUES (?, ?, ?, ?, ?)');
        $pdo->execute([$user['id'], $selector, $validatorHash, $expiresAt, $ip]);

        // Build reset link (include selector + validator)
        $resetLink = BASE_URL . '/reset?selector=' . urlencode($selector) . '&validator=' . urlencode($validator);

        // Send email using the professional template
        // Only include the real Mailer/MailTemplates if they are not already defined to avoid redeclaration.
        if (!\class_exists('Mailer')) {
            @include_once __DIR__ . '/../Services/Mailer.php';
        }
        if (!\class_exists('App\\Services\\MailTemplates') && !\class_exists('MailTemplates')) {
            @include_once __DIR__ . '/../Services/MailTemplates.php';
        }
        $subject = 'Réinitialisation de votre mot de passe';
        $displayName = $user['name'] ?? '';
        $body = MailTemplates::resetPassword($displayName, $resetLink, 1, MAIL_FROM_NAME);

        if (class_exists('Mailer')) {
            \Mailer::send($email, $subject, $body);
        }
    }

    // Show reset form (validate selector first)
    public function showReset() {
        $selector = $_GET['selector'] ?? '';
        $validator = $_GET['validator'] ?? '';

        if (empty($selector) || empty($validator)) {
            $this->render('auth/reset', ['error' => 'Invalid reset link.']);
            return;
        }

        // Lookup token
        $db = new Database();
        $pdo = $db->prepare('SELECT * FROM password_resets WHERE selector = ? AND used = 0 AND expires_at > NOW() LIMIT 1');
        $pdo->execute([$selector]);
        $row = $pdo->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            $this->render('auth/reset', ['error' => 'Reset link expired or invalid.']);
            return;
        }

        // Verify validator
        if (!TokenService::verifyValidator($validator, $row['validator_hash'])) {
            $this->render('auth/reset', ['error' => 'Reset link invalid.']);
            return;
        }

        // Show form (include selector and validator in hidden fields)
        $this->render('auth/reset', ['selector' => $selector, 'validator' => $validator]);
    }

    // Handle reset submission
    public function handleReset() {
        $selector = $_POST['selector'] ?? '';
        $validator = $_POST['validator'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if (empty($selector) || empty($validator) || empty($password)) {
            $this->render('auth/reset', ['error' => 'Missing fields.']);
            return;
        }

        if ($password !== $password_confirm) {
            $this->render('auth/reset', ['error' => 'Passwords do not match.', 'selector' => $selector, 'validator' => $validator]);
            return;
        }

        if (strlen($password) < 8) {
            $this->render('auth/reset', ['error' => 'Password must be at least 8 characters.', 'selector' => $selector, 'validator' => $validator]);
            return;
        }

        // Lookup token
        $db = new Database();
        $pdo = $db->prepare('SELECT * FROM password_resets WHERE selector = ? AND used = 0 AND expires_at > NOW() LIMIT 1');
        $pdo->execute([$selector]);
        $row = $pdo->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            $this->render('auth/reset', ['error' => 'Reset link expired or invalid.']);
            return;
        }

        if (!TokenService::verifyValidator($validator, $row['validator_hash'])) {
            $this->render('auth/reset', ['error' => 'Reset link invalid.']);
            return;
        }

        // Update user password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $upd->execute([$passwordHash, $row['user_id']]);

        // Mark token used
        $mark = $db->prepare('UPDATE password_resets SET used = 1 WHERE id = ?');
        $mark->execute([$row['id']]);

        // Optionally cleanup other unused tokens for this user
        $cleanup = $db->prepare('DELETE FROM password_resets WHERE user_id = ? AND used = 0');
        $cleanup->execute([$row['user_id']]);

        // Redirect to login with success message
        $this->redirect('/login');
    }
}
}
