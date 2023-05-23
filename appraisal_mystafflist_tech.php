<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed =  true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){   
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
                                    <h3 class="text-themecolor m-b-0 m-t-0"><i class="fas fa-diagnoses"></i> My Staff Appraisal List</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                         <li class="breadcrumb-item"><a href="appraisal_homepage.php" title="Click to View Appraisal Homepage">Appraisal</a> </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <!------------------------------------------------->
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
                                                            <select name="department_id" class="form-control" required data-validation-required-message="Please select department">
                                                                <option value="">Select Department</option>
                                                                <?php 
                                                                    $rows = $dropdown->readData("SELECT id, name FROM department WHERE active = 1 ORDER BY id");
                                                                    foreach ($rows as $row) {
                                                                ?>
                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php            
                                                                    }    
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <div class="form-group row m-b-5 m-t-0">
                                                    <label class="col-md-3 col-form-label">Section</label>
                                                    <div class="col-md-8">
                                                        <div class="controls">
                                                            <select name="section_id" class="form-control">
                                                                <option value="0">Select Section</option>
                                                                <?php 
                                                                    $rows = $dropdown->readData("SELECT id, name FROM section WHERE active = 1 ORDER BY id");
                                                                    foreach ($rows as $row) {
                                                                ?>
                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                <?php            
                                                                    }    
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row m-b-5 m-t-0">
                                                    <label class="col-md-3 col-form-label">Status</label>
                                                    <div class="col-md-8">
                                                        <div class="controls">
                                                            <select class="form-control">
                                                                <option value="">Select Status</option>
                                                                <option value="0">Not Submitted</option>
                                                                <option value="Submitted by the Staff">Submitted by the Staff</option>
                                                                <option value="Approved by the Direct Manager">Approved by the Direct Manager</option>
                                                                <option value="Approved by the Line Manager">Approved by the Line Manager</option>
                                                                <option value="Approved by the AD">Approved by the AD</option>
                                                                <option value="Approved by the Dean">Approved by the Dean</option>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="offset-md-3 col-md-5">
                                                    <button class="btn btn-success waves-effect waves-light"  type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                     <div class="card">
                                        <div class="card-header bg-light-success m-b-0 m-t-0 p-t-5 p-b-0">
                                            <h4 class="card-title font-weight-bold">Staff Appraisal Summary <span class="text-primary font-weight-bold">[Year <?php echo $helper->getAppraisalYear('appraisal_year'); ?>]</span></h4>
                                        </div>
                                    <div class="card-body">
                                        <table class="display nowrap table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Status Name</th>
                                                    <th>Number of Staff</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Not Submitted</td>
                                                    <td>
                                                        <?php 

                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Submitted by the Staff</td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Completed</td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                            </div>                
                         
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                    	<div class="card-header bg-light-success" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title font-weight-bold">My Staff Appraisal List <span class="text-primary font-weight-bold">[Year <?php echo $helper->getAppraisalYear('appraisal_year') ?>]</span></h4>
                                        </div>
                                        <div class="card-body">                           
                                            <div class="table-responsive">
                                                <table id="example24" class="display nowrap table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">Name</th>
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
                                                            $appraisalType = $helper->getAppraisalType($staffId,'appraisal_type');
                                                            if($appraisalType == 4) {
                                                                $rowsTech = $helper->readData("SELECT at.id, at.requestNo, at.appraisal_type, at.staff_id, at.status, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, apd.name as appraisalType, sec.name as section FROM appraisal_technician as at LEFT OUTER JOIN section as sec ON sec.id = at.section_id LEFT OUTER JOIN appraisal_type_description as apd ON apd.id = at.appraisal_type LEFT OUTER JOIN staff as s ON at.staff_id = s.staffId WHERE at.section_id = $logged_in_section_id AND at.department_id = $logged_in_department_id"); //This is just for Technician
                                                            } else if ($appraisalType == 5) {
                                                                $rowsTech = $helper->readData("SELECT at.id, at.requestNo, at.appraisal_type, at.staff_id, at.status, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, apd.name as appraisalType, sec.name as section FROM appraisal_technician as at LEFT OUTER JOIN section as sec ON sec.id = at.section_id LEFT OUTER JOIN appraisal_type_description as apd ON apd.id = at.appraisal_type LEFT OUTER JOIN staff as s ON at.staff_id = s.staffId WHERE at.department_id = $logged_in_department_id"); //This is just for Technician
                                                                $rowsHoS = $helper->readData("SELECT at.id, at.requestNo, at.appraisal_type, at.staff_id, at.status, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, apd.name as appraisalType, sec.name as section FROM appraisal_hos as at LEFT OUTER JOIN section as sec ON sec.id = at.section_id LEFT OUTER JOIN appraisal_type_description as apd ON apd.id = at.appraisal_type LEFT OUTER JOIN staff as s ON at.staff_id = s.staffId WHERE at.department_id = $logged_in_department_id"); //This is just for HOS
                                                            }
                                                            foreach ($rowsTech as $row) { //For Technicians
                                                                if($row['appraisal_type'] == 1 && $appraisalType == 4)
                                                                    $link = 'appraisal_technician_hos_view.php?id='.$row['id'];
                                                                if($row['appraisal_type'] == 1 && $appraisalType == 5)
                                                                    $link = 'appraisal_technician_hod_view.php?id='.$row['id'];

                                                                if ($row['appraisal_type'] == 2)
                                                                    $link = 'appraisal_lecturer.php?id='.$row['id'];
                                                                if ($row['appraisal_type'] == 3)
                                                                    $link = 'appraisal_adminstaff.php?id='.$row['id'];
                                                                if ($row['appraisal_type'] == 4)
                                                                    $link = 'appraisal_hos.php?id='.$row['id'];
                                                                if ($row['appraisal_type'] == 5)
                                                                    $link = 'appraisal_hods.php?id='.$row['id'];
                                                                ?>
                                                                <tr>
                                                                    <td><a href="<?php echo $link; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $row['staffName']; ?></span></a></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['appraisalType']; ?></td>
                                                                    <td><?php echo $row['status'] ?></td>
                                                                    <td>...</td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            foreach ($rowsHoS as $row) { //For HoS
                                                                if($row['appraisal_type'] == 1 && $appraisalType == 4)
                                                                    $link = 'appraisal_technician_hos_view.php?id='.$row['id'];
                                                                if($row['appraisal_type'] == 1 && $appraisalType == 5)
                                                                    $link = 'appraisal_technician_hod_view.php?id='.$row['id'];

                                                                if ($row['appraisal_type'] == 2)
                                                                    $link = 'appraisal_lecturer.php?id='.$row['id'];
                                                                if ($row['appraisal_type'] == 3)
                                                                    $link = 'appraisal_adminstaff.php?id='.$row['id'];
                                                                if ($row['appraisal_type'] == 4)
                                                                    $link = 'appraisal_hos_hod_view.php?id='.$row['id'];
                                                                if ($row['appraisal_type'] == 5)
                                                                    $link = 'appraisal_hods.php?id='.$row['id'];
                                                                ?>
                                                                <tr>
                                                                    <td><a href="<?php echo $link; ?>" title="Click to View Appraisal Details"> <span class="text-primary font-weight-bold"><?php echo $row['staffName']; ?></span></a></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['appraisalType']; ?></td>
                                                                    <td><?php echo $row['status'] ?></td>
                                                                    <td>...</td>
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