<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'barbershop');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the correct POST name 'appointments[]'
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];
    $payment_option = isset($_POST['payment_option']) ? $_POST['payment_option'] : '';

    if (!empty($appointments) && !empty($payment_option)) {
        // Prepare the update query for payment option
        $stmt = $db->prepare("UPDATE appointments SET 
                              payment_option_name = ? 
                              WHERE appointment_id = ?");

        foreach ($appointments as $appointmentId) {
            $stmt->bind_param('si', $payment_option, $appointmentId);
            $stmt->execute();
        }

        echo json_encode(['status' => 'success', 'message' => 'Payment option updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No appointments selected or payment option missing.']);
    }
}
?>
