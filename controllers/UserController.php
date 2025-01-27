<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    public function register() {
        var_dump($_POST); 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Check if essential fields are filled
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
                $error = "All fields are required";
            } else {
                // Handle file upload for profile picture
                $profile_picture = null;
                if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
                    // Directory to store uploaded images
                    $upload_dir = __DIR__ . '/../uploads/';
                    $file_name = basename($_FILES['profile_picture']['name']);
                    $file_path = $upload_dir . $file_name;

                    // Move uploaded file to server folder
                    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
                        $profile_picture = $file_path;  // Save the file path for DB
                    } else {
                        $error = "Profile picture upload failed";
                    }
                }

                // Get phone number and gender from the form
                $phone_number = $_POST['phone_number'] ?? null;
                $gender = $_POST['gender'] ?? 'other';  // Default to 'other'

                // Instantiate User model and check if email exists
                $user = new User();
                if ($user->findByEmail($_POST['email'])) {
                    $error = "Email already exists";
                } else {
                    // Create user with profile picture, phone number, and gender
                    if ($user->create($_POST['name'], $_POST['email'], $_POST['password'], $profile_picture, $phone_number, $gender)) {
                        header("Location: /login");  // Redirect to login on success
                        exit;
                    } else {
                        $error = "Registration failed";
                    }
                }
            }
        }

        // Render the registration page with potential error
        include '../views/register.php';
    }

    public function login() {
        $auth = new Auth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($auth->login($_POST['email'], $_POST['password'])) {
                header("Location: /");  // Redirect to homepage after login
                exit;
            } else {
                $error = "Invalid email or password";
            }
        }
        
        include '../views/login.php';
    }
}
?>
