<?php
    error_reporting(E_ALL);
    $con = mysqli_connect("192.193.10.3","group6","6520","dbgroup6");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        echo "Connected to the database!<br/>";
    }
    $sql = "SELECT * FROM EMPLOYEES ORDER BY emp_id LIMIT 1";
    $x = mysqli_query($con,$sql) or die(mysqli_error());
    if(mysqli_num_rows($x) > 0){
        $status = mysqli_fetch_array($x);
        echo $status['emp_id']." - ".$status['f_name'];
    } else {
        echo "No records found!";
    }
?>