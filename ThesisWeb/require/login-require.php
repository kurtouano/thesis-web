<?php

session_start();

$loginSuccess = $_SESSION['loginSuccess'] ?? '';
$logEmail = $_SESSION['logEmail'] ?? '';
$fname = $_SESSION['fname'] ?? '';

if (empty($_SESSION['logEmail'])) {
    header("Location: login.php");
    exit();
}

?>