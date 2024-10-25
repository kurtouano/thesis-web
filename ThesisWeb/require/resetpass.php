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
            <link rel="stylesheet" href="css/main.css">
        </head>
        <body>
            <h2>Reset Your Password</h2>
            <form method="POST" action="">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "Invalid request.";
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
        echo "Your password has been reset successfully.";
    } else {
        echo "Error resetting password.";
    }

    // Close the connection
    $conn->close();
    exit();
}
?>
