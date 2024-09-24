<?php
$mysqli = new mysqli('localhost', 'root', '', 'barbershop');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch barber names
$barbers = ['Drey', 'Vien', 'Andro', 'Lili', 'Rego'];

// Initialize date range
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('next Monday'));
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d', strtotime('next Sunday', strtotime($startDate)));

// Fetch availability for the selected week
$sql = "SELECT barber_name, date, is_available FROM barber_availability WHERE date BETWEEN '$startDate' AND '$endDate'";
$result = $mysqli->query($sql);

$availability = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $availability[$row['barber_name']][$row['date']] = $row['is_available'];
    }
}
$mysqli->close();

$daysOfWeek = ['MON', 'TUE', 'WED', 'THU', 'FRI'];
?>