<?php
    include "../../../classes/AjaxManipulators.php";
    $approver = new AjaxManipulators;
    $id = $_POST['id'];
    $is_final_approver = $approver->getInfostandardleave("approvalsequence_standardleave_5",$id,'is_final');
    if($is_final_approver == 0)
    {$is_final_approver_name='NO';}
    else 
   { $is_final_approver_name='YES';}
    $sequence_no_approver = $approver->getInfostandardleave("approvalsequence_standardleave_5",$id,'sequence_no');

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
            ,'is_final_approver' => $is_final_approver
            ,'is_final_approver_name'=>$is_final_approver_name
            ,'sequence_no_approver' => $sequence_no_approver
            ,'message' => 'success'
            ,'error' => 0
        ));
    }    
    echo $message;     
?>