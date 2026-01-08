<?php
declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/posts.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/create.php');
}

$data = [
    'type' => trim((string)($_POST['type'] ?? '')),
    'category' => trim((string)($_POST['category'] ?? '')),
    'city' => trim((string)($_POST['city'] ?? '')),
    'location_text' => trim((string)($_POST['location_text'] ?? '')),
    'description' => trim((string)($_POST['description'] ?? '')),
    'whatsapp' => trim((string)($_POST['whatsapp'] ?? '')),
    'phone' => trim((string)($_POST['phone'] ?? '')),
];

$errors = [];

if ($data['type'] === '' || !array_key_exists($data['type'], POST_TYPES)) {
    $errors['type'] = 'Please select a valid type.';
}

if ($data['category'] === '' || !in_array($data['category'], POST_CATEGORIES, true)) {
    $errors['category'] = 'Please select a valid category.';
}

if ($data['city'] === '' || strlen($data['city']) > 120) {
    $errors['city'] = 'City is required (max 120 characters).';
}

if ($data['location_text'] === '' || strlen($data['location_text']) > 255) {
    $errors['location_text'] = 'Location is required (max 255 characters).';
}

if ($data['description'] === '' || strlen($data['description']) > 500) {
    $errors['description'] = 'Description is required (max 500 characters).';
}

if ($data['whatsapp'] === '' || strlen($data['whatsapp']) > 30) {
    $errors['whatsapp'] = 'WhatsApp number is required (max 30 characters).';
}

if ($data['phone'] !== '' && strlen($data['phone']) > 30) {
    $errors['phone'] = 'Phone number must be 30 characters or less.';
}

if (!empty($errors)) {
    set_form_state($errors, $data);
    redirect('/create.php');
}

$postId = create_post($data);
flash_set('success', 'Post published successfully.');

redirect('/show.php?id=' . $postId);
