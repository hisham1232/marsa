<?php
    include "../../../classes/AjaxManipulators.php";
    $department_id = $_POST['department_id'];
    $loadStaff = new AjaxManipulators;
    $rows = $loadStaff->readData("SELECT e.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM employmentdetail as e LEFT OUTER JOIN staff as s ON s.staffId = e.staff_id WHERE e.status_id = 1 AND e.isCurrent = 1 AND e.department_id = $department_id ORDER BY staffName");
    if($loadStaff->totalCount != 0) {
        $staffs = array();
        foreach($rows as $row){
            array_push($staffs,$row);
        }
        $message = json_encode(array(
            'message' => "enable finalized button"
            ,'rows' => $staffs
            ,'totalCount' => $loadStaff->totalCount
            ,'error' => 0
        ));
    } else {
        $message = json_encode(array(
            'message' => "No staff found on the selected department."
            ,'rows' => 0
            ,'totalCount' => 0
            ,'error' => 1
        ));
    }
        echo $message;     
?>