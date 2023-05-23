<?php
    include "../../../classes/AjaxManipulators.php";
    $delete = new AjaxManipulators;
    $id = $_POST['id'];
    $tbl = $_POST['tbl'];
    if($tbl == 'visacivil') {
        $delete->destroy("staffvisa",$id);
    } else {
        $delete->destroy("staffpassport",$id);
    }
    $message = json_encode(array(
        'id'                => $id
        ,'error'            => 0
        ,'msg' => 'Document has been delete.'
    ));
    echo $message;
?>