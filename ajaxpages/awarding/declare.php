<?php
session_start();
include "../../classes/AjaxManipulators.php";
$id = $_POST['id'];
$awarder = $_POST['awarderId'];
$reason = $_POST['reason'];

$save = new AjaxManipulators;
$fields = [
	'award_candidate_id'=>$id,
	'selectedBy'=>$awarder,
	'comments'=>$reason,
	'dateEntered'=>date('Y-m-d H:i:s')
];
if($save->insert("award_winner",$fields)) {
	$save->executeSQL("UPDATE award_candidate SET canStatus = 'Winner' WHERE id = $id");
	$msg = "Employee of the month winner has been selected and declared successfully.";
}

$message = json_encode(array(
	'msg'=>$msg,
    'error' => 0
));
echo $message;
?>


