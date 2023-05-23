<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0"><i class="fas fa-diagnoses"></i> List of Suggested Training</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item"><a href="appraisal_homepage.php" title="Click to View Appraisal Homepage">Appraisal</a> </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">                        
                                    <div class="card">
                                        <div class="card-header bg-light-success m-b-0 m-t-0 p-t-5 p-b-0" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title font-weight-bold">List of Suggested Training <span class="text-primary font-weight-bold">[<?php echo 'Year '.$helper->getAppraisalYear('appraisal_year'); ?>]</span></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display nowrap table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Apprisal Type</th>
                                                            <th>Title</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $appYear = $helper->getAppraisalYear('appraisal_year');
                                                            if($_GET['apptype'] == 5) {
                                                                $rows = $helper->readData("SELECT t.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sec.name as section, atd.name as appraisalTypeDesc FROM appraisal_trainings as t LEFT OUTER JOIN employmentdetail as e ON e.staff_id = t.staff_id LEFT OUTER JOIN staff as s ON s.staffId = t.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sec ON sec.id = e.section_id LEFT OUTER JOIN appraisal_type_description as atd ON atd.id = t.appraisal_type_description_id WHERE e.department_id = $logged_in_department_id AND appraisal_year = '$appYear'");
                                                            }
                                                            if($_GET['apptype'] == 4) {
                                                                $rows = $helper->readData("SELECT t.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sec.name as section, atd.name as appraisalTypeDesc FROM appraisal_trainings as t LEFT OUTER JOIN employmentdetail as e ON e.staff_id = t.staff_id LEFT OUTER JOIN staff as s ON s.staffId = t.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sec ON sec.id = e.section_id LEFT OUTER JOIN appraisal_type_description as atd ON atd.id = t.appraisal_type_description_id WHERE e.section_id = $logged_in_section_id AND appraisal_year = '$appYear'");
                                                            }
                                                            if($_GET['apptype'] == 0) { //All
                                                                $rows = $helper->readData("SELECT t.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sec.name as section, atd.name as appraisalTypeDesc FROM appraisal_trainings as t LEFT OUTER JOIN employmentdetail as e ON e.staff_id = t.staff_id LEFT OUTER JOIN staff as s ON s.staffId = t.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sec ON sec.id = e.section_id LEFT OUTER JOIN appraisal_type_description as atd ON atd.id = t.appraisal_type_description_id WHERE appraisal_year = '$appYear'");
                                                            }
                                                            foreach ($rows as $row) {
                                                                if($row['appraisal_type_description_id'] == 1)
                                                                    $linkInfo = 'appraisal_technician_hod_view.php?id='.$row['appraisal_type_id'];
                                                                if($row['appraisal_type_description_id'] == 2)
                                                                    $linkInfo = 'appraisal_lecturer_hod_view.php?id='.$row['appraisal_type_id'];
                                                                if($row['appraisal_type_description_id'] == 3)
                                                                    $linkInfo = 'appraisal_adminstaff_hod_view.php?id='.$row['appraisal_type_id'];
                                                                if($row['appraisal_type_description_id'] == 4)
                                                                    $linkInfo = 'appraisal_hos_hod_view.php?id='.$row['appraisal_type_id'];
                                                                if($row['appraisal_type_description_id'] == 5)
                                                                    $linkInfo = 'appraisal_hod_dean_view.php?id='.$row['appraisal_type_id'];
                                                                ?>
                                                                <tr>
                                                                    <?php 
                                                                        if($row['appraisal_type_description_id'] == 1 && $_GET['apptype'] == 5) {
                                                                            ?>
                                                                            <td><a href="appraisal_technician_hod_view.php?id=<?php echo $row['appraisal_type_id'] ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $row['staffName'] ?></span></a></td>
                                                                            <?php
                                                                        }
                                                                        if($row['appraisal_type_description_id'] == 1 && $_GET['apptype'] == 4) {
                                                                            ?>
                                                                            <td><a href="appraisal_technician_hos_view.php?id=<?php echo $row['appraisal_type_id'] ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $row['staffName'] ?></span></a></td>
                                                                            <?php
                                                                        }
                                                                        if($_GET['apptype'] == 0) {
                                                                            ?>
                                                                            <td><a href="<?php echo $linkInfo; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $row['staffName'] ?></span></a></td>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['appraisalTypeDesc']; ?></td>
                                                                    <td><?php echo $row['development_needed'] ?></td>
                                                                </tr>
                                                                <?php
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