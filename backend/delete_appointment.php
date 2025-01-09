<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Handle preflight request
    header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
}

// Allow from any origin
header("Access-Control-Allow-Origin: https://admin.buzzcollective.gayvar.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the correct POST name 'appointments[]'
    $appointments = isset($_POST['appointments']) ? $_POST['appointments'] : [];

    if (!empty($appointments)) {
        // Convert array to a comma-separated string of integers
        $idString = implode(',', array_map('intval', $appointments));

        // Database connection
        $db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

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
