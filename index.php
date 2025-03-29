<?php
session_start();
include 'connection.php';
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
                <div class="text-container">
                    <p>Skip the crowded waiting rooms and manage your time 
                        better with <b>MediQueue</b>, a virtual queue system designed 
                        for walk-in clinics.
                    </p>
                </div>
                <div class="content-container">
                    <div class="table-wrapper">
                        <img src="welcome_header.png" alt="Welcome" class="image-top-right">
                        <div class="table-container">
                            <table style="text-align: center; 
                                                padding-left: 40px; 
                                                font-size: 20px;
                                                text-decoration: none;">
                                <tr>
                                    <td>
                                        <b><u>Abbotsford Care Walk-In Clinic</u></b><br>
                                        1234 Healthway Drive<br>
                                        Abbotsford, BC V2T 4X5<br>
                                        (604) 555-1234
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #F5F5F5;
                                        font-size: 25px;">
                                        Today is <?php echo date("F j, Y"); ?>
                                        <br> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="login.php">
                                            <button class="button">Click to Join Queue</button>
                                        </a>
                                    </td>
                                    
                                </tr>
                            </table>
                        </div>
                    </div> 
                </div>
                <a href="records.php">Patients Visits Record</a>
                <a href="userdata.php">User Data</a>
                </div>    
            </main>
        
            <footer>
                <p>&copy; 2025 Charan, Sana, Jade</p>
            </footer>
        </div>
    </body>
    </html>
