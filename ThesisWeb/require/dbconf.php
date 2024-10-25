<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "revendit_1001";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
}

date_default_timezone_set('Asia/Manila');
