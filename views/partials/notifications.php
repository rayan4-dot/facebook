<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php require_once __DIR__ . '/../../includes/helpers.php'; ?>

<?php if (!empty($notifications)): ?>
<div class="notifications-dropdown">
    <?php foreach ($notifications as $notification): ?>
    <div class="notification-item">
        <span class="notification-icon"></span>
        <div class="notification-content">
            <?php switch ($notification['type']):
                case 'friend_request': ?>
                    New friend request from <?= getUserName($notification['source_id']) ?>
                    <?php break; ?>
                <?php case 'like': ?>
                    <?= getUserName($notification['source_id']) ?> liked your post
                    <?php break; ?>
                <?php case 'comment': ?>
                    <?= getUserName($notification['source_id']) ?> commented on your post
                    <?php break; ?>
            <?php endswitch; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>