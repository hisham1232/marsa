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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Apply Short Leave</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Leave Application</li>
                                        <li class="breadcrumb-item">Short Leave Application</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <div class="row">
                                                <div class="col-md-4"> 
                                                    <div class="d-flex flex-row">
                                                        <div class="mr-auto">
                                                            <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$staffId.'.jpg'; ?>" style=" width:100px; height:100px; border-radius: 50%" alt="Staff ID"><br>
                                                        </div>
                                                        <div style="margin-left:20px">
                                                            <?php
                                                                $basic_info = new DBaseManipulation;
                                                                $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
                                                            ?>
                                                            <h5 class="text-primary"><?php echo trim($info['staffName']); ?></h5>
                                                            <h5><i class="fas fa-address-card text-muted"></i> <?php echo $info['staffId']; ?></h5>
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
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Short Leave Application Form</h3>
                                                                    <h6 class="card-subtitle">إستمارة طلب إجازة قصيرة</h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <ul class="list-inline">
                                                                        <li class="none">
                                                                            <?php
                                                                                $requestNo = $helper->requestNo('SHL-',"shortleave");
                                                                                $row = $helper->singleReadFullQry("SELECT id, department_id, position_id, approverInSequence1 FROM approvalsequence_shortleave WHERE active = 1 AND position_id = $myPositionId");
                                                                                $myApproverPositionId = $row['approverInSequence1'];
                                                                                $forApprovalText = "For Approval - ".$helper->fieldNameValue("staff_position",$myApproverPositionId,'code');
                                                                            ?>
                                                                            <h3 class="text-muted text-success">New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3>
                                                                            <h3 class="text-muted text-success">Status <span class="badge badge-info"><?php echo $forApprovalText; ?></span></h3>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                if(isset($_POST['submitShortLeave'])) {
                                                                    $save = new DbaseManipulation;
                                                                    $fields = [
                                                                        'requestNo'=>$_POST['requestNo'],
                                                                        'staff_id'=>$staffId,
                                                                        'currentStatus'=>'Pending',
                                                                        'dateFile'=>date('Y-m-d'),
                                                                        'leaveDate'=>$save->mySQLDate($_POST['shortleavedate']),
                                                                        'startTime'=>$_POST['daparture_time'],
                                                                        'endTime'=>$_POST['return_time'],
                                                                        'total'=>$_POST['noOfHours'],
                                                                        'reason'=>$_POST['reason'],
                                                                        'currentSeqNumber'=>1,
                                                                        'currentApproverPositionId'=>$myApproverPositionId
                                                                    ];
                                                                    if($save->insert("shortleave",$fields)){
                                                                        $last_id = $save->singleReadFullQry("SELECT TOP 1 id FROM shortleave ORDER BY id DESC");
                                                                        $shortleave_id = $last_id['id'];
                                                                        $fieldsHistory = [
                                                                            'shortleave_id'=>$shortleave_id,
                                                                            'requestNo'=>$_POST['requestNo'],
                                                                            'staff_id'=>$staffId,
                                                                            'status'=>$forApprovalText,
                                                                            'notes'=>$_POST['reason'],
                                                                            'ipAddress'=>$save->getUserIP()
                                                                        ];
                                                                        if($save->insert("shortleave_history",$fieldsHistory)) {
                                                                            $getIdInfo = new DbaseManipulation;
                                                                            $history = $getIdInfo->readData("SELECT * FROM shortleave_history WHERE shortleave_id = $shortleave_id ORDER BY id DESC");
                                                                            //Email Here...
                                                                            $from_name = 'hrms@nct.edu.om';
                                                                            $from = 'HRMS - 3.0';
                                                                            $subject = 'NCT-HRMD SHORT LEAVE FILED BY '.strtoupper($logged_name);
                                                                            $leaveDuration = 'From '.$_POST['daparture_time'].' to '.$_POST['return_time'];
                                                                            $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                                                            $message = '<html><body>';
                                                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                            $message .= "<h3>NCT-HRMS 3.0 SHORT LEAVE DETAILS</h3>";
                                                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Pending</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$forApprovalText."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$_POST['requestNo']."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DATE:</strong> </td><td>".$_POST['shortleavedate']."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>NUMBER OF HOURS:</strong> </td><td>".$_POST['noOfHours']."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                            $message .= "</table>";
                                                                            $message .= "<hr/>";
                                                                            $message .= "<h3>NCT-HRMS 3.0 SHORT LEAVE HISTORIES</h3>";
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
                                                                            $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $myApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                                                            $nextApproversStaffId = $nextApprover['staff_id'];
                                                                            $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                                                            array_push($to,$logged_in_email,$nextApproverEmailAdd);
                                                                            $emailRecipient = new sendMail;
                                                                            if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)){
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
                                                                                    'moduleName'=>'Short Leave Application',
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
                                                                                //echo $save->displayArr($emailFields);
                                                                                $saveEmail = new DbaseManipulation;
                                                                                $saveEmail->insert("system_emails",$emailFields);  
                                                                                ?>
                                                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                    <p>Short leave application has been submitted and processed successfully.</p>
                                                                                </div>
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
                                                                                    'moduleName'=>'Short Leave Application',
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
                                                                                //echo $save->displayArr($emailFields);
                                                                                $saveEmail = new DbaseManipulation;
                                                                                $saveEmail->insert("system_emails",$emailFields);
                                                                            }
                                                                        }    
                                                                    }        
                                                                }
                                                            ?>        
                                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">Date Requested <br>تاريخ الطلب</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="requestDate" class="form-control" readonly value="<?php echo date("d/m/Y"); ?>">
                                                                                <input type="hidden" name="requestNo" class="form-control" readonly value="<?php echo $requestNo; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="far fa-calendar-alt"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Date for Short Leave <br>تاريخ الإجازة القصيرة</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control" name="shortleavedate" id="sl_date" required data-validation-required-message="Please enter leave date"/>
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Departure Time <br>وقت المغادرة</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group clockpicker_daparture_time">
                                                                            <input type="text" name="daparture_time" class="form-control daparture_time" required data-validation-required-message="Please enter departure time"/>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Estimated Return Time<br>وقت العودة المتوقع</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group clockpicker_return_time">
                                                                            <input type="text" name="return_time" class="form-control return_time" required data-validation-required-message="Please enter estimated return time">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label">Number of Hours <br>عدد الساعات</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="noOfHours" class="form-control noOfHours" readonly> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
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
                                                                                <textarea name="reason" class="form-control" rows="2" required data-validation-required-message="Reasons for Leave is required" minlength="20" onFocus="computeTime()"></textarea>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-3 col-sm-9">
                                                                        <button type="submit" name="submitShortLeave" class="btn btn-info waves-effect waves-light submitShortLeave"><i class="fa fa-paper-plane"></i> Submit</button>
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
                                                                    <h3 class="card-title">Short Leave Approval Sequence Will Be</h3>
                                                                    <h6 class="card-subtitle">تسلسل إعتماد طلب الإجازة القصيرة</h6>
                                                                </div>
                                                            </div>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-info ribbon-vertical-l">1</div>
                                                                <h3 class="ribbon-content"><?php echo $forApprovalText; ?> Approval</h3>
                                                            </div>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-info ribbon-vertical-l">2</div>
                                                                <h3 class="ribbon-content">HOD-HRD Notification</h3>
                                                            </div>                          
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
                <!-- Clock Plugin JavaScript -->
                <script src="assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
                <script>
                    $('.daparture_time').keypress(function(e) {
                        e.preventDefault();
                    });
                    $('.return_time').keypress(function(e) {
                        e.preventDefault();
                    });
                    $('#sl_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    // Clock pickers
                    $('#single-input').clockpicker({
                        placement: 'bottom',
                        align: 'left',
                        autoclose: true,
                        'default': 'now'
                    });
                    $('.clockpicker_daparture_time').clockpicker({
                        donetext: 'Done',
                        twelvehour: true
                    }).find('.daparture_time').change(function() {
                        console.log(this.value);
                    });
                    $('.clockpicker_return_time').clockpicker({
                        donetext: 'Done',
                        twelvehour: true
                    }).find('.return_time').change(function() {
                        console.log(this.value);
                        computeTime();
                    });
                    $('#check-minutes').click(function(e) {
                        // Have to stop propagation here
                        e.stopPropagation();
                        input.clockpicker('show').clockpicker('toggleView', 'minutes');
                    });
                    if (/mobile/i.test(navigator.userAgent)) {
                        $('input').prop('readOnly', true);
                    }

                    //Javasript Manual Computation of Time Difference...Thanks to stackoverflow, haha!
                    function computeTime() {
                        var time1 = $(".daparture_time").val().split(':'), 
                            time2 = $(".return_time").val().split(':');
                        var hours1 = parseInt(time1[0], 10), 
                            hours2 = parseInt(time2[0], 10),
                            mins1 = parseInt(time1[1], 10),
                            mins2 = parseInt(time2[1], 10);
                        var hours = hours2 - hours1, mins = 0;
                        if(hours < 0) { 
                            hours = 24 + hours;
                        }
                        if(mins2 >= mins1) {
                            mins = mins2 - mins1;
                        } else {
                            mins = (mins2 + 60) - mins1;
                            hours--;
                        }
                        mins = mins / 60;
                        hours += mins;
                        if(hours > 12) {
                            hours = hours - 12;
                        }
                        if (hours > 3 && hours > 12) {
                            hours1 = hours.toFixed(2);
                            var decimalTimeString1 = hours1;
                            var decimalTime1 = parseFloat(decimalTimeString1);
                            decimalTime1 = decimalTime1 * 60 * 60;
                            var hoursX1 = Math.floor((decimalTime1 / (60 * 60)));
                            decimalTime1 = decimalTime1 - (hoursX1 * 60 * 60);
                            var minutes1 = Math.floor((decimalTime1 / 60));
                            decimalTime1 = decimalTime1 - (minutes1 * 60);
                            var seconds1 = Math.round(decimalTime1);
                            if(hoursX1 < 10) {
                                hoursX1 = "0" + hoursX1;
                            }
                            if(minutes1 < 10) {
                                minutes1 = "0" + minutes1;
                            }
                            if(seconds1 < 10) {
                                seconds1 = "0" + seconds1;
                            }
                            var hoursInSeconds = Math.floor(hoursX * 60 * 60);
                            var minutesInSeconds = Math.floor(minutes * 60);
                            var totalTimeInSeconds = Math.floor(hoursInSeconds) + Math.floor(minutesInSeconds) + Math.floor(seconds);
                            if(totalTimeInSeconds > 14400) {
                                $(".submitShortLeave").prop("disabled", true);
                                bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>The maximum time for short leave is FOUR (4) HOURS.<br/>Please adjust your short leave timings.");
                                $(".noOfHours").val("" + hoursX1 + ":" + minutes1 + ":" + seconds1);
                            } else {
                                $(".submitShortLeave").prop("disabled", false);
                                $(".noOfHours").val("" + hoursX1 + ":" + minutes1 + ":" + seconds1);
                            }
                            
                                
                        } else {
                            if(hours > 3 && hours < 12) {
                                hours = hours.toFixed(2);
                            } else {
                                hours = hours.toFixed(2);    
                            }
                                var decimalTimeString = hours;
                                var decimalTime = parseFloat(decimalTimeString);
                                decimalTime = decimalTime * 60 * 60;
                                var hoursX = Math.floor((decimalTime / (60 * 60)));
                                decimalTime = decimalTime - (hoursX * 60 * 60);
                                var minutes = Math.floor((decimalTime / 60));
                                decimalTime = decimalTime - (minutes * 60);
                                var seconds = Math.round(decimalTime);
                                if(hoursX < 10) {
                                    hoursX = "0" + hoursX;
                                }
                                if(minutes < 10) {
                                    minutes = "0" + minutes;
                                }
                                if(seconds < 10) {
                                    seconds = "0" + seconds;
                                }
                                var hoursInSeconds = Math.floor(hoursX * 60 * 60);
                                var minutesInSeconds = Math.floor(minutes * 60);
                                var totalTimeInSeconds = Math.floor(hoursInSeconds) + Math.floor(minutesInSeconds) + Math.floor(seconds);
                                if(totalTimeInSeconds > 14400) {
                                    $(".submitShortLeave").prop("disabled", true);
                                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>The maximum time for short leave is FOUR (4) HOURS.<br/>Please adjust your short leave timings.");
                                    $(".noOfHours").val("" + hoursX + ":" + minutes + ":" + seconds);
                                } else {
                                    $(".submitShortLeave").prop("disabled", false);
                                    $(".noOfHours").val("" + hoursX + ":" + minutes + ":" + seconds);
                                }
                                
                        }
                    }    
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>