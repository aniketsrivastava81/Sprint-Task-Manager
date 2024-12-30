<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>
    <h2 class="u-name"><!--i>SPRINTS</i--></h2>

    <div class="body">
    </div>

</body>
</html>
<?php } else {
    $errormessage = "We require you to Login to use this system!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
}
?>
