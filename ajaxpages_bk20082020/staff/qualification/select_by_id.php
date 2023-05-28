<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("staffqualification",$id);
    $degree_name = $get->fieldNameValue("degree",$row['degree_id'],"name");
    $certificate_name = $get->fieldNameValue("certificate",$row['certificate_id'],"name");
    $message = json_encode(array(
        'id' => $id
        ,'degree_id' => $row['degree_id']
        ,'degree_name' => $degree_name
        ,'certificate_id' => $row['certificate_id']
        ,'certificate_name' => $certificate_name
        ,'graduateYear' => $row['graduateYear']
        ,'institution' => $row['institution']
        ,'gpa' => $row['gpa']
        ,'certificate_no' => $row['certificateNo']
        ,'error' => 0
    ));
    
    echo $message;     
?>