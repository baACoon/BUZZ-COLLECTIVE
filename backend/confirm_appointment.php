<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 
// Database connection
$db = new mysqli('localhost', 'root', '', 'barbershop');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the correct POST name 'appointments[]'
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];

        if (!empty($appointments)) {
            error_log('Appointments array: ' . print_r($appointments, true));
            $stmt = $db->prepare("UPDATE appointments SET status_name = 'Confirmed' WHERE appointment_id = ?");
            foreach ($appointments as $appointmentId) {
                $stmt->bind_param('i', $appointmentId);
                $stmt->execute();
            }
    
            // Fetch appointment details for sending an email (if required)
            $sql = "SELECT email, first_name, date, timeslot FROM appointments WHERE appointment_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i',$appointments); // Use the last appointment ID
            $stmt->execute();
            $stmt->store_result();
    
            // Check if the appointment exists
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($email, $first_name, $date, $timeslot, $barber, $services, $barber);
                $stmt->fetch();
    
                // Prepare email notification using PHPMailer
                require __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';  
                require __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php'; 
                require __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';   
    
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';                                                                                                                                                                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'buzzincollective@gmail.com';                                                                                                                                                       // SMTP username
                    $mail->Password   = 'nwpeckxgsmpbimlb';                                                                                                                                                                 // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
 
    
                    $mail->setFrom('no-reply@buzzcollective.com', 'Buzz & Collective');
                    $mail->addAddress($email); // Add the customer's email
    
                    // Email content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Appointment is Confirmed!';
                    $mail->Body    = "Dear $first_name,<br><br>We are pleased to confirm your appointment with us. Below are the details of your appointment:\n <strong>Appointment Details:</strong>Date: $date<br>Time: $timeslot<br>Service: $services<br>Barber: $barber;<br><br>See you!<br>Buzz & Collective";
            
                    $mail->send();
                    echo json_encode(['status' => 'success', 'message' => 'Appointment confirmed and email sent successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['status' => 'success', 'message' => 'Appointment confirmed but email failed: ' . $mail->ErrorInfo]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Appointment not found.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }

    }
?>