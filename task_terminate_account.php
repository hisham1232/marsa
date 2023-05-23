<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('Approver') || $helper->isAllowed('HoS') || $helper->isAllowed('HoD_HoC')) ? true : false;
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Deactivate Staff Account</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Account Task</li>
                                        <li class="breadcrumb-item">Deactivate Account</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <?php 
                                        if(isset($_POST['submitTerminate'])) {
                                            $save = new DbaseManipulation;
                                            $request_no = $save->cleanString($_POST['request_no']);
                                            $department_id = $save->cleanString($_POST['department_id']);
                                            $joinDate = $save->cleanString($_POST['joinDate']);
                                            $staff_id = $save->cleanString($_POST['staff_id']);
                                            $name = $save->cleanString($_POST['staff_name']);
                                            $new_status = $save->cleanString($_POST['new_status']);
                                            $reason = $save->cleanString($_POST['reason']);
                                            $created = date("Y-m-d H:i:s",time());
                                            if (!empty($_FILES['fileToUpload']['name'])) {
                                                $target_dir = "attachments/terminate_accounts/";
                                                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                $uploadOk = 1;
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
                                                        <p>File type and file size BOTH not acceptable. File type not accepted.</p>
                                                    </div>
                                                <?php        
                                                } else { //if everything is ok, try to upload file
                                                    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                    $extension = end($temp);
                                                    $new_file_name = $request_no.".".$extension;
                                                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/terminate_accounts/".$new_file_name)) {
                                                        $new_image = "attachments/terminate_accounts/".$new_file_name;
                                                        goto hell;
                                                ?>
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>Staff's HR Account has been deactivated! Staff's Account has been put in the Archive List.<br/>The system has already send request to ETC to deactivate all related <strong>e-service access, e-mail,</strong> etc.</p>
                                                        </div>
                                                <?php                
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
                                                //Create a new employment history where status will be the new status and isCurrent will be equal to 1, previous is zero
                                                $employment = new DbaseManipulation;
                                                $employment2 = new DbaseManipulation;
                                                $employment3 = new DbaseManipulation;

                                                $lId = $employment->singleReadFullQry("SELECT TOP 1 id FROM employmentdetail WHERE staff_id = $staff_id ORDER BY id DESC");
                                                $lastId = $lId['id'];
                                                $isCurrent = 0;
                                                $field = [
                                                    'isCurrent'=>$isCurrent
                                                ];
                                                $employment2->update("employmentdetail",$field,$lastId);

                                                $employment3->executeSQL("INSERT INTO employmentdetail (staff_id, registrationCardNo, joinDate, isCurrent, status_id, department_id, section_id, jobtitle_id, sponsor_id, salarygrade_id, employmenttype_id, specialization_id, qualification_id, position_id) SELECT staff_id, registrationCardNo, joinDate, 1, $new_status, department_id, section_id, jobtitle_id, sponsor_id, salarygrade_id, employmenttype_id, specialization_id, qualification_id, position_id FROM employmentdetail WHERE id = $lastId");
                                                
                                                //5.0 Creating new task deactivation here
                                                        //5.1. Create a task deactivation process by inserting values in "taskprocess" table with currentServiceStatusId of 2
                                                        $request = new DbaseManipulation;
                                                        $requestNo = $request->requestNo("DEA-","taskprocess"); //DEA - DEActivate, taskType = 0 means Deactivate Account
                                                        $taskProcessStatus = 'On Process';
                                                        $currentServiceId = 2;
                                                        $currentService = 'Deactivating HR Staff Account';
                                                        $currentServiceStatus = 'Completed';
                                                        $taskType = 0;
                                                        $fieldsCreateTaskProcess = [
                                                            'requestNo'=>$requestNo,
                                                            'staff_id'=>$staff_id,
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
                                                
                                                    //5.2 Create deactivate account task process history ("taskprocesshistory" table) related to the taskprocess_id "taskprocess" table.
                                                        $last_id = new DbaseManipulation;
                                                        $taskprocess_last_id = $last_id->singleReadFullQry("SELECT TOP 1 id FROM taskprocess ORDER BY id DESC");
                                                        $taskprocess_id = $taskprocess_last_id['id'];
                                                        $task_id = 1;
                                                        $status = 'Completed';
                                                        $comments = $reason;
                                                        $fieldsCreateTaskProcessHistory = [
                                                            'taskprocess_id'=>$taskprocess_id,
                                                            'task_id'=>$task_id,
                                                            'staff_id'=>$staffId,
                                                            'transactionDate'=>$created,
                                                            'status'=>$status,
                                                            'comments'=>$comments
                                                        ];
                                                        $save->insert("taskprocesshistory", $fieldsCreateTaskProcessHistory);
                                                    //End of 5.2
                                                    
                                                    //5.3. Get staff basic info, email of task approver with a task_id = 1,3,4,5 and put it in an array variable.
                                                        $getIdInfo = new DbaseManipulation;
                                                        $email_staffName = $name;
                                                        $gsm = $getIdInfo->getContactInfo(1,$staff_id,'data');
                                                        $email_department = $getIdInfo->fieldNameValue("department",$department_id,"name");
                                                        $getApproverEmail = new DbaseManipulation;
                                                        $rows = $getApproverEmail->readData("SELECT task_id, staff_id FROM taskapprover WHERE task_id IN (1,3,4,5) AND status = 'Active'");
                                                        $to = array();
                                                        foreach($rows as $row) {
                                                            array_push($to,$getIdInfo->getContactInfo(2,$row['staff_id'],'data'));
                                                        }
                                                    //End of 5.3
                                                    
                                                    //5.4. Get the history created in number 5.2, include this in the email you will send (using foreach) to each approver.
                                                        $taskProcessHistory = new DbaseManipulation;
                                                        $history = $taskProcessHistory->readData("SELECT * FROM taskprocesshistory WHERE taskprocess_id = $taskprocess_id");
                                                    //End of 5.4
                                                    
                                                    //5.5. Send an email to recipients.
                                                        $from_name = 'hrms@nct.edu.om';
                                                        $from = 'HRMS - 3.0';
                                                        $subject = 'NCT-HRMD ACCOUNT DEACTIVATION FOR STAFF';
                                                        $d = '-';
                                                        $message = '<html><body>';
                                                        $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hrdlogo_small.png" width="419" height="65" />';
                                                        $message .= "<h3>NCT-HRMS 3.0 ACCOUNT DEACTIVATION DETAILS AS FOLLOWS</h3>";
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
                                                        $message .= "<h3>NCT-HRMS 3.0 ACCOUNT DEACTIVATION HISTORIES</h3>";
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
                                                        <p>Staff's HR Account has been deactivated! Staff's Account has been put in the Archive List.<br/>The system has already send request to ETC to deactivate all related <strong>e-service access, e-mail,</strong> etc.</p>
                                                    </div>
                                        <?php        
                                            }       
                                        ?>
                                            
                                    <?php
                                        }
                                    ?>        
                                    <div class="card card-body">
                                        <h4 class="box-title m-b-0">1. Search Staff</h4>
                                        <div style="height:10px"></div>
                                        <span class="text-muted font-13 font-italic"><em>Select the staff you want to deactivate account.</em></span>
                                        <div style="height:10px"></div>
                                        <form class="form-horizontal m-b-0" action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label">Select Staff Name</label>
                                                <div class="col-sm-8">
                                                    <div class="controls">
                                                        <select name="staff_id" class="custom-select select2" required data-validation-required-message="Please select staff name">
                                                        <option value="">Select Staff Here</option>
                                                            <?php 
                                                                $staff = new DbaseManipulation;
                                                                $rows = $staff->readData($SQLActiveStaff);
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['staffId']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button name="submit" class="btn btn-success waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">2. Deactivate Account Form</h3>
                                                    <h6 class="card-subtitle font-italic">Complete the Deactivate Account Form and
                                                        click submit. Once Submitted : <br>1. Staff Account will be put on Archive
                                                        List <br>2. The system will send request to ETC to Deactivate all related
                                                        e-service access and e-mail.</h6>
                                                </div>
                                            </div>
                                            <?php
                                                if(isset($_POST['submit'])) {
                                                    $info = new DbaseManipulation;
                                                    $staff_id = $info->cleanString($_POST['staff_id']);
                                                    $result = $info->singleReadFullQry("SELECT s.id, s.staffId, s.civilId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, sp.name as sponsor, e.status_id, e.department_id, e.joinDate FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id WHERE s.staffId = '$staff_id'");

                                                    $request = new DbaseManipulation;
                                                    $requestNo = $request->requestNo("DEA-","taskprocess"); //DEA - DEActivate, taskType = 2 means Create Deactivation
                                            ?>
                                                    <form class="form-horizontal m-b-0" action="" method="POST" novalidate enctype="multipart/form-data">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Request Number</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="request_no" value="<?php echo $requestNo; ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Staff ID - Name</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="hidden" name="staff_id" value="<?php echo $result['staffId']; ?>" class="form-control" />
                                                                        <input type="hidden" name="staff_name" value="<?php echo $result['staffName']; ?>" class="form-control" />    
                                                                        <input type="hidden" name="department_id" value="<?php echo $result['department_id']; ?>" class="form-control" />
                                                                        <input type="hidden" name="joinDate" value="<?php echo $result['joinDate']; ?>" class="form-control" />    
                                                                        <input type="text" name="staff_id_name" value="<?php echo $result['staffId']." - ".$result['staffName']; ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Department</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="department" value="<?php echo $result['department']; ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-briefcase"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Section</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="section" value="<?php echo $result['section']; ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-flag-checkered"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Job Title</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="jobtitle" value="<?php echo $result['jobtitle']; ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-book"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Sponsor</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="sponsor" value="<?php echo $result['sponsor']; ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-clipboard-list"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label"><span class="text-danger">*</span>New Status</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="new_status" class="custom-select select2" required data-validation-required-message="Please select NEW Status of staff">
                                                                            <option value="">Select Status</option>
                                                                            <?php
                                                                                $dropdown = new DbaseManipulation; 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM status ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select>
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-question"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label"><span class="text-danger">*</span>Reason</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <textarea name="reason" class="form-control" required rows="2" required data-validation-required-message="Reasons is required" minlength="20" maxlength="500"></textarea>
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Attachment</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf, .gif" class="form-control">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-file-pdf"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Entered By</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="enteredBy" value="<?php echo $_SESSION['username']; ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 control-label">Date Entered</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="dateEntered" value="<?php echo date('d/m/Y H:i:s',time()); ?>" class="form-control" readonly />
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                        </div>                                        
                                                        <div class="form-group row m-b-0">
                                                            <div class="offset-sm-3 col-sm-9">
                                                                <button name="submitTerminate" type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                            <?php
                                                }
                                            ?>        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end container fluid-->

                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>    
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>