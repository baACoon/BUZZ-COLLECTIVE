<?php
session_start();

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
    <link rel="stylesheet" href="design/aboutushiring.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Be a Buzzin' Barber</title>
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
                        <li><a href="login.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

        <!-- SELECTION -->

         <!-- BG IMAGE -->
        <div class="hiring-cover"></div>

        <div class="v_9018">
            <h1>WE'RE LOOKING FOR BARBERS</h1>
        </div>

        <div class="overview">
            <h1>POSITION OVERVIEW</h1>
            <h2>We are seeking an experienced barber to join our dynamic team. 
                The ideal candidate will have a passion for the craft, exceptional customer service skills, 
                and the ability to work well in a fast-paced environment.</h2>
        </div>

        <div class="key-respo">
            <h1>KEY RESPONSIBILITIES</h1>
            <ul>
                <li>Provide a variety of barbering services to different clients</li>
                <li>Consult with clients to understand their needs and provide expert advice.</li>
                <li>Maintain a clean and organized work station.</li>
                <li>Follow all health and safety regulations.</li>
                <li>Stay updated on the latest barbering trends and techniques.</li>
                <li>Build and maintain a loyal client base</li>
            </ul>
            
        </div>

        <div class="quali">
            <h1>QUALIFICATIONS</h1>
            <ul>
                <li>Proven experience as a barber.</li>
                <li>Strong communication and customer service skills.</li>
                <li>Ability to work flexible hours, including weekends.</li>
                <li>A team player with a positive attitude.</li>
                <li>Up-to-date knowledge of barbering trends and techniques.</li>
            </ul>
        </div>

        <div class="offer">
            <h1>WHAT WE OFFER</h1>
            <ul>
                <li>Competitive salary and tips.</li>
                <li>Flexible working hours.</li>
                <li>Professional development and training opportunities.</li>
                <li>A supportive and friendly work environment.</li>
                <li>Opportunities for career growth.</li>
            </ul>
        </div>

        <div class="apply">
            <h1>HOW TO APPLY</h1>
            <p>Interested applicants are encouraged to send their resume and a brief 
                cover letter to buzzandcollective@gmail.com or drop by any branches to 
                fill out an application.</p>
        </div>

        <div  class ="v_123">
            <p>WE LOOK FORWARD TO MEETING YOU</p>
        </div>





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