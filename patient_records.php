<?php
session_start();
require_once "connection.php";
if (!isset($_SESSION['patient_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['patient_id'];
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
                        <img src="welcome_header.png" alt="Welcome" class="image-top-right">
                        <div class="table-container">
                            <h1>My Previous Visits</h1>
                                <?php
                                //getting information from two tables using join
                                $sql = "SELECT
                                            q.queue_date,
                                            q.queue_time,
                                            q.status
                                        FROM queue q
                                        WHERE patient_id = $user_id
                                        ORDER BY q.queue_date DESC, q.queue_time ASC";

                                $result = $conn->query($sql);

                                if($result->num_rows > 0){
                                    echo '<table class="sticky-table">';
                                    echo "<tr>
                                            <th>Queue Date</th>
                                            <th>Queue Time</th>
                                            <th>Status</th>
                                        </tr>";

                                    while ($row = $result->fetch_assoc()){
                                        echo "<tr>
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
                            <div class="hori-button-container">
                                <a href="records.php">
                                    <button class="button-small">Visits Record</button>
                                </a>
                                <a href="userdata.php">
                                    <button class="button-small">User Data</button>
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