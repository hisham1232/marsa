<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("staffresearch",$id);
    $message = json_encode(array(
        'id'                => $id
        ,'category'         => $row['category']
        ,'title'            => $row['title']
        ,'subject'          => $row['subject']
        ,'organization'     => $row['organization']
        ,'location'         => $row['location']
        ,'startDate'        => date('d/m/Y',strtotime($row['startDate']))
        ,'endDate'          => date('d/m/Y',strtotime($row['endDate']))
        ,'abstract'         => $row['abstract']
        ,'error'            => 0
    ));
    
    echo $message;     
?>