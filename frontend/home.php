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
                    <div class="user-dropdown">
                        <a class="usericon" href="#"><i class="fa-solid fa-user"></i></a>
                        <div class="user-dropdown-content">
                        <li><a href="#">My Profile</a></li>
                        <li><a href="login.php">Logout</a></li>
                        </div>
                    </div>
                </div>
        </header>
        
        <a href="appointment.php"><button class="book-appointment-btn">BOOK AN APPOINTMENT</button></a>
        
                <?php if (isset($_SESSION['show_popup'])) : ?>
            <?php unset($_SESSION['show_popup']); // Unset the session variable after showing the popup ?>
            <div class="pop-background">
                <div class="popup" id="welcomePopup">
                    <p>Welcome,</p>
                    <p class="username"><?php echo $_SESSION['username']; ?>!</p>
                    <button class="popbutton" onclick="closePopup()"> Get Started </button>
                </div>
            </div>
        <?php endif; ?>
        <script>
            function closePopup() {
                var popup = document.getElementById('welcomePopup');
                popup.style.display = 'none';
            }
        </script>

        

    
            <!-- Barbers' Availability Section -->
        <div class="barbers-container">
            <h1 class="text">BARBERS' AVAILABILITY</h1>
        </div>

        <section class="availability">
    
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th><img src="design/image/Barber1.jpg" alt="Barber 1"></th>
                        <th><img src="design/image/barber 2.jpg" alt="Barber 2"></th>
                        <th><img src="design/image/Barber 3.jpg" alt="Barber 3"></th>
                        <th><img src="design/image/barber4.jpg" alt="Barber 4"></th>
                        <th><img src="design/image/barber5.jpg" alt="Barber 5"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>MONDAY</td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                    </tr>
                    <tr>
                        <td>TUESDAY</td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                    </tr>
                    <tr>
                        <td>WEDNESDAY</td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                    </tr>
                    <tr>
                        <td>THURSDAY</td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                    </tr>
                    <tr>
                        <td>FRIDAY</td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                    </tr>
                    <tr>
                        <td>SATURDAY</td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                        <td><i id="xmark" class="fa-solid fa-circle-xmark"></i></td>
                    </tr>
                    <tr>
                        <td>SUNDAY</td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                        <td><i id="check" class="fa-solid fa-circle-check"></i></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="buzzin-barber">
            <h2>BE A BUZZIN’ BARBER! <i>More Info</i></h2>
            <img src="design/image/stockphotos5.jpg" alt="Be Part of the Crew">
        </section>

        <!-- Stock Photos Section -->
        <section class="stock-photos">
            <h2>STOCK PHOTOS</h2>
            <div class="gallery">
                <img src="https://placehold.co/200x200" alt="Stock Photo 1">
                <img src="https://placehold.co/200x200" alt="Stock Photo 2">
                <img src="https://placehold.co/200x200" alt="Stock Photo 3">
                <img src="https://placehold.co/200x200" alt="Stock Photo 4">
                <img src="https://placehold.co/200x200" alt="Stock Photo 5">
            </div>
            <div class="appointment">
            <a href="appointment.php"><button>BOOK AN APPOINTMENT</button></a>

            </div>
        </section>

        <footer>
        <div class="footer-content">
            <div class="footer-left">
                <a href="aboutus.php"><img src="design/image/buzz.png" class="footer-logo" alt=""></a>
            </div>

            <div class="footer-left1">
                <h3>SIGN UP FOR NEWS AND PROMOS</h3>
                    <form>
                        <input type="email" placeholder="buzzandcollective@gmail.com">  
                        <button type="submit"><i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i></button>
                    </form>
                    <address>
                        <p><i class="fa-solid fa-location-dot" style="color: #ffffff;"></i> <a href="https://www.google.com/maps/place/Buzz+%26+Collective/@14.4412671,120.9296644,13z/data=!4m20!1m13!4m12!1m4!2m2!1d121.0417152!2d14.49984!4e1!1m6!1m2!1s0x3397d3fd93f7bdc5:0x776c208c818a1b77!2sbuzz+and+collective!2m2!1d120.9390436!2d14.4256597!3m5!1s0x3397d3fd93f7bdc5:0x776c208c818a1b77!8m2!3d14.4256826!4d120.9390514!16s%2Fg%2F11qb5sx_vm?entry=ttu"> 89 Nueno Ave, Imus Cavite, Imus, Philippines, 4103</a></p>
                        <p><i class="fa-solid fa-envelope" style="color: #ffffff;"></i> buzzandcollective@gmail.com</p>
                        <p><i class="fa-solid fa-phone" style="color: #ffffff;"></i> 0995 451 5631</p>
                    </address>
            </div>

            <div class="footer-right">
                <h3>BUZZ & COLLECTIVES</h3>
                <ul>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="#">Be a Buzzing Barber</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Services</a></li>
                </ul>
            </div>


            <div class="social-media">
                <a href="https://www.instagram.com/buzzncollective?igsh=NTk4eTR5dHBzMThi"><i class="fa-brands fa-instagram" style="color: #ffffff;"></i></a>
                <a href="https://www.facebook.com/buzzncollective"><i class="fa-brands fa-facebook-f" style="color: #ffffff;"></i></a>
                <a href="https://www.tiktok.com/@buzzncollective?_t=8mhQewDUUCI&_r=1"><i class="fa-brands fa-tiktok" style="color: #ffffff;"></i></a>
            </div>
        </div>
    </footer>
   
</body>
</html>