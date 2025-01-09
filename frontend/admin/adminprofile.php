<?php
session_start();

// Database connection
$db = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Check if admin is logged in
if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['admin_username']);
    header('location: admin_log.php');
    exit();
}

$username = $_SESSION['admin_username'];

// Fetch admin details
$query = "SELECT username, email FROM admin WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Change password functionality
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password hash from the database
    $query = "SELECT password FROM admin WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify current password
    if (!password_verify($current_password, $hashed_password)) {
        $message = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $message = "New password and confirmation do not match.";
    } else {
        // Update the password in the database
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE admin SET password = ? WHERE username = ?";
        $stmt = $db->prepare($update_query);
        $stmt->bind_param("ss", $new_hashed_password, $username);
        if ($stmt->execute()) {
            $message = "Password changed successfully.";
        } else {
            $message = "Error updating password. Please try again.";
        }
        $stmt->close();
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="Designs/admin-profile.css">
</head>
<body>
    <div class="profile-container">
        <h1>Admin Profile</h1>

        <!-- Admin Details -->
        <div class="admin-details">
            <p><strong>Username:</strong> <?= htmlspecialchars($admin['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></p>
        </div>

        <!-- Change Password -->
        <div class="change-password">
            <h2>Change Password</h2>
            <form method="post" action="">
                <?php if (!empty($message)): ?>
                    <p class="message"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" placeholder="Enter current password" required>
                
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required>
                
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required>
                
                <button type="submit" name="change_password">Change Password</button>
            </form>
        </div>

        <!-- Logout -->
        <div class="logout">
            <a href="?logout=true">Logout</a>
        </div>
    </div>
</body>
</html>
