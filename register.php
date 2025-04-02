<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pFirstName = $_POST['first_name'];
    $pLastName = $_POST['last_name'];
    $pEmail = $_POST['email'];
    $pPassword = $_POST['password'];
    $pCity = $_POST['city'];
    $pPhone = $_POST['phone'];
    $pEmergencyName = $_POST['emergency_name'];
    $pEmergencyPhone = $_POST['emergency_phone'];

    $sql = "INSERT INTO patients (patient_first_name, patient_last_name, patient_email, patient_password, patient_city, patient_phone, emergency_contact_name, emergency_contact_phone) VALUES ('$pFirstName', '$pLastName', '$pEmail', '$pPassword', '$pCity', '$pPhone', '$pEmergencyName', '$pEmergencyPhone')";

    if ($conn->query($sql) === TRUE) {
        echo "User added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<html lang="en">
    <head>
        <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
        <title>Welcome to MediQue :: Home</title>
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
                        <img src="reg_header.png" alt="Registration" class="image-top-right">
                        <div class="form-container">
                            <form method="post">
                                <input type="text" name="first_name" placeholder="First Name" required><br>
                                <input type="text" name="last_name" placeholder="Last Name" required><br>
                                <input type="email" name="email" placeholder="Email" required><br>
                                <input type="password" name="password" placeholder="Password" required><br>
                                <input type="text" name="city" placeholder="City" required><br>
                                <input type="tel" name="phone" placeholder="Phone" required><br>
                                <input type="text" name="emergency_name" placeholder="Emergency Contact Name" required><br>
                                <input type="tel" name="emergency_phone" placeholder="Emergency Contact Phone" required><br>
                                <button type="submit" name="register">Register</button>
                            </form>
                        </div>
            </main>
        
            <footer>
                <p>&copy; 2025 Charan, Sana, Jade</p>
            </footer>
        </div>
    </body>
    </html>