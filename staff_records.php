<?php
session_start();
require_once "connection.php";
if (!isset($_SESSION['staff_id'])) {
    header("Location: index.php");
    exit();
}  
$staff_id = $_SESSION['staff_id'];

$select_query_staff = "SELECT staff_first_name, staff_last_name 
                         FROM staff WHERE staff_id = $staff_id";
$result_staff = mysqli_query($conn, $select_query_staff);

if (!$result_staff) {
    die("Query failed: " . mysqli_error($conn));
}

$staff = mysqli_fetch_assoc($result_staff);
$staff_first_name = $staff ['staff_first_name'];
$staff_full_name = $staff['staff_first_name'] . ' ' . $staff['staff_last_name'];

?>

<html lang="en">
    <head>
        <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
        <title>Welcome to MediQue :: All Visit Records</title>
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
                        <h3 class="text-name-left"><?php echo $staff_first_name; ?></h3>
                        <a href="logout.php" class="text-logout-right">Log Out</a>
                        <div class="table-container">
                            <h1>All Visits Record</h1>
                                <?php
                                //getting information from two tables using join
                                $sql = "SELECT
                                            p.patient_id,
                                            p.patient_first_name,
                                            p.patient_last_name,
                                            q.queue_date,
                                            q.queue_time,
                                            q.status
                                        FROM patients p
                                        JOIN queue q ON p.patient_id = q.patient_id
                                        ORDER BY q.queue_date DESC, q.queue_time ASC";

                                $result = $conn->query($sql);

                                if($result->num_rows > 0){
                                    echo '<table class="sticky-table">';
                                    echo "<tr>
                                            <th>Patient ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Queue Date</th>
                                            <th>Queue Time</th>
                                            <th>Status</th>
                                        </tr>";

                                    while ($row = $result->fetch_assoc()){
                                        echo "<tr>
                                                <td>" . $row["patient_id"] . "</td>
                                                <td>" . $row["patient_first_name"] . "</td>
                                                <td>" . $row["patient_last_name"] . "</td>
                                                <td>" . $row["queue_date"] . "</td>
                                                <td>" . $row["queue_time"] . "</td>
                                                <td>" . $row["status"] . "</td>
                                            </tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    echo "<p>No records found.</p>";
                                }

                                $conn->close();
                                ?>
                            <div style="margin-top:10px";>
                                <a href="staff_dashboard.php">
                                    <button class="button-small">Back</button>
                                </a>
                                </div>
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