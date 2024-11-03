<!-- admin/index.php -->
<?php
session_start();
require_once('../config/database.php');

// Simple login check (you should implement proper authentication)
if (!isset($_SESSION['admin'])) {
    // Admin login form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
            $_SESSION['admin'] = true;
            header('Location: dashboard.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
<?php
    exit();
}

// If logged in, redirect to dashboard
header('Location: dashboard.php');
?>