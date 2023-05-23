<?php
include "../../../classes/AjaxManipulators.php";
$delete = new AjaxManipulators;
$delete2 = new AjaxManipulators;
$delete3 = new AjaxManipulators;
$id = $_POST['id'];
$requestNo = $_POST['requestNo'];
if($_POST['deleting'] == "standard_leave") {
	$delete->destroy("standardleave",$id);
	$sqldel2 = "DELETE FROM internalleavebalancedetails WHERE internalleavebalance_id = '$requestNo'";
	$sqldel3 = "DELETE FROM emergencyleavebalancedetails WHERE emergencyleavebalance_id = '$requestNo'";
	$delete2->executeSQL($sqldel2);
	$delete3->executeSQL($sqldel3);
	$message = json_encode(array(
		'errors' => 0
	));						
}
echo $message;
	
?>