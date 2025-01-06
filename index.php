<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) ) {

    include "SQL_Connection.php";  // Include the database connection
    include "database_fetches.php"; // Include the database fetch functions

    // Admin-specific data
    if ($_SESSION['role'] == "admin") {
        $todaydue_task = count_tasks_due_today($conn);
        $overdue_task = count_tasks_overdue($conn);
        $nodeadline_task = count_tasks_NoDeadline($conn);
        $num_task = count_tasks($conn);
        $num_users = count_users($conn);
        $pending = count_tasks($conn);
        $in_progress = count_tasks($conn);
        $completed = count_tasks($conn);
    } else {
        // Employee-specific data
        $num_my_task = count_my_tasks($conn, $_SESSION['id']);
        $overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
        $nodeadline_task = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
        $pending = count_my_pending_tasks($conn, $_SESSION['id']);
        $in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
        $completed = count_my_completed_tasks($conn, $_SESSION['id']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox" visibility = "hidden">
    <?php include "header.php" ?> <!-- Include header -->
    <h2 class="u-name"><!--i>SPRINTS</i--></h2>

    <div class="body">
        
        <section class="section-1">
            <?php if ($_SESSION['role'] == "admin") { ?>
                <div class="dashboard">
                    <div class="dashboard-item">
                        <i class="fa fa-users"></i>
                        <span><?=$num_users?> Employee</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-tasks"></i>
                        <span><?=$num_task?> All Tasks</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa-solid fa-rectangle-xmark"></i>
                        <span><?=$overdue_task?> Overdue</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa-solid fa-clock"></i>
                        <span><?=$nodeadline_task?> No Deadline</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-exclamation-triangle"></i>
                        <span><?=$todaydue_task?> Due Today</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-bell"></i>
                        <span><?=$overdue_task?> Notifications</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa-solid fa-clock-rotate-left"></i> 
                        <span><?=$pending?> Pending</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-spinner"></i>
                        <span><?=$in_progress?> In progress</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-check-square"></i>
                        <span><?=$completed?> Completed</span>
                    </div>
                </div>
            <?php } else { ?>
                <div class="dashboard">
                    <div class="dashboard-item">
                        <i class="fa fa-tasks"></i>
                        <span><?=$num_my_task?> My Tasks</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa-solid fa-rectangle-xmark"></i>
                        <span><?=$overdue_task?> Overdue</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-clock"></i>
                        <span><?=$nodeadline_task?> No Deadline</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-clock-rotate-left"></i>
                        <span><?=$pending?> Pending</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-spinner"></i>
                        <span><?=$in_progress?> In progress</span>
                    </div>
                    <div class="dashboard-item">
                        <i class="fa fa-check-square"></i>
                        <span><?=$completed?> Completed</span>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>

<script type="text/javascript">
    var active = document.querySelector("#navigationlistID li:nth-child(2)");
    active.classList.add("active");
</script>
</body>
</html>

<?php } else {
    $errormessage = "First login";
    header("Location: login.php?error=$errormessage");
    exit();
}
?>