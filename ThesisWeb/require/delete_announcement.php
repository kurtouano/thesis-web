<?php
require '../require/dbconf.php'; // Ensure the correct path to your dbconf.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the ID from the POST data
    $id = $_POST['id'];

    // Prepare the SQL statement to delete the announcement
    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back or return a success message
        header('Location: ../announcement.php'); // Change to your redirect page
        exit;
    } else {
        json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
