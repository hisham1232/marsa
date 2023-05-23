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
                                    <h3 class="text-themecolor m-b-0 m-t-0">File an Official Duty</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Official Duty</li>
                                        <li class="breadcrumb-item">File an Official Duty</li>
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
                                                <div class="col-md-4"> 
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
                                            </div><!--end row-->

                                        </div><!--end card-header-->

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <?php
                                                                if(isset($_POST['submitApplication'])) {
                                                                    $submit = new DbaseManipulation;
                                                                    $row = $submit->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM approvalsequence_standardleave as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                                    $sequence_no_will_be = $row['sequence_no'];
                                                                    $current_approver_id = $row['approver_id'];
                                                                    $leaveType = $submit->fieldNameValue("leavetype",$_POST['leaveTypeId'],'name');
                                                                    
                                                                    $requestIdNumber = $_POST['requestNo'];
                                                                    $checkRequest = new DbaseManipulation;
                                                                    $checkRequest->singleReadFullQry("SELECT TOP 1 id, requestNo FROM standardleave WHERE requestNo = '$requestIdNumber' ORDER BY id DESC");
                                                                    if($checkRequest->totalCount != 0) {
                                                                        $req = new DbaseManipulation;
                                                                        $newReqNo = $req->requestNo("OFD-","standardleave");    
                                                                    } else {
                                                                        $newReqNo = $_POST['requestNo'];    
                                                                    }

                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/leaves/standard/";
                                                                        $target_file = $newReqNo;
                                                                        $uploadOk = 1;
                                                                        $errorNo = 0;
                                                                        $acceptable = array('image/jpeg', 'image/jpg', 'image/png', "application/pdf");
                                                                          
                                                                        if ($_FILES["fileToUpload"]["size"] > 2097152) {
                                                                            $uploadOk = 0;
                                                                            $errorNo = 1;
                                                                            $errMsg = "File size is too big. Only 2MB is the maximum allowed file size.";
                                                                        }
                                                                        if (!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) { //Allow certain file formats
                                                                            $uploadOk = 0;
                                                                            $errorNo = 2;
                                                                            $errMsg = "Sorry, only JPG, JPEG, PNG, PDF file extensions are allowed to upload. File type not accepted.";
                                                                        }
                                                                        if ($uploadOk == 0) {
                                                                            if($errorNo == 1) {
                                                                                ?>
                                                                                <br/>
                                                                                <div class="alert alert-danger">
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p><?php echo $errMsg; ?></p>
                                                                                </div>
                                                                                <?php        
                                                                            } else if ($errorNo == 2) {
                                                                                ?>
                                                                                <br/>
                                                                                <div class="alert alert-danger">
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p><?php echo $errMsg; ?></p>
                                                                                </div>
                                                                                <?php
                                                                            }   
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $new_file_name = $newReqNo.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/leaves/standard/".$new_file_name)) {
                                                                                $attachment = "attachments/leaves/standard/".$new_file_name;
                                                                            } else {
                                                                                ?>
                                                                                <br/>
                                                                                <div class="alert alert-danger">
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p>File size is too big. Only 2MB is the maximum allowed file size.</p>
                                                                                </div>       
                                                                                <?php 
                                                                                die();               
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $attachment = "";
                                                                    }

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
                                                                        'attachment'=>$attachment,
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
                                                                                $subject = 'NCT-HRMD OFFICIAL DUTY FILED BY '.strtoupper($logged_name);
                                                                                $message = '<html><body>';
                                                                                $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                                                $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Pending</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$history_status."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$_POST['requestNo']."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',time())."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$_POST['noOfDays']."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                                $message .= "</table>";
                                                                                $message .= "<hr/>";
                                                                                $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY HISTORIES</h3>";
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
                                                                                        'moduleName'=>'Official Duty Application',
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
                                                                                        'moduleName'=>'Official Duty Application',
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
                                                                    <h3 class="card-title">Official Duty Application Form</h3>
                                                                    <h6 class="card-subtitle">إستمارة طلب إجازة مهمة عمل رسمي</h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <ul class="list-inline">
                                                                        <li class="none">
                                                                            <?php 
                                                                                $request = new DbaseManipulation;
                                                                                $requestNo = $request->requestNo("OFD-","standardleave");
                                                                            ?>
                                                                            <h3 class="text-muted text-success">New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal p-t-5" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <strong><i class="fa fa-info-circle"></i> Official Duty Leave Rules and Conditions in Filing</strong>
                                                                                    <ol>
                                                                                        <li>It is granted if the employee is attending a workshop or training outside the college with the approval of the college dean or vice dean.</li>
                                                                                    </ol>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">Date Requested <br> تاريخ الطلب</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="dateRequested" class="form-control" readonly value="<?php echo date("d/m/Y"); ?>">
                                                                                <input type="hidden" id="today" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                                                                <input type="hidden" id="sponsorId" class="form-control" value="<?php echo $info['sponsor_id']; ?>">
                                                                                <input type="hidden" name="leaveTypeId" id="leaveTypeId" class="form-control" value="13"> <!-- 13 here means official Duty -->
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
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Duty Date</label>
                                                                    <div class="col-sm-9">
                                                                        <div class='input-group mb-3'>
                                                                            <input type='text' class="form-control daterange" required data-validation-required-message="Please Select Duty Date" />
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
                                                                                <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf" class="form-control"> 
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
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Reasons for Filing <br>سبب الإجازة</label>
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
                                                                    <h3 class="card-title">Official Duty Approval Sequence Will Be</h3>
                                                                    <h6 class="card-subtitle">تسلسل إعتماد طلب إجازة مهمة عمل رسمي</h6>
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
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Official Duty filing has been submitted successfully!</h5>
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