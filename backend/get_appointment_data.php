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

// Database connection
$conn = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of appointments grouped by date for the line graph
$sql_total_appointments = "
    SELECT DATE(date) AS appointment_date, COUNT(*) AS total_appointments 
    FROM appointments 
    GROUP BY DATE(date)";
$result_total = $conn->query($sql_total_appointments);

$appointments_by_date = [];
while ($row = $result_total->fetch_assoc()) {
    $appointments_by_date[] = $row;
}

// Fetch total number of appointments per barber for the second chart
$sql_appointments_per_barber = "
    SELECT barber, COUNT(*) AS barber_appointments 
    FROM appointments 
    GROUP BY barber";
$result_barber = $conn->query($sql_appointments_per_barber);

$appointments_by_barber = [];
while ($row = $result_barber->fetch_assoc()) {
    $appointments_by_barber[] = $row;
}

// Send data as JSON
echo json_encode([
    'appointments_by_date' => $appointments_by_date,
    'appointments_by_barber' => $appointments_by_barber
]);

$conn->close();
?>
