<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Requests</title>
</head>
<body>
    
<div class="friend-requests">
    <h3>Pending Requests</h3>
    <?php foreach ($requests as $request): ?>
        <div class="request">
            <span><?= $request['name'] ?></span>
            <button class="accept-request" data-request-id="<?= $request['id'] ?>">Accept</button>
        </div>
    <?php endforeach; ?>
</div>

<div class="friends-list">
    <?php foreach ($friends as $friend): ?>
        <div class="friend">
            <a href="profile.php?id=<?= $friend['id'] ?>"><?= $friend['name'] ?></a>
        </div>
    <?php endforeach; ?>
</div>

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