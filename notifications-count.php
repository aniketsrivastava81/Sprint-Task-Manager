<?php
session_start();
include "SQL_Connection.php";  // Include DB connection

// Fetch unread notification count
$userId = $_SESSION['id'];
$sql = "SELECT COUNT(*) AS count FROM notifications WHERE recipient = ? AND is_read = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$notificationCount = $row['count'];

// Return notification count
echo $notificationCount > 0 ? "&nbsp;$notificationCount&nbsp;" : "";
?>
