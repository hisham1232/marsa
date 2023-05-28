<?php
    include "../../../classes/AjaxManipulators.php";
    $ids = new AjaxManipulators;
    $bal = new AjaxManipulators;
    $draft = new AjaxManipulators;
    $leavetype_id = $_POST['leavetype_id'];
    $requestNo = $_POST['requestNo'];
    $staff_id = $_POST['staffId'];
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];
    $total = $_POST['total'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];
    //$addType = $_POST['addType'];
    $createdBy = $_POST['createdBy'];
    $position_id = $ids->employmentIDs($staff_id,'position_id');
    if ($leavetype_id == 1) { //standard leave
        $intLeaveBal = $bal->getInternalLeaveBalance($staff_id,'balance');
        if($total > $intLeaveBal) {
            $err = 1;
            $msge = "Insufficient Internal Leave Balance!<br/><br/>Current Balance: ".$intLeaveBal." days.<br/>You are applying for: ".$total." days.<br/><br/>Kindly adjust the date of the leave to continue.";
            $message = json_encode(array(
                'message' => $msge
                ,'error' => 1
            ));
        } else {
            $filterOut =  new AjaxManipulators;
            $filter =  new AjaxManipulators;
            $filterOutRows = $filterOut->singleReadFullQry("SELECT staff_id, startDate, endDate FROM standardleave WHERE staff_id = '$staff_id' AND startDate <= '$start_date' AND endDate >= '$end_date'");
            if($filterOut->totalCount < 1) {
                $fields = [
                    'requestNo'=>$requestNo,
                    'staff_id'=>$staff_id,
                    'leavetype_id'=>1,
                    'currentStatus'=>"Draft",
                    'dateFiled'=>date('Y-m-d H:i:s',time()),
                    'startDate'=>$start_date,
                    'endDate'=>$end_date,
                    'total'=>$total,
                    'reason'=>$notes,
                    'current_sequence_no'=>0,
                    'position_id'=>$position_id,
                    'current_approver_id'=>0
                ];
                if($draft->insert('standardleave',$fields)) {
                    $towtal = "-".$total;
                    $fields2 = [
                        'internalleavebalance_id'=>$requestNo,
                        'leavetype_id'=>1,
                        'staffId'=>$staff_id,
                        'startDate'=>$start_date,
                        'endDate'=>$end_date,
                        'total'=>$towtal,
                        'status'=>"Approved",
                        'notes'=>$notes,
                        'addType'=>2,
                        'createdBy'=>$createdBy
                    ];
                    if($draft->insert('internalleavebalancedetails',$fields2)) {
                        $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as i LEFT OUTER JOIN staff as s ON s.staffId = i.staff_id WHERE currentStatus = 'Draft' ORDER BY i.id DESC");
                        $request__No = $draft->requestNo("STL-","standardleave");
                        if($draft->totalCount != 0) {
                            $rows = array();
                            foreach($rowDraft as $row){
                                array_push($rows,$row);
                            }
                            $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                <p>Draft Added but not yet finalized.</p>
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
                        $err = 0;
                    }    
                }
            } else { //there is conflict
                $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as i LEFT OUTER JOIN staff as s ON s.staffId = i.staff_id WHERE currentStatus = 'Draft' ORDER BY i.id DESC");
                if($draft->totalCount != 0) {
                    $rows = array();
                    foreach($rowDraft as $row){
                        array_push($rows,$row);
                    }
                    $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                        <p>The system found that there is a conflict found between start date ('.date('d/m/Y',strtotime($start_date)).') and end date ('.date('d/m/Y',strtotime($end_date)).') of the leave. Please change the start and end date. Either staff has already filed a leave for these dates.</p>
                    </div>';
                    $message = json_encode(array(
                        'message' => "failure"
                        ,'rows' => $rows
                        ,'totalCount' => $draft->totalCount
                        ,'notification' => $notification
                        ,'error' => 0
                    ));
                } else {
                    $message = json_encode(array(
                        'message' => "no drafts found"
                        ,'rows' => 0
                        ,'totalCount' => $draft->totalCount
                        ,'error' => 0
                    ));
                }
            }                           
        }
    } else if ($leavetype_id == 2) {
        $emerLeaveBal = $bal->getEmergencyLeaveBalance($staff_id,'balance');
        if($total > $emerLeaveBal) {
            $err = 1;
            $msge = "Insufficient Emergency Leave Balance!<br/><br/>Current Balance: ".$emerLeaveBal." days.<br/>You are applying for: ".$total." days.<br/><br/>Kindly adjust the date of the leave to continue.";
            $message = json_encode(array(
                'message' => $msge
                ,'error' => 1
            ));
        } else {
            $filterOut =  new AjaxManipulators;
            $filter =  new AjaxManipulators;
            $filterOutRows = $filterOut->singleReadFullQry("SELECT staff_id, startDate, endDate FROM standardleave WHERE staff_id = '$staff_id' AND startDate <= '$start_date' AND endDate >= '$end_date'");
            if($filterOut->totalCount < 1) {
                $fields = [
                    'requestNo'=>$requestNo,
                    'staff_id'=>$staff_id,
                    'leavetype_id'=>2,
                    'currentStatus'=>"Draft",
                    'dateFiled'=>date('Y-m-d H:i:s',time()),
                    'startDate'=>$start_date,
                    'endDate'=>$end_date,
                    'total'=>$total,
                    'reason'=>$notes,
                    'current_sequence_no'=>0,
                    'position_id'=>$position_id,
                    'current_approver_id'=>0
                ];
                if($draft->insert('standardleave',$fields)) {
                    $towtal = "-".$total;
                    $fields2 = [
                        'emergencyleavebalance_id'=>$requestNo,
                        'staffId'=>$staff_id,
                        'startDate'=>$start_date,
                        'endDate'=>$end_date,
                        'total'=>$towtal,
                        'status'=>"Approved",
                        'notes'=>$notes,
                        'addType'=>3,
                        'createdBy'=>$createdBy
                    ];
                    if($draft->insert('emergencyleavebalancedetails',$fields2)) {
                        $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as i LEFT OUTER JOIN staff as s ON s.staffId = i.staff_id WHERE currentStatus = 'Draft' ORDER BY i.id DESC");
                        $request__No = $draft->requestNo("STL-","standardleave");
                        if($draft->totalCount != 0) {
                            $rows = array();
                            foreach($rowDraft as $row){
                                array_push($rows,$row);
                            }
                            $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                <p>Draft Added but not yet finalized.</p>
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
                        $err = 0;
                    }    
                }
            } else { //there is conflict
                $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as i LEFT OUTER JOIN staff as s ON s.staffId = i.staff_id WHERE currentStatus = 'Draft' ORDER BY i.id DESC");
                if($draft->totalCount != 0) {
                    $rows = array();
                    foreach($rowDraft as $row){
                        array_push($rows,$row);
                    }
                    $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                        <p>The system found that there is a conflict found between start date ('.date('d/m/Y',strtotime($start_date)).') and end date ('.date('d/m/Y',strtotime($end_date)).') of the leave. Please change the start and end date. Either staff has already filed a leave for these dates.</p>
                    </div>';
                    $message = json_encode(array(
                        'message' => "failure"
                        ,'rows' => $rows
                        ,'totalCount' => $draft->totalCount
                        ,'notification' => $notification
                        ,'error' => 0
                    ));
                } else {
                    $message = json_encode(array(
                        'message' => "no drafts found"
                        ,'rows' => 0
                        ,'totalCount' => $draft->totalCount
                        ,'error' => 0
                    ));
                }
            }                           
        }
    } else {
        $filterOut =  new AjaxManipulators;
            $filter =  new AjaxManipulators;
            $filterOutRows = $filterOut->singleReadFullQry("SELECT staff_id, startDate, endDate FROM standardleave WHERE staff_id = '$staff_id' AND startDate <= '$start_date' AND endDate >= '$end_date'");
            if($filterOut->totalCount < 1) {
                $fields = [
                    'requestNo'=>$requestNo,
                    'staff_id'=>$staff_id,
                    'leavetype_id'=>$leavetype_id,
                    'currentStatus'=>"Draft",
                    'dateFiled'=>date('Y-m-d H:i:s',time()),
                    'startDate'=>$start_date,
                    'endDate'=>$end_date,
                    'total'=>$total,
                    'reason'=>$notes,
                    'current_sequence_no'=>0,
                    'position_id'=>$position_id,
                    'current_approver_id'=>0
                ];
                if($draft->insert('standardleave',$fields)) {
                    $towtal = "-".$total;
                    $fields2 = [
                        'internalleavebalance_id'=>$requestNo,
                        'leavetype_id'=>$leavetype_id,
                        'staffId'=>$staff_id,
                        'startDate'=>$start_date,
                        'endDate'=>$end_date,
                        'total'=>0,
                        'status'=>"Approved",
                        'notes'=>$notes,
                        'addType'=>2,
                        'createdBy'=>$createdBy
                    ];
                    if($draft->insert('internalleavebalancedetails',$fields2)) {
                        $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as i LEFT OUTER JOIN staff as s ON s.staffId = i.staff_id WHERE currentStatus = 'Draft' ORDER BY i.id DESC");
                        $request__No = $draft->requestNo("STL-","standardleave");
                        if($draft->totalCount != 0) {
                            $rows = array();
                            foreach($rowDraft as $row){
                                array_push($rows,$row);
                            }
                            $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                <p>Draft Added but not yet finalized.</p>
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
                        $err = 0;
                    }    
                }
            } else { //there is conflict
                $rowDraft = $draft->readData("SELECT i.*, i.startDate as fStartDate, i.endDate as fEndDate, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as i LEFT OUTER JOIN staff as s ON s.staffId = i.staff_id WHERE currentStatus = 'Draft' ORDER BY i.id DESC");
                if($draft->totalCount != 0) {
                    $rows = array();
                    foreach($rowDraft as $row){
                        array_push($rows,$row);
                    }
                    $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                        <p>The system found that there is a conflict found between start date ('.date('d/m/Y',strtotime($start_date)).') and end date ('.date('d/m/Y',strtotime($end_date)).') of the leave. Please change the start and end date. Either staff has already filed a leave for these dates.</p>
                    </div>';
                    $message = json_encode(array(
                        'message' => "failure"
                        ,'rows' => $rows
                        ,'totalCount' => $draft->totalCount
                        ,'notification' => $notification
                        ,'error' => 0
                    ));
                } else {
                    $message = json_encode(array(
                        'message' => "no drafts found"
                        ,'rows' => 0
                        ,'totalCount' => $draft->totalCount
                        ,'error' => 0
                    ));
                }
            }    
    }
    echo $message;     
?>