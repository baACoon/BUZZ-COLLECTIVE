<?php
session_start();



// Database connection
$db = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Fetch admin details
$username = $_SESSION['admin_username'];
echo "Session Username: " . htmlspecialchars($username) . "<br>"; // Debug: Check session username
$query = "SELECT username, email FROM admin WHERE username = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Debug: Check if admin details are fetched
if (!$admin) {
    die("Admin details not found. Please check your database.");
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['admin_username']);
    header('Location: admin_log.php');
    exit();
}

// Change password functionality
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password hash
    $query = "SELECT password FROM admin WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Validate current password
    if (!password_verify($current_password, $hashed_password)) {
        $message = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $message = "New password and confirmation do not match.";
    } else {
        // Update the password
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
<div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="/images/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>

    <aside class="sidebar" id="sidebar">
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Close button -->
        <div class="logo">
            <a href="../admin/admin-home.php">
                <img src="/images/BUZZ-White.png" alt="Buzz Collective Logo">
            </a>
        </div>
            <nav>
                <ul>
                    <li><a href="/dashboard.php">Dashboard</a></li>
                    <li><a href="/admin-appointment.php">Appointment Bookings</a></li>
                    <li><a href="/admin-barber.php">Barbers' Schedule</a></li>
                    <li><a href="/services.php">Services</a><span class="notification-dot"></span></li>
                    <li><a href="/admin-aboutus.php">About Us</a></li>
                    <li><a href="/news.php">News</a></li>
                    <li><a href="/admin-branches.php">Branches</a></li>
                    <li><a href="/adminprofile.php">Admin Profile </a></li>
                </ul>
            </nav>
    </aside>

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
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuIcon = document.getElementById('menu-icon');
            const sidebar = document.querySelector('.sidebar');
            const closeSidebar = document.getElementById('close-sidebar');

            // Add click event to the menu icon
            menuIcon.addEventListener('click', function() {
                sidebar.classList.toggle('open'); // Toggle the 'open' class on the sidebar
                closeSidebar.style.display = sidebar.classList.contains('open') ? 'block' : 'none'; // Show/hide close button
            });

            // Add click event to the close button
            closeSidebar.addEventListener('click', function() {
                sidebar.classList.remove('open'); // Remove the 'open' class on the sidebar
                closeSidebar.style.display = 'none'; // Hide close button
            });
        });
    </script>

</body>
</html>
