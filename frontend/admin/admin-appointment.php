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
    <div class="sidebars">
        <h2>BUZZ & COLLECTIVE</h2>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Notification</a></li>
            <li><a href="#">Barbers' Schedule</a></li>
            <li><a href="#">News and Events</a></li>
            <li><a href="#" class="active">Appointments</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Reports and Analytics</a></li>
        </ul>
    </div>

    <div class="appointments-table-container">
        <h2>Appointments List</h2>
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>ID</th>
                    <th>Booking Data</th>
                    <th>Services</th>
                    <th>Booking Date & Time</th>
                    <th>Status</th>
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
