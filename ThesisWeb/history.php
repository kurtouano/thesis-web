<?php
require 'require/dbconf.php';

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
$recentTransactions = mysqli_query($conn, "SELECT id, email, rfid_uid, material_type, material_quantity, points_earned, timestamp 
    FROM transaction_records 
    WHERE DATE(timestamp) BETWEEN '$fromDate' AND '$toDate' 
    ORDER BY id DESC");

// Get total materials
$getTotalMaterials = mysqli_query($conn, "SELECT material_type, SUM(material_quantity) AS total_quantity 
    FROM transaction_records
    WHERE DATE(timestamp) BETWEEN '$fromDate' AND '$toDate' 
    GROUP BY material_type"); 

$total_plastic = 0;
$total_glass = 0;
$total_aluminum = 0;

if ($getTotalMaterials->num_rows > 0) {
    while ($row = $getTotalMaterials->fetch_assoc()) {
        if ($row['material_type'] == 'Plastic') {
            $total_plastic = $row['total_quantity'];
        } elseif ($row['material_type'] == 'Glass') {
            $total_glass = $row['total_quantity'];
        } elseif ($row['material_type'] == 'Aluminum') {
            $total_aluminum = $row['total_quantity'];
        }
    }
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
            <img class="nav-logo-img" src="assets/main-logo-light.png" alt="">
        </div>

        <div class="nav-icons-div">

            <a href="dashboard.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/dashboards-icon.png" alt="">
                Dashboard
            </a>

            <a href="history.php" class="nav-icons active">
                <img class="nav-icons-img" src="assets/bins-icon.png" alt="">
                Transaction History
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

    <div class="top-nav">
        <p class="top-nav-title">Bin Capacity</p>
        <div class="top-nav-user-div">
            <p class="top-nav-user-name">Admin</p>
            <button class="top-nav-user-icon">
                <img src="assets/user-icon2.png" alt="">
            </button>
        </div>
    </div>

    <div class="grid-main">
        <div class="dashboard-today-text"><?php echo date(" F j, Y") . " (" . date("l") . ")"; ?></div>

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
                    <th>RFID UID</th>
                    <th>Material Type</th>
                    <th>Quantity</th>
                    <th>Points Earned</th>
                    <th>Timestamp</th>
                </tr>

                <?php
                    if ($recentTransactions->num_rows > 0) {
                        while($row = $recentTransactions->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['rfid_uid'] . "</td>";
                            echo "<td>" . $row['material_type'] . "</td>";
                            echo "<td>" . $row['material_quantity'] . "</td>";
                            echo "<td>" . $row['points_earned'] . "</td>";
                            echo "<td>" . $row['timestamp'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data available</td></tr>";
                    }
                ?>
            </table>
        </div>
        
    </div>

    </main>
    
</body>
</html>