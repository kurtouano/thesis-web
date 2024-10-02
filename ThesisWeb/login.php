<?php

    require 'require/dbconf.php';
    
    session_start();
    
    if (isset($_POST['login-submit'])){
        $_SESSION['logEmail']  = $_POST['logEmail'];
        $logPass = $_POST['logPassword'];

        $verifyPass = $conn->prepare("SELECT acc_pass FROM users_account WHERE acc_email = ?");
        $verifyPass->bind_param("s", $_SESSION['logEmail']);
        $verifyPass->execute();
        $verifyPassResult = $verifyPass->get_result();

        if ($verifyPassResult->num_rows > 0) {
            $user = $verifyPassResult->fetch_assoc();
            $hashedPassword = $user['acc_pass'];
            
            if (password_verify($logPass, $hashedPassword)) {
                $_SESSION['loginSuccess'] = 1;
                header("Location: user-dashboard.php");
                exit();
            } else {
                $_SESSION['loginSuccess'] = 2;
            }
        } else {
            $_SESSION['loginSuccess'] = 3;
        }

        $loginSuccess = $_SESSION['loginSuccess'];
        unset($_SESSION['loginSuccess']);

    }

    $conn->close();
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
                    <input type="email" name="logEmail" id="logEmail" placeholder="Email" required>

                    <label for="logPassword"></label>
                    <input type="password" name="logPassword" id="logPassword" placeholder="Password" required>

                    <a class="login-forgot-pass" href="#">Forgot Password</a>

                    <button class="login-submit-btn" type="submit" name="login-submit">Sign in</button>
                </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        let successNotif = <?php echo $loginSuccess ?? ''; ?>
        
        if (successNotif != '') {
            const Toast = Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                });
            if (successNotif == 2) {
                Toast.fire({
                icon: "error",
                title: "Incorrect Password"
                });
            } else if (successNotif == 3) {
                Toast.fire({
                icon: "error",
                title: "No Account Found with That Email Address"
                });
            }
            
           
        }

    </script>
</body>
</html>