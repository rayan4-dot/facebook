<?php

class Comment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addComment($postId, $userId, $content) {
        $stmt = $this->db->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$postId, $userId, $content]);
    }

    public function getPostComments($postId) {
        $stmt = $this->db->prepare("SELECT comments.*, users.name FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>