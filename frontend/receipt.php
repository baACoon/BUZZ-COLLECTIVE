<?php
session_start(); // Start the session

// Retrieve form data from session
$formData = $_SESSION['form_data'] ?? array();

// Retrieve details
$serviceFee = $_SESSION['payment_data']['service_fee'] ?? 0;
$appointmentFee = $_SESSION['payment_data']['appointment_fee'] ?? 0;
$totalPayment = $_SESSION['payment_data']['total_payment'] ?? 0;

// Calculate amount paid (in this example, the appointment fee is paid)
$amountPaid = $appointmentFee;

// Calculate amount due
$amountDue = $totalPayment - $amountPaid;

// Format the appointment date and time separately
$date = (new DateTime($formData['selected-date'] ?? ''))->format('Y-m-d'); // Format date as 'YYYY-MM-DD'
$time = (new DateTime($formData['appointment-time'] ?? ''))->format('H:i:s'); // Format time as 'HH:MM:SS'

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/receipt.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900&display=swap" rel="stylesheet">
    <title>Buzz & Collective - Receipt</title>
</head>
<body>
    <div class="confirmation-form">
        <h2>Buzz & Collective Appointment Form</h2>
        <p>MAIN BRANCH</p>
    </div>

    <div class="receipt-container">
        <div class="receipt-details">
            <h3>SUMMARY</h3>
            <p>BRANCH <strong>MAIN BRANCH</strong></p>
            <p>DATE <strong><?php echo $date; ?></strong></p>
            <p>TIME <strong><?php echo $time; ?></strong></p>
            <p>FIRST NAME <strong><?php echo htmlspecialchars($formData['first-name'] ?? ''); ?></strong></p>
            <p>LAST NAME <strong><?php echo htmlspecialchars($formData['last-name'] ?? ''); ?></strong></p>
            <p>EMAIL <strong><?php echo htmlspecialchars($formData['email'] ?? ''); ?></strong></p>
            <p>CONTACT NUMBER <strong><?php echo htmlspecialchars($formData['phone'] ?? ''); ?></strong></p>
            <p>SERVICE <strong><?php echo ucfirst(htmlspecialchars($formData['service'] ?? '')); ?></strong></p>
            <p>BARBER <strong><?php echo ucfirst(htmlspecialchars($formData['barber'] ?? '')); ?></strong></p>
            <hr>
            <p class="service-fee">Service Fee <strong><?php echo number_format($serviceFee, 0); ?></strong></p>
            <p class="appointment-fee">Appointment Fee <strong><?php echo number_format($appointmentFee, 0); ?></strong>  </p>
            <hr>
            <p class="amount-paid">Amount Paid  <strong><?php echo number_format($amountPaid, 0); ?></strong></p>
            <p class="amount-due">AMOUNT DUE  <strong><?php echo number_format($amountDue, 0); ?></strong></p>
        </div>
    </div>
</body>
</html>