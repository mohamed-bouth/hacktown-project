<?php
session_start();

// Check if the user_id session variable is NOT set
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ./app/views/auth/login.php");
    exit(); // Stop script execution immediately
}

// If the script continues past this point, the user is logged in.
// You can now access $_SESSION['user_name'], etc.
?>