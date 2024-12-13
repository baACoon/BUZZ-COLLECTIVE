<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'barbershop');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the correct POST name 'appointments[]'
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];
    $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';

    if (!empty($appointments) && !empty($payment_status)) {
        // Prepare the update query for payment status
        $stmt = $db->prepare("UPDATE appointments SET 
                              payment_status_name = ? 
                              WHERE appointment_id = ?");

        foreach ($appointments as $appointmentId) {
            $stmt->bind_param('si', $payment_status, $appointmentId);
            $stmt->execute();
        }

        echo json_encode(['status' => 'success', 'message' => 'Payment status updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No appointments selected or payment status missing.']);
    }
}
?>
