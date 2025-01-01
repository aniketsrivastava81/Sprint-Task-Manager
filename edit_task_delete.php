<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    // Include the database connection
    include "SQL_Connection.php";

    // Check if task_id is provided in the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $task_id = $_GET['id'];

        // SQL query to delete the task from the database
        $delete_sql = "DELETE FROM tasks WHERE task_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->execute([$task_id]);

        $successMessage = "Task deleted successfully!";
        header("Location: task-list.php?success=" . urlencode($successMessage));
        exit();
    } else {
        $errormessage = "Task ID is missing!";
        header("Location: task-list.php?error=" . urlencode($errormessage));
        exit();
    }
} else {
    // If the user is not logged in, redirect to login page
    $errormessage = "We require you to login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>
