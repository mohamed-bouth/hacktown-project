<?php
// AuthService.php
require_once '../../Repositories/UserRepository.php';

class AuthService {
    private $userRepo;
    public $errors = [];

    public function __construct($db) {
        $this->userRepo = new UserRepository($db);
    }

    public function register($name, $email, $password, $phone) {
        // 1. Validation Logic
        if (empty($name) || empty($email) || empty($password)) {
            $this->errors[] = "Name, Email, and Password are required.";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid email format.";
            return false;
        }

        if (strlen($password) < 6) {
            $this->errors[] = "Password must be at least 6 characters.";
            return false;
        }

        // 2. Check if user exists
        if ($this->userRepo->findByEmail($email)) {
            $this->errors[] = "Email is already registered.";
            return false;
        }

        // 3. Hash Password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 4. Save to DB
        return $this->userRepo->create($name, $email, $hashedPassword, $phone);
    }

    public function login($email, $password) {
        // 1. Sanitize
        $email = trim($email);

        // 2. Find User
        $user = $this->userRepo->findByEmail($email);

        if (!$user) {
            $this->errors[] = "Invalid email or password.";
            return false;
        }

        // 3. Verify Password
        if (password_verify($password, $user['password'])) {
            // Remove password from array before returning for security
            unset($user['password']); 
            return $user;
        } else {
            $this->errors[] = "Invalid email or password.";
            return false;
        }
    }
}
?>