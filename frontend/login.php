<!--<?php //include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/server.php'); ?> -->
<?php include('../backend/server.php')?>


<!DOCTYPE html>
<html>
<head>
  <title>Buzz & Collective - log in</title>
  <link rel="stylesheet" type="text/css" href="design/login_register.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <form method="post" action="login.php">
			<?php include('errors.php'); ?>
                <h4>Username</h4>
                <input type="text" name="username" placeholder="Username" required>
                <h4>Password</h4>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login" name="login_user">
            </form>
            <h3>Forgot password?</h3>
            <a href="register.php"> Sign up</a>
        </div>
        <div class="image-section">
            <!-- Image and text overlay -->
        </div>
    </div>
</body>
</html>