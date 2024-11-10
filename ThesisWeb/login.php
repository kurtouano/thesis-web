<?php

require 'require/dbconf.php';

session_start();

if (isset($_POST['login-submit'])) {
    $_SESSION['logEmail']  = $_POST['logEmail'];
    $logPass = $_POST['logPassword'];

    $verifyPass = $conn->prepare("SELECT acc_pass, is_admin, f_name FROM users_account WHERE acc_email = ?");
    $verifyPass->bind_param("s", $_SESSION['logEmail']);
    $verifyPass->execute();
    $verifyPassResult = $verifyPass->get_result();

    if ($verifyPassResult->num_rows > 0) {
        $user = $verifyPassResult->fetch_assoc();
        $hashedPassword = $user['acc_pass'];
        $isAdmin = $user['is_admin'];
        $fname = $user['f_name'];

        if (password_verify($logPass, $hashedPassword)) {
            session_regenerate_id(true);
            if ($isAdmin == 1) {
                $_SESSION['isAdmin'] = $isAdmin;
                $_SESSION['adminEmail'] = $_SESSION['logEmail'];
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['fname'] = $fname;
                $_SESSION['loginSuccess'] = 1;
                header("Location: user-dashboard.php");
                exit();
            }
        } else {
            $_SESSION['loginSuccess'] = 2;
        }
    } else {    
        $_SESSION['loginSuccess'] = 3;
    }

    $loginSuccess = $_SESSION['loginSuccess'] ?? ''; // Retrieve the value if it exists
    unset($_SESSION['loginSuccess']); 
    
}

session_destroy();
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
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="login-bg-img">

    <div class="login-content-div">
        <div class="login-column-order">
            <img src="assets/main-logo-dark.png" alt="">
            <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p class="form-title">Log in</p>

                <label for="logEmail"></label>
                <input type="email" name="logEmail" id="logEmail" placeholder="Email address" required>

                <label for="logPassword"></label>
                <input type="password" name="logPassword" id="logPassword" placeholder="Password" required>

                <button class="login-submit-btn" type="submit" name="login-submit">Sign in</button>
            </form>

            <button class="login-forgot-pass" onclick="forgetPass();">Forgot password?</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        let successNotif = <?php echo json_encode($loginSuccess ?? ''); ?>;
       
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
            <?php $loginSuccess = '' ?>;

        }

        function forgetPass() {
            Swal.fire({
                title: "Enter your email address",
                input: "email",
                inputPlaceholder: "Enter your email",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Submit",
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write an email!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const forgetPassEmail = result.value;

                    fetch('/ThesisWeb/require/forgotpass.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                email: forgetPassEmail
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Reset link sent!',
                                    text: data.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message,
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error); // Log the error for debugging
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to send reset link at this time.',
                            });
                        });
                }
            });
        }
    </script>
</body>

</html>