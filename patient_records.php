<?php
session_start();
require_once "connection.php";
if (!isset($_SESSION['patient_id'])) {
    header("Location: index.php");
    exit();
}
$patient_id = $_SESSION['patient_id'];

$select_query_patient = "SELECT patient_first_name, patient_last_name 
                         FROM patients WHERE patient_id = $patient_id";
$result_patient = mysqli_query($conn, $select_query_patient);

if (!$result_patient) {
    die("Query failed: " . mysqli_error($conn));
}

$patient = mysqli_fetch_assoc($result_patient);
$patient_first_name = $patient['patient_first_name'];
$patient_full_name = $patient['patient_first_name'] . ' ' . $patient['patient_last_name'];


?>

<html lang="en">
    <head>
        <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
        <title>Welcome to MediQue :: My Visit Records</title>
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
                            <table>
                            <h1>My Previous Visits</h1>
                                <?php
                                //getting information from two tables using join
                                $sql = "SELECT
                                            v.queue_date,
                                            v.status
                                        FROM visit_records v
                                        WHERE patient_id = $patient_id
                                        ORDER BY v.queue_date DESC";

                                $result = $conn->query($sql);

                                if($result->num_rows > 0){
                                    echo "<tr>
                                            <th>Visit Date</th>
                                            <th>Status</th>
                                        </tr>";

                                    while ($row = $result->fetch_assoc()){
                                        echo "<tr>
                                                <td>" . $row["queue_date"] . "</td>
                                                <td>" . $row["status"] . "</td>
                                            </tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    echo "<p>No records found.</p>";
                                }

                                $conn->close();
                                ?>
                            </table>
                            <div class="hori-button-container">
                                <a href="patient_dashboard.php">
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