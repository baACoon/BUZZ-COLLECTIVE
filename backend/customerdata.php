<?php

//connection to database 

session_start();


// connect to the database
$db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

//customer data
$email = $_POST['email'];
$password = $_POST['password'];

// SQL to fetch the user
$sql = "SELECT id, username FROM users WHERE email = ? AND password = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];

    header("Location: myprofile.php"); // Redirect to profile page after login
    exit();
} else {
    echo "Invalid email or password.";
}

$stmt->close();
$db->close();

?>