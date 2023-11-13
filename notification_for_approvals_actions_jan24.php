<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        $allowed = true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            if(isset($_GET['approverId']) && isset($_GET['requestNoS']) && isset($_GET['action']) && isset($_GET['approvalType'])) {
                if($_GET['approvalType'] == 'shl') { //Short Leave --ALL DONE AND WORKING--
                    if($_GET['action'] == 1) { //If button Approve "Selected Record" is Clicked --> Multiple approvals at the same time...
                        $approverId = $_GET['approverId'];
                        $approverEmail = $_GET['approverEmail'];
                        $ids = $_GET['requestNoS'];
                        $get = new DbaseManipulation;
                        $save = new DbaseManipulation;
                        $contact_details = new DbaseManipulation;
                        $getIdInfo = new DbaseManipulation;
                        $to = array();
                        $rows = $get->readData("SELECT * FROM shortleave WHERE id IN ($ids)");
                        $ApprovalText = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'code');
                        $nextApproverPositionIdRow = $get->singleReadFullQry("SELECT id, approverInSequence2 FROM approvalsequence_shortleave WHERE approverInSequence1 = $myPositionId AND active = 1 AND department_id = $logged_in_department_id");
                        $nextApproverPositionId = $nextApproverPositionIdRow['approverInSequence2'];
                        foreach($rows as $row){
                            $id = $row['id'];
                            $requestNo = $row['requestNo'];
                            $fieldsUpdate = [
                                'currentStatus'=>'Approved',
                                'currentSeqNumber'=>2,
                                'currentApproverPositionId'=>$nextApproverPositionId
                            ];
                            if($save->update("shortleave",$fieldsUpdate,$id)) {
                                $fieldsInsert = [
                                    'shortleave_id'=>$id,
                                    'requestNo'=>$requestNo,
                                    'staff_id'=>$approverId,
                                    'status'=>$ApprovalText,
                                    'notes'=>'Approved.',
                                    'ipAddress'=>$get->getUserIP()
                                ];
                                $save->insert("shortleave_history",$fieldsInsert);
                                //Saving in system_emails here...
                                $history = $getIdInfo->readData("SELECT * FROM shortleave_history WHERE shortleave_id = $id ORDER BY id DESC");
                                $from_name = 'hrms@nct.edu.om';
                                $from = 'HRMS - 3.0';
                                $shl = $get->singleReadFullQry("SELECT * FROM shortleave WHERE id = $id");
                                $shLName = $get->getStaffName($shl['staff_id'],'firstName','secondName','thirdName','lastName');
                                $subject = 'NCT-HRMD SHORT LEAVE [APPROVAL] FILED BY '.strtoupper($shLName);
                                $leaveDuration = "From ".$shl['startTime']." to ".$shl['endTime'];
                                $email = $contact_details->getContactInfo(2,$shl['staff_id'],'data');
                                $gsm = $contact_details->getContactInfo(1,$shl['staff_id'],'data');
                                $shLDeptId = $getIdInfo->employmentIDs($shl['staff_id'],'department_id');
                                $email_department = $getIdInfo->fieldNameValue("department",$shLDeptId,"name");
                                $message = '<html><body>';
                                $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                $message .= "<h3>NCT-HRMS 3.0 SHORT LEAVE DETAILS</h3>";
                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Approved</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$shl['requestNo']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DATE:</strong> </td><td>".date('d/m/Y',strtotime($shl['leaveDate']))."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>NUMBER OF HOURS:</strong> </td><td>".$shl['total']."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$shl['staff_id']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$shLName."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email."</td></tr>";
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
                                unset($to);
                                $to = array();
                                $row = $get->singleReadFullQry("SELECT id, department_id, position_id, approverInSequence2 FROM approvalsequence_shortleave WHERE active = 1 AND position_id = $myPositionId");
                                $myApproverPositionId = $row['approverInSequence2'];
                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $myApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                $nextApproverStaffId = $nextApprover['staff_id'];
                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproverStaffId,'data');
                                array_push($to,$email,$logged_in_email,$nextApproverEmailAdd);
                                
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
                                        'moduleName'=>'Short Leave Application Approval',
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
                                    //echo $save->displayArr($emailFields);
                                    $saveEmail = new DbaseManipulation;
                                    $saveEmail->insert("system_emails",$emailFields);
                            }
                        }
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Selected short leave has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 2) { //If button Approve is Clicked --> Single approval only...
                        $id = $_GET['id'];
                        $approverId = $_GET['approverId'];
                        $approverEmail = $_GET['approverEmail'];
                        $requestNoS = $_GET['requestNoS'];
                        $notes = $_GET['notes'];
                        $get = new DbaseManipulation;
                        $save = new DbaseManipulation;
                        $contact_details = new DbaseManipulation;
                        $getIdInfo = new DbaseManipulation;
                        $to = array();
                        $rows = $get->readData("SELECT * FROM shortleave WHERE id IN ($id)");
                        $ApprovalText = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'code');
                        $nextApproverPositionIdRow = $get->singleReadFullQry("SELECT id, approverInSequence2 FROM approvalsequence_shortleave WHERE approverInSequence1 = $myPositionId AND active = 1 AND department_id = $logged_in_department_id");
                        $nextApproverPositionId = $nextApproverPositionIdRow['approverInSequence2'];
                        foreach($rows as $row){
                            $id = $row['id'];
                            $requestNo = $row['requestNo'];
                            $fieldsUpdate = [
                                'currentStatus'=>'Approved',
                                'currentSeqNumber'=>2,
                                'currentApproverPositionId'=>$nextApproverPositionId
                            ];
                            if($save->update("shortleave",$fieldsUpdate,$id)) {
                                $fieldsInsert = [
                                    'shortleave_id'=>$id,
                                    'requestNo'=>$requestNo,
                                    'staff_id'=>$approverId,
                                    'status'=>$ApprovalText,
                                    'notes'=>$notes,
                                    'ipAddress'=>$get->getUserIP()
                                ];
                                $save->insert("shortleave_history",$fieldsInsert);
                                //Saving in system_emails here...
                                $history = $getIdInfo->readData("SELECT * FROM shortleave_history WHERE shortleave_id = $id ORDER BY id DESC");
                                $from_name = 'hrms@nct.edu.om';
                                $from = 'HRMS - 3.0';
                                $shl = $get->singleReadFullQry("SELECT * FROM shortleave WHERE id = $id");
                                $shLName = $get->getStaffName($shl['staff_id'],'firstName','secondName','thirdName','lastName');
                                $subject = 'NCT-HRMD SHORT LEAVE [APPROVAL] FILED BY '.strtoupper($shLName);
                                $leaveDuration = "From ".$shl['startTime']." to ".$shl['endTime'];
                                $email = $contact_details->getContactInfo(2,$shl['staff_id'],'data');
                                $gsm = $contact_details->getContactInfo(1,$shl['staff_id'],'data');
                                $shLDeptId = $getIdInfo->employmentIDs($shl['staff_id'],'department_id');
                                $email_department = $getIdInfo->fieldNameValue("department",$shLDeptId,"name");
                                $message = '<html><body>';
                                $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                $message .= "<h3>NCT-HRMS 3.0 SHORT LEAVE DETAILS</h3>";
                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Approved</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$shl['requestNo']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DATE:</strong> </td><td>".date('d/m/Y',strtotime($shl['leaveDate']))."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>NUMBER OF HOURS:</strong> </td><td>".$shl['total']."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$shl['staff_id']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$shLName."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email."</td></tr>";
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
                                unset($to);
                                $to = array();
                                $row = $get->singleReadFullQry("SELECT id, department_id, position_id, approverInSequence2 FROM approvalsequence_shortleave WHERE active = 1 AND position_id = $myPositionId");
                                $myApproverPositionId = $row['approverInSequence2'];
                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $myApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                $nextApproverStaffId = $nextApprover['staff_id'];
                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproverStaffId,'data');
                                array_push($to,$email,$logged_in_email,$nextApproverEmailAdd);

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
                                        'requestNo'=>$requestNo,
                                        'moduleName'=>'Short Leave Application Approval',
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
                                        'moduleName'=>'Short Leave Application Approval',
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
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Short leave has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 3) { //If button Decline is Clicked --> Single decline only...
                        $id = $_GET['id'];
                        $approverId = $_GET['approverId'];
                        $approverEmail = $_GET['approverEmail'];
                        $requestNoS = $_GET['requestNoS'];
                        $notes = $_GET['notes'];
                        $get = new DbaseManipulation;
                        $save = new DbaseManipulation;
                        $contact_details = new DbaseManipulation;
                        $getIdInfo = new DbaseManipulation;
                        $to = array();
                        $rows = $get->readData("SELECT * FROM shortleave WHERE id IN ($id)");
                        $ApprovalText = "Declined - ".$helper->fieldNameValue("staff_position",$myPositionId,'code');
                        $nextApproverPositionIdRow = $get->singleReadFullQry("SELECT id, approverInSequence2 FROM approvalsequence_shortleave WHERE approverInSequence1 = $myPositionId AND active = 1 AND department_id = $logged_in_department_id");
                        $nextApproverPositionId = $nextApproverPositionIdRow['approverInSequence2'];
                        foreach($rows as $row){
                            $id = $row['id'];
                            $requestNo = $row['requestNo'];
                            $fieldsUpdate = [
                                'currentStatus'=>'Declined',
                                'currentSeqNumber'=>2,
                                'currentApproverPositionId'=>$nextApproverPositionId
                            ];
                            if($save->update("shortleave",$fieldsUpdate,$id)) {
                                $fieldsInsert = [
                                    'shortleave_id'=>$id,
                                    'requestNo'=>$requestNo,
                                    'staff_id'=>$approverId,
                                    'status'=>$ApprovalText,
                                    'notes'=>$notes,
                                    'ipAddress'=>$get->getUserIP()
                                ];
                                $save->insert("shortleave_history",$fieldsInsert);
                                //Saving in system_emails here...
                                $history = $getIdInfo->readData("SELECT * FROM shortleave_history WHERE shortleave_id = $id ORDER BY id DESC");
                                $from_name = 'hrms@nct.edu.om';
                                $from = 'HRMS - 3.0';
                                $shl = $get->singleReadFullQry("SELECT * FROM shortleave WHERE id = $id");
                                $shLName = $get->getStaffName($shl['staff_id'],'firstName','secondName','thirdName','lastName');
                                $subject = 'NCT-HRMD SHORT LEAVE [DECLINED] FILED BY '.strtoupper($shLName);
                                $leaveDuration = "From ".$shl['startTime']." to ".$shl['endTime'];
                                $email = $contact_details->getContactInfo(2,$shl['staff_id'],'data');
                                $gsm = $contact_details->getContactInfo(1,$shl['staff_id'],'data');
                                $shLDeptId = $getIdInfo->employmentIDs($shl['staff_id'],'department_id');
                                $email_department = $getIdInfo->fieldNameValue("department",$shLDeptId,"name");
                                $message = '<html><body>';
                                $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                $message .= "<h3>NCT-HRMS 3.0 SHORT LEAVE DETAILS</h3>";
                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Declined</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$shl['requestNo']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DATE:</strong> </td><td>".date('d/m/Y',strtotime($shl['leaveDate']))."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>NUMBER OF HOURS:</strong> </td><td>".$shl['total']."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$shl['staff_id']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$shLName."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email."</td></tr>";
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
                                unset($to);
                                $to = array();
                                $row = $get->singleReadFullQry("SELECT id, department_id, position_id, approverInSequence2 FROM approvalsequence_shortleave WHERE active = 1 AND position_id = $myPositionId");
                                $myApproverPositionId = $row['approverInSequence2'];
                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $myApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                $nextApproverStaffId = $nextApprover['staff_id'];
                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproverStaffId,'data');
                                array_push($to,$email,$logged_in_email,$nextApproverEmailAdd);

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
                                        'requestNo'=>$requestNo,
                                        'moduleName'=>'Short Leave Application Decline',
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
                                        'moduleName'=>'Short Leave Application Decline',
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
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Short leave has been declined! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if($_GET['action'] == 4) { //If button Decline "Selected Record" is Clicked --> Multiple declines at the same time...
                        $approverId = $_GET['approverId'];
                        $approverEmail = $_GET['approverEmail'];
                        $ids = $_GET['requestNoS'];
                        $get = new DbaseManipulation;
                        $save = new DbaseManipulation;
                        $contact_details = new DbaseManipulation;
                        $getIdInfo = new DbaseManipulation;
                        $to = array();
                        $rows = $get->readData("SELECT * FROM shortleave WHERE id IN ($ids)");
                        $ApprovalText = "Declined - ".$helper->fieldNameValue("staff_position",$myPositionId,'code');
                        $nextApproverPositionIdRow = $get->singleReadFullQry("SELECT id, approverInSequence2 FROM approvalsequence_shortleave WHERE approverInSequence1 = $myPositionId AND active = 1 AND department_id = $logged_in_department_id");
                        $nextApproverPositionId = $nextApproverPositionIdRow['approverInSequence2'];
                        foreach($rows as $row){
                            $id = $row['id'];
                            $requestNo = $row['requestNo'];
                            $fieldsUpdate = [
                                'currentStatus'=>'Declined',
                                'currentSeqNumber'=>2,
                                'currentApproverPositionId'=>$nextApproverPositionId
                            ];
                            if($save->update("shortleave",$fieldsUpdate,$id)) {
                                $fieldsInsert = [
                                    'shortleave_id'=>$id,
                                    'requestNo'=>$requestNo,
                                    'staff_id'=>$approverId,
                                    'status'=>$ApprovalText,
                                    'notes'=>'Declined.',
                                    'ipAddress'=>$get->getUserIP()
                                ];
                                $save->insert("shortleave_history",$fieldsInsert);
                                $history = $getIdInfo->readData("SELECT * FROM shortleave_history WHERE shortleave_id = $id ORDER BY id DESC");
                                $from_name = 'hrms@nct.edu.om';
                                $from = 'HRMS - 3.0';
                                $shl = $get->singleReadFullQry("SELECT * FROM shortleave WHERE id = $id");
                                $shLName = $get->getStaffName($shl['staff_id'],'firstName','secondName','thirdName','lastName');
                                $subject = 'NCT-HRMD SHORT LEAVE [DECLINED] FILED BY '.strtoupper($shLName);
                                $leaveDuration = "From ".$shl['startTime']." to ".$shl['endTime'];
                                $email = $contact_details->getContactInfo(2,$shl['staff_id'],'data');
                                $gsm = $contact_details->getContactInfo(1,$shl['staff_id'],'data');
                                $shLDeptId = $getIdInfo->employmentIDs($shl['staff_id'],'department_id');
                                $email_department = $getIdInfo->fieldNameValue("department",$shLDeptId,"name");
                                $message = '<html><body>';
                                $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                $message .= "<h3>NCT-HRMS 3.0 SHORT LEAVE DETAILS</h3>";
                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Declined</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$shl['requestNo']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DATE:</strong> </td><td>".date('d/m/Y',strtotime($shl['leaveDate']))."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>NUMBER OF HOURS:</strong> </td><td>".$shl['total']."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$shl['staff_id']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$shLName."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email."</td></tr>";
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
                                unset($to);
                                $to = array();
                                $row = $get->singleReadFullQry("SELECT id, department_id, position_id, approverInSequence2 FROM approvalsequence_shortleave WHERE active = 1 AND position_id = $myPositionId");
                                $myApproverPositionId = $row['approverInSequence2'];
                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $myApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                $nextApproverStaffId = $nextApprover['staff_id'];
                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproverStaffId,'data');
                                array_push($to,$email,$logged_in_email,$nextApproverEmailAdd);
                                
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
                                        'moduleName'=>'Short Leave Application Decline',
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
                                    //echo $save->displayArr($emailFields);
                                    $saveEmail = new DbaseManipulation;
                                    $saveEmail->insert("system_emails",$emailFields);
                            }
                        }
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Selected short leave has been declined! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if($_GET['action'] == 5) { //If button Cancel this request is Clicked (By the one who filed it)
                        $id = $_GET['id'];
                        $approverId = $_GET['approverId'];
                        $approverEmail = $_GET['approverEmail'];
                        $requestNoS = $_GET['requestNoS'];
                        $notes = $_GET['notes'];
                        $get = new DbaseManipulation;
                        $save = new DbaseManipulation;
                        $contact_details = new DbaseManipulation;
                        $getIdInfo = new DbaseManipulation;
                        $to = array();
                        $rows = $get->readData("SELECT * FROM shortleave WHERE id IN ($id)");
                        $ApprovalText = "Cancelled By - ".$logged_name;
                        foreach($rows as $row){
                            $id = $row['id'];
                            $requestNo = $row['requestNo'];
                            $fieldsUpdate = [
                                'currentStatus'=>'Cancelled'
                            ];
                            if($save->update("shortleave",$fieldsUpdate,$id)) {
                                $fieldsInsert = [
                                    'shortleave_id'=>$id,
                                    'requestNo'=>$requestNo,
                                    'staff_id'=>$staffId,
                                    'status'=>$ApprovalText,
                                    'notes'=>$notes,
                                    'ipAddress'=>$get->getUserIP()
                                ];
                                $save->insert("shortleave_history",$fieldsInsert);
                                //Saving in system_emails here...
                                $history = $getIdInfo->readData("SELECT * FROM shortleave_history WHERE shortleave_id = $id ORDER BY id DESC");
                                $from_name = 'hrms@nct.edu.om';
                                $from = 'HRMS - 3.0';
                                $shl = $get->singleReadFullQry("SELECT * FROM shortleave WHERE id = $id");
                                $shLName = $get->getStaffName($shl['staff_id'],'firstName','secondName','thirdName','lastName');
                                $subject = 'NCT-HRMD SHORT LEAVE CANCELLED FILED BY '.strtoupper($shLName);
                                $leaveDuration = "From ".$shl['startTime']." to ".$shl['endTime'];
                                $email = $contact_details->getContactInfo(2,$shl['staff_id'],'data');
                                $gsm = $contact_details->getContactInfo(1,$shl['staff_id'],'data');
                                $shLDeptId = $getIdInfo->employmentIDs($shl['staff_id'],'department_id');
                                $email_department = $getIdInfo->fieldNameValue("department",$shLDeptId,"name");
                                $message = '<html><body>';
                                $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                $message .= "<h3>NCT-HRMS 3.0 SHORT LEAVE DETAILS</h3>";
                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Declined</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$shl['requestNo']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DATE:</strong> </td><td>".date('d/m/Y',strtotime($shl['leaveDate']))."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>NUMBER OF HOURS:</strong> </td><td>".$shl['total']."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$shl['staff_id']."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$shLName."</td></tr>";
                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$email."</td></tr>";
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
                                unset($to);
                                $to = array();
                                $row = $get->singleReadFullQry("SELECT id, department_id, position_id, approverInSequence1 FROM approvalsequence_shortleave WHERE active = 1 AND position_id = $myPositionId");
                                $myApproverPositionId = $row['approverInSequence1'];
                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $myApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                $nextApproverStaffId = $nextApprover['staff_id'];
                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproverStaffId,'data');
                                array_push($to,$email,$nextApproverEmailAdd);

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
                                        'requestNo'=>$requestNo,
                                        'moduleName'=>'Short Leave Application Cancelled',
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
                                        'moduleName'=>'Short Leave Application Cancelled',
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
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Short leave has been cancelled! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    }          
                

                } else if ($_GET['approvalType'] == 'stl') { //Standard Leave --ALL DONE AND WORKING--
                    if($_GET['action'] == 1) { //If button Approve "Selected Record" is Clicked --> Multiple approvals at the same time...
                        $approverId     = $_GET['approverId'];
                        $approverEmail  = $_GET['approverEmail'];
                        $ids            = $_GET['requestNoS'];
                        $notes          = "Approved.";
                        $sql            = "SELECT * FROM standardleave WHERE id IN ($ids)";
                        $rows           = $helper->readData($sql);

                        $get            = new DbaseManipulation;
                        $save           = new DbaseManipulation;
                        $contact_details= new DbaseManipulation;
                        $getIdInfo      = new DbaseManipulation;
                        foreach($rows as $rowOut){
                                $id                         = $rowOut['id'];
                                $requestNoS                 = $rowOut['requestNo'];
                                $position_id                = $getIdInfo->employmentIDs($rowOut['staff_id'],'position_id');                                                                                            
                                $no_of_days                 = $rowOut['total'];
                                
                                $ipAddress                  = $get->getUserIP();
                                $to                         = array();
                                $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                                $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                                $ApprovalText               = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                                $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                                if($helper->totalCount != 0) {
                                    $sequence_numbers = array();
                                    foreach($rowsSeq as $row){
                                        array_push($sequence_numbers,$row['sequence_no']);
                                    }
                                    $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                                }
                                
                                if($no_of_days >= $deanApprovalLimit) {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                } else {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                }
                                $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                                $nextApproverId             = $nextApprover['approver_id'];
                                $nextSequenceNumber         = $nextApprover['sequence_no'];
                                $isFinal                    = $next['is_final'];
                                if($isFinal == 1) {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    //Check first what type of leave it is...
                                    $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                                    if($leave['leavetype_id'] != 2) { //Internal Leave...
                                        $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Approved' WHERE internalleavebalance_id = '$requestNoS'";
                                    } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                        $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Approved' WHERE emergencyleavebalance_id = '$requestNoS'";
                                    }
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Approved' WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            $helper->executeSQL($leave_balance_update);
                                            //echo "Send Email Here, this is the final approval part...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') APPROVAL BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>APPROVED</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                            $message .= "</table>";
                                            $message .= "<hr/>";
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                            
                                            //Email of the HR HoD or whoever wants to be informed...
                                            $info = new DbaseManipulation;
                                            $info2 = new DbaseManipulation;
                                            $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                            if($info2->totalCount != 0) {
                                                foreach($finals as $final){
                                                    $staff_id = $final['staff_id'];
                                                    $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                                    if(!in_array($email_address_finals, $to)){
                                                        array_push($to,$email_address_finals);
                                                    }
                                                }
                                            }
                                            
                                            array_push($to,$logged_in_email,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Standard Leave Approval',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                } else {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            //echo "Send Email Here, there is still more approvals coming...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') APPROVAL BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Pending</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                            $message .= "</table>";
                                            $message .= "<hr/>";
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                            
                                            $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                            $nextApproversStaffId = $nextApprover['staff_id'];
                                            $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                            array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Standard Leave Approval',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                } 
                        }                   
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Selected standard leave has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 2) { //If button Approve is Clicked --> Single approval only...
                        $id                         = $_GET['id'];
                        $position_id                = $_GET['position_id'];
                        $approverId                 = $_GET['approverId'];
                        $approverEmail              = $_GET['approverEmail'];
                        $requestNoS                 = $_GET['requestNoS'];
                        $notes                      = $_GET['notes'];
                        $no_of_days                 = $_GET['no_of_days'];
                        
                        $get                        = new DbaseManipulation;
                        $save                       = new DbaseManipulation;
                        $contact_details            = new DbaseManipulation;
                        $getIdInfo                  = new DbaseManipulation;
                        $ipAddress                  = $get->getUserIP();
                        $to                         = array();
                        $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                        $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                        $ApprovalText               = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                        $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                        if($helper->totalCount != 0) {
                            $sequence_numbers = array();
                            foreach($rowsSeq as $row){
                                array_push($sequence_numbers,$row['sequence_no']);
                            }
                            $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                        }

                        if($no_of_days >= $deanApprovalLimit) {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        } else {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        }
                        $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                        $nextApproverId             = $nextApprover['approver_id'];
                        $nextSequenceNumber         = $nextApprover['sequence_no'];
                        $isFinal                    = $next['is_final'];
                        if($isFinal == 1) {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            //Check first what type of leave it is...
                            $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                            if($leave['leavetype_id'] != 2) { //Internal Leave...
                                $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Approved' WHERE internalleavebalance_id = '$requestNoS'";
                            } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Approved' WHERE emergencyleavebalance_id = '$requestNoS'";
                            }
                            $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Approved' WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $helper->executeSQL($leave_balance_update);
                                    //echo "Send Email Here, this is the final approval part...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') APPROVAL BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>APPROVED</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                    $message .= "</table>";
                                    $message .= "<hr/>";
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                    
                                    //Email of the HR HoD or whoever wants to be informed...
                                    $info = new DbaseManipulation;
                                    $info2 = new DbaseManipulation;
                                    $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                    if($info2->totalCount != 0) {
                                        foreach($finals as $final){
                                            $staff_id = $final['staff_id'];
                                            $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                            if(!in_array($email_address_finals, $to)){
                                                array_push($to,$email_address_finals);
                                            }
                                        }
                                    }
                                    
                                    array_push($to,$logged_in_email,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Standard Leave Approval',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        } else {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            $stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    //echo "Send Email Here, there is still more approvals coming...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') APPROVAL BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Pending</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                    $message .= "</table>";
                                    $message .= "<hr/>";
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                    
                                    $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                    $nextApproversStaffId = $nextApprover['staff_id'];
                                    $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                    array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Standard Leave Approval',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        }
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Standard leave has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 3) { //If button Decline is Clicked --> Single decline only...
                        $id                         = $_GET['id'];
                        $position_id                = $_GET['position_id'];
                        $approverId                 = $_GET['approverId'];
                        $approverEmail              = $_GET['approverEmail'];
                        $requestNoS                 = $_GET['requestNoS'];
                        $notes                      = $_GET['notes'];
                        $no_of_days                 = $_GET['no_of_days'];
                        
                        $get                        = new DbaseManipulation;
                        $save                       = new DbaseManipulation;
                        $contact_details            = new DbaseManipulation;
                        $getIdInfo                  = new DbaseManipulation;
                        $ipAddress                  = $get->getUserIP();
                        $to                         = array();
                        $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                        $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                        $ApprovalText               = "Declined - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                        $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                        if($helper->totalCount != 0) {
                            $sequence_numbers = array();
                            foreach($rowsSeq as $row){
                                array_push($sequence_numbers,$row['sequence_no']);
                            }
                            $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                        }

                        if($no_of_days >= $deanApprovalLimit) {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        } else {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        }
                        $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                        $nextApproverId             = $nextApprover['approver_id'];
                        $nextSequenceNumber         = $nextApprover['sequence_no'];
                        $isFinal                    = $next['is_final'];
                        if($isFinal == 1) {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            //Check first what type of leave it is...
                            $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                            if($leave['leavetype_id'] != 2) { //Internal Leave...
                                $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                            } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                            }
                            $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $helper->executeSQL($leave_balance_update);
                                    //echo "Send Email Here, this is the final approval part...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') DECLINED BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>DECLINED</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                    $message .= "</table>";
                                    $message .= "<hr/>";
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                    
                                    //Email of the HR HoD or whoever wants to be informed...
                                    $info = new DbaseManipulation;
                                    $info2 = new DbaseManipulation;
                                    $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                    if($info2->totalCount != 0) {
                                        foreach($finals as $final){
                                            $staff_id = $final['staff_id'];
                                            $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                            if(!in_array($email_address_finals, $to)){
                                                array_push($to,$email_address_finals);
                                            }
                                        }
                                    }
                                    
                                    array_push($to,$logged_in_email,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Standard Leave Declined',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        } else {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            //Check first what type of leave it is...
                            $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                            if($leave['leavetype_id'] != 2) { //Internal Leave...
                                $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                            } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                            }
                            $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                            //$stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $helper->executeSQL($leave_balance_update);
                                    //echo "Send Email Here, there is still more approvals coming...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') DECLINED BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>DECLINED</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                    $message .= "</table>";
                                    $message .= "<hr/>";
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                    
                                    $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                    $nextApproversStaffId = $nextApprover['staff_id'];
                                    $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                    array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Standard Leave Declined',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        }
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Standard leave has been declined! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 4) { //If button Decline "Selected Record" is Clicked --> Multiple declines at the same time...
                        $approverId     = $_GET['approverId'];
                        $approverEmail  = $_GET['approverEmail'];
                        $ids            = $_GET['requestNoS'];
                        $notes          = "Declined.";
                        $sql            = "SELECT * FROM standardleave WHERE id IN ($ids)";
                        $rows           = $helper->readData($sql);
                        
                        $get                        = new DbaseManipulation;
                        $save                       = new DbaseManipulation;
                        $contact_details            = new DbaseManipulation;
                        $getIdInfo                  = new DbaseManipulation;
                        foreach($rows as $rowOut){
                                $id                         = $rowOut['id'];
                                $requestNoS                 = $rowOut['requestNo'];
                                $position_id                = $getIdInfo->employmentIDs($rowOut['staff_id'],'position_id');                                                                                            
                                $no_of_days                 = $rowOut['total'];

                                $ipAddress                  = $get->getUserIP();
                                $to                         = array();
                                $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                                $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                                $ApprovalText               = "Declined - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                                $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                                if($helper->totalCount != 0) {
                                    $sequence_numbers = array();
                                    foreach($rowsSeq as $row){
                                        array_push($sequence_numbers,$row['sequence_no']);
                                    }
                                    $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                                }

                                if($no_of_days >= $deanApprovalLimit) {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                } else {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                }
                                $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                                $nextApproverId             = $nextApprover['approver_id'];
                                $nextSequenceNumber         = $nextApprover['sequence_no'];
                                $isFinal                    = $next['is_final'];
                                if($isFinal == 1) {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    //Check first what type of leave it is...
                                    $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                                    if($leave['leavetype_id'] != 2) { //Internal Leave...
                                        $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                                    } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                        $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                                    }
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            $helper->executeSQL($leave_balance_update);
                                            //echo "Send Email Here, this is the final approval part...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') DECLINED BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>DECLINED</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                            $message .= "</table>";
                                            $message .= "<hr/>";
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                            
                                            //Email of the HR HoD or whoever wants to be informed...
                                            $info = new DbaseManipulation;
                                            $info2 = new DbaseManipulation;
                                            $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                            if($info2->totalCount != 0) {
                                                foreach($finals as $final){
                                                    $staff_id = $final['staff_id'];
                                                    $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                                    if(!in_array($email_address_finals, $to)){
                                                        array_push($to,$email_address_finals);
                                                    }
                                                }
                                            }
                                            
                                            array_push($to,$logged_in_email,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Standard Leave Declined',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                } else {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    //Check first what type of leave it is...
                                    $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                                    if($leave['leavetype_id'] != 2) { //Internal Leave...
                                        $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                                    } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                        $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                                    }
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                                    //$stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            $helper->executeSQL($leave_balance_update);
                                            //echo "Send Email Here, there is still more approvals coming...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD STANDARD LEAVE ('.$leaveType.') DECLINED BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>DECLINED</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$leaveType."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                            $message .= "</table>";
                                            $message .= "<hr/>";
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                            
                                            $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                            $nextApproversStaffId = $nextApprover['staff_id'];
                                            $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                            array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Standard Leave Declined',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                }
                        }        
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Selected standard leave has been declined! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    }
                

                } else if ($_GET['approvalType'] == 'om') { //Official Duty --ALL DONE AND WORKING--
                    if($_GET['action'] == 1) { //If button Approve "Selected Record" is Clicked --> Multiple approvals at the same time...
                        $approverId     = $_GET['approverId'];
                        $approverEmail  = $_GET['approverEmail'];
                        $ids            = $_GET['requestNoS'];
                        $notes          = "Approved.";
                        $sql            = "SELECT * FROM standardleave WHERE id IN ($ids)";
                        $rows           = $helper->readData($sql);

                        $get            = new DbaseManipulation;
                        $save           = new DbaseManipulation;
                        $contact_details= new DbaseManipulation;
                        $getIdInfo      = new DbaseManipulation;
                        foreach($rows as $rowOut){
                                $id                         = $rowOut['id'];
                                $requestNoS                 = $rowOut['requestNo'];
                                $position_id                = $getIdInfo->employmentIDs($rowOut['staff_id'],'position_id');                                                                                            
                                $no_of_days                 = $rowOut['total'];
                                
                                $ipAddress                  = $get->getUserIP();
                                $to                         = array();
                                $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                                $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                                $ApprovalText               = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                                $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                                if($helper->totalCount != 0) {
                                    $sequence_numbers = array();
                                    foreach($rowsSeq as $row){
                                        array_push($sequence_numbers,$row['sequence_no']);
                                    }
                                    $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                                }
                                
                                if($no_of_days >= $deanApprovalLimit) {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                } else {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                }
                                $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                                $nextApproverId             = $nextApprover['approver_id'];
                                $nextSequenceNumber         = $nextApprover['sequence_no'];
                                $isFinal                    = $next['is_final'];
                                if($isFinal == 1) {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    //Check first what type of leave it is...
                                    $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                                    if($leave['leavetype_id'] == 13) { //Official Duty...
                                        $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Approved' WHERE internalleavebalance_id = '$requestNoS'";
                                    } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                        $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Approved' WHERE emergencyleavebalance_id = '$requestNoS'";
                                    }
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Approved' WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            $helper->executeSQL($leave_balance_update);
                                            //echo "Send Email Here, this is the final approval part...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD OFFICIAL DUTY APPROVAL BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>APPROVED</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
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
                                            
                                            //Email of the HR HoD or whoever wants to be informed...
                                            $info = new DbaseManipulation;
                                            $info2 = new DbaseManipulation;
                                            $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                            if($info2->totalCount != 0) {
                                                foreach($finals as $final){
                                                    $staff_id = $final['staff_id'];
                                                    $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                                    if(!in_array($email_address_finals, $to)){
                                                        array_push($to,$email_address_finals);
                                                    }
                                                }
                                            }
                                            
                                            array_push($to,$logged_in_email,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Official Duty Approval',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                } else {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            //echo "Send Email Here, there is still more approvals coming...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD OFFICIAL DUTY APPROVAL BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Pending</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
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
                                            
                                            $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                            $nextApproversStaffId = $nextApprover['staff_id'];
                                            $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                            array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Official Duty Approval',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                } 
                        }                   
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Selected standard leave has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 2) { //If button Approve is Clicked --> Single approval only...
                        $id                         = $_GET['id'];
                        $position_id                = $_GET['position_id'];
                        $approverId                 = $_GET['approverId'];
                        $approverEmail              = $_GET['approverEmail'];
                        $requestNoS                 = $_GET['requestNoS'];
                        $notes                      = $_GET['notes'];
                        $no_of_days                 = $_GET['no_of_days'];
                        
                        $get                        = new DbaseManipulation;
                        $save                       = new DbaseManipulation;
                        $contact_details            = new DbaseManipulation;
                        $getIdInfo                  = new DbaseManipulation;
                        $ipAddress                  = $get->getUserIP();
                        $to                         = array();
                        $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                        $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                        $ApprovalText               = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                        $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                        if($helper->totalCount != 0) {
                            $sequence_numbers = array();
                            foreach($rowsSeq as $row){
                                array_push($sequence_numbers,$row['sequence_no']);
                            }
                            $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                        }

                        if($no_of_days >= $deanApprovalLimit) {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        } else {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        }
                        $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                        $nextApproverId             = $nextApprover['approver_id'];
                        $nextSequenceNumber         = $nextApprover['sequence_no'];
                        $isFinal                    = $next['is_final'];
                        if($isFinal == 1) {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            //Check first what type of leave it is...
                            $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                            if($leave['leavetype_id'] == 13) { //Official Duty...
                                $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Approved' WHERE internalleavebalance_id = '$requestNoS'";
                            } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Approved' WHERE emergencyleavebalance_id = '$requestNoS'";
                            }
                            $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Approved' WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $helper->executeSQL($leave_balance_update);
                                    //echo "Send Email Here, this is the final approval part...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD OFFICIAL DUTY APPROVAL BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>APPROVED</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
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
                                    
                                    //Email of the HR HoD or whoever wants to be informed...
                                    $info = new DbaseManipulation;
                                    $info2 = new DbaseManipulation;
                                    $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                    if($info2->totalCount != 0) {
                                        foreach($finals as $final){
                                            $staff_id = $final['staff_id'];
                                            $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                            if(!in_array($email_address_finals, $to)){
                                                array_push($to,$email_address_finals);
                                            }
                                        }
                                    }
                                    
                                    array_push($to,$logged_in_email,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Official Duty Approval',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        } else {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            $stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    //echo "Send Email Here, there is still more approvals coming...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD OFFICIAL DUTY APPROVAL BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Pending</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
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
                                    
                                    $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                    $nextApproversStaffId = $nextApprover['staff_id'];
                                    $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                    array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Official Duty Approval',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        }
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Standard leave has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 3) { //If button Decline is Clicked --> Single decline only...
                        $id                         = $_GET['id'];
                        $position_id                = $_GET['position_id'];
                        $approverId                 = $_GET['approverId'];
                        $approverEmail              = $_GET['approverEmail'];
                        $requestNoS                 = $_GET['requestNoS'];
                        $notes                      = $_GET['notes'];
                        $no_of_days                 = $_GET['no_of_days'];
                        
                        $get                        = new DbaseManipulation;
                        $save                       = new DbaseManipulation;
                        $contact_details            = new DbaseManipulation;
                        $getIdInfo                  = new DbaseManipulation;
                        $ipAddress                  = $get->getUserIP();
                        $to                         = array();
                        $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                        $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                        $ApprovalText               = "Declined - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                        $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                        if($helper->totalCount != 0) {
                            $sequence_numbers = array();
                            foreach($rowsSeq as $row){
                                array_push($sequence_numbers,$row['sequence_no']);
                            }
                            $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                        }

                        if($no_of_days >= $deanApprovalLimit) {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        } else {
                            $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                            $next                   = $get->singleReadFullQry($next_seq_sql);
                            $next_sequence_no       = $next['sequence_no'] + 1;
                            $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        }
                        $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                        $nextApproverId             = $nextApprover['approver_id'];
                        $nextSequenceNumber         = $nextApprover['sequence_no'];
                        $isFinal                    = $next['is_final'];
                        if($isFinal == 1) {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            //Check first what type of leave it is...
                            $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                            if($leave['leavetype_id'] == 13) { //Official Duty...
                                $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                            } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                            }
                            $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $helper->executeSQL($leave_balance_update);
                                    //echo "Send Email Here, this is the final approval part...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD OFFICIAL DUTY DECLINED BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>DECLINED</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
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
                                    
                                    //Email of the HR HoD or whoever wants to be informed...
                                    $info = new DbaseManipulation;
                                    $info2 = new DbaseManipulation;
                                    $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                    if($info2->totalCount != 0) {
                                        foreach($finals as $final){
                                            $staff_id = $final['staff_id'];
                                            $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                            if(!in_array($email_address_finals, $to)){
                                                array_push($to,$email_address_finals);
                                            }
                                        }
                                    }
                                    
                                    array_push($to,$logged_in_email,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Official Duty Declined',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        } else {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            //Check first what type of leave it is...
                            $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                            if($leave['leavetype_id'] == 13) { //Official Duty...
                                $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                            } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                            }
                            $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                            //$stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                            $notes = $helper->cleanString($notes);
                            $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $helper->executeSQL($leave_balance_update);
                                    //echo "Send Email Here, there is still more approvals coming...";
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                    $to = array();
                                    
                                    $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                    $request_no = $leaveInfo['requestNo'];
                                    $date_filed = $leaveInfo['dateFiled'];
                                    $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                    $total = $leaveInfo['total'];
                                    $staff_id = $leaveInfo['staff_id'];
                                    $staffName = $leaveInfo['staffName'];
                                    $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                    $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                    $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                    $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                    
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD OFFICIAL DUTY DECLINED BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>DECLINED</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
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
                                    
                                    $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                    $nextApproversStaffId = $nextApprover['staff_id'];
                                    $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                    array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Official Duty Declined',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        }
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Standard leave has been declined! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 4) { //If button Decline "Selected Record" is Clicked --> Multiple declines at the same time...
                        $approverId     = $_GET['approverId'];
                        $approverEmail  = $_GET['approverEmail'];
                        $ids            = $_GET['requestNoS'];
                        $notes          = "Declined.";
                        $sql            = "SELECT * FROM standardleave WHERE id IN ($ids)";
                        $rows           = $helper->readData($sql);
                        
                        $get                        = new DbaseManipulation;
                        $save                       = new DbaseManipulation;
                        $contact_details            = new DbaseManipulation;
                        $getIdInfo                  = new DbaseManipulation;
                        foreach($rows as $rowOut){
                                $id                         = $rowOut['id'];
                                $requestNoS                 = $rowOut['requestNo'];
                                $position_id                = $getIdInfo->employmentIDs($rowOut['staff_id'],'position_id');                                                                                            
                                $no_of_days                 = $rowOut['total'];

                                $ipAddress                  = $get->getUserIP();
                                $to                         = array();
                                $row                        = $get->singleReadFullQry("SELECT * FROM standardleave WHERE id IN ($id)");
                                $deanApprovalLimit          = $get->fieldNameValue("leavetype",$row['leavetype_id'],'deanApprovalLimit');
                                $ApprovalText               = "Declined - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                                $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                                if($helper->totalCount != 0) {
                                    $sequence_numbers = array();
                                    foreach($rowsSeq as $row){
                                        array_push($sequence_numbers,$row['sequence_no']);
                                    }
                                    $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                                }

                                if($no_of_days >= $deanApprovalLimit) {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave_5 WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                } else {
                                    $next_seq_sql           = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                                    $next                   = $get->singleReadFullQry($next_seq_sql);
                                    $next_sequence_no       = $next['sequence_no'] + 1;
                                    $sql_for_next_approval  = "SELECT TOP 1 * FROM approvalsequence_standardleave WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                                }
                                $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                                $nextApproverId             = $nextApprover['approver_id'];
                                $nextSequenceNumber         = $nextApprover['sequence_no'];
                                $isFinal                    = $next['is_final'];
                                if($isFinal == 1) {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    //Check first what type of leave it is...
                                    $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                                    if($leave['leavetype_id'] == 13) { //Official Duty...
                                        $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                                    } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                        $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                                    }
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            $helper->executeSQL($leave_balance_update);
                                            //echo "Send Email Here, this is the final approval part...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD OFFICIAL DUTY DECLINED BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>DECLINED</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
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
                                            
                                            //Email of the HR HoD or whoever wants to be informed...
                                            $info = new DbaseManipulation;
                                            $info2 = new DbaseManipulation;
                                            $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                            if($info2->totalCount != 0) {
                                                foreach($finals as $final){
                                                    $staff_id = $final['staff_id'];
                                                    $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                                    if(!in_array($email_address_finals, $to)){
                                                        array_push($to,$email_address_finals);
                                                    }
                                                }
                                            }
                                            
                                            array_push($to,$logged_in_email,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Official Duty Declined',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                } else {
                                    //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                                    //echo "<br/>Next Approver: ".$nextApproverId;
                                    //Check first what type of leave it is...
                                    $leave = $helper->singleReadFullQry("SELECT leavetype_id FROM standardleave WHERE id = $id");
                                    if($leave['leavetype_id'] == 13) { //Officiam Duty...
                                        $leave_balance_update = "UPDATE internalleavebalancedetails SET status = 'Declined', total = 0 WHERE internalleavebalance_id = '$requestNoS'";
                                    } else if ($leave['leavetype_id'] == 2) { //Emergency Leave...
                                        $leave_balance_update = "UPDATE emergencyleavebalancedetails SET status = 'Declined', total = 0 WHERE emergencyleavebalance_id = '$requestNoS'";
                                    }
                                    $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Declined' WHERE id = $id";
                                    //$stl_tbl_qry_update     = "UPDATE standardleave SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                                    $notes = $helper->cleanString($notes);
                                    $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                                    if($save->executeSQL($stl_tbl_qry_update)){
                                        if($save->executeSQL($stl_tbl_qry_insert)){
                                            $helper->executeSQL($leave_balance_update);
                                            //echo "Send Email Here, there is still more approvals coming...";
                                            $getIdInfo = new DbaseManipulation;
                                            $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                            $leaveInfo = $getIdInfo->singleReadFullQry("SELECT TOP 1 stl.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM standardleave as stl LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id WHERE stl.id = $id");
                                            $leaveDuration = 'From '.date('d/m/Y',strtotime($leaveInfo['startDate'])).' to '.date('d/m/Y',strtotime($leaveInfo['endDate']));
                                            $to = array();
                                            
                                            $leaveType = $getIdInfo->fieldNameValue("leavetype",$leaveInfo['leavetype_id'],'name');
                                            $request_no = $leaveInfo['requestNo'];
                                            $date_filed = $leaveInfo['dateFiled'];
                                            $date_filed = date('d/m/Y H:i:s',strtotime($date_filed));
                                            $total = $leaveInfo['total'];
                                            $staff_id = $leaveInfo['staff_id'];
                                            $staffName = $leaveInfo['staffName'];
                                            $dept_id = $helper->employmentIDs($staff_id,'department_id');
                                            $email_department = $getIdInfo->fieldNameValue("department",$dept_id,"name");
                                            $staff_email = $helper->getContactInfo(2,$staff_id,'data');
                                            $staff_gsm = $helper->getContactInfo(1,$staff_id,'data');
                                            
                                            $from_name = 'hrms@nct.edu.om';
                                            $from = 'HRMS - 3.0';
                                            $subject = 'NCT-HRMD OFFICIAL DUTY DECLINED BY '.strtoupper($logged_name);
                                            $message = '<html><body>';
                                            $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                            $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                            $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>DECLINED</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$request_no."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".$date_filed."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$total."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$staffName."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                            $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                            $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$staff_gsm."</td></tr>";
                                            $message .= "</table>";
                                            $message .= "<hr/>";
                                            $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$leaveType.") HISTORIES</h3>";
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
                                            
                                            $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                            $nextApproversStaffId = $nextApprover['staff_id'];
                                            $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                            array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                            //Save Email Information in the system_emails table...
                                            $from_name = $from_name;
                                            $from = $from;
                                            $subject = $subject;
                                            $message = $message;
                                            $transactionDate = date('Y-m-d H:i:s',time());
                                            $to = $to;
                                            $recipients = implode(', ', $to);
                                            $emailFields = [
                                                'requestNo'=>$requestNoS,
                                                'moduleName'=>'Official Duty Declined',
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
                                            //echo $saveEmail->displayArr($emailFields);
                                            $saveEmail->insert("system_emails",$emailFields);
                                        }
                                    }
                                }
                        }        
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Selected standard leave has been declined! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    }        
                

                } else if ($_GET['approvalType'] == 'otl') { //Overtime Leave
                    if($_GET['action'] == 1) { //If button Approve Selected Record is Clicked, NOT YET WORKING
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Selected overtime WAS NOT APPROVED! KINDLY APPROVE THEM ONE AT A TIME <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 2) { //If button Approve is Clicked --> Single approval only...
                        $id                         = $_GET['id'];
                        $position_id                = $_GET['position_id'];
                        $approverId                 = $_GET['approverId'];
                        $approverEmail              = $_GET['approverEmail'];
                        $requestNoS                 = $_GET['requestNoS'];
                        $notes                      = $_GET['notes'];
                        
                        $get                        = new DbaseManipulation;
                        $save                       = new DbaseManipulation;
                        $contact_details            = new DbaseManipulation;
                        $getIdInfo                  = new DbaseManipulation;
                        $ipAddress                  = $get->getUserIP();
                        $to                         = array();
                        $ApprovalText               = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                        $rowsSeq                    = $helper->readData("SELECT DISTINCT(sequence_no) FROM internalleaveovertime_approvalsequence WHERE approver_id = $myPositionId");
                        if($helper->totalCount != 0) {
                            $sequence_numbers = array();
                            foreach($rowsSeq as $row){
                                array_push($sequence_numbers,$row['sequence_no']);
                            }
                            $myCurrentSequenceNo    = implode(', ', $sequence_numbers);
                        }

                        
                        $next_seq_sql               = "SELECT TOP 1 * FROM internalleaveovertime_approvalsequence WHERE position_id = $position_id AND approver_id = $myPositionId AND active = 1 ORDER BY sequence_no";
                        $next                       = $get->singleReadFullQry($next_seq_sql);
                        $next_sequence_no           = $next['sequence_no'] + 1;
                        $sql_for_next_approval      = "SELECT TOP 1 * FROM internalleaveovertime_approvalsequence WHERE position_id = $position_id AND sequence_no = $next_sequence_no AND active = 1 ORDER BY sequence_no";
                        $nextApprover               = $get->singleReadFullQry($sql_for_next_approval);
                        $nextApproverId             = $nextApprover['approver_id'];
                        $nextSequenceNumber         = $nextApprover['sequence_no'];
                        $isFinal                    = $next['is_final'];
                        if($isFinal == 1) {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            $stl_tbl_qry_update     = "UPDATE internalleaveovertime SET currentStatus = 'Approved' WHERE id = $id";
                            $stl_tbl_qry_insert     = "INSERT INTO internalleaveovertime_history (internalleaveovertime_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $stl_tbl_qry_update_draft     = "UPDATE internalleaveovertimedetails_draft SET status = 'Approved' WHERE internalleaveovertime_id = '$requestNoS'";
                                    $save->executeSQL($stl_tbl_qry_update_draft);
                                    //echo "<br/>Final Approver! Send Email Here"; exit;
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM internalleaveovertime_history WHERE requestNo = '$requestNoS' ORDER BY id DESC");
                                    $startEnd = $getIdInfo->singleReadFullQry("SELECT TOP 1 * FROM internalleaveovertimedetails_draft WHERE internalleaveovertime_id = '$requestNoS'");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($startEnd['startDate'])).' to '.date('d/m/Y',strtotime($startEnd['endDate']));
                                    $staffRows = $helper->readData("SELECT staffId FROM internalleaveovertimedetails_draft WHERE internalleaveovertime_id = '$requestNoS' AND status = 'Approved'");
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
                                    $subject = 'NCT-HRMD OVERTIME LEAVE APPROVAL BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 OVERTIME LEAVE DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNoS."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>CURRENT STATUS:</strong> </td><td>APPROVED</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>APPROVED BY:</strong> </td><td>".$logged_name."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>NOTES/COMMENTS:</strong> </td><td>".$notes."</td></tr>";
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
                                    
                                    //Email of the HR HoD or whoever wants to be informed...
                                    $info = new DbaseManipulation;
                                    $info2 = new DbaseManipulation;
                                    $finals = $info2->readData("SELECT staff_id FROM internalleaveovertime_finalinform WHERE active = 1");
                                    if($info2->totalCount != 0) {
                                        foreach($finals as $final){
                                            $staff_id = $final['staff_id'];
                                            $email_address_finals = $info->getContactInfo(2,$staff_id,'data');
                                            if(!in_array($email_address_finals, $to)){
                                                array_push($to,$email_address_finals);
                                            }
                                        }
                                    }

                                    $filer = $getIdInfo->singleReadFullQry("SELECT TOP 1 requestNo, createdBy FROM internalleaveovertimefiled WHERE requestNo = '$requestNoS' AND isFinalized = 'Y'");
                                    $filerStaffId = $filer['createdBy'];
                                    $filerEmailAdd = $getIdInfo->getContactInfo(2,$filerStaffId,'data');

                                    array_push($to,$logged_in_email,$filerEmailAdd);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Overtime Approval',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        } else {
                            //echo "<br/><br/>Next Sequence: ".$nextSequenceNumber;
                            //echo "<br/>Next Approver: ".$nextApproverId;
                            $stl_tbl_qry_update     = "UPDATE internalleaveovertime SET current_sequence_no = $nextSequenceNumber, current_approver_id = $nextApproverId WHERE id = $id";
                            $stl_tbl_qry_insert     = "INSERT INTO internalleaveovertime_history (internalleaveovertime_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNoS', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                            if($save->executeSQL($stl_tbl_qry_update)){
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    //echo "<br/>Go To Next Approver! Send Email Here"; exit;
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM internalleaveovertime_history WHERE requestNo = '$requestNoS' ORDER BY id DESC");
                                    $startEnd = $getIdInfo->singleReadFullQry("SELECT TOP 1 * FROM internalleaveovertimedetails_draft WHERE internalleaveovertime_id = '$requestNoS'");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($startEnd['startDate'])).' to '.date('d/m/Y',strtotime($startEnd['endDate']));
                                    $staffRows = $helper->readData("SELECT staffId FROM internalleaveovertimedetails_draft WHERE internalleaveovertime_id = '$requestNoS' AND status = 'Pending'");
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
                                    $subject = 'NCT-HRMD OVERTIME LEAVE APPROVAL BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 OVERTIME LEAVE DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$requestNoS."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>CURRENT STATUS:</strong> </td><td>Pending</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>APPROVED BY:</strong> </td><td>".$logged_name."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>NOTES/COMMENTS:</strong> </td><td>".$notes."</td></tr>";
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
                                    
                                    $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $nextApproverId AND isCurrent = 1 AND status_id = 1");
                                    $nextApproversStaffId = $nextApprover['staff_id'];
                                    $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');

                                    $filer = $getIdInfo->singleReadFullQry("SELECT TOP 1 requestNo, createdBy FROM internalleaveovertimefiled WHERE requestNo = '$requestNoS' AND isFinalized = 'Y'");
                                    $filerStaffId = $filer['createdBy'];
                                    $filerEmailAdd = $getIdInfo->getContactInfo(2,$filerStaffId,'data');

                                    array_push($to,$logged_in_email,$nextApproverEmailAdd,$filerEmailAdd);
                                    //Save Email Information in the system_emails table...
                                    $from_name = $from_name;
                                    $from = $from;
                                    $subject = $subject;
                                    $message = $message;
                                    $transactionDate = date('Y-m-d H:i:s',time());
                                    $to = $to;
                                    $recipients = implode(', ', $to);
                                    $emailFields = [
                                        'requestNo'=>$requestNoS,
                                        'moduleName'=>'Overtime Approval',
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
                                    //echo $saveEmail->displayArr($emailFields);
                                    $saveEmail->insert("system_emails",$emailFields);
                                }
                            }
                        }
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Overtime leave has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    }
                }      
            } else {
                if ($_GET['approvalType'] == 'stlcancel') { //Standard Leave (Cancel)
                    if($_GET['action'] == 1) { //If button cancel this request is Clicked (By the one who filed it)
                        $get                    = new DbaseManipulation;
                        $save                   = new DbaseManipulation;
                        $contact_details        = new DbaseManipulation;
                        $ipAddress              = $get->getUserIP();
                        $id                     = $_GET['id'];
                        $notes                  = $_GET['notes'];
                        $requestNo              = $_GET['requestNo'];
                        $ApprovalText           = "Cancelled By - ".$logged_name;
                        $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Cancelled' WHERE id = $id";
                        $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNo', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                        $stl_tbl_qry_return_credit = "UPDATE internalleavebalancedetails SET status = 'Cancelled', total = 0 WHERE internalleavebalance_id = '$requestNo'";
                        if($save->executeSQL($stl_tbl_qry_update)){ 
                            if($save->executeSQL($stl_tbl_qry_return_credit)) {                    
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $info = $get->singleReadFullQry("SELECT stl.*, l.name as leavetype FROM standardleave as stl LEFT OUTER JOIN leavetype as l ON l.id = stl.leavetype_id WHERE stl.id = $id");
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($info['startDate'])).' to '.date('d/m/Y',strtotime($info['endDate']));
                                    $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD STANDARD LEAVE ('.$info['leavetype'].') CANCELLED BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$info['leavetype'].") DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>LEAVE STATUS:</strong> </td><td>Cancelled</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$info['requestNo']."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>LEAVE TYPE:</strong> </td><td>".$info['leavetype']."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($info['dateFiled']))."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>LEAVE DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$info['total']."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$logged_in_gsm."</td></tr>";
                                    $message .= "</table>";
                                    $message .= "<hr/>";
                                    $message .= "<h3>NCT-HRMS 3.0 STANDARD LEAVE (".$info['leavetype'].") HISTORIES</h3>";
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
                                    array_push($to,$logged_in_email);
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
                                            'requestNo'=>$requestNo,
                                            'moduleName'=>'Standard Leave Cancellation',
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
                                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Standard leave has been cancelled! <span><a href='' class='btn btn-primary'><i class='fas fa-thumbs-up'></i> OK</a></span></div>";  
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
                                            'moduleName'=>'Standard Leave Cancellation',
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
                                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Standard leave has been cancelled! <span><a href='' class='btn btn-primary'><i class='fas fa-thumbs-up'></i> OK</a></span></div>";
                                    }  
                                }
                            }    
                        }
                    }
                } else if ($_GET['approvalType'] == 'OMcancel') { //Official Duty (Cancel)
                    if($_GET['action'] == 1) { //If button cancel this request is Clicked (By the one who filed it)
                        $get                    = new DbaseManipulation;
                        $save                   = new DbaseManipulation;
                        $contact_details        = new DbaseManipulation;
                        $ipAddress              = $get->getUserIP();
                        $id                     = $_GET['id'];
                        $notes                  = $_GET['notes'];
                        $requestNo              = $_GET['requestNo'];
                        $ApprovalText           = "Cancelled By - ".$logged_name;
                        $stl_tbl_qry_update     = "UPDATE standardleave SET currentStatus = 'Cancelled' WHERE id = $id";
                        $stl_tbl_qry_insert     = "INSERT INTO standardleave_history (standardleave_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNo', '$staffId', '$ApprovalText', '$notes', '$ipAddress')";
                        $stl_tbl_qry_return_credit = "UPDATE internalleavebalancedetails SET status = 'Cancelled', total = 0 WHERE internalleavebalance_id = '$requestNo'";
                        if($save->executeSQL($stl_tbl_qry_update)){ 
                            if($save->executeSQL($stl_tbl_qry_return_credit)) {                    
                                if($save->executeSQL($stl_tbl_qry_insert)){
                                    $info = $get->singleReadFullQry("SELECT stl.*, l.name as leavetype FROM standardleave as stl LEFT OUTER JOIN leavetype as l ON l.id = stl.leavetype_id WHERE stl.id = $id");
                                    $getIdInfo = new DbaseManipulation;
                                    $history = $getIdInfo->readData("SELECT * FROM standardleave_history WHERE standardleave_id = $id ORDER BY id DESC");
                                    $leaveDuration = 'From '.date('d/m/Y',strtotime($info['startDate'])).' to '.date('d/m/Y',strtotime($info['endDate']));
                                    $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                    $from_name = 'hrms@nct.edu.om';
                                    $from = 'HRMS - 3.0';
                                    $subject = 'NCT-HRMD OFFICIAL DUTY CANCELLED BY '.strtoupper($logged_name);
                                    $message = '<html><body>';
                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                    $message .= "<h3>NCT-HRMS 3.0 OFFICIAL DUTY DETAILS</h3>";
                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Cancelled</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>".$ApprovalText."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$info['requestNo']."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',strtotime($info['dateFiled']))."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>DUTY DURATION:</strong> </td><td>".$leaveDuration."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>NUMBER OF DAYS:</strong> </td><td>".$info['total']."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$logged_in_gsm."</td></tr>";
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
                                    array_push($to,$logged_in_email);
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
                                            'requestNo'=>$requestNo,
                                            'moduleName'=>'Official Duty Cancellation',
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
                                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i>  Official duty has been cancelled! <span><a href='' class='btn btn-primary'><i class='fas fa-thumbs-up'></i> OK</a></span></div>";  
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
                                            'moduleName'=>'Official Duty Cancellation',
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
                                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Official duty has been cancelled! <span><a href='' class='btn btn-primary'><i class='fas fa-thumbs-up'></i> OK</a></span></div>";
                                    }  
                                }
                            }    
                        }
                    }
                } else if ($_GET['approvalType'] == 'dlt') { 
                    if($_GET['action'] == 1) { //If button Approve is Clicked - Accept Delegation...
                        $id = $_GET['id'];
                        $delegation_id = $_GET['selected_ids'];
                        $ids = $_GET['selected_ids'];
                        $delegatorPositionId = $_GET['delegatorPositionId'];
                        $arrIds = explode(", ",$ids);
                        foreach($arrIds as $arrId){
                            if($arrId == 1) { //Short Leave Delegation
                                $sqlShLApproval = "UPDATE approvalsequence_shortleave SET approverInSequence1 = $myPositionId WHERE approverInSequence1 = $delegatorPositionId";
                                $helper->executeSQL($sqlShLApproval);
                                
                                if($user_type == 6) {
                                    $sql17 = "INSERT INTO delegation_pages_access (delegation_id, delegation_pages_id, access_menu_left_sub_id, user_type, active, createdBy) VALUES ($id, 1, 17, $user_type, 1, '$staffId')";
                                    $sql18 = "INSERT INTO delegation_pages_access (delegation_id, delegation_pages_id, access_menu_left_sub_id, user_type, active, createdBy) VALUES ($id, 1, 18, $user_type, 1, '$staffId')";
                                    //$helper->executeSQL($sql17);
                                    //$helper->executeSQL($sql18);
                                }    
                            } else if ($arrId == 2) { //Standard Leave Delegation
                                $sqlStLApproval = "UPDATE approvalsequence_standardleave SET approver_id = $myPositionId WHERE approver_id = $delegatorPositionId";
                                $helper->executeSQL($sqlStLApproval);

                                $sqlStLApproval5 = "UPDATE approvalsequence_standardleave_5 SET approver_id = $myPositionId WHERE approver_id = $delegatorPositionId";
                                $helper->executeSQL($sqlStLApproval5);

                                if($user_type == 6) {
                                    $sql23 = "INSERT INTO delegation_pages_access (delegation_id, delegation_pages_id, access_menu_left_sub_id, user_type, active, createdBy) VALUES ($id, 2, 23, $user_type, 1, '$staffId')";
                                    $sql24 = "INSERT INTO delegation_pages_access (delegation_id, delegation_pages_id, access_menu_left_sub_id, user_type, active, createdBy) VALUES ($id, 2, 24, $user_type, 1, '$staffId')";
                                    //$helper->executeSQL($sql23);
                                    //$helper->executeSQL($sql24);
                                }    
                            } else if ($arrId == 3) { //Overtime Leave Delegation
                                $sqlOTLApproval = "UPDATE internalleaveovertime_approvalsequence SET approver_id = $myPositionId WHERE approver_id = $delegatorPositionId";
                                $helper->executeSQL($sqlOTLApproval);
                                
                                if($user_type == 6) {
                                    $sql79 = "INSERT INTO delegation_pages_access (delegation_id, delegation_pages_id, access_menu_left_sub_id, user_type, active, createdBy) VALUES ($id, 3, 79, $user_type, 1, '$staffId')";
                                    $sql77 = "INSERT INTO delegation_pages_access (delegation_id, delegation_pages_id, access_menu_left_sub_id, user_type, active, createdBy) VALUES ($id, 3, 77, $user_type, 1, '$staffId')";
                                    //$helper->executeSQL($sql79);
                                    //$helper->executeSQL($sql77);
                                }    
                            } else if ($arrId == 4) { //Clearance Module Delegation
                                //Update this code once you are done with the Clearance...
                                $sql54 = "INSERT INTO delegation_pages_access (delegation_id, delegation_pages_id, access_menu_left_sub_id, user_type, active, createdBy) VALUES ($id, 4, 54, $user_type, 1, '$staffId')";
                                //$helper->executeSQL($sql54);
                            }
                        }
                        $get = new DbaseManipulation;
                        $sqlUpdateDelegation = "UPDATE delegation SET status = 'Active' WHERE id = $id";
                        $get->executeSQL($sqlUpdateDelegation);
                        
                        $ip = $get->getUserIP();
                        $requestNo = $get->cleanString($_GET['requestNo']);
                        $notes = $get->cleanString($_GET['notes']);
                        $sqlInsertDelegationHistory = "INSERT INTO delegation_history (delegation_id, requestNo, staff_id, status, notes, ipAddress) VALUES ($id, '$requestNo', $staffId, 'Delegation was accepted and the role is now active', '$notes', '$ip')";
                        $get->executeSQL($sqlInsertDelegationHistory);

                        //Create Email Here and Save it to the database!
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Delegation has been approved! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    } else if ($_GET['action'] == 2) { 
                        echo "<div class='text-primary'><i class='fas fa-info-circle'></i> Delegation has been declined! <span style='float:right'><a href='' class='btn btn-danger'><i class='fas fa-times'></i> CLOSE</a></span></div>";
                    }     
                } else {
                    include_once('not_allowed.php');
                }
            }    
        } else {
            include_once('not_allowed.php');
        }
    }
?>             
</html>