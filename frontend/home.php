<?php
session_start();


if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Database connection
$db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

// Calculate the start (Monday) and end (Friday) of the current week
$startDate = date('Y-m-d', strtotime('monday this week'));
$endDate = date('Y-m-d', strtotime('sunday this week'));


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


// Fetch news from the database
$news = [];
$result = $db->query("SELECT * FROM news ORDER BY created_at DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
} else {
    echo "<p class='error'>Error fetching news: " . $db->error . "</p>";
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
    <link rel="stylesheet" href="design/home.css">
    <link rel="stylesheet" href="design/popup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <base href="https://buzzcollective.gayvar.com/Buzz-collective/frontend/">
    <title>Buzz & Collective | Home</title>
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

            <div class="bgimage">
            </div>
            <div class="v79368">
                <span class="day">OPEN MONDAY - SUNDAY</span> <br>
                <span class="time">9:00AM - 9:00PM</span>  <br> 
                <button class="appntmnt-button"><a href="appointment.php">BOOK AN APPOINTMENT </a></button> <br>
                <span class="text">We also accepts walk-ins!</span>             
            </div>
            <!-- NEWS SELECTION -->
            <section class="body-cont">
                <h1>NEWS AND DISCOUNTS</h1>
                <?php if (!empty($news)): ?>
                    <div class="news-container">
                        <?php foreach ($news as $item): ?>
                            <div class="news-item">
                                <div class="news-image">
                                    <?php if (!empty($item['poster'])): ?>
                                        <img src="<?= htmlspecialchars($item['poster']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                                    <?php else: ?>
                                        <img src="design/image/default-placeholder.png" alt="Default Image">
                                    <?php endif; ?>
                                </div>
                                <div class="news-details">
                                    <h2><?= htmlspecialchars($item['title']) ?></h2>
                                    <h3><?= htmlspecialchars($item['subtitle']) ?></h3>
                                    <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-news">No news available at the moment. Stay tuned!</p>
                <?php endif; ?>
            </section>


            <!-- Barbers' Availability Section -->
            <section class="barber-selection">
                <!-- Barbers' IMAGE -->
                <div class="barber-sched-img">
                    <img src="design/image/SCHEDULE.png" alt="">
                </div>

                <!-- Barbers' DAYS and Availability Section -->
                <div class="barber-months">
                <h1 class="date">(<?php echo date('F j', strtotime($startDate)) . ' - ' . date('F j, Y', strtotime($endDate)); ?>)</h1>
                </div>
                <div id="availability"></div> <!-- Dito for displaying lang din db to client side and vice versa-->

                <button class="barber-button"><a href="appointment.php">BOOK AN APPOINTMENT</a></button><br>
            </section>
              <!-- BUZZIN  -->
              <section class="buzzin-barber" id="buzzbarber">
                <h1>BE A BUZZIN' BARBER!</h1>
                <div class="buzzin-img" id="buzzimg">
                    <img src="design/image/stockphotos5.png" alt="Buzzin Barber">
                </div>
                <h2>SERVE THE COMMUNITY WITH SOME FRESH LOOKS!</h2>
                <a href="../frontend/aboutushiring.php">More Info</a>
            </section>

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


            <script >
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
            </script>
            <!--SCRIPT TO SA PAG DISPLAY NG BARBER SA HOME-->
            <script> //note: hindi functionable yung (April 22 chuchu)
                document.addEventListener('DOMContentLoaded', function() {
                const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                const urlParams = new URLSearchParams(window.location.search);
                const startDate = urlParams.get('start_date') || '';
                const endDate = urlParams.get('end_date') || '';

                fetch('../frontend/fetch_availability.php')
        .then(response => response.json())
        .then(data => {
            const availabilityDiv = document.getElementById('availability');
            
            if (data.length > 0) {
                // Initialize barbers by day for available barbers only
                const availableBarbersByDay = {};
                daysOfWeek.forEach(day => {
                    availableBarbersByDay[day] = [];
                });

                // Group only available barbers by day
                data.forEach(entry => {
                    const date = new Date(entry.date);
                    const dayName = daysOfWeek[date.getDay() === 0 ? 6 : date.getDay() - 1];
                    if (dayName && entry.is_available) {  // Only add if barber is available
                        availableBarbersByDay[dayName].push(entry.barber_name);
                    }
                });

                // Build HTML for each day
                let html = '';
                daysOfWeek.forEach(day => {
                    html += `<div class="day-row">
                        <strong>${day}:</strong>
                        <div class="barbers-row">`;

                    const availableBarbers = availableBarbersByDay[day];

                    if (availableBarbers.length > 0) {
                        availableBarbers.forEach(barber => {
                            html += `<span class="barber available">${barber}</span>`;
                        });
                    } else {
                        html += `<span class="no-barbers">No barbers available</span>`;
                    }

                    html += '</div></div>'; // Close barbers-row and day-row
                });


                availabilityDiv.innerHTML = html;
            } else {
                availabilityDiv.textContent = "No availability data found for the current week.";
            }
        })
        .catch(error => {
            console.error('Error fetching availability data:', error);
            document.getElementById('availability').textContent = "Failed to load availability data.";
        });
            });

            </script>

</body>
</html>