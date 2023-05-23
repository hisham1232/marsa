<?php
$id = $_GET['id'];
include "../../classes/AjaxManipulators.php";
$chk = new AjaxManipulators;
$row = $chk->singleReadFullQry("SELECT staffId FROM staff WHERE staffId = '$id'");
if($chk->totalCount != 0){
    echo "<span style='color:red'><i class='fa fa-exclamation-triangle'></i> Staff ID already exist!<br/>Please type valid Staff ID.</span>";
}
?>								
                              	