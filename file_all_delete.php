<?php
include('include_headers.php');
if(!$helper->isUserLogged()) {
	include_once('not_allowed.php');
} else {
	$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
	//$linkid = $helper->cleanString($_GET['linkid']);
    //$allowed = $helper->withAccess($user_type,$linkid);
	if($allowed){
		if($_POST) { // check if value was posted
			$delete = new DbaseManipulation;
			$id = $delete->cleanString($_POST['object_id']);
			if($_POST['deleting'] == "department") {
				$delete->destroy("department",$id);
			}
			if($_POST['deleting'] == "section") {
				$delete->destroy("section",$id);
			}
			if($_POST['deleting'] == "jobtitle") {
				$delete->destroy("jobtitle",$id);
			}
			if($_POST['deleting'] == "qualification") {
				$delete->destroy("qualification",$id);
			}
			if($_POST['deleting'] == "degree") {
				$delete->destroy("degree",$id);
			}
			if($_POST['deleting'] == "specialization") {
				$delete->destroy("specialization",$id);
			}
			if($_POST['deleting'] == "extracertificates") {
				$delete->destroy("extracertificates",$id);
			} 
			if($_POST['deleting'] == "sponsor") {
				$delete->destroy("sponsor",$id);
			}
			if($_POST['deleting'] == "salarygrade") {
				$delete->destroy("salarygrade",$id);
			}
			/*if($_POST['deleting'] == "approver") {
				$delete->destroy("approver",$id);
			}*/
			if($_POST['deleting'] == "nationality") {
				$delete->destroy("nationality",$id);
			}
			if($_POST['deleting'] == "contacttype") {
				$delete->destroy("contacttype",$id);
			}
			if($_POST['deleting'] == "status") {
				$delete->destroy("status",$id);
			}
			if($_POST['deleting'] == "leavetype") {
				$delete->destroy("leavetype",$id);
			}
			if($_POST['deleting'] == "college_position") {
				$delete->destroy("staff_position",$id);
			}
			if($_POST['deleting'] == "taskapprover") {
				$delete->destroy("taskapprover",$id);
			}
			if($_POST['deleting'] == "holiday") {
				echo "OK!";
				$delete->destroy("holiday",$id);
			} 
		}
	} else {
		include_once('not_allowed.php');
	}
}	
?>