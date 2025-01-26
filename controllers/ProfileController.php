<?php

class ProfileController {
    public function show($userId) {
        if (!$userId || !is_numeric($userId)) {
            header("Location: /");
            exit;
        }

        $user = (new User())->findById($userId);
        if (!$user) {
            header("HTTP/1.0 404 Not Found");
            exit("User not found");
        }

        $posts = (new Post())->getUserPosts($userId);
        $friends = (new Friend())->getFriends($userId); // Now works due to Model inheritance

        include '../views/profile.php';
    }
}
?>