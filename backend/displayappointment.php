<?php

$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch existing appointments from database
$sql = "SELECT * FROM appointments";
$result = $db->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointment_id'];
    $status = $_POST['status'];

    // Update the appointment status in the database
    $sql = "UPDATE appointments SET status_id = ? WHERE appointment_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('si', $status, $appointmentId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }

    $stmt->close();
    $db->close();
}

$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}
// Close connection
$db->close();
?>
