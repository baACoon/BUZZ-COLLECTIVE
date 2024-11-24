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

// Load services data
$services = json_decode(file_get_contents('../frontend/admin/data/services.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="design/services.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <title>Services</title>
</head>
<body>
    <nav>
        <div class="navbar">
            <i class='bx bx-menu'></i>
            <div class="logo">
		        <a href="landingpage.php"><img src="design/image/BUZZ-Black.png"></a>
	        </div>
                <div class="nav-links">
                    <div class="sidebar-logo">
                        <a href="home.php">
                            <img src="design/image/BUZZ-Black.png">
                        </a>
                        <i class='bx bx-x' ></i>
                    </div>
                    <ul class="links">
                        <li><a href="home.php">HOME</a></li>
                        <li>
                            <a href="#">ABOUT US</a>
                            <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
                            <ul class="htmlCss-sub-menu sub-menu">
                                <li><a href="aboutus.php">Buzz & Collectives</a></li>
                                <li><a href="aboutushiring.php">Be a Buzzing Barber</a></li>
                            </ul>
                        </li>
                            <li><a href="branches.php">BRANCHES</a></li>
                            <li><a href="services.php">SERVICES</a></li>
                            <li>
                                <a class="usericon" href="myprofile.php">
                                    <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="User Profile Image" class="profile-img-header">
                                    <i class='bx bxs-chevron-down htmlcss-arrow profile-arrow'></i> <!-- Arrow icon same as ABOUT US -->
                                </a>
                                <ul class="htmlCss-sub-menu profile-sub-menu">
                                    <li><a href="myprofile.php">My Profile</a></li>
                                    <li><a href="../backend/logout.php">Logout</a></li> <!-- Link to Logout -->
                                </ul>
                            </li>
                    </ul>
                </div>
        </div>
    </nav>

    <div class="services-logo">
        <img src="design/image/SERVICE-transparent.png" alt="">
        <h3>All Branches</h3>
    </div>  
    <?php foreach ($services as $service) : ?>
        <div class="container">
            <div class="service-details">
                <h3><?= htmlspecialchars($service['name']); ?></h3>
                <?php if (!empty($service['with'])) : ?>
                    <p><?= htmlspecialchars($service['with']); ?></p>
                <?php endif; ?>
                <h5 class="price">PHP <?= number_format($service['fee']); ?></h5>
            </div>
        </div>
    <?php endforeach; ?>

       <!-- Haircuts Section -->
       <div class="haircuts-section">
        <h1>Haircuts</h1> 
        
        <!-- Display the first 3 images -->
        <div class="haircut-images">
            <div class="haircut-item">
                <img src="design/image/services-haircut1.jpeg" alt="Haircut 1">
                <p class="haircut-name">Mid Fade x Textured Fringe</p> 
            </div>
            <div class="haircut-item">
                <img src="design/image/services-haircut2.jpeg" alt="Haircut 2">
                <p class="haircut-name">Low Taper Fade x Textured Fringe</p> 
            </div>
            <div class="haircut-item">
                <img src="design/image/services-haircut3.jpeg" alt="Haircut 3">
                <p class="haircut-name">Low Taper Fringe</p> 
            </div>
        </div>

        <!-- "See More" link -->
        <a href="javascript:void(0);" class="see-more-link" onclick="showMoreImages()">See More</a>

        <!-- Display hidden images (initially hidden) -->
        <div class="additional-images" style="display: none;">
        
            <div class="haircut-item">
                <img src="design/image/services-haircut5.jpeg" alt="Haircut 5">
                <p class="haircut-name">Blowout Taper</p>
            </div>
            <div class="haircut-item">
                <img src="design/image/services-haircut6.jpeg" alt="Haircut 6">
                <p class="haircut-name">Mid Taper x Crop</p>
            </div>

            <div class="haircut-item">
                <img src="design/image/services-haircut7.jpeg" alt="Haircut 7">
                <p class="haircut-name">Short Mullet Textured Fringe</p>
            </div>
            <div class="haircut-item">
                <img src="design/image/services-haircut8.jpeg" alt="Haircut 8">
                <p class="haircut-name">Low Taper Fade</p> 
            </div>
            <div class="haircut-item">
                <img src="design/image/services-haircut9.jpeg" alt="Haircut 9">
                <p class="haircut-name">Mid Fade</p>
            </div>

            <div class="haircut-item">
                <img src="design/image/services-haircut10.jpeg" alt="Haircut 10">
                <p class="haircut-name">Mid Burst Fade</p> 
            </div>
            <div class="haircut-item">
                <img src="design/image/services-haircut11.jpeg" alt="Haircut 11">
                <p class="haircut-name">Mid Fade x Textured Fringe</p> 
            </div>
            <div class="haircut-item">
                <img src="design/image/services-haircut12.jpeg" alt="Haircut 12">
                <p class="haircut-name">Jay Jo Mullet x Textured Fringe</p> 
            </div>
        </div>
    </div>



    <div class="button-container">
        <button class="bookus-button"><a href="appointment.php">Book Now</a></button>
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
                    <li><a href="aboutushiring.php">Be a Buzzing Barber</a></li>
                    <li><a href="branches.php">Branches</a></li>
                    <li><a href="services.php">Services</a></li>
                </ul>
            </div>

            <div class="social-media">
                <a href="https://www.instagram.com/buzzncollective?igsh=NTk4eTR5dHBzMThi"><i class="fa-brands fa-instagram" style="color: #ffffff;"></i></a>
                <a href="https://www.facebook.com/buzzncollective"><i class="fa-brands fa-facebook-f" style="color: #ffffff;"></i></a>
                <a href="https://www.tiktok.com/@buzzncollective?_t=8mhQewDUUCI&_r=1"><i class="fa-brands fa-tiktok" style="color: #ffffff;"></i></a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../frontend/js/landingscript.js"></script>
    <script>
        function showMoreImages() {
            var additionalImages = document.querySelector('.additional-images');
            var seeMoreLink = document.querySelector('.see-more-link');
            
            // Toggle visibility of additional images
            if (additionalImages.style.display === 'none' || additionalImages.style.display === '') {
                additionalImages.style.display = 'grid';  // Show the images
                seeMoreLink.textContent = 'See Less'; // Change text to 'See Less'
            } else {
                additionalImages.style.display = 'none'; // Hide the images
                seeMoreLink.textContent = 'See More'; // Change text back to 'See More'
            }
        }
    </script>
</body>
</html>