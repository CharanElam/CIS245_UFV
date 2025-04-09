<?php
// Include the database connection file
require_once 'connection.php';

// Start the session to get staff info
session_start();

// Get the staff ID from session 
$staff_id = $_SESSION['staff_id']; // staff ID after login

// Check if staff is logged in
if (!$staff_id) {
    header("Location: index.php");
    exit();
}

// Fetch staff name
$staff_query = "SELECT staff_first_name, staff_last_name FROM staff WHERE staff_id = $staff_id";
$staff_result = mysqli_query($conn, $staff_query);
$staff_data = mysqli_fetch_assoc($staff_result);
$staff_name = $staff_data['staff_first_name'] . ' ' . $staff_data['staff_last_name'];

// Fetch all patients in the queue
$select_query_queue = "SELECT queue.patient_id, queue.queue_position, 
                       CONCAT(patients.patient_first_name, ' ', patients.patient_last_name) AS patient_full_name, 
                       queue.priority, queue.status
                       FROM queue
                       JOIN patients ON queue.patient_id = patients.patient_id
                       ORDER BY queue.priority DESC, queue.queue_position ASC";

$result_queue = mysqli_query($conn, $select_query_queue);

if (!$result_queue) {
    die("Query failed: " . mysqli_error($conn));
}

// Handle adding a new patient to the queue
if (isset($_POST['add_patient'])) {
    $patient_id = $_POST['new_patient_id'];
    
    // Check if patient already in queue
    $check_query = "SELECT * FROM queue WHERE patient_id = $patient_id";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $message = "Patient already in queue";
    } else {
        // Get the next position for the new patient
        $select_position_query = "SELECT MAX(queue_position) AS max_position FROM queue";
        $result_position = mysqli_query($conn, $select_position_query);
        if ($result_position) {
            $row = mysqli_fetch_assoc($result_position);
            $next_position = $row['max_position'] + 1;  
        } else {
            $next_position = 1;  
        }

        // Insert the new patient into the queue
        $insert_query = "INSERT INTO queue (patient_id, queue_position, added_by, queue_date, queue_time, priority, status) 
                         VALUES ($patient_id, $next_position, $staff_id, CURDATE(), CURTIME(), 0, 'active')";
        $result_insert = mysqli_query($conn, $insert_query);

        if (!$result_insert) {
            die("Query failed: " . mysqli_error($conn));
        }

        // Reload the page after adding the patient to the queue
        header("Location: staff_dashboard.php");
        exit();
    }
}

// Function to reorder queue positions
function reorderQueue($conn) {
    // Get all active patients ordered by priority and current position
    $get_queue_query = "SELECT patient_id, priority FROM queue WHERE status = 'active' ORDER BY priority DESC, queue_position ASC";
    $queue_result = mysqli_query($conn, $get_queue_query);
    
    $position = 1;
    while ($row = mysqli_fetch_assoc($queue_result)) {
        $update_query = "UPDATE queue SET queue_position = $position WHERE patient_id = {$row['patient_id']}";
        mysqli_query($conn, $update_query);
        $position++;
    }
}

// Handle status update and priority changes
if (isset($_POST['update_status'])) {
    $patient_id = $_POST['patient_id'];
    $status = $_POST['status'];
    $priority = isset($_POST['priority']) ? 1 : 0;

    // Update priority if changed
    $update_priority_query = "UPDATE queue SET priority = $priority WHERE patient_id = $patient_id";
    mysqli_query($conn, $update_priority_query);
    
    // Update status
    if ($status == 'completed' || $status == 'dropped') {
        // Update status in the queue table first
        $update_query = "UPDATE queue SET status='$status' WHERE patient_id=$patient_id";
        $result_update = mysqli_query($conn, $update_query);

        if (!$result_update) {
            die("Query failed: " . mysqli_error($conn));
        }

        // Insert into visit_records table
        $insert_visit_query = "INSERT INTO visit_records (patient_id, queue_date, status) 
                               SELECT patient_id, queue_date, status FROM queue WHERE patient_id = $patient_id";
        $result_insert_visit = mysqli_query($conn, $insert_visit_query);

        if (!$result_insert_visit) {
            die("Query failed: " . mysqli_error($conn));
        }

        // Remove from queue after moving to visit_records
        $delete_query = "DELETE FROM queue WHERE patient_id = $patient_id";
        $result_delete = mysqli_query($conn, $delete_query);

        if (!$result_delete) {
            die("Query failed: " . mysqli_error($conn));
        }
    } 
    
    // Reorder the queue
    reorderQueue($conn);

    // Redirect after action
    header("Location: staff_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MediQue :: Staff Dashboard</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="medique.css">
</head>
<body>
    <div class="wrapper">
        <header class="header-container">
            <div class="header-bar"></div>
            <a href="index.php">
                <img src="logo.png" alt="MediQue Logo" class="header-image">
            </a>
        </header>
        <br> <br> <br>
    <main>
        <div class="content-container">
            <div class="table-wrapper">
                <img src="welcome_name.png" alt="Welcome" class="image-top-left">
                <h3 class="text-name-left"><?php echo $staff_name; ?></h3>
                <a href="logout.php" class="text-logout-right">Log Out</a>
                <div class="table-container">
                    <h1>Patients in Queue</h1>     
        <table border="1">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Full Name</th>
                    <th>Queue Position</th>
                    <th>Higher Priority</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_queue)) { ?>
                    <tr>
                        <form method="POST" action="">
                            <td><?php echo $row['patient_id']; ?></td>
                            <td><?php echo $row['patient_full_name']; ?></td>
                            <td><?php echo $row['queue_position']; ?></td>
                            <td><input type="checkbox" name="priority" <?php echo ($row['priority'] == 1) ? 'checked' : ''; ?>></td>
                            <td>
                                <select name="status">
                                    <option value="active" <?php echo ($row['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="completed" <?php echo ($row['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                    <option value="dropped" <?php echo ($row['status'] == 'dropped') ? 'selected' : ''; ?>>Dropped</option>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="patient_id" value="<?php echo $row['patient_id']; ?>">
                                <button type="submit" name="update_status">Update</button>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Add New Patient Form -->
        <br><h2>Add New Patient</h2>
        <?php if (isset($message)):
             echo htmlspecialchars($message); 
             endif; ?>
        <form method="POST" action="">
            <label for="new_patient_id">Enter Patient ID:</label>
            <input type="text" name="new_patient_id" id="new_patient_id" required>
            <button type="submit" name="add_patient" class="button-add">Add to Queue</button>
        </form>
        <br>
        <div>
            <br> <a href="staff_records.php">
            <button class="button-small">All Visits Record</button>
            </a>
            <a href="staff_userdata.php">
            <button class="button-small">Patient Details</button>
            </a>
        </div>
        </div>  
     </div>
    </div>
    </main>
</body>
</html>