<?php
	include "../../classes/AjaxManipulators.php";
	$find = new AjaxManipulators;
	if($_POST['deptCode'] == 1) {	
		$sql = "SELECT MAX(RIGHT(staff_id,3)) as newStaffID FROM employmentdetail WHERE department_id NOT IN (5,6,14,15,16) and LEFT(staff_id,1) IN ('1')";
	} else if ($_POST['deptCode'] == 2) {
		$sql = "SELECT MAX(RIGHT(staff_id,3)) as newStaffID FROM employmentdetail WHERE department_id = 16 and LEFT(staff_id,1) IN ('2')";		
	} else if ($_POST['deptCode'] == 3) {
		$sql = "SELECT MAX(RIGHT(staff_id,3)) as newStaffID FROM employmentdetail WHERE department_id = 6 and LEFT(staff_id,1) IN ('3')";
	} else if ($_POST['deptCode'] == 4) {		
		$sql = "SELECT MAX(RIGHT(staff_id,3)) as newStaffID FROM employmentdetail WHERE department_id = 5 and LEFT(staff_id,1) IN ('4')";
	} else if ($_POST['deptCode'] == 5) {
		$sql = "SELECT MAX(RIGHT(staff_id,3)) as newStaffID FROM employmentdetail WHERE department_id = 15 and LEFT(staff_id,1) IN ('5')";
	} else if ($_POST['deptCode'] == 6) {
		$sql = "SELECT MAX(RIGHT(staff_id,3)) as newStaffID FROM employmentdetail WHERE department_id = 14 and LEFT(staff_id,1) IN ('6')";
	} else if ($_POST['deptCode'] == 7) {
		$sql = "SELECT MAX(RIGHT(staff_id,3)) as newStaffID FROM employmentdetail WHERE department_id = 20 and LEFT(staff_id,1) IN ('7')";
	}
	
	$row = $find->singleReadFullQry($sql);
	if($find->totalCount != 0) {
		$newId = $row['newStaffID'] + 1;
		$lastThree = sprintf("%03d",$newId);
		// $lastThree = substr($newId,3,3);
	} else {
		$newId = "000001";
		$lastThree = substr($newId,3,3);
	}	

	$message = json_encode(array(
        'lastThree' => $lastThree
        ,'error' => 0
    ));
    echo $message;     
?>								
                              							
                              	