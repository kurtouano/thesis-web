<?php

    session_start();

    require 'require/dbconf.php';

    if (isset($_POST['create-acc-submit'])) {
        $fname = $_POST['fName']; 
        $lname = $_POST['lName'];  
        $physicalAddress = $_POST['physicalAddress'];  
        $email = $_POST['createEmail'];  
        $password = $_POST['createPassword'];  
        $hashPassword = password_hash($password, PASSWORD_DEFAULT); // Hash Password
        $rfidTag = $_POST['rfidTag'];  
        $rfidTagValid = str_replace(' ', '', $rfidTag); // Remove whitespace in input

        $checkExisting = mysqli_query($conn, "SELECT * FROM account_creation_history WHERE acc_email = '$email' OR rfid_uid = '$rfidTagValid' ");
        
        if (mysqli_num_rows($checkExisting) > 0 ) {
            $_SESSION['success_message'] = 'Error: Email or RFID UID Already Exists.';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); 
            
        } else {
            $createAccData = mysqli_query($conn, "INSERT INTO account_creation_history (f_name, l_name, physical_address, acc_email, acc_pass, rfid_uid, time_stamp)
                VALUES ('$fname', '$lname', '$physicalAddress', '$email', '$hashPassword', '$rfidTagValid', NOW())");
            $_SESSION['success_message'] = 'Account Created Successfully!';
            header("Location: " . $_SERVER['PHP_SELF']); 
            exit(); 
        }
    }

    if (isset($_SESSION['success_message'])) {
        echo "<script>alert(' " . $_SESSION['success_message'] . " ');</script>";
        unset($_SESSION['success_message']); 
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
                <p class="top-nav-user-name">Kurt Ouano</p>
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

</body>
</html>