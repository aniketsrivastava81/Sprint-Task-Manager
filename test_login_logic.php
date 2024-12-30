<?php

// Start the session at the beginning
session_start();

// Include the database connection
include "SQL_Connection.php";

// Function to sanitize input data
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form was submitted with both user_name and password
if (isset($_POST['user_name']) && isset($_POST['password'])) {

    // Sanitize the user input
    $user_name = validate_input($_POST['user_name']);
    $password = validate_input($_POST['password']);

    // Check if user_name is empty
    if (empty($user_name)) {
        $errormessage = "User name is empty!!";
        header("Location: login.php?error=" . urlencode($errormessage));  // Use urlencode for special characters
        exit();
    }

    // Check if password is empty
    if (empty($password)) {
        $errormessage = "Password is empty!!";
        header("Location: login.php?error=" . urlencode($errormessage));
        exit();
    }

    // SQL query to select the user by username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_name]);

    // Check if user exists
    if ($stmt->rowCount() == 1) {
        // Fetch the user data from the database
        $user = $stmt->fetch();
        $usernameDb = $user['username'];
        $passwordDb = $user['password'];
        $role = $user['role'];
        $id = $user['user_id'];

        // Check if the username matches
        if ($user_name === $usernameDb) {

            // Verify the password
            if (password_verify($password, $passwordDb)) {

                // Set session variables based on the role
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $usernameDb;

                // Redirect based on the user role
                if ($role == "admin") {
                    header("Location: index.php");
                } elseif ($role == "employee") {
                    header("Location: index.php");
                } else {
                    // Unknown role
                    $errormessage = "An unknown error has occurred.";
                    header("Location: login.php?error=" . urlencode($errormessage));
                    exit();
                }

            } else {
                // Incorrect password
                $errormessage = "Incorrect Password.";
                header("Location: login.php?error=" . urlencode($errormessage));
                exit();
            }

        } else {
            // Incorrect username
            $errormessage = "Incorrect Username.";
            header("Location: login.php?error=" . urlencode($errormessage));
            exit();
        }

    } else {
        // User not found in the database
        $errormessage = "An unknown error has occurred.";
        header("Location: login.php?error=" . urlencode($errormessage));
        exit();
    }

} else {
    // The form was not submitted properly
    $errormessage = "An unknown error has occurred.";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>
