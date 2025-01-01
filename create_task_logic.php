<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    // Check if the form is submitted correctly
    if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && isset($_POST['status']) && isset($_POST['priority']) && isset($_POST['visibility']) && isset($_POST['duration'])) {

        // Include the database connection
        include "SQL_Connection.php";

        // Sanitize the input data
        function validate_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $title = validate_input($_POST['title']);
        $description = validate_input($_POST['description']);
        $assigned_to = validate_input($_POST['assigned_to']);
        $status = validate_input($_POST['status']);
        $priority = validate_input($_POST['priority']);
        $visibility = validate_input($_POST['visibility']);
        $duration = validate_input($_POST['duration']);
        
        // Check if any required fields are empty
        if (empty($title) || empty($description) || empty($assigned_to) || empty($status) || empty($priority) || empty($visibility) || empty($duration)) {
            $errormessage = "All fields are required!";
            header("Location: create-task.php?error=" . urlencode($errormessage));  // Redirect with error message
            exit();
        }

        // SQL query to insert the task data
        $sql = "INSERT INTO tasks (title, description, assigned_to, status, priority, visibility, duration) VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $description, $assigned_to, $status, $priority, $visibility, $duration]);

            // Redirect to task list page with success message
            $successMessage = "Task created successfully!";
            header("Location: task-list.php?success=" . urlencode($successMessage));
            exit();

        } catch (Exception $e) {
            // Error handling
            $errormessage = "Error occurred while creating task: " . $e->getMessage();
            header("Location: create-task.php?error=" . urlencode($errormessage));  // Redirect with error message
            exit();
        }

    } else {
        // If the form is not submitted correctly, redirect to create-task.php with error
        $errormessage = "Form was submitted incorrectly.";
        header("Location: create-task.php?error=" . urlencode($errormessage));
        exit();
    }

} else {
    // If the user is not logged in, redirect to login page
    $errormessage = "We require you to login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));  // Redirect to login.php with error
    exit();
}
?>
