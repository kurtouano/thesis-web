<?php

require 'require/dbconf.php';
require 'require/login-require.php';

// Set default dates to today
$fromDate = date('Y-m-d');
$toDate = date('Y-m-d');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected dates
    $fromDate = $_POST['from_date'];
    $toDate = $_POST['to_date'];
}

// Prepare the SQL query based on the selected dates
$recentTransactions = mysqli_query($conn, "SELECT id, email, sector, rfid_uid, pet_quantity, aluminum_quantity, glass_quantity, points_earned, timestamp 
    FROM transaction_records 
    WHERE DATE(timestamp) BETWEEN '$fromDate' AND '$toDate' 
    ORDER BY id DESC");

// Get total materials
$totalMaterials = mysqli_query($conn, "
    SELECT 
        SUM(pet_quantity) AS total_plastic, 
        SUM(aluminum_quantity) AS total_aluminum, 
        SUM(glass_quantity) AS total_glass 
    FROM transaction_records 
    WHERE DATE(timestamp) BETWEEN '$fromDate' AND '$toDate'
");

$total_plastic = 0;
$total_glass = 0;
$total_aluminum = 0;

if ($totalMaterials && $row = mysqli_fetch_assoc($totalMaterials)) {
    $total_plastic = $row['total_plastic'] ?? 0;
    $total_aluminum = $row['total_aluminum'] ?? 0;
    $total_glass = $row['total_glass'] ?? 0;
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
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/history.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>

<body>
    <nav class="sidenav-section">
        <div class="nav-logo">
            <button class="burger-sidenav">|||</button>
            <img class="nav-logo-img" src="assets/main-logo-light.png" alt="">
        </div>

        <div class="nav-icons-div">

            <a href="dashboard.php" class="nav-icons">
                <div class="nav-icons-content">
                    <img class="nav-icons-img" src="assets/dashboards-icon.png" alt="">
                    <span>Dashboard</span>
                </div>
            </a>

            <a href="history.php" class="nav-icons active">
                <div class="nav-icons-content">
                    <img class="nav-icons-img" src="assets/bins-icon.png" alt="">
                    <span>Transactions</span>
                </div>
            </a>

            <a href="create-acc.php" class="nav-icons">
                <div class="nav-icons-content">
                    <img class="nav-icons-img" src="assets/user-icon.png" alt="">
                    <span>Create Account</span>
                </div>
            </a>

            <a href="announcement.php" class="nav-icons">
                <div class="nav-icons-content">
                    <img class="nav-icons-img" src="assets/announcements-icon.png" alt="">
                    <span>Announcements</span>
                </div>
            </a>

            <button class="nav-icons logout-btn" id="logoutBtn">
                <div class="nav-icons-content">
                    <img class="nav-icons-img" src="assets/logout-icon.png" alt="">
                    <span>Logout</span>
                </div>
            </button>

            <p class=footer>&copy; Omnia Revendit 2024</p>

        </div>
    </nav>

    <main class="main-section">
        <div class="top-nav">
            <p class="top-nav-title">Transactions</p>

            <div class="top-nav-user-div">
                <p class="top-nav-user-name">Admin</p>
                <button class="top-nav-user-icon">
                    <img src="assets/user-icon2.png" alt="">
                </button>
            </div>
        </div>

        <div class="grid-main">
            <div class="dashboard-today-text">Total Materials (<?php echo date('F j, Y'); ?>)</div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #1D7031;">
                    <img src="assets/pet-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">PET Bottles</p>
                    <p class="total-items-text"> <?php echo $total_plastic ?> </p>
                </div>
            </div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #3ABF5D;">
                    <img src="assets/glass-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">Glass Bottles</p>
                    <p class="total-items-text"> <?php echo $total_glass ?> </p>
                </div>
            </div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #93cb8b;">
                    <img src="assets/can-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">Aluminum Cans</p>
                    <p class="total-items-text"> <?php echo $total_aluminum ?> </p>
                </div>
            </div>
        </div>

        <div class="recent-transaction-div">
            <p class="recent-transaction-text">Transaction History</p>

            <form method="post" class="date-selection-form">
                <input type="date" id="from_date" name="from_date" value="<?php echo $fromDate; ?>" required>
                <p> - </p>
                <input type="date" id="to_date" name="to_date" value="<?php echo $toDate; ?>" required>

                <button type="submit">Filter</button>
            </form>

            <div class="recent-transaction-table-div">
                <table>
                    <tr>
                        <th>Email</th>
                        <th>Sector</th>
                        <th>RFID UID</th>
                        <th>PET Qty</th>
                        <th>Aluminum Qty</th>
                        <th>Glass Qty</th>
                        <th>Points Earned</th>
                        <th>Timestamp</th>
                    </tr>

                    <?php
                    if ($recentTransactions->num_rows > 0) {
                        while ($row = $recentTransactions->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['sector'] . "</td>";
                            echo "<td>" . $row['rfid_uid'] . "</td>";
                            echo "<td>" . $row['pet_quantity'] . "</td>";
                            echo "<td>" . $row['aluminum_quantity'] . "</td>";
                            echo "<td>" . $row['glass_quantity'] . "</td>";
                            echo "<td>" . $row['points_earned'] . "</td>";
                            echo "<td>" . $row['timestamp'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No data available</td></tr>";
                    }
                    ?>
                </table>
            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/logout-listener.js"></script>
    <script src="js/nav-transitions.js"></script>

</body>

</html>