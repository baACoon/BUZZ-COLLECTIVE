<?php
// client/book-appointment.php
require_once('../config/database.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    
    try {
        // Validate appointment time availability
        $check_query = "SELECT COUNT(*) FROM appointments 
                       WHERE appointment_date = ? 
                       AND appointment_time = ? 
                       AND barber = ?";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->execute([
            $_POST['appointment_date'],
            $_POST['appointment_time'],
            $_POST['barber']
        ]);
        
        if ($check_stmt->fetchColumn() > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'This time slot is already booked. Please choose another time.'
            ]);
            exit;
        }
        
        // Insert new appointment
        $query = "INSERT INTO appointments 
                 (name, phone_number, email, service, barber, appointment_date, appointment_time) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($query);
        $stmt->execute([
            $_POST['name'],
            $_POST['phone_number'],
            $_POST['email'],
            $_POST['service'],
            $_POST['barber'],
            $_POST['appointment_date'],
            $_POST['appointment_time']
        ]);
        
        $appointment_id = $db->lastInsertId();
        
        echo json_encode([
            'success' => true,
            'appointment_id' => $appointment_id,
            'message' => 'Appointment booked successfully!'
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>