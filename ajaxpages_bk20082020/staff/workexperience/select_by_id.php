<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("staffworkexperience",$id);
    $message = json_encode(array(
        'id'                => $id
        ,'designation'      => $row['designation']
        ,'organizationName' => $row['organizationName']
        ,'organizationType' => $row['organizationType']
        ,'startDate'        => date('d/m/Y',strtotime($row['startDate']))
        ,'endDate'          => date('d/m/Y',strtotime($row['endDate']))
        ,'error'            => 0
    ));
    
    echo $message;     
?>