<?php
session_start();
include "../../classes/DbaseManipulation.php"; // Inclusion of the class named AjaxManipulators
extract($_GET); // Any GET parameters being passed from the browser's URL
$checkLogin = new DbaseManipulation; // Database connection class instanciation

if (isset($_GET['slid'])) { //slid variable checking if it is set
    if (isset($_GET['token'])){ //token variable checking if it is set
        $key = 'na$ka722ka83pag24pa721ba43ga50bag'; //An alphanumeric key logs (this was only invented by me, haha!) any values will do.
        $login_id_hashed = hash_hmac('sha256',$_GET['slid'],$key); // hash_hmac algorithm, decripting the token value if it will match to the given parameters --> de3f024294f8574e7ef27f86655c0695a4f91b6b7579fbe8c519bce2e0848e5a
        if ($login_id_hashed == $_GET['token']) { //And now the checking, if they will match with the token given from the e-Services and to the $key created that was only invented by me, haha!            
			$slid = $_GET['slid'];
			$row = $checkLogin->singleReadFullQry("SELECT * FROM users WHERE username = '$slid' AND status != 0"); //Database Query
			if($checkLogin->totalCount == 0) { //If there is no record found
				echo "<h3 style='color:#F00'>Invalid username and password!</h5>";
			} else { //If there is record found
				$_SESSION['login_id'] = $row['id'];
				//echo '-->'.$_SESSION['login_id']; exit;
				$_SESSION['username'] = $row['username'];
				$_SESSION['user_type'] = $row['userType'];
				$_SESSION['status'] = $row['status'];
				header("Location: ../../index.php");
			}			
        } else { //token variable NOT SET!
				//Start a session so destroy it.
				session_destroy(); //After starting a session, destroy it now.
				header('Location: https://www.nct.edu.om/eservices/index.php'); // Redirect the user to e-services page.
		}
    }
}
?>


