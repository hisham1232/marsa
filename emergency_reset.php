<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
?>
            <body class="fix-header fix-sidebar card-no-border">
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Reset Emergency Balance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Emergency Balance</a></li>
                                        <li class="breadcrumb-item">Reset Emergency Balance </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            
                            <!------------------------------------------------->

                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card" style="border-color: #eee;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-5 col-xs-18">
                                                    <div class="card">
                                                        <div class="card-header bg-light-yellow">
                                                            <div class="d-flex flex-wrap bg-light-yellow">
                                                                <div>
                                                                    <h3 class="card-title">Reset Emergency Balance Form</h3>
                                                                    <h6 class="card-subtitle">إستمارة إعادة تعيين رصيد الإجازة الطارئة</h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <ul class="list-inline">
                                                                        <li class="none">
                                                                            <?php 
                                                                                $request = new DbaseManipulation;
                                                                                $requestNo = $request->requestNo("ELR-","emergencyleavereset");
                                                                            ?>
                                                                            <h4 class="text-muted text-success">New Reset ID <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h4>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php
                                                                if(isset($_POST['submitReset'])) {
                                                                    $save = new DbaseManipulation;
                                                                    $allStaff = new DbaseManipulation;
                                                                    $insert = new DbaseManipulation;
                                                                    $getContact = new DbaseManipulation;
                                                                    $sponsorGroup = $_POST['sponsorGroup'];
                                                                    if($sponsorGroup == 1) { //All Ministry Staff
                                                                        //Resetting all emergency balance to zero first...
                                                                        $reset = new DbaseManipulation;
                                                                        $bal = new DbaseManipulation;
                                                                        $rows = $reset->readData("SELECT s.staffId FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.sponsor_id = 1 AND isCurrent = 1");
                                                                        $request = new DbaseManipulation;
                                                                        $requestNo = $request->requestNo("SYS-","emergencyleavereset");
                                                                        $emergencyleavebalance_id = $requestNo;
                                                                        $startDate = date('Y-m-d');
                                                                        $endDate = date('Y-m-d');
                                                                        $notes = "System Generated. Resetting emergency leave balance to 0 (zero).";
                                                                        $resetter = new DbaseManipulation;
                                                                        foreach($rows as $row){
                                                                            $balance = $bal->getEmergencyLeaveBalance($row['staffId'],'balance');
                                                                            $total = "-".$balance;
                                                                            $staff_id = $row['staffId'];
                                                                            if($balance > 0) {
                                                                                $resetFields = [
                                                                                    'emergencyleavebalance_id'=>$emergencyleavebalance_id,
                                                                                    'staffId'=>$staff_id,
                                                                                    'startDate'=>$startDate,
                                                                                    'endDate'=>$endDate,
                                                                                    'total'=>$total,
                                                                                    'status'=>'Reset',
                                                                                    'notes'=>$notes,
                                                                                    'addType'=>3,
                                                                                    'createdBy'=>$staffId
                                                                                ];
                                                                                $resetter->insert("emergencyleavebalancedetails",$resetFields);
                                                                            }
                                                                        } //Done resetting   
                                                                        $fields = [
                                                                            'requestNo'=>$_POST['request_no'],
                                                                            'sponsorType'=>'Ministry',
                                                                            'dateFiled'=>date('Y-m-d H:i:s'),
                                                                            'createdBy'=>$staffId
                                                                        ];
                                                                        if($save->insert("emergencyleavereset",$fields)){ //Saving emergency reset
                                                                            $rows = $allStaff->readData("SELECT s.staffId FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.sponsor_id = 1 AND isCurrent = 1");
                                                                            $startDate = date('Y-m-d');
                                                                            $endDate = date('Y-m-d');
                                                                            $to = array();
                                                                            foreach($rows as $row){
                                                                                $staff_id = $row['staffId'];
                                                                                $fieldsInsert = [
                                                                                    'emergencyleavebalance_id'=>$_POST['request_no'],
                                                                                    'staffId'=>$staff_id,
                                                                                    'startDate'=>$startDate,
                                                                                    'endDate'=>$endDate,
                                                                                    'total'=>5,
                                                                                    'status'=>'Saved',
                                                                                    'notes'=>"Emergency leave balance reset for Ministry Staff every first day of each calendar year.",
                                                                                    'createdBy'=>$staffId
                                                                                ];
                                                                                if($insert->insert("emergencyleavebalancedetails",$fieldsInsert)) //Saving emergency leave balance to each staff
                                                                                    array_push($to,$getContact->getContactInfo(2,$staff_id,'data'));
                                                                            }
                                                                            ?>
                                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                <p>Emergency leave balance has been added successfully. Leaves has been credited to all staff whose under MINISTRY sponsorship.</p>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    } else if ($sponsorGroup == 2) { //All Company Staff
                                                                        //Resetting all emergency balance to zero first...
                                                                        $reset = new DbaseManipulation;
                                                                        $bal = new DbaseManipulation;
                                                                        $rows = $reset->readData("SELECT s.staffId FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.sponsor_id != 1 AND isCurrent = 1");
                                                                        $request = new DbaseManipulation;
                                                                        $requestNo = $request->requestNo("SYS-","emergencyleavereset");
                                                                        $emergencyleavebalance_id = $requestNo;
                                                                        $startDate = date('Y-m-d');
                                                                        $endDate = date('Y-m-d');
                                                                        $notes = "System Generated. Resetting emergency leave balance to 0 (zero).";
                                                                        $resetter = new DbaseManipulation;
                                                                        foreach($rows as $row){
                                                                            $balance = $bal->getEmergencyLeaveBalance($row['staffId'],'balance');
                                                                            $total = "-".$balance;
                                                                            $staff_id = $row['staffId'];
                                                                            if($balance > 0) {
                                                                                $resetFields = [
                                                                                    'emergencyleavebalance_id'=>$emergencyleavebalance_id,
                                                                                    'staffId'=>$staff_id,
                                                                                    'startDate'=>$startDate,
                                                                                    'endDate'=>$endDate,
                                                                                    'total'=>$total,
                                                                                    'status'=>'Reset',
                                                                                    'notes'=>$notes,
                                                                                    'addType'=>3,
                                                                                    'createdBy'=>$staffId
                                                                                ];
                                                                                $resetter->insert("emergencyleavebalancedetails",$resetFields);
                                                                            }
                                                                        } //Done resetting
                                                                        $fields = [
                                                                            'requestNo'=>$_POST['request_no'],
                                                                            'sponsorType'=>'Company',
                                                                            'dateFiled'=>date('Y-m-d H:i:s'),
                                                                            'createdBy'=>$staffId
                                                                        ];
                                                                        if($save->insert("emergencyleavereset",$fields)){ //Saving emergency reset
                                                                            $rows = $allStaff->readData("SELECT s.staffId FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.sponsor_id != 1 AND isCurrent = 1");
                                                                            $startDate = date('Y-m-d');
                                                                            $endDate = date('Y-m-d');
                                                                            $to = array();
                                                                            foreach($rows as $row){
                                                                                $staff_id = $row['staffId'];
                                                                                $fieldsInsert = [
                                                                                    'emergencyleavebalance_id'=>$_POST['request_no'],
                                                                                    'staffId'=>$staff_id,
                                                                                    'startDate'=>$startDate,
                                                                                    'endDate'=>$endDate,
                                                                                    'total'=>6,
                                                                                    'status'=>'Saved',
                                                                                    'notes'=>"Emergency leave balance reset for Company Staff every first day of each academic year.",
                                                                                    'createdBy'=>$staffId
                                                                                ];
                                                                                if($insert->insert("emergencyleavebalancedetails",$fieldsInsert)) //Saving emergency leave balance to each staff
                                                                                    array_push($to,$getContact->getContactInfo(2,$staff_id,'data'));
                                                                            }
                                                                            ?>
                                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                <p>Emergency leave balance has been added successfully. Leaves has been credited to all staff whose under COMPANY sponsorship.</p>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    //Save Email Information in the system_emails table...    
                                                                    $from_name = 'hrms@nct.edu.om';
                                                                    $from = 'HRMS - 3.0';
                                                                    $subject = 'NCT-HRMD EMERGENCY LEAVE BALANCE CREDITED';
                                                                    $d = '-';
                                                                    $message = '<html><body>';
                                                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                    $message .= "<h3>NCT-HRMS 3.0</h3>";
                                                                    $message .= '<p>An emergency leave balance has been added and credited into your HR account. Kindly login to HR System for more details.</p>';
                                                                    $message .= "</body></html>";
                                                                    $transactionDate = date('Y-m-d H:i:s',time());
                                                                    $recipients = implode(', ', $to);
                                                                    $emailFields = [
                                                                        'requestNo'=>$_POST['request_no'],
                                                                        'moduleName'=>'Reset Emergency Balance',
                                                                        'sentStatus'=>'Pending',
                                                                        'recipients'=>$recipients,
                                                                        'fromName'=>$from_name,
                                                                        'comesFrom'=>$from,
                                                                        'subject'=>$subject,
                                                                        'message'=>$message,
                                                                        'createdBy'=>$staffId,
                                                                        'dateEntered'=>$transactionDate,
                                                                        'dateSent'=>$transactionDate
                                                                    ];
                                                                    $saveEmail = new DbaseManipulation;
                                                                    $saveEmail->insert("system_emails",$emailFields);
                                                                }
                                                            ?>
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Sponsor</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select name="sponsorGroup" class="form-control" required data-validation-required-message="Please select sponsor">
                                                                                    <option value="">Select Sponsor Type</option>
                                                                                    <option value="1">Ministry</option>
                                                                                    <option value="2">Company</option>
                                                                                </select>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-briefcase"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">Reset By</label>                  
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" value="<?php echo $logged_name; ?>" class="form-control" readonly>
                                                                                <input type="hidden" name="createdBy" value="<?php echo $staffId; ?>" class="form-control" readonly> 
                                                                                <input type="hidden" name="request_no" value="<?php echo $requestNo; ?>" class="form-control" readonly>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">Reset Date</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                            <input type="text" value="<?php echo date('d/m/Y H:i:s'); ?>" class="form-control" readonly> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-3 col-sm-9">
                                                                        <button type="submit" name="submitReset" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->

                                                <div class="col-lg-7 col-xs-18">
                                                    <div class="card">
                                                        <div class="card-header bg-light-yellow">
                                                            <div class="d-flex flex-wrap bg-light-yellow">
                                                                <div>
                                                                    <h3 class="card-title">Reset Emergency Balance List</h3>
                                                                    <h6 class="card-subtitle">قائمة بعمليات إعادة تعيين رصيد الإجازة الطارئة</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="dynamicTable" class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Reset ID</th>
                                                                            <th>Sponsor</th>
                                                                            <th>Entered By</th>
                                                                            <th>Date Entered</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $get = new DbaseManipulation;
                                                                            $rows = $get->readData("SELECT e.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as createdBy FROM emergencyleavereset AS e LEFT OUTER JOIN staff as s ON s.staffId = e.createdBy ORDER BY id DESC");
                                                                            if($get->totalCount != 0) {
                                                                                $i = 0;
                                                                                foreach($rows as $row){
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo ++$i."."; ?></td>
                                                                                            <td><?php echo $row['requestNo']; ?></td>
                                                                                            <td><?php echo $row['sponsorType']; ?></td>
                                                                                            <td><?php echo $row['createdBy']; ?></td>
                                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($row['created'])); ?></td>
                                                                                        </tr>
                                                                                    <?php
                                                                                    $i++;
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    


                        </div><!--end container fluid-->

                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>  

                        <script>
                    // MAterial Date picker    
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#effectivity_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });

                    $('.daterange').daterangepicker();

                    </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>