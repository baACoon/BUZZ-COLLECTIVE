<?php
session_start(); // initiates a new session or resume an existing one.


//connection to the mysql database. 
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Dummy data = it initialize an empty array '$appointments' to hold the appointment data
$appointments = [];

// Fetch existing appointments from database
// executes a sql query to fetch all records from the 'appointments' table 
$sql = "SELECT * FROM appointments";
$result = $db->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = htmlspecialchars ($_POST['first_name'], ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars ($_POST['last_name'], ENT_QUOTES, 'UTF-8');
    $phonenumber = filter_var ($_POST['phone_num'], FILTER_SANITIZE_NUMBER_INT);
    if (!preg_match('/^\+?[0-9]{7,15}$/' , $phonenumber)){
        die("Invalid phone number format");
    }
    $email = filter_var ($_POST['email'], FILTER_SANITIZE_EMAIL);
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        die("Invalid email format");
    }
    $barber = htmlspecialchars($_POST['barber'], ENT_QUOTES, 'UTF-8');
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];
    $date = DateTime::createFromFormat('Y-m-d', $appointmentDate);
    if($date === false || $date->format('Y-m-d') !=$appointmentDate){
        die("Invalid Date format");
    }
    if(!preg_match('/^(\d{2}):(\d{2}) - (\d{2}):(\d{2})$/', $appointmentTime)){
        die("Invalid Time format");
    }
    $services = isset($_POST['services']) ? array_map(function($services){
        return htmlspecialchars($services, ENT_QUOTES, 'UTF-8');
    }, $_POST['services']) :[];
    $services = implode(", ", $services);

    // Insert new appointment into database
    $stmt = $db->prepare("INSERT INTO appointments (first_name, last_name, email, phone_num, services, barber, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstName, $lastName, $email, $phonenumber, $services, $barber, $appointmentDate, $appointmentTime);

    if ($stmt->execute()) {
        
        // Fetch the newly inserted appointment
        $new_appointment_id = $stmt->insert_id;
        $sql = "SELECT * FROM appointments WHERE appointment_id = $new_appointment_id";
        $result = $db->query($sql);
        
        if ($result->num_rows > 0) {
            $appointment = $result->fetch_assoc();
            $appointments[] = $appointment;
            
        } else {
            echo "Error: Appointment not found after insertion.";
        }
        
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    // Store appointments data in session
    $_SESSION['appointments'] = $appointments;

    $db->close();

    include '../frontend/popup/confirmation.php';
    exit();
}

?>