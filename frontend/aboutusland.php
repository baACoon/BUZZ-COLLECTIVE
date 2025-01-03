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
                    <li><a href="product.php">Services</a></li>
                    <li><a class="usericon" href="#"><i class="fa-solid fa-user"></i></a>
                        <ul class="submenu">
                            <li><a href="myprofile.php">My Profile</a></li>
                            <li><a href="login.php">Logout</a></li>
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
        <h1><i>BUZZING</i></h1>
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
    <section class="team-section">
        <h1>Meet the <span>PRIDE</span> of Buzz&Collectives</h1>
        <div class="team-members image-container">
            <?php
            $images = [
                ['src' => 'design/image/Barber1.jpg', 'info' => '
                    <div class="info">
                        <h2>Juan <span>“Baby”</span> Luna</h2>
                        <p><strong>Fav Cut:</strong> Fade</p>
                        <p><strong>Fun Fact:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                        <h3>WORKS</h3>
                        <div class="works-gallery">
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                        </div>
                    </div>'
                ],
                ['src' => 'design/image/barber4.jpg', 'info' => '
                    <div class="info">
                        <h2>Juan <span>“Baby”</span> Luna</h2>
                        <p><strong>Fav Cut:</strong> Fade</p>
                        <p><strong>Fun Fact:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                        <h3>WORKS</h3>
                        <div class="works-gallery">
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                        </div>
                    </div>'
                ],
                ['src' => 'design/image/barber5.jpg', 'info' => '
                    <div class="info">
                        <h2>Juan <span>“Baby”</span> Luna</h2>
                        <p><strong>Fav Cut:</strong> Fade</p>
                        <p><strong>Fun Fact:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                        <h3>WORKS</h3>
                        <div class="works-gallery">
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                        </div>
                    </div>'
                ],
                ['src' => 'design/image/barber 2.jpg', 'info' => '
                    <div class="info">
                        <h2>Juan <span>“Baby”</span> Luna</h2>
                        <p><strong>Fav Cut:</strong> Fade</p>
                        <p><strong>Fun Fact:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                        <h3>WORKS</h3>
                        <div class="works-gallery">
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                        </div>
                    </div>'
                ],
                ['src' => 'design/image/Barber 3.jpg', 'info' => '
                    <div class="info">
                        <h2>Juan <span>“Baby”</span> Luna</h2>
                        <p><strong>Fav Cut:</strong> Fade</p>
                        <p><strong>Fun Fact:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                        <h3>WORKS</h3>
                        <div class="works-gallery">
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                            <div class="work-item"></div>
                        </div>
                    </div>'
                ],
            ];

            foreach ($images as $index => $image) {
                echo '<div class="member" onmouseover="showInfo(this)" onmouseout="hideInfo(this)">';
                echo '<img src="' . $image['src'] . '" alt="Image ' . ($index + 1) . '" class="image" data-index="' . $index . '">';
                echo $image['info'];
                echo '</div>';
            }
            ?>

        </div>
        <div class="appointment-container">
            <a href="login.php"><button class="book-appointment-btn">BOOK AN APPOINTMENT</button></a>
         </div>

    </section>


            <script>
                function showInfo(element) {
                    const infoDiv = element.querySelector('.info');
                    infoDiv.style.display = 'block';
                    infoDiv.style.height = '100px'; // Set height to ensure it's visible
                    updateButtonPosition();
                    }

                    function hideInfo(element) {
                    const infoDiv = element.querySelector('.info');
                    infoDiv.style.display = 'none';
                    infoDiv.style.height = '0'; // Reset height
                    updateButtonPosition();
                    }

                    function updateButtonPosition() {
                    const teamSection = document.querySelector('.team-section');
                    const appointmentButton = document.querySelector('.appointment-btn');
                    const memberElements = document.querySelectorAll('.member');
                    
                    let maxInfoHeight = 0;
                    
                    memberElements.forEach(member => {
                        const infoDiv = member.querySelector('.info');
                        if (infoDiv.style.display === 'block') {
                        maxInfoHeight = Math.max(maxInfoHeight, infoDiv.offsetHeight);
                        }
                    });
                    
                    appointmentButton.style.marginTop = `${20 + maxInfoHeight}px`;
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