<?php
    include "../../../classes/AjaxManipulators.php";
    $checkHistory = new AjaxManipulators;
    $getMainInfo = new AjaxManipulators;
    $staffList = new AjaxManipulators;
    $id = $_POST['id'];
    $requestNo = $_POST['requestNo'];
    $info = $getMainInfo->singleReadFullQry("SELECT ot.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, i.*
    FROM internalleaveovertime as ot
    LEFT OUTER JOIN staff as s ON s.staffId = ot.staff_id
    LEFT OUTER JOIN internalleaveovertimefiled as i ON i.id = ot.id
    WHERE ot.id = $id");
    $currentStatus = $info['currentStatus'];
    $position_id = $info['position_id'];
    $no_of_days = 00.00;

    $rows = $checkHistory->readData("SELECT otl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleaveovertime_history as otl
    LEFT OUTER JOIN staff as s ON s.staffId = otl.staff_id WHERE otl.internalleaveovertime_id = $id ORDER BY id DESC");
    if($checkHistory->totalCount != 0) {
        $i = 0; $j = 0;
        $new_approver = new AjaxManipulators;
        $table = '';
        $table .= '
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="text-dark"><strong>Filed By:</strong> '.$info['staff_id'].' - '.$info['staffName'].'</h4>
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li class="none">
                                <h4 class="text-dark"><strong>Request No:</strong> <span class="badge badge-primary">'.$requestNo.'</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="text-dark"><strong>Date Filed:</strong> '.date('F m, Y',strtotime($info['dateFiled'])).'</h4>
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li class="none">
                                <h4 class="text-dark"><strong>Status:</strong> '.$info['currentStatus'].'</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="display table-hover table-striped table-bordered" cellspacing="2" cellpadding="10" width="100%">
                        <thead>
                            <tr>
                            <th colspan="5" class="text-center"><strong>Staff Names Who Will Work On This Overtime Request</strong></th>
                        </tr>
                            <tr>
                                <th>#</th>
                                <th>Staff Name</th>
                                <th>Duration</th>
                                <th>Total Days</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $rows2 = $staffList->readData("SELECT otd.startDate, otd.endDate, otd.total, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleaveovertimedetails_draft as otd LEFT OUTER JOIN staff as s ON s.staffId = otd.staffId WHERE otd.internalleaveovertime_id = '$requestNo' ORDER BY staffName");
                            foreach($rows2 as $row2){
                                $table .='
                                    <tr>
                                        <td>'.++$i.'.</td>
                                        <td>'.$row2["staffName"].'</td>
                                        <td>From '.date('d/m/Y',strtotime($row2["startDate"])).' to '.date('d/m/Y',strtotime($row2["endDate"])).'</td>
                                        <td>'.$row2["total"].'</td>
                                    </tr>
                                ';
                            }
                            $i++;
        $table .=  '</tbody>
                    </table>
                </div>
                <hr/>
                <div class="table-responsive">
                    <table class="display table-hover table-striped table-bordered" cellspacing="2" cellpadding="10" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff Name</th>
                                <th>Notes/Comments</th>
                                <th>Status</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach($rows as $row){
                                $table .='
                                    <tr>
                                        <td>'.++$j.'.</td>
                                        <td>'.$row["staffName"].'</td>
                                        <td>'.$row["notes"].'</td>
                                        <td>'.$row["status"].'</td>
                                        <td>'.date('d/m/Y H:i:s',strtotime($row["created"])).'</td>
                                    </tr>
                                ';
                            }
                            $i++;
        $table .=  '</tbody>
                    </table>
                </div>
                <hr/>        
                <div class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                    <div class="form-group row">
                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Notes/Comments <br>سبب الإجازة</label>
                        <div class="col-sm-9">
                            <div class="controls">
                                <div class="input-group">
                                    <input type="hidden" name="shLId" value="'.$id.'" />
                                    <textarea name="notes" class="form-control notesComments" rows="2"></textarea>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                ';
        $message = json_encode(array(
            'id' => $id
            ,'requestNo' => $requestNo
            ,'position_id' => $position_id
            ,'no_of_days' => $no_of_days
            ,'message' => $table
            ,'error' => 0
        ));
    } else {
        $table = '';
        $table .= '
            <div class="table-responsive">
            <table class="table-bordered" cellspacing="2" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Notes/Comments</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="4">No history found!</td></tr>
                </tbody>
            </table>
            </div>';
        $message = json_encode(array(
            'message' => $table
            ,'error' => 0
        ));
    }
    echo $message;     
?>