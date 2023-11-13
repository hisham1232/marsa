<?php 

,'is_final_approver' => $is_final_approver
,'is_final_approver_name'=>$is_final_approver_name
,'sequence_no_approver' => $sequence_no_approver


    $id = $_POST['id'];
    $is_final_approver = $approver->getInfostandardleave("approvalsequence_standardleave",$id,'is_final');
    if($is_final_approver == 0)
    $is_final_approver_name='NO';
    $sequence_no_approver = $approver->getInfostandardleave("approvalsequence_standardleave",$id,'sequence_no');



?>