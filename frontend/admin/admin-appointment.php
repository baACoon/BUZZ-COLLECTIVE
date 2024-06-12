<?php

// Retrieve the appointments data from session
$appointments = isset($_SESSION['appointments']) ? $_SESSION['appointments'] : [];

// Clear the appointments data from session
unset($_SESSION['appointments']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Buzz & Collective</title>
    <link rel="stylesheet" href="Designs/adminappointment.css">
</head>
<body>
        <aside class="sidebar">
            <div class="logo">
                <img src="images/BUZZ-White.png" alt="Buzz Collective Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Notification</a><span class="notification-dot"></span></li>
                    <li><a href="admin-home.php">Home</a></li>
                    <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                    <li><a href="#">News and Events</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="#">Reports and Analytics</a></li>
                </ul>
            </nav>
        </aside>

        <div class="dropdown-container">
                <select id="status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Complete">Complete</option>
                    <option value="Noshow">No show</option>
                </select>
        </div>

    <div class="appointments-table-container">
        <h2>Appointments List</h2>
        <table class="appointments-table">
            <thead>
                <tr>
                    <th class="left"></th>
                    <th >ID</th>
                    <th>Booking Data</th>
                    <th>Services</th>
                    <th>Booking Date & Time</th>
                    <th class="right">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/displayappointment.php'); 

            ?>                
            </tbody>
        </table>
    </div>
</body>
</html>
