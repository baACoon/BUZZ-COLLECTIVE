<?php

session_start();
if (!isset($_SESSION['admin_username'])) {
    header('location: admin_log.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buzz & Collective - Home</title>
    <base href="https://admin.buzzcollective.gayvar.com/Buzz-collective/frontend/admin/">
    <link rel="stylesheet" href="/Designs/adminhomee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="script.js" defer></script>
    <script src="branches.js"></script>
</head>
<body>
    <div id="home-logo">
        <img src="/images/Buzz-White2.png" alt="Buzz Logo">
    </div>
    <div class="home-container">
        <div class="home-selection">
            <ul>
                <li>
                    <a href="/admin-appointment.php">
                        <p><i class="fa-solid fa-book" style="color: #cfcfcf"></i> Appointment Bookings</p>
                    </a>
                </li>
                <li>
                    <a href="/admin-barber.php">
                        <p><i class="fa-solid fa-scissors" style="color: #cfcfcf;"></i> Barbers' Schedule</p>
                    </a>
                </li>
                <li>
                    <a href="/services.php">
                        <p><i class="fa-solid fa-concierge-bell" style="color: #cfcfcf;"></i> Services</p>
                    </a>   
                </li>
                <li>
                    <a href="/admin-aboutus.php">
                        <p><i class="fa-solid fa-info-circle" style="color: #cfcfcf;"></i> About Us</p>
                    </a>
                </li>
                <li>    
                    <a href="/news.php">
                        <p><i class="fa-solid fa-newspaper" style="color: #cfcfcf;"></i> News</p>
                    </a>   
                </li>
                <li>
                    <a href="/admin-branches.php">
                        <p><i class="fa-solid fa-map-marker-alt" style="color: #cfcfcf;"></i> Branches</p>
                    </a>
                </li>
                <li>
                    <a href="/settings.php">
                        <p><i class="fa-solid fa-cog" style="color: #cfcfcf;"></i> Settings</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="logout-button">
        <a href="/admin_log.php">
            <p>Logout</p>
        </a>
    </div>
    </div>
</body>
