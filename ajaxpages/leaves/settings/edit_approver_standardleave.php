<?php
    include "../../../classes/AjaxManipulators.php";
    $approver = new AjaxManipulators;
    $approver_id = $_POST['approver_id'];
    $approver_staff_id = $approver->getIdsUsingPositionId("employmentdetail",$approver_id,'staff_id');
    $approver_staff_name = $approver->getStaffNameUsingStaffId($approver_staff_id,'firstName','secondName','thirdName','lastName');
    $approver_position = $approver->fieldNameValue("staff_position",$approver_id,"title");
    if($approver_staff_id == "") {
        $message = json_encode(array(
            'message' => 'No approver found on the selected position!'
            ,'error' => 1
        ));
    } else {
        $message = json_encode(array(
            'approver_staff_id' => $approver_staff_id
            ,'approver_staff_name' => $approver_staff_name
            ,'approver_position' => $approver_position
            ,'approver_id' => $approver_id
            ,'message' => 'success'
            ,'error' => 0
        ));
    }    
    echo $message;     
?>