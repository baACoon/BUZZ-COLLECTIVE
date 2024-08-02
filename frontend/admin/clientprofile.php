<?php 

$clients = isset($_SESSION['users']) ? $_SESSION['users'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Designs/adminclientprof.css">
    <title>Client Profile</title>
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

                <div class="clntprfl">
                    <h1>Client Profile</h1>
                </div>

                <div id="crud-btn">
                        <div class="add-btn">
                            <button class="add-button" ><a href="">ADD</a></button>
                        </div>

                        <div class="view-btn">
                            <button class="view-button"><a href="">VIEW</a></button>
                        </div>

                        <div class="delete-btn">
                            <button class="delete-button"><a href="">DELETE</a></button>
                        </div>
                </div>

                <div class="client-table-container">
        
                    <table class="client-table">
                        <thead>
                            <tr>
                                <th class="left"></th>
                                <th >ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th class="right"></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                 include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/adminclient.php'); 

                            ?>                
                            </tbody>
                        </table>
                </div>

</body>
</html>