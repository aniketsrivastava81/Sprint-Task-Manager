<?php  

$sName = "localhost";
$uName = "root";
$pass  = "";
$db_name = "sprintTaskManagement";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// SQL query to fetch all users
$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetching all results from the query
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any users to display
if ($users) {
    // Display data in a simple HTML table
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>User ID</th><th>Full Name</th><th>Username</th><th>Email ID</th><th>Phone</th><th>Role</th><th>Created At</th><th>Password</th></tr>";

    // Loop through the users and print their details
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email_id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
        echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($user['password']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No users found.";
}



?>
