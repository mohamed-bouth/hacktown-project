<?php
declare(strict_types=1);

function fetch_posts(array $filters): array
{
    $sql = 'SELECT * FROM posts WHERE status = :status';
    $params = ['status' => 'active'];

    if ($filters['q'] !== '') {
        $sql .= ' AND (description LIKE :q OR location_text LIKE :q OR city LIKE :q)';
        $params['q'] = '%' . $filters['q'] . '%';
    }

    if ($filters['type'] !== '') {
        $sql .= ' AND type = :type';
        $params['type'] = $filters['type'];
    }

    if ($filters['category'] !== '') {
        $sql .= ' AND category = :category';
        $params['category'] = $filters['category'];
    }

    if ($filters['city'] !== '') {
        $sql .= ' AND city = :city';
        $params['city'] = $filters['city'];
    }

    $sql .= ' ORDER BY created_at DESC';

    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

function fetch_post(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM posts WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch();

    return $post ?: null;
}

function create_post(array $data): int
{
    $stmt = db()->prepare(
        'INSERT INTO posts (type, category, city, location_text, description, whatsapp, phone, status, created_at, updated_at)
         VALUES (:type, :category, :city, :location_text, :description, :whatsapp, :phone, :status, NOW(), NOW())'
    );

    $stmt->execute([
        'type' => $data['type'],
        'category' => $data['category'],
        'city' => $data['city'],
        'location_text' => $data['location_text'],
        'description' => $data['description'],
        'whatsapp' => $data['whatsapp'],
        'phone' => $data['phone'] !== '' ? $data['phone'] : null,
        'status' => 'active',
    ]);

    return (int)db()->lastInsertId();
}

function resolve_post(int $id): void
{
    $stmt = db()->prepare('UPDATE posts SET status = :status, updated_at = NOW() WHERE id = :id');
    $stmt->execute([
        'status' => 'resolved',
        'id' => $id,
    ]);
}
