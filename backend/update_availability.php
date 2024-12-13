<?php
$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    if (!empty($startDate) && !empty($endDate)) {
        // Remove existing availability within the selected range
        $mysqli->query("DELETE FROM barber_availability WHERE date BETWEEN '$startDate' AND '$endDate'");

        // Insert new availability
        foreach ($_POST['availability'] as $barber => $dates) {
            foreach ($dates as $date => $available) {
                $stmt = $mysqli->prepare("INSERT INTO barber_availability (barber_name, date, available) VALUES (?, ?, ?)");
                $stmt->bind_param('ssi', $barber, $date, $available);
                $stmt->execute();
                $stmt->close();
            }
        }
        $response['success'] = true;
    }
}

echo json_encode($response);
?>
