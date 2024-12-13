<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

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

// Fetch barbers' details from the database
$barbers = [];
$barber_query = "SELECT name, age, work, experience, position, image FROM barbers ORDER BY name";
$result = $db->query($barber_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $barbers[] = $row;
    }
} else {
    echo "<p class='error'>Error fetching barbers: " . $db->error . "</p>";
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="design/about.css">
    <link rel="stylesheet" href="design/barbersinfo.css">
    <link rel="stylesheet" href="design/founders_info.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <base href="https://buzzcollective.gayvar.com/frontend/">
    <title>About us</title>
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
                            <a href="aboutusland.php">ABOUT US</a>
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
     <section>
        <h5>Meet the <span>PRIDE</span> of Buzz&Collectives</h5>
        <div class="carousel">
            <?php if (!empty($barbers)): ?>
                <div class="list">
                    <?php foreach ($barbers as $barber): ?>
                        <div class="item" style="background-image: url('<?= htmlspecialchars($barber['image']) ?>');">
                            <div class="content">
                                <div class="title"><?= htmlspecialchars($barber['position']) ?></div>
                                <div class="name"><?= htmlspecialchars($barber['name']) ?></div>
                                <div class="des">
                                    <h4>Age: <span style="font-weight: 400"><?= htmlspecialchars($barber['age']) ?></span></h4>
                                    <h4>Work: <?= htmlspecialchars($barber['work']) ?></h4>
                                    <h4>Position: <?= htmlspecialchars($barber['position']) ?></h4>
                                    <h4>Years of Experience: <?= htmlspecialchars($barber['experience']) ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-news">No barbers available at the moment. Stay tuned!</p>
            <?php endif; ?>

            <!-- Next/Prev buttons -->
            <div class="arrows">
                <button class="prev"><</button>
                <button class="next">></button>
            </div>

            <!-- Time running -->
            <div class="timeRunning"></div>
        </div>
        <button class="barbers-button"><a href="appointment.php">BOOK AN APPOINTMENT</a></button>
    </section>

    
    <script>
    // Select DOM elements
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');
    const carousel = document.querySelector('.carousel');
    const list = document.querySelector('.list');
    const items = document.querySelectorAll('.item');

    let index = 0; // Index for tracking current slider position

    // Timing variables
    let timeRunning = 3000; 
    let timeAutoNext = 7000; 

    // Declare a global `runningTime` variable for animation
    let runningTime = document.createElement('div'); 
    runningTime.style.animation = 'runningTime 7s linear 1 forwards'; 
    document.body.appendChild(runningTime); // Temporarily added to the DOM

    // Event listeners for next and previous buttons
    if (nextBtn) {
        nextBtn.onclick = function () {
            showSlider('next');
        };
    }

    if (prevBtn) {
        prevBtn.onclick = function () {
            showSlider('prev');
        };
    }

    let runTimeOut; // Timeout for animation reset
    let runNextAuto = setTimeout(() => {
        nextBtn.click(); // Trigger next slider automatically
    }, timeAutoNext);

    // Function to reset the running time animation
    function resetTimeAnimation() {
        if (runningTime) {
            runningTime.style.animation = 'none'; // Clear the animation
            runningTime.offsetHeight; // Trigger a reflow
            runningTime.style.animation = 'runningTime 7s linear 1 forwards'; // Restart the animation
        }
    }

    // Function to handle slider transitions
    function showSlider(type) {
        let sliderItemsDom = list.querySelectorAll('.carousel .list .item');

        if (type === 'next') {
            list.appendChild(sliderItemsDom[0]); // Move first item to the end
            carousel.classList.add('next');
        } else {
            list.prepend(sliderItemsDom[sliderItemsDom.length - 1]); // Move last item to the front
            carousel.classList.add('prev');
        }

        // Clear the transition timeout
        clearTimeout(runTimeOut);

        runTimeOut = setTimeout(() => {
            carousel.classList.remove('next');
            carousel.classList.remove('prev');
        }, timeRunning);

        // Clear and reset the auto-next timer
        clearTimeout(runNextAuto);
        runNextAuto = setTimeout(() => {
            nextBtn.click(); // Trigger the next button click
        }, timeAutoNext);

        resetTimeAnimation(); // Reset the running time animation
    }
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
    <script src="landingscript.js"></script>
    <script src="script.js"></script>
    <script>
      jQuery(document).ready(function ($) {
        $(".slider-img").on("click", function () {
          $(".slider-img").removeClass("active");
          $(this).addClass("active");
        });
      });
    </script>

</body>
</html>