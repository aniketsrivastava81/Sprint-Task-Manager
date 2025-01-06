<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    // Include the database connection
    include "SQL_Connection.php";
    include "database_fetches.php";

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">


    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .task-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            width: 100%;
        }

        /* Navigation Styling for Desktop */
        .nav-menu.desktop {
            display: flex;
            position: static;
            flex-direction: row;
            background-color: transparent;
            transform: none;
            justify-content: space-between; /* This will spread items across the available space */
            width: 100%; /* Make sure the menu takes the full width */

        }

        .nav-item.desktop {
            padding: 15px;
            margin: 0 10px;
            background-color: transparent;
        }

        /* Ensure the last nav item is pushed to the right */
        .nav-menu.desktop .nav-item:last-child {
            margin-left: auto;
        }


        /* Main Content Styles */
        .main-content {
            margin-left: 0;
            padding: 20px;
            width: 100%;
        }

        .title-2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .main-table th, .main-table td {
            padding: 8px;
            text-align: left;
        }

        /* Responsiveness for smaller screens */
        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            .nav-menu.desktop {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }

    </style>

</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php"; ?>

    <!-- Main Content Area -->
    <div class="task-list">
        <h2 class="u-name" style="text-align: center; margin-top: 20px;">Task List</h2>

        <div class="body" style="display: flex; flex: 1; flex-direction: column; align-items: center; padding: 20px 0;">
            <section style="width: 100%; max-width: 1000px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

                <!-- Filter Buttons -->
                <div class="filter-buttons" style="display: flex; flex-direction: column; align-items: center; margin-top: 20px;">
                    <h4 class="title-2" style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                        <?=$text?> (<?=$num_task?>)
                    </h4>
                    
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                        <a href="create-task.php" class="addbtn" style="padding: 8px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin: 5px;">Create Task</a>
                        <a href="task-list.php?due_date=Due Today" class="addbtn" style="padding: 8px 20px; background-color: #FF9800; color: white; text-decoration: none; border-radius: 5px; margin: 5px;">Due Today</a>
                        <a href="task-list.php?due_date=Overdue" class="addbtn" style="padding: 8px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px; margin: 5px;">Overdue</a>
                        <a href="task-list.php?due_date=No Deadline" class="addbtn" style="padding: 8px 20px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px; margin: 5px;">No Deadline</a>
                        <a href="task-list.php" class="addbtn" style="padding: 8px 20px; background-color: #607D8B; color: white; text-decoration: none; border-radius: 5px; margin: 5px;">All Tasks</a>
                    </div>
                </div>

                <!-- Success or Error Messages -->
                <?php if (isset($_GET['success'])) { ?>
                    <div class="success" role="alert" style="color: #4CAF50; text-align: center; margin-top: 15px;">
                        <?php echo stripcslashes($_GET['success']); ?>
                    </div>
                <?php } ?>

                <!-- Display tasks in a table -->
                <?php if ($tasks != 0) { ?>
                    <table class="main-table">
                        <thead>
                            <tr style="background-color: #f1f1f1;">
                                <th style="padding: 8px; text-align: left;">#</th>
                                <th style="padding: 8px; text-align: left;">Title</th>
                                <th style="padding: 8px; text-align: left;">Description</th>
                                <th style="padding: 8px; text-align: left;">Assigned To</th>
                                <th style="padding: 8px; text-align: left;">Due Date</th>
                                <th style="padding: 8px; text-align: left;">Status</th>
                                <th style="padding: 8px; text-align: left;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach ($tasks as $task): $i++; ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$task['title']?></td>
                                <td><?=$task['description']?></td>
                                <td><?=$task['assigned_to']?></td>
                                <td><?=$task['due_date']?></td>
                                <td><?=$task['status']?></td>
                                <td><a class="addbtn" href="edit_task.php?id=<?=$task['task_id']?>" class="btn">Edit</a>
                                <a class="delete-btn" href="edit_task_delete.php?id=<?=$task['task_id']?>" class="btn">Delete</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No tasks available.</p>
                <?php } ?>

            </section>
        </div>
    </div>

<script type="text/javascript">
    var active = document.querySelector("#navigationlistID li:nth-child(5)");
    active.classList.add("active");
</script>


</body>
</html>

<?php
} else {
    // Redirect if session not set
    header("Location: login.php");
}
?>
