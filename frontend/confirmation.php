<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'barbershop');
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Ensure all required data is present
if (isset($_SESSION['form_data'])) {
    $formData = $_SESSION['form_data'];

    // Define fees for services
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

    // Fetch appointment fee from the database
    $query = "SELECT appointment_fee FROM appointment_fees WHERE id = 1";
    $result = $mysqli->query($query);
    $appointmentFee = $result->fetch_assoc()['appointment_fee'];

    // Calculate fees
    $serviceFee = isset($serviceFees[$formData['services']]) ? $serviceFees[$formData['services']] : 0;
    $totalPayment = $serviceFee + $appointmentFee;

    $_SESSION['payment_data'] = array(
        'service_fee' => $serviceFee,
        'appointment_fee' => $appointmentFee,
        'total_payment' => $totalPayment
    );

    // Store appointment details in the database
    $stmt = $mysqli->prepare("INSERT INTO appointments (first_name, last_name, email, phone_num, services, barber, date, timeslot) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        'ssssssss',
        $formData['first_name'],
        $formData['last_name'],
        $formData['email'],
        $formData['phone_num'],
        $formData['services'],
        $formData['barber'],
        $formData['date'],
        $formData['timeslot']
    );

    if (!$stmt->execute()) {
        die("Error saving appointment: " . $stmt->error);
    }

    $stmt->close();
    $mysqli->close();
} else {
    // Redirect to appointment form if data is missing
    header('Location: appointmentform.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <link rel="stylesheet" href="../frontend/design/confirmation.css">
    <title>Buzz & Collective - Confirmation</title>
</head>
<body>
    <div class="confirmation-form">
        <h2>Buzz & Collective Appointment Confirmation</h2>
        <p>MAIN BRANCH</p>
    </div>

    <div class="confirmation-container">
        <div class="confirmation-details">
            <p>BRANCH <strong>MAIN BRANCH</strong></p>
            <p>DATE <strong><?php echo htmlspecialchars($formData['date']); ?></strong></p>
            <p>TIME <strong><?php echo htmlspecialchars($formData['timeslot']); ?></strong></p>
            <p>FIRST NAME <strong><?php echo htmlspecialchars($formData['first_name']); ?></strong></p>
            <p>LAST NAME <strong><?php echo htmlspecialchars($formData['last_name']); ?></strong></p>
            <p>EMAIL <strong><?php echo htmlspecialchars($formData['email']); ?></strong></p>
            <p>CONTACT NUMBER <strong><?php echo htmlspecialchars($formData['phone_num']); ?></strong></p>
            <p>SERVICE <strong><?php echo ucfirst($formData['services']); ?></strong></p>
            <p>BARBER <strong><?php echo htmlspecialchars($formData['barber']); ?></strong></p>
            <hr>
            <p class="service-fee">SERVICE FEE <strong>₱<?php echo number_format($serviceFee, 0); ?></strong></p>
            <p class="total-fee">TOTAL PAYMENT <strong>₱<?php echo number_format($totalPayment, 0); ?></strong></p>
        </div>

        <div class="confirmation-buttons">
            <form method="POST" action="payment.php">
                <button class="confirm-btn" type="submit" style="font-family: 'Montserrat', sans-serif;">Confirm Appointment</button>
            </form>
            <form method="POST" action="appointmentform.php">
                <button type="submit" style="font-family: 'Montserrat', sans-serif; border: none; background-color: #e2e2e2;">Back</button>
            </form>
        </div>
    </div>
</body>
</html>
