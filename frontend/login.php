<!--<?php //include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/server.php'); ?> -->
<?php include('../backend/server.php')?>


<!DOCTYPE html>
<html>
<head>
  <title>Buzz & Collective - log in</title>
  <link rel="icon" type="image/x-icon" href="frontend/design/image/buzznCollectives.jpg">
  <link rel="stylesheet" type="text/css" href="frontend/design/login.css?v=51">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>LOGIN</h2>
            <form method="post" action="frontend/login.php">
			<?php include('errors.php');?>
                <h4>USERNAME</h4>
                <input type="text" name="username" placeholder="Username" required style="font-family:'Montserrat', sans-serif;">
                <h4>PASSWORD</h4>
                <input type="password" name="password" placeholder="Password" required style="font-family:'Montserrat', sans-serif;">
                <input type="submit" value="Login" name="login_user" style="font-family:'Montserrat', sans-serif;">
            </form>
            <h3>Don't have account? <a href="frontend/register.php">SIGN UP</a>
            <h3>Forgot password?</h3>
        </div>
        <div class="image-section">
            <!-- Image and text overlay -->
        </div>
    </div>
</body>
</html>