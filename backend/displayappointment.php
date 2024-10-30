<?php

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch appointments and join with payments to get the receipt and receipt_path
$sql = "SELECT appointments.appointment_id, appointments.first_name, appointments.last_name, appointments.email, 
               appointments.phone_num, appointments.services, appointments.barber, appointments.date, 
               appointments.timeslot, appointments.status_name, payments.receipt, payments.receipt_path
        FROM appointments
        LEFT JOIN payments ON appointments.appointment_id = payments.appointment_id";  // Join based on appointment_id

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
