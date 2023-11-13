<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("contactdetails",$id);
     $contacttype_name = $get->fieldNameValue("contacttype",$row['contacttype_id'],"name");
     if($row['isCurrent']== 'Y')
     $isCurrent_name="Active";
     else if ($row['isCurrent']=='N')
     $isCurrent_name="Not Active";
     else 
     $isCurrent_name=" ";
     $message = json_encode(array(
        'id' => $id
        ,'staff_id' => $row['staff_id']
        ,'contacttype_id' => $row['contacttype_id']
        ,'contacttype_name' =>  $contacttype_name
        ,'stafffamily_id' => $row['stafffamily_id']
        ,'data' => $row['data']
        ,'isCurrent' => $row['isCurrent']
        ,'isCurrent_name' =>  $isCurrent_name
        ,'isFamily' => $row['isFamily']
        
    ));
    
    echo $message;     
?>