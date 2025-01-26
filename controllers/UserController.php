<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
                $error = "All fields are required";
            } else {
                $user = new User();
                if ($user->findByEmail($_POST['email'])) {
                    $error = "Email already exists";
                } else {
                    if ($user->create($_POST['name'], $_POST['email'], $_POST['password'])) {
                        header("Location: login.php");
                        exit;
                    }
                }
            }
        }
        include '../views/register.php';
    }
}
?>