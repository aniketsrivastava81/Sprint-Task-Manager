<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        // Include the database connection
        include "SQL_Connection.php";

        // SQL query to delete user from the database
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);

        // After deletion, redirect back with success message
        $successMessage = "User deleted successfully!";
        header("Location: user.php?success=" . urlencode($successMessage));
        exit();

    } else {
        // If user ID is missing, redirect with error message
        $errormessage = "User ID is missing!";
        header("Location: user.php?error=" . urlencode($errormessage));
        exit();
    }

} else {
    // If the user is not logged in
    $errormessage = "You need to log in first!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>
