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
                    <svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Cleareance - For My Approval List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Cleareance</li>
                                        <li class="breadcrumb-item">Approval List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header m-b-0 p-b-0">

                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">List of My Clearance Approvals (To Be Approve By Me)</h3>
                                                    <h6 class="card-subtitle font-italic">Click Clearance Applications ID to view the approval details.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered"
                                                    cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request</th>
                                                            <th>Process</th>
                                                            <th>Staff ID - Name</th>
                                                            <th>Staff's Department</th>
                                                            <th>Date Created</th>
                                                            <th>Cleared?</th>
                                                            <th>Department</th>
                                                            <th>Admin</th>
                                                            <th>Finance</th>
                                                            <th>ETC</th>
                                                            <th>HR</th>
                                                            <th>ADAFA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $deptArray = array(); $AdminArray = array(); $FinanceArray = array(); $ETCArray = array(); $HRArray = array(); $ADAFAArray = array();  
                                                            $rows = $helper->readData("SELECT cas.*, cp.name as process_name, c.requestNo, c.dateCreated, c.isCleared, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department FROM clearance_approval_status as cas LEFT OUTER JOIN clearance as c ON cas.clearance_id = c.id LEFT OUTER JOIN staff as s ON cas.staffId = s.staffId LEFT OUTER JOIN employmentdetail as e ON c.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN clearance_process as cp ON cas.clearance_process_id = cp.id WHERE cas.approverStaffId = '$staffId' AND current_flag = 1 AND e.isCurrent = 1");
                                                            //echo "SELECT cas.*, cp.name as process_name, c.requestNo, c.dateCreated, c.isCleared, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department FROM clearance_approval_status as cas LEFT OUTER JOIN clearance as c ON cas.clearance_id = c.id LEFT OUTER JOIN staff as s ON cas.staffId = s.staffId LEFT OUTER JOIN employmentdetail as e ON c.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN clearance_process as cp ON cas.clearance_process_id = cp.id WHERE cas.approverStaffId = '$staffId' AND current_flag = 1";
                                                            if($helper->totalCount != 0) {
                                                                foreach ($rows as $row) {
                                                                    $cid = $row['clearance_id'];
                                                                    ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php 
                                                                                    if($staffId == '107036') {
                                                                                        $requestPrefix = substr($row['requestNo'],0,3);
                                                                                        if($requestPrefix == 'CLR') {
                                                                                            $reqNo = $row['requestNo'];
                                                                                            $istapAydi = $row['staffId'];
                                                                                            $chk = new DBaseManipulation;
                                                                                            $rowX = $chk->singleReadFullQry("SELECT TOP 1 requestNo, staffId FROM exit_interview_final WHERE requestNo = '$reqNo' AND staffId = '$istapAydi'");
                                                                                            if($chk->totalCount != 0) {
                                                                                                ?>
                                                                                                <a href="clearance_details.php?id=<?php echo $row['clearance_id']; ?>&sid=<?php echo $row['staffId']; ?>" title="Click to view details"><?php echo $row['requestNo']; ?></a>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <a href="clearance_exit_interview.php?id=<?php echo $row['clearance_id']; ?>&sid=<?php echo $row['staffId']; ?>" title="Click to conduct an exit interview"><?php echo $row['requestNo']; ?></a>
                                                                                                <?php
                                                                                            }    
                                                                                        } else {
                                                                                            ?>
                                                                                            <a href="clearance_details.php?id=<?php echo $row['clearance_id']; ?>&sid=<?php echo $row['staffId']; ?>" title="Click to view details"><?php echo $row['requestNo']; ?></a>
                                                                                            <?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
                                                                                        <a href="clearance_details.php?id=<?php echo $row['clearance_id']; ?>&sid=<?php echo $row['staffId']; ?>" title="Click to view details"><?php echo $row['requestNo']; ?></a>
                                                                                        <?php 
                                                                                    }
                                                                                ?>        
                                                                            </td>
                                                                            <td>Role as <?php echo $row['process_name']; ?></td>
                                                                            <td><?php echo $row['staffId'].' - '.$row['staffName']; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($row['dateCreated'])); ?></td>
                                                                            <td>
                                                                                <?php echo $row['isCleared'] == 1 ? "<span class='label label-success'>YES</span>" : "<span class='label label-danger'>NO</span>"; ?><br/><a href="REPORT_CLEARANCE_FORM.php?id=<?php echo $row['staffId']; ?>&cid=<?php  echo $row['requestNo']; ?>" target="_blank" title="Click to Print Clearance Form" target="_blank" class="text-primary"><i class="fa fa-print fa-sm"></i> Print</a>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                                    $rows = $helper->readData("SELECT clearance_process_id, status FROM clearance_approval_status WHERE clearance_process_id IN (1,2) AND clearance_id = $cid");
                                                                                    foreach ($rows as $row) {
                                                                                        array_push($deptArray,$row['status']);
                                                                                    }
                                                                                    if (in_array('Pending', $deptArray)) {
                                                                                        echo '<span class="text-warning"><i class="fa fa-hand-paper"></i> Pending</span>';
                                                                                    } else if (in_array('Declined', $deptArray)) {
                                                                                        echo 'Declined';
                                                                                    } else {
                                                                                        echo '<span class="text-success"><i class="fa fa-check"></i> Completed</span>';
                                                                                    }    
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                                    $rows = $helper->readData("SELECT clearance_process_id, status FROM clearance_approval_status WHERE clearance_process_id IN (3,4) AND clearance_id = $cid");
                                                                                    foreach ($rows as $row) {
                                                                                        array_push($AdminArray,$row['status']);
                                                                                    }
                                                                                    if (in_array('Pending', $AdminArray)) {
                                                                                        echo '<span class="text-warning"><i class="fa fa-hand-paper"></i> Pending</span>';
                                                                                    } else if (in_array('Declined', $AdminArray)) {
                                                                                        echo 'Declined';
                                                                                    } else {
                                                                                        echo '<span class="text-success"><i class="fa fa-check"></i> Completed</span>';
                                                                                    }    
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                                    $rows = $helper->readData("SELECT clearance_process_id, status FROM clearance_approval_status WHERE clearance_process_id IN (5) AND clearance_id = $cid");
                                                                                    foreach ($rows as $row) {
                                                                                        array_push($FinanceArray,$row['status']);
                                                                                    }
                                                                                    if (in_array('Pending', $FinanceArray)) {
                                                                                        echo '<span class="text-warning"><i class="fa fa-hand-paper"></i> Pending</span>';
                                                                                    } else if (in_array('Declined', $FinanceArray)) {
                                                                                        echo 'Declined';
                                                                                    } else {
                                                                                        echo '<span class="text-success"><i class="fa fa-check"></i> Completed</span>';
                                                                                    }    
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                                    $rows = $helper->readData("SELECT clearance_process_id, status FROM clearance_approval_status WHERE clearance_process_id IN (6,7,8) AND clearance_id = $cid");
                                                                                    foreach ($rows as $row) {
                                                                                        array_push($ETCArray,$row['status']);
                                                                                    }
                                                                                    if (in_array('Pending', $ETCArray)) {
                                                                                        echo '<span class="text-warning"><i class="fa fa-hand-paper"></i> Pending</span>';
                                                                                    } else if (in_array('Declined', $ETCArray)) {
                                                                                        echo 'Declined';
                                                                                    } else {
                                                                                        echo '<span class="text-success"><i class="fa fa-check"></i> Completed</span>';
                                                                                    }    
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                                    $rows = $helper->readData("SELECT clearance_process_id, status FROM clearance_approval_status WHERE clearance_process_id IN (9) AND clearance_id = $cid");
                                                                                    foreach ($rows as $row) {
                                                                                        array_push($HRArray,$row['status']);
                                                                                    }
                                                                                    if (in_array('Pending', $HRArray)) {
                                                                                        echo '<span class="text-warning"><i class="fa fa-hand-paper"></i> Pending</span>';
                                                                                    } else if (in_array('Declined', $HRArray)) {
                                                                                        echo 'Declined';
                                                                                    } else {
                                                                                        echo '<span class="text-success"><i class="fa fa-check"></i> Completed</span>';
                                                                                    }    
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php 
                                                                                    $rows = $helper->readData("SELECT clearance_process_id, status FROM clearance_approval_status WHERE clearance_process_id IN (10) AND clearance_id = $cid");
                                                                                    foreach ($rows as $row) {
                                                                                        array_push($ADAFAArray,$row['status']);
                                                                                    }
                                                                                    if (in_array('Pending', $ADAFAArray)) {
                                                                                        echo '<span class="text-warning"><i class="fa fa-hand-paper"></i> Pending</span>';
                                                                                    } else if (in_array('Declined', $ADAFAArray)) {
                                                                                        echo 'Declined';
                                                                                    } else {
                                                                                        echo '<span class="text-success"><i class="fa fa-check"></i> Completed</span>';
                                                                                    }    
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end table-responsive-->
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