<?php include('../backend/server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link rel="stylesheet" href="design/register.css">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <title>Sign Up - BUZZ Collective</title>

</head>
<body>
    <div class="signup-container">
        <div class="signup-image">
            <img src="buzzin-dept.png" alt="">
        </div>
        <div class="signup-form-container">
        <?php include('errors.php'); ?>
            <h2>Sign Up</h2>
            <form class="signup-form" method="POST" action="register.php" >
                <h4>Username</h4>
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                <h4>Email</h4>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                <h4>Password</h4>
                <input type="password" name="password_1" placeholder="Password" required>
                <h4>Confirm Password</h4>
                <input type="password" name="password_2" placeholder="Confirm Password" required>
                <input type="submit" value="Sign up" name="reg_user">
            </form>
            <h3>Already a member?<a href="login.php"> Login</a></h3>
        </div>

    </div>
</body>
</html>