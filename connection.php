<?php
// Database connection details
$db_hostname = 'localhost';
$db_database = 'medique';
$db_username = 'root';
$db_password = '';

// Establish connection
$con = new mysqli($db_hostname, $db_username, $db_password, $db_database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
