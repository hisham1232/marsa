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
                    <?php    include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Approvals Leave Request List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Standard Leave</li>
                                        <li class="breadcrumb-item">My Approvals Leave Request List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <form action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Leave Date</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control daterange" />
                                                    <input type="hidden" name="startDate" class="form-control startDate" />
                                                    <input type="hidden" name="endDate" class="form-control endDate" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <button name="searchByDate" class="btn btn-success waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-18">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Information!</h4>
                                        <small>Select starting and ending date in the date range picker and then click on Search Button.</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                                $basic_info = new DBaseManipulation;    
                                                $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
                                            ?>
                                            <h4 class="card-title">STANDARD LEAVE REQUEST APPROVALS (ALREADY APPROVED BY [<?php echo trim($info['staffName']); ?> - <?php echo $info['department']; ?> - <?php echo $info['sponsor']; ?>])</h4>
                                            <h6 class="card-subtitle">قائمة طلبات الإجازة التي قمت بإعتمادها</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Request No</th>
                                                            <th>Staff ID/Name</th>
                                                            <th>Department</th>
                                                            <th>Sponsor</th>
                                                            <th>Leave Category</th>
                                                            <th>Leave Date</th>
                                                            <th>Days</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(isset($_POST['searchByDate'])) {
                                                                $startDate = $_POST['startDate'];
                                                                $endDate = $_POST['endDate'];
                                                                $i=0;
                                                                $ApprovalText = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                                                                $data = new DbaseManipulation;
                                                                $rows = $data->readData("SELECT h.standardleave_id, h.requestNo, stl.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, l.name as leavetype, d.name as department, sp.name as sponsor, stl.startDate, stl.endDate, stl.total, stl.reason, stl.currentStatus  FROM standardleave_history as h
                                                                LEFT OUTER JOIN standardleave as stl ON stl.id = h.standardleave_id
                                                                LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id
                                                                LEFT OUTER JOIN leavetype as l ON l.id = stl.leavetype_id
                                                                LEFT OUTER JOIN employmentdetail as e ON e.staff_id = stl.staff_id
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                                WHERE h.status LIKE '%$ApprovalText%'
                                                                AND stl.startDate <= '$startDate' AND stl.endDate >= '$endDate'
                                                                ORDER BY stl.id DESC");
                                                            } else {
                                                                $i=0;
                                                                $ApprovalText = "Approved - ".$helper->fieldNameValue("staff_position",$myPositionId,'title');
                                                                $data = new DbaseManipulation;
                                                                $rows = $data->readData("SELECT h.standardleave_id, h.requestNo, stl.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, l.name as leavetype, d.name as department, sp.name as sponsor, stl.startDate, stl.endDate, stl.total, stl.reason, stl.currentStatus  FROM standardleave_history as h
                                                                LEFT OUTER JOIN standardleave as stl ON stl.id = h.standardleave_id
                                                                LEFT OUTER JOIN staff as s ON s.staffId = stl.staff_id
                                                                LEFT OUTER JOIN leavetype as l ON l.id = stl.leavetype_id
                                                                LEFT OUTER JOIN employmentdetail as e ON e.staff_id = stl.staff_id
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id
                                                                LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id
                                                                WHERE h.status LIKE '%$ApprovalText%'
                                                                ORDER BY stl.id DESC");
                                                            }
                                                            if($data->totalCount != 0) {
                                                                    foreach ($rows as $row) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo ++$i.'.'; ?></td>
                                                                            <td><a href="standardleave_my_approvals_details.php?id=<?php echo $row['standardleave_id']; ?>&uid=<?php echo $row['staff_id']; ?>"><?php echo $row['requestNo']; ?></a></td>
                                                                            <td><?php echo $row['staff_id'].' - '.$row['staffName']; ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $row['sponsor']; ?></td>
                                                                            <td><?php echo $row['leavetype']; ?></td>
                                                                            <td><?php echo date('d/m/Y',strtotime($row['startDate'])).' to '.date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                            <td><?php echo $row['total']; ?></td>
                                                                            <td><?php echo $row['reason']; ?></td>
                                                                        </tr>
                                                                        <?php 
                                                                    }
                                                            }        
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                        </div><!--end card body-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-6-->
                            </div><!--end row-->
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