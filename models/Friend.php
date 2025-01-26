<?php



class Friend extends Model {


    // Send friend request
    public function sendRequest($userId, $friendId) {
        $stmt = $this->db->prepare("INSERT INTO friends (user_id, friend_id) VALUES (?, ?)");
        return $stmt->execute([$userId, $friendId]);
    }

    // Get friend requests
    public function getRequests($userId) {
        $stmt = $this->dbx@->prepare("SELECT * FROM friends WHERE friend_id = ? AND status = 'pending'");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Accept friend request
    public function acceptRequest($requestId) {
        $stmt = $this->db->prepare("UPDATE friends SET status = 'accepted' WHERE id = ?");
        return $stmt->execute([$requestId]);
    }

    // Get friends
    public function getFriends($userId) {
        $stmt = $this->db->prepare("SELECT * FROM friends WHERE (user_id = ? OR friend_id = ?) AND status = 'accepted'");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>