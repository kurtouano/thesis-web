<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    require 'require/dbconf.php';

    session_start();

    if (isset($_POST['create-acc-submit'])) {
        $fname = $_POST['fName']; 
        $lname = $_POST['lName'];  
        $physicalAddress = $_POST['physicalAddress'];  
        $email = $_POST['createEmail'];  

        $password = $_POST['createPassword'];  
        $hashPassword = password_hash($password, PASSWORD_DEFAULT); // Hash Password

        $rfidTag = strtoupper($_POST['rfidTag']);  // Convert to uppercase
        $rfidTagValid = str_replace(' ', '', $rfidTag); // Remove whitespaces

        // Check if Email Exists
        $emailCheckStmt = $conn->prepare("SELECT * FROM users_account WHERE acc_email = ?");
        $emailCheckStmt->bind_param("s", $email);
        $emailCheckStmt->execute();
        $emailCheckResult = $emailCheckStmt->get_result();

        // Check if RFID UID exists
        $rfidCheckStmt = $conn->prepare("SELECT * FROM users_account WHERE rfid_uid = ?");
        $rfidCheckStmt->bind_param("s", $rfidTagValid);
        $rfidCheckStmt->execute();
        $rfidCheckResult = $rfidCheckStmt->get_result();

        $_SESSION['success_message'] = array(); // Array to stack errors 
        $_SESSION['success_message_option'] = 0;

        if (strlen($rfidTagValid) < 8) { 
            $_SESSION['success_message'][] = 'RFID UID Should be 8 Characters Long.';
        }

        if ($emailCheckResult->num_rows > 0) {
            $_SESSION['success_message'][] = 'Email Already Exists.';
        } 
        
        if ($rfidCheckResult->num_rows > 0) {
            $_SESSION['success_message'][] = 'RFID UID Already Exists.';
        } 
        
        if (empty($_SESSION['success_message'])) {
            $insertStmt = $conn->prepare("INSERT INTO users_account (f_name, l_name, physical_address, acc_email, acc_pass, rfid_uid, time_stamp)
                VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $insertStmt->bind_param("ssssss", $fname, $lname, $physicalAddress, $email, $hashPassword,  $rfidTagValid);
            $insertStmt->execute();
        

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();                                            //Send using SMTP
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication                                  

                $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                $mail->Username   = 'kurt0216@gmail.com';                   //SMTP username
                $mail->Password   = 'wmelqvpugzbtuxhg';                     //APP PASSWORD
                
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('kurt0216@gmail.com', 'RevendIt'); //Sender
                $mail->addAddress('kurt0216@gmail.com', 'user');  //Recipient
            
                $mail->isHTML(true);                                  
                $mail->Subject = 'RevendIt Account Registration';
                $mail->Body = 
                        '
                        <h3>You have Successfully Registered your Email to RevendIt!</h3>
                        <hr>
                        <p>                          </p>
                        <h4>Account Details:</h4>
                        <p>Email: ' . htmlspecialchars($email) . '</p> 
                        <p>RFID UID: ' . htmlspecialchars($rfidTagValid) . '</p> 
                        <p>Access this link to view your account: <a href="#">RevendIt User Dashboard</a></p>
                        <hr>
                        <h4>Please Keep These Details in Confidentiality</h4>
                        
                        ';
                
                if ($mail->send()) {
                    $_SESSION['success_message_option'] = 1;
                    $_SESSION['success_message'][] = 'Account Created Successfully!';
                    
                } else {
                    $_SESSION['success_message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }  
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }

        header('Location: '. $_SERVER['PHP_SELF']);
        exit();
    }

    $conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Website</title>

    <link rel="stylesheet" href="css/main.css"> 
    <link rel="stylesheet" href="css/create-acc.css"> 
</head>

<body>
    <nav class="sidenav-section">
        <div class="nav-logo">
            <img class="nav-logo-img" src="assets/main-logo-light.png" alt="">
        </div>

        <div class="nav-icons-div">

            <a href="dashboard.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/dashboards-icon.png" alt="">
                Dashboard
            </a>

            <a href="bin-capacity.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/bins-icon.png" alt="">
                Bin Capacity
            </a>

            <a href="create-acc.php" class="nav-icons active">
                <img class="nav-icons-img" src="assets/user-icon.png" alt="">
                Create User Account
            </a>
            
            <a href="announcement.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/announcements-icon.png" alt="">
                Announcements
            </a>
            
        </div>
    </nav>

    <main>

        <div class="top-nav">
            <p class="top-nav-title">Create User Account</p>
            <div class="top-nav-user-div">
                <p class="top-nav-user-name">Admin</p>
                <button class="top-nav-user-icon">
                    <img src="assets/create-account-icon.png" alt="">
                </button>
            </div>
        </div>

        <div class="create-acc-form-div">
            <form class="create-acc-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="fName" id="fName" placeholder="First Name" required>
                <input type="text" name="lName" id="lName" placeholder="Last Name" required>
                <input type="text" name="physicalAddress" id="physicalAddress" placeholder="Physical Address" required>
                <input type="email" name="createEmail" id="createEmail" placeholder="Email" required>
                <input type="text" name="createPassword" id="createPassword" placeholder="Password" autocomplete="off" required>
                <input type="text" name="rfidTag" id="rfidTag" placeholder="RFID UID (8 Characters Long)" required autocomplete="off" maxlength="8">
                <button class="create-acc-submit-btn" type="submit" name="create-acc-submit">Create Account</button>

            </form>
        </div>

    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script> 
        let messageTextOption = "<?php echo $_SESSION['success_message_option'] ?? ''; ?>"; 
        let messageText = "<?php echo implode('\\n', $_SESSION['success_message'] ?? ''); ?>"; 

        if (messageText != '') {
            if (messageTextOption == 1) {
                Swal.fire({
                    title: "SUCCESS!",
                    text: messageText,
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "ERROR",
                    text: messageText,
                    icon: "error"
                });
            }            
        }

        <?php 
            unset($_SESSION['success_message_option']);
            unset($_SESSION['success_message']);
            ?>


    </script>


    
</body>
</html>