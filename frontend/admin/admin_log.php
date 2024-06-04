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
    <div class="login-container">
        <h1>BUZZ Collective</h1>
        <form class="login-form" method="post" action="admin_log.php">

            <input type="text" placeholder="Email" name="username"required>
            <input type="password" placeholder="Password" name="password" required>
            <button type="submit" name="log_admin">Login</button>
        </form>
        <h3>Forgot password?</h3>
        <a href="admin_reg.php"> Sign up</a>
    </div>
</body>
</html>