<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Designs/adminhome.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="logo.png" alt="Buzz Collective Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="admin-barber.php">Barbers' Schedule</a></li>
                    <li><a href="#">News and Events</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="admin-appointment.php">Appointment Bookings</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="#">Reports and Analytics</a></li>
                </ul>
            </nav>
        </aside>
        <main>
            <header>
                <nav class="top-nav">
                    <a href="#">Dashboard</a>
                    <a href="#">Profile</a>
                    <a href="#">Notification <span class="notification-dot"></span></a>
                </nav>
            </header>
            <section class="highlights">
                <div class="highlight-box">
                    <p>76</p>
                    <span>Total Users</span>
                </div>
                <div class="highlight-box">
                    <p>46</p>
                    <span>Avg. Appointments per Barber</span>
                </div>
                <div class="highlight-box">
                    <p>12</p>
                    <span>New Appointments</span>
                </div>
            </section>
            <section class="feedback">
                <h2>Feedback</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Rating</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>Rating</td>
                            <td>Message</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>Rating</td>
                            <td>Message</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>Rating</td>
                            <td>Message</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>Rating</td>
                            <td>Message</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
