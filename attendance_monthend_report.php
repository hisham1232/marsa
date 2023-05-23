<?php    
    //include('include_headers.php');
    session_start(); 
    /*function __autoload($class){
        require_once "classes/$class.php";
    }*/
    require_once "classes/DbaseManipulation.php";
    //$con = mysqli_connect("localhost","p09a05","15935789","dbhr3_test") or die("Cannot connect to remote server!");
    $helper = new DbaseManipulation;
    $SQLActiveStaff = "SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, e.status_id, e.isCurrent FROM staff as s LEFT OUTER JOIN employmentdetail as e ON e.staff_id = s.staffId WHERE e.status_id = 1 AND e.isCurrent = 1 ORDER BY s.firstName"; 
    $staffId = $_SESSION['username'];
    $user_type = $_SESSION['user_type'];
    $primary_staff_id = $helper->staff_primary_id($staffId,'id');
    $logged_name = $helper->getStaffName($staffId,'firstName','secondName','thirdName','lastName');
    $logged_in_email = $helper->getContactInfo(2,$staffId,'data');
    $logged_in_gsm = $helper->getContactInfo(1,$staffId,'data');
    $logged_in_department_id = $helper->employmentIDs($staffId,'department_id');
    $logged_in_section_id = $helper->employmentIDs($staffId,'section_id');
    $logged_in_sponsor_id = $helper->employmentIDs($staffId,'sponsor_id');
    $myPositionId = $helper->employmentIDs($staffId,'position_id');
    //echo $myPositionId; exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <?php 
        if(isset($_POST['searchByDate'])){
            $sponsor_id = $helper->cleanString($_POST['sponsor_id']);
            $sponsorName = $helper->fieldNameValue("sponsor",$sponsor_id,'name');
            $simula = date('d/m/Y',strtotime($helper->cleanString($_POST['startDate'])));
            $tapos = date('d/m/Y',strtotime($helper->cleanString($_POST['endDate'])));
            $titleHead = "NCT - Attendance Month End Report - $sponsorName - (From $simula To $tapos)";
        } else {
            $titleHead = "NCT - Attendance Month End Report";
        }
    ?>

    <title><?php echo $titleHead; ?></title>
    <link href="assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/colors/megna.css" id="theme" rel="stylesheet">
    <link href="css/demo_backtotop.css" rel="stylesheet">
    <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">

    <link href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <link href="assets/plugins/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <link href="assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="assets/plugins/select2/dist/css/select2.css" rel="stylesheet" type="text/css" />

    <link href="assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />

    <!--Charts-->
    <link href="assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <link href="assets/plugins/c3-master/c3.min.css" rel="stylesheet">

    <!-- fullCalendar -->
    <link rel="stylesheet" href="fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
