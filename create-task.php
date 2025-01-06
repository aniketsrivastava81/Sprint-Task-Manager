<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body style="margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh; background-color: #f4f4f4;">
    <input type="checkbox" id="checkbox">
    <!-- Header Section (fixed at the top of the page) -->
    <?php include "header.php"; ?>

    <!-- Page Title -->
    <h2 class="u-name" style="text-align: center; margin-top: 20px;">Create Task</h2>

    <!-- Main Content Container (Flexbox for centering) -->
    <div class="body" style="display: flex; flex: 1; justify-content: center; align-items: center; padding: 20px 0;">
        <section style="width: 100%; max-width: 600px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

            <!-- Display error or success messages -->
            <?php if (isset($_GET['error'])) { ?>
                <div class="danger" role="alert" style="color: #ff0000; text-align: center; margin-bottom: 15px;">
                    <?php echo stripcslashes($_GET['error']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert" style="color: #4CAF50; text-align: center; margin-bottom: 15px;">
                    <?php echo stripcslashes($_GET['success']); ?>
                </div>
            <?php } ?>

            <!-- Task Creation Form -->
            <form class="form-1" method="POST" action="create_task_logic.php" style="display: flex; flex-direction: column; gap: 15px;">
                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="title" style="font-weight: bold;">Title</label>
                    <input type="text" name="title" class="input-login" placeholder="Task Title" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="description" style="font-weight: bold;">Description</label>
                    <textarea name="description" class="input-login" placeholder="Task Description" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                </div>

                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="assigned_to" style="font-weight: bold;">Assigned To</label>
                    <select name="assigned_to" class="input-login" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="">Select Employee</option>
                        <?php foreach ($users as $user) { ?>
                            <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="status" style="font-weight: bold;">Status</label>
                    <select name="status" class="input-login" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="priority" style="font-weight: bold;">Priority</label>
                    <select name="priority" class="input-login" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                        <option value="Wish">Wish</option>
                    </select>
                </div>

                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="visibility" style="font-weight: bold;">Visibility</label>
                    <select name="visibility" class="input-login" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </select>
                </div>

                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="duration" style="font-weight: bold;">Duration</label>
                    <select name="duration" class="input-login" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="Long">Long</option>
                        <option value="Medium">Medium</option>
                        <option value="Short">Short</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>

                <div class="input-holder" style="display: flex; flex-direction: column;">
                    <label for="due_date" style="font-weight: bold;">Due Date</label>
                    <input type="date" name="due_date" class="input-login" required style="padding: 8px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <button type="submit" class="edit-btn" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px; align-self: center;">Create Task</button>
            </form>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navigationlistID li:nth-child(4)");
        active.classList.add("active");
    </script>

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
