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
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Clearance Application</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance </li>
                                        <li class="breadcrumb-item">Apply Clearance</li>
                                    </ol>
                                </div>

                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <?php 
                                if(!isset($_GET['sc']) && !isset($_GET['stc'])){
                                    ?>
                                    <script>
                                        $(document).ready(function() {
                                            $('#modalClearanceType').modal('show');
                                        });
                                    </script>
                                    <?php 
                                }
                                if(isset($_GET['sc'])) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header bg-light-yellow">
                                                    <h4 class="card-title font-weight-bold">Clearance Application Form</h4>
                                                    <div class="row">
                                                        <?php
                                                            $basic_info = new DBaseManipulation;
                                                            $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, s.gender, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.joinDate, n.name as nationality, q.name as qualification FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id WHERE s.staffId = '$staffId' AND e.isCurrent = 1 and e.status_id = 1");
                                                        ?>
                                                        <div class="col-lg-6">
                                                            <p class="m-b-0">Staff ID: <span class="text-primary"><?php echo $staffId; ?></span></p>
                                                            <p class="m-b-0">Staff Name: <span class="text-primary"><?php echo $info['staffName']; ?></span></p>
                                                            <p class="m-b-0">Department: <span class="text-primary"><?php echo $info['department']; ?></span></p>
                                                            <p class="m-b-0">Section: <span class="text-primary"><?php echo $info['section']; ?></span></p>
                                                            <p class="m-b-0">Job Title: <span class="text-primary"><?php echo $info['jobtitle']; ?></span></p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $info['sponsor']; ?></span></p>
                                                            <p class="m-b-0">Qualification: <span class="text-primary"><?php echo $info['qualification']; ?></span></p>
                                                            <p class="m-b-0">Join Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></p>
                                                            <p class="m-b-0">Nationality: <span class="text-primary"><?php echo $info['nationality']; ?></span></p>
                                                            <p class="m-b-0">Gender: <span class="text-primary"><?php echo $info['gender']; ?></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                    $ifClearanceExist = new DbaseManipulation;
                                                    $rows = $ifClearanceExist->readData("SELECT * FROM clearance WHERE staffId = '$staffId' AND isCleared = 0");
                                                    if($ifClearanceExist->totalCount != 0) {
                                                        ?>
                                                        <div class="card-header bg-light-blue">
                                                            <label class="col-sm-12 control-label"><h3 class="text-danger"><i class='fa fa-exclamation-triangle'></i> The system found out that you still have pending clearance. You cannot file another one unless your pending clearance is cleared.</h3></label>
                                                        </div>
                                                        <?php    
                                                    } else { 
                                                        ?>
                                                        <div class="card-body">
                                                            <div class="card-header bg-light-blue">
                                                                <?php 
                                                                    if(isset($_POST['submit'])) {                                                    
                                                                        
                                                                        function array_push_assoc($array, $key, $value){
                                                                           $array[$key] = $value;
                                                                           return $array;
                                                                        }
                                                                        $fields = array();
                                                                        $requestNo = $_POST['requestNo'];
                                                                        $fields = [
                                                                            'staffId'=>$staffId,
                                                                            'dateSubmitted'=>date('Y-m-d H:i:s')
                                                                        ];
                                                                        foreach ($_POST['checkBoxA'] as $chkBoxA){
                                                                            $fields = array_push_assoc($fields, 'aTick'.$chkBoxA, 1);
                                                                        }
                                                                        $fields = array_push_assoc($fields, 'aTick7Reason', $_POST['aTick7Reason']);

                                                                        foreach ($_POST['theJobRdo1'] as $theJobRdo1){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo1', $theJobRdo1);
                                                                        }
                                                                        foreach ($_POST['theJobRdo2'] as $theJobRdo2){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo2', $theJobRdo2);
                                                                        }
                                                                        foreach ($_POST['theJobRdo3'] as $theJobRdo3){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo3', $theJobRdo3);
                                                                        }
                                                                        foreach ($_POST['theJobRdo4'] as $theJobRdo4){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo4', $theJobRdo4);
                                                                        }
                                                                        foreach ($_POST['theJobRdo5'] as $theJobRdo5){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo5', $theJobRdo5);
                                                                        }
                                                                        foreach ($_POST['theJobRdo6'] as $theJobRdo6){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo6', $theJobRdo6);
                                                                        }
                                                                        foreach ($_POST['theJobRdo7'] as $theJobRdo7){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo7', $theJobRdo7);
                                                                        }
                                                                        foreach ($_POST['theJobRdo8'] as $theJobRdo8){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo8', $theJobRdo8);
                                                                        }
                                                                        foreach ($_POST['theJobRdo9'] as $theJobRdo9){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo9', $theJobRdo9);
                                                                        }
                                                                        foreach ($_POST['theJobRdo10'] as $theJobRdo10){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo10', $theJobRdo10);
                                                                        }
                                                                        foreach ($_POST['theJobRdo11'] as $theJobRdo11){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo11', $theJobRdo11);
                                                                        }
                                                                        foreach ($_POST['theJobRdo12'] as $theJobRdo12){
                                                                            $fields = array_push_assoc($fields, 'theJobRdo12', $theJobRdo12);
                                                                        }
                                                                        $fields = array_push_assoc($fields, 'theJobComment13', $_POST['theJobComment13']);

                                                                        foreach ($_POST['theCollegeRdo1'] as $theCollegeRdo1){
                                                                            $fields = array_push_assoc($fields, 'theCollegeRdo1', $theCollegeRdo1);
                                                                        }
                                                                        foreach ($_POST['theCollegeRdo2'] as $theCollegeRdo2){
                                                                            $fields = array_push_assoc($fields, 'theCollegeRdo2', $theCollegeRdo2);
                                                                        }
                                                                        foreach ($_POST['theCollegeRdo3'] as $theCollegeRdo3){
                                                                            $fields = array_push_assoc($fields, 'theCollegeRdo3', $theCollegeRdo3);
                                                                        }
                                                                        foreach ($_POST['theCollegeRdo4'] as $theCollegeRdo4){
                                                                            $fields = array_push_assoc($fields, 'theCollegeRdo4', $theCollegeRdo4);
                                                                        }
                                                                        foreach ($_POST['theCollegeRdo5'] as $theCollegeRdo5){
                                                                            $fields = array_push_assoc($fields, 'theCollegeRdo5', $theCollegeRdo5);
                                                                        }
                                                                        foreach ($_POST['theCollegeRdo6'] as $theCollegeRdo6){
                                                                            $fields = array_push_assoc($fields, 'theCollegeRdo6', $theCollegeRdo6);
                                                                        }
                                                                        $fields = array_push_assoc($fields, 'theCollegeComment7', $_POST['theCollegeComment7']);

                                                                        foreach ($_POST['theSupervisorRdo1'] as $theSupervisorRdo1){
                                                                            $fields = array_push_assoc($fields, 'theSupervisorRdo1', $theSupervisorRdo1);
                                                                        }
                                                                        foreach ($_POST['theSupervisorRdo2'] as $theSupervisorRdo2){
                                                                            $fields = array_push_assoc($fields, 'theSupervisorRdo2', $theSupervisorRdo2);
                                                                        }
                                                                        foreach ($_POST['theSupervisorRdo3'] as $theSupervisorRdo3){
                                                                            $fields = array_push_assoc($fields, 'theSupervisorRdo3', $theSupervisorRdo3);
                                                                        }
                                                                        foreach ($_POST['theSupervisorRdo4'] as $theSupervisorRdo4){
                                                                            $fields = array_push_assoc($fields, 'theSupervisorRdo4', $theSupervisorRdo4);
                                                                        }
                                                                        foreach ($_POST['theSupervisorRdo5'] as $theSupervisorRdo5){
                                                                            $fields = array_push_assoc($fields, 'theSupervisorRdo5', $theSupervisorRdo5);
                                                                        }
                                                                        foreach ($_POST['theSupervisorRdo6'] as $theSupervisorRdo6){
                                                                            $fields = array_push_assoc($fields, 'theSupervisorRdo6', $theSupervisorRdo6);
                                                                        }
                                                                        $fields = array_push_assoc($fields, 'theSupervisorComment7', $_POST['theSupervisorComment7']);

                                                                        foreach ($_POST['theManagementRdo1'] as $theManagementRdo1){
                                                                            $fields = array_push_assoc($fields, 'theManagementRdo1', $theManagementRdo1);
                                                                        }
                                                                        foreach ($_POST['theManagementRdo2'] as $theManagementRdo2){
                                                                            $fields = array_push_assoc($fields, 'theManagementRdo2', $theManagementRdo2);
                                                                        }
                                                                        foreach ($_POST['theManagementRdo3'] as $theManagementRdo3){
                                                                            $fields = array_push_assoc($fields, 'theManagementRdo3', $theManagementRdo3);
                                                                        }
                                                                        foreach ($_POST['theManagementRdo4'] as $theManagementRdo4){
                                                                            $fields = array_push_assoc($fields, 'theManagementRdo4', $theManagementRdo4);
                                                                        }
                                                                        foreach ($_POST['theManagementRdo5'] as $theManagementRdo5){
                                                                            $fields = array_push_assoc($fields, 'theManagementRdo5', $theManagementRdo5);
                                                                        }
                                                                        foreach ($_POST['theManagementRdo6'] as $theManagementRdo6){
                                                                            $fields = array_push_assoc($fields, 'theManagementRdo6', $theManagementRdo6);
                                                                        }
                                                                        foreach ($_POST['theManagementRdo7'] as $theManagementRdo7){
                                                                            $fields = array_push_assoc($fields, 'theManagementRdo7', $theManagementRdo7);
                                                                        }
                                                                        $fields = array_push_assoc($fields, 'theManagementComment8', $_POST['theManagementComment8']);

                                                                        $fields = array_push_assoc($fields, 'generalComment1', $_POST['generalComment1']);
                                                                        $fields = array_push_assoc($fields, 'generalComment2', $_POST['generalComment2']);
                                                                        $fields = array_push_assoc($fields, 'generalComment3', $_POST['generalComment3']);

                                                                        //print_r($fields);
                                                                        //Save this $fields in the exit_interview table
                                                                        $save = new DbaseManipulation;
                                                                        if($save->insert("exit_interview",$fields)) {                                                                            
                                                                            $requestNo = $_POST['requestNo'];
                                                                            $now_date = date('Y-m-d H:i:s');
                                                                            $sql_insert_clearance = "INSERT INTO clearance (requestNo, staffId, isCleared, dateCreated) VALUES ('$requestNo', '$staffId', 0, '$now_date')";
                                                                            $insertClearance = new DbaseManipulation;
                                                                            $insertClearance->executeSQL($sql_insert_clearance);
                                                                            $getIdInfo = new DbaseManipulation;    
                                                                            $lastId = $getIdInfo->singleReadFullQry("SELECT TOP 1 id FROM clearance ORDER BY id DESC");
                                                                            $clearance_id = $lastId['id'];
                                                                            $rows = $helper->readData("SELECT app.position_id, e.staff_id as approverStaffId FROM approvalsequence_standardleave as app LEFT OUTER JOIN employmentdetail as e ON app.approver_id = e.position_id WHERE app.position_id = $myPositionId AND app.is_final = 0 AND e.isCurrent = 1 AND e.status_id = 1"); //Getting HoS and HoD from standard leave approval process
                                                                            $clearanceProcesses = array();
                                                                            $to = array();
                                                                            if($helper->totalCount != 0) {
                                                                                if (count($rows) == 2) { //1. HoS > 2. HoD
                                                                                    $ctr = 1;
                                                                                    foreach ($rows as $row) {
                                                                                        $approverStaffId = $row['approverStaffId'];
                                                                                        if($ctr == 1) {
                                                                                            $approverEmailAdd = $helper->getContactInfo(2,$approverStaffId,'data');
                                                                                            array_push($to,$logged_in_email,$approverEmailAdd);
                                                                                            $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 1)";
                                                                                        } else {
                                                                                            $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 0)";
                                                                                        }    
                                                                                        array_push($clearanceProcesses,$sql);
                                                                                        $ctr++;
                                                                                    }
                                                                                } else { //1. HoD or ADAA
                                                                                    $ctr = 2;
                                                                                    foreach ($rows as $row) {
                                                                                        $approverStaffId = $row['approverStaffId'];
                                                                                        if($ctr == 2) {
                                                                                            $approverEmailAdd = $helper->getContactInfo(2,$approverStaffId,'data');
                                                                                            array_push($to,$logged_in_email,$approverEmailAdd);
                                                                                            $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 1)";
                                                                                        } else {
                                                                                            $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 0)";
                                                                                        }
                                                                                        array_push($clearanceProcesses,$sql);
                                                                                        $ctr++;
                                                                                    }
                                                                                }
                                                                            }
                                                                            $rows = $helper->readData("SELECT ca.position_id, ca.sequence_no, e.staff_id as approverStaffId FROM clearance_approver as ca LEFT OUTER JOIN employmentdetail as e ON ca.position_id = e.position_id WHERE ca.active = 1 AND e.isCurrent = 1 AND e.status_id = 1 ORDER BY ca.id");
                                                                            foreach ($rows as $row) {
                                                                                $approverStaffId = $row['approverStaffId'];
                                                                                $sequence_no = $row['sequence_no'];
                                                                                $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $sequence_no, 'Pending', 'N/A', '$now_date', 0)";
                                                                                array_push($clearanceProcesses,$sql);
                                                                                $ctr++;
                                                                            }
                                                                            $sql_insert_clearance_approval_status = "INSERT INTO clearance_approval_status (clearance_id, clearance_process_id , staffId, approverStaffId, sequence_no, status, comment, dateUpdated, current_flag) VALUES ".implode(',',$clearanceProcesses);
                                                                            
                                                                            $insertClearance->executeSQL($sql_insert_clearance_approval_status);
                                                                            //Send email here to staff who filed it, to the HoS
                                                                            $cycle = new DbaseManipulation;
                                                                            $row = $cycle->singleReadFullQry("SELECT cp.name as currProcess, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as approverName 
                                                                            FROM clearance_approval_status as cas 
                                                                            LEFT OUTER JOIN clearance_process as cp ON cas.clearance_process_id = cp.id
                                                                            LEFT OUTER JOIN staff as s ON cas.approverStaffId = s.staffId 
                                                                            WHERE cas.current_flag = 1 AND clearance_id = $clearance_id");
                                                                            $cycle_status = 'For Approval of '.$row['currProcess'].' - '.$row['approverName'];

                                                                            $gsm = $helper->getContactInfo(1,$staffId,'data');
                                                                            $from_name = 'hrms@nct.edu.om';
                                                                            $from = 'HRMS - 3.0';
                                                                            $subject = 'NCT-HRMD CLEARANCE APPLICATION FILED BY '.strtoupper($logged_name);
                                                                            $message = '<html><body>';
                                                                            $message .= '<img src="http://apps1.nct.edu.om/hrmd3/img/hr-logo-email.png" width="419" height="65" />';
                                                                            $message .= "<h3>NCT-HRMS 3.0 CLEARANCE APPLICATION DETAILS</h3>";
                                                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>CLEARANCE STATUS:</strong> </td><td>Pending [On Process]</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$cycle_status."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>CLEARANCE TYPE:</strong> </td><td>Standard</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',time())."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$info['department']."</td></tr>";
                                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                            $message .= "</table>";
                                                                            $message .= "</body></html>";
                                                                            $emailParticipants = new sendMail;
                                                                            //print_r($to);
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
                                                                                    'requestNo'=>$requestNo,
                                                                                    'moduleName'=>'Clearance Application',
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
                                                                                    'requestNo'=>$requestNo,
                                                                                    'moduleName'=>'Clearance Application',
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
                                                                            }    
                                                                            ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    $('#myModal').modal('show');
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    $('#myModalError').modal('show');
                                                                                });
                                                                            </script>
                                                                            <?php
                                                                        }
                                                                    }
                                                                ?>
                                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                    <div class="form-group row">
                                                                        <?php 
                                                                            $requestNo = $helper->requestNo("CLR-","clearance");
                                                                        ?>
                                                                        <label class="col-sm-12 control-label"><h3 class="text-primary">Fill Out Survey Form &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3></label>
                                                                        <input type="hidden" name="requestNo" value="<?php echo $requestNo; ?>">
                                                                    </div>    
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <p class="text-primary">Feedback from staff plays a crucial role in developing and improving the working environment and the services provided by the college. We would appreciate your objective and honest opinions/suggestions regarding your work experience at the college. Your responses will be treated with total confidence.</p>
                                                                        </div>
                                                                    </div>    
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <div class="controls">
                                                                                        <span class="text-danger">*</span>A. What is/are the reason/s for leaving the college? Kindly tick the appropriate.
                                                                                        <fieldset>
                                                                                            <label class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" checked value="1" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                                                <span class="custom-control-label">1. Better Career Opportunity</span>
                                                                                            </label>
                                                                                        </fieldset>
                                                                                        <fieldset>
                                                                                            <label class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" value="2" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                                                <span class="custom-control-label">2. Better pay and Benefits</span>
                                                                                            </label>
                                                                                        </fieldset>
                                                                                        <fieldset>
                                                                                            <label class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" value="3" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                                                <span class="custom-control-label">3. Unsuitable Working Environment</span>
                                                                                            </label>
                                                                                        </fieldset>
                                                                                        <fieldset>
                                                                                            <label class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" value="4" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                                                <span class="custom-control-label">4. Conflict with Superiors</span>
                                                                                            </label>
                                                                                        </fieldset>
                                                                                        <fieldset>
                                                                                            <label class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" value="5" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                                                <span class="custom-control-label">5. Personal or/and Family reasons</span>
                                                                                            </label>
                                                                                        </fieldset>
                                                                                        <fieldset>
                                                                                            <label class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" value="6" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                                                <span class="custom-control-label">6. Problems with students and colleagues</span>
                                                                                            </label>
                                                                                        </fieldset>
                                                                                        <fieldset>
                                                                                            <label class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" value="7" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                                                <span class="custom-control-label">7. Others, please specify: <textarea name="aTick7Reason" class="form-control" rows="2"></textarea></span>
                                                                                            </label>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <div class="controls">
                                                                                        <span class="text-danger">*</span>B. Tick the appropriate for the following aspects in each table:
                                                                                        <div class="font-weight-bold">1. The Job</div>
                                                                                        <table class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>Aspects</th>
                                                                                                    <th>Poor</th>
                                                                                                    <th>Needs Further Improvement</th>
                                                                                                    <th>Good</th>
                                                                                                    <th>Excellent</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td class="text-left">1.</td>
                                                                                                    <td class="text-left">Induction program provided</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">2.</td>
                                                                                                    <td class="text-left">Job was challenging</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">3.</td>
                                                                                                    <td class="text-left">Matching with your qualifications and experiences</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">4.</td>
                                                                                                    <td class="text-left">Sufficient opportunities for advancement were given</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">5.</td>
                                                                                                    <td class="text-left">Your skills were effectively used</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">6.</td>
                                                                                                    <td class="text-left">Workload was manageable and fair</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">7.</td>
                                                                                                    <td class="text-left">Sufficient resources and staff were available</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">8.</td>
                                                                                                    <td class="text-left">Appropriate working conditions</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo8[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo8[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo8[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo8[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">9.</td>
                                                                                                    <td class="text-left">Your suggestions and opinions were listened and appreciated by your colleagues</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo9[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo9[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo9[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo9[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">10.</td>
                                                                                                    <td class="text-left">Adequate training and development programs provided</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo10[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo10[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo10[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo10[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">11.</td>
                                                                                                    <td class="text-left">Pay and Benefits</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo11[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo11[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo11[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo11[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">12.</td>
                                                                                                    <td class="text-left">Opportunities for award, promotion and recognition</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theJobRdo12[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theJobRdo12[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theJobRdo12[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theJobRdo12[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">13.</td>
                                                                                                    <td class="text-left">What do you think can be improved about this job?</td>
                                                                                                    <td class="text-left" colspan="4"><textarea name="theJobComment13" class="form-control" rows="2" required data-validation-required-message="Opinion to improved the job is required"></textarea></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <div class="controls">
                                                                                        <div class="font-weight-bold">2. The College (NCT)</div>
                                                                                        <table class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>Aspects</th>
                                                                                                    <th>Poor</th>
                                                                                                    <th>Needs Further Improvement</th>
                                                                                                    <th>Good</th>
                                                                                                    <th>Excellent</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td class="text-left">1.</td>
                                                                                                    <td class="text-left">Communication</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theCollegeRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theCollegeRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theCollegeRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theCollegeRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">2.</td>
                                                                                                    <td class="text-left">Work culture</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theCollegeRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theCollegeRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theCollegeRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theCollegeRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">3.</td>
                                                                                                    <td class="text-left">Policies and procedures</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theCollegeRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theCollegeRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theCollegeRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theCollegeRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">4.</td>
                                                                                                    <td class="text-left">Recognition of high performance</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theCollegeRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theCollegeRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theCollegeRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theCollegeRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">5.</td>
                                                                                                    <td class="text-left">College resources and facilities</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theCollegeRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theCollegeRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theCollegeRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theCollegeRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">6.</td>
                                                                                                    <td class="text-left">Staff relations</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theCollegeRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theCollegeRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theCollegeRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theCollegeRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">7.</td>
                                                                                                    <td class="text-left">What do you think can be improved by the college?</td>
                                                                                                    <td class="text-left" colspan="4"><textarea name="theCollegeComment7" class="form-control" rows="2" required data-validation-required-message="Opinion to improved the college is required"></textarea></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <div class="controls">
                                                                                        <div class="font-weight-bold">3. Your Supervisor</div>
                                                                                        <table class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>Aspects</th>
                                                                                                    <th>Poor</th>
                                                                                                    <th>Needs Further Improvement</th>
                                                                                                    <th>Good</th>
                                                                                                    <th>Excellent</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td class="text-left">1.</td>
                                                                                                    <td class="text-left">Cooperative</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theSupervisorRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theSupervisorRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theSupervisorRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theSupervisorRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">2.</td>
                                                                                                    <td class="text-left">A good communicator</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theSupervisorRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theSupervisorRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theSupervisorRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theSupervisorRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">3.</td>
                                                                                                    <td class="text-left">Provide constructive feedback</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theSupervisorRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theSupervisorRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theSupervisorRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theSupervisorRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">4.</td>
                                                                                                    <td class="text-left">Encourage teamwork and cooperation</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theSupervisorRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theSupervisorRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theSupervisorRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theSupervisorRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">5.</td>
                                                                                                    <td class="text-left">Problem solver</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theSupervisorRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theSupervisorRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theSupervisorRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theSupervisorRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">6.</td>
                                                                                                    <td class="text-left">Provide feedback on your appraisal</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theSupervisorRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theSupervisorRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theSupervisorRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theSupervisorRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">7.</td>
                                                                                                    <td class="text-left">What are the suggestions/opinions to your supervisor?</td>
                                                                                                    <td class="text-left" colspan="4"><textarea name="theSupervisorComment7" class="form-control" rows="2" required data-validation-required-message="Suggestions/opinions to your supervisor is required"></textarea></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <div class="controls">
                                                                                        <div class="font-weight-bold">4. The Management</div>
                                                                                        <table class="table table-bordered">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>Aspects</th>
                                                                                                    <th>Poor</th>
                                                                                                    <th>Needs Further Improvement</th>
                                                                                                    <th>Good</th>
                                                                                                    <th>Excellent</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td class="text-left">1.</td>
                                                                                                    <td class="text-left">Effectively communicated management decisions</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theManagementRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theManagementRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theManagementRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theManagementRdo1[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">2.</td>
                                                                                                    <td class="text-left">Give fair and equal treatment</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theManagementRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theManagementRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theManagementRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theManagementRdo2[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">3.</td>
                                                                                                    <td class="text-left">Available to discuss job related concerns and issues</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theManagementRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theManagementRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theManagementRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theManagementRdo3[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">4.</td>
                                                                                                    <td class="text-left">Encourage feedback and suggestions</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theManagementRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theManagementRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theManagementRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theManagementRdo4[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">5.</td>
                                                                                                    <td class="text-left">Provide development opportunities</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theManagementRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theManagementRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theManagementRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theManagementRdo5[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">6.</td>
                                                                                                    <td class="text-left">Maintained a professional relationship with you</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theManagementRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theManagementRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theManagementRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theManagementRdo6[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">7.</td>
                                                                                                    <td class="text-left">Cooperative</td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="1" name="theManagementRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="2" name="theManagementRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" value="3" name="theManagementRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <label class="custom-control custom-radio">
                                                                                                            <input type="radio" checked value="4" name="theManagementRdo7[]" class="custom-control-input">
                                                                                                            <span class="custom-control-label"></span>
                                                                                                        </label>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="text-left">8.</td>
                                                                                                    <td class="text-left">What are the suggestions/opinions to the management?</td>
                                                                                                    <td class="text-left" colspan="4"><textarea name="theManagementComment8" class="form-control" rows="2" required data-validation-required-message="Suggestions/opinions to the management is required"></textarea></td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-sm-12">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <div class="controls">
                                                                                        <div class="font-weight-bold">5. General Comments</div>
                                                                                        <table class="table table-bordered">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>1.</td>
                                                                                                    <td>In your opinion, what do you value the most and least about working at NCT?<br/>
                                                                                                    <textarea name="generalComment1" class="form-control" rows="2" required data-validation-required-message="Please provide an answer to the general comments" minlength="10"></textarea>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>2.</td>
                                                                                                    <td>What are the main challenges faced and suggestions for improvement?<br/>
                                                                                                    <textarea name="generalComment2" class="form-control" rows="2" required data-validation-required-message="Please provide an answer to the general comments" minlength="10"></textarea>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>3.</td>
                                                                                                    <td>Any additional comments/suggestions?<br/>
                                                                                                    <textarea name="generalComment3" class="form-control" rows="2" required data-validation-required-message="Please provide an answer to the general comments" minlength="10"></textarea>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row m-b-0">
                                                                        <div class="col-sm-9">
                                                                            <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Survey Form and Generate Clearance Application</button>
                                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                        </div>
                                                                    </div>
                                                                </form>    
                                                            </div>
                                                        </div>    
                                                        <div class="card-body">
                                                            <div class="message-box contact-box">
                                                                <div style="height:20px"></div>
                                                                <p>Please take note that upon submitting your clearance, a notification email will be sent to the following department/section to notify them that they need to Approve your clearance application.</p>
                                                                <p>The process of approval is <strong>IN NO PARTICULAR ORDER</strong> but still it is depend on the discretion of the approver if he will approve/reject your clearance application.</p>
                                                                <h4>Clearance Approvers:</h4>
                                                                <ul class="feeds">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <li>
                                                                                <div class="bg-primary"><i class="fas fa-clipboard-list text-white"></i></div> Staff Section Head <em><small>(if applicable)</small></em></span>
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-primary"><i class="fas fa-suitcase text-white"></i></div> Department Head
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-success"><i class="fas fa-box-open text-white"></i></div> Administrative Affairs
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-success"><i class="ti-shopping-cart text-white"></i></div> College Store
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-megna"><i class="far fa-money-bill-alt text-white"></i></div> Financial Affairs
                                                                            </li>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <li>
                                                                                <div class="bg-info"><i class="fa ti-server text-white"></i></div> HOS - Computer Services Section
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-info"><i class="ti-book text-white"></i></div> HOS - Library Section
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-info"><i class="ti-microsoft text-white"></i></div> HOC - Educational Technologies Centre
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-danger"><i class="fas fa-diagnoses text-white"></i> </div> HOD - Human Resource Department
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-danger"><i class="ti-wallet text-white"></i></div> Assistant Dean for Admin and Financial Affairs
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                ?>      
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                }
                                if(isset($_GET['stc'])) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header bg-light-yellow">
                                                    <h4 class="card-title font-weight-bold">Clearance Application Form</h4>
                                                    <div class="row">
                                                        <?php
                                                            $basic_info = new DBaseManipulation;
                                                            $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, s.gender, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.joinDate, n.name as nationality, q.name as qualification FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id WHERE s.staffId = '$staffId' AND e.isCurrent = 1 and e.status_id = 1");
                                                        ?>
                                                        <div class="col-lg-6">
                                                            <p class="m-b-0">Staff ID: <span class="text-primary"><?php echo $staffId; ?></span></p>
                                                            <p class="m-b-0">Staff Name: <span class="text-primary"><?php echo $info['staffName']; ?></span></p>
                                                            <p class="m-b-0">Department: <span class="text-primary"><?php echo $info['department']; ?></span></p>
                                                            <p class="m-b-0">Section: <span class="text-primary"><?php echo $info['section']; ?></span></p>
                                                            <p class="m-b-0">Job Title: <span class="text-primary"><?php echo $info['jobtitle']; ?></span></p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $info['sponsor']; ?></span></p>
                                                            <p class="m-b-0">Qualification: <span class="text-primary"><?php echo $info['qualification']; ?></span></p>
                                                            <p class="m-b-0">Join Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></p>
                                                            <p class="m-b-0">Nationality: <span class="text-primary"><?php echo $info['nationality']; ?></span></p>
                                                            <p class="m-b-0">Gender: <span class="text-primary"><?php echo $info['gender']; ?></span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                    $ifClearanceExist = new DbaseManipulation;
                                                    $rows = $ifClearanceExist->readData("SELECT * FROM clearance WHERE staffId = '$staffId' AND isCleared = 0");
                                                    if($ifClearanceExist->totalCount != 0) {
                                                        ?>
                                                        <div class="card-header bg-light-blue">
                                                            <label class="col-sm-12 control-label"><h3 class="text-danger"><i class='fa fa-exclamation-triangle'></i> The system found out that you still have pending clearance. You cannot file another one unless your pending clearance is cleared.</h3></label>
                                                        </div>
                                                        <?php    
                                                    } else { 
                                                        ?>
                                                        <div class="card-body">
                                                            <div class="card-header bg-light-blue">
                                                                <?php 
                                                                    if(isset($_POST['submit2'])) {                                                    
                                                                        $save = new DbaseManipulation;
                                                                        $requestNo = $_POST['requestNo'];
                                                                        $now_date = date('Y-m-d H:i:s');
                                                                        $sql_insert_clearance = "INSERT INTO clearance (requestNo, staffId, isCleared, dateCreated) VALUES ('$requestNo', '$staffId', 0, '$now_date')";
                                                                        $insertClearance = new DbaseManipulation;
                                                                        $insertClearance->executeSQL($sql_insert_clearance);
                                                                        $getIdInfo = new DbaseManipulation;    
                                                                        $lastId = $getIdInfo->singleReadFullQry("SELECT TOP 1 id FROM clearance ORDER BY id DESC");
                                                                        $clearance_id = $lastId['id'];
                                                                        $rows = $helper->readData("SELECT app.position_id, e.staff_id as approverStaffId FROM approvalsequence_standardleave as app LEFT OUTER JOIN employmentdetail as e ON app.approver_id = e.position_id WHERE app.position_id = $myPositionId AND app.is_final = 0 AND e.isCurrent = 1 AND e.status_id = 1");
                                                                        $clearanceProcesses = array();
                                                                        $to = array();
                                                                        if($helper->totalCount != 0) {
                                                                            if (count($rows) == 2) { //1. HoS > 2. HoD
                                                                                $ctr = 1;
                                                                                foreach ($rows as $row) {
                                                                                    $approverStaffId = $row['approverStaffId'];
                                                                                    if($ctr == 1) {
                                                                                        $approverEmailAdd = $helper->getContactInfo(2,$approverStaffId,'data');
                                                                                        array_push($to,$logged_in_email,$approverEmailAdd);
                                                                                        $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 1)";
                                                                                    } else {
                                                                                        $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 0)";
                                                                                    }    
                                                                                    array_push($clearanceProcesses,$sql);
                                                                                    $ctr++;
                                                                                }
                                                                            } else { //1. HoD or ADAA
                                                                                $ctr = 2;
                                                                                foreach ($rows as $row) {
                                                                                    $approverStaffId = $row['approverStaffId'];
                                                                                    if($ctr == 2) {
                                                                                        $approverEmailAdd = $helper->getContactInfo(2,$approverStaffId,'data');
                                                                                        array_push($to,$logged_in_email,$approverEmailAdd);
                                                                                        $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 1)";
                                                                                    } else {
                                                                                        $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $ctr, 'Pending', 'N/A', '$now_date', 0)";
                                                                                    }
                                                                                    array_push($clearanceProcesses,$sql);
                                                                                    $ctr++;
                                                                                }
                                                                            }
                                                                        }
                                                                        $rows = $helper->readData("SELECT ca.position_id, ca.sequence_no, e.staff_id as approverStaffId FROM clearance_approver as ca LEFT OUTER JOIN employmentdetail as e ON ca.position_id = e.position_id WHERE ca.active = 1 AND e.isCurrent = 1 AND e.status_id = 1 ORDER BY ca.id");
                                                                        foreach ($rows as $row) {
                                                                            $approverStaffId = $row['approverStaffId'];
                                                                            $sequence_no = $row['sequence_no'];
                                                                            $sql = "($clearance_id, $ctr, '$staffId', $approverStaffId, $sequence_no, 'Pending', 'N/A', '$now_date', 0)";
                                                                            array_push($clearanceProcesses,$sql);
                                                                            $ctr++;
                                                                        }
                                                                        $sql_insert_clearance_approval_status = "INSERT INTO clearance_approval_status (clearance_id, clearance_process_id , staffId, approverStaffId, sequence_no, status, comment, dateUpdated, current_flag) VALUES ".implode(',',$clearanceProcesses);
                                                                        
                                                                        $insertClearance->executeSQL($sql_insert_clearance_approval_status);
                                                                        //Send email here to staff who filed it, to the HoS
                                                                        $cycle = new DbaseManipulation;
                                                                        $row = $cycle->singleReadFullQry("SELECT cp.name as currProcess, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as approverName 
                                                                        FROM clearance_approval_status as cas 
                                                                        LEFT OUTER JOIN clearance_process as cp ON cas.clearance_process_id = cp.id
                                                                        LEFT OUTER JOIN staff as s ON cas.approverStaffId = s.staffId 
                                                                        WHERE cas.current_flag = 1 AND clearance_id = $clearance_id");
                                                                        $cycle_status = 'For Approval of '.$row['currProcess'].' - '.$row['approverName'];

                                                                        $gsm = $helper->getContactInfo(1,$staffId,'data');
                                                                        $from_name = 'hrms@nct.edu.om';
                                                                        $from = 'HRMS - 3.0';
                                                                        $subject = 'NCT-HRMD SHORT TERM CLEARANCE APPLICATION FILED BY '.strtoupper($logged_name);
                                                                        $message = '<html><body>';
                                                                        $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                        $message .= "<h3>NCT-HRMS 3.0 SHORT TERM CLEARANCE APPLICATION DETAILS</h3>";
                                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>CLEARANCE STATUS:</strong> </td><td>Pending [On Process]</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$cycle_status."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>CLEARANCE TYPE:</strong> </td><td>Short Term</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',time())."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$info['department']."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                        $message .= "</table>";
                                                                        $message .= "</body></html>";
                                                                        $emailParticipants = new sendMail;
                                                                        //print_r($to);
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
                                                                                'requestNo'=>$requestNo,
                                                                                'moduleName'=>'Short Term Clearance Application',
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
                                                                                'requestNo'=>$requestNo,
                                                                                'moduleName'=>'Short Term Clearance Application',
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
                                                                        }    
                                                                        ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModal2').modal('show');
                                                                            });
                                                                        </script>
                                                                        <?php
                                                                        
                                                                    }
                                                                ?>
                                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                    <div class="form-group row">
                                                                        <?php 
                                                                            $requestNo = $helper->requestNo("STC-","clearance");
                                                                        ?>
                                                                        <label class="col-sm-12 control-label"><h3 class="text-primary">Short Term Clearance ID: <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3></label>
                                                                        <input type="hidden" name="requestNo" value="<?php echo $requestNo; ?>">
                                                                    </div>    
                                                                    
                                                                    <div class="form-group row m-b-0">
                                                                        <div class="col-sm-9">
                                                                            <button type="submit" name="submit2" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit and Generate Short Term Clearance Application</button>
                                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                        </div>
                                                                    </div>
                                                                </form>    
                                                            </div>
                                                        </div>    
                                                        <div class="card-body">
                                                            <div class="message-box contact-box">
                                                                <div style="height:20px"></div>
                                                                <p>Please take note that upon submitting your short term clearance, a notification email will be sent to the following department/section to notify them that they need to Approve your clearance application.</p>
                                                                <p>The process of approval is <strong>IN NO PARTICULAR ORDER</strong> but still it is depend on the discretion of the approver if he will approve/reject your clearance application.</p>
                                                                <h4>Clearance Approvers:</h4>
                                                                <ul class="feeds">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <li>
                                                                                <div class="bg-primary"><i class="fas fa-clipboard-list text-white"></i></div> Staff Section Head <em><small>(if applicable)</small></em></span>
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-primary"><i class="fas fa-suitcase text-white"></i></div> Department Head
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-success"><i class="fas fa-box-open text-white"></i></div> Administrative Affairs
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-success"><i class="ti-shopping-cart text-white"></i></div> College Store
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-megna"><i class="far fa-money-bill-alt text-white"></i></div> Financial Affairs
                                                                            </li>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <li>
                                                                                <div class="bg-info"><i class="fa ti-server text-white"></i></div> HOS - Computer Services Section
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-info"><i class="ti-book text-white"></i></div> HOS - Library Section
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-info"><i class="ti-microsoft text-white"></i></div> HOC - Educational Technologies Centre
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-danger"><i class="fas fa-diagnoses text-white"></i> </div> HOD - Human Resource Department
                                                                            </li>
                                                                            <li>
                                                                                <div class="bg-danger"><i class="ti-wallet text-white"></i></div> Assistant Dean for Admin and Financial Affairs
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                ?>      
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }  
                            ?>            
                        </div>
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <div class="modal fade" id="modalClearanceType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-question-circle'></i> Confirm</h3>
                                <h5>What type of clearance do you want to file?</h5>
                                <div class="form-horizontal">
                                    <a href="?linkid=<?php echo $_GET['linkid']; ?>&sc=1" class="btn btn-primary"><i class='fa fa-file'></i> Standard Clearance</a>
                                    <a href="?linkid=<?php echo $_GET['linkid']; ?>&stc=2" class="btn btn-warning"><i class='fa fa-edit'></i> Short Term Clearance</a>
                                </div>
                                <br/>
                                <a href="index.php" class="btn btn-danger"><i class='fa fa-ban'></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>    

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Survey Form has been submitted successfully!</h5>
                                <h5>Clearance application has been generated by the system and it is now in process of approval.</h5>
                                <a href="index.php" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModalError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-danger" id="myModalLabel"><i class='fa fa-times'></i> Failure</h3>
                                <h5>An Error occured during processing.</h5>
                                <h5>Survey Form and Clearance application failed. Please contact ETC Department.</h5>
                                <a href="index.php" class="btn btn-danger"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Short term clearance has been submitted successfully!</h5>
                                <h5>Short term clearance application has been generated by the system and it is now in process of approval.</h5>
                                <a href="index.php" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
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