<?php
    // Include the database connection file
    require_once 'connection.php';

    // Start the session
    session_start();

    // Ensure patient_id is set
    if (!isset($_SESSION['patient_id'])) {
        die("Error: You must be logged in.");
    }

    $patient_id = $_SESSION['patient_id']; // Patient's ID after login
?>
                      
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="medique.css">
</head>
<body>
    <div class="wrapper">
        <header class="header-container">
            <div class="header-bar"></div>
            <img src="logo.png" alt="MediQue Logo" class="header-image">
        </header>
    
        <main>
            <?php
                // Get patient's first name
                $select_query_patient = "SELECT patient_first_name FROM patients WHERE patient_id = $patient_id";
                $result_patient = mysqli_query($conn, $select_query_patient);

                if (!$result_patient) {
                    die("Query failed: " . mysqli_error($conn));
                }

                $patient = mysqli_fetch_assoc($result_patient);
                $patient_first_name = $patient['patient_first_name'];

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

                $row = mysqli_fetch_assoc($result_position);
                $next_position = ($row['max_position'] !== null) ? $row['max_position'] + 1 : 1;

                // Add the patient to the queue if they are not already in it
                if (isset($_POST['add_to_queue']) && !$in_queue) {
                    $insert_query = "INSERT INTO queue (patient_id, queue_position, added_by, queue_date, queue_time) 
                                     VALUES ($patient_id, $next_position, 0, CURDATE(), CURTIME())";
                    $result_insert = mysqli_query($conn, $insert_query);

                    if (!$result_insert) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    header("Location: patient_dashboard.php");
                    exit();
                }

                // Handle "Remove me from queue" action
                if (isset($_POST['remove_from_queue']) && $in_queue) {
                    $delete_query = "DELETE FROM queue WHERE patient_id = $patient_id AND queue_date = CURDATE()";
                    $result_delete = mysqli_query($conn, $delete_query);

                    if (!$result_delete) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    header("Location: patient_dashboard.php");
                    exit();
                }
            ?>

            <div class="content-container">
                <div class="table-wrapper">
                    <table>
                        <tr>
                            <td>
                                <img src="welcome_name.png" alt="Welcome" class="image-top-left">
                                <p class="text-name-left"><?php echo $patient_first_name; ?></p>
                                <a href="logout.php" class="text-logout-right">Log Out</a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="3">Date: <?php echo date("F j, Y"); ?></td>
                        </tr>
                        
                        <tr>
                            <td colspan="3">
                                <h3>Your Queue Status</h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Queue Position</th>
                                            <th>Joined At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($in_queue) {
                                                $queue = mysqli_fetch_assoc($result_queue);
                                                echo "<tr>
                                                        <td>" . $queue['patient_id'] . "</td>
                                                        <td>" . $queue['queue_position'] . "</td>
                                                        <td>" . $queue['queue_time'] . "</td>
                                                      </tr>";
                                            } else {
                                                echo "<tr><td colspan='3'>You are not in the queue.</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="3">
                                <form method="POST">
                                    <?php if ($in_queue): ?>
                                        <button type="submit" name="remove_from_queue">Remove me</button>
                                    <?php else: ?>
                                        <button type="submit" name="add_to_queue">Join Queue</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                        
                        
                        <tr>
                            <td colspan="3">
                                <b><u>Abbotsford Care Walk-In Clinic</u></b><br>
                                1234 Healthway Drive<br>
                                Abbotsford, BC V2T 4X5<br>
                                (604) 555-1234
                            </td>
                        </tr>
                    </table>
                </div>
            </div>    
        </main>
    
        <footer>
            <p>&copy; 2025 Charan, Sana, Jade</p>
        </footer>
    </div>
</body>
</html>
