<?php
    include "../../classes/AjaxManipulators.php";
    $toggle = new AjaxManipulators;
    extract($_POST);
    $row = $toggle->singleReadFullQry("SELECT * FROM e_forms_request WHERE id = $id");
    if($row['status'] == "Pending") {
        $sts = "Approved";
    } else {
        $sts = "Pending";
    }
    $toggle->executeSQL("UPDATE e_forms_request SET status = '$sts', updatedBy = '$updatedby' WHERE id = $id");
    $message = json_encode(array(
        'message' => "success"
        ,'id' => $id
        ,'sts' => $sts
        ,'error' => 0
    ));
    echo $message;
?>