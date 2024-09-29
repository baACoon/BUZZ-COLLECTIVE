<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

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
    <link rel="stylesheet" href="design/home.css">
    <link rel="stylesheet" href="design/popup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <title>Buzz & Collective | Home</title>
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
                <div class="image1"></div>
                <div class="image2"></div>

            </section>
            <!-- Barbers' Availability Section -->
            <section class="barber-selection">
                <!-- Barbers' IMAGE -->
                <div class="barber-sched-img">
                    <img src="design/image/SCHEDULE.png" alt="">
                </div>
                <!-- Barbers' MONTHS -->
                <span class="barber-months">(APRIL 22 - 28, 2024)</span>
                <!-- Barbers' DROPDOWN -->
                <div class="barber-dropdown">
                    <select id="location" name="Branch">
                        <option value="Imus branch">Imus Branch</option>
                        <option value="Salitran">Salitran Branch</option>
                    </select>
                </div>
                <!-- Barbers' DAYS and Availability Section -->
                <div id="date-range"></div>
                <div id="availability"></div> <!-- Dito for displaying lang din db to client side and vice versa-->

                <button class="barber-button"><a href="appointment.php">BOOK AN APPOINTMENT</a></button><br>
            </section>
              <!-- BUZZIN  -->
            <section class="buzzin-barber" id="buzzbarber"> 
                <h1>BE A BUZZIN' BARBER!</h1>
                <div class="buzzin-img" id="buzzimg">
                    <img src="design/image/stockphotos5.png" alt="">
                </div>
                <h2>SERVE THE COMMUNITY WITH SOME FRESH LOOKS!</h2>
                <a href="">More Info</a>
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

            <!--SCRIPT TO SA PAG DISPLAY NG BARBER SA HOME-->
            <script> //note: hindi functionable yung (April 22 chuchu)
                document.addEventListener('DOMContentLoaded', function() {
                const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                const urlParams = new URLSearchParams(window.location.search);
                const startDate = urlParams.get('start_date') || '';
                const endDate = urlParams.get('end_date') || '';

                // Fetch availability data from the server
                fetch(`fetch_availability.php`)
                    .then(response => response.json())
                    .then(data => {
                        const availabilityDiv = document.getElementById('availability');

                        if (data.length > 0) {
                            // Initialization sa barbers by day 
                            const availableBarbersByDay = {
                                'Monday': [],
                                'Tuesday': [],
                                'Wednesday': [],
                                'Thursday': [],
                                'Friday': []
                            };

                            // Iterate over the fetched data and group barbers by day
                            data.forEach(entry => {
                                const dayName = daysOfWeek[new Date(entry.date).getDay()-1];                                                  // Get the day of the week
                                if (dayName && entry.is_available) {                                                                            // Ensure barber is available and day is within Monday to Friday
                                    availableBarbersByDay[dayName].push(entry.barber_name);
                                }
                            });

                            // Build the HTML for each day with up to 6 barbers per day
                            let html = '';
                            daysOfWeek.forEach(day => {
                                html += `<div class="day-row"><strong>${day}:</strong><br><div class="barbers-row">`;

                                // Display up to 6 barbers for the current day
                                const barbers = availableBarbersByDay[day].slice(0, 6);
                                if (barbers.length > 0) {
                                    barbers.forEach(barber => {
                                        html += `<span class="barber">${barber}</span>`;
                                    });
                                } else {
                                    html += `<span class="no-barbers">No barbers available</span>`;
                                }

                                html += '</div></div><br>';
                            });

                            availabilityDiv.innerHTML = html; // Insert the generated HTML into the DOM
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


        <!-- CSS TO SA BARBERS Availability (Dito mo nalang siguro iadjust yung design. Baka kasi magulo sa back e^^) -->
            <style> 
            .availability{
                z-index: 1;
            }
                .day-row {
                top:10em;
                margin-bottom: 20px;
                background-color: aqua;
            }

            .barbers-row {
                display: grid;
                grid-template-columns: repeat(6, 1fr); /* 6 columns for 6 barbers */
                gap: 10px;
            }

            .barber {
                padding: 5px;
                background-color: #f0f0f0;
                border-radius: 5px;
                text-align: center;
            }

            .no-barbers {
                grid-column: span 6; /* Take up the entire row if no barbers */
                text-align: center;
                font-style: italic;
            }

            </style>
</body>
</html>