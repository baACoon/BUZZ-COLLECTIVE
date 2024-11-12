<?php

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch appointment details including payment status and options
$sql = "SELECT appointment_id, first_name, last_name, email, phone_num, services, barber, date, 
               timeslot, status_name, receipt, receipt_path, payment_status_name, payment_option_name
        FROM appointments";

$result = $db->query($sql);

// Handle POST request to update the appointment status and payment details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data for updating appointment
    $appointmentId = $_POST['appointment_id'];
    $status = $_POST['status']; // Update appointment status (e.g., 'confirmed', 'cancelled', etc.)
    $paymentStatus = $_POST['payment_status']; // Payment status (e.g., 'Paid', 'Unpaid')
    $paymentOption = $_POST['payment_option']; // Payment option (e.g., 'Full Payment', 'Deposit')

    // Update the appointment status, payment status, and payment option in the database
    $sql = "UPDATE appointments SET status_name = ?, payment_status = ?, payment_option = ? WHERE appointment_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('sssi', $status, $paymentStatus, $paymentOption, $appointmentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update appointment']);
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
