<?php
session_start();
include 'connection.php';
?>

<html lang="en">
    <head>
        <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
        <title>Welcome to MediQue :: Patient Visit Records</title>
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
                        <img src="admin_header.png" alt="Admin" class="image-top-right">
                        <div class="table-container">
                            <h1>Patient Visits Record</h1>
                                <?php

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

                                $result = $con->query($sql);

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

                                $con->close();
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