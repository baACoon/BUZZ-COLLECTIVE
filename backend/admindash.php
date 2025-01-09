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
if (isset($_POST['log_admin'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Check if inputs are empty
  if (empty($username)) {
      $errors[] = "Username is required";
  }
  if (empty($password)) {
      $errors[] = "Password is required";
  }

  // Proceed only if no validation errors
  if (count($errors) === 0) {
      // Query database for admin credentials
      $query = "SELECT * FROM admin WHERE username = ?";
      $stmt = $db->prepare($query);
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 1) {
          $admin = $result->fetch_assoc();
          $hashed_password = $admin['password'];

          // Handle both hashed and plaintext passwords (for legacy accounts)
          if (password_verify($password, $hashed_password)) {
              $_SESSION['admin_username'] = $username;
              header('Location: admin-home.php');
              exit();
          } elseif ($hashed_password === md5($password)) {
              // If password is stored as md5, rehash it for security
              $new_hashed_password = password_hash($password, PASSWORD_BCRYPT);
              $update_query = "UPDATE admin SET password = ? WHERE username = ?";
              $update_stmt = $db->prepare($update_query);
              $update_stmt->bind_param("ss", $new_hashed_password, $username);
              $update_stmt->execute();

              $_SESSION['admin_username'] = $username;
              header('Location: admin-home.php');
              exit();
          } else {
              $errors[] = "Wrong username/password combination";
          }
      } else {
          $errors[] = "Wrong username/password combination";
      }

      $stmt->close();
  }


}


?>
