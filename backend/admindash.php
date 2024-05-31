<?php

session_start();

$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'barbershop');

//ADMIN REGISTER 
if (isset($_POST['admin_reg'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required" ); }
    if (empty($password)) { array_push($errors, "Password is required" ); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    
    $user_check_query = "SELECT * FROM admin WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysql_fetch_assoc($result);

    if($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password_1);

        $query = "INSERT INTO admin (username,email,password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($db,$query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        $_SESSION['show_popup'] = true; //set popup flag
        header('location: ../frontend/admin/admin.php');
    }
}
//ADMIN LOGIN 
if (isset($_POST['admin_log'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['success'] = "You are now logged in";
        $_SESSION['show_popup'] = true; //set popup flag
          header('location: ../frontend/admin/admin.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }

?>