<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Designs/adminbarber.css">
    <title>Barber Schedule</title>
</head>
<body>
    <main>
        <header>
            <nav class="top-nav">
                <a href="#">Dashboard</a>
                <a href="#">Profile</a>
                <a href="#">Notification <span class="notification-dot"></span></a>
            </nav>
        </header>
    </main>
   
    <div class="sidebar">
        <div class="logo">
            <img src="images/BUZZ-White.png"  alt="logo">

        </div>
        <nav>
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="#">Barber Schedule</a></li>
                <li><a href="">News and Events</a></li>
                <li><a href="">About us</a></li>
                <li><a href="#">Appointment Bookings</a></li>
                <li><a href="#">Settins</a></li>
                <li><a href="#">Reports and Analytics</a></li>
                <li><a href="admin-home.php">Logout</a></li>
            </ul>
        </nav>
    </div>
  
    <div class="dropdown-container">
            <label for="months">This Month</label>
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
    
    <div class="container">
        <button class="btn edit-btn"><a href="#">Edit</a></button>
        <button class="btn save-btn"><a href="#">Save</a></button>
        <div class="barbers-header">
            <h1>BARBERS' AVAILABILITY</h1>
            <h1 class="date">(APRIL 22 - 28, 2024)</h1>
            <a href="#"><i class="fa-regular fa-pen-to-square" style="color: #000000;"></i></a>
        </div>

        <div class="barbers">
            <div class="barber-container">
                <img src="images/Barber1.jpg" alt="">
                <div class="checkbox-container">
                    <input type="checkbox" id="monday1">
                    <input type="checkbox" id="tuesday1">
                    <input type="checkbox" id="wednesday1">
                    <input type="checkbox" id="thursday1">
                    <input type="checkbox" id="friday1">
                    <input type="checkbox" id="saturday1">
                    <input type="checkbox" id="sunday1">
                </div>
            </div>

            <div class="barber-container">
                <img src="images/barber 2.jpg" alt="">
                <div class="checkbox-container">
                    <input type="checkbox" id="monday1">
                    <input type="checkbox" id="tuesday1">
                    <input type="checkbox" id="wednesday1">
                    <input type="checkbox" id="thursday1">
                    <input type="checkbox" id="friday1">
                    <input type="checkbox" id="saturday1">
                    <input type="checkbox" id="sunday1">
                </div>
            </div>

            <div class="barber-container">
                <img src="images/barber 3.jpg" alt="">
                <div class="checkbox-container">
                    <input type="checkbox" id="monday1">
                    <input type="checkbox" id="tuesday1">
                    <input type="checkbox" id="wednesday1">
                    <input type="checkbox" id="thursday1">
                    <input type="checkbox" id="friday1">
                    <input type="checkbox" id="saturday1">
                    <input type="checkbox" id="sunday1">
                </div>
            </div>

            <div class="barber-container">
                <img src="images/barber4.jpg" alt="">
                <div class="checkbox-container">
                    <input type="checkbox" id="monday1">
                    <input type="checkbox" id="tuesday1">
                    <input type="checkbox" id="wednesday1">
                    <input type="checkbox" id="thursday1">
                    <input type="checkbox" id="friday1">
                    <input type="checkbox" id="saturday1">
                    <input type="checkbox" id="sunday1">
                </div>
            </div>

            <div class="barber-container">
                <img src="images/barber5.jpg" alt="">
                <div class="checkbox-container">
                    <input type="checkbox" id="monday1">
                    <input type="checkbox" id="tuesday1">
                    <input type="checkbox" id="wednesday1">
                    <input type="checkbox" id="thursday1">
                    <input type="checkbox" id="friday1">
                    <input type="checkbox" id="saturday1">
                    <input type="checkbox" id="sunday1">
                </div>
            </div>
        </div>

        <ul class="schedule">
            <li>Monday</li>
            <li>Tuesday</li>
            <li>Wednesday</li>
            <li>Thursday</li>
            <li>Friday</li>
            <li>Saturday</li>
            <li>Sunday</li>
        </ul>

    </div>
   

</body>
</html>
