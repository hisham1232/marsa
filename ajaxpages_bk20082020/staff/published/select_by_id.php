<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("staffpublication",$id);
    $message = json_encode(array(
        'id'                => $id
        ,'category'         => $row['category']
        ,'title'            => $row['title']
        ,'name'             => $row['name']
        ,'place'            => $row['place']
        ,'coAuthors'        => $row['coAuthors']
        ,'copies'           => $row['copies']
        ,'publishdate'      => date('d/m/Y',strtotime($row['publishDate']))
        ,'abstract'         => $row['abstract']
        ,'error'            => 0
    ));
    
    echo $message;     
?>