<?php
$mysqli = new mysqli('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch barber details
$barbers_query = "SELECT name, age, work, experience, position, image FROM barbers ORDER BY name";
$barbers_result = $mysqli->query($barbers_query);

$barbers = [];
if ($barbers_result) {
    while ($row = $barbers_result->fetch_assoc()) {
        $barbers[] = $row;
    }
} else {
    echo "<p class='error'>Error fetching barbers: " . $mysqli->error . "</p>";
}

$mysqli->close();

?>