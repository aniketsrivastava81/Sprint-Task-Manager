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
?>