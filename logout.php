<?php
session_start();
include 'db.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Update last_logout timestamp
    $current_time = date('Y-m-d H:i:s');
    $update_sql = "UPDATE users SET last_logout = '$current_time' WHERE username = '$username'";
    $conn->query($update_sql);

    // Destroy session and redirect to login page
    session_destroy();
    header("Location: login.php");
    exit();
}

$conn->close();
?>
