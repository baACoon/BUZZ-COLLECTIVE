<?php 
// Connection to database 
session_start();

// Initializing variables
$username = "";
$email    = "";
$errors = array(); 

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
        echo "<tr>
                <td><input type='checkbox' name='select'></td>
                <td>{$row['id']}<br></td>
                <td>
                     {$row['username']}<br>
                </td>
                <td>
                     {$row['email']}<br>
                </td>
                <td>
                    {$row['password']}<br>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found.</td></tr>";
}

?>
