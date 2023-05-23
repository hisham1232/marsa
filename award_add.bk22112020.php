<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HoD_HoC')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
                 $logged_in_department_name = $helper->fieldNameValue("department",$logged_in_department_id,'name');
                 $isAcademic = $helper->fieldNameValue("department",$logged_in_department_id,'isAcademic');                            
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Employee of the Month Nomination</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Awarding </li>
                                        <li class="breadcrumb-item">Employee of the Month Nomination</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <?php 
                                $currentDate = date('d');
                                if($currentDate >= 20 && $currentDate <= 25) {
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-18">
                                            <div class="card">
                                                <div class="card-header bg-light-success" style="border-bottom: double; border-color: #28a745">
                                                    <h4 class="card-title font-weight-bold">Employee of the Month Nomination Form - Academic</h4>
                                                    <script>
                                                        if ( window.history.replaceState ) {
                                                            window.history.replaceState( null, null, window.location.href );
                                                        }
                                                    </script>
                                                    <?php 
                                                        if(isset($_POST['submitNonAcademic'])) {
                                                            if($_POST['criteria1'] > 10 || $_POST['criteria2'] > 10 || $_POST['criteria3'] > 10 || $_POST['criteria4'] > 10 || $_POST['criteria5'] > 10 || $_POST['criteria6'] > 10 || $_POST['criteria9'] > 10 || $_POST['criteria10'] > 10) {
                                                                ?>
                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Submit Failed!</h4>
                                                                    <p>You have entered an incorrect value for some of the criteria whose maximum value must only be 10. Please review your input scores.</p>
                                                                </div>
                                                                <?php
                                                            } else if($_POST['criteria7'] > 5 || $_POST['criteria8'] > 5 || $_POST['criteria11'] > 5 || $_POST['criteria12'] > 5) {
                                                                ?>
                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Submit Failed!</h4>
                                                                    <p>You have entered an incorrect value for some of the criteria whose maximum value must only be 5. Please review your input scores.</p>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                if(strlen($_POST['criteria1']) < 1 || strlen($_POST['criteria2']) < 1 || strlen($_POST['criteria3']) < 1 || strlen($_POST['criteria4']) < 1 || strlen($_POST['criteria5']) < 1 || strlen($_POST['criteria6']) < 1 || strlen($_POST['criteria7']) < 1 || strlen($_POST['criteria8']) < 1 || strlen($_POST['criteria9']) < 1 || strlen($_POST['criteria10']) < 1 || strlen($_POST['criteria11']) < 1 || strlen($_POST['criteria12']) < 1) {
                                                                    ?>
                                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Submit Failed!</h4>
                                                                        <p>All criteria are required to be filled out. Please provide values to all criteria.</p>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    //print_r($_POST);
                                                                    $trueStaffId = $helper->employmentFieldName($_POST['staff_id'],'staff_id');
                                                                    $fields = [
                                                                        'candidateId'=>$_POST['candidateId'],
                                                                        'staffId'=>$trueStaffId,
                                                                        'department_id'=>$_POST['department_id'],
                                                                        'isAcademic'=>0,
                                                                        'canYear'=>$_POST['canYear'],
                                                                        'canMonth'=>$_POST['canMonth'],
                                                                        'canStatus'=>$_POST['canStatus'],
                                                                        'score'=>$_POST['score'],
                                                                        'submittedBy'=>$staffId,
                                                                        'enteredDate'=>date('Y-m-d H:i:s',time())
                                                                    ];

                                                                    $save = new DbaseManipulation;
                                                                    if($save->insert("award_candidate",$fields)) {
                                                                        $getLast = new DbaseManipulation;
                                                                        $row = $getLast->singleReadFullQry("SELECT TOP 1 id FROM award_candidate ORDER BY id DESC");
                                                                        $award_candidate_id = $row['id'];
                                                                        $fieldsScoreNonAcademic = [
                                                                            'award_candidate_id'=>$award_candidate_id,
                                                                            'c1'=>$_POST['criteria1'],
                                                                            'c2'=>$_POST['criteria2'],
                                                                            'c3'=>$_POST['criteria3'],
                                                                            'c4'=>$_POST['criteria4'],
                                                                            'c5'=>$_POST['criteria5'],
                                                                            'c6'=>$_POST['criteria6'],
                                                                            'c7'=>$_POST['criteria7'],
                                                                            'c8'=>$_POST['criteria8'],
                                                                            'c9'=>$_POST['criteria9'],
                                                                            'c10'=>$_POST['criteria10'],
                                                                            'c11'=>$_POST['criteria11'],
                                                                            'c12'=>$_POST['criteria12'],
                                                                            'tscore'=>$_POST['score'],
                                                                            'comment'=>$helper->cleanString($_POST['notes'])
                                                                        ];
                                                                        if($save->insert("award_raw_score_nonacademic",$fieldsScoreNonAcademic)) {
                                                                            //Send an email here to ADAFA and HR-HoD...
                                                                            $to = array();
                                                                            $getStaff = new DbaseManipulation;
                                                                            $result = $getStaff->readData("SELECT staffId FROM staff WHERE staffId IN ('189010', '119084')");
                                                                            foreach($result as $row) {
                                                                                array_push($to,$getStaff->getContactInfo(2,$row['staffId'],'data'));
                                                                            }
                                                                            $from_name = 'hrms@nct.edu.om';
                                                                            $from = 'HRMS - 3.0';
                                                                            $subject = 'NCT-HRMD EMPLOYEE OF THE MONTH CANDIDATE HAS BEEN SUBMITTED';
                                                                            $d = '-';
                                                                            $message = '<html><body>';
                                                                            $message .= '<img src="http://apps1.nct.edu.om:4443/hrmd3/img/hr-logo-email.png" width="419" height="65" />';
                                                                            $message .= "<h3>NCT-HRMS 3.0</h3>";
                                                                            $message .= '<p>A candidate for employee of the month has been nominated and submitted in the system. Kindly login to the HR system to view more details.</p>';
                                                                            $message .= "</body></html>";
                                                                            $transactionDate = date('Y-m-d H:i:s',time());

                                                                            //Save Email Information in the system_emails table...
                                                                            $recipients = implode(', ', $to);
                                                                            $emailFields = [
                                                                                'requestNo'=>$_POST['candidateId'],
                                                                                'moduleName'=>'Awarding',
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
                                                                            ?>
                                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                <p>Nomination for the selected staff to be an employee of the month has been submitted.</p>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }     
                                                            }    
                                                        }


                                                        if(isset($_POST['submitAcademic'])) {
                                                            if($_POST['criteria1'] > 10 || $_POST['criteria2'] > 10 || $_POST['criteria4'] > 10 || $_POST['criteria7'] > 10 || $_POST['criteria8'] > 10 || $_POST['criteria10'] > 10) {
                                                                ?>
                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Submit Failed!</h4>
                                                                    <p>You have entered an incorrect value for some of the criteria whose maximum value must only be 10. Please review your input scores.</p>
                                                                </div>
                                                                <?php
                                                            } else if($_POST['criteria3'] > 5 || $_POST['criteria5'] > 5 || $_POST['criteria6'] > 5 || $_POST['criteria9'] > 5 || $_POST['criteria11'] > 5 || $_POST['criteria12'] > 5 || $_POST['criteria13'] > 5 || $_POST['criteria14'] > 5) {
                                                                ?>
                                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Submit Failed!</h4>
                                                                    <p>You have entered an incorrect value for some of the criteria whose maximum value must only be 5. Please review your input scores.</p>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                if(strlen($_POST['criteria1']) < 1 || strlen($_POST['criteria2']) < 1 || strlen($_POST['criteria3']) < 1 || strlen($_POST['criteria4']) < 1 || strlen($_POST['criteria5']) < 1 || strlen($_POST['criteria6']) < 1 || strlen($_POST['criteria7']) < 1 || strlen($_POST['criteria8']) < 1 || strlen($_POST['criteria9']) < 1 || strlen($_POST['criteria10']) < 1 || strlen($_POST['criteria11']) < 1 || strlen($_POST['criteria12']) < 1 || strlen($_POST['criteria13']) < 1 || strlen($_POST['criteria14']) < 1) {
                                                                    ?>
                                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Submit Failed!</h4>
                                                                        <p>All criteria are required to be filled out. Please provide values to all criteria.</p>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    //print_r($_POST);
                                                                    $trueStaffId = $helper->employmentFieldName($_POST['staff_id'],'staff_id');
                                                                    $fields = [
                                                                        'candidateId'=>$_POST['candidateId'],
                                                                        'staffId'=>$trueStaffId,
                                                                        'department_id'=>$_POST['department_id'],
                                                                        'isAcademic'=>1,
                                                                        'canYear'=>$_POST['canYear'],
                                                                        'canMonth'=>$_POST['canMonth'],
                                                                        'canStatus'=>$_POST['canStatus'],
                                                                        'score'=>$_POST['score'],
                                                                        'submittedBy'=>$staffId,
                                                                        'enteredDate'=>date('Y-m-d H:i:s',time())
                                                                    ];

                                                                    $save = new DbaseManipulation;
                                                                    if($save->insert("award_candidate",$fields)) {
                                                                        $getLast = new DbaseManipulation;
                                                                        $row = $getLast->singleReadFullQry("SELECT TOP 1 id FROM award_candidate ORDER BY id DESC");
                                                                        $award_candidate_id = $row['id'];
                                                                        $fieldsScoreAcademic = [
                                                                            'award_candidate_id'=>$award_candidate_id,
                                                                            'c1'=>$_POST['criteria1'],
                                                                            'c2'=>$_POST['criteria2'],
                                                                            'c3'=>$_POST['criteria3'],
                                                                            'c4'=>$_POST['criteria4'],
                                                                            'c5'=>$_POST['criteria5'],
                                                                            'c6'=>$_POST['criteria6'],
                                                                            'c7'=>$_POST['criteria7'],
                                                                            'c8'=>$_POST['criteria8'],
                                                                            'c9'=>$_POST['criteria9'],
                                                                            'c10'=>$_POST['criteria10'],
                                                                            'c11'=>$_POST['criteria11'],
                                                                            'c12'=>$_POST['criteria12'],
                                                                            'c13'=>$_POST['criteria13'],
                                                                            'c14'=>$_POST['criteria14'],
                                                                            'tscore'=>$_POST['score'],
                                                                            'comment'=>$helper->cleanString($_POST['notes'])
                                                                        ];
                                                                        if($save->insert("award_raw_score_academic",$fieldsScoreAcademic)) {
                                                                            //Send an email here to ADAFA and HR-HoD...
                                                                            $to = array();
                                                                            $getStaff = new DbaseManipulation;
                                                                            $result = $getStaff->readData("SELECT staffId FROM staff WHERE staffId IN ('189010', '119084')");
                                                                            foreach($result as $row) {
                                                                                array_push($to,$getStaff->getContactInfo(2,$row['staffId'],'data'));
                                                                            }
                                                                            $from_name = 'hrms@nct.edu.om';
                                                                            $from = 'HRMS - 3.0';
                                                                            $subject = 'NCT-HRMD EMPLOYEE OF THE MONTH CANDIDATE HAS BEEN SUBMITTED';
                                                                            $d = '-';
                                                                            $message = '<html><body>';
                                                                            $message .= '<img src="http://apps1.nct.edu.om:4443/hrmd3/img/hr-logo-email.png" width="419" height="65" />';
                                                                            $message .= "<h3>NCT-HRMS 3.0</h3>";
                                                                            $message .= '<p>A candidate for employee of the month has been nominated and submitted in the system. Kindly login to the HR system to view more details.</p>';
                                                                            $message .= "</body></html>";
                                                                            $transactionDate = date('Y-m-d H:i:s',time());

                                                                            //Save Email Information in the system_emails table...
                                                                            $recipients = implode(', ', $to);
                                                                            $emailFields = [
                                                                                'requestNo'=>$_POST['candidateId'],
                                                                                'moduleName'=>'Awarding',
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
                                                                            ?>
                                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                <p>Nomination for the selected staff to be an employee of the month has been submitted.</p>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }     
                                                            }    
                                                        }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-xs-18">
                                                            <form class="form-horizontal" action="" method="POST">
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label class="col-sm-3 control-label">Department</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" name="department_id" value="<?php echo $logged_in_department_id; ?>">
                                                                                <input type="hidden" name="isAcademic" value="<?php echo $isAcademic; ?>">
                                                                                <input type="text" class="form-control text-form-data-blue2" readonly value="<?php echo $logged_in_department_name; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-briefcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row  m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Staff</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <select class="custom-select select2 m-b-5 m-t-0 selectedId" name="staff_id" required data-validation-required-message="Please select staff">
                                                                                    <?php 
                                                                                        if(isset($_POST['staff_id'])) {
                                                                                            $realStaffId = $helper->employmentFieldName($_POST['staff_id'],'staff_id');
                                                                                            ?>
                                                                                            <option value="<?php echo $_POST['staff_id']; ?>"><?php echo $helper->getStaffName($realStaffId,'firstName','secondName','thirdName','lastName'); ?> </option>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <option value="">Select Staff Name </option>
                                                                                            <?php 
                                                                                        }    
                                                                                        ?>        
                                                                                        <?php 
                                                                                            $staffs = new DbaseManipulation;
                                                                                            $depts = new DbaseManipulation;
                                                                                            $rowsDepts = $depts->readData("SELECT * FROM award_staff WHERE position_id = $myPositionId");
                                                                                            if($depts->totalCount != 0) {
                                                                                                foreach ($rowsDepts as $rowDepts) {
                                                                                                    $deptAydi = $rowDepts['department_id'];
                                                                                                    $rows = $staffs->readData("SELECT e.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE e.status_id = 1 AND e.isCurrent = 1 AND e.department_id = $deptAydi");
                                                                                                    foreach ($rows as $row) {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                                                        <?php            
                                                                                                    } 
                                                                                                }
                                                                                            }
                                                                                            //Additional Staff from award_staff_additional table
                                                                                            $adds = new DbaseManipulation;
                                                                                            $rows = $adds->readData("SELECT e.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN award_staff_additional as a ON a.additional_staff_position_id = e.position_id WHERE e.status_id = 1 AND e.isCurrent = 1 AND a.position_id = $myPositionId");
                                                                                            if($adds->totalCount != 0) {
                                                                                                foreach ($rows as $row) {
                                                                                                    ?>
                                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                                                    <?php
                                                                                                }
                                                                                            }    
                                                                                        ?>     
                                                                                </select>
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
                                                                    <label  class="col-sm-3 control-label">Job Title</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control text-form-data-blue2 jobtitleName" readonly value="Job Title"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-file-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Month</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="hidden" name="canYear" value="<?php echo date('Y'); ?>">
                                                                                <input type="hidden" name="canMonth" value="<?php echo date('F'); ?>">
                                                                                <input type="text" class="form-control text-form-data-blue2" readonly value="<?php echo date('Y').' - '.date('F'); ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-calendar-alt"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>

                                                        <div class="col-lg-6 col-xs-18">
                                                            <?php 
                                                                $candidateId = new DbaseManipulation;
                                                                $canId = $candidateId->CandidateId("CAN-","award_candidate");
                                                            ?>
                                                            <div class="form-group row m-b-5 m-t-0">
                                                                <label  class="col-sm-3 control-label">Candidate ID</label>
                                                                <div class="col-sm-9">
                                                                    <div class="controls">
                                                                        <div class="input-group">
                                                                            <input type="text" name="candidateId" class="form-control text-form-data-blue2" readonly value="<?php echo $canId; ?>"> 
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon2">
                                                                                    <i class="fas fa-id-card"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row m-b-5 m-t-0">
                                                                <label  class="col-sm-3 control-label">Enter By</label>
                                                                <div class="col-sm-9">
                                                                    <div class="controls">
                                                                        <div class="input-group">
                                                                            <input type="hidden" name="enteredBy" value="<?php echo $staffId; ?>">
                                                                            <input type="text" class="form-control text-form-data-blue2" readonly value="<?php echo $logged_name; ?>"> 
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
                                                                <label  class="col-sm-3 control-label">Enter Date</label>
                                                                <div class="col-sm-9">
                                                                    <div class="controls">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control text-form-data-blue2" readonly value="<?php echo date('d/m/Y h:i:s'); ?>"> 
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon2">
                                                                                    <i class="far fa-calendar-alt"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row m-b-5 m-t-0">
                                                                <label  class="col-sm-3 control-label">Status</label>
                                                                <div class="col-sm-9">
                                                                    <div class="controls">
                                                                        <div class="input-group">
                                                                            <input type="text" name="canStatus" class="form-control text-form-data-blue2" readonly value="Recommended"> 
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="basic-addon2">
                                                                                    <i class="fas fa-info-circle"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <!-- 1. Check if this HoD had already submitted his candidate for the current Year and Month -->
                                                    <!-- 2. If yes, then don't display the form, instead display a message that he already chosen his candidate and provide some info like name and the score he had given -->
                                                    <?php
                                                        $currYear = date('Y');
                                                        $currMonth = date('F');
                                                        $check = new DbaseManipulation;
                                                        $row = $check->singleReadFullQry("SELECT TOP 1 * FROM award_candidate WHERE submittedBy = '$staffId' AND canYear = '$currYear' AND canMonth = '$currMonth'");
                                                        if($check->totalCount != 0) {
                                                            ?>
                                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Information</h4>
                                                                <p>You have already submitted your candidate for this month. Kindly refer to your My Recommendation List by clicking <a href="award_my_recommendation.php">HERE.</a></p>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            if($isAcademic == 0) { //Admins and Technicians
                                                                ?>
                                                                <div class="table-responsive">
                                                                    <table class="table color-bordered-table muted-bordered-table table-striped table-bordered" dir="rtl">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;" class="text-center">م</th>
                                                                                <th style="width: 70%;" class="text-center">البيان</th>
                                                                                <th style="width: 10%;" class="text-center">الدرجة الإجمالية</th>
                                                                                <th style="width: 15%;" class="text-center">الدرجة</th>
                                                                            </tr>    
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center">1</td>
                                                                                <td><p class="text-questions text-right">حجم ونوعية العمل<br>Size and Quality of work</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria1" name="criteria1" value="<?php echo $_POST['criteria1']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">2</td>
                                                                                <td><p class="text-questions text-right"> المبادرات والاقتراحات التي تسهم في تطوير العمل <br>Initiatives and suggestions that contribute to the development of work</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria2" name="criteria2" value="<?php echo $_POST['criteria2']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">3</td>
                                                                                <td><p class="text-questions text-right"> القدرة على التعلم والتطور والتطبيق<br>Ability to learn, develop, and apply</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria3" name="criteria3" value="<?php echo $_POST['criteria3']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">4</td>
                                                                                <td><p class="text-questions text-right">الدقة والسرعة في أداء العمل<br>Accuracy and speed of work performance</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria4" name="criteria4" value="<?php echo $_POST['criteria4']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">5</td>
                                                                                <td><p class="text-questions text-right">الالتزام بمواعيد العمل<br>Punctual</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria5" name="criteria5" value="<?php echo $_POST['criteria5']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">6</td>
                                                                                <td><p class="text-questions text-right">إتباع التعليمات<br>Comply to rules and regulations</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria6" name="criteria6" value="<?php echo $_POST['criteria6']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">7</td>
                                                                                <td><p class="text-questions text-right">المحافظة على اتباع السلوك الأمثل مع الزملاء والآخرين<br>Maintain optimal behavior with colleagues and others</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria7" name="criteria7" value="<?php echo $_POST['criteria7']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">8</td>
                                                                                <td><p class="text-questions text-right"> تحمل المسؤولية والقدرة على مواجهة الصعوبات<br>Take responsibility and ability to face challenges</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria8" name="criteria8" value="<?php echo $_POST['criteria8']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">9</td>
                                                                                <td><p class="text-questions text-right">الإلمام بالأنظمة والقوانين وقواعد السلامة ودرجة التقيد بها<br>Familiarity with regulations, laws and safety rules and their degree of compliance</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria9" name="criteria9" value="<?php echo $_POST['criteria9']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">10</td>
                                                                                <td><p class="text-questions text-right">التعاون مع الزملاء<br>Cooperative with colleagues</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria10" name="criteria10" value="<?php echo $_POST['criteria10']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">11</td>
                                                                                <td><p class="text-questions text-right"> مدى تقبل التوجيه والإرشاد <br>Acceptance of guidance and consultancy</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria11" name="criteria11" value="<?php echo $_POST['criteria11']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">12</td>
                                                                                <td><p class="text-questions text-right"> الإهتمام بالنظافة وحسن المظهر<br>Good Appearance</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria12" name="criteria12" value="<?php echo $_POST['criteria12']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScore()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2"><p class="text-questions text-right">إجمالي الدرجات Total</p></td>
                                                                                <td class="text-center text-primary">100</td>
                                                                                <td class="text-center"><p class="text-questions text-right"><input type="text" id="totalCriteria" name="score" value="<?php echo $_POST['totalCriteria']; ?>" class="form-control" readonly></p></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="1"><p class="text-questions text-right">Comments/Notes</p></td>
                                                                                <td colspan="3" class="text-center">
                                                                                    <textarea class="form-control" name="notes" id="notes" rows="4" required><?php echo $_POST['notes']; ?></textarea>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xs-18">               
                                                                        <div class="text-xs-right">
                                                                            <button type="submit" name="submitNonAcademic" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php 
                                                            } else { //Academic Departments
                                                                ?>
                                                                <div class="table-responsive">
                                                                    <table class="table color-bordered-table muted-bordered-table table-striped table-bordered" dir="rtl">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;" class="text-center">م</th>
                                                                                <th style="width: 70%;" class="text-center">البيان</th>
                                                                                <th style="width: 10%;" class="text-center">الدرجة الإجمالية<</th>
                                                                                <th style="width: 15%;" class="text-center">الدرجة</th>
                                                                            </tr>    
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center">1</td>
                                                                                <td><p class="text-questions text-right"> جودة التدريس<br>Quality of teaching</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria1" name="criteria1" value="<?php echo $_POST['criteria1']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">2</td>
                                                                                <td><p class="text-questions text-right">أنشطة البحث العلمي<br>Research and scholarly activity</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria2" name="criteria2" value="<?php echo $_POST['criteria2']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">3</td>
                                                                                <td><p class="text-questions text-right">   الإرشاد والتوجيه الطلابي <br>Student’s Advising</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria3" name="criteria3" value="<?php echo $_POST['criteria3']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">4</td>
                                                                                <td><p class="text-questions text-right">  الخدمات التي قدمها للمؤسسة  <br>Service to the department/college</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria4" name="criteria4" value="<?php echo $_POST['criteria4']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">5</td>
                                                                                <td><p class="text-questions text-right"> الخدمات التي قدمها للمجتمع<br>Service to the community</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria5" name="criteria5" value="<?php echo $_POST['criteria5']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">6</td>
                                                                                <td><p class="text-questions text-right"> المبادرات والافتراحات التي تسهم في تطوير العمل <br>Initiatives and suggestions that contribute to the development of work</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria6" name="criteria6" value="<?php echo $_POST['criteria6']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">7</td>
                                                                                <td><p class="text-questions text-right">القدرة على التعلم والتطور والتطبيق <br>Ability to learn, develop, and apply</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria7" name="criteria7" value="<?php echo $_POST['criteria7']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">8</td>
                                                                                <td><p class="text-questions text-right">   الدقة والسرعة في أداء العمل <br>Accuracy and speed to work performance</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria8" name="criteria8" value="<?php echo $_POST['criteria8']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">9</td>
                                                                                <td><p class="text-questions text-right"> الالتزام بمواعيد العمل <br>Punctuality</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria9" name="criteria9" value="<?php echo $_POST['criteria9']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">10</td>
                                                                                <td><p class="text-questions text-right"> الإلتزام بالقوانين والأنظمة  <br>Comply to rules and regulations</p></td>
                                                                                <td class="text-center text-primary">10</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria10" name="criteria10" value="<?php echo $_POST['criteria10']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">11</td>
                                                                                <td><p class="text-questions text-right">  المحافظة على اتباع السلوك الأمثل مع الزملاء والآخرين <br>Maintain optimal behavior with colleagues and others</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria11" name="criteria11" value="<?php echo $_POST['criteria11']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">12</td>
                                                                                <td><p class="text-questions text-right"> تحمل المسؤولية والقدرة على مواجهة الصعوبات <br>Ownership and Accountability</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria12" name="criteria12" value="<?php echo $_POST['criteria12']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">13</td>
                                                                                <td><p class="text-questions text-right"> مدى تقبل التوجيه والإرشاد  <br>Acceptance of guidance and consultancy</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria13" name="criteria13" value="<?php echo $_POST['criteria13']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">14</td>
                                                                                <td><p class="text-questions text-right"> الإهتمام بالنظافة وحسن المظهر  <br>Good Appearance</p></td>
                                                                                <td class="text-center text-primary">5</td>
                                                                                <td class="text-center">
                                                                                    <div class="form-group">
                                                                                        <div class="controls">
                                                                                            <input type="text" id="criteria14" name="criteria14" value="<?php echo $_POST['criteria14']; ?>" class="form-control" onKeyPress="return isNumberKey(event)" onfocusout="computeScoreAcademic()" maxlength="2">
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2"><p class="text-questions text-right">إجمالي الدرجات Total</p></td>
                                                                                <td class="text-center text-primary">100</td>
                                                                                <td class="text-center"><p class="text-questions text-right"><input type="text" id="totalCriteria" name="score" value="<?php echo $_POST['totalCriteria']; ?>" class="form-control" readonly></p></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="1"><p class="text-questions text-right">Comments/Notes</p></td>
                                                                                <td colspan="3" class="text-center">
                                                                                    <textarea class="form-control" name="notes" id="notes" rows="4" required><?php echo $_POST['notes']; ?></textarea>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xs-18">               
                                                                        <div class="text-xs-right">
                                                                            <button type="submit" name="submitAcademic" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }        
                                                    ?>        
                                                </div><!--end card body main-->
                                            </form><!--end form-->
                                            </div><!--end card-->            
                                        </div><!--end col-lg-12-->
                                    </div><!--end row-->
                                <?php 
                                } else {
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-18">
                                            <div class="card">
                                                <div class="card-header bg-light-danger" style="border-bottom: double; border-color: #28a745">
                                                    <h4 class="card-title font-weight-bold">Nomination is not yet open. Nomination will be open from 20th till 25th of this month.</h4>
                                                </div>
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
                <script>
                    $(".selectedId").change(function() {
                        var selectedId = $('.selectedId').val();
                        var data = {
                            id : selectedId
                        }
                        $.ajax({
                             url     : 'ajaxpages/awarding/jobtitle.php'
                            ,type    : 'POST'
                            ,dataType: 'json'
                            ,data    : data
                            ,success : function(e){
                                $(".jobtitleName").val(e.jobtitle);
                            }
                            ,error  : function(e){
                            }
                        });
                    });
                    function isNumberKey(evt){
                        var charCode = (evt.which) ? evt.which : event.keyCode;
                        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                            return false;
                        } else {
                            return true;   
                        }
                    }
                    function computeScore(){
                        var criteria1 = $('#criteria1').val();
                        var criteria2 = $('#criteria2').val();
                        var criteria3 = $('#criteria3').val();
                        var criteria4 = $('#criteria4').val();
                        var criteria5 = $('#criteria5').val();
                        var criteria6 = $('#criteria6').val();
                        var criteria7 = $('#criteria7').val();
                        var criteria8 = $('#criteria8').val();
                        var criteria9 = $('#criteria9').val();
                        var criteria10 = $('#criteria10').val();
                        var criteria11 = $('#criteria11').val();
                        var criteria12 = $('#criteria12').val();
                        var ts = (+criteria1) + (+criteria2) + (+criteria3) + (+criteria4) + (+criteria5) + (+criteria6) + (+criteria7) + (+criteria8) + (+criteria9) + (+criteria10) + (+criteria11) + (+criteria12);
                        document.getElementById('totalCriteria').value = ts;
                        //document.getElementById('ts').value = ts;
                    }
                    function computeScoreAcademic(){
                        var criteria1 = $('#criteria1').val();
                        var criteria2 = $('#criteria2').val();
                        var criteria3 = $('#criteria3').val();
                        var criteria4 = $('#criteria4').val();
                        var criteria5 = $('#criteria5').val();
                        var criteria6 = $('#criteria6').val();
                        var criteria7 = $('#criteria7').val();
                        var criteria8 = $('#criteria8').val();
                        var criteria9 = $('#criteria9').val();
                        var criteria10 = $('#criteria10').val();
                        var criteria11 = $('#criteria11').val();
                        var criteria12 = $('#criteria12').val();
                        var criteria13 = $('#criteria13').val();
                        var criteria14 = $('#criteria14').val();
                        var ts = (+criteria1) + (+criteria2) + (+criteria3) + (+criteria4) + (+criteria5) + (+criteria6) + (+criteria7) + (+criteria8) + (+criteria9) + (+criteria10) + (+criteria11) + (+criteria12) + (+criteria13) + (+criteria14);
                        document.getElementById('totalCriteria').value = ts;
                        //document.getElementById('ts').value = ts;
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