<?php
session_start(); // Start the session


// Retrieve form data
$_SESSION['form_data'] = array(
    'first-name' => htmlspecialchars($_POST['first-name']),
    'last-name' => htmlspecialchars($_POST['last-name']),
    'email' => htmlspecialchars($_POST['email']),
    'phone' => htmlspecialchars($_POST['phone']),
    'service' => htmlspecialchars($_POST['service']),
    'barber' => htmlspecialchars($_POST['barber']),
    'appointment-time' => htmlspecialchars($_POST['appointment-time']),
    'selected-date' => htmlspecialchars($_POST['selected-date'])
);

// Define fees for each service
$serviceFees = array(
    'haircut' => 250,
    'hair-color' => 650,
    'kiddie-haircut' => 350,
    'hair-color-and-haircut' => 750,
    'haircut-and-shave' => 350,
    'scalp-treatment' => 750,
    'hair-art' => 300,
    'scalp-treatment-and-haircut' => 250,
    'haircut-perm' => 1300,
    'shave-and-sculpting' => 200
);

// Appointment fee
$appointmentFee = 150;

// Get the fee for the selected service
$serviceFee = $serviceFees[$_SESSION['form_data']['service']] ?? 0;

// Calculate total payment
$totalPayment = $serviceFee + $appointmentFee;

// Format the appointment date and time separately
$date = (new DateTime($_SESSION['form_data']['selected-date']))->format('Y-m-d');
$time = (new DateTime($_SESSION['form_data']['appointment-time']))->format('H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/confirmation.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900&display=swap" rel="stylesheet">
    <title>Buzz & Collective - Confirmation</title>
</head>
<body>
    <div class="confirmation-form">
        <h2>Buzz & Collective Appointment Form</h2>
        <p>MAIN BRANCH</p>
    </div>

    <div class="confirmation-container">
        <div class="confirmation-details">
            <p>BRANCH <strong>MAIN BRANCH</strong></p>
            <p>DATE <strong><?php echo $date; ?></strong></p>
            <p>TIME <strong><?php echo $time; ?></strong></p>
            <p>FIRST NAME <strong><?php echo $_SESSION['form_data']['first-name']; ?></strong></p>
            <p>LAST NAME <strong><?php echo $_SESSION['form_data']['last-name']; ?></strong></p>
            <p>EMAIL <strong><?php echo $_SESSION['form_data']['email']; ?></strong></p>
            <p>CONTACT NUMBER <strong><?php echo $_SESSION['form_data']['phone']; ?></strong></p>
            <p>SERVICE <strong><?php echo ucfirst($_SESSION['form_data']['service']); ?></strong></p>
            <p>BARBER <strong><?php echo ucfirst($_SESSION['form_data']['barber']); ?></strong></p>
            <p class="service-fee"><strong> Service Fee: <?php echo number_format($serviceFee, 0); ?></strong></p>
           
        </div>

        <div class="confirmation-buttons">
            <form method="POST" action="payment.php">
                <button class="confirm-btn" type="submit">Confirm</button>
                <input type="hidden" name="service_fee" value="<?php echo $serviceFee; ?>">
                <input type="hidden" name="appointment_fee" value="<?php echo $appointmentFee; ?>">
                <input type="hidden" name="total_payment" value="<?php echo $totalPayment; ?>">
            </form>
            <form method="POST" action="appointmentform.php">
                <button type="submit">Back</button>
            </form>
        </div>
    </div>
</body>
</html>
