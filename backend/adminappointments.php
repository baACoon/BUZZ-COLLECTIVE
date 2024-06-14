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
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phonenumber = $_POST['phone_num'];
    $email = $_POST['email'];
    $barber = $_POST['barber'];
    $appointmentDate = $_POST['appointment_date'];
    $appointmentTime = $_POST['appointment_time'];
    $services = isset($_POST['services']) ? $_POST['services'] : [];

    // Convert the services array to a string to store in the database
    $servicesSerialized = serialize($services);

    // Insert new appointment into database
    $stmt = $db->prepare("INSERT INTO appointments (first_name, last_name, email, phone_num, services, barber, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstName, $lastName, $email, $phonenumber, $servicesSerialized, $barber, $appointmentDate, $appointmentTime);

    if ($stmt->execute()) {
        echo "NEW RECORD CREATED SUCCESFULLY";
        
        // Fetch the newly inserted appointment
        $new_appointment_id = $stmt->insert_id;
        $sql = "SELECT * FROM appointments WHERE appointment_id = $new_appointment_id";
        
       
        $result = $db->query($sql);
        
        if ($result->num_rows > 0) {
            $appointments[] = $result->fetch_assoc();
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
}


?>
