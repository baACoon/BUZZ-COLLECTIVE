<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../design/image/buzznCollectives.jpg">
    <title>Buzz & Collective - About Us</title>
    <link rel="stylesheet" href="Designs/admin-aboutus.css?v=901">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <base href="https://admin.buzzcollective.gayvar.com/Buzz-collective/frontend/admin/">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
     <!-- Navbar for screens below 768px -->
     <div class="mobile-navbar" id="mobile-navbar">
        <div class="mobile-logo">
            <img src="/images/BUZZ-Black.png" alt="Buzz Collective Logo">
        </div>
        <i class='bx bx-menu' id="menu-icon"></i>
    </div>
    
    <aside class="sidebar" id="sidebar">
        <i class='bx bx-x' id="close-sidebar" style="display: none;"></i> <!-- Add this line for the close button -->
        <div class="logo">
            <a href="/admin-home.php">
                <img src="/images/BUZZ-White.png" alt="Buzz Collective Logo">
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="/dashboard.php">Dashboard</a></li>
                <li><a href="/admin-appointment.php">Appointment Bookings</a></li>
                <li><a href="/admin-barber.php">Barbers' Schedule</a></li>
                <li><a href="/services.php">Services</a><span class="notification-dot"></span></li>
                <li>
                    <a href="/admin-aboutus.php">About Us</a>
                                <li><a href="/aboutus.php">Barbers</a></li>

                </li>
                <li><a href="/news.php">News</a></li>
                <li><a href="/adminprofile.php">Admin Profile </a></li>
            </ul>
        </nav>
    </aside>


    <div class="aboutus-content">
        <div class="aboutusheader">
            <h1>ABOUT US</h1>
        </div>

        <div class="aboutus-btn">
            <li><button class="aboutbarbers"><a href="/aboutus.php">ABOUT US</a></button></li>
            

        </div>
    </div>

 
    <script>
         // menu icon
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