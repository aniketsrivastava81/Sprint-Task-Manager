<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "SQL_Connection.php";  // Include DB connection

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    
    // Fetch notifications using PDO
    $sql = "SELECT * FROM notifications WHERE recipient = :user_id ORDER BY date DESC";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind the parameters
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch all notifications
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Display notifications
    ?>
    <html>
    <head>
        <title>Notifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php include "header.php"; ?>
        <div class="body">
            <h4 class="title">All Notifications</h4>
            <?php if (count($notifications) > 0) { ?>
            <table class="main-table">
                <tr>
                    <th>#</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
                <?php $i = 0; foreach ($notifications as $notification) { ?>
                <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $notification['message'] ?></td>
                    <td><?= $notification['type'] ?></td>
                    <td><?= $notification['date'] ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php } else { ?>
            <h3>You have no notifications</h3>
            <?php } ?>
        </div>
    </body>
    </html>
<?php } else {
    header("Location: login.php?error=Please login first.");
    exit();
} ?>

