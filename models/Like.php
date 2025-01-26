<?php
class Like {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    

    public function isLiked($postId, $userId) {
        $stmt = $this->db->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$postId, $userId]);
        return $stmt->rowCount() > 0;
    }

    public function removeLike($postId, $userId) {
        $stmt = $this->db->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$postId, $userId]);
    }
    public function toggleLike($postId, $userId) {
        if ($this->isLiked($postId, $userId)) {
            $this->removeLike($postId, $userId);
            return false;
        } else {
            $this->addLike($postId, $userId);
            return true;
        }
    }

    private function addLike($postId, $userId) {
        $stmt = $this->db->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        $stmt->execute([$postId, $userId]);
    }
}




?>