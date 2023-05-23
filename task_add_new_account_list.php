<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('Approver') || $helper->isAllowed('HoS') || $helper->isAllowed('HoD_HoC')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        $allowed = true;
        if($allowed){
            $check = new DbaseManipulation;
            $rowCheck = $check->singleReadFullQry("SELECT id, task_id, staff_id, department_id FROM taskapprover WHERE status = 'Active' AND staff_id = $staffId");
            if($check->totalCount != 0) {
                $myTaskId = $rowCheck['task_id'];
            } else {
                $myTaskId = 0;
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Create Staff Account Task List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Account Task</li>
                                        <li class="breadcrumb-item">Create Account Task List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <?php
                                if($user_type == 0 || $user_type == 1 || $user_type == 2) {
                            ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-18">
                                            <!---start for list div-->
                                            <div class="card">
                                                <div class="card-header bg-light-info m-b-0 p-b-0">
                                                    <div class="d-flex flex-wrap">
                                                        <div>
                                                            <h3 class="card-title">List of all Create Staff Account Task</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="dynamicTable" class="display table-hover table-striped table-bordered"
                                                            cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>##</th>
                                                                    <th>Request No.</th>
                                                                    <th>Staff ID - Name</th>
                                                                    <th>Task Status</th>
                                                                    <th>HR Account</th>
                                                                    <th>Section Settings </th>
                                                                    <th>Email Account</th>
                                                                    <th>Active Directory</th>
                                                                    <th>System Access</th>
                                                                    <th>Upload Picture</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $i = 0;
                                                                    $getField = new DbaseManipulation;
                                                                    $loadTask = new DbaseManipulation;
                                                                    $sqL = "SELECT * FROM taskprocess WHERE taskType = 1 ORDER BY id DESC";
                                                                    $rows = $loadTask->readData($sqL);
                                                                    if($loadTask->totalCount != 0) {
                                                                        foreach($rows as $row){
                                                                            $staffName = $getField->getStaffName($row['staff_id'],'firstName','secondName','thirdName','lastName');
                                                                ?>
                                                                            <tr>
                                                                                <td><?php echo ++$i."."; ?></td>
                                                                                <td style="font-weight:bold"><a href="task_add_account_details.php?id=<?php echo $row['staff_id']; ?>&t=<?php echo $row['id']; ?>"><?php echo $row['requestNo']; ?></a></td>
                                                                                <td><?php echo $row['staff_id']." - ".$staffName; ?></td>
                                                                                <td><?php echo $row['taskProcessStatus']; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],1,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],1,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;                                                                           
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],2,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],2,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],3,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],3,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],4,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],4,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],5,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],5,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],6,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],6,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
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
                                                <!--end card body-->
                                            </div>
                                            <!--end card-->
                                        </div>
                                        <!--end col-lg-6-->
                                    </div>
                                    <!--end row-->
                            <?php
                                } else {
                            ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-18">
                                            <!---start for list div-->
                                            <div class="card">
                                                <div class="card-header bg-light-info m-b-0 p-b-0">
                                                    <div class="d-flex flex-wrap">
                                                        <div>
                                                            <h3 class="card-title">List of all Create Staff Account Task</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="dynamicTable" class="display table-hover table-striped table-bordered"
                                                            cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>##</th>
                                                                    <th>Request No.</th>
                                                                    <th>Staff ID - Name</th>
                                                                    <th>Task Status</th>
                                                                    <th>HR Account</th>
                                                                    <th>Section Settings </th>
                                                                    <th>Email Account</th>
                                                                    <th>Active Directory</th>
                                                                    <th>System Access</th>
                                                                    <th>Upload Picture</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $i = 0;
                                                                    $getField = new DbaseManipulation;
                                                                    $loadTask = new DbaseManipulation;
                                                                    $sqL = "SELECT * FROM taskprocess WHERE taskType = 1 ORDER BY id DESC";
                                                                    $rows = $loadTask->readData($sqL);
                                                                    if($loadTask->totalCount != 0) {
                                                                        foreach($rows as $row){
                                                                            $staffName = $getField->getStaffName($row['staff_id'],'firstName','secondName','thirdName','lastName');
                                                                ?>
                                                                            <tr class="clickable-row" data-href="task_add_account_details.php?id=<?php echo $row['staff_id']; ?>&t=<?php echo $row['id']; ?>">
                                                                                <td><?php echo ++$i."."; ?></td>
                                                                                <td style="font-weight:bold"><?php echo $row['requestNo']; ?></td>
                                                                                <td><?php echo $row['staff_id']." - ".$staffName; ?></td>
                                                                                <td><?php echo $row['taskProcessStatus']; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],1,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],1,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;                                                                           
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],2,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],2,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],3,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],3,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],4,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],4,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],5,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],5,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                        $status = $getField->getTaskStatus($row['id'],6,'status');
                                                                                        if($status == 'Completed') {
                                                                                            $transDate = $getField->getTaskStatus($row['id'],6,'transactionDate');
                                                                                    ?>
                                                                                            <i class="fa fa-thumbs-up"></i> Completed <p><small class="label label-info"><?php echo date('d/m/Y H:i:s', strtotime($transDate)); ?></small></p>
                                                                                    <?php        
                                                                                        } else {
                                                                                            echo $status;
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
                                                <!--end card body-->
                                            </div>
                                            <!--end card-->
                                        </div>
                                        <!--end col-lg-6-->
                                    </div>
                            <?php
                                }
                            ?>        
                        </div>
                        <footer class="footer">
                            <?php
                                include('include_footer.php'); 
                            ?>
                        </footer>
                    </div>
                </div>
                <?php
                    include('include_scripts.php');
                ?>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>