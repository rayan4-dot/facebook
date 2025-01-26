<?php

class Notification {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($userId, $type, $sourceId) {
        $stmt = $this->db->prepare("INSERT INTO notifications (user_id, type, source_id) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $type, $sourceId]);
    }

    public function getUnread($userId) {
        $stmt = $this->db->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = FALSE");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>