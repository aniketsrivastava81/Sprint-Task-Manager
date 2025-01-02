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

        // Fetch task details from the database
        $sql = "SELECT * FROM tasks WHERE task_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$task_id]);

        // Check if the task exists
        if ($stmt->rowCount() > 0) {
            $task = $stmt->fetch();
        } else {
            $errormessage = "Task not found!";
            header("Location: task-list.php?error=" . urlencode($errormessage));
            exit();
        }
    } else {
        $errormessage = "Task ID is missing!";
        header("Location: task-list.php?error=" . urlencode($errormessage));
        exit();
    }

    // Check if form is submitted for updating the task
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $priority = $_POST['priority'];
        $visibility = $_POST['visibility'];
        $duration = $_POST['duration'];
        $due_date = $_POST['due_date'];  // Handle due_date here

        // SQL query to update task data, including the due_date field
        $update_sql = "UPDATE tasks SET title = ?, description = ?, status = ?, priority = ?, visibility = ?, duration = ?, due_date = ? WHERE task_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->execute([$title, $description, $status, $priority, $visibility, $duration, $due_date, $task_id]);

        $successMessage = "Task updated successfully!";
        header("Location: task-list.php?success=" . urlencode($successMessage));
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
    <?php include "header.php"; ?>

    <h2 class="u-name">Edit Task</h2>

    <div class="body">
        <section>
            <h4 class="title">Edit Task</h4>
            <a href="task-list.php" class="addbtn">Back to Task List</a>

            <!-- Display error or success messages -->
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

            <!-- Form to edit the task -->
            <form class="form-1" method="POST">
                <div class="input-holder">
                    <label>Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" class="input-login" placeholder="Task Title"><br>
                </div>
                <div class="input-holder">
                    <label>Description</label>
                    <textarea name="description" class="input-login" placeholder="Task Description"><?php echo htmlspecialchars($task['description']); ?></textarea><br>
                </div>
                <div class="input-holder">
                    <label>Status</label>
                    <select name="status" class="input-login">
                        <option value="pending" <?php if ($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="in_progress" <?php if ($task['status'] == 'in_progress') echo 'selected'; ?>>In Progress</option>
                        <option value="completed" <?php if ($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                    </select><br>
                </div>
                <div class="input-holder">
                    <label>Priority</label>
                    <select name="priority" class="input-login">
                        <option value="High" <?php if ($task['priority'] == 'High') echo 'selected'; ?>>High</option>
                        <option value="Medium" <?php if ($task['priority'] == 'Medium') echo 'selected'; ?>>Medium</option>
                        <option value="Low" <?php if ($task['priority'] == 'Low') echo 'selected'; ?>>Low</option>
                        <option value="Wish" <?php if ($task['priority'] == 'Wish') echo 'selected'; ?>>Wish</option>
                    </select><br>
                </div>
                <div class="input-holder">
                    <label>Visibility</label>
                    <select name="visibility" class="input-login">
                        <option value="Y" <?php if ($task['visibility'] == 'Y') echo 'selected'; ?>>Yes</option>
                        <option value="N" <?php if ($task['visibility'] == 'N') echo 'selected'; ?>>No</option>
                    </select><br>
                </div>
                <div class="input-holder">
                    <label>Duration</label>
                    <select name="duration" class="input-login">
                        <option value="Long" <?php if ($task['duration'] == 'Long') echo 'selected'; ?>>Long</option>
                        <option value="Medium" <?php if ($task['duration'] == 'Medium') echo 'selected'; ?>>Medium</option>
                        <option value="Short" <?php if ($task['duration'] == 'Short') echo 'selected'; ?>>Short</option>
                        <option value="Unknown" <?php if ($task['duration'] == 'Unknown') echo 'selected'; ?>>Unknown</option>
                    </select><br>
                </div>
                
                <!-- Add a due_date input field -->
                <div class="input-holder">
                    <label>Due Date</label>
                    <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" class="input-login"><br>
                </div>

                <button class="edit-btn">Update Task</button>
            </form>
        </section>
    </div>

</body>
</html>

<?php
} else {
    // If the user is not logged in, redirect to login page
    $errormessage = "We require you to login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>
