<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
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
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Notification - For Approvals</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">For Approvals</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card border-success">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="profiletimeline">
                                                        <div class="sl-item">
                                                            <div class="sl-left"> 
                                                                <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$staffId.'.jpg'; ?>" class="img-circle" alt="Staff Image"><br>
                                                                <input type="hidden" class="approverStaffId" value="<?php echo $staffId; ?>" />
                                                                <input type="hidden" class="approverEmail" value="<?php echo $logged_in_email; ?>" />
                                                            </div>
                                                            <div class="sl-right">
                                                                <div><a href="javascript:;" class="link"><?php echo $logged_name; ?></a> <span class="sl-date">[Staff ID : <?php echo $staffId; ?>]</span>
                                                                    <div class="like-comm">
                                                                        <?php
                                                                            //Short Leave Counter
                                                                            $amIShortLeaveApprover =  $helper->isShortLeaveApprover($myPositionId,'position_id');
                                                                            $countSL = $helper->singleReadFullQry("SELECT count(id) as sLCount FROM shortleave WHERE currentApproverPositionId = $myPositionId AND currentSeqNumber = 1 AND currentStatus = 'Pending'");
                                                                            $totalApprovals = $countSL['sLCount']; //Add the others here...
                                                                        ?>
                                                                        <a href="javascript:void(0)" class="link m-r-5">You have [<?php echo $totalApprovals; ?>] for Approvals waiting</a>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#stl" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Standard Leave 
                                                            <!-- Add this span below only if there is waiting for approval -->
                                                            <span class="badge badge-pill badge-danger font-weight-bold"></span>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#sl" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Short Leave
                                                            <?php
                                                                if($countSL['sLCount'] > 0) {
                                                                ?>
                                                                    <span class="badge badge-pill badge-danger font-weight-bold"><?php echo $countSL['sLCount']; ?></span>
                                                                <?php
                                                                } else {
                                                            ?>        
                                                                    <span class="badge badge-pill badge-danger font-weight-bold"></span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </span>
                                                    </a> 
                                                </li>

                                                <li class="nav-item"> 
                                                    <a class="nav-link" data-toggle="tab" href="#clearance" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-email"></i></span> 
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Clearance
                                                        </span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#delegation" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Delegation
                                                        </span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#create" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-email"></i></span> 
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Create Account
                                                        </span>
                                                    </a>
                                                </li>

                                                <li class="nav-item"> 
                                                    <a class="nav-link" data-toggle="tab" href="#terminate" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Terminate Account
                                                        </span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#document" role="tab">
                                                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                                        <span class="hidden-xs-down">
                                                            <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Document Expiration
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content tabcontent-border p-10">
                                                <div class="tab-pane active" id="stl" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-success2">
                                                            <h3 class="card-title">Standard Leave For Approvals List <span class="text-danger">[4 - application to approve]</span></h3>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To Quick APPROVE or Decline Application :</p>
                                                                    <p class="m-0 p-0">1. CLick the <span class="font-weight-bold">application</span> on the list or click <span class="font-weight-bold">SELECT ALL</span> button</p>
                                                                    <p class="m-0 p-0">2. Click <span class="font-weight-bold">APPROVE</span> or <span class="font-weight-bold">DECLINE</span> button below</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                    <p class="m-0 p-0">1. CLick the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="standardLeaveTable" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Request ID</th>
                                                                            <th>Staff ID/ Name</th>
                                                                            <th>Department</th>
                                                                            <th>Sponsor</th>
                                                                            <th>Leave Category</th>
                                                                            <th>Leave Date</th>
                                                                            <th>Days</th>
                                                                            <th>Reason</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>OLT-1234567</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>TATI</td>
                                                                            <td>Absent Without Pay بدون راتب</td>
                                                                            <td>21/10/2018 - 23/10/2018</td>
                                                                            <td>3</td>
                                                                            <td>text</td>
                                                                            <td><a href="" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>OLT-2345678</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>TATI</td>
                                                                            <td>Absent Without Pay بدون راتب</td>
                                                                            <td>21/10/2018 - 23/10/2018</td>
                                                                            <td>3</td>
                                                                            <td>text</td>
                                                                            <td><a href="" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <button type="button" class="btn btn-primary AAA">APPROVE Selected Records</button>
                                                                <button type="button" class="btn btn-danger">DECLINE Selected Records</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---if no need for approvals-->
                                                    <div class="card">
                                                        <div class="card-body bg-light-danger2">
                                                            <div class="d-flex flex-wrap">
                                                                <div style="margin:auto !important;">
                                                                    <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                        <center><i class="fas fa-clipboard-list"></i></center>
                                                                    </h1>
                                                                    <h2 class="text-danger">NO Records for APPROVAL Found!</h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end Standard Leave tab-->
                                                <div class="tab-pane" id="sl" role="tabpanel">
                                                    <?php
                                                        $sql = "SELECT sh.*, d.name as department, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.name as sponsor FROM shortleave as sh 
                                                        LEFT OUTER JOIN employmentdetail as e ON e.staff_id = sh.staff_id
                                                        LEFT OUTER JOIN staff as s ON s.staffId = sh.staff_id
                                                        LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                        LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                        WHERE sh.currentApproverPositionId = $myPositionId AND sh.currentSeqNumber = 1 AND sh.currentStatus = 'Pending' AND e.isCurrent = 1
                                                        ORDER BY sh.id DESC";
                                                        $rows = $helper->readData($sql);
                                                        if($helper->totalCount != 0) {
                                                            ?>            
                                                            <div class="card">
                                                                <div class="card-header bg-light-info">
                                                                    <h3 class="card-title">Short Leave For Approvals List <span class="text-danger">[<?php echo $countSL['sLCount']; ?> - application to approve]</span></h3>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <p class="m-0 p-0 text-primary">To Quick APPROVE or Decline Application:</p>
                                                                            <p class="m-0 p-0">1. CLick the <span class="font-weight-bold">application</span> the list or click <span class="font-weight-bold">SELECT ALL</span> button</p>
                                                                            <p class="m-0 p-0">2. Click <span class="font-weight-bold">APPROVE</span> or <span class="font-weight-bold">DECLINE</span> button below</p>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                            <p class="m-0 p-0">1. Click the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <?php
                                                                        /*if(isset($_POST['btnApproveSHL'])){
                                                                            print_r($_POST);
                                                                            ?>
                                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                <p>Approval successful.</p>
                                                                            </div>
                                                                            <?php
                                                                        }*/
                                                                    ?>        
                                                                </div>    
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="shortLeaveTable" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID</th>
                                                                                    <th>Request No</th>
                                                                                    <th>Staff ID/Name</th>
                                                                                    <th>Department</th>
                                                                                    <!-- <th>Sponsor</th> -->
                                                                                    <th>Date</th>
                                                                                    <th>Time</th>
                                                                                    <th>Hours</th>
                                                                                    <th>Reason</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php    
                                                                                    if($helper->totalCount != 0) {
                                                                                        foreach($rows as $row){
                                                                                ?>
                                                                                            <tr>
                                                                                                <td><?php echo $row['id']; ?></td>
                                                                                                <td><?php echo $row['requestNo']; ?></td>
                                                                                                <td><?php echo $row['staff_id']." - ".$row['staffName']; ?></td>
                                                                                                <td><?php echo $row['department']; ?></td>
                                                                                                <!-- <td><?php //echo $row['sponsor']; ?></td> -->
                                                                                                <td><?php echo date('d/m/Y',strtotime($row['leaveDate'])); ?></td>
                                                                                                <td><?php echo $row['startTime']." to ".$row['endTime']; ?></td>
                                                                                                <td><?php echo $row['total']; ?></td>
                                                                                                <td><?php echo $row['reason']; ?></td>
                                                                                                <td><a href="javascript:;" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" class="btn btn btn-outline-info btn-sm viewShortLeaveDetails" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-search"></i> View</a></td>
                                                                                            </tr>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <button type="button" class="btn btn-danger ShLDeclineSelected"><i class="fas fa-thumbs-down"></i> DECLINE Selected Records</button>
                                                                        <button type="button" class="btn btn-primary ShLApproveSelected"><i class="fas fa-thumbs-up"></i> APPROVE Selected Records</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>        
                                                            <!---if no need for approvals-->
                                                            <div class="card">
                                                                <div class="card-body bg-light-danger2">
                                                                    <div class="d-flex flex-wrap">
                                                                        <div style="margin:auto !important;">
                                                                            <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                                <center><i class="fas fa-clipboard-list"></i></center>
                                                                            </h1>
                                                                            <h2 class="text-danger">NO Records Waiting for APPROVAL Found!</h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>        
                                                </div>
                                                <!--end Short Leave tab-->
                                                <div class="tab-pane" id="clearance" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-danger2">
                                                            <h3 class="card-title">Clearance For Approvals List <span class="text-danger">[4 - application to approve]</span></h3>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To Quick APPROVE or Reject Application:</p>
                                                                    <p class="m-0 p-0">1. CLick the <span class="font-weight-bold">application</span> the list or click <span class="font-weight-bold">SELECT ALL</span> button</p>
                                                                    <p class="m-0 p-0">2. Click <span class="font-weight-bold">APPROVE</span> or <span class="font-weight-bold">REJECT</span> button below</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                    <p class="m-0 p-0">1. CLick the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="exampleClearance" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Request ID</th>
                                                                            <th>Staff ID/ Name</th>
                                                                            <th>Department</th>
                                                                            <th>Section</th>
                                                                            <th>Job Title</th>
                                                                            <th>Sponsor</th>
                                                                            <th>Gender</th>
                                                                            <th>Nationality</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>OLT-1234567</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>TATI</td>
                                                                            <td>Male</td>
                                                                            <td>Indian</td>
                                                                            <td><button type="button" class="btn btn btn-outline-info btn-sm"
                                                                                    title="Click to view application details"><i
                                                                                        class="fas fa-angle-double-right"></i> View</button></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>OLT-1234567</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>TATI</td>
                                                                            <td>Male</td>
                                                                            <td>Indian</td>
                                                                            <td><button type="button" class="btn btn btn-outline-info btn-sm"
                                                                                    title="Click to view application details"><i
                                                                                        class="fas fa-angle-double-right"></i> View</button></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <button type="button" class="btn btn-primary AAA">APPROVE Selected Records</button>
                                                                <button type="button" class="btn btn-danger">DECLINE Selected Records</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---if no need for approvals-->
                                                    <div class="card">
                                                        <div class="card-body bg-light-danger2">
                                                            <div class="d-flex flex-wrap">
                                                                <div style="margin:auto !important;">
                                                                    <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                        <center><i class="fas fa-clipboard-list"></i></center>
                                                                    </h1>
                                                                    <h2 class="text-danger">NO Records for APPROVAL Found!</h2>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end clearance tab-->
                                                <div class="tab-pane" id="delegation" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light">
                                                            <h3 class="card-title">Delegation Approvals List <span class="text-danger">[4 - application to approve]</span></h3>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To Quick APPROVE or Reject Application:</p>
                                                                    <p class="m-0 p-0">1. Click the <span class="font-weight-bold">application</span> the list or click <span class="font-weight-bold">SELECT ALL</span> button</p>
                                                                    <p class="m-0 p-0">2. Click <span class="font-weight-bold">APPROVE</span> or <span class="font-weight-bold">REJECT</span> button below</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                    <p class="m-0 p-0">1.CLick the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="exampleDelegation" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Request ID</th>
                                                                            <th>Delegate by Staff</th>
                                                                            <th>Department</th>
                                                                            <th>Role Delegated To You</th>
                                                                            <th>Start Date</th>
                                                                            <th>End Date Date</th>
                                                                            <th>Days</th>
                                                                            <th>Note</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>OLT-1234567</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td><span class="text-primary">Approve Standard Leave,Approve Clearance</span></td>
                                                                            <td>21/10/2018</td>
                                                                            <td>23/10/2018</td>
                                                                            <td>3</td>
                                                                            <td>text</td>
                                                                            <td><a href="deligation_accept.php" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>OLT-1234567</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td><span class="text-primary">Approve Standard Leave,Approve Clearance</span></td>
                                                                            <td>21/10/2018</td>
                                                                            <td>23/10/2018</td>
                                                                            <td>3</td>
                                                                            <td>text</td>
                                                                            <td><a href="deligation_accept.php" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <button type="button" class="btn btn-primary AAA">APPROVE Selected Records</button> 
                                                                <button type="button" class="btn btn-danger">REJECT Selected Records</button>
                                                            </div>
                                                            <!--end table responsive-->
                                                        </div>
                                                        <!--end card-body-->
                                                    </div>
                                                    <!--end card-->

                                                    <!---if no need for approvals-->
                                                    <div class="card">
                                                        <div class="card-body bg-light-danger2">
                                                            <div class="d-flex flex-wrap">
                                                                <div style="margin:auto !important;">
                                                                    <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                        <center><i class="fas fa-clipboard-list"></i></center>
                                                                    </h1>
                                                                    <h2 class="text-danger">NO Records for APPROVAL Found!</h2>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end delegation tab-->
                                                <div class="tab-pane" id="create" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-success2">
                                                            <h3 class="card-title">Create Account For Approvals List <span class="text-danger">[2 - application to approve]</span></h3>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                    <p class="m-0 p-0">1. Click the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="exampleCreate" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Request ID</th>
                                                                            <th>Staff ID/ Name</th>
                                                                            <th>Department</th>
                                                                            <th>Section</th>
                                                                            <th>Job Title</th>
                                                                            <th>Sponsor</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><a href="">TER-0000018</a></td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>Ministry</td>
                                                                            <td><a href="" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><a href="">TER-0000019</a></td>
                                                                            <td>124578 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>TATI</td>
                                                                            <td><a href="" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            <!--end table responsive-->
                                                        </div>
                                                        <!--end card-body-->
                                                    </div>
                                                    <!--end card-->

                                                    <!---if no need for approvals-->
                                                    <div class="card">
                                                        <div class="card-body bg-light-danger2">
                                                            <div class="d-flex flex-wrap">
                                                                <div style="margin:auto !important;">
                                                                    <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                        <center><i class="fas fa-clipboard-list"></i></center>
                                                                    </h1>
                                                                    <h2 class="text-danger">NO Records for APPROVAL Found!</h2>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end create account tab-->
                                                <div class="tab-pane" id="terminate" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-danger2">
                                                            <h3 class="card-title">Terminate Account For Approvals List <span class="text-danger">[2 - application to approve]</span></h3>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                    <p class="m-0 p-0">1. Click the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="exampleTerminate" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Request ID</th>
                                                                            <th>Staff ID/ Name</th>
                                                                            <th>Department</th>
                                                                            <th>Section</th>
                                                                            <th>Job Title</th>
                                                                            <th>Sponsor</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><a href="">TER-0000018</a></td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>Ministry</td>
                                                                            <td><a href="" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><a href="">TER-0000019</a></td>
                                                                            <td>124578 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>TATI</td>
                                                                            <td><a href="" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---if no need for approvals-->
                                                    <div class="card">
                                                        <div class="card-body bg-light-danger2">
                                                            <div class="d-flex flex-wrap">
                                                                <div style="margin:auto !important;">
                                                                    <h1 class="text-info" style="font-size: 110px !important;font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                        <center><i class="fas fa-clipboard-list"></i></center>
                                                                    </h1>
                                                                    <h2 class="text-danger">NO Records for APPROVAL Found!</h2>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end create terminate tab-->
                                                <!--NOTE: THIS IS ONLY VISIBLE TO SYSTEM ADMINS AND HR STAFF-->
                                                <div class="tab-pane" id="document" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light">
                                                            <h3 class="card-title">Terminate Account For Approvals List <span class="text-danger">[2 - application to approve]</span></h3>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="m-0 p-0 text-primary">To VIEW the details of the application:</p>
                                                                    <p class="m-0 p-0">1. Click the <span class="font-weight-bold">View Details</span> button on Action column</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table id="exampleDocument" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Staff ID/ Name</th>
                                                                            <th>Department</th>
                                                                            <th>Job Title</th>
                                                                            <th>Document Type</th>
                                                                            <th>Document No</th>
                                                                            <th>Expitation Date</th>
                                                                            <th>New Document No</th>
                                                                            <th>New Expitation Date</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>Passport</td>
                                                                            <td>XYX123456</td>
                                                                            <td>17/12/2018</td>
                                                                            <td><input type="text" name="" size="6" width="6"></td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="shortleavedate" id="new_date1" required data-validation-required-message="Please enter leave date"/>
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                                <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Save</button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>Passport</td>
                                                                            <td>XYX123456</td>
                                                                            <td>17/12/2018</td>
                                                                            <td><input type="text" name="" size="6" width="6"></td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="shortleavedate" id="new_date2" required data-validation-required-message="Please enter leave date"/>
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                                <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Save</button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>445782 - Staff Name Here</td>
                                                                            <td>Information Technology</td>
                                                                            <td>Job Title Here</td>
                                                                            <td>Passport</td>
                                                                            <td>XYX123456</td>
                                                                            <td>17/12/2018</td>

                                                                            <td><input type="text" name="" size="6" width="6"></td>
                                                                            <td>
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="shortleavedate" id="new_date3" required data-validation-required-message="Please enter leave date"/>
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                                <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Save</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---if no need for approvals-->
                                                    <div class="card">
                                                        <div class="card-body bg-light-danger2">
                                                            <div class="d-flex flex-wrap">
                                                                <div style="margin:auto !important;">
                                                                    <h1 class="text-info" style="font-size: 110px !important;font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                        <center><i class="fas fa-clipboard-list"></i></center>
                                                                    </h1>
                                                                    <h2 class="text-danger">NO Records for APPROVAL Found!</h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <!--end document tab-->
                                            </div>
                                            <!--end tabcontent-->

                                        </div><!--end card body-->
                                    </div><!--card border-success-->
                                </div><!--end col 12-->
                            </div><!--end row-->
                        </div>
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script src="assets/plugins/datatables/dataTables.select.min.js"></script>
                <script type="text/javascript">
                    $('#standardLeaveTable').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }
                    });
                </script>
                <script>
                    /*RETRIEVING DATA FROM THE SELECT ROWS FUNCTION-------------------------------------------------------------------- */
                    $(document).ready(function () {
                        function ajaxLoader(linkPage,variables,divName){
                            $(divName).empty().html("<i class='fa fa-info-circle text-warning'></i> <span class='text-warning'>Processing your action, please wait</span> <img src='scripts/ajax-loader.gif'/>");
                            $.get(linkPage + "?" + variables,function(data){$(divName).html(data);});
                        }
                        
                        var oTable = $('#standardLeaveTable').DataTable();
                        $('#standardLeaveTable tbody').on('click', 'tr', function () {
                            $(this).toggleClass('selected');
                            var pos = oTable.row(this).index();
                            var row = oTable.row(pos).data();
                            console.log(row);
                        });

                        $('.AAA').click(function () {
                            var oData = oTable.rows('.selected').data();
                            var iDsSelected = [];
                            for (var i = 0; i < oData.length; i++) {
                                iDsSelected.push(oData[i][0]);
                                //alert("Request: " + oData[i][0] + " Staff Id and Name: " + oData[i][1] + " Department: " + oData[i][2]);
                            }
                            alert(iDsSelected);
                        });


                        var oTable = $('#shortLeaveTable').DataTable();
                        $('#shortLeaveTable tbody').on('click', 'tr', function () {
                            $(this).toggleClass('selected');
                            var pos = oTable.row(this).index();
                            var row = oTable.row(pos).data();
                            console.log(row);
                        });

                        $('.ShLApproveSelected').click(function () {
                            var oData = oTable.rows('.selected').data();
                            var iDsSelected = [];
                            for (var i = 0; i < oData.length; i++) {
                                iDsSelected.push(oData[i][0]);
                            }
                            //iDsSelected = ["Saab", "Volvo", "BMW"];
                            if(iDsSelected.length > 0) {
                                bootbox.confirm({
                                    closeButton: false,
                                    size: 'large',
                                    message: "<h4 class='text-dark'><i class='fa fa-question-circle'></i> Confirm Action.</h4><br/><p class='processingRequest'>You are about to approve selected short leave. Continue approval?</p>",
                                    buttons: {
                                        confirm: {
                                            label: '<i class="fas fa-check"></i> Yes',
                                            className: 'btn-primary btn-bootbox-yes'
                                        },
                                        cancel: {
                                            label: '<i class="fas fa-times"></i> No',
                                            className: 'btn-danger btn-bootbox-no'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result==true){
                                            var approverId = $('.approverStaffId').val();
                                            var approverEmail = $('.approverEmail').val();
                                            ajaxLoader("notification_for_approvals_actions.php","requestNoS="+iDsSelected+"&approverId="+approverId+"&approverEmail="+approverEmail+"&action=1&approvalType=shl",".processingRequest");
                                            $('.btn-bootbox-yes').hide();
                                            $('.btn-bootbox-no').hide();
                                            return false;
                                        }
                                    }
                                });
                            }    
                        });

                        $('.ShLDeclineSelected').click(function () {
                            var oData = oTable.rows('.selected').data();
                            var iDsSelected = [];
                            for (var i = 0; i < oData.length; i++) {
                                iDsSelected.push(oData[i][0]);
                            }
                            //iDsSelected = ["Saab", "Volvo", "BMW"];
                            if(iDsSelected.length > 0) {
                                bootbox.confirm({
                                    closeButton: false,
                                    size: 'large',
                                    message: "<h4 class='text-dark'><i class='fa fa-question-circle'></i> Confirm Action.</h4><br/><p class='processingRequest'>You are about to decline selected short leave. Continue decline?</p>",
                                    buttons: {
                                        confirm: {
                                            label: '<i class="fas fa-check"></i> Yes',
                                            className: 'btn-primary btn-bootbox-yes'
                                        },
                                        cancel: {
                                            label: '<i class="fas fa-times"></i> No',
                                            className: 'btn-danger btn-bootbox-no'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result==true){
                                            var approverId = $('.approverStaffId').val();
                                            var approverEmail = $('.approverEmail').val();
                                            ajaxLoader("notification_for_approvals_actions.php","requestNoS="+iDsSelected+"&approverId="+approverId+"&approverEmail="+approverEmail+"&action=4&approvalType=shl",".processingRequest");
                                            $('.btn-bootbox-yes').hide();
                                            $('.btn-bootbox-no').hide();
                                            return false;
                                        }
                                    }
                                });
                            }    
                        });

                        $('.viewShortLeaveDetails').click(function(e){
                            var id = $(this).data('id');
                            var requestNo = $(this).data('requestno');
                            var data = {
                                id : id,
                                requestNo : requestNo
                            }
                            $.ajax({
                                url	 : 'ajaxpages/leaves/shortleave/shortleave_history_approval.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        bootbox.confirm({
                                            closeButton: false,
                                            message: e.message,
                                            size: 'large',
                                            buttons: {
                                                cancel: {
                                                    label: '<i class="fas fa-thumbs-down"></i> Decline',
                                                    className: 'btn-danger btn-bootbox-decline'
                                                },
                                                confirm: {
                                                    label: '<i class="fas fa-thumbs-up"></i> Approve',
                                                    className: 'btn-primary btn-bootbox-approve'
                                                }
                                            },
                                            title: "<p class='SHLApprovedConfirmation'><i class='fas fa-info-circle'></i> Short Leave Approval</p>",
                                            callback: function (result) {
                                                var id = e.id;
                                                var requestNo = e.requestNo;
                                                var approverId = $('.approverStaffId').val();
                                                var approverEmail = $('.approverEmail').val();
                                                var notes = $('.notesComments').val();
                                                if(notes == '') {
                                                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Your notes or comments must not be blank.");
                                                    return false;
                                                } else {
                                                    if(result==true){
                                                        ajaxLoader("notification_for_approvals_actions.php","id="+id+"&requestNoS="+requestNo+"&approverId="+approverId+"&approverEmail="+approverEmail+"&notes="+notes+"&action=2&approvalType=shl",".SHLApprovedConfirmation");
                                                        $('.btn-bootbox-approve').hide();
                                                        $('.btn-bootbox-decline').hide();
                                                        return false;
                                                    } else {
                                                        ajaxLoader("notification_for_approvals_actions.php","id="+id+"&requestNoS="+requestNo+"&approverId="+approverId+"&approverEmail="+approverEmail+"&notes="+notes+"&action=3&approvalType=shl",".SHLApprovedConfirmation");
                                                        $('.btn-bootbox-approve').hide();
                                                        $('.btn-bootbox-decline').hide();
                                                        return false;
                                                    }
                                                }    
                                            }
                                        });
                                    }	
                                }
                                ,error	: function(e){
                                }
                            });
                        });
                    });
                    /*-------------------------------------------------------------------------------------------------------------------*/
                </script>
                <script type="text/javascript">
                    $('#shortLeaveTable').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }


                    });
                </script>
                <script type="text/javascript">
                    $('#exampleClearance').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }


                    });
                </script>
                
                <script type="text/javascript">
                    $('#exampleDelegation').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }


                    });
                    $('#exampleCreate').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }


                    });
                    $('#exampleTerminate').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }


                    });
                    $('#exampleDocument').dataTable({
                        "oLanguage": {
                            "sSearch": "Search all columns:"
                        },
                        "aoColumnDefs": [{
                                'bSortable': false,
                                'aTargets': [1],
                            } //disables sorting for column one
                        ],
                        "order": [],
                        // 'iDisplayLength': 12,
                        "sPaginationType": "full_numbers",
                        "dom": 'Blfrtip', // "dom": 'T<"clear">lfrtip', remove T<<"clear">> to remove pdf print buttons
                        buttons: [
                            //'copyHtml5',
                            'excelHtml5',
                            //'csvHtml5',
                            'pdfHtml5',
                            'selectAll',
                            'selectNone'
                        ],

                        paging: false,
                        "lengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        select: {
                            style: 'multi'
                        }


                    });
                </script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#chkParent').click(function () {
                            var isChecked = $(this).prop("checked");
                            $('#tblData tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
                        });

                        $('#tblData tr:has(td)').find('input[type="checkbox"]').click(function () {
                            var isChecked = $(this).prop("checked");
                            var isHeaderChecked = $("#chkParent").prop("checked");
                            if (isChecked == false && isHeaderChecked)
                                $("#chkParent").prop('checked', isChecked);
                            else {
                                $('#tblData tr:has(td)').find('input[type="checkbox"]').each(function () {
                                    if ($(this).prop("checked") == false)
                                        isChecked = false;
                                });
                                console.log(isChecked);
                                $("#chkParent").prop('checked', isChecked);
                            }
                        });                                            
                    });
                </script>
                <script>
                    // MAterial Date picker    
                    $('#mdate').bootstrapMaterialDatePicker({
                        weekStart: 0,
                        time: false,
                        format: 'DD/MM/YYYY'
                    });
                    $('#start_date').datepicker({
                        weekStart: 0,
                        time: false,
                        format: 'dd/mm/yyyy'
                    });
                    $('#end_date').datepicker({
                        weekStart: 0,
                        time: false,
                        format: 'dd/mm/yyyy'
                    });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });

                    $('.daterange').daterangepicker();
                    $('#new_date1').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#new_date2').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#new_date3').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>             
</html>