<?php


/* Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];*/

// Database connection
$db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

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

// Load services data
$branchesFile = json_decode(file_get_contents('../frontend/admin/data/branches.json'), true);
$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="design/branches.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Branches</title>
</head>
<body>
    <nav>
        <div class="navbar">
            <i class='bx bx-menu'></i>
            <div class="logo">
		        <a href="home.php"><img src="design/image/BUZZ-Black.png"></a>
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
                                    <i class='bx bxs-chevron-down htmlcss-arrow profile-arrow'></i> 
                                </a>
                                <ul class="htmlCss-sub-menu profile-sub-menu">
                                    <li><a href="myprofile.php">My Profile</a></li>
                                    <li><a href="../backend/logout.php">Logout</a></li> 
                                </ul>
                            </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <button class="bookus-button"><a href="appointment.php">Book Now</a></button>

    <div class="container">
        <div class="buzz-logo">
            <!-- Main Branch -->
            <a href="#"><img src="design/image/BUZZ-Black.png" alt="Logo"></a>
            <div class="branch">
                <h3>Main Branch</h3>
                <a href="https://www.google.com/maps/place/Buzz+%26+Collective/@14.4412671,120.9296644,13z/data=!4m20!1m13!4m12!1m4!2m2!1d121.0417152!2d14.49984!4e1!1m6!1m2!1s0x3397d3fd93f7bdc5:0x776c208c818a1b77!2sbuzz+and+collective!2m2!1d120.9390436!2d14.4256597!3m5!1s0x3397d3fd93f7bdc5:0x776c208c818a1b77!8m2!3d14.4256826!4d120.9390514!16s%2Fg%2F11qb5sx_vm?entry=ttu">
                    <p>89 Nueno Ave, Imus Cavite, Imus, Philippines, 4103</p>
                </a>
            </div>
        </div>  

        <div class="otherbranch">
            <h3 id="toggleBranches" style="cursor: pointer;">Other Branches</h3>
            <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
        </div>

        <!-- Other Branches (Initially hidden) -->
        <div id="otherBranches" style="display: none;">
            <?php foreach ($branchesFile as $branch): ?>
                <div class="buzz-logo"> <!-- Add this wrapper to align correctly -->
                    <a href="#"><img src="design/image/BUZZ-Black.png" alt="Logo"></a>
                    <div class="branch">
                        <h3><?php echo htmlspecialchars($branch['branchName']); ?></h3>
                        <p><?php echo htmlspecialchars($branch['branchLocation']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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
          <a href="https://www.tiktok.com/@buzzncollective?_t=8mhQewDUUCI&_r=1"><i class="fa-brands fa-tiktok" style="color: #ffffff;"></i></a>
          <a href="https://www.facebook.com/buzzncollective"><i class="fa-brands fa-facebook-f" style="color: #ffffff;"></i></a>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="landingscript.js"></script>
    <script>
        document.getElementById('toggleBranches').addEventListener('click', function() {
            var otherBranches = document.getElementById('otherBranches');
            var arrow = document.querySelector('.arrow');
            if (otherBranches.style.display === "none") {
                otherBranches.style.display = "block"; // Show the branches
                arrow.classList.add('rotate');
            } else {
                otherBranches.style.display = "none"; // Hide the branches
                this.textContent = "Other Branches"; // Change button text back
                arrow.classList.remove('rotate');
            }
        });
    </script>
</body>
</html>