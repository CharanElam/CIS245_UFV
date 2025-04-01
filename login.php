<?php
session_start();
require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    if($role == 'Patient'){
        $query = "SELECT * FROM patients WHERE patient_email = '$email' AND patient_password = '$password'";
    } else {
        $query = "SELECT * FROM staff WHERE staff_email = '$email' AND staff_password = '$password'";
    }
    
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result)==0){
        header('location:index.php');
    }else {
        
       $user = mysqli_fetch_assoc($result);
       
       if($role == 'Patient') {
            $_SESSION['patient_id'] = $user['patient_id'];
            $_SESSION['patient_first_name'] = $user['patient_first_name'];
       } else {
            $_SESSION['staff_id'] = $user['staff_id'];
            $_SESSION['staff_first_name'] = $user['staff_first_name'];
       }
       
       $_SESSION['role'] = $role;
       $_SESSION['isloggedin'] = 1;
        
       if($role == 'Patient'){
           header("location: patient_dashboard.php");
       } else {
           header("location: staff_dashboard.php");
       }
        exit();
    }
}

mysqli_close($conn);
?>