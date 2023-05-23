<?php
$con = mysqli_connect("it.nct.edu.om","btec01","5113","dbbtec01");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Connected To Database!<br/>";
    $query = "SELECT * FROM TEST";
    $qry = mysqli_query($con,$query) or die(mysqli_error($con));
    if(mysqli_num_rows($qry) > 0){
        $status = mysqli_fetch_array($qry);
        echo $status['nm'];
    } else {
        echo "No Record Found!";
    }    
}
?>