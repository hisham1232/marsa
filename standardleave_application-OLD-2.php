<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed =  true;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
?>
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Apply Standard Leave</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Standard Leave</li>
                                        <li class="breadcrumb-item">Apply Standard Leave</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card"><!-- card-outline-success-->
                                        <div class="card-header" style="background-color: #DCE7E6;">
                                            <div class="row">
                                                <div class="col-md-4"> 
                                                    <div class="d-flex flex-row">
                                                        <div class="mr-auto">
                                                            <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$staffId.'.jpg'; ?>" style=" width:100px; height:100px; border-radius: 50%" alt="Staff ID"><br>
                                                        </div>
                                                        <div style="margin-left:20px">
                                                            <?php
                                                                $bal = new DbaseManipulation;
                                                                $basic_info = new DBaseManipulation;
                                                                $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
                                                            ?>
                                                            <h5 class="text-primary"><?php echo trim($info['staffName']); ?></h5>
                                                            <h5><i class="fas fa-address-card text-muted"></i> <?php echo $info['staffId']; ?></h5>
                                                            <input type="hidden" class="staff_id" value="<?php echo $info['staffId']; ?>" />
                                                            <h5><?php echo $info['section']; ?></h5>
                                                            <h5><?php echo $info['department']; ?></h5> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"> 
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <h5><?php echo $info['jobtitle']; ?></h5>
                                                            <h5><?php echo $info['sponsor']; ?></h5>
                                                            <?php
                                                                $contact_details = new DbaseManipulation;
                                                                $email = $contact_details->getContactInfo(2,$staffId,'data');
                                                                $gsm = $contact_details->getContactInfo(1,$staffId,'data');
                                                            ?>
                                                            <h5><?php echo $email; ?></h5>
                                                            <h5><i class="fas fa-address-card text-muted"></i> <?php echo $gsm; ?></h5>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6"> 
                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Internal Leave Balance</h5>
                                                        </div>
                                                        <?php $intLeaveBal = $bal->getInternalLeaveBalance($staffId,'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $intLeaveBal; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>رصيد الإجازة الداخلية </h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Pending (Internal)</h5>
                                                        </div>
                                                        <?php $intLeavePen = $bal->getInternalLeavePending($staffId,'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $intLeavePen; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>رصيد الإجازة الداخلية المعلق</h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Emergency Leave Balance</h5>
                                                        </div>
                                                        <?php $emerLeaveBal = $bal->getEmergencyLeaveBalance($staffId,'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $emerLeaveBal; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5> رصيد الإجازة الطارئة  </h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Pending (Emergency)</h5>
                                                        </div>
                                                        <?php $emLeavePen = $bal->getEmergencyLeavePending($staffId,'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $emLeavePen; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>رصيد الإجازة الطارئة المعلق</h5>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><!--end row-->

                                        </div><!--end card-header-->

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <script>
                                                                if ( window.history.replaceState ) {
                                                                    window.history.replaceState( null, null, window.location.href );
                                                                }
                                                            </script>
                                                            <?php
                                                                if(isset($_POST['submitApplication'])) {
                                                                    $submit = new DbaseManipulation;
                                                                    $row = $submit->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM approvalsequence_standardleave as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                                    $sequence_no_will_be = $row['sequence_no'];
                                                                    $current_approver_id = $row['approver_id'];
                                                                    $leaveType = $submit->fieldNameValue("leavetype",$_POST['leaveTypeId'],'name');
                                                                    $fields = [
                                                                        'requestNo'=>$_POST['requestNo'],
                                                                        'staff_id'=>$staffId,
                                                                        'leavetype_id'=>$_POST['leaveTypeId'],
                                                                        'currentStatus'=>"Pending",
                                                                        'dateFiled'=>date('Y-m-d H:i:s',time()),
                                                                        'startDate'=>$_POST['startDate'],
                                                                        'endDate'=>$_POST['endDate'],
                                                                        'total'=>$_POST['noOfDays'],
                                                                        'reason'=>$_POST['reason'],
                                                                        'current_sequence_no'=>$sequence_no_will_be,
                                                                        'position_id'=>$myPositionId,
                                                                        'current_approver_id'=>$current_approver_id
                                                                    ];
                                                                    if($submit->insert("standardleave",$fields)){
                                                                        $leavetype_id = $_POST['leaveTypeId'];
                                                                        $negativeTotal = "-".$_POST['noOfDays'];
                                                                        if($leavetype_id == 2) { //Emergency Leave MUST be inserted in emergencyleavebalancedetails table
                                                                            $fields2 = [
                                                                                'emergencyleavebalance_id'=>$_POST['requestNo'],
                                                                                'staffId'=>$staffId,
                                                                                'startDate'=>$_POST['startDate'],
                                                                                'endDate'=>$_POST['endDate'],
                                                                                'total'=>$negativeTotal,
                                                                                'status'=>"Pending",
                                                                                'notes'=>$_POST['reason'],
                                                                                'addType'=>3,
                                                                                'createdBy'=>$staffId
                                                                            ];
                                                                            $table_name = "emergencyleavebalancedetails";
                                                                        } else {
                                                                            if($leavetype_id == 1) { //If internal leave, total should be negative days.
                                                                                $towtal = $negativeTotal;
                                                                            } else { //total should be Zero (0).
                                                                                $towtal = 0;
                                                                            }
                                                                            $fields2 = [
                                                                                'internalleavebalance_id'=>$_POST['requestNo'],
                                                                                'leavetype_id'=>$_POST['leaveTypeId'],
                                                                                'staffId'=>$staffId,
                                                                                'startDate'=>$_POST['startDate'],
                                                                                'endDate'=>$_POST['endDate'],
                                                                                'total'=>$towtal,
                                                                                'status'=>"Pending",
                                                                                'notes'=>$_POST['reason'],
                                                                                'addType'=>2,
                                                                                'createdBy'=>$staffId
                                                                            ];
                                                                            $table_name = "internalleavebalancedetails";
                                                                        }
                                                                        
                                                                        if($submit->insert($table_name,$fields2)){
                                                                            $history_status = 'For Approval - '.$row['title'];
                                                                            $last_id = $submit->singleReadFullQry("SELECT TOP 1 id FROM standardleave ORDER BY id DESC");
                                                                            $standardleave_id = $last_id['id'];
                                                                            $fields3 = [
                                                                                'standardleave_id'=>$standardleave_id,
                                                                                'requestNo'=>$_POST['requestNo'],
                                                                                'staff_id'=>$staffId,
                                                                                'status'=>$history_status,
                                                                                'notes'=>$_POST['reason'],
                                                                                'ipAddress'=>$submit->getUserIP()
                                                                            ];
                                                                            if($submit->insert("standardleave_history",$fields3)){
                                                                                $getIdInfo = new DbaseManipulation;
                                                                                $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $standardleave_id ORDER BY id DESC");
                                                                                $leaveDuration = 'From '.date('d/m/Y',strtotime($_POST['startDate'])).' to '.date('d/m/Y',strtotime($_POST['endDate']));
                                                                                $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                                                                $from_name = 'hrms@nct.edu.om';
                                                                                $from = 'HRMS - 3.0';
                                                                                $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') FILED BY '.strtoupper($logged_name);
                                                                                $message = '<html><body>';
                                                                                $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                                $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Pending</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$history_status."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$_POST['requestNo']."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',time())."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$_POST['noOfDays']."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                                $message .= "</table>";
                                                                                $message .= "<hr/>";
                                                                                $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
                                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                                $message .= "<tr style='background:#F8E0E0'>";
                                                                                    $message .= "<th><strong>STAFF NAME</strong></th>";
                                                                                    $message .= "<th><strong>NOTES/COMMENTS</strong></th>";
                                                                                    $message .= "<th><strong>STATUS</strong></th>";
                                                                                    $message .= "<th><strong>DATE/TIME</strong></th>";
                                                                                $message .= "</tr>";
                                                                                $ctr = 1; $stripeColor = "";	
                                                                                foreach($history as $row){
                                                                                    if($ctr % 2 == 0) {
                                                                                        $stripeColor = '#FBEFEF';
                                                                                    } else {
                                                                                        $stripeColor = '#FBF2EF';
                                                                                    }
                                                                                    $fullStaffNameEmail = $getIdInfo->getStaffName($row['staff_id'],'firstName','secondName','thirdName','lastName');
                                                                                    $dateNotesEmail = date('d/m/Y H:i:s',strtotime($row['modified']));
                                                                                    $notesEmail = $row['notes'];
                                                                                    $statusEmail = $row['status'];
                                                                                    $message .= "
                                                                                        <tr style='background:$stripeColor'>
                                                                                            <td style='width:200px'>".$fullStaffNameEmail."</td>
                                                                                            <td style='width:200px'>".$notesEmail."</td>
                                                                                            <td style='width:200px'>".$statusEmail."</td>
                                                                                            <td style='width:200px'>".$dateNotesEmail."</td>
                                                                                        </tr>
                                                                                    ";
                                                                                    $ctr++;
                                                                                }
                                                                                $message .= "</table>";
                                                                                $message .= "<br/>";
                                                                                $message .= "</body></html>";
                                                                                $to = array();
                                                                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $current_approver_id AND isCurrent = 1 AND status_id = 1");
                                                                                $nextApproversStaffId = $nextApprover['staff_id'];
                                                                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                                                                array_push($to,$logged_in_email,$nextApproverEmailAdd);
                                                                                $emailParticipants = new sendMail;
                                                                                $a=1;
                                                                                if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
                                                                                //if($a=1){    
                                                                                    //Save Email Information in the system_emails table...
                                                                                    $from_name = $from_name;
                                                                                    $from = $from;
                                                                                    $subject = $subject;
                                                                                    $message = $message;
                                                                                    $transactionDate = date('Y-m-d H:i:s',time());
                                                                                    $to = $to;
                                                                                    $recipients = implode(', ', $to);
                                                                                    $emailFields = [
                                                                                        'requestNo'=>$_POST['requestNo'],
                                                                                        'moduleName'=>'Standard Leave Application',
                                                                                        'sentStatus'=>'Sent',
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
                                                                                    ?>
                                                                                        <script>
                                                                                            $(document).ready(function() {
                                                                                                $('#myModal').modal('show');
                                                                                            });
                                                                                        </script>
                                                                                    <?php
                                                                                } else {
                                                                                    //Save Email Information in the system_emails table...
                                                                                    $from_name = $from_name;
                                                                                    $from = $from;
                                                                                    $subject = $subject;
                                                                                    $message = $message;
                                                                                    $transactionDate = date('Y-m-d H:i:s',time());
                                                                                    $to = $to;
                                                                                    $recipients = implode(', ', $to);
                                                                                    $emailFields = [
                                                                                        'requestNo'=>$_POST['requestNo'],
                                                                                        'moduleName'=>'Standard Leave Application',
                                                                                        'sentStatus'=>'Failed',
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
                                                                                    ?>
                                                                                    <!-- <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                        <p>Leave application has been submitted successfully!</p>
                                                                                    </div> -->
                                                                                        <script>
                                                                                            $(document).ready(function() {
                                                                                                $('#myModal').modal('show');
                                                                                            });
                                                                                        </script>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }                                                                    
                                                                }
                                                            ?>
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Standard Leave Application Form</h3>
                                                                    <h6 class="card-subtitle">إستمارة طلب إجازة</h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <ul class="list-inline">
                                                                        <li class="none">
                                                                            <?php 
                                                                                $request = new DbaseManipulation;
                                                                                $requestNo = $request->requestNo("STL-","standardleave");
                                                                            ?>
                                                                            <h3 class="text-muted text-success">New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-5" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">Date Requested <br> تاريخ الطلب</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="dateRequested" class="form-control" readonly value="<?php echo date("d/m/Y"); ?>">
                                                                                <input type="hidden" id="today" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                                                                <input type="hidden" id="sponsorId" class="form-control" value="<?php echo $info['sponsor_id']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Kind of Leave <br>نوع الإجازة
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" id="intLeaveBal" class="form-control" value="<?php echo $intLeaveBal; ?>">
                                                                                <input type="hidden" id="emerLeaveBal" class="form-control" value="<?php echo $emerLeaveBal; ?>">
                                                                                <select name="leaveTypeId" id="leaveTypeId" required class="form-control leaveTypeId" data-validation-required-message="Please Select Leave Type">
                                                                                    <option value="">[Select Kind of Leave]</option>
                                                                                    <?php 
                                                                                        $request = new DbaseManipulation;
                                                                                        //NOTE: Usage of NOT IN in the SQL comes from the validations from the HRMS Rules in Filing Leave.docx send by the HR Department...Will try to improve it so that it can be dynamic...
                                                                                        if($info['sponsor_id'] == 1) { //Ministry of Manpower
                                                                                            if($info['gender'] == 'Female') {
                                                                                                $rows = $request->readData("SELECT id, name FROM leavetype WHERE active = 1 AND forMinistry = 1 AND id NOT IN (13,17) ORDER BY id");
                                                                                            } else if($info['gender'] == 'Male') {
                                                                                                $rows = $request->readData("SELECT id, name FROM leavetype WHERE active = 1 AND forMinistry = 1 AND id NOT IN (4,6,13,14,17) ORDER BY id");
                                                                                            }    
                                                                                        } else { //Company
                                                                                            if($info['gender'] == 'Female') {
                                                                                                $rows = $request->readData("SELECT id, name FROM leavetype WHERE active = 1 AND forCompany = 1 AND id NOT IN (11,12,13,14,15,16,17) ORDER BY id");
                                                                                            } else if($info['gender'] == 'Male') {
                                                                                                $rows = $request->readData("SELECT id, name FROM leavetype WHERE active = 1 AND forCompany = 1 AND id NOT IN (4,6,14,11,12,13,14,15,16,17) ORDER BY id");
                                                                                            }    
                                                                                        }
                                                                                        
                                                                                        foreach ($rows as $row) {
                                                                                    ?>
                                                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                    <?php            
                                                                                        }    
                                                                                    ?>
                                                                                </select>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-credit-card"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">&nbsp;</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <strong><i class="fa fa-info-circle"></i> Reminder</strong>
                                                                                <ol>
                                                                                    <li>Leave application doesn't guarantee that it will be approve automatically.</li>
                                                                                    <li>Be sure to talk/inform your direct superior regarding your task while you are on leave.</li>
                                                                                </ol>
                                                                            </div>
                                                                        </div>
                                                                    </div>    
                                                                </div>
                                                                        <div class="form-group row internalRules" style="display: none">
                                                                            <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                            <div class="col-sm-9">
                                                                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <strong><i class="fa fa-info-circle"></i> Internal Leave Rules and Conditions in Filing</strong>
                                                                                    <ol>
                                                                                        <li>The staff has to have credit</li>
                                                                                        <li>The staff should apply before leaving</li>
                                                                                        <li>It should be approved by the direct head</li>
                                                                                    </ol>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row eiddaRules" style="display: none">
                                                                            <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                            <div class="col-sm-9">
                                                                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <strong><i class="fa fa-info-circle"></i> Eidda Leave Rules and Conditions in Filing</strong>
                                                                                    <ol>
                                                                                        <li>A female employee whose husband died is entitled to a four-month and 10-day leave from the date of death based on the death certificate. The employee must bring the death certificate in addition to a copy of the marriage document</li>
                                                                                    </ol>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row obRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Official Mission Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>It is granted if the employee is attending a workshop or training outside the college with the approval of the college dean or vice dean.</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                <?php
                                                                    if($logged_in_sponsor_id == 1) { //Under Ministry
                                                                        ?>
                                                                            <div class="form-group row emergencyRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Emergency Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>There should be an emergency reason considered by the head</li>
                                                                                            <li>The staff has the right to apply for 5 days, successive or separate during the financial year (31/01 - 01/12)</li>
                                                                                            <li>Emergency leave MUST ONLY APPLY after the staff resume/join his work on the college.</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row unpaidRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Unpaid Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>A non-contracted employee shall be entitled to special leave without pay for a period of one-year renewable for a maximum of (4) years during the total period of service. For Omani employees they should pay the contributions due to the Civil Service Retirement Fund. For non-Omani employees, this period is deducted from end of service benefits</li>
                                                                                            <li>The approval of the direct head</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row maternityRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Maternity Leave (Giving Birth) Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>Female employee shall be granted a special paid leave for 50 days to cover the period before and after birth</li>
                                                                                            <li>This leave is entitled maximum 5 times during the period of employment</li>
                                                                                            <li>The leave prior to birth should not exceed 10 days according to the doctor's report</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row hajjRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Hajj Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>20 days with full salary (granted once during his employment)</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row sickRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Sick Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>Submit a medical certificate approved by the Ministry of Health</li>
                                                                                            <li>Sick leave with full salary for a period not exceeding 7 days at a time</li>
                                                                                            <li>Six months full salary and allowances</li>
                                                                                            <li>Six months by three quarters of the salary and full allowances</li>
                                                                                            <li>For sick leave resulting from work injuries, the employee shall be awarded a full salary without being bound by a certain period</li>
                                                                                            <li>Sick leave shall be valid from outside the Sultanate provided if it is accredited by the official medical authority in the country where the employee was treated and certified by the Sultanate's embassy and accredited by the Ministry of Health in the Sultanate</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row accompanyingRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Accompanying A Patient Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>The employee may be granted leave to accompany a patient for treatment inside or outside the Sultanate for a period not exceeding 15 days. If the treatment exceeds this period, it may be extended for another thirty days upon the approval of the Minister</li>
                                                                                            <li>If it exceeds 30 days, it will be counted as an internal leave</li>
                                                                                            <li>Accompanying sick leave is not granted in case of non-lodging and may be provided as an emergency leave or can be taken from the internal leave balance</li>
                                                                                            <li>If the accompanying is within the Sultanate, it requires that the employee is a spouse of the patient or close to him from first or second degree relatives which has to be proved by an official document and excluding from the accompanying people with work injury</li>
                                                                                            <li>Accompanying should not exceed 3 times a year</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row examsRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Exams Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>A full salary for sitting for  exams not exceeding the period specified in the examination schedule issued by the school or the competent university</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row studyRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Study Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>Full salary for the period specified in the decision</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row maternity14Rules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Maternity Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>The employee is entitled to a full year of unpaid maternity leave</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row spouseStudyRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Accompanying Spouse for Study Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>The employee shall be granted leave to accompany the spouse who is on a mission, scholarship, training course, assignment, deputation or transfer outside the Sultanate, provided that the period shall not be less than (6) months. The employee should not be employed under contracting</li>
                                                                                            <li>To apply for it one month prior to the date of leave (Leave without pay)</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row countryRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Leave for Representing the Country Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>The employee who is selected to represent the Sultanate in various official activities and celebrations inside and outside the Sultanate shall be granted a full salary leave and shall be required to bring a letter from the institution he/she is</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                            <div class="form-group row emergencyRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Emergency Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>There should be an emergency reason considered by the head</li>
                                                                                            <li>The staff has the right to apply for 6 days, 2 days per each leave during the academic year</li>
                                                                                            <li>The staff should apply for the emergency leave once they resume work</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row unpaidRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Unpaid Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>The approval of the direct head </li>
                                                                                            <li>No more than one month and if it is extended, the employee would be terminated</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row maternityRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Maternity Leave (Giving Birth) Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>Female employee shall be granted a special paid leave for 50 days to cover the period before and after birth</li>
                                                                                            <li>This leave is entitled maximum 3 times during the period of employment</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row hajjRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Hajj Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>15 days with full salary (granted once during staff employment)</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row sickRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Sick Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>Submit a medical certificate approved by the Ministry of Health</li>
                                                                                            <li>Should not exceed 3 days per month and if it is the case, it would be considered as a long leave (the employee has the right in 1 long leave per year)</li>
                                                                                            <li>If the sick leave exceeds 14 days, the excess days shall be paid by half the salary and if more than 30 consecutive days, the employee may be terminated and the company shall find the alternative</li>
                                                                                            <li>Sick leave shall be valid from outside the Sultanate provided if it is accredited by the official medical authority in the country where the employee was treated and certified by the Sultanate's embassy and accredited by the Ministry of Health in the Sultanate</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row marriageRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Marriage Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>3 days, once during the whole period of service</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row deathRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Death Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>Three days in case of the demise of the father, mother, sister, brother, son, daughter, grandmother, grandfather, 2 days in case of the demise of uncle, aunt</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row examsRules" style="display: none">
                                                                                <label  class="col-sm-3 control-label">&nbsp;</label>           
                                                                                <div class="col-sm-9">
                                                                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <strong><i class="fa fa-info-circle"></i> Exams Leave Rules and Conditions in Filing</strong>
                                                                                        <ol>
                                                                                            <li>15 days per year for exams (only Omanis)</li>
                                                                                        </ol>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Leave Date<br>تاريخ الإجازة</label>
                                                                    <div class="col-sm-9">
                                                                        <div class='input-group mb-3'>
                                                                            <input type='text' class="form-control daterange" required data-validation-required-message="Please Select Leave Date" />
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text">
                                                                                    <span class="far fa-calendar-alt"></span>
                                                                                </span>
                                                                            </div>
                                                                            <input type="hidden" name="requestNo" value="<?php echo $requestNo; ?>" class="form-control" />
                                                                            <input type="hidden" name="startDate" class="form-control startDate" />
                                                                            <input type="hidden" name="endDate" class="form-control endDate" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Number of Days <br> عدد الأيام</label>           
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="noOfDays" value="" class="form-control noOfDays" required data-validation-required-message="Number of days is required" readonly /> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-hashtag"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">Attachment <br>المرفقات</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="file" name="attachment" accept=".jpg, .jpeg, .png, .pdf" class="form-control"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-file-pdf"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Reasons for Leave <br>سبب الإجازة</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <textarea name="reason" class="form-control" rows="2" required data-validation-required-message="Reasons for Leave is required" minlength="10"></textarea>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-comment"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-3 col-sm-9">
                                                                        <button type="submit" name="submitApplication" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->

                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Leave Approval Sequence Will Be</h3>
                                                                    <h6 class="card-subtitle">تسلسل إعتماد طلب الإجازة</h6>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                $rows = $helper->readData("SELECT sa.*, p.title FROM approvalsequence_standardleave as sa 
                                                                LEFT OUTER JOIN staff_position as p ON p.id = sa.approver_id
                                                                WHERE sa.position_id = $myPositionId AND sa.active = 1
                                                                ORDER BY sa.sequence_no");
                                                                if($helper->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                                        ?>
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-info ribbon-vertical-l"><?php echo $row['sequence_no']; ?></div>
                                                                            <h3 class="ribbon-content"><?php echo $row['title']; ?> Approval</h3>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>        
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script>
                    $(document).ready(function($) {
                        $("#leaveTypeId").focus();
                        $(".daterange").prop("disabled", true);
                        $(".leaveTypeId").change(function() {
                            if($(this).val() > 0) {
                                $(".daterange").prop("disabled", false);
                            } else {
                                $(".daterange").prop("disabled", true);
                            }
                            var leavetypeid = $(this).val();
                            if(leavetypeid == 1) {
                                $('.internalRules').show();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 2) {
                                $('.internalRules').hide();
                                $('.emergencyRules').show();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 3) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').show();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 4) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').show();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 5) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').show();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 6) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').show();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 7) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').show();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 8) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').show();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 9) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').show();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 10) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').show();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 11) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').show();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 12) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').show();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 13) {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').show();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 14) { 
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').show();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 15) { 
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').show();
                                $('.countryRules').hide();
                            } else if (leavetypeid == 16) { 
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').show();
                            } else {
                                $('.internalRules').hide();
                                $('.emergencyRules').hide();
                                $('.unpaidRules').hide();
                                $('.maternityRules').hide();
                                $('.hajjRules').hide();
                                $('.eiddaRules').hide();
                                $('.sickRules').hide();
                                $('.accompanyingRules').hide();
                                $('.marriageRules').hide();
                                $('.deathRules').hide();
                                $('.examsRules').hide();
                                $('.studyRules').hide();
                                $('.obRules').hide();
                                $('.maternity14Rules').hide();
                                $('.spouseStudyRules').hide();
                                $('.countryRules').hide();
                            }
                        });
                    });
                </script>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Leave application has been submitted successfully!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>  
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>