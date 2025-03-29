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
                <img src="logo.png" alt="MediQue Logo" class="header-image">
            </header>
        
            <main>
                <div class="content-container">
                    <div class="table-wrapper">
                        <div class="table-container">
                            <h1>User Data</h1>
                                <?php

                                $sql = "SELECT
                                            patient_id,
                                            patient_first_name,
                                            patient_last_name,
                                            patient_email,
                                            patient_password,
                                            patient_city,
                                            patient_phone,
                                            emergency_contact_name,
                                            emergency_contact_phone
                                        FROM patients
                                        ORDER BY patient_id ASC";

                                $result = $con->query($sql);

                                if($result->num_rows > 0){
                                    echo '<table class="sticky-table">';
                                    echo "<tr>
                                            <th>Patient ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>City</th>
                                            <th>Phone</th>
                                            <th>Emergency Contact Name</th>
                                            <th>Emergency Contact Phone</th>
                                        </tr>";

                                    while ($row = $result->fetch_assoc()){
                                        echo "<tr>
                                                <td>" . $row["patient_id"] . "</td>
                                                <td>" . $row["patient_first_name"] . "</td>
                                                <td>" . $row["patient_last_name"] . "</td>
                                                <td>" . $row["patient_email"] . "</td>
                                                <td>" . $row["patient_password"] . "</td>
                                                <td>" . $row["patient_city"] . "</td>
                                                <td>" . $row["patient_phone"] . "</td>
                                                <td>" . $row["emergency_contact_name"] . "</td>
                                                <td>" . $row["emergency_contact_phone"] . "</td>
                                            </tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    echo "<p>No user data found.</p>";
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