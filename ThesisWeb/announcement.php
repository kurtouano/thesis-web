<?php
require 'require/dbconf.php';
require 'require/login-require.php';

// Fetch announcements from the database
$sql = "SELECT id, announce_title, announce_img, announce_body, 
        DATE_FORMAT(announce_sched_start, '%M %d, %Y %l:%i %p') AS formatted_sched_start, 
        DATE_FORMAT(announce_sched_end, '%M %d, %Y %l:%i %p') AS formatted_sched_end, 
        DATE_FORMAT(timestamp, '%M %d, %Y') AS display_timestamp 
        FROM announcements 
        ORDER BY timestamp DESC";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $announce_title = $_POST['announce_title'];
    $announce_body = $_POST['announce_body'];
    $announce_sched_start = $_POST['announce_sched_start'];
    $announce_sched_end = $_POST['announce_sched_end'];
    $announce_img = null;

    // Image handling
    if (isset($_FILES['announce_img']) && $_FILES['announce_img']['error'] == 0) {
        $imageFileType = strtolower(pathinfo($_FILES['announce_img']['name'], PATHINFO_EXTENSION));
        $targetDir = "assets/announcements-images/";
        $targetFile = $targetDir . uniqid() . '.' . $imageFileType;

        if (move_uploaded_file($_FILES['announce_img']['tmp_name'], $targetFile)) {
            $announce_img = $targetFile;
        } else {
            echo json_encode(['error' => 'Failed to upload image.']);
            exit();
        }
    }

    // Prepare SQL query with image conditionally
    $sql = "INSERT INTO announcements (announce_title, announce_img, announce_body, announce_sched_start, announce_sched_end) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $announce_title, $announce_img, $announce_body, $announce_sched_start, $announce_sched_end);

    if ($stmt->execute()) {
        $new_id = $stmt->insert_id;
        echo json_encode([
            'id' => $new_id,
            'announce_title' => $announce_title,
            'announce_img' => $announce_img,
            'announce_body' => $announce_body,
            'announce_sched_start' => $announce_sched_start,
            'announce_sched_end' => $announce_sched_end,
            'timestamp' => date('F d, Y')
        ]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Website</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/announcement.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
    <nav class="sidenav-section collapsed">
        <div class="nav-logo">
            <button class="burger-sidenav collapsed">|||</button>
            <img class="nav-logo-img collapsed" src="assets/main-logo-light.png" alt="">
        </div>

        <div class="nav-icons-div">
            <a href="dashboard.php" class="nav-icons">
                <div class="nav-icons-content">
                    <img class="nav-icons-img" src="assets/dashboards-icon.png" alt="">
                    <span>Dashboard</span>
                </div>
            </a>

            <a href="history.php" class="nav-icons">
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

            <a href="announcement.php" class="nav-icons active">
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

            <p class="footer collapsed">&copy; Omnia Revendit 2024</p>

        </div>
    </nav>

    <main class="main-section collapsed">
        <div class="top-nav">
            <p class="top-nav-title">Announcements</p>
            <div class="top-nav-user-div">
                <p class="top-nav-user-name">Admin</p>
                <button class="top-nav-user-icon">
                    <img src="assets/user-icon2.png" alt="">
                </button>
            </div>
        </div>

        <div class="announcement-grid">
            <p class="announcement-latest-text">Latest Announcements</p>
            <button class="announcement-add">Add Announcement</button>
            <button class="announcement-delete" id="toggle-delete">Delete</button>

            <div id="announcements-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="announcement-div" id="announcement-' . $row['id'] . '"> ';
                        echo '<div class="announcement-title">' . htmlspecialchars($row['announce_title']) . '<p class="announcement-timestamp">' . htmlspecialchars($row['display_timestamp']) . '</p></div>';
                        if (!empty($row['announce_img'])) {
                            echo '<div class="announcement-img-body-div"><img class="announcement-img" src="' . htmlspecialchars($row['announce_img']) . '"></div>';
                        }
                        echo '<p class="announcement-body">' . htmlspecialchars($row['announce_body']) . '</p>';
                        echo '<form method="POST" action="require/delete_announcement.php" style="display: inline;">'; // Form for deletion
                        echo '<input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">'; // Hidden input for the ID
                        echo '<button type="button" class="announcement-delete-each" onclick="confirmDelete(this)">Delete</button>';
                        echo '</form>';
                        echo '<p class="announcement-event-date">' . htmlspecialchars($row['formatted_sched_start']) . ' - ' . htmlspecialchars($row['formatted_sched_end']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<br><p> No announcements available.</p>';
                }

                ?>
            </div>
        </div>


        <div class="announcement-spacing-bottom"></div>

    </main>

    <div id="announcementModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Announcement</h2>
            <form id="announcementForm" method="POST" enctype="multipart/form-data">
                <label for="announce_title">Title:</label>
                <input type="text" id="announce_title" name="announce_title" required>

                <label for="announce_img">Add Image (Optional): </label>
                <input type="file" name="announce_img" id="announce_img" accept="image/*">

                <label for="announce_body">Description:</label>
                <textarea id="announce_body" name="announce_body" required></textarea>

                <label for="announce_sched_start">Start Date:</label>
                <input type="datetime-local" id="announce_sched_start" name="announce_sched_start" required>

                <label for="announce_sched_end">End Date:</label>
                <input type="datetime-local" id="announce_sched_end" name="announce_sched_end" required> <br>

                <input class="announcement-add-submit-btn" type="submit" value="Add Announcement">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/logout-listener.js"></script>
    <script src="js/announcement.js"></script>
    <script src="js/nav-transitions.js"></script>

</body>

</html>