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
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php   include('menu_top.php'); ?>
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">ALL Compensatory Leave Request List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Compensatory Leave</li>
                                        <li class="breadcrumb-item active">ALL Compensatory Leave Request List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0">
                                            <h4 class="card-title">All Compensatory Leave Request List</h4>
                                            <h6>قائمة بكل طلبات العمل الاضافي</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Request No</th>
                                                            <th>Request Date</th>
                                                            <th>Requested By</th>
                                                            <th>Department</th>
                                                            <th>Status</th>                                                            
                                                            <th>Current Approval Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $info = new DbaseManipulation;
                                                            $rows = $helper->readData("SELECT ot.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as requestor, d.name as department FROM internalleaveovertimefiled as ot INNER JOIN staff as s ON s.staffId = ot.createdBy INNER JOIN employmentdetail as e ON e.staff_id = ot.createdBy INNER JOIN department as d ON d.id = e.department_id WHERE e.isCurrent = 1 and e.status_id = 1 ORDER BY ot.id DESC");
                                                            if($helper->totalCount != 0) {
                                                                $page_id = $helper->pageId('overtime_request_my.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    $linkaydi = $lid;    
                                                                }
                                                                $i = 0;
                                                                foreach($rows as $row){
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                            <td class="text-primary"><?php echo $row['requestNo']; ?></td>
                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($row['dateFiled'])); ?></td>
                                                                            <td><?php echo $row['requestor']; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td>
                                                                                <?php 
                                                                                    $requestor = $row['createdBy'];
                                                                                    $requestor_position_id = $info->employmentIDs($requestor,'position_id');
                                                                                    
                                                                                    $lastApproverStaffId = $info->overtimeLastStatus($row['requestNo'],'staff_id');
                                                                                    $lastApproverStaffId_position_id = $info->employmentIDs($lastApproverStaffId,'position_id');

                                                                                    $stat = $info->singleReadFullQry("SELECT * FROM internalleaveovertime_approvalsequence WHERE position_id = $requestor_position_id AND approver_id = $lastApproverStaffId_position_id");
 /*                                                                                   if($info->totalCount != 0) {
                                                                                        $isFinal = $stat['is_final'];
                                                                                        if($isFinal == 1) {
                                                                                            echo 'Approved';
                                                                                        } else {
                                                                                            echo 'Pending';
                                                                                        }
                                                                                    } else {
                                                                                        echo 'Pending';
                                                                                    } */
                                                                                ?>
                                                                            </td>
                                                                            <td><?php echo $helper->overtimeLastStatus($row['requestNo'],'status'); ?></td>
                                                                            <td>
                                                                                <a href="overtime_request_approval.php?id=<?php echo $row['id']; ?>&linkid=<?php echo $linkaydi; ?>" class="btn btn-outline-primary waves-effect waves-light" title="Click to Edit or View Details"><i class="fas fa-search"></i> View Details</a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>



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
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>