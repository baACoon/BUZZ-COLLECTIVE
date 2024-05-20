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


        
        <!--BUZZING & FOUNDERS INFO-->
        <div id="body-container">

            <img src="design/image/buzz.png" class="logo-body"alt="">
            <p>Buzz & Collectives is more than just a barbershop—it's a dynamic concept store 
                where craftsmanship meets community. Experience top-notch grooming services 
                alongside curated selections of lifestyle products, fostering a vibrant space 
                where style and culture intersect.</p>
        </div>  


        <!--BUZZING & FOUNDERS INFO-->
        <div class="buzzing_container">
                    <h3>Founders</h3>
                    <h2>Monti & Comia started</h2>
                    <h1><i>BUZZING</i></h1>
                    <p>
                        In <b>May 2022</b>, Akira Gata and Monti Comia establised Buzz&Collectives just as Cavite City was still recovering 
                        from the aftermath of the COVID-19 pandemic. The team’s commitment to maintain strict safety measures builded 
                        the trust with the clients.
                    </p>


                        <div class="v105_40">  <!--MONTI IMAGE-->
                            <img src="design/image/Monti_comia.png" alt="" >
                        </div>

                        <div class="v105_38">  <!--AKIRA IMAGE-->
                            <img src="design/image/Akira_Gata.png" alt="">
                        </div>

        </div>


            <div class="txt">
                <h1>Meet the <b>PRIDE</b> of Buzz&Collectives</h1>
            </div>
        
            <!--BARBERS INFO -->
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

            <a href="appointment.php"><button class="book-appointment-btn">BOOK AN APPOINTMENT</button></a>


</body>

</html>