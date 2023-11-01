<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login - Billing System </title>
    <!-- reference -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
  <!-- header start -->
    <header>
        <img src="kyrol.png" alt="">
        <p style="font-family:consolas; font-weight:bold;">KYROL SECURITY LABS</p>
        <p style="font-size: 20px; padding-bottom: 15px; font-family:consolas; font-weight:bold;">Billing System 0.6</p>
    </header>
    <!-- header end -->

<div class="content">
    <div class="login-form">
        <h2>Login</h2>
        <form action="validate.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" autocomplete="off" required>

    <label for="adminPassword">Password:</label>
    <input type="password" name="adminPassword" id="adminPassword" autocomplete="off" required> <!-- Note the type="password" -->
    
    <input type="submit" name="login" value="Login" id="login-button">
</form>
      </div>
</div>
</body>
</html>