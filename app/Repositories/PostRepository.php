<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;
use App\Models\Post;

class PostRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function search(array $filters): array
    {
        $sql = "SELECT * FROM posts WHERE status = 'active'";
        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= ' AND (description LIKE :kw OR location_text LIKE :kw OR city LIKE :kw OR category LIKE :kw)';
            $params['kw'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['type'])) {
            $sql .= ' AND type = :type';
            $params['type'] = $filters['type'];
        }

        if (!empty($filters['category'])) {
            $sql .= ' AND category = :category';
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['city'])) {
            $sql .= ' AND city = :city';
            $params['city'] = $filters['city'];
        }

        $sql .= ' ORDER BY created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO posts (user_id, type, category, city, location_text, description, whatsapp, phone, status, created_at)
             VALUES (:user_id, :type, :category, :city, :location_text, :description, :whatsapp, :phone, :status, NOW())'
        );

        $stmt->execute([
            'user_id' => $data['user_id'],
            'type' => $data['type'],
            'category' => $data['category'],
            'city' => $data['city'],
            'location_text' => $data['location_text'],
            'description' => $data['description'],
            'whatsapp' => $data['whatsapp'],
            'phone' => $data['phone'],
            'status' => 'active',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function markResolved(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE posts SET status = :status WHERE id = :id');
        $stmt->execute([
            'status' => 'resolved',
            'id' => $id,
        ]);
    }
    public function getAllPosts() {
        $posts = [];
        // Get all posts, ordered by newest first
        $query = "SELECT * FROM posts ORDER BY created_at DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert raw SQL arrays into Post Objects
        foreach ($results as $row) {
            $posts[] = new Post($row);
        }

        return $posts;
    }
}
