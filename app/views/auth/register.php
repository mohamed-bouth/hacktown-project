<?php
// register.php
session_start();
require_once '../../../config/database.php';
require_once '../../Services/AuthService.php';


$database = new Database();
$db = $database->getConnection();
$auth = new AuthService($db);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->register($name, $email, $password, $phone)) {
        // Success
        header("Location: login.php?registered=true");
        exit();
    } else {
        // Show errors
        $message = implode("<br>", $auth->errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background: #f4f4f4; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px 0; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 0.9em; margin-bottom: 10px; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Register</h2>
        <?php if($message): ?>
            <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label>Full Name</label>
            <input type="text" name="name" required>
            
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Phone (Optional)</label>
            <input type="text" name="phone">

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="./login.php">Login here</a></p>
    </div>
</body>
</html>