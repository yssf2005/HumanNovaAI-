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
}
