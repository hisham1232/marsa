<?php    
    include('include_headers.php');                                 
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Add Internal Balance to Staff - By Sponsor</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Leave Setttings</li>
                            <li class="breadcrumb-item">Add Internal Balance - By Sponsor</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-18"><!---start  leave application form div-->
                        <div class="card">
                            <div class="card-body">
                                <script>
                                    if (window.history.replaceState) { //Preventing system to re-submit once refreshed
                                        window.history.replaceState( null, null, window.location.href );
                                    }
                                </script>
                                <?php
                                    if(isset($_POST['submitAddedLeave'])){
                                        $request_no = $_POST['request_no'];
                                        if (!empty($_FILES['fileToUpload']['name'])) {
                                            $target_dir = "attachments/leaves/addedinternal/";
                                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                            $uploadOk = 1;
                                            //Not working on MSWord and MSExcel
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
                                                    <p>Either file type and file size BOTH not acceptable.</p>
                                                </div>
                                            <?php        
                                            } else { //if everything is ok, try to upload file
                                                $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                                                $extension = end($temp);
                                                $new_file_name = $request_no.".".$extension;
                                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "attachments/leaves/addedinternal/".$new_file_name)) {
                                                    $new_image = "attachments/leaves/addedinternal/".$new_file_name;
                                                    goto hell;                
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
                                                $save = new DbaseManipulation;
                                                $allStaff = new DbaseManipulation;
                                                $insert = new DbaseManipulation;
                                                $getContact = new DbaseManipulation;
                                                $sponsorGroup = $_POST['sponsorGroup'];
                                                if($sponsorGroup == 1) { //All Ministry Staff
                                                    $fields = [
                                                        'requestNo'=>$_POST['request_no'],
                                                        'dateFiled'=>date('Y-m-d H:i:s'),
                                                        'notes'=>$save->cleanString($_POST['notes']),
                                                        'attachment'=>$new_image,
                                                        'isFinalized'=>'Y',
                                                        'createdBy'=>$staffId
                                                    ];
                                                    if($save->insert("internalleavebalance",$fields)) {
                                                        $rows = $allStaff->readData("SELECT s.staffId FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.sponsor_id = 1 AND e.isCurrent = 1");
                                                        $startDate = $_POST['startDate'];
                                                        $endDate = $_POST['endDate'];
                                                        $total = $_POST['noOfDays'];
                                                        $to = array();
                                                        foreach($rows as $row){
                                                            $staff_id = $row['staffId'];
                                                            $fieldsInsert = [
                                                                'internalleavebalance_id'=>$_POST['request_no'],
                                                                'leavetype_id'=>1,
                                                                'staffId'=>$staff_id,
                                                                'startDate'=>$startDate,
                                                                'endDate'=>$endDate,
                                                                'total'=>$total,
                                                                'status'=>'Saved',
                                                                'notes'=>$save->cleanString($_POST['notes']),
                                                                'createdBy'=>$staffId
                                                            ];
                                                            if($insert->insert("internalleavebalancedetails",$fieldsInsert))
                                                                array_push($to,$getContact->getContactInfo(2,$staff_id,'data'));
                                                        }                
                                                        ?>
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>Internal leave balance has been added successfully. Leaves has been credited to all staff whose under MINISTRY sponsorship.</p>
                                                        </div>
                                                        <?php            
                                                    }
                                                } else if ($sponsorGroup == 2) { //All Company Staff
                                                    $fields = [
                                                        'requestNo'=>$_POST['request_no'],
                                                        'sponsorType'=>2,
                                                        'dateFiled'=>date('Y-m-d H:i:s'),
                                                        'notes'=>$save->cleanString($_POST['notes']),
                                                        'attachment'=>$new_image,
                                                        'isFinalized'=>'Y',
                                                        'createdBy'=>$staffId
                                                    ];
                                                    if($save->insert("internalleavebalance",$fields)) {
                                                        $rows = $allStaff->readData("SELECT s.staffId FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.sponsor_id != 1 AND e.isCurrent = 1");
                                                        $startDate = $_POST['startDate'];
                                                        $endDate = $_POST['endDate'];
                                                        $total = $_POST['noOfDays'];
                                                        $to = array();
                                                        foreach($rows as $row){
                                                            $staff_id = $row['staffId'];
                                                            $fieldsInsert = [
                                                                'internalleavebalance_id'=>$_POST['request_no'],
                                                                'leavetype_id'=>1,
                                                                'staffId'=>$staff_id,
                                                                'startDate'=>$startDate,
                                                                'endDate'=>$endDate,
                                                                'total'=>$total,
                                                                'status'=>'Saved',
                                                                'notes'=>$save->cleanString($_POST['notes']),
                                                                'createdBy'=>$staffId
                                                            ];
                                                            if($insert->insert("internalleavebalancedetails",$fieldsInsert))
                                                                array_push($to,$getContact->getContactInfo(2,$staff_id,'data'));
                                                        }
                                                        ?>
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                            <p>Internal leave balance has been added successfully. Leaves has been credited to all staff whose under COMPANY sponsorship.</p>
                                                        </div>
                                                        <?php            
                                                    }
                                                }
                                                $from_name = 'hrms@nct.edu.om';
                                                $from = 'HRMS - 3.0';
                                                $subject = 'NCT-HRMD INTERNAL LEAVE BALANCE CREDITED';
                                                $d = '-';
                                                $message = '<html><body>';
                                                $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                $message .= "<h3>NCT-HRMS 3.0</h3>";
                                                $message .= '<p>An internal leave balance has been added and credited into your HR account. Kindly login to HR System for more details.</p>';
                                                $message .= "</body></html>";
                                                $transactionDate = date('Y-m-d H:i:s',time());

                                                //Save Email Information in the system_emails table...
                                                $recipients = implode(', ', $to);
                                                $emailFields = [
                                                    'requestNo'=>$_POST['request_no'],
                                                    'moduleName'=>'Adding Internal Leave Balance',
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
                                        }
                                    }
                                ?>
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h3 class="card-title">ADD Internal Balance Form - By Sponsor</h3>
                                        <h6 class="card-subtitle">إستمارة اضافة رصيد داخلي - حسب نوع الكفيل </h6>
                                    </div>
                                </div>
                                <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">

                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Leave Minus ID</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                            <?php 
                                                $request = new DbaseManipulation;
                                                $requestNo = $request->requestNo("AIL-","internalleavebalance");
                                            ?>
                                            <h3 class="text-muted text-success"><span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3> </li>
                                            <input type="hidden" name="request_no" value="<?php echo $requestNo; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Sponsor</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <select name="sponsorGroup" class="form-control" required data-validation-required-message="Please select sponsor">
                                                        <option value="">Select Sponsor</option>
                                                        <option value="1">Ministry (All Ministry Staff)</option>
                                                        <option value="2">Company (All Company Staff)</option>
                                                    </select>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-diagnoses"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">                                                        
                                        <label class="col-sm-9 offset-sm-3 control-label text-primary"><small><em><i class="fa fa-info-circle"></i> All Staff under the selected sponsor will receive additional balance.</em></small></label>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Work Leave Date</label>
                                        <div class="col-sm-9">
                                            <div class='input-group mb-3'>
                                                <input type='text' class="form-control addDateRange" />
                                                <input type="hidden" name="startDate" class="form-control startDate" />
                                                <input type="hidden" name="endDate" class="form-control endDate" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Number of Days</label>                  
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" name="noOfDays" required data-validation-required-message="Number of days is required" class="form-control noOfDays" readonly> 
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Reason</label>                  
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <textarea class="form-control" name="notes" rows="2" required data-validation-required-message="Reasons is required" minlength="20"></textarea>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Attachment</label>
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
                                        <label  class="col-sm-3 control-label">Entered By</label>                  
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <input type="text" value="<?php echo $logged_name; ?>" class="form-control" readonly />
                                                    <input type="hidden" name="createdBy" value="<?php echo $staffId; ?>" class="form-control" readonly>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-3 control-label">Entered Date</label>                  
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                <input type="text" value="<?php echo date('d/m/Y H:i:s'); ?>" class="form-control" readonly>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><span class="far fa-calendar-alt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row m-b-0">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" name="submitAddedLeave" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end container fluid-->
            <footer class="footer">
                <?php include('include_footer.php'); ?>
            </footer>
        </div>
    </div>
    <?php include('include_scripts.php'); ?>  
</body>
</html>