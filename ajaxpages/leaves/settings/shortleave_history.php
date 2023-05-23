<?php
    include "../../../classes/AjaxManipulators.php";
    $checkHistory = new AjaxManipulators;
    $position_id = $_POST['position_id'];
    $rows = $checkHistory->readData("SELECT a.*, e.staff_id as approver_staff_id,
    concat(pa.firstName,' ',pa.secondName,' ',pa.thirdName,' ',pa.lastName) as prev_approver,
    concat(na.firstName,' ',na.secondName,' ',na.thirdName,' ',na.lastName) as new_approver,
    concat(cb.firstName,' ',cb.secondName,' ',cb.thirdName,' ',cb.lastName) as created_by
    FROM approvalsequence_shortleave_history AS a
    LEFT OUTER JOIN employmentdetail as e ON e.position_id = a.previous_approver
    LEFT OUTER JOIN staff as pa ON pa.staffId = e.staff_id
    LEFT OUTER JOIN staff as na ON na.staffId = e.staff_id
    LEFT OUTER JOIN staff as cb ON cb.staffId = a.createdBy
    WHERE a.position_id = $position_id AND e.isCurrent = 1 AND e.status_id = 1 ORDER BY a.id DESC");
    if($checkHistory->totalCount != 0) {
        $new_approver = new AjaxManipulators;
        $table = '';
        $table .= '
                <div class="table-responsive">
                <table class="table-bordered" cellspacing="2" cellpadding="10" width="100%">
                    <thead>
                        <tr>
                            <th>New Approver</th>
                            <th>Prev. Approver</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Updated By</th>
                            <th>Date Updated</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($rows as $row){
                            if($row["active"] == 1)
                                $aktibo = "<span class='badge badge-success'>Active</span>";  
                            else 
                                $aktibo = "<span class='badge badge-danger'>Not-Active</span>";
                                
                            $new_approver_staff_id = $new_approver->getIdsUsingPositionId("employmentdetail",$row["new_approver"],'staff_id');
                            $new_approver_staff_name = $new_approver->getStaffNameUsingStaffId($new_approver_staff_id,'firstName','secondName','thirdName','lastName');
                            $table .='
                                <tr>
                                    <td>'.$row["new_approver"].'</td>
                                    <td>'.$row["prev_approver"].'</td>
                                    <td>'.$aktibo.'</td>
                                    <td>'.$row["notes"].'</td>
                                    <td>'.$row["created_by"].'</td>
                                    <td>'.date('d/m/Y H:i:s',strtotime($row["created"])).'</td>
                                </tr>
                            ';
                        }
        $table .=  '</tbody>
                </table>
                </div>';
        $message = json_encode(array(
            'message' => $table
            ,'error' => 0
        ));
    } else {
        $table = '';
        $table .= '
            <div class="table-responsive">
            <table class="display table-hover table-striped table-bordered" cellspacing="2" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th>New Approver</th>    
                        <th>Prev. Approver</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Updated By</th>
                        <th>Date Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="6">No history found!</td></tr>
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