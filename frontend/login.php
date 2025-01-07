<?php 
// Include the server logic file
include('../backend/server.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="design/image/buzznCollectives.jpg">
  <link rel="stylesheet" type="text/css" href="design/login.css?v=51">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>Buzz & Collective - Login</title>
</head>
<body>
  <div class="container">
    <div class="login-form">
      <h2>LOGIN</h2>
      <!-- Login form -->
      <form method="post" action="login.php"> <!-- Submit to self -->
        <?php 
          // Display error messages
          if (isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors']; 
            unset($_SESSION['errors']); // Clear errors after displaying
            include('errors.php'); 
          }
        ?>
        <h4>USERNAME</h4>
        <input type="text" name="username" placeholder="Username" required style="font-family:'Montserrat', sans-serif;">
        
        <h4>PASSWORD</h4>
        <input type="password" name="password" placeholder="Password" required style="font-family:'Montserrat', sans-serif;">
        
        <input type="submit" value="Login" name="login_user" style="font-family:'Montserrat', sans-serif;">
      </form>

      <h3>Don't have an account? <a href="register.php">SIGN UP</a></h3>
      <h3>Forgot password?</h3>
    </div>
    <div class="image-section">
      <!-- Add an image or content here if needed -->
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Fade in the body
        document.body.style.opacity = "1";

        // Animate the container and image section
        const container = document.querySelector(".container");
        const imageSection = document.querySelector(".image-section");

        setTimeout(() => {
            container.classList.add("visible");
            imageSection.classList.add("visible");
        }, 500); // Delay the animation slightly
    });
</script>

</body>
</html>
