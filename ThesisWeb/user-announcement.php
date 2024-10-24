<?php


require 'require/dbconf.php';

session_start();
$logEmail = $_SESSION['logEmail'] ?? '';

$sql = "SELECT id, announce_title, announce_body, 
        DATE_FORMAT(announce_sched_start, '%M %d, %Y %l:%i %p') AS formatted_sched_start, 
        DATE_FORMAT(announce_sched_end, '%M %d, %Y %l:%i %p') AS formatted_sched_end, 
        DATE_FORMAT(timestamp, '%M %d, %Y') AS display_timestamp 
        FROM announcements 
        ORDER BY timestamp DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Website</title>


    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/announcement.css">
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
                <p class="top-nav-user-name"><?= htmlspecialchars($logEmail) ?></p>
                <button class="top-nav-user-icon">
                    <img src="assets/user-icon2.png" alt="">
                </button>
            </div>
        </div>

        <div class="announcement-grid">
            <p class="announcement-latest-text">Latest Announcements</p>

            <div id="announcements-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="announcement-div" id="announcement-' . $row['id'] . '">';
                        echo '<div class="announcement-title">' . htmlspecialchars($row['announce_title']) . '<p class="announcement-timestamp">' . htmlspecialchars($row['display_timestamp']) . '</p></div>';
                        echo '<form method="POST" action="require/delete_announcement.php" style="display: inline;">'; // Form for deletion
                        echo '<input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">'; // Hidden input for the ID
                        echo '<button type="button" class="announcement-delete-each" onclick="confirmDelete(this)">Delete</button>';
                        echo '</form>';
                        echo '<p class="announcement-body">' . htmlspecialchars($row['announce_body']) . '</p>';
                        // Use formatted dates for displaying scheduled start and end
                        echo '<p class="announcement-event-date">' . htmlspecialchars($row['formatted_sched_start']) . ' - ' . htmlspecialchars($row['formatted_sched_end']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No announcements available.</p>';
                }
                ?>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>