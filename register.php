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
                <img src="logo.png" alt="MediQue Logo" class="header-image">
            </header>
        
            <main>
                <div class="content-container">
                    <div class="table-wrapper">
                        <img src="reg_header.png" alt="Registration" class="image-top-right">
                        <div class="form-container">
                            <form>
                                <table>
                                    <tr>
                                        <th><label for="name">Full Name:</label></th>
                                        <td><input type="text" id="name" placeholder="Enter your name"></td>
                                    </tr>
                                    <tr>
                                        <th><label for="email">Email:</label></th>
                                        <td><input type="email" id="email" placeholder="Enter your email"></td>
                                    </tr>
                                    <tr>
                                        <th><label for="phone">Phone Number:</label></th>
                                        <td><input type="tel" id="phone" placeholder="Enter your phone number"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><button type="submit">Register</button></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
            </main>
        
            <footer>
                <p>&copy; 2025 Charan, Sana, Jade</p>
            </footer>
        </div>
    </body>
    </html>