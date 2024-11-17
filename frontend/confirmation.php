<?php
session_start();                        

$mysqli = new mysqli('localhost', 'root', '', 'barbershop');                                    // Database connection


if ($mysqli->connect_error) {                                                                                                           // Ensure the connection was successful
    die("Database connection failed: " . $mysqli->connect_error);
}

                                                                                                                                        // Retrieve form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['form_data'] = array(                                                                                                      // Store form data in session
        'first_name' => htmlspecialchars($_POST['first_name']),
        'last_name' => htmlspecialchars($_POST['last_name']),
        'email' => htmlspecialchars($_POST['email']),
        'phone_num' => htmlspecialchars($_POST['phone_num']),
        'services' => htmlspecialchars($_POST['services']),                                                                     // Make sure 'services' is correct
        'barber' => htmlspecialchars($_POST['barber']),
        'timeslot' => htmlspecialchars($_POST['timeslot']),
        'date' => htmlspecialchars($_POST['date'])
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

    $appointmentFee = 150;                                                                                                               // Appointment fee

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

    
    $date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';
    $time = isset($_POST['timeslot']) ? htmlspecialchars($_POST['timeslot']) : '';
   
    $stmt = $mysqli->prepare("SELECT * FROM appointments WHERE date = ? AND timeslot = ?");
    $stmt->bind_param('ss', $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='warning_prompt' >THIS TIMESLOT IS ALREADY BOOKED.</div>";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO appointments (first_name, last_name, email, phone_num, services, barber, date, timeslot) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssss', $_SESSION['form_data']['first_name'], $_SESSION['form_data']['last_name'], $_SESSION['form_data']['email'], $_SESSION['form_data']['phone_num'], $_SESSION['form_data']['services'], $_SESSION['form_data']['barber'], $date, $time);
        
        if ($stmt->execute()) {
            $_SESSION['form_data']['appointment_id'] = $mysqli->insert_id; // Store appointment_id
            $_SESSION['form_data']['date'] = $date;
            $_SESSION['form_data']['email'] = $_SESSION['form_data']['email']; // Email is already stored
            
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
    <link rel="stylesheet" href="../frontend/design/confirmation.css">
    <title>Buzz & Collective - Confirmation</title>
</head>
<style>
    
</style>

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