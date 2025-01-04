<?php
session_start();
include "SQL_Connection.php";  // Include DB connection

if (isset($_GET['notification_id'])) {
    // Mark notification as read
    $notification_id = $_GET['notification_id'];
    $userId = $_SESSION['id'];
    
    $sql = "UPDATE notifications SET is_read = 1 WHERE id = ? AND recipient = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $notification_id, $userId);
    $stmt->execute();
    
    // Redirect to the notifications page after marking as read
    header("Location: notifications.php");
    exit();
} else {
    // If no notification ID is passed, redirect to the notifications page
    header("Location: notifications.php");
    exit();
}
?>
