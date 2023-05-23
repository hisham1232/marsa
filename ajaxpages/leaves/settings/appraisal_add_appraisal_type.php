<?php
    include "../../../classes/AjaxManipulators.php";
    $save = new AjaxManipulators;
    $check = new AjaxManipulators;
    $staff_id = $_POST['staff_id'];
    $appraisal_type = $_POST['appraisal_type'];
    $description = $save->fieldNameValue("appraisal_type_description",$appraisal_type,'name');
    $check->singleReadFullQry("SELECT * FROM appraisal_type WHERE staff_id = $staff_id");
    if($check->totalCount != 0) {
        $message = json_encode(array(
            'msg' => 'Appraisal type cannot add! Staff has already existing one. Use Edit function instead of adding.',
            'error' => 1
        ));
    } else {
        if($save->executeSQL("INSERT INTO appraisal_type (appraisal_type, description, staff_id, active) VALUES ($appraisal_type, '$description', $staff_id, 1)")) {
            $message = json_encode(array(
                'msg' => 'Appraisal type has been added!',
                'error' => 0
            ));
        }
    }    
    echo $message;     
?>