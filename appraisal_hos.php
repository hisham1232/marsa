<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed =  true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            ?>  
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <div class="preloader">
                    <!-- <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg> -->
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Appraisal - HOS</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                         <li class="breadcrumb-item"><a href="appraisal_homepage.php" title="Click to View Appraisal Homepage">Appraisal</a> </li>
                                        <li class="breadcrumb-item">Staff Appraisal</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <?php
                                            $appraisalYear = $helper->getAppraisalYear('appraisal_year');
                                            $basic_info = new DBaseManipulation;
                                            $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, s.joinDate, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.position_id, nat.name as nationality FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as nat ON nat.id = s.nationality_id WHERE s.staffId = '$staffId'");
                                        ?>
                                        <div class="card-header bg-light-success" style="border-bottom: double; border-color: #28a745">
                                            <div class="d-flex no-block align-items-center">
                                                <h4 class="card-title font-weight-bold">Staff Appraisal Form - HOS [<?php echo $appraisalYear; ?>]</h4>
                                                <div class="ml-auto">
                                                    <ul class="list-inline text-right">
                                                        <?php 
                                                            $checkSubmitted =  new DbaseManipulation;
                                                            if(isset($_GET['y'])) {
                                                                $currentYear = $_GET['y'];
                                                            } else {
                                                                $currentYear = date('Y');
                                                            }
                                                            $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_hos WHERE staff_id = '$staffId' AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                                            if($checkSubmitted->totalCount != 0) {
                                                                $staffStats = 'Submitted ['.date('d/m/Y',strtotime($rec['date_submitted'])).']';
                                                                $requestNo = $rec['requestNo'];
                                                                if($rec['status'] == 'Completed') {
                                                                    $show = 'display: inline';
                                                                } else {
                                                                    $show = 'display: none';
                                                                }
                                                            } else {
                                                                $staffStats = 'Not Started';
                                                                $request = new DbaseManipulation;
                                                                $requestNo = $request->requestNo("HOS-","appraisal_hos");
                                                                $show = 'display: none';
                                                            }
                                                        ?>
                                                        <li>ID/Status  <span class="font-weight-bold text-info"><?php echo $requestNo; ?> - <?php echo $rec['status']; ?></span></li>
                                                        <li>
                                                            <a style="<?php echo $show; ?>" href="appraisal_hos_view.php?id=<?php echo $rec['id']; ?>" target="_blank" class="btn btn-sm btn-warning waves-effect waves-light" title="Click to Show the Appraisal Result to Staff"><i class="fas fa-search"></i> View Result</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-2">Name</div>
                                                        <div class="col-md-10"> <span class="font-weight-bold text-info"><?php echo trim($info['staffName']); ?> </span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Section</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"> <?php echo $info['section']; ?> </span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Dept.</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"><?php echo $info['department']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Job Title</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"><?php echo $info['jobtitle']; ?></span></div>
                                                    </div><!--end row-->
                                                </div><!--end col staff-->

                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-4">Gender</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['gender']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-4">Nationality</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['nationality']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-4">Sponsor</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['sponsor']; ?></span></div>
                                                    </div><!--end row-->
                                                     <div class="row">
                                                        <div class="col-md-4">Join Date</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></div>
                                                    </div><!--end row-->
                                                </div><!--end col -->

                                                <div class="col-md-5">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-2">Staff</div>
                                                        <div class="col-md-6"><?php echo trim($info['staffName']); ?></div>

                                                        <div class="col-md-4"><span class="font-weight-bold text-info"><?php echo $staffStats; ?> </span></div>
                                                    </div><!--end row-->
                                                    <?php
                                                        $staff_position_id = $info['position_id'];
                                                        $approval = new DbaseManipulation;
                                                        $approvers = $approval->readData("SELECT s.*, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as approverName, p.code as approverTitle FROM  appraisal_approval_sequence as s LEFT OUTER JOIN staff_position as p ON p.id = s.approver_id LEFT OUTER JOIN employmentdetail as e ON e.position_id = s.approver_id LEFT OUTER JOIN staff as ss ON e.staff_id = ss.staffId WHERE s.position_id = $staff_position_id AND e.isCurrent = 1 and e.status_id = 1 ORDER BY s.sequence_no");
                                                        if($approval->totalCount != 0) {
                                                            if($rec['current_sequence'] == 2) { //Last Approver
                                                                foreach ($approvers as $row) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                        <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                        <?php 
                                                                            if($row['sequence_no'] == 1) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate('appraisal_hos_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 2) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        
                                                                    </div>
                                                                    <?php
                                                                }        
                                                            } else if($rec['current_sequence'] == 1) { //2nd Approver
                                                                foreach ($approvers as $row) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                        <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                        <?php 
                                                                            if($row['sequence_no'] == 1) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 2) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Pending</span></div>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        
                                                                    </div>
                                                                    <?php
                                                                }        
                                                            }
                                                        }
                                                    ?>
                                                </div><!--end col status-->
                                            </div><!--end row-->
                                        </div><!--end card header-->
                                        <div class="card-body">
                                            <ul class="nav nav-tabs customtab2" role="tablist">
                                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Qualification" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Qualification</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#SelfAppraisal" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Self Appraisal</span></a> </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane p-20 active" id="Qualification" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4 class="card-title">Staff Qualification List</h4>
                                                        </div>    
                                                        <div class="card-body">
                                                            <div class="table-responsiveXXX">
                                                                <table class="display nowrap table table-hover table-striped table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Degree</th>
                                                                            <th>Qualification Name</th>
                                                                            <th>University/Country</th>
                                                                            <th>Year</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $qua = new DBaseManipulation;
                                                                            $rows = $qua->readData("SELECT sq.*, d.name as degree, c.name as certification FROM staffqualification as sq LEFT OUTER JOIN degree as d ON d.id = sq.degree_id LEFT OUTER JOIN certificate as c ON c.id = sq.certificate_id WHERE staffId = '$staffId'");
                                                                            if($qua->totalCount != 0) {
                                                                                $i = 0;
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                                        <td><span class="text-primary font-weight-bold"><?php echo $row['degree']; ?></span></td>
                                                                                        <td><?php echo $row['certification']; ?></td>
                                                                                        <td><?php echo $row['institution']; ?></td>
                                                                                        <td><?php echo $row['graduateYear']; ?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20" id="SelfAppraisal" role="tabpanel">
                                                    <?php 
                                                        if(isset($_POST['submitHOS'])) {
                                                            $submit = new DbaseManipulation;
                                                            $row = $submit->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM appraisal_approval_sequence as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                            $sequence_no = $row['sequence_no'];
                                                            $approver_id = $row['approver_id'];
                                                            $checkRequest = new DbaseManipulation;
                                                            $requestIdNumber = $_POST['request_no'];
                                                            $checkRequest->singleReadFullQry("SELECT TOP 1 id, requestNo FROM appraisal_hos WHERE requestNo = '$requestIdNumber' ORDER BY id DESC");
                                                            if($checkRequest->totalCount != 0) {
                                                                $req = new DbaseManipulation;
                                                                $newReqNo = $req->requestNo("HOS-","appraisal_hos");    
                                                            } else {
                                                                $newReqNo = $_POST['request_no'];    
                                                            }
                                                            $fields = [
                                                                'requestNo'=>$newReqNo,
                                                                'staff_id'=>$staffId,
                                                                'department_id'=>$logged_in_department_id,
                                                                'section_id'=>$logged_in_section_id,
                                                                'appraisal_type'=>4,
                                                                'status'=>'Submitted by the HOS',
                                                                'position_id'=>$myPositionId,
                                                                'current_approver'=>$approver_id,
                                                                'current_sequence'=>$sequence_no,
                                                                'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                'appraisal_year'=>date('Y',time()),
                                                                'jd1'=>$_POST['htechtextarea_job1'],
                                                                'jd2'=>$_POST['htechtextarea_job2'],
                                                                'jd3'=>$_POST['htechtextarea_job3'],
                                                                'acc1'=>$_POST['htechtextarea_accomplishment1'],
                                                                'acc2'=>$_POST['htechtextarea_accomplishment2'],
                                                                'acc3'=>$_POST['htechtextarea_accomplishment3'],
                                                                'acc4'=>$_POST['htechtextarea_accomplishment4'],
                                                                'gs1'=>$_POST['htechtextarea_goal1'],
                                                                'gs2'=>$_POST['htechtextarea_goal2']
                                                            ];
                                                            $saveTech = new DBaseManipulation;
                                                            if($saveTech->insert("appraisal_hos",$fields)){
                                                                $contact_details = new DbaseManipulation;
                                                                $gsm = $contact_details->getContactInfo(1,$staffId,'data');
                                                                $getIdInfo = new DbaseManipulation;
                                                                $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                                                $from_name = 'hrms@nct.edu.om';
                                                                $from = 'HRMS - 3.0';
                                                                $subject = 'NCT-HRMD STAFF APPRAISAL SUBMITTED BY '.strtoupper($logged_name);
                                                                $message = '<html><body>';
                                                                $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                                $message .= "<h3>NCT-HRMS 3.0 STAFF APPRAISAL DETAILS</h3>";
                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Submitted By The HOS</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>For Approval Of Direct Manager</td></tr>";
                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$newReqNo."</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                $message .= "</table>";
                                                                $message .= "</body></html>";
                                                                $to = array();
                                                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $approver_id AND isCurrent = 1 AND status_id = 1");
                                                                $nextApproversStaffId = $nextApprover['staff_id'];
                                                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                                                array_push($to,$logged_in_email,$nextApproverEmailAdd);
                                                                $emailParticipants = new sendMail;
                                                                $a=1;
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
                                                                        'requestNo'=>$newReqNo,
                                                                        'moduleName'=>'HOS - Staff Appraisal Submitted',
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
                                                                        'requestNo'=>$newReqNo,
                                                                        'moduleName'=>'HOS - Staff Appraisal Submitted',
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
                                                        if($checkSubmitted->totalCount != 0) {
                                                            ?>
                                                            <form novalidate>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Job Definition</h4></div>
                                                                        <div class="card-body">
                                                                            <div class="form-group">
                                                                                <h5>1. Describe your duties and responsibilities. <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea class="textarea_job1 form-control" rows="3" readonly><?php echo $rec['jd1']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <h5>2. Which responsibility from those listed in #1 do you think is most important and why? <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea class="textarea_job2 form-control" rows="3" readonly><?php echo $rec['jd2']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <h5>3. Specify what you consider in order to achieve your job requirements. <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea class="textarea_job3 form-control" rows="3" readonly><?php echo $rec['jd3']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>                                        
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Accomplishments</h4></div>
                                                                    <div class="card-body">                                                
                                                                        <div class="form-group">
                                                                            <h5>1. What actions have you taken this year in order to gain a better understanding of the organization, your department, or your own job? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment1 form-control" rows="3" readonly><?php echo $rec['acc1']; ?></textarea>
                                                                            </div>                                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>2. In your view, what is your contribution to the organization in order to achieve its goals and objectives? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment2 form-control" rows="3" readonly><?php echo $rec['acc2']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>3. Have you performed any new tasks or additional duties outside the scope of your regular responsibilities? If so, please specify. <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment3 form-control" rows="3" readonly><?php echo $rec['acc3']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>4. Describe any staff development activities that have been helpful to you. <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment4 form-control" rows="3" readonly><?php echo $rec['acc4']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Goal Setting</h4></div>
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <h5>1. In what specific areas would you like to improve your job performance? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_goal1 form-control" rows="3" readonly><?php echo $rec['gs1']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>2. What kind of support and/or guidance would you like to see from your supervisor? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_goal2 form-control" rows="3" readonly><?php echo $rec['gs2']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end card body Goal Setting-->
                                                                </div>
                                                            </form>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <form id="techForm" method="POST" action="" novalidate>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Job Definition</h4></div>
                                                                        <div class="card-body">
                                                                            <div class="form-group">
                                                                                <h5>1. Describe your duties and responsibilities. <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea name="techtextarea_job1" class="textarea_job1 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                    <input type="hidden" name="htechtextarea_job1" class="htechtextarea_job1">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <h5>2. Which responsibility from those listed in #1 do you think is most important and why? <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea name="techtextarea_job2" class="textarea_job2 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                    <input type="hidden" name="htechtextarea_job2" class="htechtextarea_job2">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <h5>3. Specify what you consider in order to achieve your job requirements. <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea name="techtextarea_job3" class="textarea_job3 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                    <input type="hidden" name="htechtextarea_job3" class="htechtextarea_job3">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>                                        
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Accomplishments</h4></div>
                                                                    <div class="card-body">                                                
                                                                        <div class="form-group">
                                                                            <h5>1. What actions have you taken this year in order to gain a better understanding of the organization, your department, or your own job? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea name="techtextarea_accomplishment1" class="textarea_accomplishment1 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htechtextarea_accomplishment1" class="htechtextarea_accomplishment1">
                                                                            </div>                                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>2. In your view, what is your contribution to the organization in order to achieve its goals and objectives? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea name="techtextarea_accomplishment2" class="textarea_accomplishment2 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htechtextarea_accomplishment2" class="htechtextarea_accomplishment2">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>3. Have you performed any new tasks or additional duties outside the scope of your regular responsibilities? If so, please specify. <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea name="techtextarea_accomplishment3" class="textarea_accomplishment3 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htechtextarea_accomplishment3" class="htechtextarea_accomplishment3">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>4. Describe any staff development activities that have been helpful to you. <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea name="techtextarea_accomplishment4" class="textarea_accomplishment4 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htechtextarea_accomplishment4" class="htechtextarea_accomplishment4">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Goal Setting</h4></div>
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <h5>1. In what specific areas would you like to improve your job performance? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea name="techtextarea_goal1" class="textarea_goal1 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htechtextarea_goal1" class="htechtextarea_goal1">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>2. What kind of support and/or guidance would you like to see from your supervisor? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea name="techtextarea_goal2" class="textarea_goal2 form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htechtextarea_goal2" class="htechtextarea_goal2">
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end card body Goal Setting-->
                                                                </div>
                                                                <div class="text-xs-right">
                                                                    <input type="hidden" name="request_no" value="<?php echo $requestNo; ?>">
                                                                    <button type="submit" name="submitHOS" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Appraisal</button>
                                                                    <button type="reset" name="resetAppraisal" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Reset</button>
                                                                </div>
                                                            </form>
                                                            <?php 
                                                        }
                                                    ?>        
                                                </div>
                                            </div><!--end tab-content-->                                          
                                        </div><!--end card body main-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-12 col-xs-18-->
                            </div><!--end row-->
                        </div>            
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>

                <script>
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });
                    $('.daterange').daterangepicker();
                </script>
                <script src="assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
                <script src="assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>
                 <script type="text/javascript" src="assets/plugins/multiselect/js/jquery.multi-select.js"></script>
                <script>
                    $(document).ready(function() {
                        $('.textarea_job1').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_job2').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_job3').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment1').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment2').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment3').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment4').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_goal1').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_goal2').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});

                        $("#techForm").submit(function() {
                           var textarea_job1 = $('.textarea_job1').val();
                           var textarea_job2 = $('.textarea_job2').val();
                           var textarea_job3 = $('.textarea_job3').val();
                           $(".htechtextarea_job1").val(textarea_job1);
                           $(".htechtextarea_job2").val(textarea_job2);
                           $(".htechtextarea_job3").val(textarea_job3);

                           var textarea_accomplishment1 = $('.textarea_accomplishment1').val();
                           var textarea_accomplishment2 = $('.textarea_accomplishment2').val();
                           var textarea_accomplishment3 = $('.textarea_accomplishment3').val();
                           var textarea_accomplishment4 = $('.textarea_accomplishment4').val();
                           $(".htechtextarea_accomplishment1").val(textarea_accomplishment1);
                           $(".htechtextarea_accomplishment2").val(textarea_accomplishment2);
                           $(".htechtextarea_accomplishment3").val(textarea_accomplishment3);
                           $(".htechtextarea_accomplishment4").val(textarea_accomplishment4);

                           var textarea_goal1 = $('.textarea_goal1').val();
                           var textarea_goal2 = $('.textarea_goal2').val();
                           $(".htechtextarea_goal1").val(textarea_goal1);
                           $(".htechtextarea_goal2").val(textarea_goal2);
                        });
                    });

                    //For multiselect
                    $('#pre-selected-options').multiSelect();
                    $('#optgroup').multiSelect({
                        selectableOptgroup: true
                    });
                    $('#public-methods').multiSelect();
                    $('#select-all').click(function() {
                        $('#public-methods').multiSelect('select_all');
                        return false;
                    });
                    $('#deselect-all').click(function() {
                        $('#public-methods').multiSelect('deselect_all');
                        return false;
                    });
                    $('#refresh').on('click', function() {
                        $('#public-methods').multiSelect('refresh');
                        return false;
                    });
                    $('#add-option').on('click', function() {
                        $('#public-methods').multiSelect('addOption', {
                            value: 42,
                            text: 'test 42',
                            index: 0
                        });
                        return false;
                    });
                </script>    
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Staff appraisal information has been submitted successfully!<br><br>Click on Self Appraisal tab to see the information you have submitted.</h5>
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