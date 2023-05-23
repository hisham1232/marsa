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
                                    <h3 class="text-themecolor m-b-0 m-t-0">All Standard Leave List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Standard Leave</li>
                                        <li class="breadcrumb-item">All Standard Leave List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <?php /*
                                <div class="row">
                                    <div class="col-lg-6 col-xs-18">
                                        <div class="card card-body p-b-0">
                                            <form action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Select Date</label>
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
                            */ ?>    
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">All Staff Standard Leave List</h4>
                                            <h6 class="card-subtitle">قائمة كل الإجازات</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTableAllSTL" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request ID</th>
                                                            <th>Staff ID</th>
                                                            <th>Staff Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Sponsor</th>
                                                            <th>Leave Category</th>
                                                            <th>Date Filed</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Days</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                        
                                                        $data = new DbaseManipulation;
                                                        if(isset($_POST['searchByDate'])) {
                                                            $startDate = $_POST['startDate'];
                                                            $endDate = $_POST['endDate'];
                                                            $sql = "SELECT s.id, s.staff_id, concat(sf.firstName,' ',sf.secondName,' ',sf.thirdName,' ',sf.lastName) as staffName, d.name as department, sec.name as section, sp.name as sponsor, s.requestNo, l.name as leave_type, s.dateFiled, s.startDate, s.endDate, s.total, s.modified, s.currentStatus FROM standardleave as s LEFT OUTER JOIN staff as sf ON sf.staffId = s.staff_id LEFT OUTER JOIN leavetype as l ON s.leavetype_id = l.id LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sec ON sec.id = e.section_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id WHERE e.isCurrent = 1 AND s.startDate <= '$startDate' AND s.endDate >= '$endDate' ORDER BY s.id DESC";
                                                            $rows = $data->readData($sql);
                                                        } else {
                                                            $sql = "SELECT s.id, s.staff_id, concat(sf.firstName,' ',sf.secondName,' ',sf.thirdName,' ',sf.lastName) as staffName, d.name as department, sec.name as section, sp.name as sponsor, s.requestNo, l.name as leave_type, s.dateFiled, s.startDate, s.endDate, s.total, s.modified, s.currentStatus FROM standardleave as s LEFT OUTER JOIN staff as sf ON sf.staffId = s.staff_id LEFT OUTER JOIN leavetype as l ON s.leavetype_id = l.id LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sec ON sec.id = e.section_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id WHERE e.isCurrent = 1 ORDER BY s.id DESC";
                                                            $rows = $data->readData($sql);
                                                        }
                                                        if($data->totalCount != 0) {
                                                            foreach($rows as $row){
                                                                ?>
                                                                <tr>
                                                                    <td><a href="standardleave_details.php?id=<?php echo $row['requestNo']; ?>&uid=<?php echo $row['staff_id']; ?>"><?php echo $row['requestNo']; ?></a></td>
                                                                    <td><?php echo $row['staff_id']; ?></td>
                                                                    <td><?php echo $row['staffName']; ?></td>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['sponsor']; ?></td>
                                                                    <td><?php echo $row['leave_type']; ?></td>
                                                                    <td><?php echo date('d/m/Y H:i:s',strtotime($row['dateFiled'])); ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                    <td><?php echo $row['total']; ?></td>
                                                                    <td><?php echo $row['currentStatus']; ?></td>
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