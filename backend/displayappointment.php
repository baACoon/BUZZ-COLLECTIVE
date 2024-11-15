<?php

$db = new mysqli('localhost', 'root', '', 'barbershop');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT a.appointment_id, a.first_name, a.last_name, a.email, a.phone_num, a.services, 
               a.barber, a.date, a.timeslot, a.status_name, a.receipt, a.receipt_path, 
               ps.status_name AS payment_status_name, po.option_name AS payment_option_name,
               a.payment_option_id
        FROM appointments AS a
        LEFT JOIN payment_status AS ps ON a.payment_status_name = ps.id
        LEFT JOIN payment_options AS po ON a.payment_option_name = po.id";


$result = $db->query($sql);

// Handle POST request to update the appointment status and payment details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data for updating appointment
    $appointmentId = $_POST['appointment_id'];
    $status = $_POST['status'];
    $paymentStatus = $_POST['payment_status']; 
    $paymentOption = $_POST['payment_option_id']; 

    // Convert payment status and payment option to respective IDs
    $paymentStatusId = null;
    $paymentOptionId = null;

    // Retrieve payment_status ID
    $stmt = $db->prepare("SELECT id FROM payment_status WHERE status_name = ?");
    $stmt->bind_param('s', $paymentStatus);
    $stmt->execute();
    $stmt->bind_result($paymentStatusId);
    $stmt->fetch();
    $stmt->close();

    // Update the appointment status, payment status, and payment option in the database
    $sql = "UPDATE appointments SET status_name = ?, payment_status_name = ?, payment_option_id = ? WHERE appointment_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('siii', $status, $paymentStatusId, $paymentOptionId, $appointmentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update appointment']);
    }

    $stmt->close();
}

$payment_option = 'Not specified';
if (isset($appointment['payment_option_id'])) {
    if ($appointment['payment_option_id'] == 1) {
        $payment_option = 'Appointment Fee';
    } elseif ($appointment['payment_option_id'] == 2) {
        $payment_option = 'Full Payment';
    }
}


$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['payment_option'] = ($row['payment_option_id'] == 1) ? 'Appointment Fee' : 
                                 (($row['payment_option_id'] == 2) ? 'Full Payment' : 'N/A');
        $appointments[] = $row;
    }
}


$db->close();
?>
