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

    if (empty($username)) $errors[] = "Username is required";
    if (empty($password)) $errors[] = "Password is required";

    if (count($errors) == 0) {
        $query = "SELECT * FROM admin WHERE username='$username'";
        $result = mysqli_query($db, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $admin = mysqli_fetch_assoc($result);
            $stored_password = $admin['password'];

            // Check if the stored password is plain text
            if (password_verify($password, $stored_password)) {
                // Password is hashed and matches
                $_SESSION['admin_username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('Location: admin-home.php');
                exit();
            } elseif ($stored_password === $password) {
                // Password is in plain text and matches
                // Hash the plain text password and update the database
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $update_query = "UPDATE admin SET password='$hashed_password' WHERE username='$username'";
                mysqli_query($db, $update_query);

                // Log the user in
                $_SESSION['admin_username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('Location: admin-home.php');
                exit();
            } else {
                // Password mismatch
                $errors[] = "Wrong username/password combination";
            }
        } else {
            $errors[] = "Wrong username/password combination";
        }
    }
}

?>
