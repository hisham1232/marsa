<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        $id = $helper->cleanString($_GET['id']);
        $cStaffId = $helper->cleanString($_GET['sid']);
        $row = $helper->singleReadFullQry("SELECT * FROM clearance WHERE id = $id AND staffId = '$cStaffId'");
        if($helper->totalCount == 0) 
            $loggedAllowed = false;
        else 
            $loggedAllowed = true;

        $isApprover = new DBaseManipulation;
        $isApproverRow = $isApprover->singleReadFullQry("SELECT * FROM clearance_approval_status WHERE clearance_id = $id AND approverStaffId = '$staffId'");
        if($isApprover->totalCount == 0)
            $loggedAllowed = false;
        else 
            $loggedAllowed = true;
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $loggedAllowed) ? true : false;
        if($allowed){  
            $requestNo = $row['requestNo'];
            $cDate = date('d/m/Y',strtotime($row['dateCreated']));
            if($row['isCleared'] == 1)
                $cStat = 'Cleared';
            else
                $cStat = 'On Process';

            $currentFlag = $isApproverRow['current_flag'];
            $processId = $isApproverRow['clearance_process_id'];
            ?>
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Clearance Application Details</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance </li>
                                        <li class="breadcrumb-item">Clearance Details</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <h4 class="card-title">Clearance Application Form</h4>
                                            <div class="row">
                                                <?php
                                                    $basic_info = new DBaseManipulation;
                                                    $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, s.gender, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.joinDate, n.name as nationality, q.name as qualification FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id WHERE s.staffId = '$cStaffId' AND e.isCurrent = 1 and e.status_id = 1");
                                                ?>
                                                <div class="col-lg-3">
                                                    <p class="m-b-0">Staff ID: <span class="text-primary"><?php echo $info['staffId']; ?></span></p>
                                                    <p class="m-b-0">Staff Name: <span class="text-primary"><?php echo $info['staffName']; ?></span></p>
                                                    <p class="m-b-0">Job Title : <span class="text-primary"><?php echo $info['jobtitle']; ?></span></p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p class="m-b-0">Department: <span class="text-primary"><?php echo $info['department']; ?></span></p>
                                                    <p class="m-b-0">Section: <span class="text-primary"><?php echo $info['section']; ?></span></p>
                                                    <p class="m-b-0">Qualification: <span class="text-primary"><?php echo $info['qualification']; ?></span></p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $info['sponsor']; ?></span></p>
                                                    <p class="m-b-0">Join Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></p>
                                                    <p class="m-b-0">Nationality: <span class="text-primary"><?php echo $info['nationality']; ?></span></p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p class="m-b-0">Clearance ID: <span class="badge badge-primary"><?php echo $requestNo; ?></span></p>
                                                    <p class="m-b-0">Clearance Date: <span class="text-primary"><?php echo $cDate; ?></span></p>
                                                    <p class="m-b-0">Clearance Status: <span class="text-primary"><?php echo $cStat; ?></span></p>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <?php 
                                                    if(isset($_POST['submit'])) {
                                                        $currentFlag = $_POST['currentFlag'];
                                                        $clearanceId = $_POST['clearanceId'];
                                                        $approverStaffId = $_POST['approverStaffId'];
                                                        $processId = $_POST['processId'];
                                                        $sts = $_POST['sts'];
                                                        $notes = $_POST['notes'];
                                                        /*
                                                            1. Update status, current_flag field names in clearance_approval_status table.
                                                                    current_flag = 0, next current_flag = 1, status = $sts
                                                            2. Insert into clearance_history table
                                                            3. Check in clearance_approval_status table 
                                                                if all status = 'Completed', if yes then
                                                                    in clearance table set isCleared = 1 [Cleared]
                                                                else if there is a status equal to Declined, then 
                                                                    isCleared = 0 [Pending]
                                                                else if there is a status equal to Pending, then
                                                                    isCleared = 0 [Pending]
                                                            4. Send an email to the following:
                                                                    staff who filed it
                                                                    approver who approves it
                                                                    next approver which will be marked as current_flag = 1        
                                                        */
                                                        ?>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#myModal').modal('show');
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                ?>
                                                <?php 
                                                    if($currentFlag == 1) {
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-lg-4 col-xs-18">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="d-flex flex-wrap">
                                                                            <div>
                                                                                <h3 class="card-title">Clearance Approval Form</h3>
                                                                                <h6 class="card-subtitle font-italic">Fill-up form to Approve/Dis-approve Clearance Application</h6>
                                                                            </div>
                                                                        </div>
                                                                        <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-3 control-label">Approver</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" class="form-control" readonly value="<?php echo $logged_name; ?>">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text" id="basic-addon2">
                                                                                                    <i class="fas fa-user"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php /*<div class="form-group row">
                                                                                <label class="col-sm-3 control-label">Section</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="numberofdays" class="form-control" readonly value="Asst. Dean for Admin and Financial Affairs">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text" id="basic-addon2">
                                                                                                    <i class="fas fa-key"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>*/ ?>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-3 control-label"></label>
                                                                                <div class="col-sm-9">
                                                                                    <a class="mytooltip" href="javascript:void(0)">
                                                                                        <span class="text-info"><small><i class="fas fa-list-ol"></i> Clearance Check List</small></span>
                                                                                        <span class="tooltip-content5">
                                                                                            <span class="tooltip-text3">
                                                                                                <span class="tooltip-inner2">
                                                                                                    <p>Administrative Affairs:</p>
                                                                                                    <ul>
                                                                                                        <li>Accommodation</li>
                                                                                                        <li>Furniture</li>
                                                                                                        <li>Electiricity Bill</li>
                                                                                                        <li>Water Bill</li>
                                                                                                        <li>Telephone Bill</li>
                                                                                                    </ul>
                                                                                                    <p>College Store:</p>
                                                                                                    <ul>
                                                                                                        <li>Personal Official ID</li>
                                                                                                        <li>Store Dues</li>
                                                                                                        <li>Office Furniture</li>
                                                                                                        <li>Equipment</li>
                                                                                                        <li>Others</li>
                                                                                                    </ul>
                                                                                                    <p>Financial Affairs:</p>
                                                                                                    <ul>
                                                                                                        <li>Debts</li>
                                                                                                    </ul>
                                                                                                </span>
                                                                                            </span>
                                                                                        </span>
                                                                                    </a>
                                                                                </div>                                                            
                                                                            </div>                                                    
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-3 control-label">Enter Date</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i:s'); ?>" readonly>
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                <span class="far fa-calendar-alt"></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-3 control-label"><span class="text-danger">*</span>Status</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="hidden" name="currentFlag" value="<?php echo $currentFlag; ?>" />
                                                                                            <input type="hidden" name="clearanceId" value="<?php echo $id; ?>" />
                                                                                            <input type="hidden" name="approverStaffId" value="<?php echo $staffId; ?>" />
                                                                                            <input type="hidden" name="processId" value="<?php echo $processId; ?>" />
                                                                                            <select name="sts" class="form-control" required data-validation-required-message="Please select Clearance Approval Status">
                                                                                                <option value="">Select Status</option>
                                                                                                <option value="Completed">Approve</option>
                                                                                                <option value="Declined">Decline</option>
                                                                                            </select>
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text" id="basic-addon2">
                                                                                                    <i class="fas fa-question"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-3 control-label"><span class="text-danger">*</span>Notes</label>
                                                                                <div class="col-sm-9">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <textarea name="notes" class="form-control" rows="2" required data-validation-required-message="Please type a brief note or comment"></textarea>
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text" id="basic-addon2">
                                                                                                    <i class="far fa-comment"></i>
                                                                                                </span>
                                                                                            </div>
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
                                                            <div class="col-lg-8 col-xs-18">
                                                                <div id="accordion-style-1">
                                                                    <div class="accordion" id="accordionExample">
                                                                        <?php 
                                                                            $rows = $helper->readData("SELECT cas.id, cas.status, p.name as processName, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as approverName, cas.dateUpdated, cas.comment FROM clearance_approval_status as cas LEFT OUTER JOIN clearance_process as p ON cas.clearance_process_id = p.id LEFT OUTER JOIN staff as s ON cas.approverStaffId = s.staffId WHERE cas.clearance_id = $id ORDER BY cas.id");
                                                                            foreach ($rows as $row) {
                                                                                if($row['status'] == 'Pending') {
                                                                                    $processStatus = '<i class="fas fa-edit text-warning"></i> On Process';    
                                                                                } else if ($row['status'] == 'Declined') {
                                                                                    $processStatus = '<i class="fas fa-times text-danger"></i> Declined';
                                                                                } else {
                                                                                    $processStatus = '<i class="fas fa-check text-primary"></i> Approved';
                                                                                }   
                                                                                ?>
                                                                                <div class="card">
                                                                                    <div class="card-header" id="heading<?php echo $row['id']; ?>">
                                                                                        <div class="d-flex no-block align-items-center">
                                                                                            <h4 class="card-title">
                                                                                                <button class="btn collapsed btn-link text-left"type="button" data-toggle="collapse"data-target="#collapse<?php echo $row['id']; ?>" aria-expanded="true"aria-controls="collapse<?php echo $row['id']; ?>">
                                                                                                    <i class="fa fa-clipboard-list main"></i><i class="fa fa-angle-double-right mr-3"></i><?php echo $row['processName']; ?>
                                                                                                </button>
                                                                                            </h4>
                                                                                            <div class="ml-auto">
                                                                                                <ul class="list-inline text-right">
                                                                                                    <li><?php echo $processStatus; ?></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="collapse<?php echo $row['id']; ?>" class="collapse fade" aria-labelledby="heading<?php echo $row['id']; ?>" data-parent="#accordionExample">
                                                                                        <div class="card-body">
                                                                                            <div class="table-responsive">
                                                                                                <table data-toggle="table" data-mobile-responsive="true" class="table table-striped table-sm">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>Approver Name</th>
                                                                                                            <th>Date/Time</th>
                                                                                                            <th>Status</th>
                                                                                                            <th>Comment</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr id="tr-id-1" class="tr-class-1">
                                                                                                            <td id="td-id-1" class="td-class-1"><?php echo $row['approverName']; ?></td>
                                                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($row['dateUpdated'])); ?></td>
                                                                                                            <td><?php echo $row['status']; ?></td>
                                                                                                            <td><?php echo $row['comment']; ?></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php 
                                                                                }
                                                                            ?>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                    } else {
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xs-24">
                                                                <div id="accordion-style-1">
                                                                    <div class="accordion" id="accordionExample">
                                                                        <?php 
                                                                            $rows = $helper->readData("SELECT cas.id, cas.status, p.name as processName, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as approverName, cas.dateUpdated, cas.comment FROM clearance_approval_status as cas LEFT OUTER JOIN clearance_process as p ON cas.clearance_process_id = p.id LEFT OUTER JOIN staff as s ON cas.approverStaffId = s.staffId WHERE cas.clearance_id = $id ORDER BY cas.id");
                                                                            echo "SELECT cas.id, cas.status, p.name as processName, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as approverName, cas.dateUpdated, cas.comment FROM clearance_approval_status as cas LEFT OUTER JOIN clearance_process as p ON cas.clearance_process_id = p.id LEFT OUTER JOIN staff as s ON cas.approverStaffId = s.staffId WHERE cas.clearance_id = $id ORDER BY cas.id";
                                                                            foreach ($rows as $row) {
                                                                                if($row['status'] == 'Pending') {
                                                                                    $processStatus = '<i class="fas fa-edit text-warning"></i> On Process';    
                                                                                } else if ($row['status'] == 'Declined') {
                                                                                    $processStatus = '<i class="fas fa-times text-danger"></i> Declined';
                                                                                } else {
                                                                                    $processStatus = '<i class="fas fa-check text-primary"></i> Approved';
                                                                                }   
                                                                                ?>
                                                                                <div class="card">
                                                                                    <div class="card-header" id="heading<?php echo $row['id']; ?>">
                                                                                        <div class="d-flex no-block align-items-center">
                                                                                            <h4 class="card-title">
                                                                                                <button class="btn collapsed btn-link text-left"type="button" data-toggle="collapse"data-target="#collapse<?php echo $row['id']; ?>" aria-expanded="true"aria-controls="collapse<?php echo $row['id']; ?>">
                                                                                                    <i class="fa fa-clipboard-list main"></i><i class="fa fa-angle-double-right mr-3"></i><?php echo $row['processName']; ?>
                                                                                                </button>
                                                                                            </h4>
                                                                                            <div class="ml-auto">
                                                                                                <ul class="list-inline text-right">
                                                                                                    <li><?php echo $processStatus; ?></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="collapse<?php echo $row['id']; ?>" class="collapse fade" aria-labelledby="heading<?php echo $row['id']; ?>" data-parent="#accordionExample">
                                                                                        <div class="card-body">
                                                                                            <div class="table-responsive">
                                                                                                <table data-toggle="table" data-mobile-responsive="true" class="table table-striped table-sm">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>Approver Name</th>
                                                                                                            <th>Date/Time</th>
                                                                                                            <th>Status</th>
                                                                                                            <th>Comment</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr id="tr-id-1" class="tr-class-1">
                                                                                                            <td id="td-id-1" class="td-class-1"><?php echo $row['approverName']; ?></td>
                                                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($row['dateUpdated'])); ?></td>
                                                                                                            <td><?php echo $row['status']; ?></td>
                                                                                                            <td><?php echo $row['comment']; ?></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php 
                                                                                }
                                                                            ?>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                ?>        
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
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body" style="text-align: center">
                                    <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                    <h5>Clearance approval action has been processed successfully!</h5>
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