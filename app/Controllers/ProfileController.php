<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ProfileController extends Controller {
    
    public function edit() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        $this->render('profile/edit', ['user' => $user]);
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        $id = $_SESSION['user_id'];
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';

        if (empty($name) || empty($email) || empty($currentPassword)) {
            $this->render('profile/edit', ['error' => 'Name, Email, and Current Password are required', 'user' => $_POST]);
            return;
        }

        $userModel = new User();
        $user = $userModel->findById($id);

        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            $this->render('profile/edit', ['error' => 'Incorrect current password', 'user' => $_POST]);
            return;
        }
        
        // Update user
        $passwordToUpdate = !empty($newPassword) ? $newPassword : null;
        
        if ($userModel->update($id, $name, $email, $passwordToUpdate)) {
            // Update session data
            $_SESSION['user_name'] = $name;
            
            $_SESSION['notification'] = [
                'type' => 'success',
                'title' => 'Profile Updated',
                'message' => 'Your profile information has been updated successfully.'
            ];
            $this->redirect('/dashboard');
        } else {
            $_SESSION['notification'] = [
                'type' => 'error',
                'title' => 'Update Failed',
                'message' => 'Could not update profile. Please try again.'
            ];
            $this->redirect('/profile');
        }
    }

    // AJAX: upload avatar (example handler)
    public function uploadAvatar() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        header('Content-Type: application/json');

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'No file uploaded']);
            exit;
        }

        $file = $_FILES['avatar'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowed)) {
            echo json_encode(['error' => 'Invalid image format']);
            exit;
        }

        $uploadsDir = __DIR__ . '/../../public/uploads/avatars';
        if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0755, true);

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
        $dest = $uploadsDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            echo json_encode(['error' => 'Could not save file']);
            exit;
        }

        $publicUrl = BASE_URL . '/uploads/avatars/' . $filename;
        // NOTE: The users table in this app's schema doesn't include avatar by default.
        // Persisting this URL requires adding a column; here we set it into session for demo.
        $_SESSION['user_avatar'] = $publicUrl;

        echo json_encode(['success' => true, 'url' => $publicUrl]);
        exit;
    }

    // AJAX: remove avatar (example)
    public function removeAvatar() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        header('Content-Type: application/json');
        if (isset($_SESSION['user_avatar'])) {
            $url = $_SESSION['user_avatar'];
            $path = __DIR__ . '/../../public' . parse_url($url, PHP_URL_PATH);
            if (file_exists($path)) @unlink($path);
            unset($_SESSION['user_avatar']);
        }
        echo json_encode(['success' => true]);
        exit;
    }

    // AJAX: change password (example)
    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        header('Content-Type: application/json');
        $id = $_SESSION['user_id'];
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (empty($current) || empty($new) || $new !== $confirm) {
            echo json_encode(['error' => 'Validation failed']);
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($id);
        if (!password_verify($current, $user['password'])) {
            echo json_encode(['error' => 'Current password incorrect']);
            exit;
        }

        // Basic strength check example
        if (strlen($new) < 8) {
            echo json_encode(['error' => 'Password too short']);
            exit;
        }

        $userModel->update($id, $user['name'], $user['email'], $new, $user['phone'] ?? null);
        echo json_encode(['success' => true]);
        exit;
    }

    // AJAX: toggle 2FA (demo only)
    public function toggle2fa() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        header('Content-Type: application/json');
        $enable = isset($_POST['enable']) && $_POST['enable'] === '1';
        $_SESSION['2fa_enabled'] = $enable;
        echo json_encode(['success' => true, 'enabled' => $enable]);
        exit;
    }

    // AJAX: list sessions (demo)
    public function sessions() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        header('Content-Type: application/json');
        // In a real app you'd query a sessions table. Here we return the current session plus an example.
        $sessions = [
            ['id' => session_id(), 'device' => 'Current browser', 'ip' => $_SERVER['REMOTE_ADDR'] ?? '—', 'last_seen' => date('Y-m-d H:i:s')],
            ['id' => 'other-123', 'device' => 'Mobile — iPhone', 'ip' => '198.51.100.12', 'last_seen' => date('Y-m-d H:i:s', strtotime('-2 days'))]
        ];
        echo json_encode(['sessions' => $sessions]);
        exit;
    }

    // AJAX: logout other sessions (demo)
    public function logoutOtherSessions() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        header('Content-Type: application/json');
        // In a real app you'd invalidate tokens / session rows. Here we simply respond success.
        echo json_encode(['success' => true]);
        exit;
    }

    // AJAX: deactivate account (demo)
    public function deactivate() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        header('Content-Type: application/json');
        // Demo: mark deactivated in session (persisting requires DB change)
        $_SESSION['deactivated'] = true;
        echo json_encode(['success' => true]);
        exit;
    }

    // AJAX: delete account (example - destructive: only use if intended)
    public function deleteAccount() {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        header('Content-Type: application/json');
        $id = $_SESSION['user_id'];
        // Use User model delete if available. If not, respond with instruction.
        $userModel = new User();
        if (method_exists($userModel, 'delete')) {
            $ok = $userModel->delete($id);
            if ($ok) {
                session_unset();
                session_destroy();
                echo json_encode(['success' => true]);
                exit;
            }
            echo json_encode(['error' => 'Could not delete account']);
            exit;
        }

        echo json_encode(['error' => 'Delete not implemented on server. Add User::delete() to enable.']);
        exit;
    }
}
