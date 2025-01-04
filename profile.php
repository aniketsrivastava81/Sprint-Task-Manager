<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    include "SQL_Connection.php";  // Include the database connection
    include "database_fetches.php"; // Include the database fetch functions

    // Get the user details from the database based on the session user ID
    $user_id = $_SESSION['id'];
    $user_details = get_user_details($conn, $user_id); // Fetch user details

    // If user not found (just a safety check)
    if (!$user_details) {
        echo "User not found.";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php"; ?>  <!-- Include header -->
    <div class="body">
        
        <section class="section-1">
            <div class="profile-container">
                <h2>User Profile</h2>
                <div class="profile-info">
                    <p><strong>Full Name:</strong> <?= htmlspecialchars($user_details['full_name']) ?></p>
                    <p><strong>Username:</strong> <?= htmlspecialchars($user_details['username']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user_details['email_id']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($user_details['phone']) ?></p>
                    <p><strong>Role:</strong> <?= htmlspecialchars($user_details['role']) ?></p>
                </div>

                <!-- Edit Profile Button (you can link this to another page to allow updates) -->
                <a href="edit-profile.php" class="btn-edit-profile">Edit Profile</a>
            </div>
        </section>
    </div>
</body>
</html>

<?php } else {
    $em = "You need to be logged in to view the profile!";
    header("Location: login.php?error=$em");
    exit();
}
?>
