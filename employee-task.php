<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'employee') {
    // Include the necessary files for database connection
    include "SQL_Connection.php";
    include "database_fetches.php";
    include "employee_task_logic.php";

    $employee_id = $_SESSION['id']; // Get logged-in employee ID
    
    // Get the tasks assigned to the employee
    $tasks = get_employee_tasks($conn, $employee_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Tasks</title>
    <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
                <style> 
                            /* General Styles */
                            body {
                                margin: 0;
                                padding: 0;
                                display: flex;
                                flex-direction: column;
                                min-height: 100vh;
                                background-color: #f4f4f4;
                            }

                            .task-list {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                padding: 20px 0;
                                width: 100%;
                                flex: 1;
                            }

                            h2 {
                                text-align: center;
                                margin-top: 20px;
                            }

                            /* Table Styles */
                            table {
                                width: 80%;
                                max-width: 1000px;
                                border-collapse: collapse;
                                margin-top: 20px;
                                background-color: white;
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            }

                            th, td {
                                padding: 8px;
                                text-align: left;
                                border-bottom: 1px solid #ddd;
                            }

                            th {
                                background-color: #f1f1f1;
                            }

                            tr:hover {
                                background-color: #f9f9f9;
                            }

                            /* Centering Table */
                            .task-list table {
                                margin-left: auto;
                                margin-right: auto;
                            }

                            /* Button Styles */
                            .update-btn {
                                padding: 5px 15px;
                                background-color: #4CAF50;
                                color: white;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;
                            }

                            .update-btn:hover {
                                background-color: #45a049;
                            }

                            /* Change font for the body */
                            body {
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                font-size: 16px;
                                color: #333;
                            }

                            /* Style for select elements */
                            select {
                                width: 100%;
                                padding: 10px 15px;
                                margin: 5px 0;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f9f9f9;
                                font-size: 14px;
                                color: #333;
                                transition: all 0.3s ease;
                            }

                            select:focus {
                                border-color: #4CAF50;
                                background-color: #f1f8f1;
                                outline: none;
                            }

                            select option {
                                padding: 10px;
                            }

                            /* Hover effect for select elements */
                            select:hover {
                                border-color: #4CAF50;
                                background-color: #f1f8f1;
                            }

                            /* Style the select dropdown with a custom arrow */
                            select::-ms-expand {
                                display: none;
                            }

                            select {
                                -webkit-appearance: none;
                                -moz-appearance: none;
                                appearance: none;
                                background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 11 6%22%3E%3Cpath fill=%22none%22 stroke=%22#000%22 stroke-width=%221%22 d=%22M0 1L5.5 5 11 1%22/%3E%3C/svg%3E');
                                background-repeat: no-repeat;
                                background-position: right 10px center;
                                background-size: 12px;
                            }

                            /* Responsive styling for select */
                            @media (max-width: 768px) {
                                select {
                                    width: 95%;
                                }
                            }


                </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "header.php" ?>

    <h2>Your Tasks</h2>

    <div class="task-list">
        <?php if (count($tasks) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Duration</th>
                        <th>Due Date</th> <!-- Added the Due Date column -->
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['task_id']); ?></td>
                            <td><?php echo htmlspecialchars($task['title']); ?></td>
                            <td><?php echo htmlspecialchars($task['description']); ?></td>
                            <td>
                                <select name="status_<?php echo $task['task_id']; ?>" class="task-status">
                                    <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="in_progress" <?php echo ($task['status'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                </select>
                            </td>
                            <td>
                                <select name="priority_<?php echo $task['task_id']; ?>" class="task-priority">
                                    <option value="High" <?php echo ($task['priority'] == 'High') ? 'selected' : ''; ?>>High</option>
                                    <option value="Medium" <?php echo ($task['priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                    <option value="Low" <?php echo ($task['priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
                                    <option value="Wish" <?php echo ($task['priority'] == 'Wish') ? 'selected' : ''; ?>>Wish</option>
                                </select>
                            </td>
                            <td>
                                <select name="duration_<?php echo $task['task_id']; ?>" class="task-duration">
                                    <option value="Long" <?php echo ($task['duration'] == 'Long') ? 'selected' : ''; ?>>Long</option>
                                    <option value="Medium" <?php echo ($task['duration'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                    <option value="Short" <?php echo ($task['duration'] == 'Short') ? 'selected' : ''; ?>>Short</option>
                                    <option value="Unknown" <?php echo ($task['duration'] == 'Unknown') ? 'selected' : ''; ?>>Unknown</option>
                                </select>
                            </td>
                            <td><?php echo htmlspecialchars($task['due_date']); ?></td> <!-- Displaying Due Date -->
                            <td>
                                <!-- Update Button -->
                                <form action="edit_task_employee.php" method="GET">
                                    <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                                    <button type="submit" class="update-btn">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>You have no assigned tasks.</p>
        <?php } ?>
    </div>
    <script type="text/javascript">
    var active = document.querySelector("#navigationlistID li:nth-child(3)");
    active.classList.add("active");
</script>
</body>
</html>

<?php 
} else {
    // If not logged in or not an employee, redirect to login page
    $errormessage = "You must log in as an employee to view your tasks!";
    header("Location: login.php?error=" . urlencode($errormessage));
    exit();
} // end of file employee-task.php
?>
