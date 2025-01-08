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
                    <li><a href="/settings.php">Settings</a></li>
                </ul>
            </nav>
    </aside>

    <div class="profile-container">
    <h1>Admin Profile</h1>

    <!-- Admin Details -->
    <div class="admin-details">
        <p><strong>Username:</strong> AdminUsername</p>
        <p><strong>Email:</strong> admin@example.com</p>
    </div>

    <!-- Change Password -->
    <div class="change-password">
        <h2>Change Password</h2>
        <form method="post" action="#">
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
        <button type="button" name="logout">Logout</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuIcon = document.getElementById('menu-icon');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');

        // Open sidebar
        menuIcon.addEventListener('click', () => {
            sidebar.classList.add('open');
        });

        // Close sidebar
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('open');
        });
    });
</script>

</body>
       
