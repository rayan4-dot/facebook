<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/Session.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../controllers/PostController.php';

Session::start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



$postController = new PostController();

// Fetch posts from the database
$postModel = new Post();
$posts = $postModel->getAllPosts(); // Or $postModel->getAllPosts()

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $postController->updatePost(); // Call update logic
    } else {
        $postController->createPost(); // Default behavior: create a post
    }
}


?>


<!DOCTYPE html>
    <html lang="en">
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Social</title>
        <link rel="stylesheet" href="/facebook/assets/css/style.css">
    </head>
    <body>
        <nav class="main-nav">
            <a href="/" class="nav-brand">Social</a>
            <div class="nav-links">
                <?php if (Session::get('user_id')): ?>
                    <a href="/dashboard">Dashboard</a>
                    <a href="views/profile.php<?= Session::get('user_id') ?>">Profile</a>
                    <a href="views/friends.php">Friends</a>
                    <a  href="/logout">Logout</a>
                <?php else: ?>
                    <a href="/login">Login</a>
                    <a href="/register">Register</a>
                <?php endif; ?>
            </div>
        </nav>
<div class="container">
    <div class="post-form">
        <form method="POST" enctype="multipart/form-data">
            <textarea name="content" placeholder="What's on your mind?" required></textarea>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Post</button>
        </form>
    </div>

    <div class="posts">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <div class="post-header">
                    <img src="<?= $post['profile_picture'] ?? 'assets/default-profile.png' ?>" class="profile-pic">
                    <h3><?= htmlspecialchars($post['name']) ?></h3>
                    <small><?= date('M j, Y H:i', strtotime($post['created_at'])) ?></small>
                </div>

                <div class="post-content" id="post-content-<?= $post['id'] ?>">
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    <?php if (!empty($post['image'])): ?>
        <img src="<?= htmlspecialchars($post['image'], ENT_QUOTES, 'UTF-8') ?>" class="post-image" alt="Post Image">
    <?php else: ?>
        <p>(No image attached)</p>
    <?php endif; ?>
</div>
        

                <!-- Edit Form -->
                <form method="POST" action="dashboard.php" enctype="multipart/form-data" class="edit-form" id="edit-form-<?= $post['id'] ?>" style="display: none;">
                    <textarea name="content"><?= htmlspecialchars($post['content']) ?></textarea>
                    <input type="file" name="image" accept="image/*">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>"> <!-- Post ID -->
                    <input type="hidden" name="action" value="edit"> <!-- Action identifier -->
                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelEdit(<?= $post['id'] ?>)">Cancel</button>
                </form>

                <!-- Buttons -->
                <div class="post-actions">
                    <button onclick="enableEdit(<?= $post['id'] ?>)">Edit</button>
                    <a href="delete_post.php?id=<?= $post['id'] ?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No posts to display.</p>
    <?php endif; ?>
</div>

</div>

</main>
</body>
</html>

<script>
function enableEdit(postId) {
    document.getElementById('post-content-' + postId).style.display = 'none';
    document.getElementById('edit-form-' + postId).style.display = 'block';
}

function cancelEdit(postId) {
    document.getElementById('edit-form-' + postId).style.display = 'none';
    document.getElementById('post-content-' + postId).style.display = 'block';
}
</script>
