<?php
	include "../../classes/AjaxManipulators.php";
	$find = new AjaxManipulators;
	if($_POST['deptCode'] == 1) {
		$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE department_id NOT IN (5,6,14,15,16) ORDER BY id DESC";
	} else if ($_POST['deptCode'] == 2) {
		$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE department_id = 16 ORDER BY id DESC";
	} else if ($_POST['deptCode'] == 3) {
		$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE department_id = 6 ORDER BY id DESC";
	} else if ($_POST['deptCode'] == 4) {
		$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE department_id = 5 ORDER BY id DESC";
	} else if ($_POST['deptCode'] == 5) {
		$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE department_id = 15 ORDER BY id DESC";
	} else if ($_POST['deptCode'] == 6) {
		$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE department_id = 14 ORDER BY id DESC";
	} else if ($_POST['deptCode'] == 7) {
		$sql = "SELECT TOP 1 staff_id FROM employmentdetail WHERE department_id = 20 ORDER BY id DESC";
	}
	
	$row = $find->singleReadFullQry($sql);
	if($find->totalCount != 0) {
		$newId = $row['staff_id'] + 1;
		$lastThree = substr($newId,3,3);
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
                              	