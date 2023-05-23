<?php
    include "../../../classes/AjaxManipulators.php";
    $save = new AjaxManipulators;
    $id = $_POST['id'];
    $new_appraisal_type = $_POST['new_appraisal_type'];
    $new_appraisal_type_display = $save->fieldNameValue("appraisal_type_description",$new_appraisal_type,'name');
    if($save->executeSQL("UPDATE appraisal_type SET appraisal_type = $new_appraisal_type, description = '$new_appraisal_type_display' WHERE id = $id")) {
        $message = json_encode(array(
            'msg' => 'Appraisal type has been updated!',
            'new_appraisal_type_display' => $new_appraisal_type_display,
            'error' => 0
        ));
    }
    echo $message;     
?>