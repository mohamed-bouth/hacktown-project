<?php
namespace App\Models;

class Post
{
    public int $id;
    public string $type;
    public string $category;
    public string $city;
    public string $locationText;
    public string $description;
    public string $whatsapp;
    public ?string $phone;
    public string $status;
    public string $createdAt;

    public static function fromArray(array $row): self
    {
        $post = new self();
        $post->id = (int) $row['id'];
        $post->type = $row['type'];
        $post->category = $row['category'];
        $post->city = $row['city'];
        $post->locationText = $row['location_text'];
        $post->description = $row['description'];
        $post->whatsapp = $row['whatsapp'];
        $post->phone = $row['phone'] ?? null;
        $post->status = $row['status'];
        $post->createdAt = $row['created_at'];
        return $post;
    }
}
