<?php
    include "../../../classes/AjaxManipulators.php";
    $checkDraft = new AjaxManipulators;
    $checkDraft->singleReadFullQry("SELECT id FROM internalleavebalancedetails_draft");
    if($checkDraft->totalCount != 0) {
        $message = json_encode(array(
            'message' => "enable finalized button"
            ,'enable' => 1
        ));
    } else {
        $message = json_encode(array(
            'message' => "disable finalized button"
            ,'enable' => 0
        ));
    }
        echo $message;     
?>