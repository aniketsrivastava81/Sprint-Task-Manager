<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    // Include the database connection
    include "SQL_Connection.php";
    include "database_fetches.php";

    if (isset($_POST['user_id'], $_POST['user_name'], $_POST['password'], $_POST['phone'], $_POST['email_id'], $_POST['full_name'])) {

        // Sanitize the input
        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $user_id = validate_input($_POST['user_id']);
        $user_name = validate_input($_POST['user_name']);
        $password = validate_input($_POST['password']);
        $full_name = validate_input($_POST['full_name']);
        $email = validate_input($_POST['email_id']);
        $phone = validate_input($_POST['phone']);

        // If password is not empty, hash it
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Retain the current password if it's not updated
            $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
            $password = $user['password'];
        }

        // Update user in the database
        $sql = "UPDATE users SET full_name = ?, username = ?, email_id = ?, phone = ?, password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$full_name, $user_name, $email, $phone, $password, $user_id]);

        // After successful update, redirect back with success message
        $successMessage = "User updated successfully!";
        header("Location: edit-user.php?user_id=" . $user_id . "&success=" . urlencode($successMessage));
        exit();

    } else {
        // Redirect with error if fields are missing
        $errormessage = "All fields are required!";
        header("Location: edit-user.php?user_id=" . $_POST['user_id'] . "&error=" . urlencode($errormessage));
        exit();
    }

} else {
    $errormessage = "You need to log in first!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>
