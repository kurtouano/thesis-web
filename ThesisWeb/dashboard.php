<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'require/dbconf.php';

$getBinsCapacity = mysqli_query($conn, "SELECT pet_bin, glass_bin, aluminum_bin, isBinFull, date_time FROM bins_capacity ORDER BY date_time DESC LIMIT 1");

if ($getBinsCapacity) {
    $row = mysqli_fetch_assoc($getBinsCapacity);

    if ($row) {
        $petBin = $row['pet_bin'];
        $glassBin = $row['glass_bin'];
        $aluminumBin = $row['aluminum_bin'];
        $lastStatus = $row['isBinFull'];
        $currentStatus = 'Not Full'; // Default status

        if ($petBin >= 95 || $glassBin >= 95 || $aluminumBin >= 95) {
            $currentStatus = 'Full';
        } else if ($petBin >= 80 || $glassBin >= 80 || $aluminumBin >= 80) {
            $currentStatus = 'Almost Full';
        }

        if ($currentStatus !== $lastStatus) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();                                            //Send using SMTP
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication                                  

                $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                $mail->Username   = 'revendit.system@gmail.com';            //SMTP username
                $mail->Password   = 'djuiribxqydjoufd';                     //APP PASSWORD

                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('revendit.system@gmail.com', 'RevendIt');    //Sender
                $mail->addAddress('kurt0216@gmail.com', 'user');            //Recipient

                $mail->isHTML(true);
                $mail->Subject = 'RevendIt Bin Status Update: ' . $currentStatus;
                $mail->Body = "
                            <h3>RevendIt Bin Status Notification</h3>
                            <p>Dear User,</p>

                            <p>We wanted to inform you that the status of your bin has been updated.</p>
                            <hr>
                            <p>As of Today, <strong>" . date('Y-m-d H:i:s') . "</strong>: </p>
                            <p>&nbsp;&nbsp;<strong> New Status:</strong> <span style='color: #ff6347;'>$currentStatus</span></p>
                            <p>&nbsp;&nbsp;<strong> PET Bin:</strong> $petBin% </p>
                            <p>&nbsp;&nbsp;<strong> Glass Bin:</strong> $glassBin% </p>
                            <p>&nbsp;&nbsp;<strong> Aluminum Bin:</strong> $aluminumBin% </p>
                            <hr>

                            <p>Please take the appropriate action as needed:</p>

                            <p>&nbsp;&nbsp;If the status is '<strong>Almost Full</strong>,' please prepare for collection soon.</p>
                            <p>&nbsp;&nbsp;If the status is '<strong>Full</strong>,' immediate attention is required for collection.</p>

                            <p>We appreciate your efforts in keeping the environment clean!</p>

                            <p>Thank you for using RevendIt!</p>
                            <p><strong>RevendIt Team</strong></p>
                            ";

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        $update_sql = "UPDATE bins_capacity SET isBinFull ='$currentStatus' WHERE date_time='" . $row['date_time'] . "'";
        mysqli_query($conn, $update_sql);
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

</head>

<body>
    <nav class="sidenav-section">
        <div class="nav-logo">
            <img class="nav-logo-img" src="assets/main-logo-light.png" alt="">
        </div>

        <div class="nav-icons-div">

            <a href="dashboard.php" class="nav-icons active">
                <img class="nav-icons-img" src="assets/dashboards-icon.png" alt="">
                Dashboard
            </a>

            <a href="history.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/bins-icon.png" alt="">
                Transaction History
            </a>

            <a href="create-acc.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/user-icon.png" alt="">
                Create Account
            </a>

            <a href="announcement.php" class="nav-icons">
                <img class="nav-icons-img" src="assets/announcements-icon.png" alt="">
                Announcements
            </a>

        </div>
    </nav>

    <main>

        <div class="top-nav">
            <p class="top-nav-title">Dashboard</p>
            <div class="top-nav-user-div">
                <p class="top-nav-user-name">Admin</p>
                <a href="login.php" class="top-nav-user-icon">
                    <img src="assets/user-icon2.png" alt="">
                </a>
            </div>
        </div>

        <div class="grid-main">
            <div class="dashboard-today-text">Bin Capacity</div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #1D7031;">
                    <img src="assets/pet-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">PET Bottles</p>
                    <p class="total-items-text"> <?php echo $petBin ?> % </p>
                </div>
            </div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #3ABF5D;">
                    <img src="assets/glass-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">Glass Bottles</p>
                    <p class="total-items-text"> <?php echo $glassBin ?> % </p>
                </div>
            </div>

            <div class="dashboard-div">
                <div class="dashboard-icon" style="background-color: #93cb8b;">
                    <img src="assets/can-icon.png" alt="">
                </div>
                <div class="dashboard-column-order">
                    <p class="material-name">Aluminum Cans</p>
                    <p class="total-items-text"> <?php echo $aluminumBin ?> % </p>
                </div>
            </div>

        </div>


        <div class="dashboard-charts-div">
            <div class="chart-date-text"></div> <!-- CHART TITLE -->
            <div class="chart-controls">
                <select id="timePeriod" onchange="changePeriod(this.value)">
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <div class="dashboard-charts">
                <canvas id="myBarChart"></canvas>
                <canvas id="myPieChart"></canvas>
            </div>
        </div>

    </main>

    <script src="js/dashboard-chart.js"></script>
</body>

</html>