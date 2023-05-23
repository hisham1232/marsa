<?php
include "../../../classes/AjaxManipulators.php";
$delete = new AjaxManipulators;
$id = $_POST['id'];
if($delete->destroy("internalleavebalancedetails",$id) == 'true') {
	$message = json_encode(array(
		'errors' => 0
	));						
	echo $message;	
}
?>