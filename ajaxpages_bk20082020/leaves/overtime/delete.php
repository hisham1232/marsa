<?php
    include "../../../classes/AjaxManipulators.php";
    extract($_POST);
    $rows = array();
    $draft = new AjaxManipulators;
    if($draft->destroy("internalleaveovertimedetails_draft",$id)) {
        $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleaveovertimedetails_draft as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId WHERE i.status = 'Drafted' ORDER BY i.id DESC");
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
                ,'error' => 0
            ));
        } else {
            $message = json_encode(array(
                'message' => "success"
                ,'rows' => 0
                ,'totalCount' => $draft->totalCount
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