<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    // Include the database connection
    include "SQL_Connection.php";

    // Fetch all users for the 'assigned_to' field if needed (assumes users table exists)
    $sql = "SELECT user_id, full_name FROM users WHERE role = 'employee'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2 class="u-name">Create Task</h2>

    <div class="body">
        <section>
            <h4 class="title">Create New Task</h4>
            <a href="task-list.php" class="addbtn">Tasks</a>

            <!-- Display error or success messages inside the form -->
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

            <!-- Form to create a new task -->
            <form class="form-1" method="POST" action="create_task_logic.php">
                <div class="input-holder">
                    <label>Title</label>
                    <input type="text" name="title" class="input-login" placeholder="Task Title" required><br>
                </div>

                <div class="input-holder">
                    <label>Description</label>
                    <textarea name="description" class="input-login" placeholder="Task Description" required></textarea><br>
                </div>

                <div class="input-holder">
                    <label>Assigned To</label>
                    <select name="assigned_to" class="input-login" required>
                        <option value="">Select Employee</option>
                        <?php foreach ($users as $user) { ?>
                            <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                        <?php } ?>
                    </select><br>
                </div>

                <div class="input-holder">
                    <label>Status</label>
                    <select name="status" class="input-login" required>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select><br>
                </div>

                <div class="input-holder">
                    <label>Priority</label>
                    <select name="priority" class="input-login" required>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                        <option value="Wish">Wish</option>
                    </select><br>
                </div>

                <div class="input-holder">
                    <label>Visibility</label>
                    <select name="visibility" class="input-login" required>
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </select><br>
                </div>

                <div class="input-holder">
                    <label>Duration</label>
                    <select name="duration" class="input-login" required>
                        <option value="Long">Long</option>
                        <option value="Medium">Medium</option>
                        <option value="Short">Short</option>
                        <option value="Unknown">Unknown</option>
                    </select><br>
                </div>

                <!-- Added Due Date field -->
                <div class="input-holder">
                    <label>Due Date</label>
                    <input type="date" name="due_date" class="input-login" required><br>
                </div>

                <button class="edit-btn">Create Task</button>
            </form>
        </section>
    </div>

</body>
</html>

<?php 
} else {
    // If the user is not logged in, redirect to login page
    $errormessage = "We require you to Login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>
