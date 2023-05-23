<?php
    include "../../../classes/AjaxManipulators.php";
    extract($_POST);
    $checkDraft = new AjaxManipulators;
    $row = $checkDraft->singleReadFullQry("SELECT id, attachment FROM standardleave WHERE id = $id");
    //echo "SELECT id, attachment FROM standardleave WHERE id = $id";
    if($checkDraft->totalCount != 0) {
        $message = json_encode(array(
            'url' => $row['attachment'],
            'error' => 0
        ));
    } else {
        $message = json_encode(array(
            'url' => '',
            'error' => 1
        ));
    }
    echo $message;     
?>