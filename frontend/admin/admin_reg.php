<?php include($_SERVER['DOCUMENT_ROOT'] . '/Buzz-collective/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - BUZZ Collective</title>
    <!-- Updated to ensure paths work for the admin subdomain -->
    <link rel="stylesheet" href="/Designs/admin-logreg.css?v=101">
</head>
<body>
    <div id="buzz-img">
        <!-- Updated image path -->
        <img src="/images/BUZZ-White2.png" alt="Buzz Logo">
    </div>
    <div class="login-container2">
        <?php 
        // Include error handling file
        include($_SERVER['DOCUMENT_ROOT'] . '/Buzz-collective/frontend/errors.php'); 
        ?>
        <form class="login-form2" method="POST" action="/admin_reg.php">
                <h4>USERNAME</h4>
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required style="font-family:'Montserrat', sans-serif;">
                <h4>EMAIL</h4>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required style="font-family:'Montserrat', sans-serif;">
                <h4>PASSWORD</h4>
                <input type="password" name="password_1" placeholder="Password" required style="font-family:'Montserrat', sans-serif;">
                <h4>CONFIRM PASSWORD</h4>
                <input type="password" name="password_2" placeholder="Confirm Password" required style="font-family:'Montserrat', sans-serif;">
                <button type="submit" name="reg_admin" style="font-family:'Montserrat', sans-serif;">Sign Up</button>
                <a href="/admin_log.php">Login</a> <!-- Fixed link -->
        </form>
    </div>
</body>
</html>
