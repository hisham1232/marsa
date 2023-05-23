<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
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
                                    <div class="card card-outline-info">
                                        <div class="card-header">
                                            <h4 class="m-b-0 text-white">Search Staff Form</h4>
                                        </div>
                                        <div class="card-body">
                                            <form  class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Department</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="department_id[]" id="department_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Department">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM department ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                    <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('department_id').value = "<?php echo $_POST['department_id'];?>";
                                                                         </script>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">                                                            
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Section</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="section_id[]" id="section_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Section">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM section ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                    <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('section_id').value = "<?php echo $_POST['section_id'];?>";
                                                                         </script>  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                    <div class="col-lg-4">   
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Sponsor</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="sponsor_id[]" id="sponsor_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Sponsor">
                                                                            <option value="999">All Company</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM sponsor ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                    <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sponsor_id').value = "<?php echo $_POST['sponsor_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">   
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Leave Category</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="leavetype_id[]" id="leavetype_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Leave Category">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM leavetype ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                    <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('leavetype_id').value = "<?php echo $_POST['leavetype_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">   
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Date Range</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control daterange" />
                                                                        <input type="hidden" name="startDate" value="<?php echo date('Y-m-d'); ?>" class="form-control startDate" />
                                                                        <input type="hidden" name="endDate" value="<?php echo date('Y-m-d'); ?>" class="form-control endDate" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">   
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Status</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="current_status[]" id="current_status" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Status">
                                                                            <option value="Pending">Pending</option>
                                                                            <option value="Approved">Approved</option>
                                                                            <option value="Declined">Declined</option>
                                                                            <option value="Cancelled">Cancelled</option>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('current_status').value = "<?php echo $_POST['current_status'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-b-0">
                                                            <div class="offset-sm-4 col-sm-8">
                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-search"></i> Search</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                                                            if(isset($_POST['submit'])) {
                                                                $sql = "SELECT s.id, s.staff_id, concat(sf.firstName,' ',sf.secondName,' ',sf.thirdName,' ',sf.lastName) as staffName, d.name as department, sec.name as section, sp.name as sponsor, s.requestNo, l.name as leave_type, s.dateFiled, s.startDate, s.endDate, s.total, s.modified, s.currentStatus FROM standardleave as s LEFT OUTER JOIN staff as sf ON sf.staffId = s.staff_id LEFT OUTER JOIN leavetype as l ON s.leavetype_id = l.id LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sec ON sec.id = e.section_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id WHERE e.isCurrent = 1 ";
                                                                if ($_POST['department_id'] != '') {
                                                                    $departmentIds = array();
                                                                    foreach ($_POST['department_id'] as $selectedIds) {
                                                                        array_push($departmentIds,$selectedIds);
                                                                    }
                                                                    $departmentIds = implode(', ', $departmentIds);
                                                                    $sql .= " AND e.department_id IN (".$departmentIds.")";
                                                                }

                                                                if ($_POST['section_id'] != '') {
                                                                    $sectionIds = array();
                                                                    foreach ($_POST['section_id'] as $selectedSectionIds) {
                                                                        array_push($sectionIds,$selectedSectionIds);
                                                                    }
                                                                    $sectionIds = implode(', ', $sectionIds);
                                                                    $sql .= " AND e.section_id IN (".$sectionIds.")";
                                                                }

                                                                if ($_POST['sponsor_id'] != '') {
                                                                    if($_POST['sponsor_id'] == 999)
                                                                        $sql .= " AND e.sponsor_id != 1";
                                                                    else
                                                                        $sponsorIds = array();
                                                                        foreach ($_POST['sponsor_id'] as $selectedSponsorIds) {
                                                                            array_push($sponsorIds,$selectedSponsorIds);
                                                                        }
                                                                        $sponsorIds = implode(', ', $sponsorIds);
                                                                        $sql .= " AND e.sponsor_id IN (".$sponsorIds.")";
                                                                }

                                                                if ($_POST['leavetype_id'] != '') {
                                                                    $leaveIds = array();
                                                                    foreach ($_POST['leavetype_id'] as $selectedLeaveIds) {
                                                                        array_push($leaveIds,$selectedLeaveIds);
                                                                    }
                                                                    $leaveIds = implode(', ', $leaveIds);
                                                                    $sql .= " AND s.leavetype_id IN (".$leaveIds.")";
                                                                }

                                                                if ($_POST['current_status'] != '') {
                                                                    $cStatus = array();
                                                                    foreach ($_POST['current_status'] as $selectedcStatus) {
                                                                        $selectedcStatus = "'".$selectedcStatus."'";
                                                                        array_push($cStatus,$selectedcStatus);
                                                                    }
                                                                    $cStatus = implode(', ', $cStatus);
                                                                    $sql .= " AND s.currentStatus IN (".$cStatus.")";
                                                                }
                                                                $startDate  = $_POST['startDate'];
                                                                $endDate    = $_POST['endDate'];
                                                                $sql .= " AND s.startDate >= '$startDate' AND s.endDate <= '$endDate'";
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