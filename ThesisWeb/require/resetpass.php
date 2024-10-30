<?php
require 'dbconf.php'; // Include your database configuration
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if email and token are set in the URL
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    // Prepare a statement to check if the token is valid
    $stmt = $conn->prepare("SELECT * FROM users_account WHERE acc_email = ? AND reset_token = ? AND token_expires > NOW()");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, show the password reset form
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password</title>
            <link rel="stylesheet" href="../css/reset-pass.css">
            <link rel="stylesheet" href="../css/main.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <div class="reset-pass-div">
                <p class="reset-pass-name">Revendit</p>
                <p class="reset-pass-title">Reset Your Password</p>
                <form method="POST" action="">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <input type="password" name="new_password" placeholder="New password" required>
                    <button type="submit" name="reset_password">Reset Password</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid or expired token',
                text: 'Please request a new password reset link.',
                confirmButtonColor: '#3085d6'
            });
        </script>";
    }
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Invalid request',
            text: 'Required parameters are missing.',
            confirmButtonColor: '#3085d6'
        });
    </script>";
}

// Handle the form submission
if (isset($_POST['reset_password'])) {
    $newPassword = $_POST['new_password'];
    $email = $_POST['email'];
    $token = $_POST['token'];

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users_account SET acc_pass = ?, reset_token = NULL, token_expires = NULL WHERE acc_email = ? AND reset_token = ?");
    $stmt->bind_param("sss", $hashedPassword, $email, $token);

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Password Reset Successful',
                text: 'Your password has been reset successfully.',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../login.php'; // Redirect to login page after the alert is closed
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an issue resetting your password. Please try again.',
                confirmButtonColor: '#d33'
            });
        </script>";
    }

    // Close the connection
    $conn->close();
    exit();
}
?>
