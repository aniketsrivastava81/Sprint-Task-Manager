<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

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
        
        <style>
            /* Center the table */
            .centered-table {
                margin: 0 auto; /* Center horizontally */
                width: 80%; /* Optional: adjust the width of the table */
                max-width: 1000px; /* Optional: limit the table width */
                border-collapse: collapse; /* Optional: ensures borders don't overlap */
            }

            /* Center table content */
            .centered-table th, .centered-table td {
                text-align: left;
                padding: 10px;
            }

            /* Optional: Add some basic styling */
            .centered-table th {
                background-color: #f1f1f1;
            }
        </style>
    </head>
    <body>
        <input type="checkbox" id="checkbox">
        <?php include "header.php"; ?>
        <div class="body">
            <?php if (count($notifications) > 0) { ?>
                <table class="centered-table">
                <tr><td><h4 class="title">All Notifications</h4></td></tr>

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

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                            <script type="text/javascript">
                                var active = document.querySelector("#navigationlistID li:nth-child(6)");
                                active.classList.add("active");
                            </script>
                        <?php } else { ?> 
                            <script type="text/javascript">
                                var active = document.querySelector("#navigationlistID li:nth-child(5)");
                                active.classList.add("active");
                            </script> 
                        <?php } ?>

    </body>
    </html>
<?php } else {
    header("Location: login.php?error=Please login first.");
    exit();
} ?>
