<?php include('../backend/server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<link rel="stylesheet" href="../frontend/design/register.css?v=51">
    <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
    <title>Sign Up - BUZZ Collective</title>

</head>
<body>
    <div class="signup-container">
        <div class="signup-form-container">
        <?php include('errors.php'); ?>
            <h2>REGISTER</h2>
            <form class="signup-form" method="POST" action="register.php" >
                <h4>USERNAME</h4>
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required style="font-family:'Montserrat', sans-serif;">
                <h4>EMAIL</h4>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required style="font-family:'Montserrat', sans-serif;">
                <h4>PASSWORD</h4>
                <input type="password" name="password_1" placeholder="Password" required style="font-family:'Montserrat', sans-serif;">
                <h4>CONFIRM PASSWORD</h4>
                <input type="password" name="password_2" placeholder="Confirm Password" required style="font-family:'Montserrat', sans-serif;">
                <input type="submit" value="Sign up" name="reg_user" style="font-family:'Montserrat', sans-serif;">
            </form>
            <h3>Already a member? <a href="login.php">Login</a></h3>
        </div>
        <div class="signup-image">
            
        </div>

    </div>
</body>
</html>