<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - BUZZ Collective</title>
    <link rel="stylesheet" href="Designs/admindash.css">
</head>
<body>
    <div class="login-container">
        
        <h1>BUZZ Collective</h1>
        <form class="login-form" method="POST" action="admin_reg.php" >
              
                <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
             
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
               
                <input type="password" name="password_1" placeholder="Password" required>
            
                <input type="password" name="password_2" placeholder="Confirm Password" required>
                <input type="submit" value="Sign up" name="reg_admin">
        </form>
    </div>
</body>
</html>
