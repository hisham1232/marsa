<?php
    include "../../../classes/AjaxManipulators.php";
    $checkIfExist = new AjaxManipulators;
    $staff_id = $_POST['staff_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $sql = "SELECT l.name as leavetype, stl.* FROM standardleave as stl LEFT OUTER JOIN leavetype as l ON l.id = stl.leavetype_id WHERE stl.startDate <= '$start_date' AND stl.endDate >= '$end_date' AND stl.staff_id = '$staff_id' AND stl.currentStatus IN ('Pending', 'Approved', 'Approved-HR')";
    $rows = $checkIfExist->readData($sql);
    if($checkIfExist->totalCount != 0) {
        $table = '
            <div class="panel-body">
                <h4>Selected date(s) conflicts with your other filed leaves and/or official mission.</h4>
                <br/>
                <h4>Here are the list of your leaves and/or official mission that gives conflicts on your current application:</h4>
                <div class="table-responsive">
                    <table class="display table-hover table-striped table-bordered" cellspacing="2" cellpadding="10" width="100%">
                        <thead>
                        <tr>
                            <th>Request No</th>
                            <th>Leave Type</th>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Duration</th>
                        </tr>
                        </thead>
                        <tbody>';
                            foreach($rows as $row){
                                $table .='
                                    <tr>
                                        <td><a href="standardleave_my_details.php?id='.$row["requestNo"].'" target="_blank">'.$row["requestNo"].'</a></td>
                                        <td>'.$row["leavetype"].'</td>
                                        <td>'.$row["currentStatus"].'</td>
                                        <td>'.date('d/m/Y H:i:s',strtotime($row["dateFiled"])).'</td>
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