<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    // Check if the form is submitted correctly
    if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['email_id']) && isset($_POST['full_name'])) {

        // Include the database connection
        include "SQL_Connection.php";
        include "database_fetches.php";

        // Function to sanitize input data
        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Sanitize the user input
        $user_name = validate_input($_POST['user_name']);
        $password = validate_input($_POST['password']);
        $full_name = validate_input($_POST['full_name']);
        $email = validate_input($_POST['email_id']);
        $phone = validate_input($_POST['phone']);

        // Check if any of the required fields are empty
        if (empty($user_name) || empty($password) || empty($email) || empty($phone) || empty($full_name)) {
            $errormessage = "All fields are required!";
            header("Location: add-user.php?error=" . urlencode($errormessage));  // Redirect with error message
            exit();
        }

        $password = password_hash($password, PASSWORD_DEFAULT);



        // SQL query to insert the user data
        $data = array($full_name, $user_name, $email, $phone, $password, "employee");

        // Attempt to insert user
        insert_user($conn, $data);

        // After insertion, redirect back to add-user.php with success message (optional)
        $successMessage = "User added successfully!";
        header("Location: add-user.php?success=" . urlencode($successMessage));
        exit();

    } else {
        // If the form was not submitted correctly, redirect to add-user.php with error
        $errormessage = "Form was submitted incorrectly.";
        header("Location: add-user.php?error=" . urlencode($errormessage));  // Redirect with error message
        exit();
    }

} else {
    // If the session is not set, the user is not logged in
    $errormessage = "We require you to login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));  // Redirect to login.php with error
    exit();
}
?>
