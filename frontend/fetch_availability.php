<?php
header('Content-Type: application/json');

$mysqli = new mysqli('localhost', 'root', '', 'barbershop');


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the current week's Monday and Friday dates
$monday = date('Y-m-d', strtotime('this Monday'));
$friday = date('Y-m-d', strtotime('this Friday'));

// Query the database for availability data within the current week
$sql = "SELECT barber_name, date, is_available FROM barber_availability WHERE date BETWEEN '$monday' AND '$friday'";
$result = $mysqli->query($sql);
error_log($mysqli->error);

$availability = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $availability[] = $row;
    }
} else {
    error_log("No availability data found for the current week.");
}
$mysqli->close();

echo json_encode($availability);
?>