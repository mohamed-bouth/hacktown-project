<?php
namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    private PostRepository $repo;

    public function __construct()
    {
        $this->repo = new PostRepository();
    }

    public function list(array $filters): array
    {
        return $this->repo->search($filters);
    }

    public function getById(int $id): ?array
    {
        return $this->repo->find($id);
    }

    public function create(array $data): int
    {
        return $this->repo->create($data);
    }

    public function markResolved(int $id): void
    {
        $this->repo->markResolved($id);
    }
}
