<?php 
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mysqli = new mysqli('localhost', 'root', '', 'barbershop');
$currentDateTime = new DateTime();
$nextHour = $currentDateTime->modify('+1 hour')->format('Y-m-d H:i:s');

// Fetch appointments for the next hour
$query = "SELECT * FROM appointments WHERE CONCAT(date, ' ', timeslot) = '$nextHour'";
$result = $mysqli->query($query);

while ($appointment = $result->fetch_assoc()) {
    // Send reminder email
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@example.com';
    $mail->Password = 'your-password';
    $mail->setFrom('your-email@example.com', 'Buzz & Collective');
    $mail->addAddress($appointment['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Reminder: Your Appointment is in 1 Hour';
    $mail->Body = 'Dear ' . $appointment['first_name'] . ',<br>' .
                  'This is a reminder that your appointment is in 1 hour.<br><br>' .
                  'Date: ' . $appointment['date'] . '<br>' .
                  'Time: ' . $appointment['timeslot'];
    $mail->send();
}


?>