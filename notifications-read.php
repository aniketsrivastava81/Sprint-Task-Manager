<?php
session_start();
include "SQL_Connection.php";  // Include DB connection

if (isset($_GET['notifications_id'])) {
    // Mark notification as read
    $notification_id = $_GET['notifications_id'];
    $userId = $_SESSION['id'];
    
    // Prepare the SQL statement
    $sql = "UPDATE notifications SET is_read = 1 WHERE id = $notification_id AND recipient = $userId";
    
    // Execute the query
    if ($conn->exec($sql)) {
        // Redirect to the notifications page after marking as read
        header("Location: notifications.php");
        exit();
    } else {
        // If the update fails
        header("Location: notifications.php?alert=fail");
        exit();
    }
} else {
    // If no notification ID is passed, redirect to the notifications page with an alert
    header("Location: notifications.php?alert=failure");
    exit();
}
?>
