<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    // Include the database connection
    include "SQL_Connection.php";
    include "database_fetches.php";

    // Define the functions
    function get_all_tasks($conn) {
        $sql = "SELECT * FROM tasks WHERE status != 'completed' ORDER BY task_id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else {
            return 0;
        }
    }

    function count_tasks($conn) {
        $sql = "SELECT task_id FROM tasks WHERE status != 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        return $stmt->rowCount();
    }

    function get_all_tasks_due_today($conn) {
        $sql = "SELECT * FROM tasks WHERE due_date = CURDATE() AND status != 'completed' ORDER BY task_id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else {
            return 0;
        }
    }

    function count_tasks_due_today($conn) {
        $sql = "SELECT task_id FROM tasks WHERE due_date = CURDATE() AND status != 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        return $stmt->rowCount();
    }

    function get_all_tasks_overdue($conn) {
        $sql = "SELECT * FROM tasks WHERE due_date < CURDATE() AND status != 'completed' ORDER BY task_id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else {
            return 0;
        }
    }

    function count_tasks_overdue($conn) {
        $sql = "SELECT task_id FROM tasks WHERE due_date < CURDATE() AND status != 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        return $stmt->rowCount();
    }

    function get_all_tasks_NoDeadline($conn) {
        $sql = "SELECT * FROM tasks WHERE status != 'completed' AND (due_date IS NULL OR due_date = '0000-00-00') ORDER BY task_id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll();
        } else {
            return 0;
        }
    }

    function count_tasks_NoDeadline($conn) {
        $sql = "SELECT task_id FROM tasks WHERE status != 'completed' AND (due_date IS NULL OR due_date = '0000-00-00')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);

        return $stmt->rowCount();
    }

    // Main logic for task filtering based on due date
    $text = "All Task";
    if (isset($_GET['due_date'])) {
        if ($_GET['due_date'] == "Due Today") {
            $text = "Due Today";
            $tasks = get_all_tasks_due_today($conn);
            $num_task = count_tasks_due_today($conn);
        } else if ($_GET['due_date'] == "Overdue") {
            $text = "Overdue";
            $tasks = get_all_tasks_overdue($conn);
            $num_task = count_tasks_overdue($conn);
        } else if ($_GET['due_date'] == "No Deadline") {
            $text = "No Deadline";
            $tasks = get_all_tasks_NoDeadline($conn);
            $num_task = count_tasks_NoDeadline($conn);
        } else {
            $tasks = get_all_tasks($conn);
            $num_task = count_tasks($conn);
        }
    } else {
        $tasks = get_all_tasks($conn);
        $num_task = count_tasks($conn);
    }

    // Fetch all users for assigning tasks
    $users = get_all_users($conn);

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
    <?php include "header.php"; ?>

    <h2 class="u-name">Task List</h2>

    <div class="body">
        <section>
            <h4 class="title">All Tasks</h4>
            <a href="create-task.php" class="addbtn">Create Task</a>

            <!-- Filter buttons -->
            <div class="filter-buttons">
                <a href="task-list.php?due_date=Due Today">Due Today</a>
                <a href="task-list.php?due_date=Overdue">Overdue</a>
                <a href="task-list.php?due_date=No Deadline">No Deadline</a>
                <a href="task-list.php">All Tasks</a>
            </div>

            <!-- Display success or error messages -->
            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo stripcslashes($_GET['success']); ?>
                </div>
            <?php } ?>

            <h4 class="title-2"><?=$text?> (<?=$num_task?>)</h4>

            <!-- Display tasks in a table -->
            <?php if ($tasks != 0) { ?>
                <table class="task-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Assigned To</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($tasks as $task) { ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td>
                                <?php 
                                foreach ($users as $user) {
                                    if($user['user_id'] == $task['assigned_to']){
                                        echo htmlspecialchars($user['full_name']);
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo $task['due_date'] ?: "No Deadline"; ?></td>
                            <td><?= htmlspecialchars($task['status']) ?></td>
                            <td>
                                <a href="edit_task.php?id=<?= $task['task_id'] ?>" class="edit-btn">Edit</a>
                                <a href="edit_task_delete.php?id=<?= $task['task_id'] ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h3>No tasks found!</h3>
            <?php } ?>
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
