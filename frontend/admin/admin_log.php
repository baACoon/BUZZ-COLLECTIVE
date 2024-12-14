<?php include($_SERVER['DOCUMENT_ROOT'] . '/Buzz-collective/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BUZZ Collective</title>
    <!-- Updated to ensure paths work for the admin subdomain -->
    <link rel="stylesheet" href="/Designs/admin-logreg.css?v=101">
</head>
<body>
    <div id="buzz-img">
        <!-- Updated image path -->
        <img src="/images/BUZZ-White2.png" alt="Buzz Logo">
    </div>
    <div class="login-container">
        <?php 
        // Include error handling file if needed
        include($_SERVER['DOCUMENT_ROOT'] . '/Buzz-collective/frontend/errors.php'); 
        ?>
        <form class="login-form" method="post" action="/admin_log.php">
            <h4>USERNAME</h4>
            <input type="text" placeholder="Username" name="username" required style="font-family:'Montserrat', sans-serif;">
            <h4>PASSWORD</h4>
            <input type="password" placeholder="Password" name="password" required style="font-family:'Montserrat', sans-serif;">
            
            <div style="display: flex; justify-content: space-between; width: 100%; max-width: 300px;">
                <a href="/admin_reg.php">Sign Up</a> <!-- Fixed link -->
            </div>
            
            <button type="submit" name="log_admin" style="font-family:'Montserrat', sans-serif;">Login</button>
        </form>
    </div>
</body>
</html>
