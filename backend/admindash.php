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
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password_1)) $errors[] = "Password is required";
    if ($password_1 !== $password_2) $errors[] = "The two passwords do not match";

    // Check for existing username or email
    $user_check_query = "SELECT * FROM admin WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) $errors[] = "Username already exists";
        if ($user['email'] === $email) $errors[] = "Email already exists";
    }

    // Register admin if no errors
    if (count($errors) == 0) {
        $hashed_password = password_hash($password_1, PASSWORD_BCRYPT);
        $query = "INSERT INTO admin (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($db, $query)) {
            $_SESSION['admin_username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('Location: admin-home.php');
            exit();
        } else {
            $errors[] = "Failed to register admin. Please try again.";
        }
    }
}

// LOGIN ADMIN
// LOGIN ADMIN
if (isset($_POST['log_admin'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Validate inputs
  if (empty($username)) {
      $errors[] = "Username is required";
  }
  if (empty($password)) {
      $errors[] = "Password is required";
  }

  // Only proceed if there are no validation errors
  if (count($errors) == 0) {
      // Fetch the hashed password from the database
      $query = "SELECT * FROM admin WHERE username='$username'";
      $result = mysqli_query($db, $query);

      if ($result && mysqli_num_rows($result) == 1) {
          $admin = mysqli_fetch_assoc($result);
          $hashed_password = $admin['password'];

          // Debugging: Log the retrieved password hash
          error_log("Database Password Hash: $hashed_password");
          error_log("Entered Password: $password");

          // Verify the password
          if (password_verify($password, $hashed_password)) {
              $_SESSION['admin_username'] = $username;
              $_SESSION['success'] = "You are now logged in";
              $_SESSION['show_popup'] = true; // Set popup flag
              header('Location: admin-home.php');
              exit();
          } else {
              $errors[] = "Wrong username/password combination";
          }
      } else {
          $errors[] = "Wrong username/password combination";
      }
  }


}


// OPTIONAL: Password Hashing Fix Script
// Uncomment this function and the call below only to hash existing plaintext passwords once.
// function hashPlaintextPasswords($db) {
//     $query = "SELECT id, password FROM admin";
//     $result = mysqli_query($db, $query);

//     while ($row = mysqli_fetch_assoc($result)) {
//         $id = $row['id'];
//         $password = $row['password'];

//         if (!password_get_info($password)['algo']) {
//             $hashed_password = password_hash($password, PASSWORD_BCRYPT);
//             $update_query = "UPDATE admin SET password='$hashed_password' WHERE id=$id";
//             mysqli_query($db, $update_query);
//         }
//     }
// }

// Uncomment this line only to hash plaintext passwords once.
// hashPlaintextPasswords($db);

?>
