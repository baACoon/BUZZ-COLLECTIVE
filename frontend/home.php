<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/home.css">
    <link rel="stylesheet" href="design/popup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="frontend/usericon.js" defer></script>
    <title>Buzz & Collective | Home</title>
</head>
<body>
<header id="mainheader">
            <div class="logo">
                <a href="#"><img src="design/image/BUZZ-Black.png" alt="Logo"></a>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a>
                        <ul class="submenu">
                            <li><a href="#">Buzz & Collectives</a></li>
                            <li><a href="aboutus.php">Be a Buzzing Barber</a></li>
                        </ul>
                    </li>
                    <li><a href="branches.php">Branches</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a class="usericon" href="#"><i class="fa-solid fa-user"></i></a>
                        <ul class="submenu">
                            <li><a href="#">My Profile</a></li>
                            <li><a href="login.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>

            <?php if (isset($_SESSION['show_popup'])) : ?>
                <?php unset($_SESSION['show_popup']); // Unset the session variable after showing the popup ?>
                <div class="pop-background" id="popBackground">
                    <div class="popup" id="welcomePopup">
                        <p>Welcome,</p>
                        <p class="username"><?php echo $_SESSION['username']; ?>!</p>
                        <button class="popbutton" onclick="closePopup()">Get Started</button>
                    </div>
                </div>
            <?php endif; ?>
        <script>
            function closePopup() {
                var background = document.getElementById('popBackground');
                background.style.display = 'none';
            }
        </script>

            <!-- Barbers' Availability Section -->

            <div>
                <img src="design/image/SCHEDULE.png" alt="">
            </div>
        

        
</body>
</html>