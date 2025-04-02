<?php
// Include the database connection file
require_once 'connection.php';

// Start the session to get patient info
session_start();

// Get the patient ID from session
$patient_id = $_SESSION['patient_id']; 

// Get patient's name from the database
$select_query_patient = "SELECT patient_first_name, patient_last_name 
                         FROM patients WHERE patient_id = $patient_id";
$result_patient = mysqli_query($conn, $select_query_patient);

if (!$result_patient) {
    die("Query failed: " . mysqli_error($conn));
}

$patient = mysqli_fetch_assoc($result_patient);
$patient_first_name = $patient['patient_first_name'];
$patient_full_name = $patient['patient_first_name'] . ' ' . $patient['patient_last_name'];

// Check if the patient is already in the queue
$select_query_queue = "SELECT * FROM queue WHERE patient_id = $patient_id AND queue_date = CURDATE()";
$result_queue = mysqli_query($conn, $select_query_queue);

if (!$result_queue) {
    die("Query failed: " . mysqli_error($conn));
}

$in_queue = mysqli_num_rows($result_queue) > 0;

// Get the next queue position
$select_position_query = "SELECT MAX(queue_position) AS max_position FROM queue WHERE queue_date = CURDATE()";
$result_position = mysqli_query($conn, $select_position_query);

if ($result_position) {
    $row = mysqli_fetch_assoc($result_position);
    $next_position = $row['max_position'] + 1;
} else {
    $next_position = 1;
}

// Handle "Add me" action
if (isset($_POST['add']) && !$in_queue) {
    $insert_query = "INSERT INTO queue (patient_id, queue_position, added_by, queue_date, queue_time) 
                     VALUES ($patient_id, $next_position, NULL, CURDATE(), CURTIME())";
    $result_insert = mysqli_query($conn, $insert_query);

    if (!$result_insert) {
        die("Query failed: " . mysqli_error($conn));
    }

    header("Location: patient_dashboard.php");
    exit();
}

// Handle "Remove me" action
// First add it to records
if (isset($_POST['remove']) && $in_queue) {
    $delete_query = "DELETE FROM queue WHERE patient_id = $patient_id AND queue_date = CURDATE()";
    $result_delete = mysqli_query($conn, $delete_query);
    $add_to_records_query = "INSERT INTO visit_records (patient_id, queue_date, status) 
            VALUES ($patient_id, CURDATE(), 'Dropped')";
    $result_add_to_records = mysqli_query($conn, $add_to_records_query);

    if (!$result_delete) {
        die("Query failed: " . mysqli_error($conn));
    }

    header("Location: patient_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MediQue :: Patient Dashboard</title>
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

        <main>
            <div class="content-container">
                <div class="table-wrapper">
                    <img src="welcome_name.png" alt="Welcome" class="image-top-left">
                    <h3 class="text-name-left"><?php echo $patient_first_name; ?></h3>
                    <a href="logout.php" class="text-logout-right">Log Out</a>

                    <div class="table-container">
                        <p>Date: <?php echo date("F j, Y"); ?></p>
                        <h1>Your Queue Status</h1>

                    <?php if ($in_queue):
                       $queue = mysqli_fetch_assoc($result_queue);
                        echo
                            "<table class='sticky-table'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Queue Position</th>
                                        <th>Joined At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                            <td>{$queue['patient_id']}</td>
                                            <td>{$patient_full_name}</td>
                                            <td>{$queue['queue_position']}</td>
                                            <td>{$queue['queue_time']}</td>
                                          </tr>";
                                    ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>You are not in the queue.</p>
                        <?php endif; ?>
                        
                        <div class="hori-button-container">
                            <form method="POST">
                                <button type="submit" name="add" class="button-add">Add Me</button>
                                <button type="submit" name="remove" class="button-remove">Remove Me</button>
                            </form>
                        </div>

                        <h3><b><u>Abbotsford Care Walk-In Clinic</u></b></h3>
                        <p>1234 Healthway Drive</p>
                        <p>Abbotsford, BC V2T 4X5</p>
                        <p>(604) 555-1234</p>   
                   <a href="userdata.php">
                    <button class="button-small">User Data</button>
                   </a>
                    </div>
                </div> 
            </div>
           
        </main>

        <footer>
            <p>&copy; 2025 Charan, Sana, Jade</p>
        </footer>
    </div>
</body>
</html>