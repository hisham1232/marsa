<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed =  $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                if($user_type == 3) {
                    $staff_department_id = $helper->employmentIDs($id,'department_id');
                    if($staff_department_id != $logged_in_department_id) {
                        header("Location: dept_staff_list.php");
                    }
                } else if ($user_type == 4) {
                    $staff_section_id = $helper->employmentIDs($id,'section_id');
                    if($staff_section_id != $logged_in_section_id) {
                        header("Location: dept_staff_list.php");
                    }
                }
            } else {
                header("Location: dept_staff_list.php");
            }                                 
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Search Staff Attendance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">My Department/Section </li>
                                        <li class="breadcrumb-item">My Staff List</li>
                                        <li class="breadcrumb-item active">Staff Attendance</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <?php
                                            if(isset($_POST['searchByDate'])){
                                                $myAttendance = new DBaseManipulation;
                                                $startDate =  $myAttendance->cleanString($_POST['startDate']);
                                                $endDate = $myAttendance->cleanString($_POST['endDate']);
                                                $searched = true;
                                            } else {
                                                $searched = false;
                                            }
                                            
                                        ?>
                                        <form action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Date</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control daterange" />
                                                        <input type="hidden" name="startDate" value="<?php echo date('Y-m-d'); ?>" class="form-control startDate" />
                                                        <input type="hidden" name="endDate" value="<?php echo date('Y-m-d'); ?>" class="form-control endDate" />
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
                                        <small>Select staff name, starting and ending date in the date range picker and then click on Search Button.</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row"><!--for search results-->
                                <div class="col-lg-12 col-xs-18"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Search Result</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <?php
                                                        $staff_id = $_POST['staff_id'];
                                                        $basic_info = new DBaseManipulation;
                                                        $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$id'");
                                                    ?>
                                                    <p class="m-b-0">Staff: <span class="text-primary"><?php if(isset($info['sponsor'])) echo trim($info['staffName'])." [". $info['staffId']."] "; ?></span></p>
                                                    <p class="m-b-0">Sponsor: <span class="text-primary"><?php if(isset($info['sponsor'])) echo $info['sponsor']; ?></span></p>
                                                    <p class="m-b-0">Department: <span class="text-primary"><?php if(isset($info['department'])) echo $info['department']; ?></span></p>
                                                </div>
                                                <?php
                                                    if($searched) {
                                                        ?>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Start Date: <span class="text-primary"><?php echo date("d/m/Y",strtotime($startDate)); ?></span></p>
                                                            <p class="m-b-0">End Date: <span class="text-primary"><?php echo date("d/m/Y",strtotime($endDate)); ?></span></p>
                                                            <p class="m-b-0">Num. of Working Days: <span class="text-primary workingDaysCtr"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Present: <span class="text-primary presentCtr"></span></p>
                                                            <p class="m-b-0">Under Time: <span class="text-primary underTimeCtr"></span></p>
                                                            <p class="m-b-0">Over Time: <span class="text-primary overTimeCtr"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Absent: <span class="text-primary absentCtr"></span></p>
                                                            <p class="m-b-0">Short Leave: <span class="text-primary shortLeaveCtr"></span></p>
                                                            <p class="m-b-0">On Leave:<span class="text-primary onLeaveCtr"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Missing Time: <span class="text-primary missingTimeCtr"></span></p>      
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Start Date: <span class="text-primary"></span></p>
                                                            <p class="m-b-0">End Date: <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Num. of Working Days: <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Present: <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Under Time: <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Over Time: <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Absent: <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Short Leave: <span class="text-primary"></span></p>
                                                            <p class="m-b-0">On Leave:<span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Missing Time: <span class="text-primary"></span></p>      
                                                        </div>
                                                        <?php
                                                    }
                                                ?>        
                                            </div><!--end row-->
                                        </div><!--end card header-->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>    
                                                            <th>Date</th>
                                                            <th>In</th>
                                                            <th>Out</th>
                                                            <th>Hours</th>
                                                            <th>Status</th>
                                                            <th>Leave</th>
                                                            <th>Request No</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(isset($_POST['searchByDate'])){
                                                                $j = 0;
                                                                $workingDays = 0;
                                                                $present = 0;
                                                                $underTime = 0;
                                                                $overTime = 0;
                                                                $absent = 0;
                                                                $shortLeave = 0;
                                                                $onLeave = 0;
                                                                $missingTime = 0;
                                                                if($startDate != '' && $endDate != '') {
                                                                    $newDateRanges = $helper->createDateRangeArray($startDate,$endDate);
                                                                } else if ($startDate != '' && $endDate == '') {
                                                                    $newDateRanges = $helper->createDateRangeArray($startDate,date("Y-m-d"));	
                                                                } else {
                                                                    $newDateRanges = $helper->createDateRangeArray(date("Y-m-d"),date("Y-m-d"));  
                                                                }
                                                                $ctr = count($newDateRanges);
                                                                $workingDays = $ctr;
                                                                $showAttendance = new DbaseManipulation;
                                                                $qryCheckLeave = new DbaseManipulation;
                                                                $qryCheckLeave2 = new DbaseManipulation;
                                                                $qryRamadan = new DbaseManipulation;
                                                                $qryHoliday = new DbaseManipulation;
                                                                $staffId = $id;
                                                                for($i=$ctr-1; $i>=0; $i--) {
                                                                    $att = $showAttendance->singleReadFullQry("SELECT * FROM v_attendance WHERE StaffId = '$staffId' AND Date >= '$newDateRanges[$i]' AND Date <= '$newDateRanges[$i]'");
                                                                    //echo "SELECT * FROM v_attendance WHERE StaffId = '$staffId' AND Date >= '$newDateRanges[$i]' AND Date <= '$newDateRanges[$i]'";
                                                                    if($showAttendance->totalCount < 1){
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo ++$j.'.'; ?></td>
                                                                                <?php
                                                                                    if (date("w",strtotime($newDateRanges[$i])) == 5 || date("w",strtotime($newDateRanges[$i])) == 6) {
                                                                                        ?>
                                                                                            <td><span class="bg-weekend"><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></span></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td><span class="bg-weekend">Weekend</span></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        <?php
                                                                                        $workingDays--;
                                                                                    }  else {
                                                                                        $chkLeave = $qryCheckLeave->singleReadFullQry("SELECT s.id, s.requestNo, s.leavetype_id, l.name as leavetype, s.dateFiled, s.currentStatus, s.startDate, s.endDate FROM standardleave AS s LEFT OUTER JOIN leavetype as l ON l.id = s.leavetype_id WHERE (s.startDate <= '$newDateRanges[$i]' AND s.endDate >= '$newDateRanges[$i]') AND s.staff_id = '$staffId'");
                                                                                        if($qryCheckLeave->totalCount != 0) { //No Attendance BUT there is a LEAVE FILED.
                                                                                            if($chkLeave['currentStatus'] == 'Cancelled' || $chkLeave['currentStatus'] == 'Declined'){
                                                                                                ?>
                                                                                                    <td><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td><span class="bg-absent">Absent</span></td>
                                                                                                    <td><?php echo $chkLeave['leavetype']; ?></td>
                                                                                                    <td><a href="replace_this_link.php?id=<?php echo $chkLeave['requestNo']; ?>&uid=<?php echo $staffId; ?>" target="_blank"><?php echo $chkLeave['requestNo']; ?></a></td>
                                                                                                    <td><?php echo date('d/m/Y H:i:s',strtotime($chkLeave['dateFiled'])); ?></td>
                                                                                                    <td><?php echo $chkLeave['currentStatus']; ?></td>
                                                                                                <?php
                                                                                                $absent++;
                                                                                            } else {
                                                                                                ?>
                                                                                                    <td><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></td>
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
                                                                                                $onLeave++;
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
                                                                                                    <td><span class="bg-weekend">Holidays</span></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                <?php
                                                                                                $workingDays--;
                                                                                            } else {
                                                                                                ?>
                                                                                                    <td><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td><span class="bg-absent">Absent</span></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                <?php
                                                                                                $absent++;
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
                                                                                    <td><span class="bg-weekend"><?php echo date('d/m/Y - l',strtotime($newDateRanges[$i])); ?></span></td>
                                                                                    <td><?php echo substr($att['TimeIn'], 0, 8); ?></td>
                                                                                    <td><?php echo substr($att['TimeOut'], 0, 8); ?></td>
                                                                                    <td><?php echo $att['noOfHours']; ?></td>
                                                                                    <td><span class="bg-weekend">Weekend</span></td>
                                                                                    <td><span class="bg-overtime">Overtime</span></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            <?php
                                                                            $overTime++;
                                                                        } else {   
                                                                            ?>
                                                                                <tr>
                                                                                    <td><?php echo ++$j.'.'; ?></td>
                                                                                    <td><?php echo date('d/m/Y - l',strtotime($att['Date'])); ?></td>
                                                                                    <td><?php echo substr($att['TimeIn'], 0, 8); ?></td>
                                                                                    <td><?php echo substr($att['TimeOut'], 0, 8); ?></td>
                                                                                    <td><?php echo $att['noOfHours']; ?></td>
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
                                                                                                    $shortLeave++;
                                                                                                } else {
                                                                                                    ?>
                                                                                                        <td><span class="bg-missingtime">Missing Time</span></td>
                                                                                                        <td></td>
                                                                                                        <td></td>
                                                                                                        <td></td>
                                                                                                        <td></td>
                                                                                                    <?php
                                                                                                    $missingTime++;    
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
                                                                                                            $shortLeave++;    
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
                                                                                                                $present++;
                                                                                                            }
                                                                                                            
                                                                                                        }
                                                                                                    } else {
                                                                                                        $chkLeave2 = $qryCheckLeave2->singleReadFullQry("SELECT * FROM shortleave WHERE (leaveDate <= '$newDateRanges[$i]' AND leaveDate >= '$newDateRanges[$i]') AND staff_id = '$staffId'");
                                                                                                        //echo "SELECT * FROM shortleave WHERE (dateFile <= '$newDateRanges[$i]' AND dateFile >= '$newDateRanges[$i]') AND staff_id = '$staffId'";
                                                                                                        if($qryCheckLeave2->totalCount != 0) { //Under Time BUT there is a SHORT LEAVE FILED.
                                                                                                            $leaveRequestNo = $chkLeave2['requestNo'];
                                                                                                            ?>
                                                                                                                <td><span class="bg-onleave">On Short Leave</span></td>
                                                                                                                <td>Short Leave</td>
                                                                                                                <td><a href='#'><?php echo $leaveRequestNo; ?></a></td>
                                                                                                                <td><?php echo date('d/m/Y',strtotime($chkLeave2['leaveDate'])); ?></td>
                                                                                                                <td><?php echo $chkLeave2['currentStatus']; ?></td>
                                                                                                            <?php
                                                                                                            $shortLeave++;
                                                                                                        } else {
                                                                                                            ?>
                                                                                                                <td><span class="bg-undertime">Under Time</span></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                            <?php
                                                                                                            $underTime++;
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
                                                                                                    $present++;
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                </tr>
                                                                            <?php
                                                                        }    
                                                                    } //if $showAttendance    
                                                                } //for    
                                                            }
                                                        ?>
                                                    </tbody>                                                    
                                                </table>
                                                <input id="workingDaysCtr" type="hidden" value="<?php if(isset($workingDays)) echo $workingDays; ?>" />
                                                <input id="presentCtr" type="hidden" value="<?php if(isset($present)) echo $present; ?>" />
                                                <input id="underTimeCtr" type="hidden" value="<?php if(isset($underTime)) echo $underTime; ?>" />
                                                <input id="overTimeCtr" type="hidden" value="<?php if(isset($overTime)) echo $overTime; ?>" />
                                                <input id="absentCtr" type="hidden" value="<?php if(isset($absent)) echo $absent; ?>" />
                                                <input id="shortLeaveCtr" type="hidden" value="<?php if(isset($shortLeave)) echo $shortLeave; ?>" />
                                                <input id="onLeaveCtr" type="hidden" value="<?php if(isset($onLeave)) echo $onLeave; ?>" />
                                                <input id="missingTimeCtr" type="hidden" value="<?php if(isset($missingTime)) echo $missingTime; ?>" />
                                            </div><!--end table-responsive-->
                                        </div><!--end card body-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-6-->
                            </div><!--end row for search results-->
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
                <script>
                    $(document).ready(function() {
                        var workingDaysCtr = $('#workingDaysCtr').val();
                        $('.workingDaysCtr').html(workingDaysCtr);

                        var presentCtr = $('#presentCtr').val();
                        $('.presentCtr').html(presentCtr);

                        var underTimeCtr = $('#underTimeCtr').val();
                        $('.underTimeCtr').html(underTimeCtr);

                        var overTimeCtr = $('#overTimeCtr').val();
                        $('.overTimeCtr').html(overTimeCtr);

                        var absentCtr = $('#absentCtr').val();
                        $('.absentCtr').html(absentCtr);

                        var shortLeaveCtr = $('#shortLeaveCtr').val();
                        $('.shortLeaveCtr').html(shortLeaveCtr);

                        var onLeaveCtr = $('#onLeaveCtr').val();
                        $('.onLeaveCtr').html(onLeaveCtr);

                        var missingTimeCtr = $('#missingTimeCtr').val();
                        $('.missingTimeCtr').html(missingTimeCtr);
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