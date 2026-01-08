<?php
// UserRepository.php
require_once '../../../config/database.php';

class UserRepository {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Find a user by email
    public function findByEmail($email) {
        $query = "SELECT id, name, email, password, phone FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns array or false
    }

    // Create a new user
    public function create($name, $email, $passwordHash, $phone) {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, phone) VALUES (:name, :email, :password, :phone)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':phone', $phone);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>