<?php include('../backend/appointment.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="design/appointment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Appointment Form</title>
</head>
<body>
    <div id="buzz-img">
        <img src="design/image/buzz.png" alt="">
    </div>

    <div id="appointment-form">
        <h2>Buzz & Collective Appointment Form</h2>
    </div>
    
    <div class="form-container">
        <form method="POST" action="appointment.php" method="POST"> 
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone_num" required>
            </div>

            <h2 class="select">Select Services</h2>

            <div class="form-group services">
                <label><input type="checkbox" name="services[]" value="haircut"> Haircut</label>
                <label><input type="checkbox" name="services[]" value="kiddie_haircut"> Kiddie Haircut</label>
                <label><input type="checkbox" name="services[]" value="haircut_shave"> Haircut and Shave</label>
                <label><input type="checkbox" name="services[]" value="hair_art"> Hair Art</label>
                <label><input type="checkbox" name="services[]" value="haircut_perm"> Haircut and Perm</label>
                <label><input type="checkbox" name="services[]" value="hair_color"> Hair Color</label>
                <label><input type="checkbox" name="services[]" value="hair_color_haircut"> Hair Color and Haircut</label>
                <label><input type="checkbox" name="services[]" value="scalp_treatment"> Scalp Treatment</label>
                <label><input type="checkbox" name="services[]" value="scalp_treatment_haircut"> Scalp Treatment and Haircut</label>
                <label><input type="checkbox" name="services[]" value="shave_sculpting"> Shave and Sculpting</label>
            </div>

            <h2 class="select">Stylist</h2>
            <div id="stylist">
                <div class="stylist-item">
                    <img src="design/image/barber5.jpg" alt="Stylist">
                    <p>Adi</p>
                    <input type="checkbox" name="barber">
                </div>

                <div class="stylist-item">
                    <img src="design/image/barber4.jpg" alt="Stylist">
                    <p>Adi</p>
                    <input type="checkbox" name="barber">
                </div>

                <div class="stylist-item">
                    <img src="design/image/Barber 3.jpg" alt="Stylist">
                    <p>Adi</p>
                    <input type="checkbox" name="barber">
                </div>

                <div class="stylist-item">
                    <img src="design/image/barber 2.jpg" alt="Stylist">
                    <p>Adi</p>
                    <input type="checkbox" name="barber">
                </div>

                <div class="stylist-item">
                    <img src="design/image/Barber1.jpg" alt="Stylist">
                    <p>Adi</p>
                    <input type="checkbox" name="barber">
                </div>
            </div>

            <div class="recos">
                <input type="checkbox" id="recommended-barber" name="barbers" value="recommended-barber">
                <label for="recommended-barber">Recommended Barber</label>
            </div>

            <h2 class="select">Set Date and Time</h2>
            <div class="form-group datetime">
                <label for="appointment_date">Date</label>
                <input type="date" id="appointment-date" name="appointment_date" required>
            </div>

            <div class="form-group datetime">
                <label for="appointment_time">Time</label>
                <input type="time" id="appointment-time" name="appointment_time" required>
            </div>

            <div class="form-group button-group">
                <button type="submit">Submit</button>
            </div>

            <div class="form-group button-group">
                <button type="submit"><a href="home.php">Cancel</a></button>
            </div>
        </form>
    </div>
</body>
</html>