</head>
<?php
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed =  true;
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
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Attendance Monthend Report</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Attendance </li>
                                        <li class="breadcrumb-item">Monthend Report </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <form action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Sponsor Here</label>
                                                    <div class="col-sm-8">
                                                        <select name="sponsor_id" class="form-control select2">
                                                            <?php 
                                                                $sponsors = new DbaseManipulation;
                                                                $rows = $sponsors->readData("SELECT * FROM sponsor WHERE active = 1");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                            </div>
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
                                        <small>Select sponsor from the list, starting and ending date in the date range picker and then click on Search Button.</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!--for result-->
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Search Result</h4>
                                            <div class="row">
                                                <?php
                                                    if(isset($_POST['searchByDate'])){
                                                        $sponsor_id = $helper->cleanString($_POST['sponsor_id']);
                                                        $startDate =  $helper->cleanString($_POST['startDate']);
                                                        $endDate = $helper->cleanString($_POST['endDate']);
                                                        $searched = true;
                                                    } else {
                                                        $searched = false;
                                                    }
                                                    if(!$searched) {
                                                ?>                
                                                        <div class="col-md-4">
                                                            <p class="m-b-0">Sponsor: <span class="text-primary">-</span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Start Date: <span class="text-primary">-</span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">End Date: <span class="text-primary">-</span></p>
                                                        </div>
                                                <?php
                                                    } else {
                                                        ?>
                                                            <div class="col-md-4">
                                                                <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $helper->fieldNameValue("sponsor",$sponsor_id,"name"); ?></span></p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <p class="m-b-0">Start Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($startDate)); ?></span></p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <p class="m-b-0">End Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($endDate)); ?></span></p>
                                                            </div>
                                                        <?php
                                                    }
                                                ?>        
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Staff Name</th>
                                                            <th>Position</th>
                                                            <th>Job Title</th>
                                                            <th>Leave Type</th>
                                                            <th>Absent</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(isset($_POST['searchByDate'])){
                                                                $staffs = new DbaseManipulation;
                                                                $rows = $staffs->readData("SELECT e.staff_id, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, p.name as position, j.name as jobtitle FROM employmentdetail as e LEFT OUTER JOIN staff as s ON s.staffId = e.staff_id LEFT OUTER JOIN position_category as p on p.id = e.position_category_id LEFT OUTER JOIN jobtitle as j on j.id = e.jobtitle_id WHERE e.status_id = 1 AND e.isCurrent = 1 AND e.sponsor_id = $sponsor_id");
                                                                if($staffs->totalCount != 0) {
                                                                    $noCtr = 0;
                                                                    $typeOfLeave = array();
                                                                    $dateOfAbsent = array();
                                                                    $qryCheckLeave = new DbaseManipulation;
                                                                    $qryCheckLeave2 = new DbaseManipulation;
                                                                    $showAttendance = new DbaseManipulation;
                                                                    $qryHoliday = new DbaseManipulation;
                                                                    foreach($rows as $row){
                                                                        $staff_id = $row['staff_id'];
                                                                        if($startDate != '' && $endDate != '') {
                                                                            $newDateRanges = $helper->createDateRangeArray($startDate,$endDate);
                                                                        } else if ($startDate != '' && $endDate == '') {
                                                                            $newDateRanges = $helper->createDateRangeArray($startDate,date("Y-m-d"));	
                                                                        } else {
                                                                            $newDateRanges = $helper->createDateRangeArray(date("Y-m-d"),date("Y-m-d"));  
                                                                        }
                                                                        $ctr = count($newDateRanges);
                                                                        $j = 0; $timeIn = ""; $timeOut = ""; $noOfHours = "";
                    
                                                                        $noOfDays = $ctr;
                                                                        $noOfAbsent = 0;
                                                                        for($i=$ctr-1; $i>=0; $i--){
                                                                            $showAttendance->singleReadFullQry("SELECT * FROM v_attendance WHERE StaffId = '$staff_id' AND Date >= '$newDateRanges[$i]' AND Date <= '$newDateRanges[$i]'");
                                                                            if($showAttendance->totalCount < 1){ //Walang login at log out si staff
                                                                                $sql = "SELECT s.id, s.requestNo, s.leavetype_id, l.name as leavetype, s.dateFiled, s.currentStatus, s.startDate, s.endDate FROM standardleave AS s LEFT OUTER JOIN leavetype as l ON l.id = s.leavetype_id WHERE (s.startDate <= '$newDateRanges[$i]' AND s.endDate >= '$newDateRanges[$i]') AND s.staff_id = '$staff_id' AND s.currentStatus NOT IN ('Declined','Cancelled')";
                                                                                $chkLeave = $qryCheckLeave->singleReadFullQry($sql);
                                                                                if($qryCheckLeave->totalCount != 0) { //No Attendance BUT there is a LEAVE FILED.
                                                                                    if($chkLeave['currentStatus'] == 'Cancelled' || $chkLeave['currentStatus'] == 'Declined') {
                                                                                        if (date("w",strtotime($newDateRanges[$i])) == 5) {
                                                                                            $noOfDays = $noOfDays;
                                                                                        }
                                                                                        else if (date("w",strtotime($newDateRanges[$i])) == 6) {
                                                                                            $noOfDays = $noOfDays;
                                                                                        } else {
                                                                                            $noOfDays = $noOfDays - 1;
                                                                                            $noOfAbsent = $noOfAbsent + 1;
                                                                                            array_push($dateOfAbsent, date('d',strtotime($newDateRanges[$i])).'/'.date('m',strtotime($newDateRanges[$i])).'/'.date('y',strtotime($newDateRanges[$i]))." - ");
                                                                                        }
                                                                                    } else {
                                                                                        if (date("w",strtotime($newDateRanges[$i])) >= 5 && date("w",strtotime($newDateRanges[$i])) <= 6) {
                                                                                        } else {
                                                                                            $leaveTypeId = $chkLeave['leavetype_id'];
                                                                                            array_push($typeOfLeave, $chkLeave['leavetype'].', '.date('d',strtotime($newDateRanges[$i])).'/'.date('m',strtotime($newDateRanges[$i])).'/'.date('y',strtotime($newDateRanges[$i]))." - ");
                                                                                            $noOfDays = $noOfDays;
                                                                                        }
                                                                                        if($chkLeave['leavetype_id'] == 3){
                                                                                            $noOfDays = $noOfDays - 1;
                                                                                            $noOfAbsent = $noOfAbsent + 1;
                                                                                            array_push($dateOfAbsent, date('d',strtotime($newDateRanges[$i])).'/'.date('m',strtotime($newDateRanges[$i])).'/'.date('y',strtotime($newDateRanges[$i]))." - ");
                                                                                        }
                                                                                    }		
                                                                                } else { //No Attendance AND no LEAVE FILED ALSO
                                                                                    $rowHoliday = $qryHoliday->singleReadFullQry("SELECT * FROM holiday WHERE (startDate <= '$newDateRanges[$i]' AND endDate >= '$newDateRanges[$i]')");
																					//Check if the date is Holiday Here
																					if($qryHoliday->totalCount < 1) {
																						if (date("w",strtotime($newDateRanges[$i])) == 5) {															
																							$noOfDays = $noOfDays;
																						}
																						else if (date("w",strtotime($newDateRanges[$i])) == 6) {
																							$noOfDays = $noOfDays;
																						} else {
																							$noOfDays = $noOfDays - 1;
																							$noOfAbsent = $noOfAbsent + 1;
																							array_push($dateOfAbsent, date('d',strtotime($newDateRanges[$i])).'/'.date('m',strtotime($newDateRanges[$i])).'/'.date('y',strtotime($newDateRanges[$i]))." - ");
																						}
																					} else {
																						$isRamadan = $rowHoliday['isRamadan'];
																						if($qryHoliday->totalCount != 0 && $isRamadan != 1){ //Holiday at hindi naman Ramadan
																							$noOfDays = $noOfDays;
																						} else { //Hindi Holiday at wala syang login at logout
																							if (date("w",strtotime($newDateRanges[$i])) == 5) {
																								$noOfDays = $noOfDays;
																							}
																							else if (date("w",strtotime($newDateRanges[$i])) == 6) {
																								$noOfDays = $noOfDays;
																							} else {
																								$noOfDays = $noOfDays - 1;
																								$noOfAbsent = $noOfAbsent + 1;
																								array_push($dateOfAbsent, date('d',strtotime($newDateRanges[$i])).'/'.date('m',strtotime($newDateRanges[$i])).'/'.date('y',strtotime($newDateRanges[$i]))." - ");
																							}
																						}
																					}
                                                                                }
                                                                            }    
                                                                        }
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo ++$noCtr.'.'; ?></td>
                                                                                <td><?php echo $row['staffName']; ?></td>
                                                                                <td><?php echo $row['position']; ?></td>
                                                                                <td><?php echo $row['jobtitle']; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                        foreach($typeOfLeave as $value){
                                                                                            echo $value."<br />";
                                                                                        } 
                                                                                        //print_r($typeOfLeave);    
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php 
                                                                                        //echo $noOfAbsent;
                                                                                        if($noOfAbsent < 1) {
                                                                                            echo "NONE";
                                                                                        } else {
                                                                                            echo "(".$noOfAbsent." Days)<br/>";
                                                                                            foreach($dateOfAbsent as $val){
                                                                                                echo $val."<br />";
                                                                                            }
                                                                                        }																		//}
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $noOfDays.' days'; ?></td>
                                                                            </tr>
                                                                        <?php 
                                                                        unset($typeOfLeave);
                                                                        $typeOfLeave = array();
                                                                        
                                                                        unset($dateOfAbsent);
                                                                        $dateOfAbsent = array();   
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
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>