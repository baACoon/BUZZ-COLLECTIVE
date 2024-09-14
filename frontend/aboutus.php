<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Database connection
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

// Fetch the user's profile image from the database
$profile_image = 'design/image/default-placeholder.png'; // Default placeholder image path

$sql = "SELECT profile_image FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($profile_image_path);
    $stmt->fetch();
    $stmt->close();

    if ($profile_image_path) {
        $profile_image = $profile_image_path; // Use the saved image if available
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/about.css">
    <link rel="stylesheet" href="design/barbersinfo.css">
    <link rel="stylesheet" href="design/founders_info.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>About us</title>
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
                        <li><a href="aboutus.php">Buzz & Collectives</a></li>
                        <li><a href="aboutushiring.php">Be a Buzzing Barber</a></li>
                    </ul>
                </li>
                <li><a href="branches.php">Branches</a></li>
                <li><a href="services.php">Services</a></li>
                <li>
                    <a class="usericon" href="#">
                        <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="User Profile Image" class="profile-img-header">
                    </a>
                    <ul class="submenu">
                        <li><a href="myprofile.php">My Profile</a></li>
                        <li><a href="../backend/logout.php">Logout</a></li> <!-- Link to Logout -->
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div id="body-container">
        <img src="design/image/buzz.png" class="logo-body" alt="">
        <p>Buzz & Collectives is more than just a barbershop—it's a dynamic concept store where craftsmanship meets community. Experience top-notch grooming services alongside curated selections of lifestyle products, fostering a vibrant space where style and culture intersect.</p>
    </div>  

    <div class="buzzing_container">
        <h3>Founders</h3>
        <h2>Monti & Comia started</h2>
        <h4><i>BUZZING</i></h4>
        <p>
            In <b>May 2022</b>, Akira Gata and Monti Comia established Buzz&Collectives just as Cavite City was still recovering from the aftermath of the COVID-19 pandemic. The team’s commitment to maintain strict safety measures built the trust with the clients.
        </p>
            <div class="v105_40">
                <img src="design/image/Monti_comia.png" alt="">
            </div>
            <div class="v105_38">
                <img src="design/image/Akira_Gata.png" alt="">
            </div>
        <div class="name1">
            <h3> Monti Comia </h3>
        </div>
        <div class="name2">
            <h3> Akira Gata </h3>
        </div>
        
    </div>

     <!-- BARBERS INFO SELECTION -->
     <h5>Meet the <span>PRIDE</span> of Buzz&Collectives</h5>
     <section class="slider-container">
      <div class="slider-images">
        <div class="slider-img">
          <img src="design/image/Barber1.jpg" alt="1" />
          <h1>Andre</h1>
          <div class="details">
            <h2>Andre</h2>
            <p>MANG BARBER</p>
          </div>
        </div>
        <div class="slider-img">
          <img src="design/image/barber 2.jpg" alt="2" />
          <h1>Drey</h1>
          <div class="details">
            <h2>Drey</h2>
            <p>MANG BARBER</p>
          </div>
        </div>
        <div class="slider-img">
          <img src="design/image/Barber 3.jpg" alt="3" />
          <h1>Jeremy</h1>
          <div class="details">
            <h2>Jeremy</h2>
            <p>MANG BARBER</p>
          </div>
        </div>
        <div class="slider-img active">
          <img src="design/image/barber4.jpg" alt="4" />
          <h1>Donie</h1>
          <div class="details">
            <h2>Donie</h2>
            <p>MANG BARBER</p>
          </div>
        </div>
        <div class="slider-img">
          <img src="design/image/barber5.jpg" alt="5" />
          <h1>Vien</h1>
          <div class="details">
            <h2>Vien</h2>
            <p>MANG BARBER</p>
          </div>
        </div>

      </div>
    </section>

    <button class="barbers-button"><a href="appointment.php">BOOK AN APPOINTMENT </a></button> <br>

    
    <script src="script.js"></script>
    <script>
      jQuery(document).ready(function ($) {
        $(".slider-img").on("click", function () {
          $(".slider-img").removeClass("active");
          $(this).addClass("active");
        });
      });
    </script>

   
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
    <script src="scripts.js"></script>
</body>
</html>