<?php
// login.php
session_start();
require_once '../../../config/database.php';
require_once '../../Services/AuthService.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$auth = new AuthService($db);
$message = "";

if (isset($_GET['registered'])) {
    $message = "<span style='color:green'>Account created! Please login.</span>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $auth->login($email, $password);

    if ($user) {
        // Set Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        
        header("Location: ../dashboard.php");
        exit();
    } else {
        $message = implode("<br>", $auth->errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background: #f4f4f4; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 300px; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px 0; border: 1px solid #ddd; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 0.9em; margin-bottom: 10px; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <?php if($message): ?>
            <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>