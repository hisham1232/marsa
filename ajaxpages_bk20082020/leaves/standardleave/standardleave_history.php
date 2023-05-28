<?php
    include "../../../classes/AjaxManipulators.php";
    $checkHistory = new AjaxManipulators;
    $getMainSHInfo = new AjaxManipulators;
    $id = $_POST['id'];
    $requestNo = $_POST['requestNo'];
    $info = $getMainSHInfo->singleReadFullQry("SELECT stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName 
    FROM standardleave as stl
    LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id
    WHERE stl.id = $id");
    $currentStatus = $info['currentStatus'];
    $rows = $checkHistory->readData("SELECT stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave_history as stl
    LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.standardleave_id = $id ORDER BY stl.id DESC");
    if($checkHistory->totalCount != 0) {
        $i = 0;
        $new_approver = new AjaxManipulators;
        $table = '';
        $table .=    
                '<div class="d-flex flex-wrap">
                    <div>
                        <h4 class="text-dark">Staff: '.$info['staff_id'].' - '.$info['staffName'].'</h4>
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li class="none">
                                <h4 class="text-dark">Request No: <span class="badge badge-primary">'.$requestNo.'</span></h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="text-dark">Date Filed: '.date('F m, Y',strtotime($info['dateFiled'])).'</h4>
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li class="none">
                                <h4 class="text-dark">Duration: From '.date('d/m/Y',strtotime($info['startDate'])).' to '.date('d/m/Y',strtotime($info['endDate'])).'</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <div>
                        <h4 class="text-dark">Status: '.$info['currentStatus'].'</h4>
                    </div>
                    <div class="ml-auto">
                        <ul class="list-inline">
                            <li class="none">
                                <h4 class="text-dark">No. of Days: '.$info['total'].'</h4>
                            </li>
                        </ul>
                    </div>
                </div>
                ';
        $table .='
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <div>
                                    <h3 class="card-title">Leave Approval History</h3>
                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                </div>
                            </div>';
                            foreach($rows as $row){
                                $table .='
                                    <div class="ribbon-vwrapper card">
                                        <div class="ribbon ribbon-info ribbon-vertical-l">'.++$i.'</div>
                                        <h3 class="ribbon-content">'.$row["staffName"].'</h3>
                                        <p class="ribbon-content"><span class="text-muted">Status : <span class="text-primary">'.$row["status"].' on </span>
                                        <span class="text-info pull-right">'.date('F m, Y H:i:s',strtotime($row["created"])).'</span></span></p>
                                        <p class="ribbon-content"><i>'.$row["notes"].'</i></p>
                                    </div>    
                                    
                                ';
                            }
        $table .=
                        '</div>
                    </div>
                </div>
        ';        
        if($currentStatus == 'Pending') { //show only the type notes or comments if the status is Pending...
                $table.='
                        <hr/>        
                        <div class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                            <div class="form-group row">
                                <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Notes/Comments <br>سملاحظات</label>
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
        }        
                
        $message = json_encode(array(
            'id' => $id
            ,'requestNo' => $requestNo    
            ,'message' => $table
            ,'status' => $currentStatus
            ,'error' => 0
        ));
    } else {
        $table = '';
        $table .= '
            <div class="table-responsive">
            <table class="table-bordered" cellspacing="2" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th>Initiator</th>
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