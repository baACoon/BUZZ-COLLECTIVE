<?php
session_start();

// Connect to the database
$db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: admin_log.php');
    exit();
}

// Fetch admin details
$username = $_SESSION['username'];
$query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($db, $query);
$admin = mysqli_fetch_assoc($result);

// Update password
$errors = [];
$success = "";
if (isset($_POST['change_password'])) {
    $current_password = mysqli_real_escape_string($db, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);

    // Validate inputs
    if (empty($current_password)) $errors[] = "Current password is required.";
    if (empty($new_password)) $errors[] = "New password is required.";
    if ($new_password !== $confirm_password) $errors[] = "New passwords do not match.";

    // Check current password
    if (count($errors) == 0 && !password_verify($current_password, $admin['password'])) {
        $errors[] = "Current password is incorrect.";
    }

    // Update password in the database
    if (count($errors) == 0) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_query = "UPDATE admin SET password = '$hashed_password' WHERE id = " . $admin['id'];
        if (mysqli_query($db, $update_query)) {
            $success = "Password changed successfully.";
        } else {
            $errors[] = "Failed to update password.";
        }
    }
}

// Logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: admin_log.php');
    exit();
}
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

        <!-- Display Admin Details -->
        <div class="admin-details">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($admin['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
        </div>

        <!-- Change Password -->
        <div class="change-password">
            <h2>Change Password</h2>
            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <?php foreach ($errors as $error): ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>
                
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>
                
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                
                <button type="submit" name="change_password">Change Password</button>
            </form>
        </div>

        <!-- Logout -->
        <div class="logout">
            <form method="post" action="">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
