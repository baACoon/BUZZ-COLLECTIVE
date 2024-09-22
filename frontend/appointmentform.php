<?php

// Retrieve form data from session if available
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : array();

?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/appointmentform.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Buzz & Collective - Appointment Form</title>
</head>
<body>
    <div class="appointment-form">
        <h2>Buzz & Collective Appointment Form</h2>
        <p>MAIN BRANCH</p>
    </div>

    <form class="appointment-fields" id="appointmentForm" method="POST" action="confirmation.php">
        <div class="form-section">
            <h3>PERSONAL INFORMATION</h3>
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($formData['first_name'] ?? ''); ?>">

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($formData['last_name'] ?? ''); ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">

            <label for="phone_num">Phone Number </label>
            <input type="tel" id="phone_num" name="phone_num" placeholder="Phone Number (ex. 09*********)" pattern="((^(\+)(\d){12}$)|(^\d{11}$))" value="<?php echo htmlspecialchars($formData['phone_num'] ?? ''); ?>">
        </div>

        <div class="form-section">
            <h3>SERVICE</h3>
            <label>Select Services</label>
            <div class="services-container">
                <div class="services">
                    <?php 
                    $services = array('haircut', 'hair-color', 'kiddie-haircut', 'hair-color-and-haircut', 'haircut-and-shave', 'scalp-treatment', 'hair-art', 'scalp-treatment-and-haircut', 'haircut-perm', 'shave-and-sculpting');
                    foreach ($services as $service) {
                        $checked = ($formData['services'] ?? '') === $service ? 'checked' : '';
                        echo "<div><input type='radio' id='$service' name='services' value='$service' $checked><label for='$service'>" . ucfirst(str_replace('-', ' ', $service)) . "</label></div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="form-section">
            <label for="barber">Barber</label>
            <select id="barber" name="barber">
                <option value="">Select Barber</option>
                <?php 
                $barbers = array('andre', 'drey', 'jeremy', 'donie', 'vien');
                foreach ($barbers as $barber) {
                    $selected = ($formData['barber'] ?? '') === $barber ? 'selected' : '';
                    echo "<option value='$barber' $selected>" . ucfirst($barber) . "</option>";
                }
                ?>
            </select>
        </div>

        <p class="note-text">NOTE: Only barbers available for your scheduled date and time are visible.</p>

        <div class="validation-message" id="validationMessage">
            Please fill out all fields and select a service and a barber before proceeding.
        </div>

        <input type="hidden" id="timeslot" name="timeslot" value="">
        <input type="hidden" id="date" name="date" value="">
        <button type="submit" class="proceed-btn">PROCEED</button>
    </form>

    <script>
        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone_num').value.trim();
        const services = document.querySelector('input[name="services"]:checked');
        const barber = document.getElementById('barber').value.trim();
        const timeslot = document.getElementById('timeslot').value.trim();
        const selectedDate = document.getElementById('date').value.trim();

        if (!firstName || !lastName || !email || !phone || !service || !barber || !timeslot || !selectedDate) {
                document.getElementById('validationMessage').style.display = 'block';
            } else {
                document.getElementById('validationMessage').style.display = 'none';
                // Set hidden input values
                document.getElementById('timeslot').value = document.getElementById('timeslot').value;
                document.getElementById('date').value = document.getElementById('date').value;
                // Submit form
                event.currentTarget.submit();
            }
    });

    </script>
</body>
</html>
