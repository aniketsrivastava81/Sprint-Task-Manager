<?php
function get_all_users($conn){
    $sql = "SELECT * FROM users WHERE role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["employee"]);

    if ($stmt->rowCount() > 0) {
        $users = $stmt->fetchAll(); // This will return an array of users
    } else {
        $users = []; // Return an empty array instead of 0
    }

    return $users;
}

/*function get_all_users($conn){
	$sql = "SELECT * FROM user WHERE role =? ";
	$stmt = $conn->prepare($sql);
	$stmt->execute(["employee"]);

	if($stmt->rowCount() > 0){
		$users = $stmt->fetchAll();
	}else $users = 0;

	return $users;
}*/ // end of file





function insert_user($conn, $data) {
    $sql = "INSERT INTO users (full_name, username, email_id, phone, password, role) VALUES(?,?,?,?,?,?)";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
        // Log a message indicating success
        echo "User inserted successfully!";
    } catch (Exception $e) {
        // Log the error message and die() to stop execution
        error_log("Error: " . $e->getMessage()); // Logs the error message
        echo "Error occurred while inserting user: " . $e->getMessage();
        die(); // Stops the execution so you can see the error message
    }
}











?>