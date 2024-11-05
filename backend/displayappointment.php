<?php

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch appointments and join with payments to get the receipt and receipt_path
// Updated SQL query if receipt is in appointments table
$sql = "SELECT appointment_id, first_name, last_name, email, phone_num, services, barber, date, 
               timeslot, status_name, receipt, receipt_path
        FROM appointments";


$result = $db->query($sql);

// Handle POST request to update the appointment status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointment_id'];
    $status = $_POST['status'];

    // Update the appointment status in the database
    $sql = "UPDATE appointments SET status_name = ? WHERE appointment_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('si', $status, $appointmentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }

    $stmt->close();
}

// Fetch appointments data and store in $appointments array
$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Close the database connection
$db->close();

?>