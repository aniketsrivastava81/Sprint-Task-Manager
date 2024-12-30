<?php
//session_start();
?>
<header class="header">
    <h2 class="u-name"><i>SPRINTS</i></h2>

    <label for="checkbox">
        <i id="navbtn" class="fa fa-expand" aria-hidden="true"></i>
    </label>

    <?php if ($_SESSION['role'] == "admin") { ?>
        <!-- Admin NavBar Code Below -->
        <nav class="navigation-icons-bar">
            <ul id="navigationlistID">
                <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
                <li><a href="user.php"><i class="fa fa-user" aria-hidden="true"></i><span>Manage Users</span></a></li>
                <li><a href="create_task.php"><i class="fa fa-plus" aria-hidden="true"></i><span>Create Tasks</span></a></li>
                <li><a href="tasks.php"><i class="fa fa-tasks" aria-hidden="true"></i><span>All Tasks</span></a></li>
                <li><a href="notifications.php"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
                <li><div class="user-p"> <img src="./user.jpg"> <h4><?php echo $_SESSION['username']; ?></h4> </div> </li>
            </ul>
        </nav>
    <?php } elseif ($_SESSION['role'] == "employee") { ?>
        <!-- Employee NavBar Code Below -->
        <nav class="navigation-icons-bar">
            <ul>
                <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
                <li><a href="#"><i class="fa fa-tasks" aria-hidden="true"></i><span>Tasks</span></a></li>
                <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Profile</span></a></li>
                <li><a href="notifications.php"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
                <li><div class="user-p"> <img src="./user.jpg"> <h4><?php echo $_SESSION['username']; ?></h4> </div> </li>
            </ul>
        </nav>
    <?php } ?>
</header>
