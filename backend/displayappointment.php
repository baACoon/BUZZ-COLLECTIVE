<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch appointments and join with payments
$sql = "SELECT 
            a.*,
            p.receipt,
            p.receipt_path,
            COALESCE(s.status_name, 'Pending') as payment_status
        FROM 
            appointments a
        LEFT JOIN 
            payments p ON a.appointment_id = p.appointment_id
        LEFT JOIN
            status s ON p.status_id = s.id -- Cedorrect to match the structure
        ORDER BY 
            a.appointment_id DESC";


$result = $db->query($sql);

if (!$result) {
    error_log("Query failed: " . $db->error);
    die("Query failed: " . $db->error);
}

// Handle POST request to update appointment status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointment_id'];
    $status = $_POST['status'];

    $sql = "UPDATE appointments SET status_name = ? WHERE appointment_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('si', $status, $appointmentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }

    $stmt->close();
}

// Fetch appointments data
$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Debug logging
        error_log("Processing appointment ID: " . $row['appointment_id']);
        error_log("Receipt path: " . ($row['receipt_path'] ?? 'null'));
        
        // Clean and validate the data
        $appointments[] = array_map(function($value) {
            return is_null($value) ? '' : htmlspecialchars($value);
        }, $row);
        
    }
}

// Close the database connection
$db->close();
?>