<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

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
}
