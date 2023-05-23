<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("staffextracertificate",$id);
    $certificate_name = $get->fieldNameValue("extracertificates",$row['extracertificates_id'],"name");
    $message = json_encode(array(
        'id'                => $id
        ,'certificateName'  => $certificate_name
        ,'certificate_id'   => $row['extracertificates_id']
        ,'certificateNo'    => $row['certificateNo']
        ,'dateIssue'        => date('d/m/Y',strtotime($row['issuedDate']))
        ,'placeIssue'       => $row['issuedPlace']
        ,'error'            => 0
    ));
    
    echo $message;     
?>