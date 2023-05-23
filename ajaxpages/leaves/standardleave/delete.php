<?php
    include "../../../classes/AjaxManipulators.php";
    extract($_POST);
    $rows = array();
    $draft = new AjaxManipulators;
    if($draft->destroy("standardleave",$id)) {
        $draft->executeSQL("DELETE FROM standardleave_history WHERE requestNo = '$requestNo'");
        $draft->executeSQL("DELETE FROM internalleavebalancedetails WHERE internalleavebalance_id = '$requestNo'");
        $draft->executeSQL("DELETE FROM emergencyleavebalancedetails WHERE emergencyleavebalance_id = '$requestNo'");
        
        $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as i LEFT OUTER JOIN staff as s ON s.staffId = i.staff_id WHERE currentStatus = 'Draft' ORDER BY i.id DESC");
        $request__No = $draft->requestNo("STL-","standardleave");
        if($draft->totalCount != 0) {
            foreach($rowDraft as $row){
                array_push($rows,$row);
            }
            $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                <p>Draft Deleted.</p>
            </div>';
            $message = json_encode(array(
                'message' => "success"
                ,'rows' => $rows
                ,'totalCount' => $draft->totalCount
                ,'notification' => $notification
                ,'next_request' => $request__No
                ,'error' => 0
            ));
        } else {
            $message = json_encode(array(
                'message' => "success"
                ,'rows' => 0
                ,'totalCount' => $draft->totalCount
                ,'next_request' => $request__No
                ,'error' => 0
            ));
        }
    } else {
        $message = json_encode(array(
            'message' => "An error occured during the process."
            ,'error' => 1
        ));
    }
    echo $message;
?>