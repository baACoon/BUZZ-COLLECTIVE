<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the correct POST name 'appointments[]'
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];

    if (!empty($appointments)) {
        // Convert array to a comma-separated string of integers
        $idString = implode(',', array_map('intval', $appointments));

        // Database connection
        $db = mysqli_connect('localhost', 'root', '', 'barbershop');

        if (!$db) {
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
            exit;
        }

        // Use correct table 'appointments'
        $sql = "DELETE FROM appointments WHERE appointment_id IN ($idString)";
        if (mysqli_query($db, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Appointments deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete appointments: ' . mysqli_error($db)]);
        }

        mysqli_close($db);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No appointment IDs received.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
