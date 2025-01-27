<?php

class Post {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }
    public function getImagePath($postId) {
        $query = "SELECT image FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['image'] : null;
    }
    
    public function create($userId, $content, $image = null) {
        $query = "INSERT INTO posts (user_id, content, image, created_at) VALUES (:user_id, :content, :image, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }
    
    public function update($postId, $content, $image = null) {
        $query = "UPDATE posts SET content = :content, image = :image, updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $postId);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }
    
    public function getAllPosts() {
        $query = "SELECT posts.*, users.name, users.profile_picture 
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  ORDER BY posts.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        
}
?>
