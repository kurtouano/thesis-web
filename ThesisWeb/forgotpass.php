<?php

require 'require/dbconf.php';

session_start();
$logEmail = $_SESSION['logEmail'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Website</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <nav class="sidenav-section">
        <div class="nav-logo">
            <img class="nav-logo-img" src="assets/main-logo-light.png" alt="">
        </div>

        <div class="nav-icons-div">

            <a href="user-dashboard.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/bins-icon.png" alt="">
                Dashboard
            </a>

            <a href="user-announcement.php" class="nav-icons active">
                <img class="nav-icons-img" src="assets/announcements-icon.png" alt="">
                Announcements
            </a>

        </div>
    </nav>

    <main>

        <div class="top-nav">
            <p class="top-nav-title">Announcements</p>
            <div class="top-nav-user-div">
                <p class="top-nav-user-name"><?= $logEmail ?></p>
                <button class="top-nav-user-icon">
                    <img src="assets/user-icon2.png" alt="">
                </button>
            </div>
        </div>


    </main>



</body>

</html>