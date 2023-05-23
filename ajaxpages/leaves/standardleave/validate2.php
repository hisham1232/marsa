<?php
    include "../../../classes/AjaxManipulators.php";
    $checkIfExist = new AjaxManipulators;
    $staff_id = $_POST['staff_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    //$sql = "SELECT l.name as leavetype, stl.* FROM standardleave as stl LEFT OUTER JOIN leavetype as l ON l.id = stl.leavetype_id WHERE stl.startDate <= '$start_date' AND stl.endDate >= '$end_date' AND stl.staff_id = '$staff_id' AND stl.currentStatus IN ('Pending', 'Approved', 'Approved-HR')";
    $sql = "SELECT d.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as delegator FROM delegation as d LEFT OUTER JOIN staff as s ON s.staffId = d.staffIdFrom WHERE d.staffIdTo = '$staff_id' AND d.startDate <= '$start_date' AND d.endDate >= '$end_date' AND d.status IN ('Pending', 'Active');";
    $rows = $checkIfExist->readData($sql);
    if($checkIfExist->totalCount != 0) {
        $table = '
            <div class="panel-body">
                <h4>Delegation of roles to the selected staff conflicts with the following:</h4>
                <div class="table-responsive">
                    <table class="display table-hover table-striped table-bordered" cellspacing="2" cellpadding="10" width="100%">
                        <thead>
                        <tr>
                            <th>Request No</th>
                            <th>Delegated By</th>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Duration</th>
                        </tr>
                        </thead>
                        <tbody>';
                            foreach($rows as $row){
                                $table .='
                                    <tr>
                                        <td class="text-success">'.$row["requestNo"].'</td>
                                        <td>'.$row["delegator"].'</td>
                                        <td>'.$row["status"].'</td>
                                        <td>'.date('d/m/Y H:i:s',strtotime($row["created"])).'</td>
                                        <td>From '.date('d/m/Y',strtotime($row["startDate"])).' to '.date('d/m/Y',strtotime($row["endDate"])).'</td>
                                    </tr>
                                ';
                            }
        $table .=       '</tbody>
                    </table>        
                </div>                    
            </div>
        ';
        $message = json_encode(array(
                'message' => $table
                ,'error' => 1
        ));
    } else {
        $message = json_encode(array(
            'message' => 'success'
            ,'error' => 0
        ));
    }    
    echo $message;     
?>