<?php
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login ReVendIt</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">

</head>

<body class="login-bg-img">
    
    <div class="login-content-div">
        <div class="login-column-order">
            <img src="assets/main-logo-dark.png" alt="">
                <form class="login-form" action="<?php echo htmlspecialchars(string: $_SERVER["PHP_SELF"]); ?>" method="post">
                    <p class="form-title">Login</p>

                    <label for="logEmail"></label>
                    <input type="email" name="logEemail" id="logEmail" placeholder="Email" required>

                    <label for="logPassword"></label>
                    <input type="password" name="logPassword" id="logPassword" placeholder="Password" required>

                    <button class="login-submit-btn" type="submit" name="logSubmit">Sign in</button>
                </form>
        </div>
    </div>
    
</body>
</html>