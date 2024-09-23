<?php
header('Content-Type: application/json');

// Create connection
$mysqli = new mysqli('localhost', 'root', '', 'barbershop');
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch availability for the first week of the month
$sql = "SELECT barber_name, date, is_available FROM barber_availability WHERE date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$result = $mysqli->query($sql);

$availability = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $availability[] = $row;
    }
}
$mysqli->close();

echo json_encode($availability);
?>
