<?php    
    include('include_headers.php');
    $loggedInStaffId = $staffId;
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $dropdown = new DbaseManipulation;                        
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
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Add New Staff Record Entry Form</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">College Staff</li>
                                        <li class="breadcrumb-item active">Add New Staff</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-outline-info">
                                        <div class="card-header">
                                            <h4 class="m-b-0 text-white">Add New Staff Form <span style="float: right"><button class="btn btn-success btnShowAddNewStaffForm"><i class="fa fa-edit"></i> Start Entering New Staff Information</button></span></h4>
                                        </div>
                                        <div class="card-body">
                                            <?php 
                                                if(isset($_GET['nid'])){
                                                    $newStaffId = $_GET['nid'];
                                                } else {
                                                    $newStaffId = "";
                                                }   
                                            ?>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $save = new DbaseManipulation;
                                                    //"staff" Table First
                                                    $staffId = $save->cleanString($_POST['staffId']); //required
                                                    $civilId = $save->cleanString($_POST['civilId']); //required
                                                    $ministryStaffId = $save->cleanString($_POST['ministryStaffId']);
                                                    $salutation = $save->cleanString($_POST['salutation']); //required
                                                    $firstName = $save->cleanString($_POST['firstName']); //required
                                                    $secondName = $save->cleanString($_POST['secondName']);
                                                    $thirdName = $save->cleanString($_POST['thirdName']);
                                                    $lastName = $save->cleanString($_POST['lastName']); //required
                                                    $firstNameArabic = $save->cleanString($_POST['firstNameArabic']);
                                                    $secondNameArabic = $save->cleanString($_POST['secondNameArabic']);
                                                    $thirdNameArabic = $save->cleanString($_POST['thirdNameArabic']);
                                                    $lastNameArabic = $save->cleanString($_POST['lastNameArabic']);    
                                                    if(!empty($_POST['birthdate'])) {
                                                        $birthdate = $save->cleanString($_POST['birthdate']);
                                                        $birthdate = $save->mySQLDate($birthdate);
                                                    } else {
                                                        $birthdate = date("Y-m-d",time());
                                                    }    
                                                    $gender = $save->cleanString($_POST['gender']);
                                                    $joinDate = $save->cleanString($_POST['joinDate']);
                                                    $joinDate = $save->mySQLDate($joinDate);
                                                    $maritalStatus = $save->cleanString($_POST['maritalStatus']);
                                                    if(!empty($_POST['nationality_id'])) {
                                                        $nationality_id = $save->cleanString($_POST['nationality_id']);
                                                    } else {
                                                        $nationality_id = 194;
                                                    }
                                                    
                                                    
                                                    $created = date("Y-m-d H:i:s",time());
                                                    $gsm = $save->cleanString($_POST['gsm']); //required

                                                    //Create a validation here for staffId, civilId, ministryStaffId, GSM that already exist.
                                                    $IdChecker = new DbaseManipulation;
                                                    $IdChecker->singleReadFullQry("SELECT staffId FROM staff WHERE staffId = '$staffId'");
                                                    if($IdChecker->totalCount != 0) {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Saving Failed!</h4>
                                                            <p>Staff ID already exist! Kindly provide correct staff id. Staff ID must be <strong>unique.</strong></p>
                                                        </div>   
                                                        <?php            
                                                        goto hell;
                                                    }
                                                    $IdChecker->singleReadFullQry("SELECT civilId FROM staff WHERE civilId = '$civilId'");
                                                    if($IdChecker->totalCount != 0) {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Saving Failed!</h4>
                                                            <p>Civil ID already exist! Kindly provide correct civil id. Civil ID must be <strong>unique.</strong></p>
                                                        </div>   
                                                        <?php            
                                                        goto hell;
                                                    }
                                                    $IdChecker->singleReadFullQry("SELECT ministryStaffId FROM staff WHERE ministryStaffId = '$ministryStaffId' AND ministryStaffId != ''");
                                                    if($IdChecker->totalCount != 0) {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Saving Failed!</h4>
                                                            <p>Ministry Staff ID already exist! Kindly provide correct ministry staff id. Ministry Staff ID must be <strong>unique.</strong></p>
                                                        </div>   
                                                        <?php            
                                                        goto hell;
                                                    }
                                                    $IdChecker->singleReadFullQry("SELECT data FROM contactdetails WHERE data = '$gsm'");
                                                    if($IdChecker->totalCount != 0) {
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Saving Failed!</h4>
                                                            <p>GSM already exist! Kindly provide correct GSM. GSM must be <strong>unique.</strong></p>
                                                        </div>   
                                                        <?php            
                                                        goto hell;
                                                    }

                                                    $fieldsStaff = [
                                                        'staffId'=>$staffId,
                                                        'civilId'=>$civilId,
                                                        'ministryStaffId'=>$ministryStaffId,
                                                        'salutation'=>$salutation,
                                                        'firstName'=>$firstName,
                                                        'secondName'=>$secondName,
                                                        'thirdName'=>$thirdName,
                                                        'lastName'=>$lastName,
                                                        'firstNameArabic'=>$firstNameArabic,
                                                        'secondNameArabic'=>$secondNameArabic,
                                                        'thirdNameArabic'=>$thirdNameArabic,
                                                        'lastNameArabic'=>$lastNameArabic,
                                                        'birthdate'=>$birthdate,
                                                        'gender'=>$gender,
                                                        'joinDate'=>$joinDate,
                                                        'maritalStatus'=>$maritalStatus,
                                                        'nationality_id'=>$nationality_id
                                                    ];
                                                    $save->insert("staff",$fieldsStaff);
                                                    //End of "staff" Table
                                                    
                                                    //"employmentdetails" Table
                                                    $registrationCardNo = "";
                                                    $isCurrent = 1;
                                                    $status_id = $save->cleanString($_POST['status_id']);
                                                    $department_id = $save->cleanString($_POST['department_id']); //required
                                                    $section_id = $save->cleanString($_POST['section_id']);
                                                    $jobtitle_id = $save->cleanString($_POST['jobtitle_id']);
                                                    $sponsor_id = $save->cleanString($_POST['sponsor_id']);
                                                    $salarygrade_id = $save->cleanString($_POST['salarygrade_id']);
                                                    $employmenttype_id = $save->cleanString($_POST['employmenttype_id']);
                                                    $specialization_id = $save->cleanString($_POST['specialization_id']);
                                                    $qualification_id = $save->cleanString($_POST['qualification_id']);
                                                    $position_id = $save->cleanString($_POST['position_id']);
                                                    $position_category_id = $save->cleanString($_POST['position_category_id']);

                                                    $fieldsEmployment = [
                                                        'staff_id'=>$staffId,
                                                        'registrationCardNo'=>$registrationCardNo,
                                                        'joinDate'=>$joinDate,
                                                        'isCurrent'=>$isCurrent,
                                                        'status_id'=>$status_id,
                                                        'department_id'=>$department_id,
                                                        'section_id'=>$section_id,
                                                        'jobtitle_id'=>$jobtitle_id,
                                                        'sponsor_id'=>$sponsor_id,
                                                        'salarygrade_id'=>$salarygrade_id,
                                                        'employmenttype_id'=>$employmenttype_id,
                                                        'specialization_id'=>$specialization_id,
                                                        'qualification_id'=>$qualification_id,
                                                        'position_id'=>$position_id,
                                                        'position_category_id'=>$position_category_id
                                                    ];
                                                    $save->insert("employmentdetail",$fieldsEmployment);
                                                    //End of "employmentdetails" Table
                                                    
                                                    //"stafffamily" Table
                                                    $name = trim($firstName.' '.$secondName.' '.$thirdName.' '.$lastName);
                                                    $name = preg_replace('/\s+/', ' ', $name);
                                                    $relationship = "Staff";
                                                    $fieldsStaffFamily = [
                                                        'staffId'=>$staffId,
                                                        'civilId'=>$civilId,
                                                        'name'=>$name,
                                                        'relationship'=>$relationship,
                                                        'gender'=>$gender,
                                                        'birthdate'=>$birthdate
                                                    ];
                                                    $save->insert("stafffamily",$fieldsStaffFamily);
                                                    //End of "stafffamily" Table
                                                    
                                                    //"contactdetails" Table, saving only GSM since email address will be added on the TASK ACCOUNT CREATE.
                                                    $last_id = new DbaseManipulation;
                                                    $row_last_id = $last_id->singleReadFullQry("SELECT TOP 1 id FROM stafffamily ORDER BY id DESC");
                                                    $contacttype_id = 1;
                                                    $stafffamily_id = $row_last_id['id'];
                                                    $isCurrent = 'Y';
                                                    $isFamily = 'N';
                                                    $fieldsContactDetails = [
                                                        'staff_id'=>$staffId,
                                                        'contacttype_id'=>$contacttype_id,
                                                        'stafffamily_id'=>$stafffamily_id,
                                                        'data'=>$gsm,
                                                        'isCurrent'=>$isCurrent,
                                                        'isFamily'=>$isFamily
                                                    ];
                                                    $save->insert("contactdetails",$fieldsContactDetails);
                                                    //End of "contactdetails" Table
                                                    
                                                    //"users" Table
                                                    $username = $staffId;
                                                    $password = md5(1);
                                                    $fieldsUsers = [
                                                        'username'=>$username,
                                                        'password'=>$password,
                                                        'userType'=>6,
                                                        'status'=>1,
                                                        'created_by'=>$loggedInStaffId,
                                                        'created'=>date('Y-m-d H:i:s',time()),
                                                        'modified'=>date('Y-m-d H:i:s',time())
                                                    ];
                                                    $save->insert("users",$fieldsUsers);
                                                    //End of "users" Table


                                                    //5.0 Creating new task here
                                                        //5.1. Create a task process by inserting values in "taskprocess" table with currentServiceStatusId of 2
                                                            $request = new DbaseManipulation;
                                                            $requestNo = $request->requestNo("CRE-","taskprocess"); //CRE - CREate, taskType = 1 means Create New Task
                                                            $taskProcessStatus = 'On Process';
                                                            $currentServiceId = 2;
                                                            $currentService = 'Creating HR Staff Account';
                                                            $currentServiceStatus = 'Completed';
                                                            $taskType = 1;
                                                            $fieldsCreateTaskProcess = [
                                                                'requestNo'=>$requestNo,
                                                                'staff_id'=>$staffId,
                                                                'department_id'=>$department_id,
                                                                'taskProcessStatus'=>$taskProcessStatus,
                                                                'currentServiceId'=>$currentServiceId,
                                                                'currentService'=>$currentService,
                                                                'currentServiceStatus'=>$currentServiceStatus,
                                                                'started'=>$created,
                                                                'taskType'=>$taskType
                                                            ];
                                                            $save->insert("taskprocess", $fieldsCreateTaskProcess);
                                                        //End of 5.1
                                                    
                                                        //5.2 Create task process history ("taskprocesshistory" table) related to the taskprocess_id "taskprocess" table.
                                                            $taskprocess_last_id = $last_id->singleReadFullQry("SELECT TOP 1 id FROM taskprocess ORDER BY id DESC");
                                                            $taskprocess_id = $taskprocess_last_id['id'];
                                                            $task_id = 1;
                                                            $status = 'Completed';
                                                            $comments = 'HR Account has been created.';
                                                            $fieldsCreateTaskProcessHistory = [
                                                                'taskprocess_id'=>$taskprocess_id,
                                                                'task_id'=>$task_id,
                                                                'staff_id'=>$_SESSION['username'],
                                                                'transactionDate'=>$created,
                                                                'status'=>$status,
                                                                'comments'=>$comments
                                                            ];
                                                            $save->insert("taskprocesshistory", $fieldsCreateTaskProcessHistory);
                                                        //End of 5.2
                                                        
                                                        //5.3. Get staff basic info, email and of task approver with a task_id = 1 and 2 and put it in an array variable.
                                                            $getIdInfo = new DbaseManipulation;
                                                            $email_staffName = $name;
                                                            $email_department = $getIdInfo->fieldNameValue("department",$department_id,"name");
                                                            $getApproverEmail = new DbaseManipulation;
                                                            $rows1 = $getApproverEmail->readData("SELECT task_id, staff_id FROM taskapprover WHERE task_id = 1 AND status = 'Active'");
                                                            $to = array();
                                                            foreach($rows1 as $row1) {
                                                                array_push($to,$logged_in_email,$getIdInfo->getContactInfo(2,$row1['staff_id'],'data'));
                                                            }
                                                            $rows2 = $getApproverEmail->readData("SELECT task_id, staff_id FROM taskapprover WHERE department_id = $department_id AND task_id = 2 AND status = 'Active'");
                                                            foreach($rows2 as $row2) {
                                                                array_push($to,$getIdInfo->getContactInfo(2,$row2['staff_id'],'data'));
                                                            }
                                                        //End of 5.3
                                                        
                                                        //5.4. Get the history created in number 5.2, include this in the email you will send (using foreach) to each approver.
                                                            $taskProcessHistory = new DbaseManipulation;
                                                            $history = $taskProcessHistory->readData("SELECT * FROM taskprocesshistory WHERE taskprocess_id = $taskprocess_id ORDER BY id DESC");
                                                        //End of 5.4
                                                        
                                                        //5.5. Send an email to recipients.
                                                            $from_name = 'hrms@nct.edu.om';
                                                            $from = 'HRMS - 3.0';
                                                            $subject = 'NCT-HRMD ACCOUNT CREATION FOR '.strtoupper($email_staffName);
                                                            $d = '-';
                                                            $message = '<html><body>';
                                                            $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                            $message .= "<h3>A task has been assigned to you by the NCT. Click <a target='_blank' href='http://apps1.nct.edu.om:4443/hrmd3/task_add_account_details.php?id=".$staffId."&t=".$taskprocess_id."'>HERE</a> to access the system and provide action to your assigned task.</h3>";
                                                            $message .= "<h4>NOTE: If you have already created the account of the staff assigned to you, kindly disregard this email.</h4>";
                                                            $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION DETAILS AS FOLLOWS</h3>";
                                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>DATE STARTED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($created))."</td></tr>";
                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>TASK STATUS:</strong> </td><td>Started/On Process</td></tr>";
                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT TASK SERVICE:</strong> </td><td>For Assigning Section</td></tr>";
                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$email_staffName."</td></tr>";
                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                            $message .= "<tr style='background:#EFFBFB'><td><strong>JOINING DATE:</strong> </td><td>".date('d/m/Y',strtotime($joinDate))."</td></tr>";
                                                            $message .= "<tr style='background:#E0F8F7'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                            $message .= "</table>";
                                                            $message .= "<hr/>";
                                                            $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION HISTORIES</h3>";
                                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                            $message .= "<tr style='background:#F8E0E0'>";
                                                                $message .= "<th><strong>STAFF NAME</strong></th>";
                                                                $message .= "<th><strong>DATE/TIME</strong></th>";
                                                                $message .= "<th><strong>TASK LIST</strong></th>";
                                                                $message .= "<th><strong>NOTES/COMMENTS</strong></th>";
                                                                $message .= "<th><strong>STATUS</strong></th>";
                                                            $message .= "</tr>";
                                                            $ctr = 1; $stripeColor = "";	
                                                            foreach($history as $row){
                                                                if($ctr % 2 == 0) {
                                                                    $stripeColor = '#FBEFEF';
                                                                } else {
                                                                    $stripeColor = '#FBF2EF';
                                                                }
                                                                $fullStaffNameEmail = $getIdInfo->getStaffName($row['staff_id'],'firstName','secondName','thirdName','lastName');
                                                                $dateNotesEmail = date('d/m/Y H:i:s',strtotime($row['transactionDate']));
                                                                $taskListEmail = $getIdInfo->fieldNameValue("tasklist",$row['task_id'],'name');
                                                                $notesEmail = $row['comments'];
                                                                $statusEmail = $row['status'];
                                                                $message .= "
                                                                    <tr style='background:$stripeColor'>
                                                                        <td style='width:200px'>".$fullStaffNameEmail."</td>
                                                                        <td style='width:200px'>".$dateNotesEmail."</td>
                                                                        <td style='width:200px'>".$taskListEmail."</td>
                                                                        <td style='width:200px'>".$notesEmail."</td>
                                                                        <td style='width:200px'>".$statusEmail."</td>
                                                                    </tr>
                                                                ";
                                                                $ctr++;
                                                            }
                                                            $message .= "</table>";
                                                            $message .= "<br/>";
                                                            $message .= "</body></html>";
                                                            $emailRecipient = new sendMail;
                                                            $emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message);    
                                                        //End of 5.5
                                                    //End 5.0                                                                                                             
                                                        ?>
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                        <p>New staff has been added and saved! You may now provide different information related to the staff such as <strong>passport, visa, work experience,</strong> etc.</p>
                                                    </div>
                                                        <?php
                                                    hell: 
                                                } //end if isset submit

                                                // $request = new DbaseManipulation;
                                                // $requestNo = $request->requestNo("CRE-","taskprocess"); //CRE - CREate, taskType = 1 means Create New Task
                                                // echo $requestNo;
                                            ?>    
                                            <form class="form-horizontal" id="staff_add_new" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="row">
                                                    <!--First Column col-lg-4-->
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Title</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="salutation" class="form-control" required data-validation-required-message="Please select title">
                                                                            <option value="">Select Title</option>
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                            <option value="Ms.">Ms.</option>
                                                                            <option value="Dr.">Dr.</option>
                                                                        </select>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>First Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="firstName" class="form-control firstName" required data-validation-required-message="Please enter first name"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Second Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="secondName" class="form-control" />   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Third Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="thirdName" class="form-control"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Last Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="lastName" class="form-control" required data-validation-required-message="Please enter last name"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Arabic First Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="firstNameArabic" class="form-control" />   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Arabic Second Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="secondNameArabic" class="form-control" />   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Arabic Third Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="thirdNameArabic" class="form-control"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Arabic Last Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="lastNameArabic" class="form-control"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End First Column col-lg-4-->
                                                    
                                                    <!--Second Column col-lg-4-->
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Staff ID</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <!--<input type="text" name="staffId" id="staffIdCheck" value="<?php echo $newStaffId; ?>" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="7" onBlur="checkStaffId();" />-->
                                                                        <input type="text" name="staffId" id="staffIdCheck" value="<?php echo $newStaffId; ?>" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="7" onBlur="checkStaffId();" readonly />
                                                                        &nbsp;<a href="staff_generate_id.php" title="Generate Staff ID" class="btn btn-info"><i class="fa fa-plus"></i></a>&nbsp;
                                                                        <div id="staffIdChecker" style="font-weight:450; font-size:11px"></div>  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Civil ID</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="civilId" id="civilIdCheck" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="9" onBlur="checkCivilId();" />&nbsp;
                                                                        <div id="civilIdChecker" style="font-weight:450; font-size:11px"></div>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Ministry ID</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="ministryStaffId" id="ministryStaffIdCheck" class="form-control" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" onBlur="checkMinistryStaffId();" />&nbsp;
                                                                        <div id="ministryStaffIdChecker" style="font-weight:450; font-size:11px"></div>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Gender</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="gender" class="form-control">
                                                                            <option value="">Select Gender</option>
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Marital Status</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="maritalStatus" class="form-control">
                                                                            <option value="">Select Marital Status</option>
                                                                            <option value="Single">Single</option>
                                                                            <option value="Married">Married</option>
                                                                            <option value="Divorced">Divorced</option>
                                                                            <option value="Widowed">Widowed</option>

                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Nationality</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="nationality_id" class="form-control">
                                                                            <option value="">Select Nationality</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM nationality WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Birth Date</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text"  class="form-control" name="birthdate" id="birthday_date"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>GSM</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="gsm" id="gsmCheck" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="8" onBlur="checkGSM();" />&nbsp;
                                                                        <div id="GSMChecker" style="font-weight:450; font-size:11px"></div>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Email Address</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="email" class="form-control" data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})" data-validation-regex-message="Enter Valid Email" readonly>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Join Date</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <!--<input type="date"  class="form-control"/>   -->
                                                                        <input type="text" class="form-control" name="joinDate" id="join_date" required data-validation-required-message="Please enter joining date"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Second Column col-lg-4-->
                                                    
                                                    <!--Third Column col-lg-4-->    
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Department</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="department_id" class="form-control" required data-validation-required-message="Please select department">
                                                                            <option value="">Select Department</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM department WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Section</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="section_id" class="form-control">
                                                                            <option value="0">Select Section</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM section WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span> College Position</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="position_id" class="form-control" required data-validation-required-message="Please select college position">
                                                                            <option value="">Select College Position</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, code, title FROM staff_position WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Position Category</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="position_category_id" class="form-control">
                                                                            <option value="">Select Position Category</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM position_category WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Specialization</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="specialization_id" class="form-control">
                                                                            <option value="0">Select Specialization</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM specialization WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Job Title</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="jobtitle_id" class="form-control">
                                                                            <option value="0">Select Job Title</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM jobtitle WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Qualification</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="qualification_id" class="form-control">
                                                                            <option value="0">Select Qualification</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM qualification WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Sponsor</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="sponsor_id" class="form-control">
                                                                            <option value="0">Select Sponsor</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM sponsor WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Salary Grade</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="salarygrade_id" class="form-control">
                                                                            <option value="0">Select Salary Grade</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM salarygrade WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Employment</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="employmenttype_id" class="form-control">
                                                                            <!-- <option value="0">Select Employment</option> -->
                                                                            <option value="1">Full Time</option>
                                                                            <option value="2">Part Time</option>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Status</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="status_id" class="form-control">
                                                                            <!-- <option value="0">Select Status</option> -->
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM status WHERE active = 1 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                   
                                                        <div class="form-group m-b-0">
                                                            <div class="offset-sm-4 col-sm-8">
                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Third Column col-lg-4-->
                                                </div><!--end row for form-->  
                                            </form>
                                        </div><!--end card body-->
                                    </div><!--end card for outline-info--> 
                                </div>       
                            </div><!--end row for whole-->        
                        </div>            
                        <footer class="footer">
                            <?php
                                include('include_footer.php'); 
                            ?>
                        </footer>
                    </div>
                </div>
                
                <?php
                    include('include_scripts.php');
                ?>

                    <script>
                        // MAterial Date picker    
                        $('#birthday_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                        $('#join_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>