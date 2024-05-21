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
                <p>Welcome,</p>
                <p class ="username"><?php echo $_SESSION['username']; ?>!</p>
                <button class="popbutton" onclick="closePopup()">Get Started</button>
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
                <h2>BUZZ & COLLECTIVES</h2>
                <p>SIGN UP FOR NEWS AND PROMOS</p>
                <form>
                    <input type="email" placeholder="buzzandcollective@gmail.com">
                    <button type="submit">→</button>
                </form>
                <address>
                    <p>89 Nueno Ave, Imus Cavite, Imus, Philippines, 4103</p>
                    <p>buzzandcollective@gmail.com</p>
                    <p>0995 451 5631</p>
                </address>
                <div class="social-media">
                    <a href="#"><img src="https://placehold.co/24x24" alt="Facebook"></a>
                    <a href="#"><img src="https://placehold.co/24x24" alt="Instagram"></a>
                    <a href="#"><img src="https://placehold.co/24x24" alt="TikTok"></a>
                </div>
            </div>
            <div class="footer-right">
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Be a Buzzing Barber</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Services</a></li>
                </ul>
            </div>
        </div>
    </footer>

</html>