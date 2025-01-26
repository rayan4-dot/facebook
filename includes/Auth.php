<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../models/User.php';

class Auth {
    public function login($email, $password) {
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_destroy();
    }

    public function getCurrentUser() {
        return isset($_SESSION['user_id']) ? (new User())->findById($_SESSION['user_id']) : null;
    }
}
?>