<?php
function getUserName($userId) {
    $user = (new User())->findById($userId);
    return $user ? htmlspecialchars($user['name']) : 'Unknown User';
}

function formatDate($timestamp) {
    return date('M j, Y H:i', strtotime($timestamp));
}