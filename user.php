<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "SQL_Connection.php";
    include "database_fetches.php";
    
    // Call the function to get the users
    $users = get_all_users($conn);

    // Debugging: Check if $users is populated
    print_r($users); // This will print the $users array for debugging
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
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2 class="u-name"><!--i>SPRINTS</i--></h2>

    <div class="body">
    	<section> 

    		<table class="main-table">
				<tr>
					<th>#</th>
					<th>Full Name</th>
					<th>Username</th>
					<th>role</th>
					<th>Action</th>

				</tr>
					<td> 1</td>
					<td> UserName</td>
					<td> user1</td>
					<td> employee </td>
					<td>
						<a href="edit-user.php?id=<?=$_SESSION['username']?>" class="edit-btn">Edit</a>
						<a href="delete-user.php?id=<?=($_SESSION['username'])?>" class="delete-btn">Delete</a>
					</td>

    	</section>
    </div>






<script type="text/javascript">
	var active = document.querySelector("#navigationlistID li:nth-child(2)");
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
