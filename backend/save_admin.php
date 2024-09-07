<?php
// Start the session
session_start();

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$errors = array();

// Check if the form was submitted
if (isset($_POST['save_admin'])) {
    // Get the form data
    $username = mysqli_real_escape_string($db, $_POST['admin-username']);
    $email = mysqli_real_escape_string($db, $_POST['admin-email']);
    $password = mysqli_real_escape_string($db, $_POST['admin-password']);

    // Form validation: ensure that the form is correctly filled
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    // Check if the user already exists
    $user_check_query = "SELECT * FROM admin WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // If no errors, save the new admin
    if (count($errors) == 0) {
        // Encrypt the password before saving in the database
        $password = md5($password);

        // Insert the new admin into the database
        $query = "INSERT INTO admin (username, email, password) VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);

        // Redirect to the settings page or another page
        $_SESSION['success'] = "New admin added successfully";
        header('location: settings.php');
        exit();
    } else {
        // Redirect back with errors
        $_SESSION['errors'] = $errors;
        header('location: settings.php');
        exit();
    }
}
?>
