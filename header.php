<?php
session_start();
include "SQL_Connection.php";  // Include DB connection

// Fetch notification count for the logged-in user using PDO
$userId = $_SESSION['id'];
$sql = "SELECT COUNT(*) AS count FROM notifications WHERE recipient = :user_id AND is_read = 0";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$notificationCount = $row['count'];

// Fetch notifications for the logged-in user using PDO
$notificationsQuery = "SELECT * FROM notifications WHERE recipient = :user_id ORDER BY date DESC";
$notificationStmt = $conn->prepare($notificationsQuery);
$notificationStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$notificationStmt->execute();
$notifications = $notificationStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<header class="header">
    <h2 class="u-name"><i>SPRINTS</i></h2>

    
    <label for="checkbox">
        <i id="navbtn" class="fa fa-expand" aria-hidden="true"></i>
    </label>

    <!-- Role-based navbar logic -->
    <?php if ($_SESSION['role'] == "admin") { ?>
        <nav class="navigation-icons-bar">
            <ul id="navigationlistID">
                <li><div class="user-p"> <img src="./user.jpg"> <h4><?php echo $_SESSION['username']; ?></h4> </div> </li>
                <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
                <li><a href="user.php"><i class="fa fa-users" aria-hidden="true"></i><span>Manage Users</span></a></li>
                <li><a href="create-task.php"><i class="fa fa-plus" aria-hidden="true"></i><span>Create Tasks</span></a></li>
                <li><a href="task-list.php"><i class="fa fa-tasks" aria-hidden="true"></i><span>All Tasks</span></a></li>
                <li><a href="notifications.php"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>




                <!-- Notification icon and count display -->
                <li>    <span class="notification" id="notificationBtn">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        <span id="notificationNum"><?= $notificationCount > 0 ? "&nbsp;$notificationCount&nbsp;" : "" ?></span>
                    </span>
                </li>

            </ul>
        </nav>
    <?php } elseif ($_SESSION['role'] == "employee") { ?>
        <nav class="navigation-icons-bar">
            <ul>
                <li><div class="user-p"> <img src="./user.jpg"> <h4><?php echo $_SESSION['username']; ?></h4> </div> </li>
                <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
                <li><a href="employee-task.php"><i class="fa fa-tasks" aria-hidden="true"></i><span>Tasks</span></a></li>
                <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span>Profile</span></a></li>
                <li><a href="notifications.php"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>




                                <!-- Notification icon and count display -->
                <li>    <span class="notification" id="notificationBtn">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        <span id="notificationNum"><?= $notificationCount > 0 ? "&nbsp;$notificationCount&nbsp;" : "" ?></span>
                    </span>
                </li>

            </ul>
        </nav>
    <?php } ?>
</header>

<!-- Notification bar (for expanded view) -->
<div class="notification-bar" id="notificationBar">
    <ul id="notifications">
        <?php foreach ($notifications as $notification) { ?>
            <li>
                <a href="notifications-read.php?id=<?= $notification['id'] ?>">
                    <?= $notification['is_read'] == 0 ? "<mark>" : "" ?>
                    <?= $notification['type'] . ": " . $notification['message'] ?>
                    <?= $notification['is_read'] == 0 ? "</mark>" : "" ?>
                    &nbsp;&nbsp;<small><?= $notification['date'] ?></small>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<script type="text/javascript">
    var openNotification = false;
    const notification = () => {
        let notificationBar = document.querySelector("#notificationBar");
        if (openNotification) {
            notificationBar.classList.remove('open-notification');
            openNotification = false;
        } else {
            notificationBar.classList.add('open-notification');
            openNotification = true;
        }
    }
    document.querySelector("#notificationBtn").addEventListener("click", notification);
</script>
