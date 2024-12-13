<?php include($_SERVER['DOCUMENT_ROOT'] . '/Buzz-collective/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BUZZ Collective</title>
    <!-- Updated base URL -->
    <base href="https://buzzcollective.gayvar.com/Buzz-collective/">
    <!-- Corrected stylesheet path -->
    <link rel="stylesheet" href="frontend/admin/Designs/admin-logreg.css">
</head>
<body>

    <div id="buzz-img">
        <!-- Corrected image path -->
        <img src="frontend/admin/images/BUZZ-White2.png" alt="Buzz Logo">
    </div>

    <div class="login-container">
        <?php 
        // Ensure errors.php path is correct
        include($_SERVER['DOCUMENT_ROOT'] . '/Buzz-collective/frontend/errors.php'); 
        ?>
        <form class="login-form" method="post" action="frontend/admin/admin_log.php">
            <h4>USERNAME</h4>
            <input type="text" placeholder="Username" name="username" required style="font-family:'Montserrat', sans-serif;">
            <h4>PASSWORD</h4>
            <input type="password" placeholder="Password" name="password" required style="font-family:'Montserrat', sans-serif;">
            
            <div style="display: flex; justify-content: space-between; width: 100%; max-width: 300px;">
                <!--<a class="forgotpassword" href="#">Forgot Password</a>-->
                <a href="frontend/admin/admin_reg.php">Sign Up</a>
            </div>
            
            <button type="submit" name="log_admin" style="font-family:'Montserrat', sans-serif;">Login</button>
        </form>
    </div>
 
</body>
</html>
