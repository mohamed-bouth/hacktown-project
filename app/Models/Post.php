<?php
// models/Post.php

class Post {
    private $id;
    private $user_id;
    private $type;       // 'lost' or 'found'
    private $category;
    private $city;
    private $location_text;
    private $description;
    private $status;
    private $created_at;
    private $image_url;

    // Constructor to hydrate the object from a database array
    public function __construct($data) {
        $this->id = $data['id'];
        $this->user_id = $data['user_id'];
        $this->type = $data['type'];
        $this->category = $data['category'];
        $this->city = $data['city'];
        $this->location_text = $data['location_text'];
        $this->description = $data['description'];
        $this->status = $data['status'];
        $this->created_at = $data['created_at'];
        $this->image_url = $data['image_url'];
    }

    // Getters (to access data safely)
    public function getId() { return $this->id; }
    public function getType() { return $this->type; }
    public function getCategory() { return $this->category; }
    public function getCity() { return $this->city; }
    public function getLocation() { return $this->location_text; }
    public function getStatus() { return $this->status; }
    public function getImage() { return $this->image_url; }
    
    // specialized getter for date formatting
    public function getFormattedDate() {
        return date("M d, Y", strtotime($this->created_at));
    }

    public function getTitle() {
        // Create a title like "Lost Wallet in Casablanca"
        return ucfirst($this->type) . " " . ucfirst($this->category);
    }
}
?>
