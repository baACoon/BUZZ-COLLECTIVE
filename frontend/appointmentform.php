<?php

// Retrieve form data from session if available
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : array();
$selectedTime = isset($_GET['selected-timeslot']) ? htmlspecialchars($_GET['selected-timeslot']) : '';
$selectedDate = isset($_GET['selected-date']) ? htmlspecialchars($_GET['selected-date']) : '';

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
                    // Define services with fees and descriptions
                    $servicesData = array(
                        'haircut' => array('fee' => 250, 'description' => 'A classic haircut for a fresh look.'),
                        'hair-color' => array('fee' => 650, 'description' => 'Change your hair color to something new.'),
                        'kiddie-haircut' => array('fee' => 350, 'description' => 'A fun haircut for kids.'),
                        'hair-color-and-haircut' => array('fee' => 750, 'description' => 'Get a haircut and change your hair color.'),
                        'haircut-and-shave' => array('fee' => 350, 'description' => 'Includes a haircut and a clean shave.'),
                        'scalp-treatment' => array('fee' => 750, 'description' => 'Treat your scalp for a healthier look.'),
                        'hair-art' => array('fee' => 300, 'description' => 'Creative designs and styles on your hair.'),
                        'scalp-treatment-and-haircut' => array('fee' => 250, 'description' => 'Includes a scalp treatment and haircut.'),
                        'haircut-perm' => array('fee' => 1300, 'description' => 'Get your hair permed for beautiful curls.'),
                        'shave-and-sculpting' => array('fee' => 200, 'description' => 'Precise shaving and sculpting of facial hair.')
                    );

                    foreach ($servicesData as $service => $data) {
                        $checked = ($formData['services'] ?? '') === $service ? 'checked' : '';
                        echo "<div class='service-item'>
                        <div class='service-info'>
                                <input type='radio' id='$service' name='services' value='$service' $checked>
                                <label for='$service'>" . ucfirst(str_replace('-', ' ', $service)) . "</label>
                                </div>
                        <div class='service-details'>
                                <span class='service-fee'>₱" . $data['fee'] . "</span>
                                <div class='service-description'>" . $data['description'] . "</div>
                                </div>
                                
                            </div>";
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

        <input type="hidden" id="timeslot" name="timeslot" value="<?php echo $selectedTime; ?>">
        <input type="hidden" id="date" name="date" value="<?php echo $selectedDate?>">
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
        const selectedDate = document.getElementById('date').value.trim();
        const timeslot = document.getElementById('timeslot').value.trim();
        
        const selectedTimeSlot = timeslot ? timeslot.value.trim() : '';
        console.log("Selected Time Slot:", selectedTimeSlot);
        console.log("Selected Date:", selectedDate);
        document.getElementById('timeslot').value = selectedTimeSlot;

        if (!firstName || !lastName || !email || !phone || !service || !barber || !timeslot || !selectedDate) {
                document.getElementById('validationMessage').style.display = 'block';
            } else {
                document.getElementById('validationMessage').style.display = 'none';
                // Set hidden input values
                document.getElementById('timeslot').value = selectedTimeSlot;
                document.getElementById('date').value = selectedDate;
                // Submit form
                event.currentTarget.submit();
            }
    });

    </script>
</body>
</html>