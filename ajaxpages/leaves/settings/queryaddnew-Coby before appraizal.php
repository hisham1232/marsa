<?php
    include "../../../classes/AjaxManipulators.php";
    $approver = new AjaxManipulators;
    $position_id = $_POST['position_id'];
    $approver_staff_id = $approver->getIdsUsingPositionId("employmentdetail",$position_id,'staff_id');
    $approver_staff_name = $approver->getStaffNameUsingStaffId($approver_staff_id,'firstName','secondName','thirdName','lastName');
    $college_position_name = $approver->fieldNameValue("staff_position",$position_id,'title');
    if($approver_staff_id == "") {
        $message = json_encode(array(
            'message' => 'No approver found on the selected position!'
            ,'college_position_name' => $college_position_name
            ,'error' => 1
        ));
    } else {
        $message = json_encode(array(
            'staff_id' => $approver_staff_id
            ,'staff_name' => $approver_staff_name
            ,'college_position_name' => $college_position_name
            ,'message' => 'success'
            ,'error' => 0
        ));
    }    
    echo $message;     
?>