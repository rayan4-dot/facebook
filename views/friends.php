<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Requests</title>
</head>
<body>
    
<?php include 'partials/header.php'; ?>

<div class="container">
    <!-- Pending Requests -->
    <div class="requests-section">
        <h2>Friend Requests</h2>
        <?php if (!empty($requests)): ?>
            <?php foreach ($requests as $request): ?>
            <div class="request-item">
                <img src="<?= $request['profile_picture'] ?>" class="profile-pic-small">
                <div class="request-info">
                    <h4><?= htmlspecialchars($request['name']) ?></h4>
                    <form method="POST" action="/friends/accept">
                        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                        <button type="submit" class="accept-btn">Accept</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No pending friend requests</p>
        <?php endif; ?>
    </div>

    <!-- Friends List -->
    <div class="friends-section">
        <h2>Your Friends</h2>
        <div class="friends-grid">
            <?php foreach ($friends as $friend): ?>
            <div class="friend-card">
                <img src="<?= $friend['profile_picture'] ?>" class="profile-pic-medium">
                <h4><?= htmlspecialchars($friend['name']) ?></h4>
                <a href="/profile/<?= $friend['id'] ?>" class="view-profile">View Profile</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>
<script>
// AJAX friend request handling
document.querySelectorAll('.accept-request').forEach(button => {
    button.addEventListener('click', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch('/api/friend_accept', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            body: JSON.stringify({ 
                request_id: this.dataset.requestId 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) this.closest('.request-item').remove();
        });
    });
});
</script>
</body>
</html>