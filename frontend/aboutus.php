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
    echo "Error fetching barbers: " . $db->error;
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
    <link rel="stylesheet" href="design/about.css?v=1.0">
    <link rel="stylesheet" href="design/barbersinfo.css?v=1.0">
    <link rel="stylesheet" href="design/founders_info.css?v=1.0">
    <link rel="stylesheet" href="design/transitions/aboutus_transition.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <base href="https://buzzcollective.gayvar.com/Buzz-collective/frontend/">
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
                            <a href="aboutus.php">ABOUT US</a>
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
        <!-- Images Section -->
        <div class="images">
            <div class="image-wrapper">
                <img src="design/image/Monti_Comia.png" alt="Monti Comia">
                <span class="label">Monti Comia</span>
            </div>
            <div class="image-wrapper">
                <img src="design/image/Akira_Gata.png" alt="Akira Gata">
                <span class="label">Akira Gata</span>
            </div>
        </div>

        <!-- Text Section -->
        <div class="text-content">
            <h3>Founders</h3>
            <h2>Monti & Comia started</h2>
            <h1><i>BUZZING</i></h1>
            <p>
                In <b>May 2022</b>, Akira Gata and Monti Comia established Buzz&Collectives just as Cavite City was still recovering from the aftermath of the COVID-19 pandemic. The team’s commitment to maintaining strict safety measures built trust with their clients.
            </p>
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
                <a href="aboutus.php"><img src="design/image/buzz.png" class="footer-logo" alt="Footer Logo"></a>
            </div>
            <div class="footer-left1">
                <h3>SIGN UP FOR NEWS AND PROMOS</h3>
                <form>
                    <input type="email" placeholder="buzzandcollective@gmail.com">
                    <button type="submit">
                        <i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i>
                    </button>
                </form>
                <address>
                    <p>
                        <i class="fa-solid fa-location-dot" style="color: #ffffff;"></i>
                        <a href="https://www.google.com/maps/place/Buzz+%26+Collective/...">89 Nueno Ave, Imus Cavite</a>
                    </p>
                    <p><i class="fa-solid fa-envelope" style="color: #ffffff;"></i> buzzandcollective@gmail.com</p>
                    <p><i class="fa-solid fa-phone" style="color: #ffffff;"></i> 0995 451 5631</p>
                </address>
            </div>
            <div class="footer-right">
                <h3>BUZZ & COLLECTIVES</h3>
                <ul>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="aboutushiring.php">Be a Buzzin Barber</a></li>
                    <li><a href="branches.php">Branches</a></li>
                    <li><a href="services.php">Services</a></li>
                </ul>
            </div>
            <div class="social-media">
                <a href="https://www.instagram.com/buzzncollective"><i class="fa-brands fa-instagram" style="color: #ffffff;"></i></a>
                <a href="https://www.facebook.com/buzzncollective"><i class="fa-brands fa-facebook-f" style="color: #ffffff;"></i></a>
                <a href="https://www.tiktok.com/@buzzncollective"><i class="fa-brands fa-tiktok" style="color: #ffffff;"></i></a>
            </div>
        </div>
    </footer>
    
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
    <script>
      jQuery(document).ready(function ($) {
        $(".slider-img").on("click", function () {
          $(".slider-img").removeClass("active");
          $(this).addClass("active");
        });
      });

        // sidebar open close js code
        let navLinks = document.querySelector(".nav-links");
        let menuOpenBtn = document.querySelector(".navbar .bx-menu");
        let menuCloseBtn = document.querySelector(".nav-links .bx-x");

        menuOpenBtn.onclick = function() {
        navLinks.classList.add("show");
        };

        menuCloseBtn.onclick = function() {
        navLinks.classList.remove("show");
        };

        // sidebar submenu open close js code
        let htmlcssArrow = document.querySelector(".htmlcss-arrow");
        htmlcssArrow.onclick = function() {
        navLinks.classList.toggle("show1");
        }

        document.addEventListener("DOMContentLoaded", function () {
            const buzzingContainer = document.querySelector(".buzzing_container");
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Add the visible class when in viewport
                            entry.target.classList.add("visible");
                        } else {
                            // Remove the visible class when out of viewport (optional)
                            entry.target.classList.remove("visible");
                        }
                    });
                },
                {
                    threshold: 0.1, // Trigger when 10% of the element is visible
                }
            );

            // Observe the container
            observer.observe(buzzingContainer);
});


    </script>

</body>
</html>