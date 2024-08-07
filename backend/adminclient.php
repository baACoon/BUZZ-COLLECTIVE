<?php 
session_start();

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Display clients' information
$sql = "SELECT * FROM users";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr id='client-row-{$row['id']}'>
                <td><input type='checkbox' name='ids[]' value='{$row['id']}'></td>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td>{$row['password']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found.</td></tr>";
}

mysqli_close($db);
?>
