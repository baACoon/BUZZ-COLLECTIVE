<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BUZZ Collective</title>
    <link rel="stylesheet" href="Designs/admindash.css">
</head>
<body>


    <div id="buzz-img">
        <img src="images/BUZZ-White.png" alt="">

    </div>
    <div class="login-container">
        <form class="login-form" method="post" action="admin_log.php">
            <h4>Username</h4>
            <input type="text" placeholder="Email" name="username"required>
            <h4>Password</h4>
            <input type="password" placeholder="Password" name="password" required>
            <button type="submit" name="log_admin">Login</button>
            <h3>Forgot Password</h3>
        <a href="admin_reg.php"> Sign up</a>
        </form>
       
    </div>
 
</body>
</html>