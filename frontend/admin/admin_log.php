<?php include($_SERVER['DOCUMENT_ROOT'] . './Buzz-collective/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BUZZ Collective</title>
    <link rel="stylesheet" href="Designs/admin-logreg.css?v=101">
</head>
<body>
    <div id="buzz-img">
        <img src="/admin/images/BUZZ-White2.png" alt="Buzz Logo">
    </div>
    <div class="login-container">
        <?php 
        if (isset($errors) && count($errors) > 0): ?>
            <div class="error-message">
                <?php foreach ($errors as $error) echo $error . '<br>'; ?>
            </div>
        <?php endif; ?>
        <form class="login-form" method="post" action="/Buzz-collective/frontend/admin/admin_log.php">
            <h4>USERNAME</h4>
            <input type="text" placeholder="Username" name="username" required>
            <h4>PASSWORD</h4>
            <input type="password" placeholder="Password" name="password" required>
            <a href="./admin_reg.php">Sign Up</a>
            <button type="submit" name="log_admin">Login</button>
        </form>
    </div>
</body>
</html>
