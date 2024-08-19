<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BUZZ Collective</title>
    <link rel="stylesheet" href="Designs/admin-logreg.css">
</head>
<body>
    <div id="buzz-img">
        <img src="images/BUZZ-White2.png" alt="">
    </div>
    <div class="login-container2">
        <form class="login-form2" method="POST" action="admin_reg.php" >
                <h4>Username</h4>
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                <h4>Email</h4>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                <h4>Password</h4>
                <input type="password" name="password_1" placeholder="Password" required>
                <h4>Confirm Password</h4>
                <input type="password" name="password_2" placeholder="Confirm Password" required>
                <button type="submit" name="reg_admin">Sign Up</button>
                <a href="admin_log.php">Login</a>
        </form>
    </div>
</body>
</html>
