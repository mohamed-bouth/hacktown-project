<?php
namespace App\Models;

class Post
{
    public int $id;
    public int $user_id;
    public string $type;
    public string $category;
    public string $city;
    public string $locationText;
    public string $description;
    public string $whatsapp;
    public ?string $phone;
    public string $status;
    public string $createdAt;
    public string $imageUrl;

    public static function fromArray(array $row): self
    {
        $post = new self();
        $post->id = (int) $row['id'];
        $post->user_id = (int) $row['user_id'];
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

    public function getId() { return $this->id; }
    public function getType() { return $this->type; }
    public function getCategory() { return $this->category; }
    public function getCity() { return $this->city; }
    public function getLocation() { return $this->locationText; }
    public function getStatus() { return $this->status; }
    public function getImage() { return $this->imageUrl; }

    // specialized getter for date formatting
    public function getFormattedDate() {
        return date("M d, Y", strtotime($this->createdAt));
    }

    public function getTitle() {
        // Create a title like "Lost Wallet in Casablanca"
        return ucfirst($this->type) . " " . ucfirst($this->category);
    }
}
