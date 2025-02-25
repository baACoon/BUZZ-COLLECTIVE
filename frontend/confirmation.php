<?php
session_start();                        

$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');                                    // Database connection


if ($mysqli->connect_error) {                                                                                                           // Ensure the connection was successful
    die("Database connection failed: " . $mysqli->connect_error);
}

// echo "Debug Timeslot: " . htmlspecialchars($_SESSION['form_data']['timeslot'] ?? 'No timeslot');

// Retrieve form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['timeslot']);
    $barber = htmlspecialchars($_POST['barber']);
    
    $_SESSION['form_data'] = array(
        'first_name' => htmlspecialchars($_POST['first_name']),
        'last_name' => htmlspecialchars($_POST['last_name']),
        'email' => htmlspecialchars($_POST['email']),
        'phone_num' => htmlspecialchars($_POST['phone_num']),
        'services' => htmlspecialchars($_POST['services']),
        'barber' => $barber,
        'timeslot' => $time,
        'date' => $date
    );

    $serviceFees = array(                                                                                                               // Define fees for each service
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

    //$appointmentFee = 150;
    // Fetch the appointment fee from the database
    $query = "SELECT appointment_fee FROM appointment_fees WHERE id = 1"; 
    $result = $mysqli->query($query);
    $appointmentFee = $result->fetch_assoc()['appointment_fee'];                                                                                                               // Appointment fee

                                                                                                                                            // Get the fee for the selected service
    $serviceKey = $_SESSION['form_data']['services'];                                                                                      // Store the service key properly
    $serviceFee = isset($serviceFees[$serviceKey]) ? $serviceFees[$serviceKey] : 0;

    
    if ($serviceFee == 0) {                                                                                                                     // Check if service fee is found
        echo "<div class='alert'>Service not found or invalid service selected.</div>";
    }

        
    $totalPayment = $serviceFee + $appointmentFee;                                                                                              // Check if service fee is found

    $_SESSION['payment_data'] = array(
        'service_fee' => $serviceFee,
        'appointment_fee' => $appointmentFee,
        'total_payment' => $totalPayment
    );

    $stmt = $mysqli->prepare("SELECT * FROM appointments WHERE date = ? AND timeslot = ? AND barber = ?");
    $stmt->bind_param('sss', $date, $time, $barber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='warning_prompt'>THIS TIMESLOT IS ALREADY BOOKED.</div>";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO appointments (first_name, last_name, email, phone_num, services, barber, date, timeslot) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssss', 
            $_SESSION['form_data']['first_name'], 
            $_SESSION['form_data']['last_name'], 
            $_SESSION['form_data']['email'], 
            $_SESSION['form_data']['phone_num'], 
            $_SESSION['form_data']['services'], 
            $_SESSION['form_data']['barber'], 
            $_SESSION['form_data']['date'], 
            $_SESSION['form_data']['timeslot']
        );
        
        if ($stmt->execute()) {
            $_SESSION['form_data']['appointment_id'] = $mysqli->insert_id;
            echo "<div class='prompt'>PLEASE CONFIRM THE DETAILS!</div>";
        } else {
            echo "<div class='prompt'>There was an error processing your booking. Please try again.</div>";
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
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
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
            <p>DATE <strong><?php echo htmlspecialchars($_SESSION['form_data']['date'] ?? ''); ?></strong></p>
            <p>TIME <strong><?php echo htmlspecialchars($_SESSION['form_data']['timeslot'] ?? 'Not set'); ?></strong></p>
            <p>FIRST NAME <strong><?php echo $_SESSION['form_data']['first_name']; ?></strong></p>
            <p>LAST NAME <strong><?php echo $_SESSION['form_data']['last_name']; ?></strong></p>
            <p>EMAIL <strong><?php echo $_SESSION['form_data']['email']; ?></strong></p>
            <p>CONTACT NUMBER <strong><?php echo $_SESSION['form_data']['phone_num']; ?></strong></p>
            <p>SERVICE <strong><?php echo ucfirst($_SESSION['form_data']['services']); ?></strong></p>
            <p>BARBER <strong><?php echo htmlspecialchars($_SESSION['form_data']['barber'] ?? ''); ?></strong></p>
            <hr>
            <p class="service-fee" style="font-weight: bolder;">SERVICE FEE <strong>₱<?php echo number_format($serviceFee, 0); ?></strong></p>
            <p class="total-fee" style="font-weight: bolder;">TOTAL PAYMENT: <strong>₱<?php echo number_format($totalPayment, 0); ?></strong></p>
        </div>

        <div class="confirmation-buttons">
            <form method="POST" action="payment.php">
                <button class="confirm-btn" type="submit" style="font-family: 'Montserrat', sans-serif;">Confirm Appointment</button>
            </form>
            <form method="POST" action="appointment.php">
                <button type="submit" style="font-family: 'Montserrat', sans-serif; border: none; background-color: #e2e2e2;">Back</button>
            </form>
        </div>
    </div>
</body>
</html>