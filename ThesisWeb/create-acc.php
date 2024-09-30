<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Website</title>

    <link rel="stylesheet" href="css/main.css"> 
    <link rel="stylesheet" href="css/dashboard.css"> 
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
            <form class="create-acc-form" action="<?php echo htmlspecialchars(string: $_SERVER["PHP_SELF"]); ?>" method="post">

                <label for="fName">First Name</label>
                <input type="text" name="fName" id="fName" required>

                <label for="lName">Last Name</label>
                <input type="text" name="lName" id="lName" required>

                <label for="phyicalAddress">Physical Address</label>
                <input type="text" name="phyicalAddress" id="phyicalAddress" required>

                <label for="createEmail">Email</label>
                <input type="email" name="createEmail" id="createEmail" required>

                <label for="createPassword">Password</label>
                <input type="text" name="createPassword" id="createPassword" required autocomplete="off">

                <label for="rfidTag">RFID TAG UID</label>
                <input type="text" name="rfidTag" id="rfidTag" placeholder="XX XX XX XX" required autocomplete="off">

                <button class="create-acc-submit-btn" type="submit" name="create-acc-submit">Create Account</button>

            </form>
        </div>

    </main>

</body>
</html>