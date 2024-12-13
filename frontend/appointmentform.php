<?php
session_start();
$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Retrieve selected date, time, and barber from POST or session
$selectedTime = isset($_POST['timeslot']) ? htmlspecialchars($_POST['timeslot']) : '';
$selectedDate = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';
$selectedBarber = isset($_POST['barber']) ? htmlspecialchars($_POST['barber']) : '';

$promptMessage = '';
$promptType = '';

if ($selectedDate && $selectedTime && $selectedBarber) {
    $stmt = $mysqli->prepare("SELECT * FROM appointments WHERE date = ? AND timeslot = ? AND barber = ?");
    $stmt->bind_param('sss', $selectedDate, $selectedTime, $selectedBarber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $promptMessage = "This timeslot is already booked.";
        $promptType = 'warning';
    } else {
        $promptMessage = "You can continue to fill up the appointment details.";
        $promptType = 'success';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="../frontend/design/appointmentform.css?=901">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Buzz & Collective - Appointment Form</title>
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .modal-content p {
            margin: 20px 0;
            font-size: 1.2em;
        }

        .modal-content button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .warning {
            color: red;
        }

        .success {
            color: rgb(255, 77, 64);
        }

        .back-btn {
            background-color: #e2e2e2;
        }

        .continue-btn {
            background-color: rgb(255, 77, 64);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Prompt Modal -->
    <?php if ($promptMessage): ?>
        <div id="promptModal" class="modal">
            <div class="modal-content">
                <p class="<?php echo htmlspecialchars($promptType); ?>">
                    <?php echo htmlspecialchars($promptMessage); ?>
                </p>
                <?php if ($promptType === 'warning'): ?>
                    <button class="back-btn" onclick="location.href='appointment.php'">Back</button>
                <?php else: ?>
                    <button class="continue-btn" onclick="closeModal()">Continue</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

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

        <div class="validation-message" id="validationMessage" style="display: none;">
            Please fill out all fields and select a service and a barber before proceeding.
        </div>

        <input type="hidden" name="date" value="<?php echo $selectedDate; ?>">
        <input type="hidden" name="timeslot" value="<?php echo $selectedTime; ?>">
        <input type="hidden" name="barber" value="<?php echo $selectedBarber; ?>">
        <div class="buttons">
            <button type="submit" class="back-btn"style="font-family: 'Montserrat', sans-serif; border: none; background-color: #e2e2e2;"><a href="appointment.php">Back</a></button>
            <button type="submit" class="proceed-btn" style="font-family:'Montserrat', sans-serif;">PROCEED</button>
        </div>
    </form>

        <script>
       // Update your validation script
            document.getElementById('appointmentForm').addEventListener('submit', function(event) {
                const firstName = document.getElementById('first_name').value.trim();
                const lastName = document.getElementById('last_name').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone_num').value.trim();
                const services = document.querySelector('input[name="services"]:checked');
                const date = document.getElementById('date').value.trim();
                const timeslot = document.getElementById('timeslot').value.trim();
                const barber = document.getElementById('barber').value.trim();

                if (!firstName || !lastName || !email || !phone || !services || !date || !timeslot || !barber) {
                    document.getElementById('validationMessage').style.display = 'block';
                    event.preventDefault();
                } else {
                    document.getElementById('validationMessage').style.display = 'none';
                }
            });

             // Show modal on load
        window.onload = function () {
            const modal = document.getElementById('promptModal');
            if (modal) {
                modal.style.display = 'block';
            }
        };

        // Close modal
        function closeModal() {
            const modal = document.getElementById('promptModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

    </script> 
</body>
</html>
