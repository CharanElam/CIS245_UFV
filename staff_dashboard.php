<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: index.php");
    exit();
}

echo "Welcome, " . $_SESSION['staff_first_name'];
?>
<br>
<a href="staff_records.php">All Visits Record</a><br>
<a href="staff_userdata.php">Patient Details</a><br>
<a href="logout.php">Logout</a>