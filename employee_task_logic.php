<?php
// Fetch tasks assigned to a specific employee
function get_employee_tasks($conn, $employee_id) {
    // SQL query to get tasks assigned to the employee
    $sql = "SELECT * FROM tasks WHERE assigned_to = ?"; // Assuming 'assigned_to' is the employee's ID
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employee_id]);

    // Check if there are any tasks assigned
    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(); // Fetch all tasks
    } else {
        return []; // Return an empty array if no tasks
    }
}
?>
