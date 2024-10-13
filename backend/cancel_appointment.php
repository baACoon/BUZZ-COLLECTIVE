<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$db = new mysqli('localhost', 'root', '', 'barbershop');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];

    if (!empty($appointments)) {
        // Prepared statement for update
        $stmt = $db->prepare("UPDATE appointments SET status_name = 'Cancelled' WHERE appointment_id = ?");
        foreach ($appointments as $appointmentId) {
            $stmt->bind_param('i', $appointmentId);
            $stmt->execute();
        }

        // Loop through each appointment for email notification
        $sql = "SELECT email, first_name, date, timeslot FROM appointments WHERE appointment_id = ?";
        $stmt = $db->prepare($sql);

        foreach ($appointments as $appointmentId) {
            $stmt->bind_param('i', $appointmentId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($email, $first_name, $date, $timeslot);
                $stmt->fetch();

                // Send email using PHPMailer
                require __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';  
                require __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php'; 
                require __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';   

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; 
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'buzzincollective@gmail.com';
                    $mail->Password   = 'nwpeckxgsmpbimlb';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom('no-reply@buzzcollective.com', 'Buzz & Collective');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $subject = "Your Appointment Has Been Cancelled";
                    $message = "Dear $first_name,\n\nWe regret to inform you that your appointment on $date at $timeslot has been cancelled.";
                    $mail->Body = nl2br($message);

                    $mail->send();
                } catch (Exception $e) {
                    echo json_encode(['status' => 'error', 'message' => 'Appointment cancelled but email failed: ' . $mail->ErrorInfo]);
                }
            }
        }

        // Response after all emails are processed
        echo json_encode(['status' => 'success', 'message' => 'Appointment(s) cancelled and email(s) sent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No appointments selected.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
