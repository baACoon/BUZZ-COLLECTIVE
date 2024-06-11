<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbershops";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dummy data
$appointments = [];

// Fetch existing appointments from database
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_num'];
    $service = $_POST['services'];
    $stylist = $_POST['barber'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];
    $status = $_POST['status'];

    // Insert new appointment into database
    $stmt = $conn->prepare("INSERT INTO appointments (first_name, last_name, email, phone, service, stylist, date, time, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone, $service, $stylist, $date, $time, $status);
    
    if ($stmt->execute()) {
        // Fetch the newly inserted appointment
        $new_appointment_id = $stmt->insert_id;
        $sql = "SELECT * FROM appointments WHERE id = $new_appointment_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $appointments[] = $result->fetch_assoc();
        }
    }
    $stmt->close();
}

foreach ($appointments as $appointment) {
    echo "<tr>
            <td><input type='checkbox' name='select'></td>
            <td>{$appointment['id']}</td>
            <td>
                <strong>First Name:</strong> {$appointment['first_name']}<br>
                <strong>Last Name:</strong> {$appointment['last_name']}<br>
                <strong>Email:</strong> {$appointment['email']}<br>
                <strong>Phone Number:</strong> {$appointment['phone']}
            </td>
            <td>
                <strong>Service:</strong> {$appointment['service']}<br>
                <strong>Stylist:</strong> {$appointment['stylist']}
            </td>
            <td>
                <strong>Date:</strong> {$appointment['date']}<br>
                <strong>Time:</strong> {$appointment['time']}
            </td>
            <td class='status'>{$appointment['status']}</td>
          </tr>";
}

// Close connection
$conn->close();
?>
