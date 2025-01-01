<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        // Include the database connection and fetch function
        include "SQL_Connection.php";
        include "database_fetches.php";

        // Fetch user details based on user_id
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            $errormessage = "User not found!";
            header("Location: user.php?error=" . urlencode($errormessage));
            exit();
        }
    } else {
        $errormessage = "User ID is missing!";
        header("Location: user.php?error=" . urlencode($errormessage));
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2 class="u-name">Edit User</h2>

    <div class="body">
        <section> 
            <h4 class="title">Edit User</h4>
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

            <!-- Form to edit user -->
            <form class="form-1" method="POST" action="edit_update_user.php">
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                <div class="input-holder">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="input-login" value="<?php echo $user['full_name']; ?>" placeholder="Full Name"><br>
                </div>
                <div class="input-holder">
                    <label>Username</label>
                    <input type="text" name="user_name" class="input-login" value="<?php echo $user['username']; ?>" placeholder="Username"><br>
                </div>
                <div class="input-holder">
                    <label>Password</label>
                    <input type="password" name="password" class="input-login" placeholder="New Password"><br>
                </div>

                <div class="input-holder">
                    <label>Email-ID</label>
                    <input type="email" name="email_id" class="input-login" value="<?php echo $user['email_id']; ?>" placeholder="abc@example.com"><br>
                </div>

                <div class="input-holder">
                    <label>Phone</label>
                    <input type="text" name="phone" class="input-login" value="<?php echo $user['phone']; ?>" placeholder="+1 234 567 8900"><br>
                </div>

                <button class="edit-btn">Update</button>
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
