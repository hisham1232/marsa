<?php
$id = $_GET['id'];
if($id != ""){
include "../../classes/AjaxManipulators.php";
$chk = new AjaxManipulators;
$row = $chk->singleReadFullQry("SELECT ministryStaffId FROM staff WHERE ministryStaffId = '$id'");
if($chk->totalCount != 0){
    echo "<span style='color:red'><i class='fa fa-exclamation-triangle'></i> Ministry Staff ID already exist!<br/>Please type valid Ministry Staff ID.</span>";
}
}
?>								
                              	