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
    </div>

    <div class="txt">
        <h1>Meet the <b>PRIDE</b> of Buzz&Collectives</h1>
    </div>

    <div class="image-container">
        <?php
        $images = [
            ['src' => 'design/image/Barber1.jpg', 'info' => 'Juan “Baby” Luna<br>Fav Cut: Fade<br>Fun Fact:<br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.'],
            ['src' => 'design/image/barber4.jpg', 'info' => 'Information about Image 2'],
            ['src' => 'design/image/barber5.jpg', 'info' => 'Information about Image 3'],
            ['src' => 'design/image/barber 2.jpg', 'info' => 'Information about Image 3'],
            ['src' => 'design/image/Barber 3.jpg', 'info' => 'Information about Image 3'],
        ];

        foreach ($images as $index => $image) {
            echo '<div class="image-wrapper">';
            echo '<img src="' . $image['src'] . '" alt="Image ' . ($index + 1) . '" class="image" data-index="' . $index . '">';
            echo '<div class="info" id="info-' . $index . '">' . $image['info'] . '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.image');
            const infos = document.querySelectorAll('.info');

            images.forEach(image => {
                image.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    const info = document.getElementById('info-' + index);  

                    // Hide all info boxes and remove active class from all images
                    infos.forEach(info => {
                        info.style.opacity = '0';
                        info.style.height = '0';
                    });
                    images.forEach(img => img.classList.remove('active'));

                    // Toggle the clicked info box and add active class to the clicked image
                    if (info.style.opacity === '1') {
                        info.style.opacity = '0';
                        info.style.height = '0';
                        this.classList.remove('active');
                    } else {
                        info.style.opacity = '1';
                        info.style.height = 'auto';
                        this.classList.add('active');
                    }
                });

                image.addEventListener('mouseenter', function() {
                    const index = this.getAttribute('data-index');
                    const info = document.getElementById('info-' + index);
                    info.style.opacity = '1';
                    info.style.height = 'auto';
                });

                image.addEventListener('mouseleave', function() {
                    const index = this.getAttribute('data-index');
                    const info = document.getElementById('info-' + index);
                    if (!this.classList.contains('active')) {
                        info.style.opacity = '0';
                        info.style.height = '0';
                    }
                });
            });
        });
    </script>

    <div class="appointment-container">
        <a href="appointment.php"><button class="book-appointment-btn">BOOK AN APPOINTMENT</button></a>
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
