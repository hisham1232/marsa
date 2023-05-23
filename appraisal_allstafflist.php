<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead')) ? true : false;
        //$allowed =  true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){    
            $appraisalYear = $helper->getAppraisalYear('appraisal_year');   
            $dropdown = new DbaseManipulation;                              
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
                                    <h3 class="text-themecolor m-b-0 m-t-0"><i class="fas fa-diagnoses"></i> All Staff Appraisal List</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item"><a href="appraisal_homepage.php" title="Click to View Appraisal Homepage">Appraisal</a> </li>
                                        
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header bg-light-success  m-b-0 m-t-0 p-t-5 p-b-0">
                                            <h4 class="card-title font-weight-bold">Filter Record </h4>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row m-b-5 m-t-0">
                                                    <label class="col-md-3 col-form-label">Department</label>
                                                    <div class="col-md-8">
                                                        <div class="controls">
                                                            <select name="department_id[]" id="department_id" class="form-control">
                                                                <option value="0">Select Department</option>
                                                                <?php 
                                                                    $rows = $dropdown->readData("SELECT id, name FROM department WHERE active = 1 ORDER BY id");
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
                                                <div class="form-group row m-b-5 m-t-0">
                                                    <label class="col-md-3 col-form-label">Section</label>
                                                    <div class="col-md-8">
                                                        <div class="controls">
                                                            <select name="section_id[]" id="section_id" class="form-control" data-placeholder="Select Section">
                                                                <?php 
                                                                    $rows = $dropdown->readData("SELECT id, name FROM section WHERE active = 1 ORDER BY id");
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
                                                <div class="form-group row m-b-5 m-t-0">
                                                    <label class="col-md-3 col-form-label">Status</label>
                                                    <div class="col-md-8">
                                                        <div class="controls">
                                                            <select name="filterStatus" id="filterStatus" class="form-control" data-placeholder="Select Status">
                                                                <option value="Submitted by the Staff">Submitted by the Staff</option>
                                                                <option value="Submitted by the HOS">Submitted by the HOS</option>
                                                                <option value="Submitted by the HOD/HOC">Submitted by the HOD/HOC</option>
                                                                <option value="Approved by the Line Manager">Approved by the Line Manager</option>
                                                                <option value="Approved by the AD">Approved by the AD</option>
                                                                <option value="Approved by the Dean">Approved by the Dean</option>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                            <script type="text/javascript">
                                                                document.getElementById('filterStatus').value = "<?php echo $_POST['filterStatus'];?>";
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="offset-md-3 col-md-5">
                                                    <button class="btn btn-success waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header bg-light-success m-b-0 m-t-0 p-t-5 p-b-0">
                                            <h4 class="card-title font-weight-bold">Staff Appraisal Summary <span class="text-primary font-weight-bold">[Year <?php echo $appraisalYear; ?>] <small></small></span></h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="display nowrap table table-hover table-striped table-bordered">
                                                <?php 
                                                    $stf = $helper->singleReadFullQry("SELECT COUNT(id) as staffTotal FROM employmentdetail WHERE status_id = 1 AND isCurrent = 1");
                                                    $totalStaff = $stf['staffTotal'];
                                                    $submitted = 0; 
                                                    $ctrTech = $helper->singleReadFullQry("SELECT COUNT(id) as ctr1 FROM appraisal_technician WHERE appraisal_year = '$appraisalYear' AND status != 'Completed'");
                                                    $submitted = $submitted + $ctrTech['ctr1'];
                                                    $ctrLect = $helper->singleReadFullQry("SELECT COUNT(id) as ctr2 FROM appraisal_lecturer WHERE appraisal_year = '$appraisalYear' AND status != 'Completed'");
                                                    $submitted = $submitted + $ctrLect['ctr2'];
                                                    $ctrAdm = $helper->singleReadFullQry("SELECT COUNT(id) as ctr3 FROM appraisal_admin WHERE appraisal_year = '$appraisalYear' AND status != 'Completed'");
                                                    $submitted = $submitted + $ctrAdm['ctr3'];
                                                    $ctrHoS = $helper->singleReadFullQry("SELECT COUNT(id) as ctr4 FROM appraisal_hos WHERE appraisal_year = '$appraisalYear' AND status != 'Completed'");
                                                    $submitted = $submitted + $ctrHoS['ctr4'];
                                                    $ctrHoD = $helper->singleReadFullQry("SELECT COUNT(id) as ctr5 FROM appraisal_hod WHERE appraisal_year = '$appraisalYear' AND status != 'Completed'");
                                                    $submitted = $submitted + $ctrHoD['ctr5'];

                                                    $submittedCompleted = 0; 
                                                    $ctrTechCompleted = $helper->singleReadFullQry("SELECT COUNT(id) as ctr1 FROM appraisal_technician WHERE appraisal_year = '$appraisalYear' AND status = 'Completed'");
                                                    $submittedCompleted = $submittedCompleted + $ctrTechCompleted['ctr1'];
                                                    $ctrLectCompleted = $helper->singleReadFullQry("SELECT COUNT(id) as ctr2 FROM appraisal_lecturer WHERE appraisal_year = '$appraisalYear' AND status = 'Completed'");
                                                    $submittedCompleted = $submittedCompleted + $ctrLectCompleted['ctr2'];
                                                    $ctrAdmCompleted = $helper->singleReadFullQry("SELECT COUNT(id) as ctr3 FROM appraisal_admin WHERE appraisal_year = '$appraisalYear' AND status = 'Completed'");
                                                    $submittedCompleted = $submittedCompleted + $ctrAdmCompleted['ctr3'];
                                                    $ctrHoSCompleted = $helper->singleReadFullQry("SELECT COUNT(id) as ctr4 FROM appraisal_hos WHERE appraisal_year = '$appraisalYear' AND status = 'Completed'");
                                                    $submittedCompleted = $submittedCompleted + $ctrHoSCompleted['ctr4'];
                                                    $ctrHoDCompleted = $helper->singleReadFullQry("SELECT COUNT(id) as ctr5 FROM appraisal_hod WHERE appraisal_year = '$appraisalYear' AND status = 'Completed'");
                                                    $submittedCompleted = $submittedCompleted + $ctrHoDCompleted['ctr5'];

                                                    $notSubmitted = $totalStaff - $submitted - $submittedCompleted;
                                                    $lahat = $notSubmitted + $submitted + $submittedCompleted;
                                                ?>
                                                <thead>
                                                    <tr>
                                                        <th>Status Name</th>
                                                        <th>Number of Staff</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Not Submitted</td>
                                                        <td><?php echo $notSubmitted; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>On Process</td>
                                                        <td><?php echo $submitted; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Completed</td>
                                                        <td><?php echo $submittedCompleted; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td><?php echo $lahat; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------------------->
                            <!------------------------------------------------->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-success m-b-0 m-t-0 p-t-5 p-b-0" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title font-weight-bold">All Staff Appraisal List <span class="text-primary font-weight-bold">[Year <?php echo $appraisalYear; ?>]</span></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <?php 
                                                    $get = new DbaseManipulation;
                                                    $appraisalType = $get->getAppraisalType($staffId,'appraisal_type');
                                                    
                                                    $sqlAllTech = "SELECT ap.id, ap.staff_id, concat(st.firstName,' ',st.secondName,' ',st.thirdName,' ',st.lastName) as staffName, ap.appraisal_type, ap.status, d.shortName as department, s.shortName as section, t.name as app_type, atga.total FROM appraisal_technician as ap LEFT OUTER JOIN appraisal_technician_general_attribute as atga ON ap.id = atga.appraisal_technician_id LEFT OUTER JOIN appraisal_type_description as t ON ap.appraisal_type = t.id LEFT OUTER JOIN department as d ON ap.department_id = d.id LEFT OUTER JOIN section as s ON ap.section_id = s.id LEFT OUTER JOIN staff as st ON ap.staff_id = st.staffId WHERE ap.appraisal_year = '$appraisalYear' AND ";

                                                    $sqlAllLecturer = "SELECT ap.id, ap.staff_id, concat(st.firstName,' ',st.secondName,' ',st.thirdName,' ',st.lastName) as staffName, ap.appraisal_type, ap.status, d.shortName as department, s.shortName as section, t.name as app_type, atga.grand_total, alg.student_feedback, alg.class_visit, alg.development_activities, alg.hos_assessment, alg.hod_assessment, alg.total_mark FROM appraisal_lecturer as ap LEFT OUTER JOIN appraisal_lecturer_teaching_attribute as atga ON ap.id = atga.appraisal_lecturer_id LEFT OUTER JOIN appraisal_type_description as t ON ap.appraisal_type = t.id LEFT OUTER JOIN department as d ON ap.department_id = d.id LEFT OUTER JOIN section as s ON ap.section_id = s.id LEFT OUTER JOIN appraisal_lecturer_grading AS alg ON ap.id = alg.appraisal_lecturer_id LEFT OUTER JOIN staff as st ON ap.staff_id = st.staffId WHERE ap.appraisal_year = '$appraisalYear' AND ";
                                                    
                                                    $sqlAllAdmin = "SELECT ap.id, ap.staff_id, concat(st.firstName,' ',st.secondName,' ',st.thirdName,' ',st.lastName) as staffName, ap.appraisal_type, ap.status, d.shortName as department, s.shortName as section, t.name as app_type, atga.total FROM appraisal_admin as ap LEFT OUTER JOIN appraisal_admin_general_attribute as atga ON ap.id = atga.appraisal_admin_id LEFT OUTER JOIN appraisal_type_description as t ON ap.appraisal_type = t.id LEFT OUTER JOIN department as d ON ap.department_id = d.id LEFT OUTER JOIN section as s ON ap.section_id = s.id LEFT OUTER JOIN staff as st ON ap.staff_id = st.staffId WHERE ap.appraisal_year = '$appraisalYear' AND ";

                                                    
                                                    $sqlAllHoS = "SELECT ap.id, ap.staff_id, concat(st.firstName,' ',st.secondName,' ',st.thirdName,' ',st.lastName) as staffName, ap.appraisal_type, ap.status, d.shortName as department, s.shortName as section, t.name as app_type, atga.grand_total FROM appraisal_hos as ap LEFT OUTER JOIN appraisal_hos_working_attribute as atga ON ap.id = atga.appraisal_hos_id LEFT OUTER JOIN appraisal_type_description as t ON ap.appraisal_type = t.id LEFT OUTER JOIN department as d ON ap.department_id = d.id LEFT OUTER JOIN section as s ON ap.section_id = s.id LEFT OUTER JOIN staff as st ON ap.staff_id = st.staffId WHERE ap.appraisal_year = '$appraisalYear' AND ";
                                                    
                                                    $sqlAllHoD = "SELECT ap.id, ap.staff_id, concat(st.firstName,' ',st.secondName,' ',st.thirdName,' ',st.lastName) as staffName, ap.appraisal_type, ap.status, d.shortName as department, s.shortName as section, t.name as app_type, atga.grand_total FROM appraisal_hod as ap LEFT OUTER JOIN appraisal_hod_working_attribute as atga ON ap.id = atga.appraisal_hod_id LEFT OUTER JOIN appraisal_type_description as t ON ap.appraisal_type = t.id LEFT OUTER JOIN department as d ON ap.department_id = d.id LEFT OUTER JOIN section as s ON ap.section_id = s.id LEFT OUTER JOIN staff as st ON ap.staff_id = st.staffId WHERE ap.appraisal_year = '$appraisalYear' AND ";

                                                    if ($_POST['department_id'] == 0) {
                                                        $sqlAllTech .= "ap.department_id > 0";
                                                        $sqlAllLecturer .= "ap.department_id > 0";
                                                        $sqlAllAdmin .= "ap.department_id > 0";
                                                        $sqlAllHoS .= "ap.department_id > 0";
                                                        $sqlAllHoD .= "ap.department_id > 0";
                                                    } else {
                                                        $departmentIds = array();
                                                        foreach ($_POST['department_id'] as $selectedDepartmentIds) {
                                                            array_push($departmentIds,$selectedDepartmentIds);
                                                        }
                                                        $departmentIds = implode(', ', $departmentIds);
                                                        $sqlAllTech .= "ap.department_id IN (".$departmentIds.")";
                                                        $sqlAllLecturer .= "ap.department_id IN (".$departmentIds.")";
                                                        $sqlAllAdmin .= "ap.department_id IN (".$departmentIds.")";
                                                        $sqlAllHoS .= "ap.department_id IN (".$departmentIds.")";
                                                        $sqlAllHoD .= "ap.department_id IN (".$departmentIds.")";
                                                    }

                                                    if ($_POST['section_id'] != '') {
                                                        $sectionIds = array();
                                                        foreach ($_POST['section_id'] as $selectedSectionIds) {
                                                            array_push($sectionIds,$selectedSectionIds);
                                                        }
                                                        $sectionIds = implode(', ', $sectionIds);
                                                        $sqlAllTech .= " AND ap.section_id IN (".$sectionIds.")";
                                                        $sqlAllLecturer .= " AND ap.section_id IN (".$sectionIds.")";
                                                        $sqlAllAdmin .= " AND ap.section_id IN (".$sectionIds.")";
                                                        $sqlAllHoS .= " AND ap.section_id IN (".$sectionIds.")";
                                                        $sqlAllHoD .= " AND ap.section_id IN (".$sectionIds.")";
                                                    }

                                                    if ($_POST['filterStatus'] != '') {
                                                        $sqlAllTech .= " AND ap.status = '".$_POST['filterStatus']."'";
                                                        $sqlAllLecturer .= " AND ap.status = '".$_POST['filterStatus']."'";
                                                        $sqlAllAdmin .= " AND ap.status = '".$_POST['filterStatus']."'";
                                                        $sqlAllHoS .= " AND ap.status = '".$_POST['filterStatus']."'";
                                                        $sqlAllHoD .= " AND ap.status = '".$_POST['filterStatus']."'";
                                                    }
                                                ?>
                                                        <table id="dynamicTable" class="display nowrap table table-hover table-striped table-bordered">
                                                            <!-- This table needs to have the buttons, sorting, paging and searching -->
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">Name</th>
                                                                    <th rowspan="2">Department</th>
                                                                    <th rowspan="2">Section</th>
                                                                    <th rowspan="2">Type</th>
                                                                    <th rowspan="2">Status</th>
                                                                    <th rowspan="2">Attribute Mark</th>
                                                                    <th colspan="6">Grading Mark <span class="font-weight-italic">(for Lecturers only)</span></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Students <br>feedback</th>
                                                                    <th>Class Visit <br> by Peers</th>
                                                                    <th>Development <br> Activities </th>
                                                                    <th>HOS <br> Assessment</th>
                                                                    <th>HOD <br> Assessment</th>
                                                                    <th>Total <br> Mark</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    $rowsTech = $get->readData($sqlAllTech);
                                                                    foreach ($rowsTech as $rowTech) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="appraisal_technician_hod_view.php?id=<?php echo $rowTech['id']; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $rowTech['staffName']; ?></span></a>
                                                                            </td>
                                                                            <td><?php echo $rowTech['department']; ?></td>
                                                                            <td><?php echo $rowTech['section']; ?></td>
                                                                            <td><?php echo $rowTech['app_type']; ?></td>
                                                                            <td><?php echo $rowTech['status']; ?></td>
                                                                            <td><?php echo $rowTech['total']; ?></td>
                                                                            <td colspan="6"></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <?php 
                                                                    $rowsAdm = $get->readData($sqlAllAdmin);
                                                                    // echo"<pre>";
                                                                    // print_r($rowsAdm);
                                                                    // echo"</pre>";
                                                                    foreach ($rowsAdm as $rowAdm) {
                                                                        // if($rowAdm['department']== 'Deans Office' && $rowAdm['status']== 'Submitted by the Staff')
                                                                        // {
                                                                        //     $href='appraisal_adminstaff_hod_view.php';
                                                                        // }
                                                                        // else
                                                                        // {
                                                                            $href='appraisal_adminstaff_dean_view.php';
                                                                        // }
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="<?=$href?>?id=<?php echo $rowAdm['id']; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $rowAdm['staffName']; ?></span></a>
                                                                            </td>
                                                                            <td><?php echo $rowAdm['department']; ?></td>
                                                                            <td><?php echo $rowAdm['section']; ?></td>
                                                                            <td><?php echo $rowAdm['app_type']; ?></td>
                                                                            <td><?php echo $rowAdm['status']; ?></td>
                                                                            <td><?php echo $rowAdm['total']; ?></td>
                                                                            <td colspan="6"></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <?php 
                                                                    $rowsLect = $get->readData($sqlAllLecturer);
                                                                    foreach ($rowsLect as $rowLect) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="appraisal_lecturer_hod_view.php?id=<?php echo $rowLect['id']; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $rowLect['staffName']; ?></span></a>
                                                                            </td>
                                                                            <td><?php echo $rowLect['department']; ?></td>
                                                                            <td><?php echo $rowLect['section']; ?></td>
                                                                            <td><?php echo $rowLect['app_type']; ?></td>
                                                                            <td><?php echo $rowLect['status']; ?></td>
                                                                            <td><?php echo $rowLect['grand_total']; ?></td>
                                                                            <td><?php echo $rowLect['student_feedback']; ?></td>
                                                                            <td><?php echo $rowLect['class_visit']; ?></td>
                                                                            <td><?php echo $rowLect['development_activities']; ?></td>
                                                                            <td><?php echo $rowLect['hos_assessment']; ?></td>
                                                                            <td><?php echo $rowLect['hod_assessment']; ?></td>
                                                                            <td><?php echo $rowLect['total_mark']; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <?php 
                                                                    $rowsHoS = $get->readData($sqlAllHoS);
                                                                    foreach ($rowsHoS as $rowHoS) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="appraisal_hos_hod_view.php?id=<?php echo $rowHoS['id']; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $rowHoS['staffName']; ?></span></a>
                                                                            </td>
                                                                            <td><?php echo $rowHoS['department']; ?></td>
                                                                            <td><?php echo $rowHoS['section']; ?></td>
                                                                            <td><?php echo $rowHoS['app_type']; ?></td>
                                                                            <td><?php echo $rowHoS['status']; ?></td>
                                                                            <td><?php echo $rowHoS['grand_total']; ?></td>
                                                                            <td colspan="6"></td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <?php 
                                                                    $rowsHoD = $get->readData($sqlAllHoD);
                                                                    foreach ($rowsHoD as $rowHoD) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <a href="appraisal_hod_dean_view.php?id=<?php echo $rowHoD['id']; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $rowHoD['staffName']; ?></span></a>
                                                                            </td>
                                                                            <td><?php echo $rowHoD['department']; ?></td>
                                                                            <td><?php echo $rowHoD['section']; ?></td>
                                                                            <td><?php echo $rowHoD['app_type']; ?></td>
                                                                            <td><?php echo $rowHoD['status']; ?></td>
                                                                            <td><?php echo $rowHoD['grand_total']; ?></td>
                                                                            <td colspan="6"></td>
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