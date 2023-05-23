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
                                    <h3 class="text-themecolor m-b-0 m-t-0">NCT E-Forms</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">E-Forms</li>
                                        <li class="breadcrumb-item">Request E-Forms</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header" style="background-color: #DCE7E6;">
                                            <div class="row">
                                                <div class="col-md-4"> 
                                                    <div class="d-flex flex-row">
                                                        <div class="mr-auto">
                                                            <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$staffId.'.jpg'; ?>" style=" width:100px; height:100px; border-radius: 50%" alt="Staff ID"><br>
                                                        </div>
                                                        <div style="margin-left:20px">
                                                            <?php
                                                                $bal = new DbaseManipulation;
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
                                                <div class="col-md-6"> 
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header bg-light-info m-b-0 p-b-0">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Create E-Forms Request Entry Form</h3>                    
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="card-body">
                                            <?php
                                                if(isset($_POST['submit'])) {
                                                    $formName = $helper->fieldNameValue("e_forms",$_POST['eformId'],'name');
                                                    $fields = [
                                                        'requestNo'=>$_POST['requestNo'],
                                                        'requestBy'=>$staffId,
                                                        'eFormId'=>$_POST['eformId'],
                                                        'status'=>"Pending",
                                                        'reason'=>$_POST['reason'],
                                                        'createdBy'=>$staffId
                                                    ];
                                                    if($helper->insert("e_forms_request",$fields)){
                                                        $email_department = $helper->fieldNameValue("department",$logged_in_department_id,"name");
                                                        $from_name = 'hrms@nct.edu.om';
                                                        $from = 'HRMS - 3.0';
                                                        $subject = 'NCT-HRMD E-FORMS REQUESTED BY '.strtoupper($logged_name);
                                                        $message = '<html><body>';
                                                        $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                        $message .= "<h3>NCT-HRMS 3.0 E-FORMS DETAILS</h3>";
                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$_POST['requestNo']."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>E-FORM NAME:</strong> </td><td>".$formName."</td></tr>";
                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REASON:</strong> </td><td>".$_POST['reason']."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>DATE FILED:</strong> </td><td>".date('d/m/Y H:i:s',time())."</td></tr>";
                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                        $message .= "</table>";
                                                        
                                                        $message .= "<br/>";
                                                        $message .= "</body></html>";
                                                        $to = array(); $hrStaffEmails = array();
                                                        $HRs = new DbaseManipulation;
                                                        $rows = $HRs->readData("SELECT e.staff_id, c.data FROM employmentdetail e LEFT OUTER JOIN contactdetails c ON c.staff_id = e.staff_id WHERE e.department_id = 13 AND c.contacttype_id = 2 and e.isCurrent = 1");
                                                        foreach($rows as $row){ array_push($to,$row['data']); }
                                                        array_push($to,$logged_in_email);
                                                        $emailParticipants = new sendMail;
                                                        if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
                                                            //Save Email Information in the system_emails table...
                                                            $from_name = $from_name;
                                                            $from = $from;
                                                            $subject = $subject;
                                                            $message = $message;
                                                            $transactionDate = date('Y-m-d H:i:s',time());
                                                            $recipients = implode(', ', $to);
                                                            $emailFields = [
                                                                'requestNo'=>$_POST['requestNo'],
                                                                'moduleName'=>'E-Forms Request',
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
                                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                    <p>E-Form request has been successfully submitted. Kindly contact the HR Department for more information.</p>
                                                                </div>
                                                            <?php
                                                        } else {
                                                            //Save Email Information in the system_emails table...
                                                            $from_name = $from_name;
                                                            $from = $from;
                                                            $subject = $subject;
                                                            $message = $message;
                                                            $transactionDate = date('Y-m-d H:i:s',time());
                                                            $recipients = implode(', ', $to);
                                                            $emailFields = [
                                                                'requestNo'=>$_POST['requestNo'],
                                                                'moduleName'=>'E-Forms Request',
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
                                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                    <p>E-Form request has been successfully submitted. Kindly contact the HR Department for more information.</p>
                                                                </div>
                                                            <?php    
                                                        }   
                                                    }
                                                }
                                            ?>        
                                            <form class="form-horizontal m-b-0" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <?php 
                                                    $request = new DbaseManipulation;
                                                    $requestNo = $request->requestNo("EFO-","e_forms_request");
                                                ?>
                                                <input type="hidden" name="requestNo" value="<?php echo $requestNo; ?>" />
                                                <div class="form-group row">
                                                    <label class="col-sm-12"><h3 class="text-muted text-success">New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3></label>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Select E-Form</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                            <select name="eformId" class="form-control" required data-validation-required-message="Please select user type">
                                                                <option value="">Select Form Here</option>
                                                                <?php 
                                                                    $rows = $helper->readData("SELECT id, name FROM e_forms WHERE active = 1 ORDER BY id");
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
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Reason</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                        <textarea name="reason" class="form-control" rows="2" required data-validation-required-message="Reasons for requesting is required" minlength="10"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3">&nbsp;</label>
                                                    <div class="col-sm-9">
                                                        <div class="controls">
                                                        <button name="submit" class="btn btn-info waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-paper-plane"></i> Submit Request</button>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>                           
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
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>