<?php

//connection to database 

session_start();


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

//customer data
$sql = "SELECT username FROM users WHERE id = 1"; // Fetching customer with id = 1
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $customerName = $row["username"];
    }
} else {
    echo "0 results";
}
$db->close();

?>