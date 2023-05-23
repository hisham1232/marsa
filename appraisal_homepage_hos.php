<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HoS')) ? true : false;
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
                                                                            if($info->appraisalHOSStatus($row['appraisal_year'],$staffId,'status') == 'No data.') {
                                                                                ?>
                                                                                <td><a><span class="text-primary font-weight-bold"><?php echo $info->fieldNameValue('staff_position',$myPositionId,'code'); ?></span></a></td>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <td><a href="appraisal_hos.php?y=<?php echo $row['appraisal_year']; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $info->fieldNameValue('staff_position',$myPositionId,'code'); ?></span></a></td>
                                                                                <?php 
                                                                            }
                                                                        ?>        
                                                                        <td><?php echo $info->appraisalHOSStatus($row['appraisal_year'],$staffId,'status'); ?></td>
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
                                                                        <td><?php echo $bilang->getTotalAppraisalStaffSection($logged_in_department_id,$logged_in_section_id,'ctr'); ?></td>
                                                                        <td><?php echo $bilang->countSubmittedMyStaffAppraisalListHOSTechnician($logged_in_section_id,$row['appYear'],'submitted') + $bilang->countSubmittedMyStaffAppraisalListHOSLecturer($logged_in_section_id,$row['appYear'],'submitted'); ?></td>
                                                                        <td>
                                                                            <?php 
                                                                                echo $bilang->getTotalAppraisalStaffSection($logged_in_department_id,$logged_in_section_id,'ctr') - $bilang->countSubmittedMyStaffAppraisalListHOSTechnician($logged_in_section_id,$row['appYear'],'submitted') + $bilang->countSubmittedMyStaffAppraisalListHOSLecturer($logged_in_section_id,$row['appYear'],'submitted');
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $bilang->countMyStaffAppraisalListHOSTechnicianApproved($logged_in_section_id,$row['appYear'],'approved') + $bilang->countMyStaffAppraisalListHOSLecturerApproved($logged_in_section_id,$row['appYear'],'approved'); ?></td>
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