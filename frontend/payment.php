<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "barbershop");
if($mysqli->connect_error){
    die("Database connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['payment_option'])) {
    $paymentOptionId = (int)$_POST['payment_option'];
    $_SESSION['payment_data']['payment_option_id'] = $paymentOptionId;

    // Query the payment_options table to get the payment_option_name based on payment_option_id
    $query = "SELECT option_name FROM payment_options WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $paymentOptionId);
    $stmt->execute();
    $stmt->bind_result($paymentOptionName);
    $stmt->fetch();
    $stmt->close();

 
    $_SESSION['payment_data']['payment_option_name'] = $paymentOptionName;
    if ($paymentOptionId == 2) { // Full Payment
        $_SESSION['payment_data']['amount_paid'] = $_SESSION['payment_data']['total_payment'];
        $_SESSION['payment_data']['balance'] = 0;
    } else { // Appointment Fee
        $_SESSION['payment_data']['amount_paid'] = $_SESSION['payment_data']['appointment_fee'];
        $_SESSION['payment_data']['balance'] = $_SESSION['payment_data']['service_fee'];
    }
}

// Update the appointment in the database if payment option is set
if (isset($_SESSION['payment_data']['payment_option_id'])) {
    $appointmentId = $_SESSION['form_data']['appointment_id'];
    $paymentOptionId = $_SESSION['payment_data']['payment_option_id'];
    $paymentOptionName = $_SESSION['payment_data']['payment_option_name'];

    $appointmentQuery = "UPDATE appointments SET payment_option_name = ?, payment_option_id = ? WHERE appointment_id = ?";
    $appointmentStmt = $mysqli->prepare($appointmentQuery);
    $appointmentStmt->bind_param("sii", $paymentOptionName, $paymentOptionId, $appointmentId);
    $appointmentStmt->execute();
    $appointmentStmt->close();
}

// Retrieve the service and appointment fees if they are not already set
$_SESSION['payment_data']['service_fee'] = $_SESSION['payment_data']['service_fee'] ?? 1000; 
//$_SESSION['payment_data']['appointment_fee'] = $_SESSION['payment_data']['appointment_fee'] ?? 150; 
$query = "SELECT appointment_fee FROM appointment_fees WHERE id = 1";
$result = $mysqli->query($query);
if ($result) {
    $_SESSION['payment_data']['appointment_fee'] = $result->fetch_assoc()['appointment_fee'];
} else {
    die("Error fetching appointment fee: " . $mysqli->error);
}

$totalPayment = $_SESSION['payment_data']['service_fee'] + $_SESSION['payment_data']['appointment_fee'];
$_SESSION['payment_data']['total_payment'] = $totalPayment;


$uploadMessage ='';
$uploadError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['receipt'])) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/frontend/uploads/receipts/';  

    if(!file_exists($target_dir)){
        mkdir($target_dir,0777,true);
    }

    $originalFileName = $_FILES['receipt']['name'];
    $fileExtension = strtolower(pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION));
    $newFileName = uniqid('receipt_', true) . '.' . $fileExtension;
    $targetFile = $target_dir . $newFileName;
    
    $allowedTypes = array('jpg','jpeg','png','pdf');

    if (!in_array($fileExtension, $allowedTypes)){
        $uploadError = "Only JPG, JPEG, PNG, and PDF files are allowed.";
    }elseif ($_FILES['receipt']['size'] > 5000000){
        $uploadError = "Your file is too large. Maximum size is 5MB.";
    }else{
        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFile)) {
            if (isset($_SESSION['form_data']['appointment_id'])) {
                $appointmentId = $_SESSION['form_data']['appointment_id'];
                $_SESSION['payment_data']['original_filename'] = $originalFileName;
                $_SESSION['payment_data']['receipt_filename'] = $newFileName;
                $_SESSION['payment_data']['receipt_path'] = $targetFile;

                $stmt = $mysqli->prepare("UPDATE appointments SET receipt = ?, receipt_path = ? WHERE appointment_id = ?");
                $stmt->bind_param('ssi', $newFileName, $targetFile, $appointmentId);

                if($stmt->execute()){
                    $uploadMessage = "Payment receipt uploaded successfully!";
                    header("Location: receipt.php");
                    exit();
                }else{
                    $uploadError = "Database update failed: " . $mysqli->error;
                }
                $stmt->close();
            }else{
                $uploadError = "Appointment ID missing. Please confirm your appointment details first.";
            }
        }else{
            $uploadError = "There was an error uploading your file.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="../frontend/design/payment.css?v=101">
    <link rel="stylesheet" href="../frontend/design/terms.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Buzz & Collective - Payment</title>
</head>
<style>
    
</style>
<body>
    <div class="confirmation-form">
        <h2>Buzz & Collective Confirmation</h2>
        <p>MAIN BRANCH</p>
    </div>

    <p class="payment-opt">PAYMENT OPTION</p>

    <form method="POST" action="payment.php">
            <div class="payment-container" id="fullPayment">
                <button type="submit" name="payment_option" value="2" <?php if (isset($_SESSION['payment_data']['payment_option_id']) 
                    && $_SESSION['payment_data']['payment_option_id'] == 2) echo 'checked'; ?>>
                    <h3>Full Payment</h3>
                    <h1 class="total">₱<?php echo number_format($_SESSION['payment_data']['total_payment'], 2); ?></h1>
                    <h5>(Service + Appointment Fee)</h5>
                </button>
            </div>

            <div class="payment-container" id="appointmentFee">
                <button type="submit" name="payment_option" value="1" <?php if (isset($_SESSION['payment_data']['payment_option_id']) 
                    && $_SESSION['payment_data']['payment_option_id'] == 1) echo 'checked'; ?>>
                    <h3>Appointment Fee</h3>
                    <h1>₱<?php echo number_format($_SESSION['payment_data']['appointment_fee'], 2); ?></h1>
                </button>
            </div>
    </form>



    <?php if ($uploadError): ?>
        <div class="error-message"><?php echo $uploadError; ?></div>
    <?php endif; ?>
            
    <?php if ($uploadMessage): ?>
        <div class="success-message"><?php echo $uploadMessage; ?></div>
    <?php endif; ?>


    <div class="terms-container">
        <label>
            <input type="checkbox" id="termsCheckbox">
            I agree to the <a href="" id="termslink">TERMS AND CONDITIONS</a>.
        </label>
    </div>
    <div id="myModal" class="modal" style="display:none;">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Terms and Conditions for Appointment Scheduling</h2>
        </div>
        <div class="modal-body" >
        <p>1. General Appointment Scheduling
            We offer two convenient ways to schedule an appointment with our barbershop: through walk-ins or by booking online via our website.
            Walk-ins: Customers are welcome to visit our shop without a prior appointment; however, walk-ins will be assisted on a first-come, first-served basis, and wait times may vary depending on the number of clients.
            Online Booking: Clients can schedule an appointment directly through our website. Simply fill out the booking form, which allows you to select your preferred date, time, and barber. The appointment is only confirmed after successful payment of the booking fee (details below).</p>

            <p> Barber Availability
            Each barber has a specific weekly schedule, which is updated regularly on our website. Customers can choose their preferred barber when booking online, but the selected time must align with the barber’s availability.
            Appointments can be made up to 2 hours in advance. We do not accept last-minute or on-the-spot bookings unless the chosen barber is available for the requested time.
            Walk-in customers may be assigned the next available barber if they do not have a preference.</p>

            <p>3. Booking Fee and Payment
            A non-refundable booking fee of 150 PHP is required to confirm any appointment.
            Payment must be made through GCash at the time of booking on the website. A screenshot of the successful payment must be uploaded. Appointments are only confirmed after both filling out the booking form and payment have been submitted.
            The booking fee is separate from the service fee for the haircut or other services you select. The booking fee serves to secure your slot with your preferred barber. </p>

            <p>4. Service Fees
            Service fees vary depending on the specific services requested (e.g., haircut, beard trim, styling). These fees are separate from the booking fee and will be charged at the barbershop after the service has been provided. Payment for services can be made in cash or through other payment methods accepted at the shop.</p>

            <p>5. Appointment Changes and Cancellations
            Cancellations are not accepted once the appointment is confirmed. The 150 PHP booking fee is non-refundable regardless of whether the customer shows up for the appointment or not.
            Appointment modifications (such as rescheduling) are allowed up to 2 hours before the appointment time. Once it is within 2 hours of the appointment, no changes will be accepted.
            If you are late to your appointment, we will hold your booking for a maximum of 15 minutes. After this period, your appointment may be forfeited, and walk-in customers may be prioritized.</p>

            <p>6. Walk-ins
            We accept walk-ins; however, walk-in customers will be assisted based on the availability of our barbers.
            Walk-in clients may need to wait if all barbers are busy with appointments. The estimated waiting time will be communicated to you upon arrival.
            We cannot guarantee immediate service for walk-ins, as appointments take priority.</p>

            <p>7. Customer Responsibility
            Customers are expected to arrive on time for their appointments and provide accurate information during the booking process.
            No-shows or late cancellations will result in the loss of the 150 PHP booking fee.
            Customers who repeatedly miss appointments without proper notice may be refused future bookings.</p>

            <p>8. Changes to Terms and Conditions
            We reserve the right to modify these terms and conditions at any time. Any updates will be posted on our website, and customers are responsible for reviewing the terms periodically.
            By booking an appointment through our website, you acknowledge and agree to these terms and conditions.</p>
        </div>
        <div class="modal-footer">
            <button class="agree">I agree</button>
        </div>
    </div>
    </div>

    <div class="mop">
        <p style="color: white;">MODE OF PAYMENT</p>
            <div class="mop-gcash">
                <!-- GCash button will be disabled initially -->
                <button id="gcashButton" class="disabled" disabled>
                    <img src="../frontend/design/image/GCash_logo.svg.png" alt="GCash Logo">
                </button>
            </div>
    </div>

     <!-- Custom popup for GCash -->
     <div class="custom-popup" id="gcashPopup">
     <i class='bx bx-x' id="closePopup"></i> <!-- Add this line for the close button -->
        <h2>UPLOAD SCREENSHOT</h2>
        <div class="gcash-container">
            <div class="gcash-text">
                <p>SEND TO</p>
                <h3>0960 520 5411</h3>
            </div>
            <div class="gcash-image">
                <img src="../frontend/design/image/QRGacsh.jpg" alt="GCASH QR Code">
                <p class="file-info">Accepted formats: JPG, JPEG, PNG, PDF (Max size: 5MB)</p> <!-- Moved here -->
            </div>
        </div>
        <div class="receipt-upload">
             <!-- <h4>UPLOAD GCASH RECEIPT</h4> -->
            <form action="payment.php" id="receiptForm" method="POST" enctype="multipart/form-data">
                <label class="file-label">
                    <input type="file" name="receipt" accept="image/*" required onchange="updateFileName(this)"> <br>
                    <span id="file-label-text">UPLOAD RECEIPT</span>
                </label>
                <button type="submit" name="submit"class="submit-button">SUBMIT</button>
            </form>
        </div>
    </div>


        <script src="../frontend/js/payment.js"></script>

</body>
</html>