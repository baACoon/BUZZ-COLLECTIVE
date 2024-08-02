<?php 
//connection to database 
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


//display clients  information
$sql = "SELECT * FROM users";
$result = $db ->query($sql);

if ($result - $num_rows > 0 ) {
    while($row = $result -> fetch_assoc()) {
        echo "<tr>
                <td><input type='checkbox' name='select'></td>
                <td>{$row['appointment_id']}<br></td>
                <td>
                    <strong>First Name:</strong> {$row['first_name']}<br>
                    <strong>Last Name:</strong> {$row['last_name']}<br>
                    <strong>Email:</strong> {$row['email']}<br>
                    <strong>Phone Number:</strong> {$row['phone_num']}
                </td>
                <td>
                    <strong>Service:</strong> {$row['services']}<br>
                    <strong>Stylist:</strong> {$row['barber']}
                </td>
                <td>
                    <strong>Date:</strong> {$row['appointment_date']}<br>
                    <strong>Time:</strong> {$row['appointment_time']}
                </td>
              </tr>";
    }
}

?>