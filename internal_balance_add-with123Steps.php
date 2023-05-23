<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $dropdown = new DbaseManipulation;                        
?>
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Add Internal Balance to Staff</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Leave Setttings</li>
                                        <li class="breadcrumb-item">Add Internal Balance</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card card-body">
                                        <h4 class="box-title m-b-0">1. Search Deparment</h4>
                                        <span class="text-muted font-13"><em>Select the department of the staff you want to add balance.</em></span>
                                        <form class="form-horizontal m-b-0" action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Department</label>
                                                    <div class="col-sm-6">
                                                        <div class="controls">
                                                            <select name="department_id" class="form-control" required data-validation-required-message="Please select department">
                                                                <option value="">Select Department</option>
                                                                <?php
                                                                    $dropdown = new DbaseManipulation; 
                                                                    $rows = $dropdown->readData("SELECT id, name FROM department WHERE active = 1 ORDER BY id");
                                                                    $selected_department_id = $_GET['did'];
                                                                    foreach ($rows as $row) {
                                                                        if($row['id'] == $selected_department_id) {
                                                                            ?>
                                                                                <option value="<?php echo $row['id']; ?>" selected><?php echo $row['name']; ?></option>
                                                                            <?php        
                                                                        } else {    
                                                                ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php
                                                                        }            
                                                                    }    
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button name="searchDepartment" class="btn btn-success waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                    </div>
                                            </div><!--end form-group-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card" style="border-color: #eee;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-4 col-xs-18">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">2. Add Internal Balance Form</h3>
                                                                    <h6 class="card-subtitle"><em>Select Staff, Add Working Days, Click Submit</em></h6>
                                                                </div>
                                                            </div>
                                                            <div class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Staff</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <?php
                                                                                    if(isset($_POST['searchDepartment'])) {
                                                                                        $department_id = $_POST['department_id'];
                                                                                ?>
                                                                                        <select name="staff_id" class="custom-select select2 staffId" required data-validation-required-message="Please select staff name">
                                                                                        <option value="">Select Staff Here</option>
                                                                                            <?php 
                                                                                                $staff = new DbaseManipulation;
                                                                                                $rows = $staff->readData("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, e.status_id, e.isCurrent FROM staff as s INNER JOIN employmentdetail as e WHERE s.staffId = e.staff_id AND e.status_id = 1 AND e.isCurrent = 1 and e.department_id = $department_id ORDER by staffName");
                                                                                                foreach ($rows as $row) {
                                                                                            ?>
                                                                                                    <option value="<?php echo $row['staffId']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                                            <?php            
                                                                                                }    
                                                                                            ?>
                                                                                        </select>
                                                                                <?php        
                                                                                    } else {   
                                                                                            if(isset($_GET['uid'])) {
                                                                                                $uid = $_GET['uid'];
                                                                                                $staff_name = $dropdown->getStaffName($uid,'firstName','secondName','thirdName','lastName');
                                                                                                ?>
                                                                                                    <select name="staff_id" class="custom-select select2 staffId" required data-validation-required-message="Please select staff name">
                                                                                                        <option value="<?php echo $uid; ?>"><?php echo $staff_name; ?></option>
                                                                                                    </select>    
                                                                                                <?php
                                                                                            } else {
                                                                                        ?>    
                                                                                                    <select name="staff_id" class="custom-select select2" required data-validation-required-message="Please select staff">
                                                                                                        <option value="">Select Staff Here</option>
                                                                                                    </select>
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                <?php
                                                                                    }
                                                                                ?>        
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-user"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Date</label>
                                                                    <div class="col-sm-9">
                                                                        <div class='input-group mb-3'>
                                                                            <input type="text" name="addDateRange" class="form-control addDateRange" />
                                                                            <input type="hidden" name="startDate" class="form-control startDate" />
                                                                            <input type="hidden" name="endDate" class="form-control endDate" />
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Total</label>                  
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="noOfDays" value="" class="form-control noOfDays" readonly /> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-hashtag"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Notes</label>                  
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <textarea class="form-control notes" rows="2" required data-validation-required-message="Reasons for Add Balance is required" minlength="20"></textarea>
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2"><i class="far fa-comment"></i></span>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row m-b-0">
                                                                    <div class="offset-sm-3 col-sm-9">
                                                                        <button class="btn btn-primary waves-effect waves-light draftAddInternalLeave">Add Leave <i class="fa fa-arrow-right"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->

                                                <div class="col-lg-8 col-xs-18">
                                                    <div class="card">                         
                                                        <div class="card-body">
                                                            <?php
                                                                if(isset($_POST['finalizedSubmit'])){
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
                                                                            $fetch = new DbaseManipulation;
                                                                            $distinct = $fetch->readData("SELECT DISTINCT internalleavebalance_id, created, notes, createdBy FROM internalleavebalancedetails_draft GROUP BY internalleavebalance_id");
                                                                            $requestNoCollections = array();
                                                                            if($fetch->totalCount != 0) {
                                                                                $write = new DbaseManipulation;
                                                                                foreach($distinct as $row){
                                                                                    $fields = [
                                                                                        'requestNo'=>$row['internalleavebalance_id'],
                                                                                        'dateFiled'=>date('Y-m-d',strtotime($row['created'])),
                                                                                        'notes'=>$row['notes'],
                                                                                        'attachment'=>$new_image,
                                                                                        'isFinalized'=>'Y',
                                                                                        'createdBy'=>$row['createdBy']
                                                                                    ];
                                                                                    array_push($requestNoCollections,"'".$row['internalleavebalance_id']."'");
                                                                                    if($write->insert("internalleavebalance",$fields)) {                    
                                                                                    } else {
                                                                                        ?>
                                                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Unable to continue!</h4>
                                                                                            <p>An error occured during processing. Please contact your programmer.</p>
                                                                                        </div>
                                                                                        <?php                    
                                                                                    }
                                                                                }
                                                                                $write->executeSQL("UPDATE internalleavebalancedetails_draft SET status = 'Saved'");
                                                                                if($write->executeSQL("INSERT INTO internalleavebalancedetails (internalleavebalance_id, leavetype_id, staffId, startDate, endDate, total, status, notes, createdBy) SELECT internalleavebalance_id, 0, staffId, startDate, endDate, total, status, notes, createdBy FROM internalleavebalancedetails_draft")){
                                                                                    $write->executeSQL("TRUNCATE TABLE internalleavebalancedetails_draft");
                                                                                    $requestS = implode(', ', $requestNoCollections);
                                                                                    $staff = new DbaseManipulation;
                                                                                    $to = array();
                                                                                    $result = $staff->readData("SELECT i.id, i.internalleavebalance_id, i.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleavebalancedetails as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId WHERE i.internalleavebalance_id IN ($requestS)");
                                                                                    foreach($result as $row) {
                                                                                        array_push($to,$staff->getContactInfo(2,$row['staffId'],'data'));
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
                                                                                    $requestS = str_replace("'", "", $requestS);    
                                                                                    $emailFields = [
                                                                                        'requestNo'=>$requestS,
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
                                                                        ?>
                                                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                        <p>Internal leave balance has been finalized. Leaves has been credited to the selected staff successfully.</p>
                                                                                    </div>    
                                                                        <?php
                                                                                }
                                                                            }
                                                                    }                
                                                                }
                                                            ?>    
                                                            <div class="d-flex flex-wrap">                    
                                                                <div>
                                                                    <h3 class="card-title">3. Add Internal Balance to Staff</h3>
                                                                    <h6 class="card-subtitle"><em>Observe the staff on the list and click Finalized Button once completed.</em></h6>
                                                                </div>
                                                                <div class="ml-auto">
                                                                    <ul class="list-inline">
                                                                        <li class="none">
                                                                            <?php 
                                                                                $request = new DbaseManipulation;
                                                                                $requestNo = $request->requestNo("AIL-","internalleavebalance");
                                                                            ?>  
                                                                            <h3 class="text-muted text-success">New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3> </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal finalized" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Date</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" disabled class="form-control" value="<?php echo date("d/m/Y"); ?>">
                                                                                    <input type="hidden" name="request_no" value="<?php echo $requestNo; ?>" class="form-control" value="<?php echo date("d/m/Y"); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Attach</label>
                                                                                <div class="col-md-9">
                                                                                    <div class="input-group">
                                                                                        <input type="file" name="fileToUpload" accept=".jpg, .jpeg, .png, .pdf, .gif" class="form-control"> 
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-file-pdf"></i></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">Enter By</label>
                                                                                <div class="col-md-9">
                                                                                    <input type="text" class="form-control" value="<?php echo $logged_name; ?>" readonly />
                                                                                    <input type="hidden" class="form-control createdBy" value="<?php echo $staffId; ?>" readonly />
                                                                                </div>
                                                                            </div>
                                                                        </div>                                            
                                                                    </div>
                                                                    <br/>
                                                                    <div class="actionNotification">                    
                                                                    </div>    
                                                                    <p><em><i class="fa fa-users"></i> List of Staff to be given Internal Balance</em></p>
                                                                    <hr class="m-t-0 m-b-10">
                                                                    <div class="table-responsive">
                                                                        <table class="table" id="draftAddInternal">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>Staff ID</th>
                                                                                    <th>Staff Name</th>
                                                                                    <th>Start</th>
                                                                                    <th>End</th>
                                                                                    <th>Total Days</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $checkDraft = new DbaseManipulation;
                                                                                    $rows = $checkDraft->readData("SELECT i.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM internalleavebalancedetails_draft as i LEFT OUTER JOIN staff as s ON s.staffId = i.staffId ORDER BY i.id DESC");
                                                                                    if($checkDraft->totalCount != 0) {
                                                                                ?>
                                                                                        <tr>
                                                                                            <td colspan="7">
                                                                                                <div class="alert alert-warning" role="alert">
                                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times</span></button>
                                                                                                    <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Notification!</h4>
                                                                                                    <p>The following leave has been added as draft but they were not yet finalized. Click on Finalized button to have the internal balance credited to respected staffs.</p>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                <?php        
                                                                                        foreach($rows as $row){
                                                                                ?>
                                                                                            <tr>
                                                                                                <td><?php echo $row['id']; ?></td>
                                                                                                <td><?php echo $row['staffId']; ?></td>
                                                                                                <td><?php echo $row['staffName']; ?></td>
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                                <td><?php echo $row['total']; ?></td>
                                                                                                <td><button onClick="deleteAddedInternal('<?php echo $row['id']; ?>')" type="button" class="btn btn-outline-danger waves-effect waves-light" title="Remove this entry"><i class="fa fa-trash"></i></button></td>
                                                                                            </tr>
                                                                                <?php            
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </tbody>
                                                                            <tfoot>
                                                                                    <tr>
                                                                                        <td colspan="7">
                                                                                        <div class="alert alert-info">
                                                                                            <strong><i class="fa fa-info-circle"></i> Reminder:</strong> These leaves in the table were not yet saved and credited. Click on Finalize button finish processing.
                                                                                        </div>
                                                                                        </td>
                                                                                    </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="form-actions">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="row">
                                                                                <div class="col-md-offset-3 col-md-9">
                                                                                    <button type="submit" name="finalizedSubmit" class="btn btn-info waves-effect waves-light finalizedSubmit"><i class="fa fa-paper-plane"></i> Finalized</button>
                                                                                    <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6"></div>
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
                    /*$('.finalized').submit(function(e) {
                        var currentForm = this;
                        e.preventDefault();
                        bootbox.confirm("Are you sure?", function(result) {
                            if (result) {
                                currentForm.submit();
                            }
                        });
                    });*/
                    $(document).ready(function() {
                        $.ajax({
                            url	 : 'ajaxpages/leaves/add-internal/countdraft.php'
                            ,type	 : 'POST'
                            ,dataType: 'json'
                            ,success : function(e){
                                if(e.enable == 1){
                                    $('.finalizedSubmit').removeAttr('disabled');
                                } else {
                                    $('.finalizedSubmit').attr('disabled','disabled');
                                }	
                            }
                            ,error	: function(e){
                            }
                        });
                    });
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>             
</html>