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
    <title>Buzz & Collective | Home</title>
</head>
<body>

        <header id="mainheader">
       
                <img src="design/image/buzz.png" alt="">
                <div class="buttons">
                    <a href="home.php">HOME </a>
                    <div class="dropdown">
                        <a class="dropbtn" href="aboutus.php">ABOUT US <i class="fa-solid fa-chevron-down"></i> </a>
                        <div class="dropdown-content">
                            <li><a href="aboutus.php">About us</a></li>
                            <li><a href="#">Barbers</a></li>
                        </div>
                    </div>
                    <a href="#">SERVICES</a>
                    <a href="#">PRODUCTS </a>
                    <a class="usericon" href=""><i class="fa-solid fa-user"></i></a>

                </div>
        </header>
        
        <a href="appointment.php"><button class="book-appointment-btn">BOOK AN APPOINTMENT</button></a>


        
        <?php if (isset($_SESSION['show_popup'])) : ?>
            <div class="popup" id="welcomePopup">
                <p>Welcome to <i>Buzzin' Collective,</i></p>
                <p class ="username"><?php echo $_SESSION['username']; ?>!</p>
                <p>You are now logged in. </p>
                <button class="popbutton" onclick="closePopup()">Close</button>
            </div>
            <script>
                function closePopup() {
                    var popup = document.getElementById('welcomePopup');
                    popup.style.display = 'none';
                    <?php unset($_SESSION['show_popup']); // Unset the session variable after showing the popup ?>
                }

                window.onload = function() {
                    var popup = document.getElementById('welcomePopup');
                    popup.style.display = 'block';
                }
            </script>
        <?php endif; ?>

        

</body>
        <div class="barbers-container">
            <h1 class="text">BARBERS' AVAILABILITY</h1>
            <div class="barbers">
                <img src="design/image/Barber1.jpg" alt="">
                <img src="design/image/barber 2.jpg" alt="">
                <img src="design/image/Barber 3.jpg" alt="">
                <img src="design/image/barber4.jpg" alt="">
                <img src="design/image/barber5.jpg" alt="">
            </div>
        </div>

        <div class="days">
            <div class="day">
            <h1>MONDAY</h1>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            </div>
            <div class="day">
            <h1>TUESDAY</h1>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="day">
            <h1>WEDNESDAY</h1>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            </div>
            <div class="day">
            <h1>THURSDAY</h1>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            </div>
            <div class="day">
            <h1>FRIDAY</h1>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            </div>
            <div class="day">
            <h1>SATURDAY</h1>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            <i id="xmark" class="fa-solid fa-circle-xmark"></i>
            </div>
            <div class="day">
            <h1>SUNDAY</h1>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            <i id="check" class="fa-solid fa-circle-check"></i>
            </div>
        </div>


        <footer>
            <div class="footer-container">
                <div class="footer-section">
                <img src="design/image/buzz.png" alt="">

                </div>

            </div>
        </footer>
</html>