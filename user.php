<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "SQL_Connection.php";
    include "database_fetches.php";
    
    // Call the function to get the users
    $users = get_all_users($conn);

    // Debugging: Check if $users is populated
    //print_r($users); // This will print the $users array for debugging
?>

    <script type="text/javascript">
        // Pass the PHP $users array to JavaScript
        var users = <?php echo json_encode($users); ?>;
        
        // Check if the data is correctly passed
        if (users === null || users.length === 0) {
            console.log("No users found");
        } else {
            console.log(users); // Log the users array to the browser console
        }
    </script>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Users</title>
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
    <?php include "header.php" ?>

    <h2 class="u-name"><!--i>SPRINTS</i--></h2>

    <div class="body">
        <section> 
                    
            <?php if ($users != 0) { ?>
                <table class="centered-table">
                <tr><td><h4 class="title">Manage Users </h4> </td></tr>
                    <tr>
                        <th>#</th>
                        <th> ID </th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>role</th>
                        <th>Action</th>
                    </tr>
                    <?php $i=0; foreach ($users as $user) { ?>
                    <tr>
                        <td><?=++$i?></td>
                        <td><?=$user['user_id']?></td>
                        <td><?=$user['full_name']?></td>
                        <td><?=$user['username']?></td>
                        <td><?=$user['role']?></td>
                        <td>
                            <a href="edit-user.php?user_id=<?php echo $user['user_id'];?>" class="edit-btn">Edit</a>
                            <a href="edit_delete_user.php?user_id=<?php echo $user['user_id'];?>" class="delete-btn">Delete</a>
                        </td>
                    </tr> 
                   <?php } ?> 
                   <tr><td><a href="add-user.php" class="addbtn">Add User</a></td></tr>
                </table> 
                
            <?php } else { ?>
                <h3>Empty</h3>
            <?php } ?>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navigationlistID li:nth-child(3)");
        active.classList.add("active");
    </script>
</body>
</html>

<?php } else {
    $errormessage = "We require you to Login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
} // end of file
?>
