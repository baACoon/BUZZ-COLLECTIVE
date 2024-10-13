<?php
session_start(); // Start the session

// Retrieve payment details from the POST request
$serviceFee = $_POST['service_fee'] ?? 0;
$appointmentFee = $_POST['appointment_fee'] ?? 0;
$totalPayment = $_POST['total_payment'] ?? 0;

// Store payment data in session
$_SESSION['payment_data'] = [
    'service_fee' => $serviceFee,
    'appointment_fee' => $appointmentFee,
    'total_payment' => $totalPayment
];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/payment.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900&display=swap" rel="stylesheet">
    <title>Buzz & Collective - Payment</title>
</head>
<body>
    <div class="confirmation-form">
        <h2>Buzz & Collective Confirmation</h2>
        <p>MAIN BRANCH</p>
    </div>

    <p class="payment-opt">PAYMENT OPTION</p>

        <div class="payment-section">
            <div class="payment-container">
                <div class="payment-details">
                    <h1><?php echo number_format($totalPayment, 0); ?></h1>
                    <p>PHP</p>
                    <h3>Full Payment</h3>
                    <h5>(Service + Appointment Fee)</h5>
                    <h5>Refund available</h5>

                </div>
            </div>

            <div class="payment-container">
                <div class="payment-details">
                    <h1><?php echo number_format($appointmentFee, 0); ?></h1>
                    <p>PHP</p>
                    <h3>Appointment Fee</h3>

                </div>
            </div>
        </div>  

        <div class="mop">       
            <p>MODE OF PAYMENT</p>
            <div class="mop-container">
                <div class="mop-gcash">
                    <a href="receipt.php" target="_blank">
                        <img src="../frontend/design/image/GCash_logo.svg.png" alt="GCash Logo">
                    </a>
                </div>
            </div>
        </div>
    

</body>
</html>