<?php
session_start(); // Start the session

// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'barbershop');

// Ensure the connection was successful
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Retrieve form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Store form data in session
    $_SESSION['form_data'] = array(
        'first_name' => htmlspecialchars($_POST['first_name']),
        'last_name' => htmlspecialchars($_POST['last_name']),
        'email' => htmlspecialchars($_POST['email']),
        'phone_num' => htmlspecialchars($_POST['phone_num']),
        'services' => htmlspecialchars($_POST['services']), // Make sure 'services' is correct
        'barber' => htmlspecialchars($_POST['barber']),
        'timeslot' => htmlspecialchars($_POST['timeslot']),
        'date' => htmlspecialchars($_POST['date'])
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
    $serviceKey = $_SESSION['form_data']['services']; // Store the service key properly
    $serviceFee = isset($serviceFees[$serviceKey]) ? $serviceFees[$serviceKey] : 0;

    // Check if service fee is found
    if ($serviceFee == 0) {
        echo "<div class='alert alert-danger'>Service not found or invalid service selected.</div>";
    }

    // Calculate total payment
    $totalPayment = $serviceFee + $appointmentFee;

    // Store the payment data in session for later use in receipt.php
    $_SESSION['payment_data'] = array(
        'service_fee' => $serviceFee,
        'appointment_fee' => $appointmentFee,
        'total_payment' => $totalPayment
    );

    // Format the appointment date and time separately
    $date = (new DateTime($_SESSION['form_data']['date']))->format('Y-m-d');
    $time = (new DateTime($_SESSION['form_data']['timeslot']))->format('H:iA');

    // Check if the timeslot is already booked
    $stmt = $mysqli->prepare("SELECT * FROM appointments WHERE date = ? AND timeslot = ?");
    $stmt->bind_param('ss', $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger'>This timeslot is already booked.</div>";
    } else {
        // Insert the booking into the database
        $stmt = $mysqli->prepare("INSERT INTO appointments (first_name, last_name, email, phone_num, services, barber, date, timeslot) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssss', $_SESSION['form_data']['first_name'], $_SESSION['form_data']['last_name'], $_SESSION['form_data']['email'], $_SESSION['form_data']['phone_num'], $_SESSION['form_data']['services'], $_SESSION['form_data']['barber'], $date, $time);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Booking successful!</div>";
        } else {
            echo "<div class='alert alert-danger'>There was an error processing your booking. Please try again.</div>";
        }
    }
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/design/confirmation.css">
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
            <p>FIRST NAME <strong><?php echo $_SESSION['form_data']['first_name']; ?></strong></p>
            <p>LAST NAME <strong><?php echo $_SESSION['form_data']['last_name']; ?></strong></p>
            <p>EMAIL <strong><?php echo $_SESSION['form_data']['email']; ?></strong></p>
            <p>CONTACT NUMBER <strong><?php echo $_SESSION['form_data']['phone_num']; ?></strong></p>
            <p>SERVICE <strong><?php echo ucfirst($_SESSION['form_data']['services']); ?></strong></p>
            <p>BARBER <strong><?php echo ucfirst($_SESSION['form_data']['barber']); ?></strong></p>
            <p class="service-fee"><strong>Service Fee: <?php echo number_format($serviceFee, 0); ?></strong></p>
            <p class="total-fee"><strong>Total Payment: <?php echo number_format($totalPayment, 0); ?></strong></p>
        </div>

        <div class="confirmation-buttons">
            <form method="POST" action="receipt.php">
                <button class="confirm-btn" type="submit">Confirm Appointment</button>
            </form>
            <form method="POST" action="appointmentform.php">
                <button type="submit">Back</button>
            </form>
        </div>
    </div>
</body>
</html>
