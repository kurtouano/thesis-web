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

            <a href="dashboard.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/dashboards-icon.png" alt="">
                Dashboard
            </a>

            <a href="bin-capacity.php" class="nav-icons active">
                <img class="nav-icons-img" src="assets/bins-icon.png" alt="">
                Bin Capacity
            </a>

            <a href="create-acc.php" class="nav-icons">
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

    <?php require 'require/topnav.php'; ?>

        <div class="grid-main">

        <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #1D7031;">
                    <img src="assets/pet-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">PET Bottles</p>
                    <p class="total-items-text"> 60% </p>
                </div>
            </div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #3ABF5D;">
                    <img src="assets/glass-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">Glass Bottles</p>
                    <p class="total-items-text"> 30% </p>
                </div>
            </div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #93cb8b;">
                    <img src="assets/can-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">Aluminum Cans</p>
                    <p class="total-items-text"> 50% </p>
                </div>
            </div>

        </div>

    </main>

</body>
</html>