<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    // You can include database connection files here, if needed.
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2 class="u-name">Add User</h2>

    <div class="body">
        <section> 
            <h4 class="title">Add User</h4>
            <a href="user.php" class="addbtn">Users</a>

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

            <!-- Form to add a user -->
            <form class="form-1" method="POST" action="add_user_logic.php">
                <div class="input-holder">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="input-login" placeholder="Full Name"><br>
                </div>
                <div class="input-holder">
                    <label>Username</label>
                    <input type="text" name="user_name" class="input-login" placeholder="Username"><br>
                </div>
                <div class="input-holder">
                    <label>Password</label>
                    <input type="text" name="password" class="input-login" placeholder="Password"><br>
                </div>

                <div class="input-holder">
                    <label>Email-ID</label>
                    <input type="text" name="email_id" class="input-login" placeholder="abc@example.com"><br>
                </div>

                <div class="input-holder">
                    <label>Phone</label>
                    <input type="text" name="phone" class="input-login" placeholder="+1 234 567 8900"><br>
                </div>

                <button class="edit-btn">Add</button>
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
