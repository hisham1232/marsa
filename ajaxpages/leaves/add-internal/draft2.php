<?php
    include "../../../classes/AjaxManipulators.php";
    extract($_POST);
    if($startDate == "" || $endDate == "") {
        $message = json_encode(array(
            'message' => "Start and end date are required. Please select starting and ending date."
            ,'error' => 1
        ));
        echo $message;
    } else if ($total == ""){
        $message = json_encode(array(
            'message' => "Total number of days is a required field. Please select starting and ending date."
            ,'error' => 1
        ));
        echo $message;
    } else if ($notes == ""){
        $message = json_encode(array(
            'message' => "Notes is a required field. Please enter a notes."
            ,'error' => 1
        ));
        echo $message;    
    } else {
        $rows = array();
        $draft = new AjaxManipulators;
        $fields = [
            'internalleavebalance_id'=>$internalleavebalance_id,
            'leavetype_id'=>$leavetype_id,
            'staffId'=>$staffId,
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'total'=>$total,
            'status'=>$status,
            'notes'=>$notes,
            'addType'=>$addType,
            'createdBy'=>$createdBy
        ];
        $filterOut =  new AjaxManipulators;
        $filter =  new AjaxManipulators;
        $filterOutRows = $filterOut->singleReadFullQry("SELECT staffId, startDate, endDate FROM internalleavebalancedetails WHERE staffId = '$staffId' AND startDate <= '1970-01-01' AND endDate >= '1970-01-01'");
        if($filterOut->totalCount == 0) {
            $filterRows = $filter->singleReadFullQry("SELECT staffId, startDate, endDate FROM internalleavebalancedetails_draft WHERE staffId = '$staffId' AND startDate <= '1970-01-01' AND endDate >= '1970-01-01'");
            if($filter->totalCount == 0) {
                if($draft->insert("internalleavebalancedetails_draft",$fields)) {
                    $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleavebalancedetails_draft as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId ORDER BY i.id DESC");
                    if($draft->totalCount != 0) {
                        foreach($rowDraft as $row){
                            array_push($rows,$row);
                        }
                        $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                            <p>Draft Added.</p>
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
                }
            } else {
                $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleavebalancedetails_draft as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId ORDER BY i.id DESC");
                if($draft->totalCount != 0) {
                    foreach($rowDraft as $row){
                        array_push($rows,$row);
                    }
                    $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                        <p>The system found that there is a conflict found between start date ('.date('d/m/Y',strtotime($startDate)).') and end date ('.date('d/m/Y',strtotime($endDate)).') of the leave. Please change the start and end date. Either staff has already receives credits for these dates or the staff has leaves that conflicts to it.</p>
                                    </div>';
                    $message = json_encode(array(
                        'message' => "failure"
                        ,'rows' => $rows
                        ,'totalCount' => $draft->totalCount
                        ,'notification' => $notification
                        ,'error' => 0
                    ));
                } else {
                    $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                        <p>The system found that there is a conflict found between start date ('.date('d/m/Y',strtotime($startDate)).') and end date ('.date('d/m/Y',strtotime($endDate)).') of the leave. Please change the start and end date. Either staff has already receives credits for these dates or the staff has leaves that conflicts to it.</p>
                                    </div>';    
                    $message = json_encode(array(
                        'message' => "success"
                        ,'rows' => 0
                        ,'totalCount' => $draft->totalCount
                        ,'notification' => $notification
                        ,'error' => 0
                    ));
                }
            }
        } else {
            $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleavebalancedetails_draft as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId ORDER BY i.id DESC");
            if($draft->totalCount != 0) {
                foreach($rowDraft as $row){
                    array_push($rows,$row);
                }
                $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                    <p>The system found that there is a conflict found between start date ('.date('d/m/Y',strtotime($startDate)).') and end date ('.date('d/m/Y',strtotime($endDate)).') of the leave. Please change the start and end date. Either staff has already receives credits for these dates or the staff has leaves that conflicts to it.</p>
                                </div>';
                $message = json_encode(array(
                    'message' => "failure"
                    ,'rows' => $rows
                    ,'totalCount' => $draft->totalCount
                    ,'notification' => $notification
                    ,'error' => 0
                ));
            } else {
                $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                    <p>The system found that there is a conflict found between start date ('.date('d/m/Y',strtotime($startDate)).') and end date ('.date('d/m/Y',strtotime($endDate)).') of the leave. Please change the start and end date. Either staff has already receives credits for these dates or the staff has leaves that conflicts to it.</p>
                                </div>';    
                $message = json_encode(array(
                    'message' => "success"
                    ,'rows' => 0
                    ,'totalCount' => $draft->totalCount
                    ,'notification' => $notification
                    ,'error' => 0
                ));
            }
        }                    
        echo $message;
    }
?>