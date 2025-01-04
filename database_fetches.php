<?php

// Fetch all users with a specific role
function get_all_users($conn) {
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

// Count all users with a specific role
function count_users($conn) {
    $sql = "SELECT user_id FROM users WHERE role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["employee"]);

    return $stmt->rowCount();
}

// Get all tasks (this is used for both admin and employee views)
function get_all_tasks($conn) {
    $sql = "SELECT * FROM tasks WHERE status != 'completed' ORDER BY task_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = [];
    }

    return $tasks;
}

// Count all tasks (this is used for both admin and employee views)
function count_tasks($conn) {
    $sql = "SELECT task_id FROM tasks WHERE status != 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

// Get all tasks that are due today (admin and employee)
function get_all_tasks_due_today($conn) {
    $sql = "SELECT * FROM tasks WHERE due_date = CURDATE() AND status != 'completed' ORDER BY task_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = [];
    }

    return $tasks;
}

// Count tasks that are due today
function count_tasks_due_today($conn) {
    $sql = "SELECT task_id FROM tasks WHERE due_date = CURDATE() AND status != 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

// Get all overdue tasks
function get_all_tasks_overdue($conn) {
    $sql = "SELECT * FROM tasks WHERE due_date < CURDATE() AND status != 'completed' ORDER BY task_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = [];
    }

    return $tasks;
}

// Count overdue tasks
function count_tasks_overdue($conn) {
    $sql = "SELECT task_id FROM tasks WHERE due_date < CURDATE() AND status != 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

// Get all tasks with no deadline
function get_all_tasks_NoDeadline($conn) {
    $sql = "SELECT * FROM tasks WHERE status != 'completed' AND (due_date IS NULL OR due_date = '0000-00-00') ORDER BY task_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = [];
    }

    return $tasks;
}

// Count tasks with no deadline
function count_tasks_NoDeadline($conn) {
    $sql = "SELECT task_id FROM tasks WHERE status != 'completed' AND (due_date IS NULL OR due_date = '0000-00-00')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

// Get all tasks assigned to a specific user
function get_my_tasks($conn, $user_id) {
    $sql = "SELECT * FROM tasks WHERE assigned_to = ? AND status != 'completed' ORDER BY task_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = [];
    }

    return $tasks;
}

// Count all tasks assigned to a specific user
function count_my_tasks($conn, $user_id) {
    $sql = "SELECT task_id FROM tasks WHERE assigned_to = ? AND status != 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    return $stmt->rowCount();
}

// Get all overdue tasks assigned to a specific user
function get_my_tasks_overdue($conn, $user_id) {
    $sql = "SELECT * FROM tasks WHERE assigned_to = ? AND due_date < CURDATE() AND status != 'completed' ORDER BY task_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = [];
    }

    return $tasks;
}

// Count overdue tasks assigned to a specific user
function count_my_tasks_overdue($conn, $user_id) {
    $sql = "SELECT task_id FROM tasks WHERE assigned_to = ? AND due_date < CURDATE() AND status != 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    return $stmt->rowCount();
}

// Get all tasks with no deadline assigned to a specific user
function get_my_tasks_NoDeadline($conn, $user_id) {
    $sql = "SELECT * FROM tasks WHERE assigned_to = ? AND (due_date IS NULL OR due_date = '0000-00-00') AND status != 'completed' ORDER BY task_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    if ($stmt->rowCount() > 0) {
        $tasks = $stmt->fetchAll();
    } else {
        $tasks = [];
    }

    return $tasks;
}

// Count tasks with no deadline assigned to a specific user
function count_my_tasks_NoDeadline($conn, $user_id) {
    $sql = "SELECT task_id FROM tasks WHERE assigned_to = ? AND (due_date IS NULL OR due_date = '0000-00-00') AND status != 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    return $stmt->rowCount();
}

// Get all pending tasks assigned to a specific user
function count_my_pending_tasks($conn, $user_id) {
    $sql = "SELECT task_id FROM tasks WHERE assigned_to = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    return $stmt->rowCount();
}

// Get all in progress tasks assigned to a specific user
function count_my_in_progress_tasks($conn, $user_id) {
    $sql = "SELECT task_id FROM tasks WHERE assigned_to = ? AND status = 'in_progress'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    return $stmt->rowCount();
}

// Get all completed tasks assigned to a specific user
function count_my_completed_tasks($conn, $user_id) {
    $sql = "SELECT task_id FROM tasks WHERE assigned_to = ? AND status = 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    return $stmt->rowCount();
}


// Fetch user details by user ID
function get_user_details($conn, $user_id) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(); // Returns user details as an associative array
    } else {
        return false; // Return false if no user is found
    }
}


// Update user profile in the database
function update_user_profile($conn, $user_id, $full_name, $username, $email, $phone, $role) {
    $sql = "UPDATE users SET full_name = ?, username = ?, email_id = ?, phone = ?, role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$full_name, $username, $email, $phone, $role, $user_id]);
        return true;  // Return true on successful update
    } catch (Exception $e) {
        // Log the error and return false if there's an issue
        error_log("Error: " . $e->getMessage());
        return false;
    }
}


?>
