<?php
    include "../../../classes/AjaxManipulators.php";
    extract($_POST);
        $rows = array();
        $history = new AjaxManipulators;
        $lrows = $history->readData("SELECT id, shl, stl, otl, clr FROM delegation WHERE id = $id");
        foreach($lrows as $row) {
            if($row['shl'] == 1) {
                array_push($rows,"<span class='badge badge-success'>Short Leave Approval</span> ");
            }
            if($row['stl'] == 1) {
                array_push($rows,"<span class='badge badge-primary'>Standard Leave Approval</span> ");
            }
            if($row['otl'] == 1) {
                array_push($rows,"<span class='badge badge-warning'>Overtime Leave Approval</span> ");
            }
            if($row['clr'] == 1) {
                array_push($rows,"<span class='badge badge-danger'>Clearance Approval</span> ");
            }
        }
                                                                              
        $message = json_encode(array(
            'message' => "success"
            ,'rows' => $rows
            ,'error' => 0
        ));
        echo $message;
    
?>