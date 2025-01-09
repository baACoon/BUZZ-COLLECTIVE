<?php
session_start();

// Connect to the database
$db = mysqli_connect('localhost', 'u634485059_root', '>nZ7/&Zzr', 'u634485059_barbershop');

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize variables
$username = "";
$email    = "";
$errors   = [];

// REGISTER ADMIN
if (isset($_POST['reg_admin'])) {
    $username   = mysqli_real_escape_string($db, $_POST['username']);
    $email      = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // Validate form inputs
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }

  // Password validation using regular expression
  if (strlen($password_1) < 6) {
    array_push($errors, "Password must be at least 6 characters long");
  }
  if (!preg_match('/[A-Za-z]/', $password_1)) {
    array_push($errors, "Password must contain at least one letter");
  }
  if (!preg_match('/[0-9]/', $password_1)) {
    array_push($errors, "Password must contain at least one number");
  }
  if (!preg_match('/[!$@%&_]/', $password_1)) {
    array_push($errors, "Password must contain at least one special character (!$@%&_)");
  }

    // Check for existing username or email
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
    

    // Register admin if no errors
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database
    
        $query = "INSERT INTO admin (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($db, $query);
        $_SESSION['admin_username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        $_SESSION['show_popup'] = true; //set popup flag
        header('location: admin-home.php');
    }
    }

// LOGIN ADMIN
if (isset($_POST['log_admin'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Check if inputs are empty
  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }


  // Proceed only if no validation errors
  if (count($errors) === 0) {
    $password = md5($password);

    // Query database for admin credentials
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    $rowCount = mysqli_num_rows($results); // Save the result for reuse

    switch ($rowCount) {
        case 1: // Successful login
            $_SESSION['admin_username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['show_popup'] = true; // Set popup flag
            header('location: admin-home.php');
            exit();

        case 0: // Wrong username/password combination
            array_push($errors, "Wrong username/password combination");
            break;

        default: // Unexpected result (e.g., multiple matches, which shouldn't happen)
            array_push($errors, "Unexpected error: multiple accounts found.");
            break;
    }
}

 // If there are errors, store them in session and redirect back
 if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('location: admin_log.php'); // Redirect back to login
    exit();
  }
}

?>
