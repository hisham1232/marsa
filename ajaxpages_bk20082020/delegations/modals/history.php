<?php
    include "../../../classes/AjaxManipulators.php";
    extract($_POST);
        $rows = array();
        $history = new AjaxManipulators;
        $hrows = $history->readData("SELECT h.id, h.delegation_id, h.created as created, h.notes, h.status, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM delegation_history as h LEFT OUTER JOIN staff as s ON s.staffId = h.staff_id WHERE h.delegation_id = $id");
        foreach($hrows as $row){
            array_push($rows,$row);
        }
        $message = json_encode(array(
            'message' => "success"
            ,'rows' => $rows
            ,'error' => 0
        ));
        echo $message;
?>