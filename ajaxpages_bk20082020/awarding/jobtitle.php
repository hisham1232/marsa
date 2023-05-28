<?php
session_start();
include "../../classes/AjaxManipulators.php";
$id = $_POST['id'];
$help = new AjaxManipulators;
$row = $help->singleRead("employmentdetail",$id);
$jobTitleId = $row['jobtitle_id'];
$message = json_encode(array(
    'jobtitle' => $help->fieldNameValue("jobtitle",$jobTitleId,'name')
    ,'error' => 0
));
echo $message;
?>


