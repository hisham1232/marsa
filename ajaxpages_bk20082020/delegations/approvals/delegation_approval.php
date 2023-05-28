<?php
    include "../../../classes/AjaxManipulators.php";
    $checkHistory = new AjaxManipulators;
    $getMainInfo = new AjaxManipulators;
    $id = $_POST['id'];
    $requestNo = $_POST['requestNo'];
    $row = $getMainInfo->singleReadFullQry("SELECT d.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as delegator, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as delegatee FROM delegation as d LEFT OUTER JOIN staff as s ON s.staffId = d.staffIdFrom LEFT OUTER JOIN staff as ss ON ss.staffId = d.staffIdTo WHERE d.id = $id");
    $table = '';
        $table .= '
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">Request By: <span class="text-primary">'.$row['delegator'].'</span></div>
                    <div class="col-md-6">Request ID: <span class="text-primary">'.$requestNo.'</span></div>
                </div>
                <div class="row">
                    <div class="col-md-6">Request Date: <span class="text-primary">'.date('d/m/Y H:i:s',strtotime($row['created'])).'</span></div>
                    <div class="col-md-6">Status: <span class="text-primary">'.$row['status'].'</span></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">Delegated Role:</div><div class="col-md-7"><span class="text-primary">'; 
                    if($row['shl'] == 1) {
                        $table .= ' <span class="badge badge-success">Short Leave Approval</span>';
                    }
                    if($row['stl'] == 1) {
                        $table .= ' <span class="badge badge-primary">Standard Leave Approval</span>';
                    }
                    if($row['otl'] == 1) {
                        $table .= ' <span class="badge badge-warning">Overtime Leave Approval</span>';
                    }
                    if($row['clr'] == 1) {
                        $table .= ' <span class="badge badge-danger">Clearance Approval</span>';
                    }
                $table .= '</span></div>
                </div>
                <div class="row">
                    <div class="col-md-3">Delegated Staff: </div><div class="col-md-7"><span class="text-primary">'.$row['delegatee'].'</span></div>
                </div>
                <div class="row">
                    <div class="col-md-3">Delegated Date: </div><div class="col-md-7"><span class="text-primary">From '.date('d/m/Y',strtotime($row['startDate'])).' to '.date('d/m/Y',strtotime($row['endDate'])).'</span></div>
                </div>
                <div class="row">
                    <div class="col-md-3">Note: </div><div class="col-md-7"><span class="text-primary">'.$row['reason'].'</span></div>
                </div>
                <hr>
                <p class="font-weight-bold">Extension Form </p>
                <div class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">Delegated Role</label>
                        <div class="col-sm-9">
                            <div class="controls">
                                <div class="input-group">
                                    <div class="controls">';
                                        if($row['shl'] == 1) {
                                            $table .= '<fieldset>
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" value="1" name="delegation_task_id" class="custom-control-input">
                                                    <span class="custom-control-label">Short Leave Approval</span>
                                                </label>
                                            </fieldset>';
                                        } if($row['stl'] == 1) {   
                                            $table .= '<fieldset>
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" value="2" name="delegation_task_id" class="custom-control-input">
                                                    <span class="custom-control-label">Standard Leave Approval</span>
                                                </label>
                                            </fieldset>';
                                        } if($row['otl'] == 1) {    
                                            $table .= '<fieldset>
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" value="3" name="delegation_task_id" class="custom-control-input">
                                                    <span class="custom-control-label">Overtime Leave Approval</span>
                                                </label>
                                            </fieldset>';
                                        } if($row['clr'] == 1) {    
                                            $table .= '<fieldset>
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" value="4" name="delegation_task_id" class="custom-control-input">
                                                    <span class="custom-control-label">Clearance Approval</span>
                                                </label>
                                            </fieldset>';
                                        }    

                                        $table .=
                                    '</div>
                                </div>                                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label"><span class="text-danger">*</span>Note</label>
                        <div class="col-sm-9">
                            <div class="controls">
                                <div class="input-group">
                                    <textarea class="form-control notesComments" rows="2" minlength="10"></textarea>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">
                                            <i class="far fa-comment"></i>
                                        </span>
                                    </div>                                                    
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
    
    echo $message;     
?>