<?php
session_start();

// Retrieve form data from session if available
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : array();
$selectedTime = isset($_GET['selected-timeslot']) ? htmlspecialchars($_GET['selected-timeslot']) : '';
$selectedDate = isset($_GET['selected-date']) ? htmlspecialchars($_GET['selected-date']): '';
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/appointmentform.css?v=101">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Buzz & Collective - Appointment Form</title>
</head>
<body>
        <div class="appointment-form">
                <h2>Buzz & Collective Appointment Form</h2>
                <p>Main Branch</p>
        </div>


    <form class="appointment-fields" id="appointmentForm" method="POST" action="confirmation.php">
        <div class="form-section">
            <h3>PERSONAL INFORMATION</h3>
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($formData['first_name'] ?? ''); ?>" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($formData['last_name'] ?? ''); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" required>

            <label for="phone_num">Phone Number </label>
            <input type="tel" id="phone_num" name="phone_num" placeholder="Phone Number (ex. 09*********)" pattern="((^(\+)(\d){12}$)|(^\d{11}$))" value="<?php echo htmlspecialchars($formData['phone_num'] ?? ''); ?>" required>
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
                                <input type='radio' id='$service' name='services' value='$service' $checked required>
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
            <label for="barber">Barber 
                <span class="tooltip"><i class="fa-light fa-circle-question"></i>
                    <span class="tooltiptext"><em>Check the available barber for the week in the homepage.</em></span>
                </span>
            </label>
            <div id="barber-container">
                <!-- Barber options will be populated dynamically -->
            </div>
        </div>

        <p class="note-text">NOTE: Only barbers available for your scheduled date and time are visible.</p>

        <div class="validation-message" id="validationMessage" style="display: none;">
            Please fill out all fields and select a service and a barber before proceeding.
        </div>

        <input type="hidden" id="timeslot" name="timeslot" value="<?php echo $selectedTime; ?>">
        <input type="hidden" id="date" name="date" value="<?php echo $selectedDate; ?>">
        <button type="submit" class="proceed-btn">PROCEED</button>
    </form>
    <script>
        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone_num').value.trim();
        const services = document.querySelector('input[name="services"]:checked');
        const barber = document.querySelector('input[name="barber"]:checked');
        const selectedDate = document.getElementById('date').value.trim();
        const timeslot = document.getElementById('timeslot').value.trim();

        if (!firstName || !lastName || !email || !phone || !services || !barber || !timeslot || !selectedDate) {
            document.getElementById('validationMessage').style.display = 'block';
            event.preventDefault(); // Prevent form submission


            
        } else {
            document.getElementById('validationMessage').style.display = 'none';
        }
    });

    window.onload = function() {
        const selectedDate = "<?php echo $selectedDate; ?>";
        const selectedTime = "<?php echo $selectedTime; ?>";
        
        if (selectedDate && selectedTime) {
            fetchAvailableBarbers(selectedDate);
        }
    };

    function fetchAvailableBarbers(date) {
        const barberContainer = document.getElementById('barber-container');
        barberContainer.innerHTML = 'Loading barbers...'; // Placeholder text while fetching
        
        // AJAX request to fetch availability
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `barberavailability.php?selected_date=${date}`, true); // Removed selected_time since it's not needed
        xhr.onload = function() {
            if (this.status === 200) {
                const barbers = JSON.parse(this.responseText);
                let barberOptions = '';

                // Display only available barbers
                barbers.forEach(barber => {
                    barberOptions += `<div class='barber-item'>
                                        <input type='radio' name='barber' value='${barber.barber_name}' required>
                                        <label>${barber.barber_name}</label>
                                    </div>`;
                });

                barberContainer.innerHTML = barberOptions.length ? barberOptions : 'No available barbers for the selected date.';
            }
        };
        xhr.send();
    }

    </script> 
    </body>
    <style>
        
        /* Barber item container */
        .barber-item {
            display: flex;                
            align-items: center;         
            padding: 8px;               
            margin: 5px 0;              
            border: 1px solid #ddd;     
            border-radius: 5px;         
            transition: background-color 0.3s; 
            cursor: pointer;             
            background-color: #fff;
        }

        /* Radio button */
        .barber-item input[type="radio"] {
            margin-right: 10px;          
            cursor: pointer;             
        }

        /* Label styling */
        .barber-item label {
            font-size: 16px;             
            color: #333;                 
        }

        /* Hover effect */
        .barber-item:hover {
            background-color: orangered;  
        }

        /* Selected state for radio button */
        .barber-item input[type="radio"]:checked + label {
            font-weight: bold;          
            color: black;             
        }
        
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer; /* Change cursor to pointer */
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 220px; 
            background-color: #555; 
            color: #fff; 
            text-align: center; 
            border-radius: 5px; 
            padding: 5px; 
            position: absolute;
            z-index: 1; 
            bottom: 100%; 
            left: 50%;
            margin-left: -60px; 
            opacity: 0; 
            transition: opacity 0.3s; 
            font-size: 12px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible; 
            opacity: 1; 
        }

    </style>
</body>
</html>
