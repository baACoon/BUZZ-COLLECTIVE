
<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

// Fetch the selected date parameter
$selected_date = isset($_GET['selected_date']) ? $_GET['selected_date'] : date('Y-m-d');

// Fetch available barbers for the selected date
$query = "SELECT barber_name, is_available FROM barber_availability WHERE date = '$selected_date' AND is_available = 1"; // Only fetch available barbers
$result = mysqli_query($db, $query);

$availability_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $availability_data[] = [
        'barber_name' => $row['barber_name'],
        'is_available' => (bool)$row['is_available'] // Ensure this is a boolean value
    ];
}

// Return the availability data as JSON
echo json_encode($availability_data);

mysqli_close($db);
?>
