<?php

session_start();

$loginSuccess = $_SESSION['loginSuccess'] ?? '';
$logEmail = $_SESSION['logEmail'] ?? '';

if (empty($_SESSION['logEmail']) || empty($_SESSION['logEmail'])) {
    header("Location: login.php");
    exit();
}

?>