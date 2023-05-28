<?php
    include "../../../classes/AjaxManipulators.php";
    $checkHistory = new AjaxManipulators;
    $id = $_POST['id'];
    $requestNo = $_POST['requestNo'];
    $rows = $checkHistory->readData("SELECT sh.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM shortleave_history as sh
    LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id WHERE sh.shortleave_id = $id ORDER BY id DESC");
    if($checkHistory->totalCount != 0) {
        $i = 0;
        $new_approver = new AjaxManipulators;
        $table = '';
        $table .= '
                <div class="ml-auto">
                    <ul class="list-inline">
                        <li class="none">
                            <h3 class="text-muted text-success">Request No: <span class="badge badge-primary requestNo">'.$requestNo.'</span></h3>
                        </li>
                    </ul>
                </div>
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
                                    <td>'.++$i.'.</td>
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