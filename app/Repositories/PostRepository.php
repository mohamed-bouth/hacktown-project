<?php
// repositories/PostRepository.php
require_once __DIR__ . '/../models/Post.php'; // Adjust path if needed

class PostRepository {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getAllPosts() {
        $posts = [];
        // Get all posts, ordered by newest first
        $query = "SELECT * FROM posts ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert raw SQL arrays into Post Objects
        foreach ($results as $row) {
            $posts[] = new Post($row);
        }

        return $posts;
    }
}
?>