<?php
class Post {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function create($userId, $content, $image = null) {
        $stmt = $this->db->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $content, $image]);
    }

    public function getAllPosts() {
        $stmt = $this->db->query("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserPosts($userId) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>