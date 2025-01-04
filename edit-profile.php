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

    // Initialize variables for current user details (to populate the form)
    $full_name = $user_details['full_name'];
    $username = $user_details['username'];
    $email = $user_details['email_id'];
    $phone = $user_details['phone'];
    $role = $user_details['role'];

    // Handle the form submission for profile updates
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Sanitize and get new user input
        $new_full_name = htmlspecialchars($_POST['full_name']);
        $new_username = htmlspecialchars($_POST['username']);
        $new_email = htmlspecialchars($_POST['email']);
        $new_phone = htmlspecialchars($_POST['phone']);
        $new_role = htmlspecialchars($_POST['role']);

        // Update the user profile in the database
        $update_result = update_user_profile($conn, $user_id, $new_full_name, $new_username, $new_email, $new_phone, $new_role);

        // Display success or error message based on result
        if ($update_result) {
            $message = "Profile updated successfully!";
        } else {
            $message = "Error updating profile. Please try again.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php"; ?>  <!-- Include header -->
    <div class="body">
        
        <section class="section-1">
            <div class="edit-profile-container">
                <h2>Edit Profile</h2>

                <!-- Display success or error message -->
                <?php if (isset($message)): ?>
                    <p class="message"><?= $message ?></p>
                <?php endif; ?>

                <form action="edit-profile.php" method="POST" class="edit-profile-form">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($full_name) ?>" required>

                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" required>

                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="employee" <?= $role == 'employee' ? 'selected' : '' ?>>Employee</option>
                    </select>

                    <button type="submit" class="btn-submit">Update Profile</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>

<?php
} else {
    $em = "You need to be logged in to edit your profile!";
    header("Location: login.php?error=$em");
    exit();
}
?>
