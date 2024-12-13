<?php
$db = new mysqli('localhost', 'root', '', 'barbershop');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];
    if (!empty($appointments)) {
        error_log('Appointments array: ' . print_r($appointments, true));

        // Prepare the SQL to update the appointment status and payment option
        $stmt = $db->prepare("
            UPDATE appointments 
            SET status_name = 'Confirmed', 
                payment_option_name = (SELECT option_name FROM payment_options WHERE id = ?)
            WHERE appointment_id = ?
        ");
        
        foreach ($appointments as $appointmentId) {
            // Assuming you have payment_option_id in POST data, replace with the correct value as needed
            $paymentOptionId = 1; // Replace this with the actual payment option ID (1 for "Appointment Fee" or 2 for "Full Payment")
            
            $stmt->bind_param('ii', $paymentOptionId, $appointmentId);
            $stmt->execute();
        }

        // Fetch and display confirmation message without sending an email
        $sql = "SELECT first_name, date, timeslot, services, barber 
                FROM appointments 
                WHERE appointment_id = ?";
        $stmt = $db->prepare($sql);

        foreach ($appointments as $appointmentId) {
            $stmt->bind_param('i', $appointmentId); 
            $stmt->execute();
            $stmt->store_result();

            // Check if the appointment exists
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($first_name, $date, $timeslot, $services, $barber);
                $stmt->fetch();
                $formattedDate = date("F j, Y", strtotime($date));
                $servicesFormatted = str_replace('-', ' ', $services);
                $servicesFormatted = ucwords($servicesFormatted); 
                
                // Output a confirmation message (no email)
                echo json_encode([
                    'status' => 'success', 
                    'message' => "Appointment confirmed for $first_name on $formattedDate at $timeslot for $servicesFormatted with $barber."
                ]);
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Appointment not found for ID: ' . $appointmentId
                ]);
            }
        }
    }
}
?>
