<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <base href="https://admin.buzzcollective.gayvar.com/Buzz-collective/frontend/admin/">
    <link rel="stylesheet" href="/Designs/admindash.css?v=101">
    <link rel="stylesheet" href="/Designs/dashboard.css?v=101">
</head>
<body>


            <aside class="sidebar">
                <div class="logo">
                    <img src="/images/BUZZ-White.png" alt="Buzz Collective Logo">
                 </div>
                    <nav>
                        <ul>
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

   
  
    <div class="dropdown-container">
                <select id="months" name="months">
                    <option value="january">January</option>
                    <option value="february">February</option>
                    <option value="march">March</option>
                    <option value="april">April</option>
                    <option value="may">May</option>
                    <option value="june">June</option>
                    <option value="july">July</option>
                    <option value="august">August</option>
                    <option value="september">September</option>
                    <option value="october">October</option>
                    <option value="november">November</option>
                    <option value="december">December</option>
                </select>
    </div>
    <div class="dropdown-containerhair">
                <select id="months" name="months">
                    <option value="january">Haircut</option>
                    <option value="january">Kiddie Haircut</option>
                    <option value="february">Haircut and Shave</option>
                    <option value="march">Hair Art</option>
                    <option value="april">Haircut and Perm</option>
                    <option value="may"> Hair Color</option>
                    <option value="june">Hair Color and Haircut</option>
                    <option value="july">Scalp Treatment</option>
                    <option value="august">Scalp Treatment and Haircut</option>
                    <option value="september">Shave and Sculpting</option>
                </select>
    </div>
    
    <main>
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
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th colspan="3">Feedbacks</th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Rating</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jone</td>
                            <td>10</td>
                            <td>Perfect</td>
                        </tr>
                        <tr>
                            <td>Beh</td>
                            <td>10</td>
                            <td>Pogi</td>
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
            </div>
        </main>
</body>
</html>
