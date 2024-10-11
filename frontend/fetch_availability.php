<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

// Fetch the start and end date parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d', strtotime('+6 days'));

// Fetch available barbers for the selected date range
$query = "SELECT * FROM barber_availability WHERE date BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($db, $query);

$availability_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $availability_data[] = [
        'barber_name' => $row['barber_name'],
        'date' => $row['date'],
        'is_available' => $row['is_available']
    ];
}

// Return the availability data as JSON
echo json_encode($availability_data);

mysqli_close($db);
?>
