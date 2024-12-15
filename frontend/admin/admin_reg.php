<?php include($_SERVER['DOCUMENT_ROOT'] . '/Buzz-collective/backend/admindash.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - BUZZ Collective</title>
    <base href="https://admin.buzzcollective.gayvar.com/Buzz-collective/">
    <link rel="stylesheet" href="/admin/Designs/admin-logreg.css?v=101">
</head>
<body>
    <div id="buzz-img">
        <img src="images/BUZZ-White2.png" alt="Buzz Logo">
    </div>
    <div class="login-container2">
        <?php 
        if (isset($errors) && count($errors) > 0): ?>
            <div class="error-message">
                <?php foreach ($errors as $error) echo $error . '<br>'; ?>
            </div>
        <?php endif; ?>
        <form class="login-form2" method="POST" action="backend/admindash.php">
            <h4>USERNAME</h4>
            <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
            <h4>EMAIL</h4>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <h4>PASSWORD</h4>
            <input type="password" name="password_1" placeholder="Password" required>
            <h4>CONFIRM PASSWORD</h4>
            <input type="password" name="password_2" placeholder="Confirm Password" required>
            <button type="submit" name="reg_admin">Sign Up</button>
            <a href="admin_log.php">Login</a>
        </form>
    </div>
</body>
</html>
