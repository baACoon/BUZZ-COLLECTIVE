<?php
session_start();

$_SESSION['username'] = $username; // Assign the username to the session

if (!isset($_SESSION['username'])) {
    die('Session not set');
    header('Location: admin_log.php');
    exit();
}

if (isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
    unset($_SESSION['errors']);
}

if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>".$_SESSION['success']."</p>";
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - Settings</title>
    <link rel="icon" type="image/x-icon" href="../design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="Designs/settings.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- Navbar for screens below 768px -->
    <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="images/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>

    <aside class="sidebar" id="sidebar">
    <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Close button -->
    <div class="logo">
        <a href="../admin/admin-home.php">
            <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
        </a>
    </div>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="admin-appointment.php">Appointment Bookings</a></li>
            <li><a href="admin-barber.php">Barbers' Schedule</a></li>
            <li class="services"><a href="services.php">Services</a><span class="notification-dot"></span></li>
            <li class="about-us"><a href="admin-aboutus.php">About Us</a></li>
            <li><a href="news.php">News</a></li>
            <li><a href="admin-branches.php">Branches</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </nav>
</aside>


    <div class="settings-content">
        <div class="settings-header">
            <h1 id="settings-title">Settings</h1>
        </div>

        <div class="settings-btn" id="button-container">
            <li><button class="addnew" id="add-new-btn">ADD NEW ADMINISTRATOR</button></li>
            <li><button class="login"><a href="admin_log.php">LOGOUT</a></button></li>
        </div>
        
        <div id="new-admin-container" style="display: none;">
            <div id="new-admin-form">
                <form method="POST" action="/BUZZ-COLLECTIVE/backend/save_admin.php">
                    <label for="admin-username">Username</label>
                    <input type="text" id="admin-username" name="admin-username" placeholder="Username" required>
                    
                    <label for="admin-email">Email</label>
                    <input type="email" id="admin-email" name="admin-email" placeholder="Email" required>

                    <label for="admin-password">Password</label>
                    <input type="password" id="admin-password" name="admin-password" placeholder="Password" required>

                    <div class="form-buttons">
                        <button type="submit" name="save_admin">SAVE</button>
                        <button type="button" id="cancel-btn" class="cancel-btn">Cancel</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>

    <script src="settings.js"></script>
</body>
</html>
