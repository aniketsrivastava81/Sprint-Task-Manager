<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'employee') {
    // Include the necessary files for database connection
    include "SQL_Connection.php";
    
    if (isset($_GET['task_id']) && !empty($_GET['task_id'])) {
        $task_id = $_GET['task_id'];

        // Fetch the current task details from the database
        $sql = "SELECT * FROM tasks WHERE task_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$task_id]);

        if ($stmt->rowCount() > 0) {
            $task = $stmt->fetch();

            // Process the form when submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $status = $_POST['status'];
                $priority = $_POST['priority'];
                $duration = $_POST['duration'];

                // Update the task in the database
                $update_sql = "UPDATE tasks SET status = ?, priority = ?, duration = ? WHERE task_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->execute([$status, $priority, $duration, $task_id]);

                // Redirect back to employee-task.php with a success message
                $successMessage = "Task updated successfully!";
                header("Location: employee-task.php?success=" . urlencode($successMessage));
                exit();
            }
        } else {
            $errormessage = "Task not found!";
            header("Location: employee-task.php?error=" . urlencode($errormessage));
            exit();
        }
    } else {
        $errormessage = "Task ID is missing!";
        header("Location: employee-task.php?error=" . urlencode($errormessage));
        exit();
    }
} else {
    // If not logged in or not an employee, redirect to login page
    $errormessage = "You must log in as an employee to update tasks!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2>Edit Task</h2>

    <div class="edit-task-form">
        <form action="edit_task_employee.php?task_id=<?php echo $task['task_id']; ?>" method="POST">
            <label>Title</label>
            <input type="text" value="<?php echo htmlspecialchars($task['title']); ?>" readonly>

            <label>Description</label>
            <textarea readonly><?php echo htmlspecialchars($task['description']); ?></textarea>

            <label>Status</label>
            <select name="status">
                <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="in_progress" <?php echo ($task['status'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
            </select>

            <label>Priority</label>
            <select name="priority">
                <option value="High" <?php echo ($task['priority'] == 'High') ? 'selected' : ''; ?>>High</option>
                <option value="Medium" <?php echo ($task['priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="Low" <?php echo ($task['priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
                <option value="Wish" <?php echo ($task['priority'] == 'Wish') ? 'selected' : ''; ?>>Wish</option>
            </select>

            <label>Duration</label>
            <select name="duration">
                <option value="Long" <?php echo ($task['duration'] == 'Long') ? 'selected' : ''; ?>>Long</option>
                <option value="Medium" <?php echo ($task['duration'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="Short" <?php echo ($task['duration'] == 'Short') ? 'selected' : ''; ?>>Short</option>
                <option value="Unknown" <?php echo ($task['duration'] == 'Unknown') ? 'selected' : ''; ?>>Unknown</option>
            </select>

            <label>Due Date</label>
            <input type="text" value="<?php echo htmlspecialchars($task['due_date']); ?>" readonly> <!-- Display Due Date -->

            <button type="submit" class="update-btn">Update Task</button>
        </form>
    </div>
</body>
</html>
