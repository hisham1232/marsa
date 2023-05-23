<?php
    include "../../../classes/AjaxManipulators.php";
    $staffId = $_POST['staffId'];
    $getInternal = new AjaxManipulators;
    $internal = $getInternal->getInternalLeaveBalance($staffId,'balance');
    if($internal) {
        $message = json_encode(array(
            'message' => "success"
            ,'balance' => $internal
            ,'error' => 0
        ));
    } else {
        $message = json_encode(array(
            'message' => "success"
            ,'balance' => 0
            ,'error' => 0
        ));
    }    
    echo $message;     
?>