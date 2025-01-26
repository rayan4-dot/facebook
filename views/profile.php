<?php include 'header.php'; ?>
<div class="profile-header">
    <img src="<?= $user['profile_picture'] ?>" class="cover-photo">
    <div class="profile-info">
        <h1><?= htmlspecialchars($user['name']) ?></h1>
        <p><?= $user['email'] ?></p>
        <p>Friends: <?= count($friends) ?></p>
    </div>
</div>

<div class="profile-posts">
    <?php foreach ($posts as $post): ?>
        <!-- Post display similar to dashboard -->
    <?php endforeach; ?>
</div>
<?php include 'footer.php'; ?>