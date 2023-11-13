<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('Approver')) ? true : false;
        $allowed =  true; //Validate this that only a staff can view his own view
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            ?>  
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <div class="preloader">
                    <!-- <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg> -->
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Appraisal - Lecturer</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                         <li class="breadcrumb-item"><a href="appraisal_homepage.php" title="Click to View Appraisal Homepage">Appraisal</a> </li>
                                        <li class="breadcrumb-item">Staff Appraisal</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <?php 
                                            $checkSubmitted =  new DbaseManipulation;
                                            $currentYear = $_GET['y'];
                                            $id = $_GET['id'];
                                            $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_lecturer WHERE id = $id AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                            if($checkSubmitted->totalCount != 0) {
                                                $staffStats = 'Submitted ['.date('d/m/Y',strtotime($rec['date_submitted'])).']';
                                                $requestNo = $rec['requestNo'];
                                                $staff_id = $rec['staff_id'];
                                            } else {
                                                $staffStats = 'Not Started';
                                                $request = new DbaseManipulation;
                                                $requestNo = $request->requestNo("TAP-","appraisal_lecturer");
                                            }

                                            $staff_position_id = $info['position_id'];
                                        ?>
                                        <?php
                                            $basic_info = new DBaseManipulation;
                                            $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, s.joinDate, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.position_id, nat.name as nationality FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as nat ON nat.id = s.nationality_id WHERE s.staffId = '$staff_id'");
                                        ?>
                                        <div class="card-header bg-light-success" style="border-bottom: double; border-color: #28a745">
                                            <div class="d-flex no-block align-items-center">
                                                <h4 class="card-title font-weight-bold">Staff Appraisal Form - Lecturer [<?php echo $currentYear; ?>]</h4>
                                                <div class="ml-auto">
                                                    <ul class="list-inline text-right">
                                                        
                                                        <li>ID/Status  <span class="font-weight-bold text-info"><?php echo $requestNo; ?> - <?php echo $rec['status']; ?></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-2">Name</div>
                                                        <div class="col-md-10"> <span class="font-weight-bold text-info"><?php echo trim($info['staffName']); ?> </span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Section</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"> <?php echo $info['section']; ?> </span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Dept.</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"><?php echo $info['department']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Job Title</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"><?php echo $info['jobtitle']; ?></span></div>
                                                    </div><!--end row-->
                                                </div><!--end col staff-->

                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-4">Gender</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['gender']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-4">Nationality</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['nationality']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-4">Sponsor</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['sponsor']; ?></span></div>
                                                    </div><!--end row-->
                                                     <div class="row">
                                                        <div class="col-md-4">Join Date</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></div>
                                                    </div><!--end row-->
                                                </div><!--end col -->

                                                <div class="col-md-5">
                                                    <?php 
                                                        $checkSubmitted =  new DbaseManipulation;
                                                        $currentYear = $_GET['y'];
                                                        $id = $_GET['id'];
                                                        $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_lecturer WHERE id = $id AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                                        $stfId = $rec['position_id'];
                                                        if($checkSubmitted->totalCount != 0) {
                                                            $staffStats = 'Submitted ['.date('d/m/Y',strtotime($rec['date_submitted'])).']';
                                                        } else {
                                                            $staffStats = 'Not Started';
                                                        }
                                                         $staff_position_id = $info['position_id'];
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-2">Staff</div>
                                                        <div class="col-md-6"><?php echo trim($info['staffName']); ?></div>

                                                        <div class="col-md-4"><span class="font-weight-bold text-info"><?php echo $staffStats; ?> </span></div>
                                                    </div><!--end row-->
                                                    <?php 
                                                        $approval = new DbaseManipulation;
                                                        $approvers = $approval->readData("SELECT s.*, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as approverName, p.code as approverTitle FROM  appraisal_approval_sequence as s LEFT OUTER JOIN staff_position as p ON p.id = s.approver_id LEFT OUTER JOIN employmentdetail as e ON e.position_id = s.approver_id LEFT OUTER JOIN staff as ss ON e.staff_id = ss.staffId WHERE s.position_id = $staff_position_id AND e.isCurrent = 1 and e.status_id = 1 ORDER BY s.sequence_no");
                                                        if($approval->totalCount != 0) {
                                                            if($rec['current_sequence'] == 3) { //Already in the last approver
                                                                foreach ($approvers as $row) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                        <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                        <?php 
                                                                            if($row['sequence_no'] == 1) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate('appraisal_hos_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 2) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate2('appraisal_hod_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 3) {
                                                                                if($rec['status'] == 'Completed') {
                                                                                    ?>
                                                                                    <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate2('appraisal_dean_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        
                                                                    </div>
                                                                    <?php
                                                                }        
                                                            } else if($rec['current_sequence'] == 2) { //2nd Approver
                                                                foreach ($approvers as $row) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                        <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                        <?php 
                                                                            if($row['sequence_no'] == 1) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate('appraisal_hos_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 2) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 3) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Pending</span></div>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        
                                                                    </div>
                                                                    <?php
                                                                }        
                                                            } else if($rec['current_sequence'] == 1) { //1st Approver
                                                                foreach ($approvers as $row) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                        <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                        <?php 
                                                                            if($row['sequence_no'] == 1) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 2) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Pending</span></div>
                                                                                <?php
                                                                            } else if($row['sequence_no'] == 3) {
                                                                                ?>
                                                                                <div class="col-md-4"><span class="font-weight-bold text-info">Pending</span></div>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                        
                                                                    </div>
                                                                    <?php
                                                                }        
                                                            }
                                                        }
                                                    ?>
                                                </div><!--end col status-->
                                            </div><!--end row-->
                                        </div><!--end card header-->
                                        <div class="card-body">
                                            <ul class="nav nav-tabs customtab2" role="tablist">
                                               <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Qualification" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Qualification</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#SelfAppraisal" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Self Appraisal</span></a> </li>
                                                
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Attribute" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Attributes</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Grading" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Grading</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Development" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down"></span>Staff Development Needed</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Observation" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">HOS Observation</span></a> </li>

                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Approval" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Approval</span></a> </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane p-20 active" id="Qualification" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4 class="card-title">Staff Qualification List</h4>
                                                        </div>    
                                                        <div class="card-body">
                                                            <div class="table-responsiveXXX">
                                                                <table class="display nowrap table table-hover table-striped table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Degree</th>
                                                                            <th>Qualification Name</th>
                                                                            <th>University/Country</th>
                                                                            <th>Year</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $qua = new DBaseManipulation;
                                                                            $rows = $qua->readData("SELECT sq.*, d.name as degree, c.name as certification FROM staffqualification as sq LEFT OUTER JOIN degree as d ON d.id = sq.degree_id LEFT OUTER JOIN certificate as c ON c.id = sq.certificate_id WHERE staffId = '$staff_id'");
                                                                            if($qua->totalCount != 0) {
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>1</td>
                                                                                        <td><span class="text-primary font-weight-bold"><?php echo $row['degree']; ?></span></td>
                                                                                        <td><?php echo $row['certification']; ?></td>
                                                                                        <td><?php echo $row['institution']; ?></td>
                                                                                        <td><?php echo $row['graduateYear']; ?></td>
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
                                                <!------------------------------------->
                                                <!------------------------------------->
                                                <div class="tab-pane p-20" id="SelfAppraisal" role="tabpanel">
                                                    <?php 
                                                        if($checkSubmitted->totalCount != 0) {
                                                            ?>
                                                            <form novalidate>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Job Definition</h4></div>
                                                                        <div class="card-body">
                                                                            <div class="form-group">
                                                                                <h5>1. Describe your duties and responsibilities. <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea class="textarea_job1 form-control" rows="3" readonly><?php echo $rec['jd1']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <h5>2. Which responsibility from those in #1 do you think is most important and why? <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea class="textarea_job2 form-control" rows="3" readonly><?php echo $rec['jd2']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <h5>3. Specify what you consider in order to achieve your job requirements. <span class="text-danger">*</span></h5>
                                                                                <div class="controls">
                                                                                    <textarea class="textarea_job3 form-control" rows="3" readonly><?php echo $rec['jd3']; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>                                        
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Accomplishments</h4></div>
                                                                    <div class="card-body">                                                
                                                                        <div class="form-group">
                                                                            <h5>1. What actions have you taken this year in order to gain a better understanding of the organization, your department, or your own job? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment1 form-control" rows="3" readonly><?php echo $rec['acc1']; ?></textarea>
                                                                            </div>                                                    
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>2. In your view, what is your contribution to the organization in order to achieve its goals and objectives? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment2 form-control" rows="3" readonly><?php echo $rec['acc2']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>Have you performed any new tasks or additional duties outside the scope of your regular responsibilities? If so, please specify. <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment3 form-control" rows="3" readonly><?php echo $rec['acc3']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>Describe any staff development activities that have been helpful to you. <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment4 form-control" rows="3" readonly><?php echo $rec['acc4']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Goal Setting</h4></div>
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <h5>1. In what specific areas would you like to improve your job performance? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_goal1 form-control" rows="3" readonly><?php echo $rec['gs1']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>2. What kind of support and/or guidance would you like to see from your supervisor? <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_goal2 form-control" rows="3" readonly><?php echo $rec['gs2']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end card body Goal Setting-->
                                                                </div>
                                                            </form>
                                                            <?php
                                                        }
                                                    ?>        
                                                </div>
                                                <!------------------------------------->
                                                <!------------------------------------->
                                                <div class="tab-pane p-20" id="Attribute" role="tabpanel">
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_lecturer_id = $_GET['id'];
                                                            $genAtt = new DbaseManipulation;
                                                            $row = $genAtt->singleReadFullQry("SELECT * FROM appraisal_lecturer_general_attribute WHERE appraisal_lecturer_id = $appraisal_lecturer_id");
                                                            if($genAtt->totalCount != 0) {
                                                                $tobeVisible = '';
                                                            } else {
                                                                $tobeVisible = '[To be filled by the HOS]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4>General Attribute <i><?php echo $tobeVisible; ?></i></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if($genAtt->totalCount != 0) {
                                                                    function score_value($score){
                                                                        if($score == 1)
                                                                            return 'Weak';
                                                                        else if($score == 2)
                                                                            return 'Fair';
                                                                        else if($score == 3)
                                                                            return 'Good';
                                                                        else if($score == 4)
                                                                            return 'Very Good';
                                                                        else if($score == 5)
                                                                            return 'Excellent';
                                                                    }
                                                                    ?>
                                                                    <form novalidate>
                                                                        <div class="demo-radio-button">
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18">Dress code and appearance</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q1']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div>
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Accepts advice and instructions</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q2']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q2-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Relationship with other staff</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q3']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q3-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Relationship with HoS and HoD</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q4']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q4-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Relationship with students</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q5']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q5-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Strength in teaching the class</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q6']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q6-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Class control</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q7']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q7-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Willingness to improve teaching methods</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q8']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q8-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Participation in departmental/college activities</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q9']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q9-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Willingness for growth or progress</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q10']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q10-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Total/Remark</h3></div>
                                                                                <div class="col-lg-5">
                                                                                    <label><h3><span id="totalScore"><?php echo $row['total'] ?></span> - <span id="totalRemarks"><?php echo $row['remarks']; ?></span></h3></label>
                                                                                </div>
                                                                            </div><!--end row total-->
                                                                        </div><!--end demo-radio-button-->
                                                                    </form>
                                                                    <?php
                                                                }
                                                            ?>        
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_lecturer_id = $_GET['id'];
                                                            $teachAtt = new DbaseManipulation;
                                                            $row = $teachAtt->singleReadFullQry("SELECT * FROM appraisal_lecturer_teaching_attribute WHERE appraisal_lecturer_id = $appraisal_lecturer_id");
                                                            if($teachAtt->totalCount != 0) {
                                                                $tobeVisible = '';
                                                            } else {
                                                                $tobeVisible = '[To be filled by the HOS]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4>Teaching Attribute <i><?php echo $tobeVisible; ?></i></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if($teachAtt->totalCount != 0) {
                                                                    function score_value2($score){
                                                                        if($score == 1)
                                                                            return 'Weak';
                                                                        else if($score == 2)
                                                                            return 'Fair';
                                                                        else if($score == 3)
                                                                            return 'Good';
                                                                        else if($score == 4)
                                                                            return 'Very Good';
                                                                        else if($score == 5)
                                                                            return 'Excellent';
                                                                    }
                                                                    ?>
                                                                    <form novalidate>
                                                                        <div class="demo-radio-button">
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18">Dress code and appearance</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q11']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div>
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Accepts advice and instructions</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q12']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q2-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Relationship with other staff</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q13']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q3-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Relationship with HoS and HoD</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q14']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q4-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Relationship with students</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q15']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q5-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Strength in teaching the class</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q16']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q6-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Class control</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q17']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q7-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Willingness to improve teaching methods</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q18']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q8-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Participation in departmental/college activities</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q19']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q9-->
                                                                            <div class="row border-bottom m-t-5" style="display: none">
                                                                                <div class="col-lg-5 col-xs-18">Willingness for growth or progress</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q20']) {
                                                                                            $haydi = 'job_q'.$a;
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" checked />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <div class="<?php echo $col_class; ?> col-xs-18">
                                                                                                <input type="radio" id="<?php echo $haydi; ?>" class="with-gap radio-col-indigo" />
                                                                                                <label for="<?php echo $haydi; ?>"><?php echo score_value2($a); ?></label>
                                                                                            </div>
                                                                                            <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                            </div><!--end row q10-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Total/Remark</h3></div>
                                                                                <div class="col-lg-5">
                                                                                    <label><h3><span id="totalScoreX"><?php echo $row['total'] ?></span> - <span id="totalRemarksX"><?php echo $row['remarks']; ?></span></h3></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18"><h3>GrandTotal/Remark</h3></div>
                                                                                <div class="col-lg-5">
                                                                                    <label><h3><span id="grandTotalX"><?php echo $row['grand_total'] ?></span> - <span id="grandRemarksX"><?php echo $row['grand_remarks']; ?></span></h3></label>
                                                                                </div>
                                                                            </div><!--end row total-->
                                                                        </div>
                                                                    </form>
                                                                    <?php
                                                                }
                                                            ?>        
                                                        </div>
                                                    </div>
                                                </div>
                                                <!------------------------------------->
                                                <!------------------------------------->
                                                <div class="tab-pane p-20" id="Grading" role="tabpanel">
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_lecturer_id = $_GET['id'];
                                                            $grading = new DbaseManipulation;
                                                            $row = $grading->singleReadFullQry("SELECT * FROM appraisal_lecturer_grading WHERE appraisal_lecturer_id = $appraisal_lecturer_id");
                                                            if($grading->totalCount != 0) {
                                                                $tobeVisible4 = '';
                                                            } else {
                                                                $tobeVisible4 = '[To be filled by the HOS and HOD]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4 class="card-title font-weight-bold">Grading criteria for Academic Staff <i><?php echo $tobeVisible4; ?></i></h4>
                                                            <h6 class="card-subtitle">Academic Staff will be assessed according to the following criteria:</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if($grading->totalCount != 0) {
                                                                    ?>
                                                                    <form class="form-horizontal" novalidate>
                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label class="col-sm-4 control-label"><span class="text-danger">*</span>Students feedback 30%</label>
                                                                            <div class="col-sm-3">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="student_feedback" value="<?php echo $row['student_feedback']; ?>" class="form-control" readonly>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)" title="Info about Grading"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            - Enter 0-30 points only <br>
                                                                                                            - Average of two feedbacks / 5 x 30% <br>
                                                                                                            - To be filled by HOS 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-control-feedback">To be filled by HOS </div> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label  class="col-sm-4 control-label"><span class="text-danger">*</span>Class Visit by Peers 20%</label>
                                                                            <div class="col-sm-3">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="class_visit" value="<?php echo $row['class_visit']; ?>" class="form-control" readonly>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)" title="Info about Grading"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            - Enter 0-20 points only <br>
                                                                                                            - 2 Staff to visit every Lecturer <br>
                                                                                                            - Calculation Average Score x 20% <br>
                                                                                                            - To be filled by HOS 
                                                                                                            </span>
                                                                                                             (Enter 0-20 points only)
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-control-feedback">To be filled by HOS </div> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label  class="col-sm-4 control-label"><span class="text-danger">*</span>Development Activities 20% </label>
                                                                            <div class="col-sm-3">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="development_activities" value="<?php echo $row['development_activities']; ?>" class="form-control" readonly>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)" title="Info about Grading"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            - Enter 0-20 points only <br>
                                                                                                            - Paper published (4) <br>
                                                                                                            - Workshop/meetups (4)<br>
                                                                                                            - Staff Development Activities (4) <br>
                                                                                                            - Curriclum Revision (4) <br>
                                                                                                            - Membership of College/Departmental Committees (4) <br>
                                                                                                            - To be filled by HOS 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>    
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-control-feedback">To be filled by HOS </div> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label  class="col-sm-4 control-label"><span class="text-danger">*</span>HOS Assessment 20%  </label>
                                                                            <div class="col-sm-3">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="hos_assessment" value="<?php echo $row['hos_assessment']; ?>" class="form-control" readonly>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                  <a class="mytooltip" href="javascript:void(0)" title="Info about Grading"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            - Enter 0-20 points only <br>
                                                                                                            - Calculation Score x 20%<br>
                                                                                                            - To be filled by HOS 
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-control-feedback">To be filled by HOS </div> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group has-success row m-b-5 m-t-0">
                                                                            <label  class="col-sm-4 control-label"><span class="text-danger">*</span>HOD Assessment 10%  </label>
                                                                            <div class="col-sm-3">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="hod_assessment" value="<?php echo $row['hod_assessment']; ?>" class="form-control" readonly>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                  <a class="mytooltip" href="javascript:void(0)" title="Info about Grading"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            - Enter 0-10 points only <br>
                                                                                                            - Complaints by students (2) <br>
                                                                                                            - Complaints by staffs (2)<br>
                                                                                                            - Following instructions (2)<br>
                                                                                                            - Punctuality/absence (2)<br>
                                                                                                            - Overall impression (2) <br>
                                                                                                            - To be filled by HOD 
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-control-feedback">To be filled by HOD </div> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label  class="col-sm-4 control-label">Total Mark</label>
                                                                            <div class="col-sm-3">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="total_mark" value="<?php echo $row['total_mark']; ?>" class="form-control" readonly>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)" title="Info about Grading"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            - Students feedback 30% <br>
                                                                                                            - Class Visit by Peers 20%<br>
                                                                                                            - Development Activities 20% <br>
                                                                                                            - HOS Assessment 20%<br>
                                                                                                            - HOD Assessment 10% <br>
                                                                                                            - Total 100 %
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>        
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <?php
                                                                }
                                                            ?>        
                                                        </div>
                                                    </div>
                                                </div>
                                                <!------------------------------------->
                                                <!------------------------------------->
                                                <div class="tab-pane p-20" id="Development" role="tabpanel">
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_lecturer_id = $_GET['id'];
                                                            $sdn = new DbaseManipulation;
                                                            $rows = $sdn->readData("SELECT * FROM appraisal_trainings WHERE appraisal_type_description_id = 2 AND appraisal_type_id = $appraisal_lecturer_id"); //2 is fixed for lecturer
                                                            if($sdn->totalCount != 0) {
                                                                $tobeVisible2 = '';
                                                            } else {
                                                                $tobeVisible2 = '[To be filled by the HOS]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success">
                                                            <h4 class="card-title">SUMMARY OF STAFF DEVELOPMENT NEEDS <i><?php echo $tobeVisible2; ?></i></h4>
                                                            <h6 class="card-subtitle">These list will be sent to <span class="font-weight-bold">Staff Development Unit (SDU)</span></h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if($sdn->totalCount != 0) {
                                                                    ?>
                                                                    <form class="form-horizontal" novalidate>
                                                                        <?php
                                                                            foreach ($rows as $row) {
                                                                                ?>
                                                                                <div class="form-group row m-b-5 m-t-0">
                                                                                    <div class="col-sm-10">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <textarea rows="2" class="form-control" readonly><?php echo $row['development_needed']; ?></textarea>
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                                        <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                            <i class="fas fa-info-circle"></i>
                                                                                                            <span class="tooltip-content5">
                                                                                                                <span class="tooltip-text3">
                                                                                                                    <span class="tooltip-inner2">
                                                                                                                    Note:<br />
                                                                                                                    This entry will be show to staff <br>
                                                                                                                    after the whole process of <br>
                                                                                                                    the appraisal. 
                                                                                                                    </span>
                                                                                                                </span>
                                                                                                            </span>
                                                                                                        </a>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php 
                                                                            }
                                                                        ?>        
                                                                    </form>
                                                                    <?php
                                                                }
                                                                ?>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <!------------------------------------->
                                                <!------------------------------------->
                                                <div class="tab-pane p-20" id="Observation" role="tabpanel">
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_lecturer_id = $_GET['id'];
                                                            $hosObs = new DbaseManipulation;
                                                            $row = $hosObs->singleReadFullQry("SELECT TOP 1 * FROM appraisal_hos_observation WHERE appraisal_type_description_id = 2 AND appraisal_type_id = $appraisal_lecturer_id"); //2 is fixed for lecturers
                                                            if($hosObs->totalCount != 0) {
                                                                $tobeVisible3 = '';
                                                            } else {
                                                                $tobeVisible3 = '[To be filled by the HOS]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Observation of Official <i><?php echo $tobeVisible3 ?></i></h4></div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if($hosObs->totalCount != 0) {
                                                                    ?>
                                                                    <form class="form-horizontal">
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Strengths</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="3" class="form-control" readonly><?php echo $row['strengths']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                  <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Weaknesses/Gaps</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="3" class="form-control" readonly><?php echo $row['weaknessess']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Threats</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="3" class="form-control" readonly><?php echo $row['threats']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Recommendation for Improvements</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="3" class="form-control" readonly><?php echo $row['recommendation']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label">Other Comments</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="3" class="form-control" readonly><?php echo $row['other_comments']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-comment"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label">HOS Opinion</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <?php 
                                                                                        $rowsHoS = $helper->readData("SELECT * FROM appraisal_lecturer_hos_recommendation ORDER BY id");
                                                                                        foreach ($rowsHoS as $rowHoS) {
                                                                                            if($rowHoS['id'] == $row['hos_opinion']) {
                                                                                                ?>
                                                                                                <fieldset>
                                                                                                    <label class="custom-control custom-radio">
                                                                                                        <input type="radio" class="custom-control-input" checked><span class="custom-control-label"><?php echo $rowHoS['description']; ?></span> </label>
                                                                                                </fieldset>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <fieldset>
                                                                                                    <label class="custom-control custom-radio">
                                                                                                        <input type="radio" class="custom-control-input" disabled><span class="custom-control-label"><?php echo $rowHoS['description']; ?></span> </label>
                                                                                                </fieldset>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <?php
                                                                }
                                                                ?>                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                <!------------------------------------->
                                                <!------------------------------------->
                                                <div class="tab-pane p-20" id="Approval" role="tabpanel">
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_lecturer_id = $_GET['id'];
                                                            $hoDObs = new DbaseManipulation;
                                                            $rowHoD = $hoDObs->singleReadFullQry("SELECT TOP 1 * FROM appraisal_hod_observation WHERE appraisal_type_description_id = 2 AND appraisal_id = $appraisal_lecturer_id"); //2 is fixed for lecturer
                                                            if($hoDObs->totalCount != 0) {
                                                                $tobeVisible5 = '';
                                                            } else {
                                                                $tobeVisible5 = '[To be filled by the HOC/HOD]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">HOC/HOD Approval <i><?php echo $tobeVisible5 ?></i></h4></div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['hodhocApproval'])) {
                                                                    function array_push_assoc3($array, $key, $value){
                                                                       $array[$key] = $value;
                                                                       return $array;
                                                                    }
                                                                    $fields = array();
                                                                    $fields = [
                                                                        'appraisal_id'=>$_GET['id'],
                                                                        'appraisal_type_description_id'=>2,
                                                                        'staff_id'=>$staff_id,
                                                                        'comment'=>$_POST['hodComment'],
                                                                        'submitted_by'=>$staffId,
                                                                        'date_submitted'=>date('Y-m-d H:i:s')
                                                                    ];

                                                                    foreach ($_POST['styled_radio_opinion_agree'] as $agree_with_hos){
                                                                        $fields = array_push_assoc3($fields, 'agree_with_hos', $agree_with_hos);
                                                                    }
                                                                    if($helper->insert("appraisal_hod_observation",$fields)) {
                                                                        $hod_assessment = $_POST['hod_assessment'];
                                                                        $updateLectGrading = "UPDATE appraisal_lecturer_grading SET hod_assessment = $hod_assessment, total_mark = total_mark + $hod_assessment WHERE appraisal_lecturer_id = ".$_GET['id'];
                                                                        $helper->executeSQL($updateLectGrading);

                                                                        //$staff_position_id = $helper->employmentIDs($staff_id,'position_id');
                                                                        $submit = new DbaseManipulation;
                                                                        $row = $submit->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM appraisal_approval_sequence as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                                        $approver_id = $row['approver_id'];
                                                                        $get = new DbaseManipulation;
                                                                        $rowREqNo = $get->singleReadFullQry("SELECT TOP 1 requestNo, current_sequence FROM appraisal_lecturer WHERE id = ".$_GET['id']);
                                                                        $newReqNo = $rowREqNo['requestNo'];
                                                                        $sequence_no_next = $rowREqNo['current_sequence'] + 1;

                                                                        $sql = "UPDATE appraisal_lecturer SET status = 'Approved by the Line Manager', current_approver = $approver_id, current_sequence = $sequence_no_next WHERE id = ".$_GET['id'];
                                                                        $helper->executeSQL($sql);
                                                                        
                                                                        $contact_details = new DbaseManipulation;
                                                                        $gsm = $contact_details->getContactInfo(1,$staff_id,'data');
                                                                        $staff_email = $contact_details->getContactInfo(2,$staff_id,'data');
                                                                        $appName = $get->getStaffName($staff_id,'firstName','secondName','thirdName','lastName');
                                                                        $getIdInfo = new DbaseManipulation;
                                                                        $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                                                        $from_name = 'hrms@nct.edu.om';
                                                                        $from = 'HRMS - 3.0';
                                                                        $subject = 'NCT-HRMD STAFF APPRAISAL APPROVAL BY '.strtoupper($logged_name);
                                                                        $message = '<html><body>';
                                                                        $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                        $message .= "<h3>NCT-HRMS 3.0 STAFF APPRAISAL DETAILS</h3>";
                                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Approved by the Line Manager</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>For Approval of AD/Dean</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$newReqNo."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$appName."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                        $message .= "</table>";
                                                                        $message .= "</body></html>";
                                                                        $to = array();
                                                                        $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $approver_id AND isCurrent = 1 AND status_id = 1");
                                                                        $nextApproversStaffId = $nextApprover['staff_id'];
                                                                        $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                                                        array_push($to,$logged_in_email,$nextApproverEmailAdd,$staff_email);
                                                                        $emailParticipants = new sendMail;
                                                                        if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
                                                                            //Save Email Information in the system_emails table...
                                                                            $from_name = $from_name;
                                                                            $from = $from;
                                                                            $subject = $subject;
                                                                            $message = $message;
                                                                            $transactionDate = date('Y-m-d H:i:s',time());
                                                                            $to = $to;
                                                                            $recipients = implode(', ', $to);
                                                                            $emailFields = [
                                                                                'requestNo'=>$newReqNo,
                                                                                'moduleName'=>'Technician - Staff Appraisal Approved By Line Manager (HOD/HOC)',
                                                                                'sentStatus'=>'Sent',
                                                                                'recipients'=>$recipients,
                                                                                'fromName'=>$from_name,
                                                                                'comesFrom'=>$from,
                                                                                'subject'=>$subject,
                                                                                'message'=>$message,
                                                                                'createdBy'=>$staffId,
                                                                                'dateEntered'=>$transactionDate,
                                                                                'dateSent'=>$transactionDate
                                                                            ];
                                                                            $saveEmail = new DbaseManipulation;
                                                                            $saveEmail->insert("system_emails",$emailFields);  
                                                                            ?>
                                                                                <script>
                                                                                    $(document).ready(function() {
                                                                                        $('#myModalHoDObservation').modal('show');
                                                                                    });
                                                                                </script>
                                                                            <?php
                                                                        } else {
                                                                            //Save Email Information in the system_emails table...
                                                                            $from_name = $from_name;
                                                                            $from = $from;
                                                                            $subject = $subject;
                                                                            $message = $message;
                                                                            $transactionDate = date('Y-m-d H:i:s',time());
                                                                            $to = $to;
                                                                            $recipients = implode(', ', $to);
                                                                            $emailFields = [
                                                                                'requestNo'=>$newReqNo,
                                                                                'moduleName'=>'Technician - Staff Appraisal Approved By Line Manager (HOD/HOC)',
                                                                                'sentStatus'=>'Failed',
                                                                                'recipients'=>$recipients,
                                                                                'fromName'=>$from_name,
                                                                                'comesFrom'=>$from,
                                                                                'subject'=>$subject,
                                                                                'message'=>$message,
                                                                                'createdBy'=>$staffId,
                                                                                'dateEntered'=>$transactionDate,
                                                                                'dateSent'=>$transactionDate
                                                                            ];
                                                                            $saveEmail = new DbaseManipulation;
                                                                            $saveEmail->insert("system_emails",$emailFields);  
                                                                            ?>
                                                                                <script>
                                                                                    $(document).ready(function() {
                                                                                        $('#myModalHoDObservation').modal('show');
                                                                                    });
                                                                                </script>
                                                                            <?php
                                                                        }    
                                                                    }
                                                                }
                                                                if($hoDObs->totalCount != 0) {
                                                                    ?>
                                                                    <form class="form-horizontal">
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-2 control-label">HOS Opinion</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                <?php 
                                                                                    $rowsHoS = $helper->readData("SELECT * FROM appraisal_lecturer_hos_recommendation ORDER BY id");
                                                                                    foreach ($rowsHoS as $rowHoS) {
                                                                                        if($rowHoS['id'] == $row['hos_opinion']) {
                                                                                            ?>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" checked><span class="custom-control-label"><?php echo $rowHoS['description']; ?></span> </label>
                                                                                            </fieldset>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" disabled><span class="custom-control-label"><?php echo $rowHoS['description']; ?></span> </label>
                                                                                            </fieldset>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-2 control-label">Are You Agree with the HOS?</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <?php 
                                                                                        if($rowHoD['agree_with_hos'] == 'YES') {
                                                                                            ?>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" checked><span class="custom-control-label">YES</span> </label>
                                                                                            </fieldset>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" disabled><span class="custom-control-label">NO</span> </label>
                                                                                            </fieldset>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" disabled><span class="custom-control-label">YES</span> </label>
                                                                                            </fieldset>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" checked><span class="custom-control-label">NO</span> </label>
                                                                                            </fieldset>
                                                                                            <?php
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">                                                        
                                                                            <div class="offset-sm-2 col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea class="form-control" readonly><?php echo $rowHoD['comment']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-comment"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>                                                        
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <form class="form-horizontal" action="" method="POST" novalidate>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-2 control-label">HOS Opinion</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                <?php 
                                                                                    $rowsHoS = $helper->readData("SELECT * FROM appraisal_lecturer_hos_recommendation ORDER BY id");
                                                                                    foreach ($rowsHoS as $rowHoS) {
                                                                                        if($rowHoS['id'] == $row['hos_opinion']) {
                                                                                            ?>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" checked><span class="custom-control-label"><?php echo $rowHoS['description']; ?></span> </label>
                                                                                            </fieldset>
                                                                                            <?php
                                                                                        } else {
                                                                                            ?>
                                                                                            <fieldset>
                                                                                                <label class="custom-control custom-radio">
                                                                                                    <input type="radio" class="custom-control-input" disabled><span class="custom-control-label"><?php echo $rowHoS['description']; ?></span> </label>
                                                                                            </fieldset>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-2 control-label">Grading Criteria - Academic</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">

                                                                                        <input type="text" name="hod_assessment" onkeypress="return isNumberKey(event)" class="form-control" required data-validation-required-message="This field is required" min="0" max="10" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">

                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                
                                                                                                  <a class="mytooltip" href="javascript:void(0)" title="Info about Grading"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            - Enter 0-10 points only <br>
                                                                                                            - Complaints by students (2) <br>
                                                                                                            - Complaints by staffs (2)<br>
                                                                                                            - Following instructions (2)<br>
                                                                                                            - Punctuality/absence (2)<br>
                                                                                                            - Overall impression (2) <br>
                                                                                                            - To be filled by HOD 
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div><!--end input-group-prepend-->
                                                                                    </div><!--end input-group-->
                                                                                </div><!--end controls-->
                                                                                <div class="form-control-feedback">HOD Assessment 10% (1 to 10, maximum of 10)</div>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-2 control-label">Are You Agree with the HOS?</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                <fieldset>
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="YES" name="styled_radio_opinion_agree[]" required id="styled_radio_opinion_agree_yes" class="custom-control-input" checked><span class="custom-control-label">YES</span> </label>
                                                                                </fieldset>
                                                                                <fieldset>
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="NO" name="styled_radio_opinion_agree[]" id="styled_radio_opinion_agree_no" class="custom-control-input"><span class="custom-control-label">NO - You have to explain why</span> </label>
                                                                                </fieldset>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">                                                        
                                                                            <div class="offset-sm-2 col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="hodComment" rows="3" class="form-control" required data-validation-required-message="Please enter your brief justification">Yes I agree.</textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-comment"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>                                                        
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-0">
                                                                            <div class="offset-sm-2 col-sm-10">
                                                                                <button type="submit" name="hodhocApproval" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Approval</button>                                                            
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <?php
                                                                }
                                                                ?>
                                                                                                        
                                                        </div>
                                                    </div>
                                                    <?php 
                                                        $chk = $helper->singleReadFullQry("SELECT TOP 1 * FROM appraisal_approval_sequence WHERE approver_id = $myPositionId AND is_final = 1");
                                                        if($helper->totalCount != 0) {
                                                            if(isset($_POST['deanApproval'])) {
                                                                $fields = [
                                                                    'appraisal_id'=>$_GET['id'],
                                                                    'appraisal_type_description_id'=>2,
                                                                    'staff_id'=>$staff_id,
                                                                    'comment'=>$_POST['deanComment'],
                                                                    'submitted_by'=>$staffId,
                                                                    'date_submitted'=>date('Y-m-d H:i:s')
                                                                ];
                                                                if($helper->insert("appraisal_dean_observation",$fields)) {
                                                                    $submit = new DbaseManipulation;
                                                                    $sql = "UPDATE appraisal_lecturer SET status = 'Completed' WHERE id = ".$_GET['id'];
                                                                    $helper->executeSQL($sql);
                                                                    
                                                                    $contact_details = new DbaseManipulation;
                                                                    $gsm = $contact_details->getContactInfo(1,$staff_id,'data');
                                                                    $staff_email = $contact_details->getContactInfo(2,$staff_id,'data');
                                                                    $get = new DbaseManipulation;
                                                                    $rowREqNo = $get->singleReadFullQry("SELECT TOP 1 requestNo FROM appraisal_lecturer WHERE id = ".$_GET['id']);
                                                                    $newReqNo = $rowREqNo['requestNo'];
                                                                    $appName = $get->getStaffName($staff_id,'firstName','secondName','thirdName','lastName');
                                                                    $getIdInfo = new DbaseManipulation;
                                                                    $staff_dept_id = $helper->employmentIDs($staff_id,'department_id');
                                                                    $email_department = $getIdInfo->fieldNameValue("department",$staff_dept_id,"name");
                                                                    $from_name = 'hrms@nct.edu.om';
                                                                    $from = 'HRMS - 3.0';
                                                                    $subject = 'NCT-HRMD STAFF APPRAISAL APPROVAL BY '.strtoupper($logged_name);
                                                                    $message = '<html><body>';
                                                                    $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                    $message .= "<h3>NCT-HRMS 3.0 STAFF APPRAISAL DETAILS</h3>";
                                                                    $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Completed</td></tr>";
                                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>Approved By The AD/Dean</td></tr>";
                                                                    $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$newReqNo."</td></tr>";
                                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staff_id."</td></tr>";
                                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$appName."</td></tr>";
                                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                    $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$staff_email."</td></tr>";
                                                                    $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                    $message .= "</table>";
                                                                    $message .= "</body></html>";
                                                                    $to = array();


                                                                    $position_aydi = $helper->employmentIDs($staff_id,'position_id');
                                                                    $allEmails = $getIdInfo->readData("SELECT aps.*, e.staff_id FROM appraisal_approval_sequence as aps LEFT OUTER JOIN employmentdetail as e ON aps.approver_id = e.position_id WHERE aps.position_id = $position_aydi AND e.isCurrent = 1 AND e.status_id = 1");
                                                                    foreach ($allEmails as $emailRow) {
                                                                        $participantId = $emailRow['staff_id'];
                                                                        $participantEmail = $getIdInfo->getContactInfo(2,$participantId,'data');
                                                                        array_push($to,$participantEmail);
                                                                    }
                                                                    array_push($to,$staff_email);

                                                                    $emailParticipants = new sendMail;
                                                                    if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
                                                                        //Save Email Information in the system_emails table...
                                                                        $from_name = $from_name;
                                                                        $from = $from;
                                                                        $subject = $subject;
                                                                        $message = $message;
                                                                        $transactionDate = date('Y-m-d H:i:s',time());
                                                                        $to = $to;
                                                                        $recipients = implode(', ', $to);
                                                                        $emailFields = [
                                                                            'requestNo'=>$newReqNo,
                                                                            'moduleName'=>'Technician - Staff Appraisal Approved By The Dean',
                                                                            'sentStatus'=>'Sent',
                                                                            'recipients'=>$recipients,
                                                                            'fromName'=>$from_name,
                                                                            'comesFrom'=>$from,
                                                                            'subject'=>$subject,
                                                                            'message'=>$message,
                                                                            'createdBy'=>$staffId,
                                                                            'dateEntered'=>$transactionDate,
                                                                            'dateSent'=>$transactionDate
                                                                        ];
                                                                        $saveEmail = new DbaseManipulation;
                                                                        $saveEmail->insert("system_emails",$emailFields);  
                                                                        ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    $('#myModalHoDObservation').modal('show');
                                                                                });
                                                                            </script>
                                                                        <?php
                                                                    } else {
                                                                        //Save Email Information in the system_emails table...
                                                                        $from_name = $from_name;
                                                                        $from = $from;
                                                                        $subject = $subject;
                                                                        $message = $message;
                                                                        $transactionDate = date('Y-m-d H:i:s',time());
                                                                        $to = $to;
                                                                        $recipients = implode(', ', $to);
                                                                        $emailFields = [
                                                                            'requestNo'=>$newReqNo,
                                                                            'moduleName'=>'Technician - Staff Appraisal Approved By The Dean',
                                                                            'sentStatus'=>'Failed',
                                                                            'recipients'=>$recipients,
                                                                            'fromName'=>$from_name,
                                                                            'comesFrom'=>$from,
                                                                            'subject'=>$subject,
                                                                            'message'=>$message,
                                                                            'createdBy'=>$staffId,
                                                                            'dateEntered'=>$transactionDate,
                                                                            'dateSent'=>$transactionDate
                                                                        ];
                                                                        $saveEmail = new DbaseManipulation;
                                                                        $saveEmail->insert("system_emails",$emailFields);  
                                                                        ?>
                                                                            <script>
                                                                                $(document).ready(function() {
                                                                                    $('#myModalHoDObservation').modal('show');
                                                                                });
                                                                            </script>
                                                                        <?php
                                                                    }    
                                                                }
                                                            }
                                                            ?>
                                                            <?php 
                                                                $appraisal_lecturer_id = $_GET['id'];
                                                                $dean = new DbaseManipulation;
                                                                $deanRow = $dean->singleReadFullQry("SELECT TOP 1 * FROM appraisal_dean_observation WHERE appraisal_type_description_id = 2 AND appraisal_id = $appraisal_lecturer_id"); //2 is fixed for lecturers
                                                                if($dean->totalCount != 0) {
                                                                    $tobeVisible5 = '';
                                                                } else {
                                                                    $tobeVisible5 = '[To be filled by the ADAA/College Dean]';
                                                                }
                                                            ?>
                                                            <div class="card">
                                                                <div class="card-header bg-light-info p-b-0 p-t-5"><h4 class="card-title font-weight-bold">Asst. Dean/College Dean Approval <i><?php echo $tobeVisible5; ?></i></h4></div>
                                                                <div class="card-body">
                                                                    <?php 
                                                                        if($dean->totalCount != 0) {
                                                                            ?>
                                                                            <form class="form-horizontal">
                                                                                <div class="form-group row m-b-5 m-t-0">
                                                                                    <label  class="col-sm-2 control-label">Remarks</label>                                                      
                                                                                    <div class="col-sm-9">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <textarea rows="3" class="form-control" readonly><?php echo $deanRow['comment']; ?></textarea>
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                                        <i class="far fa-comment"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <form class="form-horizontal" action="" method="POST" novalidate>
                                                                                <div class="form-group row m-b-5 m-t-0">
                                                                                    <label  class="col-sm-2 control-label">Remarks</label>                                                      
                                                                                    <div class="col-sm-9">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <textarea name="deanComment" rows="3" class="form-control" required data-validation-required-message="Please enter your remarks"></textarea>
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                                        <i class="far fa-comment"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>                                                        
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row m-b-0">
                                                                                    <div class="offset-sm-2 col-sm-10">
                                                                                        <button type="submit" name="deanApproval" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Approval</button>                                                            
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <?php 
                                                                        }
                                                                    ?>        
                                                                </div>
                                                            </div>
                                                            <?php 
                                                        }    
                                                    ?>        
                                                </div>
                                            </div><!--end tab-content-->                                          
                                        </div><!--end card body main-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-12 col-xs-18-->
                            </div><!--end row-->
                        </div>            
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>

                <script>
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });
                    $('.daterange').daterangepicker();
                </script>
                <script src="assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
                <script src="assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>
                <script type="text/javascript" src="assets/plugins/multiselect/js/jquery.multi-select.js"></script>
                <script>
                    function isNumberKey(evt){
                        var charCode = (evt.which) ? evt.which : event.keyCode;
                        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) return false;
                        return true;
                    }
                    $(document).ready(function() {
                        $('.textarea_job1').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_job2').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_job3').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment1').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment2').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment3').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_accomplishment4').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_goal1').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_goal2').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});

                        $("#techForm").submit(function() {
                           var textarea_job1 = $('.textarea_job1').val();
                           var textarea_job2 = $('.textarea_job2').val();
                           var textarea_job3 = $('.textarea_job3').val();
                           $(".htechtextarea_job1").val(textarea_job1);
                           $(".htechtextarea_job2").val(textarea_job2);
                           $(".htechtextarea_job3").val(textarea_job3);

                           var textarea_accomplishment1 = $('.textarea_accomplishment1').val();
                           var textarea_accomplishment2 = $('.textarea_accomplishment2').val();
                           var textarea_accomplishment3 = $('.textarea_accomplishment3').val();
                           var textarea_accomplishment4 = $('.textarea_accomplishment4').val();
                           $(".htechtextarea_accomplishment1").val(textarea_accomplishment1);
                           $(".htechtextarea_accomplishment2").val(textarea_accomplishment2);
                           $(".htechtextarea_accomplishment3").val(textarea_accomplishment3);
                           $(".htechtextarea_accomplishment4").val(textarea_accomplishment4);

                           var textarea_goal1 = $('.textarea_goal1').val();
                           var textarea_goal2 = $('.textarea_goal2').val();
                           $(".htechtextarea_goal1").val(textarea_goal1);
                           $(".htechtextarea_goal2").val(textarea_goal2);
                        });

                        var tValueX = $('#totalScore').text();
                        var grandTotalX = parseInt(tValueX) + parseInt(10);

                        if(grandTotalX){
                            if(grandTotalX >= 90 && grandTotalX <= 100)
                                var remarksGrandX = 'Excellent';
                            else if(grandTotalX >= 80 && grandTotalX <= 89)
                                var remarksGrandX = 'Very Good';
                            else if(grandTotalX >= 70 && grandTotalX <= 79)
                                var remarksGrandX = 'Good';
                            else if(grandTotalX >= 56 && grandTotalX <= 69)
                                var remarksGrandX = 'Fair';
                            else if(grandTotalX < 55)
                                var remarksGrandX = 'Weak';
                            $('#grandTotal').text(grandTotalX);
                            $('#grandRemarks').text(remarksGrandX);
                            $('.grandRemarks').val(remarksGrandX);
                        }

                        $('input:radio').change(function(){
                            var job_q1 = $('input[type=radio][name="job_q1[]"]:checked').val();
                            var job_q2 = $('input[type=radio][name="job_q2[]"]:checked').val();
                            var job_q3 = $('input[type=radio][name="job_q3[]"]:checked').val();
                            var job_q4 = $('input[type=radio][name="job_q4[]"]:checked').val();
                            var job_q5 = $('input[type=radio][name="job_q5[]"]:checked').val();
                            var job_q6 = $('input[type=radio][name="job_q6[]"]:checked').val();
                            var job_q7 = $('input[type=radio][name="job_q7[]"]:checked').val();
                            var job_q8 = $('input[type=radio][name="job_q8[]"]:checked').val();
                            var job_q9 = $('input[type=radio][name="job_q9[]"]:checked').val();
                            var job_q10 = $('input[type=radio][name="job_q10[]"]:checked').val();

                            var totalValue = parseInt(job_q1) + parseInt(job_q2) + parseInt(job_q3) + parseInt(job_q4) + parseInt(job_q5) + parseInt(job_q6) + parseInt(job_q7) + parseInt(job_q8) + parseInt(job_q9) + parseInt(job_q10);
                            if(totalValue){
                                if(totalValue >= 40 && totalValue <= 50)
                                    var remarks = 'Excellent';
                                else if(totalValue >= 30 && totalValue <= 39)
                                    var remarks = 'Very Good';
                                else if(totalValue >= 20 && totalValue <= 29)
                                    var remarks = 'Good';
                                else if(totalValue >= 10 && totalValue <= 19)
                                    var remarks = 'Fair';
                                else if(totalValue < 9)
                                    var remarks = 'Weak';
                                $('#totalScore').text(totalValue);
                                $('#totalRemarks').text(remarks);
                                $('.totalRemarks').val(remarks);
                            }

                            var job_q11 = $('input[type=radio][name="job_q11[]"]:checked').val();
                            var job_q12 = $('input[type=radio][name="job_q12[]"]:checked').val();
                            var job_q13 = $('input[type=radio][name="job_q13[]"]:checked').val();
                            var job_q14 = $('input[type=radio][name="job_q14[]"]:checked').val();
                            var job_q15 = $('input[type=radio][name="job_q15[]"]:checked').val();
                            var job_q16 = $('input[type=radio][name="job_q16[]"]:checked').val();
                            var job_q17 = $('input[type=radio][name="job_q17[]"]:checked').val();
                            var job_q18 = $('input[type=radio][name="job_q18[]"]:checked').val();
                            var job_q19 = $('input[type=radio][name="job_q19[]"]:checked').val();
                            var job_q20 = $('input[type=radio][name="job_q20[]"]:checked').val();

                            var totalValue2 = parseInt(job_q11) + parseInt(job_q12) + parseInt(job_q13) + parseInt(job_q14) + parseInt(job_q15) + parseInt(job_q16) + parseInt(job_q17) + parseInt(job_q18) + parseInt(job_q19) + parseInt(job_q20);
                            if(totalValue2){
                                if(totalValue2 >= 40 && totalValue2 <= 50)
                                    var remarks2 = 'Excellent';
                                else if(totalValue2 >= 30 && totalValue2 <= 39)
                                    var remarks2 = 'Very Good';
                                else if(totalValue2 >= 20 && totalValue2 <= 29)
                                    var remarks2 = 'Good';
                                else if(totalValue2 >= 10 && totalValue2 <= 19)
                                    var remarks2 = 'Fair';
                                else if(totalValue2 < 9)
                                    var remarks2 = 'Weak';
                                $('#totalScore2').text(totalValue2);
                                $('#totalRemarks2').text(remarks2);
                                $('.totalRemarks2').val(remarks2);
                            }

                            var tValue = $('#totalScore').text();
                            var grandTotal = parseInt(tValue) + parseInt(totalValue2);
                            if(grandTotal){
                                if(grandTotal >= 90 && grandTotal <= 100)
                                    var remarksGrand = 'Excellent';
                                else if(grandTotal >= 80 && grandTotal <= 89)
                                    var remarksGrand = 'Very Good';
                                else if(grandTotal >= 70 && grandTotal <= 79)
                                    var remarksGrand = 'Good';
                                else if(grandTotal >= 56 && grandTotal <= 69)
                                    var remarksGrand = 'Fair';
                                else if(grandTotal < 55)
                                    var remarksGrand = 'Weak';
                                $('#grandTotal').text(grandTotal);
                                $('.grandTotal').val(grandTotal);
                                $('#grandRemarks').text(remarksGrand);
                                $('.grandRemarks').val(remarksGrand);
                            }
                        });
                        
                        $('input[name=student_feedback]').change(function() { 
                            var total = parseInt($('.studentFeedback').val()) + parseInt($('.classVisit').val()) + parseInt($('.developmentActivities').val()) + parseInt($('.hosAssessment').val());
                            $('.totalGradingMark').val(total)
                        });
                        $('input[name=class_visit]').change(function() { 
                            var total = parseInt($('.studentFeedback').val()) + parseInt($('.classVisit').val()) + parseInt($('.developmentActivities').val()) + parseInt($('.hosAssessment').val());
                            $('.totalGradingMark').val(total)
                        });
                        $('input[name=development_activities]').change(function() { 
                            var total = parseInt($('.studentFeedback').val()) + parseInt($('.classVisit').val()) + parseInt($('.developmentActivities').val()) + parseInt($('.hosAssessment').val());
                            $('.totalGradingMark').val(total)
                        });
                        $('input[name=hos_assessment]').change(function() { 
                            var total = parseInt($('.studentFeedback').val()) + parseInt($('.classVisit').val()) + parseInt($('.developmentActivities').val()) + parseInt($('.hosAssessment').val());
                            $('.totalGradingMark').val(total)
                        });

                        
                    });

                    //For multiselect
                    $('#pre-selected-options').multiSelect();
                    $('#optgroup').multiSelect({
                        selectableOptgroup: true
                    });
                    $('#public-methods').multiSelect();
                    $('#select-all').click(function() {
                        $('#public-methods').multiSelect('select_all');
                        return false;
                    });
                    $('#deselect-all').click(function() {
                        $('#public-methods').multiSelect('deselect_all');
                        return false;
                    });
                    $('#refresh').on('click', function() {
                        $('#public-methods').multiSelect('refresh');
                        return false;
                    });
                    $('#add-option').on('click', function() {
                        $('#public-methods').multiSelect('addOption', {
                            value: 42,
                            text: 'test 42',
                            index: 0
                        });
                        return false;
                    });
                </script>    
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Staff's general attribute score has been submitted successfully! <br><br>Click on Attributes tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalTeaching" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Staff's teaching attribute score has been submitted successfully! <br><br>Click on Attributes tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalStaffDev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>SUMMARY OF STAFF DEVELOPMENT NEEDS has been submitted successfully! <br><br>Click on Staff Development Needed tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="modal fade" id="myModalGrading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Your grading scores has been submitted successfully! <br><br>Click on Grading tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalHoSObservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Your observation data and your appraisal has been submitted successfully! <br><br>Click on HOS Observation tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalHoDObservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Your observation data has been submitted successfully! <br><br>Click on Approval tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>