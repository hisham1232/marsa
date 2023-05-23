<?php
    include "../../../classes/AjaxManipulators.php";
    $update = new AjaxManipulators;
    $select = new AjaxManipulators;
    $id = $_POST['id'];
    $active = $_POST['active'];
    $created_by = $_POST['created_by'];
    if($update->executeSQL("UPDATE access_menu_matrix_sub SET active = $active, created_by = '$created_by' WHERE id = $id")){
        $row = $select->singleReadFullQry("SELECT a.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM access_menu_matrix_sub as a LEFT OUTER JOIN staff as s ON s.staffId = a.created_by WHERE a.id = $id");
        if($select->totalCount != 0) {
            if($active == 1) {
                $mensahe = "User permission has been granted!";
            } else {
                $mensahe = "User permission has been revoked!";
            }
            $message = json_encode(array(
                'message' => $mensahe
                ,'updated_by' => $row['staffName']
                ,'updated' => date('d/m/Y H:i:s',strtotime($row['modified']))
                ,'error' => 0
            ));  
        } else {
            $message = json_encode(array(
                'message' => 'Query Error.'
                ,'error' => 1
            ));   
        }   
    }      
    echo $message;     
?>