<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed || $staffId = '404009' || $staffId = '196058'){ //Customized for the Auditor (196058) and Database Admin, Mr. Ali (404009)        
            if($user_type == 3) {
                $filter = ' AND e.department_id = '.$logged_in_department_id;
            } else if ($user_type == 4) {
                $filter = ' AND e.section_id = '.$logged_in_section_id;
            } else if ($user_type == 0 || $user_type == 1){
                $filter = ' AND e.department_id = '.$logged_in_department_id;
            }
            $departmentName = $helper->fieldNameValue("department",$logged_in_department_id,'name');
            $sectionName = $helper->fieldNameValue("section",$logged_in_section_id,'name');                            
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">ALL Staff Attendance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Attendance </li>
                                        <li class="breadcrumb-item">All Staff Attendance </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <form id="form-attendance" method="POST" action="">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Department</label>
                                                <div class="col-sm-4">
                                                    <select name="department_id" class="form-control" id="department_id">
                                                        <?php 
                                                            $rows = $helper->readData("SELECT id, name FROM department WHERE id = $logged_in_department_id");
                                                            foreach ($rows as $row) {
                                                                ?>
                                                                <option value="<?php echo $row['id']; ?>" selected><?php echo $row['name']; ?></option>
                                                                <?php            
                                                            }    
                                                        ?>
                                                    </select>
                                                    <script>
                                                        $('#department_id').val('<?php echo $_POST['department_id']; ?>');
                                                    </script>
                                                </div>
                                                <label class="col-sm-2 col-form-label">Section</label>
                                                <div class="col-sm-4">
                                                    <select name="section_id" class="form-control" id="section_id">
                                                        
                                                        <?php 
                                                            if($user_type == 3 || $user_type == 0 || $user_type == 1 || $user_type == 2) {
                                                                ?>
                                                                <option value="">Select Section</option>
                                                                <?php
                                                                $rows = $helper->readData("SELECT id, name FROM section WHERE department_id = $logged_in_department_id ORDER BY id");
                                                            } else if ($user_type == 4) {
                                                                $rows = $helper->readData("SELECT id, name FROM section WHERE id = $logged_in_section_id ORDER BY id");
                                                            }
                                                            foreach ($rows as $row) {
                                                                if($user_type == 4) {
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
                                                    <script>
                                                        $('#section_id').val('<?php echo $_POST['section_id']; ?>');
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group row">    
                                                <label class="col-sm-2 col-form-label">Sponsor</label>
                                                <div class="col-sm-4">
                                                    <select name="sponsor_id" class="form-control" id="sponsor_id">
                                                        <option value="">Select Sponsor</option>
                                                        <?php 
                                                            $rows = $helper->readData("SELECT id, name FROM sponsor ORDER BY id");
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                        <?php            
                                                            }    
                                                        ?>
                                                    </select>
                                                    <script>
                                                        $('#sponsor_id').val('<?php echo $_POST['sponsor_id']; ?>');
                                                    </script>
                                                </div>
                                                <label class="col-sm-2 col-form-label">Date Range</label>
                                                <div class="col-sm-4">
                                                    <input type='text' class="form-control daterange" />
                                                    <input type="hidden" name="startDate" value="<?php echo date('Y-m-d'); ?>" class="form-control startDate" />
                                                    <input type="hidden" name="endDate" value="<?php echo date('Y-m-d'); ?>" class="form-control endDate" />
                                                </div>
                                            </div>
                                            <div class="form-group row">    
                                                <label class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-4">
                                                    <select name="attendance_status" class="form-control attendance_status" id="attendance_status">
                                                        <option value="">Select Attendance Status</option>
                                                        <option value="Present">Present</option>
                                                        <option value="Absent">Absent</option>
                                                        <option value="Missing Time">Missing Time</option>
                                                        <option value="Under Time">Under Time</option>
                                                        <option value="On Leave">On Leave</option>
                                                        <option value="Holidays">Holidays</option>
                                                        <option value="Weekend">Weekend</option>
                                                    </select>
                                                    <script>
                                                        $('#attendance_status').val('<?php echo $_POST['attendance_status']; ?>');
                                                    </script>
                                                </div>
                                                <label class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-4">
                                                    <button name="searchBtn" class="btn btn-success waves-effect waves-light searchBtn" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Search Result</h4>
                                            <?php
                                                if(!isset($_POST['searchBtn'])) {
                                            ?>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Start Date: <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">End Date: <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="m-b-0">Department: <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Section: <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Sponsor: <span class="text-primary"></span></p>
                                                        </div>
                                                    </div>
                                            <?php
                                                } else {
                                                    if($_POST['department_id'] == ""){
                                                        $deptDisplay = "ALL";
                                                    } else {
                                                        $department_id = $_POST['department_id'];
                                                        $deptDisplay = $helper->fieldNameValue("department",$department_id,"name");
                                                    }
                                                    if($_POST['section_id'] == ""){
                                                        $sectDisplay = "ALL";
                                                    } else {
                                                        $section_id = $_POST['section_id'];
                                                        $sectDisplay = $helper->fieldNameValue("section",$section_id,"name");
                                                    }
                                                    if($_POST['sponsor_id'] == ""){
                                                        $sponDisplay = "ALL";
                                                    } else {
                                                        $sponsor_id = $_POST['sponsor_id'];
                                                        $sponDisplay = $helper->fieldNameValue("sponsor",$sponsor_id,"name");
                                                    }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Start Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($_POST['startDate'])); ?></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">End Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($_POST['endDate'])); ?></span></p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="m-b-0">Department: <span class="text-primary"><?php echo $deptDisplay; ?></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Section: <span class="text-primary"><?php echo $sectDisplay; ?></span></p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $sponDisplay; ?></span></p>
                                                        </div>
                                                    </div>    
                                                    <?php
                                                }
                                            ?>        
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTableAttendanceAll" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Staff ID - Name</th>
                                                            <th>Sponsor</th>    
                                                            <th>Department</th>
                                                            <th>Date</th>
                                                            <th>In</th>
                                                            <th>Out</th>
                                                            <th>Hours</th>
                                                            <th>Overtime</th>
                                                            <th>Status</th>
                                                            <th>Leave</th>
                                                            <th>Request No</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(isset($_POST['searchBtn'])){
                                                                $startDate =  $helper->cleanString($_POST['startDate']);
                                                                $endDate = $helper->cleanString($_POST['endDate']);
                                                                $staffQuery = new DbaseManipulation;
                                                                $showAttendance = new DbaseManipulation;
                                                                $qryCheckLeave = new DbaseManipulation;
                                                                $qryCheckLeave2 = new DbaseManipulation;
                                                                $qryRamadan = new DbaseManipulation;
                                                                $qryHoliday = new DbaseManipulation;
                                                                $j = 0;
                                                                $qryText = "SELECT e.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, sp.name as sponsor, d.name as department FROM employmentdetail as e LEFT OUTER JOIN staff as s ON s.staffId = e.staff_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN department as d ON d.id = e.department_id WHERE e.status_id = 1 AND e.isCurrent = 1 ";
                                                                if ($department_id != '') { 
                                                                    $qryText .= " AND e.department_id = ".$department_id; 
                                                                }
                                                                if ($section_id != '') { 
                                                                    $qryText .= " AND e.section_id = ".$section_id; 
                                                                }
                                                                if ($sponsor_id != '') { 
                                                                    $qryText .= " AND e.sponsor_id = ".$sponsor_id; 
                                                                }
                                                                
                                                                //echo $qryText;
                                                                echo "<input type='hidden' id='astat' value='".$_POST['attendance_status']."'>";
                                                                $rows = $staffQuery->readData($qryText);
                                                                if($staffQuery->totalCount != 0) {
                                                                    foreach($rows as $srow){
                                                                        if($startDate != '' && $endDate != '') {
                                                                            $newDateRanges = $helper->createDateRangeArray($startDate,$endDate);
                                                                        } else if ($startDate != '' && $endDate == '') {
                                                                            $newDateRanges = $helper->createDateRangeArray($startDate,date("Y-m-d"));	
                                                                        } else {
                                                                            $newDateRanges = $helper->createDateRangeArray(date("Y-m-d"),date("Y-m-d"));  
                                                                        }
                                                                        $ctr = count($newDateRanges);
                                                                        $staffId = $srow['staff_id'];
                                                                        for($i=$ctr-1; $i>=0; $i--) {
                                                                            $att = $showAttendance->singleReadFullQry("SELECT * FROM v_attendance WHERE StaffId = '$staffId' AND Date >= '$newDateRanges[$i]' AND Date <= '$newDateRanges[$i]'");
                                                                            //echo "SELECT * FROM v_attendance WHERE StaffId = '$staffId' AND Date >= '$newDateRanges[$i]' AND Date <= '$newDateRanges[$i]'";
                                                                            if($showAttendance->totalCount < 1){
                                                                                ?>
                                                                                    <tr>
                                                                                        <td><?php echo ++$j.'.'; ?></td>
                                                                                        <td><?php echo $srow['staff_id']." - ".$srow['staffName']; ?></td>
                                                                                        <td><?php echo $srow['sponsor']; ?></td>
                                                                                        <td><?php echo $srow['department']; ?></td>
                                                                                        <?php
                                                                                            if (date("w",strtotime($newDateRanges[$i])) == 5 || date("w",strtotime($newDateRanges[$i])) == 6) {
                                                                                                ?>
                                                                                                    <td><span class="bg-weekend"><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></span></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td><span class="bg-weekend">Weekend</span></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                <?php
                                                                                            }  else {
                                                                                                $chkLeave = $qryCheckLeave->singleReadFullQry("SELECT s.id, s.requestNo, s.leavetype_id, l.name as leavetype, s.dateFiled, s.currentStatus, s.startDate, s.endDate FROM standardleave AS s LEFT OUTER JOIN leavetype as l ON l.id = s.leavetype_id WHERE (s.startDate <= '$newDateRanges[$i]' AND s.endDate >= '$newDateRanges[$i]') AND s.staff_id = '$staffId'");
                                                                                                if($qryCheckLeave->totalCount != 0) { //No Attendance BUT there is a LEAVE FILED.
                                                                                                    if($chkLeave['currentStatus'] == 'Cancelled' || $chkLeave['currentStatus'] == 'Declined'){
                                                                                                        ?>
                                                                                                            <td><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td><span class="bg-absent">Absent</span></td>
                                                                                                            <td><?php echo $chkLeave['leavetype']; ?></td>
                                                                                                            <td><a href="replace_this_link.php?id=<?php echo $chkLeave['requestNo']; ?>&uid=<?php echo $staffId; ?>" target="_blank"><?php echo $chkLeave['requestNo']; ?></a></td>
                                                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($chkLeave['dateFiled'])); ?></td>
                                                                                                            <td><?php echo $chkLeave['currentStatus']; ?></td>
                                                                                                        <?php                                                                                                
                                                                                                    } else {
                                                                                                        ?>
                                                                                                            <td><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td><span class="bg-onleave">On Leave</span></td>
                                                                                                            <td><?php echo $chkLeave['leavetype']; ?></td>
                                                                                                            <?php /*<td><a href="replace_this_link.php?id=<?php echo $chkLeave['requestNo']; ?>&uid=<?php echo $staffId; ?>" target="_blank"><?php echo $chkLeave['requestNo']; ?></a></td>*/ ?>
                                                                                                            <td><a href="#"><?php echo $chkLeave['requestNo']; ?></a></td>
                                                                                                            <td><?php echo date('d/m/Y H:i:s',strtotime($chkLeave['dateFiled'])); ?></td>
                                                                                                            <td><?php echo $chkLeave['currentStatus']; ?></td>
                                                                                                        <?php                                                                                                
                                                                                                    }
                                                                                                } else {
                                                                                                    //Check Holiday Here
                                                                                                    $chkHoliday = $qryHoliday->singleReadFullQry("SELECT * FROM holiday WHERE (startDate <= '$newDateRanges[$i]' AND endDate >= '$newDateRanges[$i]')");
                                                                                                    $isRamadan = $chkHoliday['isRamadan'];
                                                                                                    if($qryHoliday->totalCount != 0 && $isRamadan != 1){
                                                                                                        $holidayName = $chkHoliday['name'];
                                                                                                        ?>
                                                                                                            <td><span class="bg-weekend"><?php echo date('d/m/Y',strtotime($newDateRanges[$i])) ?> - <?php echo $holidayName; ?></span></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td><span class="bg-weekend">Holidays</span></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        <?php                                                                                                
                                                                                                    } else {
                                                                                                        ?>
                                                                                                            <td><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td><span class="bg-absent">Absent</span></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        <?php                                                                                                
                                                                                                    }    
                                                                                                }
                                                                                            }                      
                                                                                        ?>
                                                                                    </tr>
                                                                                <?php
                                                                            } else {
                                                                                if (date("w",strtotime($newDateRanges[$i])) == 5 || date("w",strtotime($newDateRanges[$i])) == 6) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo ++$j.'.'; ?></td>
                                                                                            <td><?php echo $srow['staff_id']." - ".$srow['staffName']; ?></td>
                                                                                            <td><?php echo $srow['sponsor']; ?></td>
                                                                                            <td><?php echo $srow['department']; ?></td>
                                                                                            <td><span class="bg-weekend"><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></span></td>
                                                                                            <td><?php echo substr($att['TimeIn'],0,8); ?></td>
                                                                                            <td><?php echo substr($att['TimeOut'],0,8); ?></td>
                                                                                            <td><?php echo $att['noOfHours']; ?></td>
                                                                                            <td><?php echo $att['noOfHours']; ?></td>
                                                                                            <td><span class="bg-overtime">Weekend Work</span></td>
                                                                                            <td><span class="bg-overtime">Overtime</span></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    <?php                                                                            
                                                                                } else {   
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td><?php echo ++$j.'.'; ?></td>
                                                                                            <td><?php echo $srow['staff_id']." - ".$srow['staffName']; ?></td>
                                                                                            <td><?php echo $srow['sponsor']; ?></td>
                                                                                            <td><?php echo $srow['department']; ?></td>
                                                                                            <td><?php echo date('d/m/Y - l',strtotime($att['Date'])); ?></td>
                                                                                            <td><?php echo substr($att['TimeIn'],0,8); ?></td>
                                                                                            <td><?php echo substr($att['TimeOut'],0,8); ?></td>
                                                                                            <td><?php echo $att['noOfHours']; ?></td>
                                                                                            <td><?php if ($att['missingTime'] != 'Y') echo $att['overTime']; ?></td>
                                                                                                <?php
                                                                                                    if($att['missingTime'] == 'Y') {
                                                                                                        $chkLeave2 = $qryCheckLeave2->singleReadFullQry("SELECT * FROM shortleave WHERE (leaveDate <= '$newDateRanges[$i]' AND leaveDate >= '$newDateRanges[$i]') AND staff_id = '$staffId'");
                                                                                                        if($qryCheckLeave2->totalCount != 0) { //Missing Time BUT there is a SHORT LEAVE FILED.
                                                                                                            $leaveRequestNo = $chkLeave2['requestNo'];
                                                                                                            ?>
                                                                                                                <td><span class="bg-onleave">On Short Leave</span></td>
                                                                                                                <td>Short Leave</td>
                                                                                                                <td><a href='#'><?php echo $leaveRequestNo; ?></a></td>
                                                                                                                <td><?php echo date('d/m/Y',strtotime($chkLeave2['leaveDate'])); ?></td>
                                                                                                                <td><?php echo $chkLeave2['currentStatus']; ?></td>
                                                                                                            <?php                                                                                               
                                                                                                        } else {
                                                                                                            $chkLeave = $qryCheckLeave->singleReadFullQry("SELECT s.id, s.requestNo, s.leavetype_id, l.name as leavetype, s.dateFiled, s.currentStatus, s.startDate, s.endDate FROM standardleave AS s LEFT OUTER JOIN leavetype as l ON l.id = s.leavetype_id WHERE (s.startDate <= '$newDateRanges[$i]' AND s.endDate >= '$newDateRanges[$i]') AND s.staff_id = '$staffId'");
                                                                                                            if($chkLeave['currentStatus'] == 'Cancelled' || $chkLeave['currentStatus'] == 'Declined'){
                                                                                                                ?>
                                                                                                                <td><span class="bg-missingtime">Missing Time</span></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <?php
                                                                                                                $missingTime++;
                                                                                                            } else {
                                                                                                                ?>
                                                                                                                <td><span class="bg-onleave">On Leave</span></td>
                                                                                                                <td><?php echo $chkLeave['leavetype']; ?></td>
                                                                                                                <td><a href="#"><?php echo $chkLeave['requestNo']; ?></a></td>
                                                                                                                <td><?php echo date('d/m/Y H:i:s',strtotime($chkLeave['dateFiled'])); ?></td>
                                                                                                                <td><?php echo $chkLeave['currentStatus']; ?></td>
                                                                                                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                    } else if ($att['missingTime'] == 'N') {
                                                                                                        if($att['underTime'] == 'Y') {
                                                                                                            $attRamadan = $qryRamadan->singleReadFullQry("SELECT * FROM holiday WHERE (startDate <= '$newDateRanges[$i]' AND endDate >= '$newDateRanges[$i]')");
                                                                                                            $isRamadan = $attRamadan['isRamadan'];
                                                                                                            if($qryRamadan->totalCount != 0 && $isRamadan == 1) { //Date is Ramadan, 5 Hours Only
                                                                                                                $chkLeave2 = $qryCheckLeave2->singleReadFullQry("SELECT * FROM shortleave WHERE (leaveDate <= '$newDateRanges[$i]' AND leaveDate >= '$newDateRanges[$i]') AND staff_id = '$staffId'");
                                                                                                                if($qryCheckLeave2->totalCount != 0) { //Under Time BUT there is a SHORT LEAVE FILED.
                                                                                                                    $leaveRequestNo = $chkLeave2['requestNo'];
                                                                                                                    ?>
                                                                                                                        <td><span class="bg-onleave">On Short Leave</span></td>
                                                                                                                        <td>Short Leave</td>
                                                                                                                        <td><a href='#'><?php echo $leaveRequestNo; ?></a></td>
                                                                                                                        <td><?php echo date('d/m/Y',strtotime($chkLeave2['leaveDate'])); ?></td>
                                                                                                                        <td><?php echo $chkLeave2['currentStatus']; ?></td>
                                                                                                                    <?php
                                                                                                                } else {
                                                                                                                    if($att['decimalNoOfHours'] <= 5) {
                                                                                                                        ?>
                                                                                                                            <td><span class="bg-undertime">Under Time</span></td>
                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                        <?php
                                                                                                                        $underTime++;
                                                                                                                    } else {
                                                                                                                        ?>
                                                                                                                            <td><span class='label label-success'>Present</span></td>
                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                    
                                                                                                                }
                                                                                                            } else {
                                                                                                                $chkLeave2 = $qryCheckLeave2->singleReadFullQry("SELECT * FROM shortleave WHERE (leaveDate <= '$newDateRanges[$i]' AND leaveDate >= '$newDateRanges[$i]') AND staff_id = '$staffId'");
                                                                                                                if($qryCheckLeave2->totalCount != 0) { //Under Time BUT there is a SHORT LEAVE FILED.
                                                                                                                    $leaveRequestNo = $chkLeave2['requestNo'];
                                                                                                                    ?>
                                                                                                                        <td><span class="bg-onleave">On Short Leave</span></td>
                                                                                                                        <td>Short Leave</td>
                                                                                                                        <td><a href='#'><?php echo $leaveRequestNo; ?></a></td>
                                                                                                                        <td><?php echo date('d/m/Y',strtotime($chkLeave2['leaveDate'])); ?></td>
                                                                                                                        <td><?php echo $chkLeave2['currentStatus']; ?></td>
                                                                                                                    <?php
                                                                                                                } else {
                                                                                                                    ?>
                                                                                                                        <td><span class="bg-undertime">Under Time</span></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                    <?php
                                                                                                                }
                                                                                                            }
                                                                                                        } else if ($att['underTime'] == 'N') {
                                                                                                            ?>
                                                                                                                <td><span class="bg-present">Present</span></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                ?>
                                                                                        </tr>
                                                                                    <?php
                                                                                }    
                                                                            }//if $showAttendance    
                                                                        }//for
                                                                    }    
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
                <script>                    
                    $(document).ready(function() {
                        var filter = $('#astat').val();
                        $('#dynamicTableAttendanceAll').dataTable({
                            "oSearch": {"sSearch": filter },
                            dom: 'Bfrltip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
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