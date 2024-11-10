<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require 'dbconf.php'; // Ensure your database configuration is included

session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email']; // Get the email from the input

    // Prepare a statement to check if the email exists
    $stmt = $conn->prepare("SELECT acc_email FROM users_account WHERE acc_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(16)); // Generate a random token

        // Save the token to the database with an expiration date
        $stmt = $conn->prepare("UPDATE users_account SET reset_token = ?, token_expires = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE acc_email = ?");
        $stmt->bind_param("ss", $token, $email);

        if (!$stmt->execute()) {
            echo json_encode(["success" => false, "message" => "Failed to update token."]);
            exit();
        }

        $mail = new PHPMailer(true); // Use PHPMailer
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'revendit.system@gmail.com'; // SMTP username
            $mail->Password   = 'djuiribxqydjoufd'; // Your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('revendit.system@gmail.com', 'RevendIt');
            $mail->addAddress($email); // Recipient

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the link below to reset your password:<br>
                              <a href='https://www.revendit.site/ThesisWeb/require/resetpass.php?email={$email}&token={$token}'>Reset Password</a>";

            $mail->send();
            echo json_encode(["success" => true, "message" => "Reset password email has been sent."]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Mailer Error: {$mail->ErrorInfo}"]);
            error_log("Mailer Error: {$mail->ErrorInfo}"); // Log the error to the server log
        }
    } else {
        // Email not found in the database
        echo json_encode(["success" => false, "message" => "No account found with that email address."]);
    }

    // Close the connection
    $conn->close();
    exit(); // Terminate the script after sending response
}
?>
