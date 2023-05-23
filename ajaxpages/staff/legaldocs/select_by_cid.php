<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("staffvisa",$id);
    if($row['isCurrent'] == 1) {
        $isCurrent = 'Active';
    } else {
        $isCurrent = 'Expired';
    }
    $message = json_encode(array(
        'id'                => $id
        ,'number'           => $row['civilId']
        ,'issueDate'        => date('d/m/Y',strtotime($row['issueDate']))
        ,'expiryDate'       => date('d/m/Y',strtotime($row['expiryDate']))
        ,'isCurrentId'      => $row['isCurrent']
        ,'isCurrent'        => $isCurrent
        ,'error'            => 0
    ));
    echo $message;
?>