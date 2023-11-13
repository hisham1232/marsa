<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if($user_type == 3) {
                $filter = ' AND e.department_id = '.$logged_in_department_id;
            } else if ($user_type == 4) {
                $filter = ' AND e.section_id = '.$logged_in_section_id;
            } else {
                $filter = '';
            }
            $departmentName = $helper->fieldNameValue("department",$logged_in_department_id,'name');
            $sectionName = $helper->fieldNameValue("section",$logged_in_section_id,'name');                     
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0"> Compensatory Leave Request Form</h3>
                                    <!---this is for HOS,HOC,HOD and higher position--->
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Compensatory Leave</li>
                                        <li class="breadcrumb-item">Request Compensatory Leave</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <!------------------------------------------------->
                            <!------------------------------------------------->
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card bg-light-yellow" style="border-color: #eee;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4 col-xs-18">
                                                    <!---start application form div-->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Step 1: Select Staff and Add To List</h3>
                                                                    <h6 class="card-subtitle text-info"><em><i class="fas fa-info-circle"></i> Select Staff you want to include for this Compensatory Leave Request</em></h6>
                                                                </div>
                                                            </div>
                                                            <div class="form-horizontal p-t-20">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Staff</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select class="custom-select select2 staffDropDown" required data-validation-required-message="Please select staff">
                                                                                    <option value="">Select Staff</option>
                                                                                    <?php
                                                                                        $rows = $helper->readData("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id WHERE e.status_id = 1 AND e.isCurrent = 1".$filter." ORDER BY staffName");
                                                                                        foreach ($rows as $row) {
                                                                                            ?>
                                                                                            <option value="<?php echo $row['staffId']; ?>"><?php echo $row['staffName']; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    ?>        
                                                                                </select>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Date</label>
                                                                    <div class="col-sm-9">
                                                                        <div class='input-group mb-3'>
                                                                            <input type='text' class="form-control addDateRange" />
                                                                            <input type="hidden" name="startDate" class="form-control startDate" />
                                                                            <input type="hidden" name="endDate" class="form-control endDate" />
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span># of Days</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="noOfDays" class="form-control noOfDays" readonly />
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                                                </div>                                                                    
                                                                            </div>                                                                
                                                                        </div>                                                            
                                                                    </div>                                                        
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 control-label"><span class="text-danger">*</span>Notes</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <textarea class="form-control notes" rows="2" required data-validation-required-message="Reasons for this Compensatory Leave is required" minlength="20"></textarea>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"> <i class="far fa-comment"></i></span>
                                                                                </div>                                                                    
                                                                            </div>                                                                
                                                                        </div>                                                            
                                                                    </div>                                                        
                                                                </div>                                          
                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-3 col-sm-9">
                                                                        <button class="btn btn-primary waves-effect waves-light draftOvertimeLeave">Add Staff to List <i class="fa fa-arrow-right"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <div class="col-lg-8 col-xs-18">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <?php
                                                                if(isset($_POST['finalizedSubmit'])){
                                                                    $request_no = $_POST['requestNo'];
                                                                    if (!empty($_FILES['fileToUpload']['name'])) {
                                                                        $target_dir = "attachments/leaves/overtime/";
                                                                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                                        $uploadOk = 1;
                                                                        //Not working on MSWord and MSExcel
                                                                        $acceptable = array('application/pdf', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
                                                                        
                                                                        // Check if image file is a actual image or fake image    
                                                                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                                                            if($check !== false) {
                                                                                $uploadOk = 1;
                                                                            } else {
                                                                                $uploadOk = 0;
                                                                            }
                                                                        if ($_FILES["fileToUpload"]["size"] > 2097152) {
                                                                        ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, file size is too large. Files size should be up to 2MB only.</p>
                                                                            </div>    
                                                                        <?php            
                                                                            $uploadOk = 0;
                                                                        }
                                                                        // Allow certain file formats
                                                                        if(!in_array($_FILES['fileToUpload']['type'], $acceptable) && (!empty($_FILES["fileToUpload"]["type"]))) {
                                                                        ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Sorry, only JPG, JPEG, PNG, GIF, PDF files are allowed to upload. File type not accepted.</p>
                                                                            </div>    
                                                                        <?php                
                                                                            $uploadOk = 0;
                                                                        }
                                                                        if ($uploadOk == 0) {
                                                                        ?>
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                <p>Either file type and file size BOTH not acceptable.</p>
                                                                            </div>
                                                                        <?php        
                                                                        } else { //if everything is ok, try to upload file
                                                                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                                            $extension = end($temp);
                                                                            $new_file_name = $request_no.".".$extension;
                                                                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/leaves/overtime/".$new_file_name)) {
                                                                                $new_image = "attachments/leaves/overtime/".$new_file_name;
                                                                                goto hell;                
                                                                            } else {
                                                                        ?>
                                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Upload Failed!</h4>
                                                                                    <p>Sorry, there was an error uploading your attachment, please try again.</p>
                                                                                </div>       
                                                                        <?php                
                                                                            }
                                                                        }
                                                                    } else {
                                                                        hell:
                                                                            $helper->executeSQL("UPDATE internalleaveovertimedetails_draft SET status = 'Pending' WHERE internalleaveovertime_id = '$request_no'");
                                                                            $note = $helper->singleReadFullQry("SELECT TOP 1 notes FROM internalleaveovertimedetails_draft WHERE internalleaveovertime_id = '$request_no'");
                                                                            $insertToInternalLeaveOvertimeFiled = [
                                                                                'requestNo'=>$request_no,
                                                                                'dateFiled'=>date('Y-m-d H:i:s',time()),
                                                                                'notes'=>$note['notes'],
                                                                                'attachment'=>$new_image,
                                                                                'ot_type'=>$_POST['ot_type'],
                                                                                'isFinalized'=>'Y',
                                                                                'createdBy'=>$staffId
                                                                            ];
                                                                            $helper->insert("internalleaveovertimefiled",$insertToInternalLeaveOvertimeFiled);
                                                                            //$helper->displayArr($insertToInternalLeaveOvertimeFiled);
                                                                            $row = $helper->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM internalleaveovertime_approvalsequence as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                                            $sequence_no_will_be = $row['sequence_no'];
                                                                            $current_approver_id = $row['approver_id'];
                                                                            $insertToInternalLeaveOvertime = [
                                                                                'requestNo'=>$request_no,
                                                                                'staff_id'=>$staffId,
                                                                                'currentStatus'=>'Pending',
                                                                                'current_sequence_no'=>$sequence_no_will_be,
                                                                                'current_approver_id'=>$current_approver_id,
                                                                                'position_id'=>$myPositionId
                                                                            ];
                                                                            $helper->insert("internalleaveovertime",$insertToInternalLeaveOvertime);
                                                                            //$helper->displayArr($insertToInternalLeaveOvertime);
                                                                            $history_status = 'For Approval - '.$row['title'];
                                                                            $last_id = $helper->singleReadFullQry("SELECT TOP 1 id FROM internalleaveovertime ORDER BY id DESC");
                                                                            $internalleaveovertime_id = $last_id['id'];
                                                                            $fieldsHistory = [
                                                                                'internalleaveovertime_id'=>$internalleaveovertime_id,
                                                                                'requestNo'=>$request_no,
                                                                                'staff_id'=>$staffId,
                                                                                'status'=>$history_status,
                                                                                'notes'=>$note['notes'],
                                                                                'ipAddress'=>$helper->getUserIP()
                                                                            ];
                                                                            $helper->insert("internalleaveovertime_history",$fieldsHistory);
                                                                            //$helper->displayArr($fieldsHistory);

                                                                            $getIdInfo = new DbaseManipulation;
                                                                            $history = $getIdInfo->readData("SELECT * FROM internalleaveovertime_history WHERE requestNo = '$request_no' ORDER BY id DESC");
                                                                            $startEnd = $getIdInfo->singleReadFullQry("SELECT TOP 1 * FROM internalleaveovertimedetails_draft WHERE internalleaveovertime_id = '$request_no'");
                                                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($startEnd['startDate'])).' to '.date('d/m/Y',strtotime($startEnd['endDate']));
                                                                            $staffRows = $helper->readData("SELECT staffId FROM internalleaveovertimedetails_draft WHERE internalleaveovertime_id = '$request_no' AND status = 'Pending'");
                                                                            $arrStaff = array();
                                                                            $to = array();
                                                                            foreach($staffRows as $staffRow){
                                                                                $names_staff = $getIdInfo->getStaffName($staffRow['staffId'],'firstName','secondName','thirdName','lastName');
                                                                                array_push($arrStaff,$names_staff);
                                                                                $staff_emails = $getIdInfo->getContactInfo(2,$staffRow['staffId'],'data');
                                                                                array_push($to,$staff_emails);
                                                                            }
                                                                            $list_staff_names = implode(', ', $arrStaff);
                                                                            $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                                                            $from_name = 'hrms@nct.edu.om';
                                                                            $from = 'HRMS - 3.0';
                                                                            $subject = 'NCT-HRMD OVERTIME LEAVE FILED BY '.strtoupper($logged_name);
                                                                            $message = '<html><body>';
                                                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                            $message .= "<h3>NCT-HRMS 3.0 OVERTIME LEAVE DETAILS</h3>";
                                                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>CURRENT STATUS:</strong> </td><td>Pending</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>FILED BY:</strong> </td><td>".$logged_name."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>REASON:</strong> </td><td>".$note['notes']."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>NO. OF DAYS:</strong> </td><td>".$startEnd['total']."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAMES:</strong> </td><td>".$list_staff_names."</td></tr>";
                                                                            $message .= "</table>";
                                                                            $message .= "<br/>";
                                                                            $message .= "<h3 style='color:red'><i class='fa fa-exclamation-triangle'></i> Staff whose name appears in this overtime <strong>MUST Login and Logout in the Biometrics</strong> during these dates to avoid technical issues.</h3>";
                                                                            $message .= "<hr/>";
                                                                            $message .= "<h3>NCT-HRMS 3.0 OVERTIME LEAVE HISTORIES</h3>";
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
                                                                            
                                                                            $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $current_approver_id AND isCurrent = 1 AND status_id = 1");
                                                                            $nextApproversStaffId = $nextApprover['staff_id'];
                                                                            $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                                                            array_push($to,$logged_in_email,$nextApproverEmailAdd);
                                                                            $emailParticipants = new sendMail;
                                                                            
                                                                            if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
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
                                                                                    'moduleName'=>'Overtime Application',
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
                                                                                    'moduleName'=>'Overtime Application',
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
                                                                                    <script>
                                                                                        $(document).ready(function() {
                                                                                            $('#myModal').modal('show');
                                                                                        });
                                                                                    </script>    
                                                                                <?php
                                                                            }
                                                                                
                                                                            
                                                                    }                
                                                                }
                                                            ?>
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Step 2 : Submit Request to ADD Compensatory Leave</h3>
                                                                    <h6 class="card-subtitle text-info"><em><i class="fas fa-info-circle"></i> Verify the list of staff and details of overtime and click Finalized button to submit the request.</em></h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <ul class="list-inline">
                                                                        <li class="none">
                                                                            <?php 
                                                                                $request = new DbaseManipulation;
                                                                                $requestNo = $request->requestNo("OTL-","internalleaveovertime");
                                                                            ?>
                                                                            <h3 class="text-muted text-success">New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span>
                                                                            </h3>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal finalized" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Date</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="hidden" name="requestNo" class="form-control" value="<?php echo $requestNo; ?>" />
                                                                                    <input type="text" readonly class="form-control" value="<?php echo date("d/m/Y"); ?>" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Type</label>
                                                                                <div class="col-md-9">
                                                                                    <div class="input-group">
                                                                                        <select name="ot_type" class="form-control" required data-validation-required-message="Please select Request Type">
                                                                                            <option value="Planned" selected>Planned</option>
                                                                                            <option value="Emergency">Emergency</option>
                                                                                        </select>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2"><i class="far fa-envelope"></i></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Requester</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" disabled class="form-control" value="<?php echo $logged_name; ?>">
                                                                                    <input type="hidden" name="createdBy" class="form-control createdBy" value="<?php echo $staffId; ?>" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Attachment</label>
                                                                                <div class="col-md-9">
                                                                                    <div class="input-group">
                                                                                        <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf, .gif" class="form-control">
                                                                                        <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-file-pdf"></i></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    <div class="actionNotification">                    
                                                                    </div>                    
                                                                    <p><em><i class="fa fa-users"></i> List of Staff to be given Compensatory Leave.</em> <span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Staff MUST Login and Logout in the Biometrics during these dates.</span></p>
                                                                    <hr class="m-t-0 m-b-10">
                                                                    <div class="table-responsive">
                                                                        <table class="table" id="draftAddOvertime">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>Staff ID</th>
                                                                                    <th>Staff Name</th>
                                                                                    <th>Start</th>
                                                                                    <th>End</th>
                                                                                    <th>Total Days</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $checkDraft = new DbaseManipulation;
                                                                                    $rows = $checkDraft->readData("SELECT i.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleaveovertimedetails_draft as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId WHERE i.status = 'Drafted' ORDER BY i.id DESC"); //Drafted means button finalized was NOT Clicked before...
                                                                                    if($checkDraft->totalCount != 0) {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="7">
                                                                                                <div class="alert alert-warning" role="alert">
                                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                                                                                    <p>The following overtime leave has been added as draft but they were not yet finalized. Click on Finalized button to have the overtime converted into internal balance and will be credited to respected staffs.</p>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php        
                                                                                        foreach($rows as $row){
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?php echo $row['id']; ?></td>
                                                                                                <td><?php echo $row['staffId']; ?></td>
                                                                                                <td><?php echo $row['staffName']; ?></td>
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                                <td><?php echo $row['total']; ?></td>
                                                                                                <td><button onClick="deleteAddedOvertime('<?php echo $row['id']; ?>')" type="button" class="btn btn-outline-danger waves-effect waves-light" title="Remove this entry"><i class="fa fa-trash"></i></button></td>
                                                                                            </tr>
                                                                                            <?php            
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </tbody>
                                                                            <tfoot>
                                                                                    <tr>
                                                                                        <td colspan="7">
                                                                                        <div class="alert alert-info">
                                                                                            <strong><i class="fa fa-info-circle"></i> Reminder:</strong> These leaves in the table were not yet saved and credited. Click on Finalize button finish processing.
                                                                                        </div>
                                                                                        </td>
                                                                                    </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="form-actions">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="row">
                                                                                <div class="col-md-offset-3 col-md-9">
                                                                                    <button type="submit" name="finalizedSubmit" class="btn btn-info waves-effect waves-light finalizedSubmit"><i class="fa fa-paper-plane"></i> Finalized</button>
                                                                                    <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6"></div>
                                                                    </div>
                                                                </div>
                                                            </form>
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
                    /*$('.finalized').submit(function(e) {
                        var currentForm = this;
                        e.preventDefault();
                        bootbox.confirm("Are you sure?", function(result) {
                            if (result) {
                                currentForm.submit();
                            }
                        });
                    });*/
                    $(document).ready(function() {
                        $.ajax({
                            url	 : 'ajaxpages/leaves/overtime/countdraft.php'
                            ,type	 : 'POST'
                            ,dataType: 'json'
                            ,success : function(e){
                                if(e.enable == 1){
                                    $('.finalizedSubmit').removeAttr('disabled');
                                } else {
                                    $('.finalizedSubmit').attr('disabled','disabled');
                                }	
                            }
                            ,error	: function(e){
                            }
                        });
                    });
                </script>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Overtime leave application entries has been finalized. The application was send for approval.</h5>
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