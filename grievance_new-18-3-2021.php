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
                                    <h3 class="text-themecolor m-b-0 m-t-0">File A Grievance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Staff Grievance</li>
                                        <li class="breadcrumb-item">File A Grievance</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card"><!-- card-outline-success-->
                                         <div class="card-header bg-light-warning3 p-t-5 p-b-0 m-t-0 m-b-0">
                                            <div class="row">
                                               <div class="col-12">
                                                    <div class="d-flex flex-wrap">
                                                        <div><h3 class="card-title">Staff Grievance Form</h3></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body bg-light-warning2 p-t-5 p-b-0 m-t-0 m-b-0">
                                            <div class="row">
                                                <?php
                                                    $basic_info = new DBaseManipulation;
                                                    $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
                                                ?>
                                                <div class="col-lg-6"><!---start about Details of Staff Giving Complaint div-->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Details of Staff Giving Complaint</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="form-horizontal">
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Staff ID Name</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['staffId'].' - '.trim($info['staffName']); ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Department</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['department']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-briefcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Section</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['section']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-suitcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Job Title</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['jobtitle']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-credit-card"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                            
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Sponsor</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['sponsor']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-tags"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                    <?php
                                                                        $contact_details = new DbaseManipulation;
                                                                        $email = $contact_details->getContactInfo(2,$staffId,'data');
                                                                        $gsm = $contact_details->getContactInfo(1,$staffId,'data');
                                                                    ?>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">GSM</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $gsm; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-phone"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Email</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $email; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-envelope-open"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->

                                                <div class="col-lg-6"><!---start about Details of Staff Giving Complaint div-->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Complaint Given Against</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                                if(isset($_POST['submit'])) {
                                                                    $submit = new DbaseManipulation;
                                                                    $dateFiled = date('Y-m-d H:i:s',time());
                                                                    $complainant = $_POST['staffId'];
                                                                    $responder = $_POST['staffIdComplaintTo'];
                                                                    $complaint_type = $_POST['complaint_type'];
                                                                    $statement = $_POST['statement'];
                                                                    $status = 'OPEN';
                                                                    $date_filed = $dateFiled;

                                                                    $getSectionInfo = new DbaseManipulation;
                                                                    $complainantSectionId = $getSectionInfo->sectionId($complainant,'section_id');
                                                                    $responderSectionId = $getSectionInfo->sectionId($responder,'section_id');
                                                                    if($complainantSectionId == $responderSectionId) {
                                                                        //echo "Same Section! Category 1";
                                                                        $category_id = 1;
                                                                    } else {
                                                                        $getDepartmentInfo = new DbaseManipulation;
                                                                        $complainantDepartmentId = $getDepartmentInfo->departmentId($complainant,'department_id');
                                                                        $responderDepartmentId = $getDepartmentInfo->departmentId($responder,'department_id');
                                                                        if($complainantDepartmentId == $responderDepartmentId) {
                                                                            //echo "Same Department! Category 2";
                                                                            $category_id = 2;
                                                                        } else {
                                                                            //echo "Different Department and Section! Category 3";
                                                                            $category_id = 3;
                                                                        }
                                                                    }

                                                                    $nextApp = new DbaseManipulation;
                                                                    $row = $nextApp->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM grievance_workflow as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId AND category_id = $category_id ORDER BY a.sequence_no");
                                                                    //echo "SELECT TOP 1 a.*, sp.title FROM grievance_workflow as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId AND category_id = $category_id ORDER BY a.sequence_no";
                                                                    $current_approver_id = $row['approver_id'];
                                                                    $current_sequence_no = $row['sequence_no'];

                                                                    $fields = [
                                                                        'complainant'=>$complainant,
                                                                        'responder'=>$responder,
                                                                        'complaint_type'=>$complaint_type,
                                                                        'statement'=>$statement,
                                                                        'status'=>$status,
                                                                        'date_filed'=>$date_filed,
                                                                        'current_sequence_no'=>$current_sequence_no,
                                                                        'current_approver_id'=>$current_approver_id,
                                                                        'position_id'=>$myPositionId,
                                                                        'category_id'=>$category_id
                                                                    ];
                                                                    //print_r($fields);
                                                                    //Error in insert since the grievance_workflow table is not yet complete
                                                                    if($submit->insert("grievance",$fields)){
                                                                        $last_id = $submit->singleReadFullQry("SELECT TOP 1 id FROM grievance ORDER BY id DESC");
                                                                        $grievance_id = $last_id['id'];
                                                                        $fieldsHistory = [
                                                                            'grievance_id'=>$grievance_id,
                                                                            'staffId'=>$complainant,
                                                                            'statement'=>$statement,
                                                                            'decision'=>'Not-Agree',
                                                                            'dateEntered'=>$date_filed
                                                                        ];
                                                                        if($submit->insert("grievance_history",$fieldsHistory)){ 
                                                                                $getIdInfo = new DbaseManipulation;
                                                                                $history = $getIdInfo->readData("SELECT * FROM grievance_history WHERE grievance_id = $grievance_id ORDER BY id DESC");
                                                                                $respondentInfo = new DbaseManipulation;
                                                                                $respondentName = $respondentInfo->getStaffName($responder,'firstName','secondName','thirdName','lastName');
                                                                                $respondentEmail = $helper->getContactInfo(2,$responder,'data');
                                                                                $respondentgsm = $helper->getContactInfo(1,$responder,'data');
                                                                                $respondentDepartmentId = $helper->employmentIDs($responder,'department_id');
                                                                                $respondentDepartment = $helper->fieldNameValue("department",$respondentDepartmentId,"name");

                                                                                $from_name = 'hrms@nct.edu.om';
                                                                                $from = 'HRMS - 3.0';
                                                                                $subject = 'NCT-HRMD GRIEVANCE HAS BEEN FILED BY '.strtoupper($logged_name);
                                                                                $message = '<html><body>';
                                                                                $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                                                $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE DETAILS</h3>";
                                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Open</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>REQUEST ID:</strong> </td><td>".$grievance_id."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',time())."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT STAFF ID:</strong> </td><td>".$responder."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT NAME:</strong> </td><td>".$respondentName."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT DEPARTMENT:</strong> </td><td>".$respondentDepartment."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT ADDRESS:</strong> </td><td>".$respondentEmail."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT NUMBER:</strong> </td><td>".$respondentgsm."</td></tr>";
                                                                                $message .= "</table>";
                                                                                $message .= "<hr/>";
                                                                                $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE HISTORIES</h3>";
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
                                                                                    $fullStaffNameEmail = $getIdInfo->getStaffName($row['staffId'],'firstName','secondName','thirdName','lastName');
                                                                                    $dateNotesEmail = date('d/m/Y H:i:s',strtotime($row['dateEntered']));
                                                                                    $notesEmail = $row['statement'];
                                                                                    $statusEmail = $row['decision'];
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
                                                                                        'requestNo'=>$grievance_id,
                                                                                        'moduleName'=>'Grievance Application',
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
                                                                                        'requestNo'=>$grievance_id,
                                                                                        'moduleName'=>'Grievance Application',
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
                                                                }
                                                            ?>
                                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Staff ID Name</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" name="staffId" class="staffId" value="<?php echo $info['staffId']; ?>">
                                                                                 <select class="custom-select select2" name="staffIdComplaintTo" required data-validation-required-message="Please select staff">
                                                                                    <option value="">Select Staff Name </option>
                                                                                    <?php 
                                                                                        $managers = new DbaseManipulation;
                                                                                        $rows = $managers->readData($SQLActiveStaff);
                                                                                        foreach ($rows as $row) {
                                                                                    ?>
                                                                                            <option value="<?php echo $row['staffId']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                                    <?php            
                                                                                        }    
                                                                                    ?>
                                                                                    </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Department</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control department" readonly /> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-briefcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Section</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control section" readonly/> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-suitcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Job Title</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control jobtitle" readonly /> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-credit-card"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                    
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Sponsor</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control sponsor" readonly/> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-tags"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Complaint Type</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select class="form-control" name="complaint_type" required data-validation-required-message="Please select Nature of the Complaint">
                                                                                    <option value="">Nature of the Complaint</option>
                                                                                    <option value="1">Academic</option>
                                                                                    <option value="2">Administrative</option>
                                                                                    <option value="3">Personal</option>
                                                                                    <option value="4">Others</option>
                                                                                </select>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Grievance Statement</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <textarea name="statement" rows="4" id="statement" class="form-control" required data-validation-required-message="Please enter Grievance Statement"></textarea>
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-comment"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">&nbsp;</label>
                                                                    <div class="col-sm-9">
                                                                        <em>Please provide a full statement of facts surrounding the grievance.  (Give a clear answer on:  What happened, when, where, why, and how?) Give specific details on the alleged violation, the name/s of respondent/s or witness/es, and other relevant information.  An additional sheet may be used.</em>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">&nbsp;</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <label class="custom-control custom-checkbox">
                                                                                <input type="checkbox" required data-validation-required-message="Acknowledgement for filling grievance is required" value="single" name="styled_single_checkbox" class="custom-control-input"> <span class="custom-control-label text-info">I hereby declare that the information I provided on this staff grievance form is true, correct and complete to the best of my knowledge. </span> </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-3 col-sm-9">
                                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
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
                    $('.select2').on('change', function() {
                        var staffId = this.value;
                        var data = {
                            staffId : staffId
                        };
                        if(staffId != '') {
                            $.ajax({
                                url  : 'ajaxpages/grievance/staffInfo.php'
                                ,type    : 'POST'
                                ,dataType: 'json',
                                data    : data
                                ,success : function(e){
                                    if(e.error == 0){
                                        $('.department').val(e.department);
                                        $('.section').val(e.section);
                                        $('.jobtitle').val(e.jobtitle);
                                        $('.sponsor').val(e.sponsor);
                                    }   
                                }
                                ,error  : function(e){
                                }
                            });
                        }
                    });
                </script>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Grievance application has been submitted successfully!</h5>
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