<?php
session_start();
include "classes/DbaseManipulation.php";
$id = $_POST['id'];
$action = $_POST['action'];
if($action == 1) {
	$fields = [
        'status'=>'OPEN'
    ];
    $save = new DbaseManipulation;
    if($save->update("appraisal_settings",$fields,$id)) {
		$message = json_encode(array(
		    'msg' => 'Staff appraisal has been opened!'
		    ,'error' => 0
		));
	}	
} else {
	$fields = [
        'status'=>'CLOSED'
    ];
    $save = new DbaseManipulation;
    if($save->update("appraisal_settings",$fields,$id)) {
		$message = json_encode(array(
		    'msg' => 'Staff appraisal has been closed!'
		    ,'error' => 0
		));
	}
}	
echo $message;
?>


