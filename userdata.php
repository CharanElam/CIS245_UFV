<?php
session_start();
require_once "connection.php";
if (!isset($_SESSION['staff_id'])) {
    header("Location: index.php");
    exit();
}
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
                            <h1>User Data</h1>
                                <?php
                                //getting patient information from patient table
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

                                $result = $conn->query($sql);

                                //if rows exists, display in table, if not show 'no user data found'
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