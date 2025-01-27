<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/User.php';  // Include User model

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create an instance of the User model
    $user = new User();

    // Check if user exists by email
    $userData = $user->findByEmail($email);

    if ($userData) {
        // If user exists, check if password matches
        if (password_verify($password, $userData['password'])) {
            // If password is correct, start session and redirect to dashboard
            if (session_status() === PHP_SESSION_NONE) {
                session_start(); // Start the session if not already started
            }
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['name'] = $userData['name'];

            header("Location: ../dashboard.php");  // Redirect to dashboard
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
}
?>

<?php include '../views/partials/header.php'; ?>

<div class="login-form">
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <div class="alert"><?= $error ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

<?php include '../views/partials/footer.php'; ?>
