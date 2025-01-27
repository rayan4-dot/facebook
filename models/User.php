<?php
// models/User.php
require_once __DIR__ . '/../includes/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Updated create method with profile_picture, phone_number, and gender
    public function create($name, $email, $password, $phone_number, $gender, $profile_picture) {
        // Check if email already exists
        if ($this->findByEmail($email)) {
            return false; // Email already exists
        }
    
        // Hash the password
        $hashed = password_hash($password, PASSWORD_DEFAULT);
    
        // Prepare the SQL query to insert the user
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, phone_number, gender, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashed, $phone_number, $gender, $profile_picture]);
    }
    
    

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
