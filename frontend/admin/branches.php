<?php
// Load services data
$services = json_decode(file_get_contents('data/services.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - Services</title>
    <link rel="stylesheet" href="Designs/branches.css">
    <script src="scripts.js" defer></script>
</head>
<body>

        <aside class="sidebar">
                <div class="logo">
                    <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
                </div>
                    <nav>
                        <ul>
                        <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                        <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                        <li><a href="services.php">Services</a><span class="notification-dot"></span></li>
                        <li><a href="admin-aboutus.php">About Us</a></li>
                        <li><a href="news.php">News</a></li>
                        <li><a href="branches.php">Branches</a></li>
                        <li><a href="clientprofile.php">Client Profile</a></li>
                        <li><a href="settings.php">Settings</a></li>
                        </ul>
                    </nav>
        </aside>

        <div class="branches-content">
            <h1>BRANCHES</h1>
            <div class="box-container">
                <img src="" alt="logo">
                <h5>Mainbranch</h5>
                

            </div>
        </div>

</body>
</html>
