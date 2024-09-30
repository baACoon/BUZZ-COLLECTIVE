<?php 
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mysqli = new mysqli('localhost', 'root', '', 'barbershop');
$currentDate = new DateTime();
$nextDay = $currentDate->modify('+1 day')->format('Y-m-d');

// Fetch appointments for the next day
$query = "SELECT * FROM appointments WHERE DATE(date) = '$nextDay'";
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
    $mail->Subject = 'Reminder: Your Appointment is Tomorrow';
    $mail->Body = 'Dear ' . $appointment['first_name'] . ',<br>' .
                  'This is a reminder for your appointment tomorrow.<br><br>' .
                  'Date: ' . $appointment['date'] . '<br>' .
                  'Time: ' . $appointment['timeslot'];
    $mail->send();
}

?>