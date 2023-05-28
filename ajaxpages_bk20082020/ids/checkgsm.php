<?php
$gsm = $_GET['gsm'];
include "../../classes/AjaxManipulators.php";
$chk = new AjaxManipulators;
$row = $chk->singleReadFullQry("SELECT data FROM contactdetails WHERE data = '$gsm'");
if($chk->totalCount != 0){
    echo "<span style='color:red'><i class='fa fa-exclamation-triangle'></i> GSM already exist!<br/>Please type valid GSM.</span>";
}
?>								
                              	