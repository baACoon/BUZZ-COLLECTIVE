<?php
session_start(); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';  
require __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php'; 
require __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';       

$mysqli = new mysqli("localhost", "root", "", "barbershop");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$appointmentId = $_SESSION['form_data']['appointment_id'];
$paymentOptionName = "Not specified";
if ($appointmentId) {
  
    $query = "SELECT a.payment_option_id, po.option_name 
              FROM appointments a 
              JOIN payment_options po ON a.payment_option_id = po.id 
              WHERE a.appointment_id = ?";
    $stmt = $mysqli->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
        $stmt->bind_result($paymentOptionId, $paymentOptionName);
        if ($stmt->fetch()) {
            if ($paymentOptionId == 1) {
                $paymentOptionName = "Appointment Fee";
            } elseif ($paymentOptionId == 2) {
                $paymentOptionName = "Full Payment";
            }
        } else {
            echo "No results found for appointment ID: $appointmentId";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
} else {
    echo "Appointment ID not set in session.";
}
// Fetch values from session
$serviceFee = $_SESSION['payment_data']['service_fee'] ?? 0;
$appointmentFee = $_SESSION['payment_data']['appointment_fee'] ?? 0;
$totalPayment = $_SESSION['payment_data']['total_payment'] ?? ($serviceFee + $appointmentFee);
$amountPaid = $_SESSION['payment_data']['amount_paid'] ?? 0;
$balance = $_SESSION['payment_data']['balance'] ?? ($totalPayment - $amountPaid);

$date = $_SESSION['form_data']['date'] ?? '';
$time = $_SESSION['form_data']['timeslot'] ?? '';
$originalFilename = $_SESSION['payment_data']['original_filename'] ?? '';


$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';                                                                                                                                                                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;
    $mail->Username   = 'buzzincollective@gmail.com';                                                                                                                                                       // SMTP username
    $mail->Password   = 'nwpeckxgsmpbimlb';                                                                                                                                                                 // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('buzzincollective@gmail.com', 'Buzz & Collective');
    $mail->addAddress($_SESSION['form_data']['email']);                                                                                                                                                     // Client email

    $mail->isHTML(true);                                                                                                                                                                                        // Content
    $mail->Subject = 'Appointment Confirmation';
    $mail->Body    = '<p>Dear ' . $_SESSION['form_data']['first_name'] . ' ' . $_SESSION['form_data']['last_name'] . ',</p>'
        . '<p>Your appointment for ' . $date . ' at ' . $time . ' is still pending. Wait until your payment is confirmed. </p>'
        . '<p>Check your email from time to time for confirmation of your appointment.</p>'
        . '<p>Service: ' . ucfirst($_SESSION['form_data']['services']) . '</p>'
        . '<p>Total Payment: ' . number_format($totalPayment, 0) . '</p>'
        . '<p>Thank you for choosing Buzz & Collective!</p>';

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
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
   
    <div class="confirmation-section">
        <div class="confirmation-message">
            <h3><a href="home.php">HOME</a></h3>
            <h1>Appointment Successful</h1>
            <p>You will be notified via email a day before your appointment schedule.</p>
            <p>For no show on your appointed day, you will be re-scheduled.</p>
            <p>
                For cancellation, contact us via email at 
                <a href="mailto:buzzcollective@gmail.com" target="_blank" class="redirect-email">
                    buzzcollective@gmail.com
                </a>
            </p>
        </div>
        <div class="receipt-container">
            <div class="receipt-details">
                <h3>SUMMARY</h3>
                <p>BRANCH <strong>MAIN BRANCH</strong></p>
                <p>DATE <strong><?php echo $date; ?></strong></p>
                <p>TIME <strong><?php echo $time; ?></strong></p>
                <p>FIRST NAME <strong><?php echo $_SESSION['form_data']['first_name']; ?></strong></p>
                <p>LAST NAME <strong><?php echo $_SESSION['form_data']['last_name']; ?></strong></p>
                <p>EMAIL <strong><?php echo $_SESSION['form_data']['email']; ?></strong></p>
                <p>CONTACT NUMBER <strong><?php echo $_SESSION['form_data']['phone_num']; ?></strong></p>
                <p>SERVICE <strong><?php echo ucfirst($_SESSION['form_data']['services']); ?></strong></p>
                <p>BARBER <strong><?php echo ucfirst($_SESSION['form_data']['barber']); ?></strong></p>
                <hr>
                <p>Service Fee: <strong>₱<?php echo number_format($serviceFee, 2); ?></strong></p>
                <p>Appointment Fee: <strong>₱<?php echo number_format($appointmentFee, 2); ?></strong></p>
                <p>PAYMENT OPTION: <strong><?php echo htmlspecialchars($paymentOptionName); ?></strong></p>
                <hr>
                <p>Amount Paid: <strong>₱<?php echo number_format($amountPaid, 2); ?></strong></p>
                <?php if ($balance > 0): ?>
                    <p class="balance">BALANCE: <strong>₱<?php echo number_format($balance, 2); ?></strong></p>
                <?php else: ?>
                    <p><strong>Paid in Full</strong></p>
                <?php endif; ?>
            </div>
            <div class="receipt-image">
                <h3>Receipt Image</h3>
                <?php if (!empty($originalFilename)): ?>
                    <p>Uploaded File: <?php echo htmlspecialchars($originalFilename); ?></p>
                    <?php 
                    /*if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                        $receiptPath = $_SESSION['payment_data']['receipt_path'] ?? '';
                        if (!empty($receiptPath)) {
                            echo "<img src='" . htmlspecialchars($receiptPath) . "' alt='Receipt' style='max-width: 100%; height: auto;'/>";
                        }
                    }*/
                    ?>
                <?php else: ?>
                    <p>No receipt image uploaded.</p>
                <?php endif; ?>
            </div>
            <div class="confirmation-buttons">
                <form method="POST" action="appointment.php">
                    <button class="confirm-btn" type="submit" style="font-family: 'Montserrat', sans-serif;">Book again</button>
                </form>
                <form method="POST" action="home.php">
                    <button type="submit" style="font-family: 'Montserrat', sans-serif; border: none; background-color: #e0e0e0;">Home</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
