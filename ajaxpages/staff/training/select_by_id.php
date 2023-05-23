<?php
    include "../../../classes/AjaxManipulators.php";
    $get = new AjaxManipulators;
    $id = $_POST['id'];
    $row = $get->singleRead("stafftraining",$id);
    $category = $get->fieldNameValue("trainingtype",$row['trainingtype_id'],"name");
    if($row['inCollege'] == 1) {
        $inCollege = 'Yes';
    } else {
        $inCollege = 'No';
    }
    if($row['isSponsoredByCollege'] == 1) {
        $isSponsoredByCollege = 'Yes';
    } else {
        $isSponsoredByCollege = 'No';
    }
    $message = json_encode(array(
        'id'                => $id
        ,'category'         => $category
        ,'category_id'         => $row['trainingtype_id']
        ,'title'            => $row['title']
        ,'startDate'        => date('d/m/Y',strtotime($row['startDate']))
        ,'endDate'          => date('d/m/Y',strtotime($row['endDate']))
        ,'place'            => $row['place']
        ,'inCollegeId'        => $row['inCollege']
        ,'inCollege'        => $inCollege
        ,'isSponsoredByCollegeId'        => $row['isSponsoredByCollege']
        ,'isSponsoredByCollege'  => $isSponsoredByCollege
        ,'error'            => 0
    ));
    
    echo $message;     
?>