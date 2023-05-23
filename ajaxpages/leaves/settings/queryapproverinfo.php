<?php
    include "../../../classes/AjaxManipulators.php";
    $approver = new AjaxManipulators;
    $position_id = $_POST['position_id'];
    $approver_staff_id = $approver->getIdsUsingPositionId("employmentdetail",$position_id,'staff_id');
    $approver_staff_name = $approver->getStaffNameUsingStaffId($approver_staff_id,'firstName','secondName','thirdName','lastName');
    if($approver_staff_id == "") {
        $message = json_encode(array(
            'message' => 'No approver found on the selected position!'
            ,'error' => 1
        ));
    } else {
        $message = json_encode(array(
            'staff_id' => $approver_staff_id
            ,'staff_name' => $approver_staff_name
            ,'message' => 'success'
            ,'error' => 0
        ));
    }    
    echo $message;     
?>