<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['id']) && isset($_GET['t'])) {
                $id = $_GET['t'];
                $staff_id = $_GET['id'];
                $staff = new DbaseManipulation;
                $result = $staff->singleReadFullQry("SELECT s.id, s.staffId, s.civilId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, sp.name as sponsor, e.status_id, e.joinDate FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id WHERE s.staffId = '$staff_id' AND e.status_id = 1 and e.isCurrent = 1");
                $mobile = $staff->getContactInfo(1,$staff_id,'data');
                $email_add = $staff->getContactInfo(2,$staff_id,'data');

                $task = new DbaseManipulation;
                $taskRow = $task->singleRead("taskprocess",$id);
                $id_taskprocess = $taskRow['currentServiceId'];
                $requestNo = $taskRow['requestNo'];
                $started = $taskRow['started'];
                $taskStatus = $taskRow['taskProcessStatus'];
                $department_id = $taskRow['department_id'];
                //echo '-----------------------------------------------------'.$logged_in_email;

            } else {
                header("Location: task_add_new_account_list.php");
            }                                
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Create Account Task Details <?php //echo $department_id; ?></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Account Task</li>
                                        <li class="breadcrumb-item">Create Account Details</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <!--Will do all the submit action here until sending of emails to those staff involve in the task assigned-->
                            <?php
                                if(isset($_POST['submitSection'])) {
                                    $taskId = 2;
                                    if($id_taskprocess != $taskId) {
                                        header("Location: task_add_new_account_list.php");
                                    } else {
                                        $assignSection = new DbaseManipulation;
                                        $section_id = $assignSection->cleanString($_POST['section_id']);
                                        $comment = $assignSection->cleanString($_POST['comment']);
                                        $empId = $assignSection->employmentIDs($staff_id,'id');
                                        $fields = [
                                            'section_id'=>$section_id
                                        ];
                                        if($assignSection->update("employmentdetail",$fields,$empId)) {
                                            $id = $_GET['t'];
                                            $updateTask = new DbaseManipulation;
                                            $fields = [
                                                'currentService'=>'Assigning Section',
                                                'currentServiceId'=>'3'
                                            ];
                                            if($updateTask->update("taskprocess",$fields,$id)) {
                                                $taskprocess_id = $_GET['t'];
                                                $transactionDate = date("Y-m-d H:i:s",time());
                                                $fields = [
                                                    'taskprocess_id'=>$taskprocess_id,
                                                    'task_id'=>'2',
                                                    'staff_id'=>$staffId,
                                                    'transactionDate'=>$transactionDate,
                                                    'status'=>'Completed',
                                                    'comments'=>$comment
                                                ];
                                                if($updateTask->insert("taskprocesshistory",$fields)){
                                                    //History Dito
                                                    $history = $task->readData("SELECT * FROM taskprocesshistory WHERE taskprocess_id = $taskprocess_id ORDER BY id DESC");
                                                    //Email Dito
                                                    $to = array();
                                                    array_push($to,$logged_in_email);

                                                    //$rowsNextApprover = $task->readData("SELECT task_id, staff_id FROM taskapprover WHERE department_id = $department_id AND task_id = 3 AND status = 'Active'");
                                                    $rowsNextApprover = $task->readData("SELECT task_id, staff_id FROM taskapprover WHERE task_id = 3 AND status = 'Active'");
                                                    foreach($rowsNextApprover as $rowNextApprover) {
                                                        array_push($to,$staff->getContactInfo(2,$rowNextApprover['staff_id'],'data'));
                                                    }
                                                    $email_staffName = $result['staffName'];
                                                    $email_department = $task->fieldNameValue("department",$department_id,"name");
                                                    $joinDate = $result['joinDate'];
                                                    $gsm = $mobile;
                                                    $from_name = 'hrms@nct.edu.om';
                                                    $from = 'HRMS - 3.0';
                                                    $subject = 'NCT-HRMD ACCOUNT CREATION FOR '.strtoupper($email_staffName);
                                                    $d = '-';
                                                    $message = '<html><body>';
                                                    $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                    $message .= "<h3>A task has been assigned to you by the NCT. Click <a target='_blank' href='http://apps1.nct.edu.om:4443/hrmd3/task_add_account_details.php?id=".$staff_id."&t=".$taskprocess_id."'>HERE</a> to access the system and provide action to your assigned task.</h3>";
                                                    $message .= "<h4>NOTE: If you have already created the account of the staff assigned to you, kindly disregard this email.</h4>";
                                                    $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION DETAILS AS FOLLOWS</h3>";
                                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DATE STARTED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($started))."</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>TASK STATUS:</strong> </td><td>Started/On Process</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT TASK SERVICE:</strong> </td><td>For Creating Email Account</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
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
                                                        $getIdInfo = new DbaseManipulation;
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
                                                    if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)) {
                                                        //Save Email Information in the database...
                                                        $recipients = implode(', ', $to);    
                                                        $emailFields = [
                                                            'requestNo'=>$requestNo,
                                                            'moduleName'=>'Create Account - Assign Section',
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
                                                        //Ends...
                                                    } else {
                                                        //Save Email Information in the database...
                                                        $recipients = implode(', ', $to);    
                                                        $emailFields = [
                                                            'requestNo'=>$requestNo,
                                                            'moduleName'=>'Create Account - Assign Section',
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
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                        <p>Section has been assigned to the staff successfully. Next Task: <strong>Creating Email Account</strong> has been forwarded to the next staff in charge.</p>
                                                    </div>    
                            <?php                    
                                                }
                                            }
                                        }
                                    }    
                                }
                            ?>
                            <?php
                                if(isset($_POST['submitEmail'])) {
                                    $taskId = 3;
                                    if($id_taskprocess != $taskId) {
                                        header("Location: task_add_new_account_list.php");
                                    } else {
                                        $createEmail = new DbaseManipulation;
                                        $email = $createEmail->cleanString($_POST['email_address']);
                                        $comment = $createEmail->cleanString($_POST['comment']);
                                        $empId = $createEmail->employmentIDs($staff_id,'id');
                                        $stafffamily_id = $createEmail->staffFamilyIDs($staff_id,'Staff','id');
                                        $fields = [
                                            'staff_id'=>$staff_id,
                                            'contacttype_id'=>2,
                                            'stafffamily_id'=>$stafffamily_id,
                                            'data'=>$email,
                                            'isCurrent'=>'Y',
                                            'isFamily'=>'N'
                                        ];
                                        
                                        if($createEmail->insert("contactdetails",$fields)) {
                                            
                                            $id = $_GET['t'];
                                            $updateTask = new DbaseManipulation;
                                            $fields = [
                                                'currentService'=>'Creating Email Account',
                                                'currentServiceId'=>'4'
                                            ];
                                            if($updateTask->update("taskprocess",$fields,$id)) {
                                                $taskprocess_id = $_GET['t'];
                                                $transactionDate = date("Y-m-d H:i:s",time());
                                                $fields = [
                                                    'taskprocess_id'=>$taskprocess_id,
                                                    'task_id'=>'3',
                                                    'staff_id'=>$staffId,
                                                    'transactionDate'=>$transactionDate,
                                                    'status'=>'Completed',
                                                    'comments'=>$comment
                                                ];
                                                if($updateTask->insert("taskprocesshistory",$fields)){
                                                    //History Dito
                                                    $history = $task->readData("SELECT * FROM taskprocesshistory WHERE taskprocess_id = $taskprocess_id ORDER BY id DESC");
                                                    //Email Dito
                                                    $to = array();                                                    
                                                    $rowsNextApprover = $task->readData("SELECT task_id, staff_id FROM taskapprover WHERE task_id = 4 AND status = 'Active'");
                                                    foreach($rowsNextApprover as $rowNextApprover) {
                                                        array_push($to,$staff->getContactInfo(2,$rowNextApprover['staff_id'],'data'));
                                                    }
                                                    //echo "SELECT task_id, staff_id FROM taskapprover WHERE task_id = 4 AND status = 'Active'";
                                                    array_push($to,$logged_in_email);
                                                    //print_r($to); exit;
                                                    $email_staffName = $result['staffName'];
                                                    $email_department = $task->fieldNameValue("department",$department_id,"name");
                                                    $joinDate = $result['joinDate'];
                                                    $gsm = $mobile;
                                                    $from_name = 'hrms@nct.edu.om';
                                                    $from = 'HRMS - 3.0';
                                                    $subject = 'NCT-HRMD ACCOUNT CREATION FOR '.strtoupper($email_staffName);
                                                    $d = '-';
                                                    $message = '<html><body>';
                                                    $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                    $message .= "<h3>A task has been assigned to you by the NCT. Click <a target='_blank' href='http://apps1.nct.edu.om:4443/hrmd3/task_add_account_details.php?id=".$staff_id."&t=".$taskprocess_id."'>HERE</a> to access the system and provide action to your assigned task.</h3>";
                                                    $message .= "<h4>NOTE: If you have already created the account of the staff assigned to you, kindly disregard this email.</h4>";
                                                    $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION DETAILS AS FOLLOWS</h3>";
                                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DATE STARTED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($started))."</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>TASK STATUS:</strong> </td><td>Started/On Process</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT TASK SERVICE:</strong> </td><td>For Creating Active Directory Account</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$email_staffName."</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>JOINING DATE:</strong> </td><td>".date('d/m/Y',strtotime($joinDate))."</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email."</td></tr>";
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
                                                        $getIdInfo = new DbaseManipulation;
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
                                                    if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)) {
                                                        //Save Email Information in the database...
                                                        $recipients = implode(', ', $to);    
                                                        $emailFields = [
                                                            'requestNo'=>$requestNo,
                                                            'moduleName'=>'Create Account - Create Email Account',
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
                                                        //Ends...
                                                    } else {
                                                        //Save Email Information in the database...
                                                        $recipients = implode(', ', $to);    
                                                        $emailFields = [
                                                            'requestNo'=>$requestNo,
                                                            'moduleName'=>'Create Account - Create Email Account',
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
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                        <p>Email account has been created successfully. Next Task: <strong>Creating Active Directory Account</strong> has been forwarded to the next staff in charge.</p>
                                                    </div>    
                            <?php                    
                                                }
                                            }
                                        }
                                    }    
                                }
                            ?>
                            <?php
                                if(isset($_POST['submitActiveDirectory'])) {
                                    $taskId = 4;
                                    if($id_taskprocess != $taskId) {
                                        header("Location: task_add_new_account_list.php");
                                    } else {
                                        $createEmail = new DbaseManipulation;
                                        $comment = $createEmail->cleanString($_POST['comment']);
                                        
                                        $id = $_GET['t'];
                                        $updateTask = new DbaseManipulation;
                                        $fields = [
                                            'currentService'=>'Creating User Accounts to NCT Apps',
                                            'currentServiceId'=>'5'
                                        ];
                                        if($updateTask->update("taskprocess",$fields,$id)) {
                                            $taskprocess_id = $_GET['t'];
                                            $transactionDate = date("Y-m-d H:i:s",time());
                                            $fields = [
                                                'taskprocess_id'=>$taskprocess_id,
                                                'task_id'=>'4',
                                                'staff_id'=>$staffId,
                                                'transactionDate'=>$transactionDate,
                                                'status'=>'Completed',
                                                'comments'=>$comment
                                            ];
                                            if($updateTask->insert("taskprocesshistory",$fields)){
                                                //History Dito
                                                $history = $task->readData("SELECT * FROM taskprocesshistory WHERE taskprocess_id = $taskprocess_id ORDER BY id DESC");
                                                //Email Dito
                                                $to = array();
                                                array_push($to,$logged_in_email);
                                                $rowsNextApprover = $task->readData("SELECT task_id, staff_id FROM taskapprover WHERE task_id = 5 AND status = 'Active'");
                                                foreach($rowsNextApprover as $rowNextApprover) {
                                                    array_push($to,$staff->getContactInfo(2,$rowNextApprover['staff_id'],'data'));
                                                }
                                                $email_staffName = $result['staffName'];
                                                $email_department = $task->fieldNameValue("department",$department_id,"name");
                                                $joinDate = $result['joinDate'];
                                                $gsm = $mobile;
                                                $from_name = 'hrms@nct.edu.om';
                                                $from = 'HRMS - 3.0';
                                                $subject = 'NCT-HRMD ACCOUNT CREATION FOR '.strtoupper($email_staffName);
                                                $d = '-';
                                                $message = '<html><body>';
                                                $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                $message .= "<h3>A task has been assigned to you by the NCT. Click <a target='_blank' href='http://apps1.nct.edu.om:4443/hrmd3/task_add_account_details.php?id=".$staff_id."&t=".$taskprocess_id."'>HERE</a> to access the system and provide action to your assigned task.</h3>";
                                                $message .= "<h4>NOTE: If you have already created the account of the staff assigned to you, kindly disregard this email.</h4>";
                                                $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION DETAILS AS FOLLOWS</h3>";
                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>DATE STARTED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($started))."</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>TASK STATUS:</strong> </td><td>Started/On Process</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT TASK SERVICE:</strong> </td><td>For Creating User Accounts to NCT Apps</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$email_staffName."</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>JOINING DATE:</strong> </td><td>".date('d/m/Y',strtotime($joinDate))."</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email_add."</td></tr>";
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
                                                    $getIdInfo = new DbaseManipulation;
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
                                                if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)) {
                                                    //Save Email Information in the database...
                                                    $recipients = implode(', ', $to);    
                                                    $emailFields = [
                                                        'requestNo'=>$requestNo,
                                                        'moduleName'=>'Create Account - Create Active Directory Account',
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
                                                    //Ends...
                                                } else {
                                                    //Save Email Information in the database...
                                                    $recipients = implode(', ', $to);    
                                                    $emailFields = [
                                                        'requestNo'=>$requestNo,
                                                        'moduleName'=>'Create Account - Create Active Directory Account',
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
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                    <p>Active directory account has been created successfully. Next Task: <strong>Creating User Accounts to NCT Apps</strong> has been forwarded to the next staff in charge.</p>
                                                </div>    
                            <?php                    
                                            }
                                        }
                                    }    
                                }
                            ?>
                            <?php
                                if(isset($_POST['submitSystemUser'])) {
                                    $taskId = 5;
                                    if($id_taskprocess != $taskId) {
                                        header("Location: task_add_new_account_list.php");
                                    } else {
                                        $systemUser = new DbaseManipulation;
                                        $comment = $systemUser->cleanString($_POST['comment']);
                                        
                                        $id = $_GET['t'];
                                        $updateTask = new DbaseManipulation;
                                        $fields = [
                                            'currentService'=>'Uploading Picture/Photo',
                                            'currentServiceId'=>'6'
                                        ];
                                        if($updateTask->update("taskprocess",$fields,$id)) {
                                            $taskprocess_id = $_GET['t'];
                                            $transactionDate = date("Y-m-d H:i:s",time());
                                            $fields = [
                                                'taskprocess_id'=>$taskprocess_id,
                                                'task_id'=>'5',
                                                'staff_id'=>$staffId,
                                                'transactionDate'=>$transactionDate,
                                                'status'=>'Completed',
                                                'comments'=>$comment
                                            ];
                                            if($updateTask->insert("taskprocesshistory",$fields)){
                                                //History Dito
                                                $history = $task->readData("SELECT * FROM taskprocesshistory WHERE taskprocess_id = $taskprocess_id ORDER BY id DESC");
                                                //Email Dito
                                                $to = array();
                                                array_push($to,$logged_in_email);
                                                $rowsNextApprover = $task->readData("SELECT task_id, staff_id FROM taskapprover WHERE task_id = 6 AND status = 'Active'");
                                                foreach($rowsNextApprover as $rowNextApprover) {
                                                    array_push($to,$staff->getContactInfo(2,$rowNextApprover['staff_id'],'data'));
                                                }
                                                $email_staffName = $result['staffName'];
                                                $email_department = $task->fieldNameValue("department",$department_id,"name");
                                                $joinDate = $result['joinDate'];
                                                $gsm = $mobile;
                                                $from_name = 'hrms@nct.edu.om';
                                                $from = 'HRMS - 3.0';
                                                $subject = 'NCT-HRMD ACCOUNT CREATION FOR '.strtoupper($email_staffName);
                                                $d = '-';
                                                $message = '<html><body>';
                                                $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                $message .= "<h3>A task has been assigned to you by the NCT. Click <a target='_blank' href='http://apps1.nct.edu.om:4443/hrmd3/task_add_account_details.php?id=".$staff_id."&t=".$taskprocess_id."'>HERE</a> to access the system and provide action to your assigned task.</h3>";
                                                $message .= "<h4>NOTE: If you have already created the account of the staff assigned to you, kindly disregard this email.</h4>";
                                                $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION DETAILS AS FOLLOWS</h3>";
                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>DATE STARTED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($started))."</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>TASK STATUS:</strong> </td><td>Started/On Process</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT TASK SERVICE:</strong> </td><td>For Uploading Picture/Photo</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$email_staffName."</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>JOINING DATE:</strong> </td><td>".date('d/m/Y',strtotime($joinDate))."</td></tr>";
                                                $message .= "<tr style='background:#E0F8F7'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email_add."</td></tr>";
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
                                                    $getIdInfo = new DbaseManipulation;
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
                                                if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)) {
                                                    //Save Email Information in the database...
                                                    $recipients = implode(', ', $to);    
                                                    $emailFields = [
                                                        'requestNo'=>$requestNo,
                                                        'moduleName'=>'Create Account - Create NCT Apps User Account',
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
                                                    //Ends...
                                                } else {
                                                    //Save Email Information in the database...
                                                    $recipients = implode(', ', $to);    
                                                    $emailFields = [
                                                        'requestNo'=>$requestNo,
                                                        'moduleName'=>'Create Account - Create NCT Apps User Account',
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
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                    <p>User accounts for NCT Apps has been created successfully. Next Task: <strong>Uploading Picture/Photo</strong> has been forwarded to the next staff in charge.</p>
                                                </div>    
                            <?php                    
                                            }
                                        }
                                    }    
                                }
                            ?>
                            <?php
                                if(isset($_POST['submitUploadPicture'])) {
                                    $taskId = 6;
                                    if($id_taskprocess != $taskId) {
                                        header("Location: task_add_new_account_list.php");
                                    } else {
                                        //Validate and upload the photo first...
                                        if (!empty($_FILES['fileToUpload']['name'])) {
                                            $target_dir = "attachments/added_accounts/staff_photos/";
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
                                                $new_file_name = $staff_id."_".$requestNo.".".$extension;
                                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$new_file_name)) {
                                                    $new_image = $target_dir.$new_file_name;
                                                    goto hell;
                                            ?>
                                                    <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                        <p>Staff's HR Account has been deactivated! Staff's Account has been put in the Archive List.<br/>The system has already send request to ETC to deactivate all related <strong>e-service access, e-mail,</strong> etc.</p>
                                                    </div> -->
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
                                            $uploadPhoto = new DbaseManipulation;
                                            $comment = $uploadPhoto->cleanString($_POST['comment']);
                                            
                                            $id = $_GET['t'];
                                            $updateTask = new DbaseManipulation;
                                            $fields = [
                                                'taskProcessStatus'=>'Completed',
                                                'currentService'=>'Uploading Picture/Photo',
                                                'currentServiceId'=>'7'
                                            ];
                                            if($updateTask->update("taskprocess",$fields,$id)) {
                                                $taskprocess_id = $_GET['t'];
                                                $transactionDate = date("Y-m-d H:i:s",time());
                                                $fields = [
                                                    'taskprocess_id'=>$taskprocess_id,
                                                    'task_id'=>'6',
                                                    'staff_id'=>$staffId,
                                                    'transactionDate'=>$transactionDate,
                                                    'status'=>'Completed',
                                                    'comments'=>$comment
                                                ];
                                                if($updateTask->insert("taskprocesshistory",$fields)){
                                                    //History Dito
                                                    $history = $task->readData("SELECT * FROM taskprocesshistory WHERE taskprocess_id = $taskprocess_id ORDER BY id DESC");
                                                    //Email Dito
                                                    $to = array();
                                                    array_push($to,$logged_in_email);
                                                    $rowsNextApprover = $task->readData("SELECT task_id, staff_id FROM taskapprover WHERE task_id IN (1,2,3,4,5,6) AND status = 'Active'"); //Informing All Involved in the task process...
                                                    foreach($rowsNextApprover as $rowNextApprover) {
                                                        array_push($to,$staff->getContactInfo(2,$rowNextApprover['staff_id'],'data'));
                                                    }
                                                    $email_staffName = $result['staffName'];
                                                    $email_department = $task->fieldNameValue("department",$department_id,"name");
                                                    $joinDate = $result['joinDate'];
                                                    $gsm = $mobile;
                                                    $from_name = 'hrms@nct.edu.om';
                                                    $from = 'HRMS - 3.0';
                                                    $subject = 'COMPLETED - NCT-HRMD ACCOUNT CREATION FOR '.strtoupper($email_staffName);
                                                    $d = '-';
                                                    $message = '<html><body>';
                                                    $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                    $message .= "<h3>A task has been assigned to you by the NCT. Click <a target='_blank' href='http://apps1.nct.edu.om:4443/hrmd3/task_add_account_details.php?id=".$staff_id."&t=".$taskprocess_id."'>HERE</a> to access the system and provide action to your assigned task.</h3>";
                                                    $message .= "<h4>NOTE: If you have already created the account of the staff assigned to you, kindly disregard this email.</h4>";
                                                    $message .= "<h3>NCT-HRMS 3.0 ACCOUNT CREATION DETAILS AS FOLLOWS</h3>";
                                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNo."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DATE STARTED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($started))."</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>TASK STATUS:</strong> </td><td><strong>Finished/Completed</strong></td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT TASK SERVICE:</strong> </td><td>***No more task. Process completed***</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$email_staffName."</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>JOINING DATE:</strong> </td><td>".date('d/m/Y',strtotime($joinDate))."</td></tr>";
                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email_add."</td></tr>";
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
                                                        $getIdInfo = new DbaseManipulation;
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
                                                    if($emailRecipient->smtpMailer($to,$from_name,$from,$subject,$message)) {
                                                        //Save Email Information in the database...
                                                        $recipients = implode(', ', $to);    
                                                        $emailFields = [
                                                            'requestNo'=>$requestNo,
                                                            'moduleName'=>'Create Account - Upload Photo',
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
                                                        //Ends...
                                                    } else {
                                                        //Save Email Information in the database...
                                                        $recipients = implode(', ', $to);    
                                                        $emailFields = [
                                                            'requestNo'=>$requestNo,
                                                            'moduleName'=>'Create Account - Upload Photo',
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
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                        <p>Staff photo/picture has been created successfully. <strong>All task has been completed for this request</strong>.</p>
                                                    </div>    
                                                    <?php                    
                                                }
                                            }
                                        }    
                                    }    
                                }
                            ?>
                            <!--End-->
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="card">
                                        <div class="card-header bg-light-info">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Staff Information</h3>
                                                    <h6 class="card-subtitle font-italic">Details of New Staff. Details was entered from ADD New Staff Module</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal p-t-5" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Staff ID</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="text" value="<?php echo $result['staffId']; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fa fa-user"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Civil ID</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo $result['civilId']; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fa fa-key"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Staff Name</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo preg_replace('/( )+/', ' ',$result['staffName']); ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-id-card"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Mobile</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo $mobile; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-mobile-alt"></i>
                                                                    </span>
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
                                                            <input type="text" value="<?php echo $result['department']; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-briefcase"></i>
                                                                    </span>
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
                                                            <input type="text" value="<?php echo $result['sponsor']; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-clipboard-list"></i>
                                                                    </span>
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
                                                            <input type="text" value="<?php echo $result['jobtitle']; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-book"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>                                            
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Join Date</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo date('d/m/Y',strtotime($result['joinDate'])); ?>" class="form-control" readonly />
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
                                                    <label class="col-sm-3 control-label">Section</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo $result['section']; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="far fa-building"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                            <input type="text" value="<?php echo $email_add; ?>" class="form-control" readonly />
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="basic-addon2">
                                                                        <i class="fas fa-envelope"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    if($user_type == 0 || $user_type == 1 || $user_type == 2) {
                                        ?>
                                        <div class="col-lg-7">
                                            <div class="card">
                                                <div class="card-header bg-light-info">
                                                    <div class="d-flex flex-wrap">
                                                        <div>
                                                            <h3 class="card-title">Create Staff's Accounts</h3>
                                                            <h6 class="card-subtitle font-italic">Approval Details</h6>
                                                        </div>
                                                        <div class="ml-auto">
                                                            <h4> Task ID: <span class="text-primary"><?php echo $requestNo; ?></span> / Status: <span class="text-primary"><?php echo $taskStatus; ?></span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="ribbon-vwrapper card">
                                                        <div class="ribbon ribbon-info ribbon-vertical-l"><i class="fa fa-user"></i></div>
                                                        <h3 class="ribbon-content">Create HR Staff Account</h3>
                                                        <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,1,'status'); ?></span> /
                                                                <?php
                                                                    $created_by = $task->getTaskStatus($id,1,'staff_id');
                                                                ?>
                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,1,'transactionDate'))); ?></span></span></p>
                                                        <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,1,'comments'); ?></i></p>
                                                    </div>
                                                    <!--2. Assigning Section Portion-->
                                                    <?php
                                                        if($task->getTaskStatus($id,2,'status') == 'Pending') {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                <h3 class="ribbon-content">Assign Section</h3>
                                                                <p class="ribbon-content">
                                                                    <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                    <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                </p>
                                                                <form class="form-horizontal m-t-5" action="" method="POST">
                                                                <div class="form-group">
                                                                        <select name="section_id" class="form-control select" required>
                                                                            <option value="">Select Section Here</option>
                                                                            <?php
                                                                                $dropdown = new DbaseManipulation; 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM section WHERE department_id = $department_id ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                        </select> 
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="taskId" value="2" />
                                                                        <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" name="submitSection" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                        <button type="submit" name="declineSection" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                    <?php        
                                                        } else {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                <h3 class="ribbon-content">Assign Section</h3>
                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                <?php
                                                                    $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                ?>
                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    <!--3. Creating Email Account Portion-->
                                                    <?php
                                                        if($task->getTaskStatus($id,3,'status') == 'Pending') {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                <h3 class="ribbon-content">Create Email Account</h3>
                                                                <p class="ribbon-content">
                                                                    <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                    <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                </p>
                                                                <form class="form-horizontal m-t-5" action="" method="POST">
                                                                    <div class="form-group">
                                                                        <input type="email" name="email_address" class="form-control" placeholder="name@nct.edu.om" required/> 
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="taskId" value="3" />
                                                                        <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" name="submitEmail" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                        <button type="submit" name="declineEmail" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                    <?php        
                                                        } else {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                <h3 class="ribbon-content">Create Email Accounts</h3>
                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                <?php
                                                                    $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                ?>
                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                        <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>      
                                                    <!--4. Creating Active Directory Account Portion-->
                                                    <?php
                                                        if($task->getTaskStatus($id,4,'status') == 'Pending') {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                    <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                    <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                <p class="ribbon-content">
                                                                    <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                    <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                </p>
                                                                <form class="form-horizontal m-t-5" action="" method="POST">
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="taskId" value="4" />
                                                                        <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" name="submitActiveDirectory" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                        <button type="submit" name="declineActiveDirectory" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                    <?php        
                                                        } else {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                <?php
                                                                    $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                ?>
                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                        <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    <!--5. Creating System User Account Portion-->
                                                    <?php
                                                        if($task->getTaskStatus($id,5,'status') == 'Pending') {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                <h3 class="ribbon-content">Assign System User Type</h3>
                                                                <p class="ribbon-content">
                                                                    <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                    <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                </p>
                                                                <form class="form-horizontal m-t-5" action="" method="POST">
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="taskId" value="5" />
                                                                        <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" name="submitSystemUser" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                        <button type="submit" name="declineSystemUser" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                    <?php        
                                                        } else {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                <h3 class="ribbon-content">Assign System User Type</h3>
                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                                <?php
                                                                    $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                                ?>
                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                        <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    <!--6. Uploading Picture Portion-->
                                                    <?php
                                                        if($task->getTaskStatus($id,6,'status') == 'Pending') {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-custom ribbon-vertical-l"><i class="fas fa-address-card"></i></div>
                                                                <h3 class="ribbon-content">Upload Picture</h3>
                                                                <p class="ribbon-content">
                                                                    <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                    <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                </p>
                                                                <form class="form-horizontal m-t-5" action="" method="POST" enctype="multipart/form-data">
                                                                    <div class="form-group">
                                                                        <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf, .gif" class="form-control" placeholder="Select image file" required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="taskId" value="6" />
                                                                        <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" name="submitUploadPicture" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                        <button type="submit" name="declineUploadPicture" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                    <?php        
                                                        } else {
                                                    ?>
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-custom ribbon-vertical-l"><i class="fas fa-address-card"></i></div>
                                                                <h3 class="ribbon-content">Upload Picture</h3>
                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,6,'status'); ?></span> /
                                                                <?php
                                                                    $created_by = $task->getTaskStatus($id,6,'staff_id');
                                                                ?>
                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,6,'transactionDate'))); ?></span></span></p>
                                                        <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,6,'comments'); ?></i></p>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <!--end card body approval-->
                                            </div>
                                            <!--end card approval-->
                                        </div>
                                <?php
                                    } else {
                                        if($taskStatus != "Completed") {
                                            $check = new DbaseManipulation;
                                            $rowCheck = $check->singleReadFullQry("SELECT id, task_id, staff_id, department_id FROM taskapprover WHERE status = 'Active' AND staff_id = $staffId");
                                            if($check->totalCount != 0) {
                                                $myTaskId = $rowCheck['task_id'];
                                                //echo $myTaskId;
                                                ?>
                                                <div class="col-lg-7">
                                                    <div class="card">
                                                        <div class="card-header bg-light-info">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Create Staff's Accounts</h3>
                                                                    <h6 class="card-subtitle font-italic">Approval Details</h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <h4> Task ID: <span class="text-primary"><?php echo $requestNo; ?></span> / Status: <span class="text-primary"><?php echo $taskStatus; ?></span></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <!--1. Available for all since this one is finished already upon creation of the user account from staff_add_new.php-->
                                                            <div class="ribbon-vwrapper card">
                                                                <div class="ribbon ribbon-info ribbon-vertical-l"><i class="fa fa-user"></i></div>
                                                                <h3 class="ribbon-content">Create HR Staff Account</h3>
                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,1,'status'); ?></span> /
                                                                        <?php
                                                                            $created_by = $task->getTaskStatus($id,1,'staff_id');
                                                                        ?>
                                                                        <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,1,'transactionDate'))); ?></span></span></p>
                                                                <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,1,'comments'); ?></i></p>
                                                            </div>
                                                            <!--2. Assigning Section Portion-->
                                                            <?php
                                                                if($myTaskId == 2) {
                                                                    if($department_id == $logged_in_department_id) {
                                                                        if($task->getTaskStatus($id,2,'status') == 'Pending') {          
                                                                ?>
                                                                            <div class="ribbon-vwrapper card">
                                                                                <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                                <h3 class="ribbon-content">Assign Section</h3>
                                                                                <p class="ribbon-content">
                                                                                    <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                                    <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                                </p>
                                                                                <form class="form-horizontal m-t-5" action="" method="POST">
                                                                                <div class="form-group">
                                                                                        <select name="section_id" class="form-control select" required>
                                                                                            <option value="">Select Section Here</option>
                                                                                            <?php
                                                                                                $dropdown = new DbaseManipulation; 
                                                                                                $rows = $dropdown->readData("SELECT id, name FROM section WHERE department_id = $department_id ORDER BY id");
                                                                                                foreach ($rows as $row) {
                                                                                            ?>
                                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                            <?php            
                                                                                                }    
                                                                                            ?>
                                                                                        </select> 
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <button type="submit" name="submitSection" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                                        <button type="submit" name="declineSection" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                <?php        
                                                                        } else {
                                                                ?>
                                                                            <!--Section Assignment History-->
                                                                            <div class="ribbon-vwrapper card">
                                                                                <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                                <h3 class="ribbon-content">Assign Section</h3>
                                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                                <?php
                                                                                    $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                                ?>
                                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                                <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                            </div>
                                                                            <!--Section Assignment History Ends-->
                                                                            <!--Email Assignment History-->
                                                                            <div class="ribbon-vwrapper card">
                                                                                <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                                <h3 class="ribbon-content">Create Email Account</h3>
                                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                                <?php
                                                                                    $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                                ?>
                                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                                <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                            </div>
                                                                            <!--Email Assignment History Ends-->
                                                                            <!--AD Assignment History-->
                                                                            <div class="ribbon-vwrapper card">
                                                                                <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                                <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                                <?php
                                                                                    $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                                ?>
                                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                                                <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                                            </div>
                                                                            <!--AD Assignment History Ends-->
                                                                            <!--System Users Assignment History-->
                                                                            <div class="ribbon-vwrapper card">
                                                                                <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                                <h3 class="ribbon-content">Assign System User Type</h3>
                                                                                <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                                                <?php
                                                                                    $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                                                ?>
                                                                                <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                                                <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                                            </div>
                                                                            <!--System Users Assignment History Ends-->
                                                                <?php
                                                                        }
                                                                    } else {
                                                                ?>
                                                                            <div class="ribbon-vwrapper card">
                                                                                <div class="ribbon ribbon-danger ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                                <h3 class="ribbon-content text-danger"><i class="fa fa-exclamation-triangle"></i> Open Assign Section Module Failed</h3>
                                                                                <p class="ribbon-content"><span class="text-danger">System Message: You are not allowed to assign section to the staff selected for the reason that you and the staff does not belong to the same department.</span></p>
                                                                            </div>
                                                                <?php            
                                                                    }  
                                                                }    
                                                            ?>
                                                            <!--3. Creating Email Account Portion-->
                                                            <?php
                                                                if($myTaskId == 3) {
                                                                    if($task->getTaskStatus($id,3,'status') == 'Pending') {
                                                                        ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->    
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content">
                                                                                <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                                <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                            </p>
                                                                            <form class="form-horizontal m-t-5" action="" method="POST">
                                                                                <div class="form-group">
                                                                                    <input type="email" name="email_address" tab class="form-control" placeholder="name@nct.edu.om" required/> 
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="taskId" value="3" />
                                                                                    <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <button type="submit" name="submitEmail" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                                    <button type="submit" name="declineEmail" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <?php        
                                                                    } else {
                                                                        ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->
                                                                        <!--Email Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Email Assignment History Ends-->
                                                                        <!--AD Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                            <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--AD Assignment History Ends-->
                                                                        <!--System Users Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                            <h3 class="ribbon-content">Assign System User Type</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--System Users Assignment History Ends-->
                                                                        
                                                            <?php
                                                                    }
                                                                }    
                                                            ?>      
                                                            <!--4. Creating Active Directory Account Portion-->
                                                            <?php
                                                                if($myTaskId == 4) {
                                                                    if($task->getTaskStatus($id,4,'status') == 'Pending') {
                                                                        ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->
                                                                        <!--Email Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Email Assignment History Ends-->
                                                                        <div class="ribbon-vwrapper card">
                                                                                <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                                <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                            <p class="ribbon-content">
                                                                                <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                                <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                            </p>
                                                                            <form class="form-horizontal m-t-5" action="" method="POST">
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="taskId" value="4" />
                                                                                    <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <button type="submit" name="submitActiveDirectory" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                                    <button type="submit" name="declineActiveDirectory" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                            <?php        
                                                                    } else {
                                                                        ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->
                                                                        <!--Email Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Email Assignment History Ends-->
                                                                        <!--AD Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                            <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--AD Assignment History Ends-->
                                                                        <!--System Users Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                            <h3 class="ribbon-content">Assign System User Type</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--System Users Assignment History Ends-->
                                                            <?php
                                                                    }
                                                                }    
                                                            ?>
                                                            <!--5. Creating System User Account Portion-->
                                                            <?php
                                                                if($myTaskId == 5) {
                                                                    if($task->getTaskStatus($id,5,'status') == 'Pending') {
                                                                        ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->
                                                                        <!--Email Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Email Assignment History Ends-->
                                                                        <!--AD Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                            <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--AD Assignment History Ends-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                            <h3 class="ribbon-content">Assign System User Type</h3>
                                                                            <p class="ribbon-content">
                                                                                <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                                <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                            </p>
                                                                            <form class="form-horizontal m-t-5" action="" method="POST">
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="taskId" value="5" />
                                                                                    <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <button type="submit" name="submitSystemUser" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                                    <button type="submit" name="declineSystemUser" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                            <?php        
                                                                    } else {
                                                            ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->
                                                                        <!--Email Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Email Assignment History Ends-->
                                                                        <!--AD Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                            <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--AD Assignment History Ends-->
                                                                        <!--System Users Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                            <h3 class="ribbon-content">Assign System User Type</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--System Users Assignment History Ends-->
                                                            <?php
                                                                    }
                                                                }    
                                                            ?>
                                                            <!--6. Uploading Picture Portion-->
                                                            <?php
                                                                if($myTaskId == 6) {
                                                                    if($task->getTaskStatus($id,6,'status') == 'Pending') {
                                                            ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->
                                                                        <!--Email Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Email Assignment History Ends-->
                                                                        <!--AD Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                            <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--AD Assignment History Ends-->
                                                                        <!--System Users Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                            <h3 class="ribbon-content">Assign System User Type</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--System Users Assignment History Ends-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-custom ribbon-vertical-l"><i class="fas fa-address-card"></i></div>
                                                                            <h3 class="ribbon-content">Upload Picture</h3>
                                                                            <p class="ribbon-content">
                                                                                <span class="text-primary">Status : <span class="label label-warning">On-Process</span> / 
                                                                                <span class="text-muted pull-right"><?php echo date('jS F, Y H:i:s',time()); ?></span></span>
                                                                            </p>
                                                                            <form class="form-horizontal m-t-5" action="" method="POST" enctype="multipart/form-data">
                                                                                <div class="form-group">
                                                                                    <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf, .gif" class="form-control" placeholder="Select image file" required/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input type="hidden" name="taskId" value="6" />
                                                                                    <input type="text" name="comment" class="form-control" placeholder="Type comment here..." required/>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <button type="submit" name="submitUploadPicture" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Complete Task</button>
                                                                                    <button type="submit" name="declineUploadPicture" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline Task</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                            <?php        
                                                                    } else {
                                                            ?>
                                                                        <!--Section Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Section Assignment History Ends-->
                                                                        <!--Email Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Email Assignment History Ends-->
                                                                        <!--AD Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                                            <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--AD Assignment History Ends-->
                                                                        <!--System Users Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                                            <h3 class="ribbon-content">Assign System User Type</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--System Users Assignment History Ends-->
                                                                        <!--Uploading Photo/Picture Assignment History-->
                                                                        <div class="ribbon-vwrapper card">
                                                                            <div class="ribbon ribbon-custom ribbon-vertical-l"><i class="fas fa-address-card"></i></div>
                                                                            <h3 class="ribbon-content">Upload Picture</h3>
                                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,6,'status'); ?></span> /
                                                                            <?php
                                                                                $created_by = $task->getTaskStatus($id,6,'staff_id');
                                                                            ?>
                                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,6,'transactionDate'))); ?></span></span></p>
                                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,6,'comments'); ?></i></p>
                                                                        </div>
                                                                        <!--Uploading Photo/Picture Assignment History Ends-->
                                                            <?php
                                                                    }
                                                                }    
                                                            ?>
                                                        </div>
                                                        <!--end card body approval-->
                                                    </div>
                                                </div>
                                <?php            
                                            } else {
                                                include_once('not_allowed.php');    
                                            }
                                        } else { //COMPLETED! Read-only, showing only histories...   
                                ?>        
                                            <div class="col-lg-7">
                                                <div class="card">
                                                    <div class="card-header bg-light-info">
                                                        <div class="d-flex flex-wrap">
                                                            <div>
                                                                <h3 class="card-title">Create Staff's Accounts</h3>
                                                                <h6 class="card-subtitle font-italic">Approval Details</h6>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <h4> Task ID: <span class="text-primary"><?php echo $requestNo; ?></span> / Status: <span class="text-primary"><?php echo $taskStatus; ?></span></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <!--1. Available for all since this one is finished already upon creation of the user account from staff_add_new.php-->
                                                        <div class="ribbon-vwrapper card">
                                                            <div class="ribbon ribbon-info ribbon-vertical-l"><i class="fa fa-user"></i></div>
                                                            <h3 class="ribbon-content">Create HR Staff Account</h3>
                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,1,'status'); ?></span> /
                                                                    <?php
                                                                        $created_by = $task->getTaskStatus($id,1,'staff_id');
                                                                    ?>
                                                                    <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,1,'transactionDate'))); ?></span></span></p>
                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,1,'comments'); ?></i></p>
                                                        </div>
                                                        <!--2. Assigning Section Portion-->
                                                        <div class="ribbon-vwrapper card">
                                                            <div class="ribbon ribbon-success ribbon-vertical-l"><i class="fa fa-briefcase"></i></div>
                                                            <h3 class="ribbon-content">Assign Section</h3>
                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,2,'status'); ?></span> /
                                                            <?php
                                                                $created_by = $task->getTaskStatus($id,2,'staff_id');
                                                            ?>
                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,2,'transactionDate'))); ?></span></span></p>
                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,2,'comments'); ?></i></p>
                                                        </div>                                                        
                                                        <!--3. Creating Email Account Portion-->
                                                        <div class="ribbon-vwrapper card">
                                                            <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                            <h3 class="ribbon-content">Create Email Account</h3>
                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,3,'status'); ?></span> /
                                                            <?php
                                                                $created_by = $task->getTaskStatus($id,3,'staff_id');
                                                            ?>
                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,3,'transactionDate'))); ?></span></span></p>
                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,3,'comments'); ?></i></p>
                                                        </div>
                                                        <!--4. Creating Active Directory Account Portion-->
                                                        <div class="ribbon-vwrapper card">
                                                            <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                            <h3 class="ribbon-content">Create Active Directory Account</h3>
                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,4,'status'); ?></span> /
                                                            <?php
                                                                $created_by = $task->getTaskStatus($id,4,'staff_id');
                                                            ?>
                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,4,'transactionDate'))); ?></span></span></p>
                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,4,'comments'); ?></i></p>
                                                        </div>
                                                        <!--5. Creating System User Account Portion-->
                                                        <div class="ribbon-vwrapper card">
                                                            <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                            <h3 class="ribbon-content">Assign System User Type</h3>
                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,5,'status'); ?></span> /
                                                            <?php
                                                                $created_by = $task->getTaskStatus($id,5,'staff_id');
                                                            ?>
                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,5,'transactionDate'))); ?></span></span></p>
                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,5,'comments'); ?></i></p>
                                                        </div>
                                                        <!--6. Uploading Picture Portion-->
                                                        <div class="ribbon-vwrapper card">
                                                            <div class="ribbon ribbon-custom ribbon-vertical-l"><i class="fas fa-address-card"></i></div>
                                                            <h3 class="ribbon-content">Upload Picture</h3>
                                                            <p class="ribbon-content"><span class="text-primary">Status : <span class="label label-info"><?php echo $task->getTaskStatus($id,6,'status'); ?></span> /
                                                            <?php
                                                                $created_by = $task->getTaskStatus($id,6,'staff_id');
                                                            ?>
                                                            <span class="label label-primary"><?php echo $staff->getStaffName($created_by,'firstName','secondName','thirdName','lastName')." - ".date('jS F, Y H:i:s',strtotime($task->getTaskStatus($id,6,'transactionDate'))); ?></span></span></p>
                                                            <p class="ribbon-content"><i><?php echo $task->getTaskStatus($id,6,'comments'); ?></i></p>
                                                        </div>
                                                    </div>
                                                    <!--end card body approval-->
                                                </div>
                                            </div>
                                <?php
                                        }
                                    }
                                ?>
                                
                            </div>
                            <!--end row -->

                        </div>

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