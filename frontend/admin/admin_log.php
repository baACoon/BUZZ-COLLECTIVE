<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>

<!DOCTYPE html>
<html>
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
    <div class="login-container">
        <form class="login-form" method="post" action="admin_log.php">
            <h4>Username</h4>
            <input type="text" placeholder="Email" name="username" required>
            <h4>Password</h4>
            <input type="password" placeholder="Password" name="password" required>
            
            <div style="display: flex; justify-content: space-between; width: 100%; max-width: 300px;">
                <a class="forgotpassword" href="#">Forgot Password</a>
                <a href="admin_reg.php">Sign Up</a>
            </div>
            
            <button type="submit" name="log_admin">Proceed</button>
        </form>
    </div>
 
</body>
</html>