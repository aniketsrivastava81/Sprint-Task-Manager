<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'employee') {
    // Include the necessary files for database connection
    include "SQL_Connection.php";
    include "employee_task_logic.php";

    $employee_id = $_SESSION['id']; // Get logged-in employee ID
    
    // Get the tasks assigned to the employee
    $tasks = get_employee_tasks($conn, $employee_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Tasks</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2>Your Tasks</h2>

    <div class="task-list">
        <?php if (count($tasks) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Duration</th>
                        <th>Due Date</th> <!-- Added the Due Date column -->
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                            <td><?php echo htmlspecialchars($task['title']); ?></td>
                            <td><?php echo htmlspecialchars($task['description']); ?></td>
                            <td>
                                <select name="status_<?php echo $task['task_id']; ?>" class="task-status">
                                    <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="in_progress" <?php echo ($task['status'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                </select>
                            </td>
                            <td>
                                <select name="priority_<?php echo $task['task_id']; ?>" class="task-priority">
                                    <option value="High" <?php echo ($task['priority'] == 'High') ? 'selected' : ''; ?>>High</option>
                                    <option value="Medium" <?php echo ($task['priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                    <option value="Low" <?php echo ($task['priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
                                    <option value="Wish" <?php echo ($task['priority'] == 'Wish') ? 'selected' : ''; ?>>Wish</option>
                                </select>
                            </td>
                            <td>
                                <select name="duration_<?php echo $task['task_id']; ?>" class="task-duration">
                                    <option value="Long" <?php echo ($task['duration'] == 'Long') ? 'selected' : ''; ?>>Long</option>
                                    <option value="Medium" <?php echo ($task['duration'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                    <option value="Short" <?php echo ($task['duration'] == 'Short') ? 'selected' : ''; ?>>Short</option>
                                    <option value="Unknown" <?php echo ($task['duration'] == 'Unknown') ? 'selected' : ''; ?>>Unknown</option>
                                </select>
                            </td>
                            <td><?php echo htmlspecialchars($task['due_date']); ?></td> <!-- Displaying Due Date -->
                            <td>
                                <!-- Update Button -->
                                <form action="edit_task_employee.php" method="GET">
                                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                    <button type="submit" class="update-btn">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>You have no assigned tasks.</p>
        <?php } ?>
    </div>
</body>
</html>

<?php 
} else {
    // If not logged in or not an employee, redirect to login page
    $errormessage = "You must log in as an employee to view your tasks!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
} // end of file employee-task.php
?>
