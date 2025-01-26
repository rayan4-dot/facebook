
<?php include 'header.php'; ?>
<div class="container">
    <div class="post-form">
        <form method="POST" enctype="multipart/form-data">
            <textarea name="content" placeholder="What's on your mind?"></textarea>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Post</button>
        </form>
    </div>

    <div class="posts">
        <?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="post-header">
                <img src="<?= $post['profile_picture'] ?? 'assets/default-profile.png' ?>" class="profile-pic">
                <h3><?= htmlspecialchars($post['name']) ?></h3>
                <small><?= date('M j, Y H:i', strtotime($post['created_at'])) ?></small>
            </div>
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <?php if ($post['image']): ?>
                <img src="<?= $post['image'] ?>" class="post-image">
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>