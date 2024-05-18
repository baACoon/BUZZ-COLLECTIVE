<?php include($_SERVER['DOCUMENT_ROOT'] . '/BUZZ-COLLECTIVE/backend/server.php'); ?>  


<!DOCTYPE html>
<html>
<head>
  <title>Buzz & Collective - log in</title>
  <link rel="stylesheet" type="text/css" href="design/login_register.css">
</head>
<body>
	 
<div class ="image-container">
	<div class="img29_6"></div>
</div>
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
	  <h2>Login</h2>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		<a href="register.php">Sign up</a>
  	</p>

</form>
</body>
</html>