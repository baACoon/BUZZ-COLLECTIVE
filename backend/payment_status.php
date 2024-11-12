<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'barbershop');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the correct POST name 'appointments[]' and 'payment_status'
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];
    $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';

    if (!empty($appointments) && !empty($payment_status)) {
        // First, check if the payment_status exists in the payment_status table
        $stmt = $db->prepare("SELECT id FROM payment_status WHERE status_name = ?");
        $stmt->bind_param('s', $payment_status);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Get the corresponding payment status ID
            $stmt->bind_result($status_id);
            $stmt->fetch();

            // Prepare the update query for payment status
            $updateStmt = $db->prepare("UPDATE appointments 
                                        SET payment_status_id = ? 
                                        WHERE appointment_id = ?");
            
            foreach ($appointments as $appointmentId) {
                // Bind the payment status ID and appointment ID
                $updateStmt->bind_param('ii', $status_id, $appointmentId);
                $updateStmt->execute();
            }

            echo json_encode(['status' => 'success', 'message' => 'Payment status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid payment status.']);
        }
        
        $stmt->close();
        $updateStmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No appointments selected or payment status missing.']);
    }
}

$db->close();
?>
