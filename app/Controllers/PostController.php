<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\PostService;

class PostController extends Controller
{
    private PostService $service;

    private array $categories = ['CIN', 'Phone', 'Document', 'Wallet', 'Other'];
    private array $types = ['lost', 'found'];

    public function __construct()
    {
        $this->service = new PostService();
    }

    public function index(): void
    {
        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'type' => $_GET['type'] ?? '',
            'category' => $_GET['category'] ?? '',
            'city' => trim($_GET['city'] ?? ''),
        ];

        $posts = $this->service->list($filters);
        $this->view('posts/index', [
            'posts' => $posts,
            'filters' => $filters,
            'categories' => $this->categories,
            'types' => $this->types,
        ]);
    }

    public function create(): void
    {
        $this->view('posts/create', [
            'errors' => [],
            'old' => [],
            'categories' => $this->categories,
            'types' => $this->types,
        ]);
    }

    public function store(): void
    {
        $data = [
            'user_id' => $_SESSION['user_id'] ?? 1,
            'type' => $_POST['type'] ?? '',
            'category' => $_POST['category'] ?? '',
            'city' => trim($_POST['city'] ?? ''),
            'location_text' => trim($_POST['location_text'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'whatsapp' => trim($_POST['whatsapp'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
        ];

        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->view('posts/create', [
                'errors' => $errors,
                'old' => $data,
                'categories' => $this->categories,
                'types' => $this->types,
            ]);
            return;
        }

        $data['whatsapp'] = preg_replace('/\D+/', '', $data['whatsapp']);
        $data['phone'] = $data['phone'] !== '' ? preg_replace('/\D+/', '', $data['phone']) : null;

        $this->service->create($data);
        $this->redirect('/');
    }

    public function show(string $id): void
    {
        $post = $this->service->getById((int) $id);

        if ($post === null) {
            http_response_code(404);
            echo 'Post not found.';
            return;
        }

        $this->view('posts/show', [
            'post' => $post,
        ]);
    }

    public function resolve(string $id): void
    {
        $this->service->markResolved((int) $id);
        $this->redirect('/posts/' . $id);
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (!in_array($data['type'], $this->types, true)) {
            $errors[] = 'Please select a valid type.';
        }

        if (!in_array($data['category'], $this->categories, true)) {
            $errors[] = 'Please select a valid category.';
        }

        if ($data['city'] === '') {
            $errors[] = 'City is required.';
        }

        if ($data['location_text'] === '') {
            $errors[] = 'Location is required.';
        }

        if ($data['description'] === '') {
            $errors[] = 'Description is required.';
        }

        if (strlen($data['description']) > 500) {
            $errors[] = 'Description must be 500 characters or less.';
        }

        if ($data['whatsapp'] === '') {
            $errors[] = 'WhatsApp number is required.';
        }

        return $errors;
    }
}
