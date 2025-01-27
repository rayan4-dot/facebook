<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_POST); // Check form data

require_once __DIR__ . '/../models/User.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    $target_file = null;
    
    if (!empty($_FILES['profile_picture']['name'])) {
        // Path to the directory where files should be stored
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        
        // Check if file is an actual image (optional)
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo "The file ". basename($_FILES["profile_picture"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Proceed with user registration
    $user = new User();
    if ($user->create($_POST['name'], $_POST['email'], $_POST['password'], $_POST['phone_number'], $_POST['gender'], $target_file)) {
        // Redirect to login page or dashboard
        header("Location: /views/login.php");
        exit;
    } else {
        echo "Error: Unable to register. Email may already be in use.";
    }
}
?>

<?php include '../views/partials/header.php'; ?>

<div class="container">
    <h2>Register</h2>
    <?php if (isset($error)): ?>
        <div class="alert"><?= $error ?></div>
    <?php endif; ?>
    <form action="register.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*"><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" pattern="\d{10}" placeholder="Enter a 10-digit number"><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>

        <button type="submit">Register</button>
    </form>
</div>

<?php include '../views/partials/footer.php'; ?>
