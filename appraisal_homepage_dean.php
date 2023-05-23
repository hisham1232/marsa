<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            ?>
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0"><i class="fas fa-diagnoses"></i> Staff Appraisal Modules</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Appraisal </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                         
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="card">
                                        <div class="card-header bg-light-success m-t-5 m-b-0 p-t-5 p-b-0" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title font-weight-bold">My Appraisal List</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="display nowrap table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $info = new DbaseManipulation;
                                                            $appraisalYearList = $helper->readData("SELECT * FROM appraisal_settings ORDER BY appraisal_year");
                                                            if($helper->totalCount != 0) {
                                                                foreach ($appraisalYearList as $row) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $row['appraisal_year']; ?></td>
                                                                        <?php
                                                                            if($info->appraisalHODStatus($row['appraisal_year'],$staffId,'status') == 'No data.') {
                                                                                ?>
                                                                                <td><a><span class="text-primary font-weight-bold"><?php echo $info->fieldNameValue('staff_position',$myPositionId,'code'); ?></span></a></td>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <td><a href="appraisal_hods.php?y=<?php echo $row['appraisal_year']; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $info->fieldNameValue('staff_position',$myPositionId,'code'); ?></span></a></td>
                                                                                <?php 
                                                                            }
                                                                        ?>
                                                                        <td><?php echo $info->appraisalHODStatus($row['appraisal_year'],$staffId,'status'); ?></td>
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
                                <!-- column -->
                                <div class="col-lg-7">
                                    <div class="card">
                                            <div class="card-header bg-light-success m-t-5 m-b-0 p-t-5 p-b-0" style="border-bottom: double; border-color: #28a745">
                                                <h4 class="card-title font-weight-bold">My Staff Appraisal List</h4>
                                            </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="display nowrap table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Total Staff</th>
                                                            <th>Submitted</th>
                                                            <th>NOT Submitted</th>
                                                            <th>My Approved</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $sqlAppYear = "SELECT DISTINCT(appraisal_year) as appYear FROM appraisal_settings";
                                                            $rows = $helper->readData($sqlAppYear);
                                                            if($helper->totalCount != 0) {
                                                                $bilang = new DbaseManipulation;
                                                                foreach ($rows as $row) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $row['appYear']; ?></td>
                                                                        <td><?php echo $bilang->getTotalAppraisalStaffAsstDean('IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)','ctr'); ?></td>
                                                                        <td>
                                                                            <?php echo 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_admin','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_lecturer','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_technician','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_hod','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_hos','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted');
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo 
                                                                                $bilang->getTotalAppraisalStaffAsstDean('IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)','ctr') - 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_admin','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') - 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_lecturer','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') - 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_technician','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') - 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_hod','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted') - 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_hos','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'submitted');
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_admin','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'approved') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_lecturer','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'approved') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_technician','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'approved') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_hod','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'approved') + 
                                                                                $bilang->countSubmittedMyStaffAppraisalListAsstDean('appraisal_hos','IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22)',$row['appYear'],'approved');
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-------------------------------->
                            <!-------------------------------->
                            <?php 
                                if($helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) { //HRD HOD and STAFF
                                    ?>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="card">
                                                <div class="card-header bg-light-success m-t-5 m-b-0 p-t-5 p-b-0" style="border-bottom: double; border-color: #28a745">
                                                    <h4 class="card-title font-weight-bold">Appraisal Settings</h4>
                                                </div>
                                                <div class="card-body">
                                                    <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                        <div class="form-group row m-b-5 m-t-0">
                                                            <label  class="col-sm-3 control-label">Year</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="appraisal_year" value="<?php echo date('Y'); ?>" class="form-control" > 
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                <i class="fas fa-edit"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row m-b-5 m-t-0">
                                                            <label  class="col-sm-3 control-label">Self Appraisal</label>
                                                            <div class="col-sm-9">
                                                                <div class='input-group mb-3'>
                                                                    <input type='text' class="form-control daterange" required data-validation-required-message="Please Select Self Appraisal Start and Date Date" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                                <span class="far fa-calendar-alt"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row m-b-5 m-t-0">
                                                            <label  class="col-sm-3 control-label">Manager Approval</label>
                                                            <div class="col-sm-9">
                                                                <div class='input-group mb-3'>
                                                                    <input type='text' class="form-control daterange" required data-validation-required-message="Please Select Start and End Date for HOS/HOD/HOC Approval" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                                <span class="far fa-calendar-alt"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row m-b-5 m-t-0">
                                                            <label  class="col-sm-3 control-label">AD/Dean Approval</label>
                                                            <div class="col-sm-9">
                                                                <div class='input-group mb-3'>
                                                                    <input type='text' class="form-control daterange" required data-validation-required-message="Please Select Start and End Date for AD/Dean Approval" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                                <span class="far fa-calendar-alt"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                
                                                        <div class="form-group row m-b-5 m-t-0">
                                                            <label  class="col-sm-3 control-label">Status</label>
                                                            <div class="col-sm-9">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select class="form-control" required data-validation-required-message="Please select Status">
                                                                            <option>Open</option>
                                                                            <option>Closed</option>
                                                                        </select>
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                <i class="fas fa-edit"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row m-b-0">
                                                            <div class="offset-sm-3 col-sm-9">
                                                                <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- column -->
                                        <div class="col-lg-7">                        
                                            <div class="card">
                                                <div class="card-header bg-light-success m-t-5 m-b-0 p-t-5 p-b-0" style="border-bottom: double; border-color: #28a745">
                                                    <h4 class="card-title font-weight-bold">Appraisal Settings List</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="display nowrap table table-hover table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Year</th>
                                                                    <th>Status</th>
                                                                    <th>List of All Staff Appraisal</th>
                                                                    <th>List of Suggested Training</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    $sqlAppYear = "SELECT DISTINCT(appraisal_year) as appYear, status FROM appraisal_settings";
                                                                    $rows = $helper->readData($sqlAppYear);
                                                                    if($helper->totalCount != 0) {
                                                                        $bilang = new DbaseManipulation;
                                                                        foreach ($rows as $row) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $row['appYear']; ?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        if ($row['status'] == 'CLOSED') {
                                                                                            ?>
                                                                                            <span class="badge badge-danger"><i class="fa fa-times"></i> CLOSED</span>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <span class="badge badge-success"><i class="fa fa-check"></i> OPEN</span>
                                                                                            <?php
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $bilang->countAppraisals('appraisal_technician',$row['appYear'],'total') + $bilang->countAppraisals('appraisal_lecturer',$row['appYear'],'total') + $bilang->countAppraisals('appraisal_admin',$row['appYear'],'total') + $bilang->countAppraisals('appraisal_hos',$row['appYear'],'total') + $bilang->countAppraisals('appraisal_hod',$row['appYear'],'total'); ?></td>
                                                                                <td><?php echo $bilang->countTrainings($row['appYear'],'total'); ?></td>
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
                                    <?php 
                                }
                            ?>        
                        </div>
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>  
                    <script>
                        // MAterial Date picker    
                        $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                        $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                        $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                        jQuery('#date-range').datepicker({
                            toggleActive: true
                        });
                        $('.daterange').daterangepicker();
                    </script>
                    <!--Morris JavaScript -->
                    <script src="assets/plugins/raphael/raphael-min.js"></script>
                    <script src="assets/plugins/morrisjs/morris.js"></script>
                    <script src="js/morris-data-bar-staff.js"></script>
                    <script src="assets/plugins/chartist-js/dist/chartist.min.js"></script>
                    <script src="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
                    
                    <!-- chartist chart -->
                    <script src="assets/plugins/chartist-js/dist/chartist.min.js"></script>
                    <script src="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
                    <script src="assets/plugins/chartist-js/dist/chartist-init.js"></script>
                    <script src="assets/plugins/d3/d3.min.js"></script>
                    <script src="assets/plugins/c3-master/c3.min.js"></script>
                
                    <script src="assets/plugins/knob/jquery.knob.js"></script>
                    <script>
                    $(function() {
                        $('[data-plugin="knob"]').knob();
                    });
                    </script>
                    <script src="js/dashboard2.js"></script>
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>