<?php
	extract($_GET);
	include "../../classes/AjaxManipulators.php";
	$chk = new AjaxManipulators;
	$find = new AjaxManipulators;
	$rows = $chk->readData("SELECT TOP 1 staffId FROM staff WHERE staffId LIKE '$first3%' ORDER BY staffId DESC");
	$ctr = $yearCode;
	$firstThree = $deptCode.$ctr;
	if($chk->totalCount == 0) {
		do {
			$prefix = $deptCode.$ctr;
			$rowx = $find->readData("SELECT TOP 1 staffId FROM staff WHERE staffId LIKE '$prefix%' ORDER BY staffId DESC");
			if ($find->totalCount != 0) {
				foreach($rowx as $row){
					$newStaffId = $row['staffId'] + 1;
					$toBeReplace = substr($newStaffId, 0, 3);
					$new_str = str_replace($toBeReplace,$firstThree,$newStaffId);
					echo trim($new_str);
				}
			}
			$ctr--;
		} while ($find->totalCount < 1);
	} else {
		$prefix = $deptCode.$ctr;
		foreach($rows as $row){
			$newStaffId = $row['staffId'] + 1;
			$toBeReplace = substr($newStaffId, 0, 3);
			$new_str = str_replace($toBeReplace,$firstThree,$newStaffId);
			echo trim($new_str);
		}
	}
?>								
                              	