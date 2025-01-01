<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    // Include the database connection
    include "SQL_Connection.php";

    // SQL query to fetch all tasks
    $sql = "SELECT tasks.task_id, tasks.title, tasks.description, tasks.status, tasks.priority, tasks.visibility, tasks.duration, users.full_name AS assigned_to, tasks.created_at 
            FROM tasks 
            LEFT JOIN users ON tasks.assigned_to = users.user_id"; // Joining the users table to get the 'assigned_to' employee name
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch all tasks
    $tasks = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2 class="u-name">Task List</h2>

    <div class="body">
        <section>
            <h4 class="title">All Tasks</h4>
            <a href="create-task.php" class="addbtn">Create Task</a>

            <!-- Display success or error messages -->
            <?php if (isset($_GET['error'])) { ?>
                <div class="danger" role="alert">
                    <?php echo stripcslashes($_GET['error']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo stripcslashes($_GET['success']); ?>
                </div>
            <?php } ?>

            <!-- Display tasks in a table -->
            <table class="task-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Visibility</th>
                        <th>Duration</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($tasks) > 0) { ?>
                        <?php foreach ($tasks as $task) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td><?php echo htmlspecialchars($task['assigned_to']); ?></td>
                                <td><?php echo htmlspecialchars($task['status']); ?></td>
                                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                                <td><?php echo htmlspecialchars($task['visibility']); ?></td>
                                <td><?php echo htmlspecialchars($task['duration']); ?></td>
                                <td><?php echo htmlspecialchars($task['created_at']); ?></td>
                                <td>
                                    <a href="edit_task.php?id=<?php echo $task['task_id']; ?>" class="edit-btn">Edit</a>
                                    <a href="edit_task_delete.php?id=<?php echo $task['task_id']; ?>" class="delete-btn">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8">No tasks found!</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>

<?php 
} else {
    // If the user is not logged in, redirect to login page
    $errormessage = "We require you to login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));  // Redirect to login.php with error
    exit();
}
?>
