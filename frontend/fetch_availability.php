<?php
header('Content-Type: application/json');

$mysqli = new mysqli('localhost', 'root', '', 'barbershop');

if ($mysqli->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $mysqli->connect_error]));
}

// Get current week's dates
$startDate = date('Y-m-d', strtotime('monday this week'));
$endDate = date('Y-m-d', strtotime('sunday this week'));

// Fetch all barber availability for the current week
$query = "SELECT ba.barber_name, ba.date, ba.is_available 
          FROM barber_availability ba 
          WHERE ba.date BETWEEN ? AND ?
          ORDER BY ba.date, ba.barber_name";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('ss', $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

$availability = [];
while ($row = $result->fetch_assoc()) {
    $availability[] = [
        'barber_name' => $row['barber_name'],
        'date' => $row['date'],
        'is_available' => (bool)$row['is_available']
    ];
}

$stmt->close();
$mysqli->close();

echo json_encode($availability);