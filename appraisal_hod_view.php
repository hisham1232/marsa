<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HoD_HoC')) ? true : false;
        //$allowed =  true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            ?>  
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Appraisal - HOS</h3>
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
                                            $currentYear = date('Y');
                                            $id = $_GET['id'];
                                            $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_hod WHERE id = $id AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                            if($checkSubmitted->totalCount != 0) {
                                                $staffStats = 'Submitted ['.date('d/m/Y',strtotime($rec['date_submitted'])).']';
                                                $requestNo = $rec['requestNo'];
                                                $staff_id = $rec['staff_id'];
                                            } else {
                                                $staffStats = 'Not Started';
                                                $request = new DbaseManipulation;
                                                $requestNo = $request->requestNo("HOD-","appraisal_hod");
                                            }
                                        ?>
                                        <?php
                                            $appraisalYear = $helper->getAppraisalYear('appraisal_year');
                                            $basic_info = new DBaseManipulation;
                                            $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, s.joinDate, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, nat.name as nationality FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as nat ON nat.id = s.nationality_id WHERE s.staffId = '$staff_id'");
                                        ?>
                                        <div class="card-header bg-light-success" style="border-bottom: double; border-color: #28a745">
                                            <div class="d-flex no-block align-items-center">
                                                <h4 class="card-title font-weight-bold">Staff Appraisal Form - HOS [<?php echo $appraisalYear; ?>]</h4>
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
                                                        $currentYear = date('Y');
                                                        $id = $_GET['id'];
                                                        $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_hod WHERE id = $id AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                                        $stfId = $rec['position_id'];
                                                        if($checkSubmitted->totalCount != 0) {
                                                            $staffStats = 'Submitted ['.date('d/m/Y',strtotime($rec['date_submitted'])).']';
                                                        } else {
                                                            $staffStats = 'Not Started';
                                                        }
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-2">Staff</div>
                                                        <div class="col-md-6"><?php echo trim($info['staffName']); ?></div>

                                                        <div class="col-md-4"><span class="font-weight-bold text-info"><?php echo $staffStats; ?> </span></div>
                                                    </div><!--end row-->
                                                    <?php 
                                                        $status = $helper->singleReadFullQry("SELECT status FROM appraisal_hod WHERE id = ".$rec['id']);
                                                        $approvers = $helper->readData("SELECT s.*, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as approverName, p.code as approverTitle FROM  appraisal_approval_sequence as s LEFT OUTER JOIN staff_position as p ON p.id = s.approver_id LEFT OUTER JOIN employmentdetail as e ON e.position_id = s.approver_id LEFT OUTER JOIN staff as ss ON e.staff_id = ss.staffId WHERE s.position_id = $stfId AND e.isCurrent = 1 and e.status_id = 1 ORDER BY s.sequence_no;");
                                                        foreach ($approvers as $row) {
                                                            if($row['approver_id'] == $rec['current_approver'] && $rec['current_sequence'] == $row['sequence_no'])
                                                                if($status['status'] == 'Completed')
                                                                    $approverStats = 'Completed';
                                                                else 
                                                                    $approverStats = 'On Process';
                                                            else 
                                                                if($status['status'] == 'Completed')
                                                                    $approverStats = 'Completed';
                                                                else 
                                                                    $approverStats = '...';
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2"><?php echo $row['approverTitle'] ?></div>
                                                                <div class="col-md-6"><?php echo $row['approverName'] ?></div>
                                                                <div class="col-md-4"><span class="font-weight-bold text-info"><?php echo $approverStats; ?></span></div>
                                                                
                                                            </div><!--end row-->
                                                            <?php
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
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Development" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down"></span>Staff Development Needed</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Observation" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">AD/DEAN Observation</span></a> </li>

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
                                                                                <h5>2. Which responsibility from those listed in #1 do you think is most important and why? <span class="text-danger">*</span></h5>
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
                                                                            <h5>3. Have you performed any new tasks or additional duties outside the scope of your regular responsibilities? If so, please specify. <span class="text-danger">*</span></h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_accomplishment3 form-control" rows="3" readonly><?php echo $rec['acc3']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5>4. Describe any staff development activities that have been helpful to you. <span class="text-danger">*</span></h5>
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
                                                            $appraisal_hod_id = $_GET['id'];
                                                            $genAtt = new DbaseManipulation;
                                                            $row = $genAtt->singleReadFullQry("SELECT * FROM appraisal_hod_general_attribute WHERE appraisal_hod_id = $appraisal_hod_id");
                                                            if($genAtt->totalCount != 0) {
                                                                $tobeVisible = '';
                                                            } else {
                                                                $tobeVisible = '[To be filled by the HOD/HOC]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4>General Attribute <i><?php echo $tobeVisible; ?></i></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['submitGeneralAttribute'])) {
                                                                    //print_r($_POST);
                                                                    function array_push_assoc($array, $key, $value){
                                                                       $array[$key] = $value;
                                                                       return $array;
                                                                    }
                                                                    $fields = array();
                                                                    
                                                                    $fields = [
                                                                        'appraisal_hod_id'=>$_GET['id'],
                                                                        'submitted_by'=>$staffId,
                                                                        'date_submitted'=>date('Y-m-d H:i:s')
                                                                    ];
                                                                    $total = 0;

                                                                    foreach ($_POST['job_q1'] as $job_q1){
                                                                        $fields = array_push_assoc($fields, 'job_q1', $job_q1);
                                                                        $total = $total + $job_q1;
                                                                    }
                                                                    foreach ($_POST['job_q2'] as $job_q2){
                                                                        $fields = array_push_assoc($fields, 'job_q2', $job_q2);
                                                                        $total = $total + $job_q2;
                                                                    }
                                                                    foreach ($_POST['job_q3'] as $job_q3){
                                                                        $fields = array_push_assoc($fields, 'job_q3', $job_q3);
                                                                        $total = $total + $job_q3;
                                                                    }
                                                                    foreach ($_POST['job_q4'] as $job_q4){
                                                                        $fields = array_push_assoc($fields, 'job_q4', $job_q4);
                                                                        $total = $total + $job_q4;
                                                                    }
                                                                    foreach ($_POST['job_q5'] as $job_q5){
                                                                        $fields = array_push_assoc($fields, 'job_q5', $job_q5);
                                                                        $total = $total + $job_q5;
                                                                    }
                                                                    foreach ($_POST['job_q6'] as $job_q6){
                                                                        $fields = array_push_assoc($fields, 'job_q6', $job_q6);
                                                                        $total = $total + $job_q6;
                                                                    }
                                                                    foreach ($_POST['job_q7'] as $job_q7){
                                                                        $fields = array_push_assoc($fields, 'job_q7', $job_q7);
                                                                        $total = $total + $job_q7;
                                                                    }
                                                                    foreach ($_POST['job_q8'] as $job_q8){
                                                                        $fields = array_push_assoc($fields, 'job_q8', $job_q8);
                                                                        $total = $total + $job_q8;
                                                                    }
                                                                    foreach ($_POST['job_q9'] as $job_q9){
                                                                        $fields = array_push_assoc($fields, 'job_q9', $job_q9);
                                                                        $total = $total + $job_q9;
                                                                    }
                                                                    foreach ($_POST['job_q10'] as $job_q10){
                                                                        $fields = array_push_assoc($fields, 'job_q10', $job_q10);
                                                                        $total = $total + $job_q10;
                                                                    }
                                                                    $fields = array_push_assoc($fields, 'total', $total);
                                                                    $fields = array_push_assoc($fields, 'remarks', $_POST['remarks']);

                                                                    if($helper->insert("appraisal_hod_general_attribute",$fields)) {
                                                                        ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModalGeneral').modal('show');
                                                                            });
                                                                        </script>
                                                                        <?php
                                                                    }
                                                                }
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
                                                                                    <div class="col-lg-5 col-xs-18"><h3>Interpersonal Skill</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18">With Line Manager</div>
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
                                                                                <div class="col-lg-5 col-xs-18">With other staff</div>
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
                                                                                <div class="col-lg-5 col-xs-18">With students</div>
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
                                                                            <div class="row border-bottom">
                                                                                    <div class="col-lg-5 col-xs-18"><h3>Communication Skill</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Ability to listen and understand information</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Presents information in a clear and concise manner</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Willingness to share information</div>
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
                                                                            <div class="row border-bottom">
                                                                                    <div class="col-lg-5 col-xs-18"><h3>General Performance</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Starts work at appropriate time</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Follow's the dress code</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Observes code of conduct at all times</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Participates in departmental/college activities</div>
                                                                                <?php 
                                                                                    for($a=5; $a>=1; $a--) {
                                                                                        if($a >= 4) {
                                                                                            $col_class = 'col-lg-2';
                                                                                        } else {
                                                                                            $col_class = 'col-lg-1';
                                                                                        }
                                                                                        if($a==$row['job_q10']) {
                                                                                            $haydi = 'job_q'.$a;
                        //    Observe code of conduct at all times                                                               
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
                                                                } else {    
                                                                    ?>
                                                                    <form method="POST" action="" novalidate>
                                                                        <div class="demo-radio-button">
                                                                            <div class="row border-bottom">
                                                                                    <div class="col-lg-5 col-xs-18"><h3>Interpersonal Skill</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18">With Line Manager</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q1[]" type="radio" id="job_q1_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q1_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q1[]" type="radio" id="job_q1_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q1_b">Very Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q1[]" type="radio" id="job_q1_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q1_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q1[]" type="radio" id="job_q1_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q1_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q1[]" type="radio" id="job_q1_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q1_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">With other staff</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input type="hidden" class="totalRemarks" name="remarks">
                                                                                    <input name="job_q2[]" type="radio" id="job_q2_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q2_a">Excellent</label>
                                                                                </div>
                                                                                 <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q2[]" type="radio" id="job_q2_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q2_b">Very Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q2[]" type="radio" id="job_q2_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q2_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q2[]" type="radio" id="job_q2_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q2_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q2[]" type="radio" id="job_q2_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q2_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q2-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">With students</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q3[]" type="radio" id="job_q3_a" value="5" value="5"class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q3_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q3[]" type="radio" id="job_q3_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q3_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q3[]" type="radio" id="job_q3_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q3_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q3[]" type="radio" id="job_q3_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q3_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q3[]" type="radio" id="job_q3_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q3_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q3-->
                                                                            <div class="row border-bottom">
                                                                                    <div class="col-lg-5 col-xs-18"><h3>Communication Skill</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Ability to listen and understand information</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q4[]" type="radio" id="job_q4_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q4_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q4[]" type="radio" id="job_q4_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q4_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q4[]" type="radio" id="job_q4_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q4_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q4[]" type="radio" id="job_q4_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q4_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q4[]" type="radio" id="job_q4_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q4_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q4-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Presents information in a clear and concise manner</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q5[]" type="radio" id="job_q5_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q5_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q5[]" type="radio" id="job_q5_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q5_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q5[]" type="radio" id="job_q5_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q5_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q5[]" type="radio" id="job_q5_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q5_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q5[]" type="radio" id="job_q5_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q5_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q5-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Willingness to share information</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q6[]" type="radio" id="job_q6_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q6_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q6[]" type="radio" id="job_q6_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q6_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q6[]" type="radio" id="job_q6_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q6_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q6[]" type="radio" id="job_q6_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q6_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q6[]" type="radio" id="job_q6_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q6_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q6-->
                                                                            <div class="row border-bottom">
                                                                                    <div class="col-lg-5 col-xs-18"><h3>General Performance</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Starts work at appropriate time</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q7[]" type="radio" id="job_q7_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q7_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q7[]" type="radio" id="job_q7_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q7_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q7[]" type="radio" id="job_q7_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q7_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q7[]" type="radio" id="job_q7_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q7_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q7[]" type="radio" id="job_q7_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q7_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q7-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Follow's the dress code</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q8[]" type="radio" id="job_q8_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q8_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q8[]" type="radio" id="job_q8_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q8_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q8[]" type="radio" id="job_q8_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q8_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q8[]" type="radio" id="job_q8_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q8_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q8[]" type="radio" id="job_q8_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q8_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q8-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Observes code of conduct at all times</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q9[]" type="radio" id="job_q9_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q9_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q9[]" type="radio" id="job_q9_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q9_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q9[]" type="radio" id="job_q9_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q9_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q9[]" type="radio" id="job_q9_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q9_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q9[]" type="radio" id="job_q9_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q9_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q9-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Participates in departmental/college activities</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q10[]" type="radio" id="job_q10_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q10_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q10[]" type="radio" id="job_q10_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q10_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q10[]" type="radio" id="job_q10_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q10_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q10[]" type="radio" id="job_q10_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q10_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q10[]" type="radio" id="job_q10_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q10_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q10-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Total/Remark</h3></div>
                                                                                <div class="col-lg-5">
                                                                                    <label><h3><span id="totalScore">10</span> - <span id="totalRemarks">Weak</span></h3></label>
                                                                                </div>
                                                                            </div><!--end row total-->
                                                                        </div><!--end demo-radio-button-->

                                                                        <div class="text-xs-right">
                                                                            <button type="submit" name="submitGeneralAttribute" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Save</button>
                                                                            <a href="" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Reset</a>
                                                                        </div>
                                                                    </form>
                                                                    <?php 
                                                                }
                                                            ?>        
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_hod_id = $_GET['id'];
                                                            $teachAtt = new DbaseManipulation;
                                                            $row = $teachAtt->singleReadFullQry("SELECT * FROM appraisal_hod_working_attribute WHERE appraisal_hod_id = $appraisal_hod_id");
                                                            if($teachAtt->totalCount != 0) {
                                                                $tobeVisible = '';
                                                            } else {
                                                                $tobeVisible = '[To be filled by the HOD/HOC]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4>Working Attribute <i><?php echo $tobeVisible; ?></i></h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['submitWorkingAttribute'])) {
                                                                    //Dito na tayo, check kung nag si save, i combine din ang score sa dalawa...
                                                                    //print_r($_POST);
                                                                    function array_push_assoc($array, $key, $value){
                                                                       $array[$key] = $value;
                                                                       return $array;
                                                                    }
                                                                    $fields = array();
                                                                    
                                                                    $fields = [
                                                                        'appraisal_hod_id'=>$_GET['id'],
                                                                        'submitted_by'=>$staffId,
                                                                        'date_submitted'=>date('Y-m-d H:i:s')
                                                                    ];
                                                                    $total = 0;

                                                                    foreach ($_POST['job_q11'] as $job_q11){
                                                                        $fields = array_push_assoc($fields, 'job_q11', $job_q11);
                                                                        $total = $total + $job_q11;
                                                                    }
                                                                    foreach ($_POST['job_q12'] as $job_q12){
                                                                        $fields = array_push_assoc($fields, 'job_q12', $job_q12);
                                                                        $total = $total + $job_q12;
                                                                    }
                                                                    foreach ($_POST['job_q13'] as $job_q13){
                                                                        $fields = array_push_assoc($fields, 'job_q13', $job_q13);
                                                                        $total = $total + $job_q13;
                                                                    }
                                                                    foreach ($_POST['job_q14'] as $job_q14){
                                                                        $fields = array_push_assoc($fields, 'job_q14', $job_q14);
                                                                        $total = $total + $job_q14;
                                                                    }
                                                                    foreach ($_POST['job_q15'] as $job_q15){
                                                                        $fields = array_push_assoc($fields, 'job_q15', $job_q15);
                                                                        $total = $total + $job_q15;
                                                                    }
                                                                    foreach ($_POST['job_q16'] as $job_q16){
                                                                        $fields = array_push_assoc($fields, 'job_q16', $job_q16);
                                                                        $total = $total + $job_q16;
                                                                    }
                                                                    foreach ($_POST['job_q17'] as $job_q17){
                                                                        $fields = array_push_assoc($fields, 'job_q17', $job_q17);
                                                                        $total = $total + $job_q17;
                                                                    }
                                                                    foreach ($_POST['job_q18'] as $job_q18){
                                                                        $fields = array_push_assoc($fields, 'job_q18', $job_q18);
                                                                        $total = $total + $job_q18;
                                                                    }
                                                                    foreach ($_POST['job_q19'] as $job_q19){
                                                                        $fields = array_push_assoc($fields, 'job_q19', $job_q19);
                                                                        $total = $total + $job_q19;
                                                                    }
                                                                    foreach ($_POST['job_q20'] as $job_q20){
                                                                        $fields = array_push_assoc($fields, 'job_q20', $job_q20);
                                                                        $total = $total + $job_q20;
                                                                    }
                                                                    $fields = array_push_assoc($fields, 'total', $total);
                                                                    $fields = array_push_assoc($fields, 'grand_total', $_POST['grandTotal']);
                                                                    $fields = array_push_assoc($fields, 'remarks', $_POST['remarks2']);
                                                                    $fields = array_push_assoc($fields, 'grand_remarks', $_POST['grandRemarks']);
                                                                    //print_r($fields);
                                                                    if($helper->insert("appraisal_hod_working_attribute",$fields)) {
                                                                        ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModalWorking').modal('show');
                                                                            });
                                                                        </script>
                                                                        <?php
                                                                    }
                                                                }
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
                                                                                <div class="col-lg-5 col-xs-18"><h3>Quality of Work</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18">Reliable and accurate in every task given</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Always gives attention to details</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Attentive to every request for service</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Work output matches the expectations established</div>
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
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Technical Skills</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Job Knowledge</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Analyzes problems with confidence</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Follows proper safety procedures</div>
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
                                                                                <div class="col-lg-5 col-xs-18">Good use of the center equipment and tools</div>
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
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Approach to work</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Planning & Organization</div>
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
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Flexible/adaptable</div>
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
                                                                } else {    
                                                                    ?>
                                                                    <form method="POST" action="" novalidate>
                                                                        <div class="demo-radio-button">
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Quality of Work</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18">Reliable and accurate in every task given</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input type="hidden" class="totalRemarks2" name="remarks2">
                                                                                    <input type="hidden" class="grandTotal" name="grandTotal">
                                                                                    <input type="hidden" class="grandRemarks" name="grandRemarks">
                                                                                    <input name="job_q11[]" type="radio" id="job_q11_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q11_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q11[]" type="radio" id="job_q11_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q11_b">Very Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q11[]" type="radio" id="job_q11_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q11_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q11[]" type="radio" id="job_q11_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q11_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q11[]" type="radio" id="job_q11_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q11_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q11-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Always gives attention to details</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q12[]" type="radio" id="job_q12_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q12_a">Excellent</label>
                                                                                </div>
                                                                                 <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q12[]" type="radio" id="job_q12_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q12_b">Very Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q12[]" type="radio" id="job_q12_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q12_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q12[]" type="radio" id="job_q12_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q12_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q12[]" type="radio" id="job_q12_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q12_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q12-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Attentive to every request for service</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q13[]" type="radio" id="job_q13_a" value="5" value="5"class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q13_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q13[]" type="radio" id="job_q13_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q13_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q13[]" type="radio" id="job_q13_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q13_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q13[]" type="radio" id="job_q13_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q13_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q13[]" type="radio" id="job_q13_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q13_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q13-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Work output matches the expectations established</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q14[]" type="radio" id="job_q14_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q14_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q14[]" type="radio" id="job_q14_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q14_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q14[]" type="radio" id="job_q14_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q14_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q14[]" type="radio" id="job_q14_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q14_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q14[]" type="radio" id="job_q14_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q14_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q14-->
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Technical Skills</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Job Knowledge</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q15[]" type="radio" id="job_q15_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q15_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q15[]" type="radio" id="job_q15_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q15_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q15[]" type="radio" id="job_q15_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q15_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q15[]" type="radio" id="job_q15_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q15_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q15[]" type="radio" id="job_q15_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q15_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q15-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Analyzes problems with confidence</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q16[]" type="radio" id="job_q16_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q16_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q16[]" type="radio" id="job_q16_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q16_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q16[]" type="radio" id="job_q16_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q16_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q16[]" type="radio" id="job_q16_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q16_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q16[]" type="radio" id="job_q16_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q16_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q16-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Follows proper safety procedures</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q17[]" type="radio" id="job_q17_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q17_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q17[]" type="radio" id="job_q17_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q17_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q17[]" type="radio" id="job_q17_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q17_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q17[]" type="radio" id="job_q17_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q17_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q17[]" type="radio" id="job_q17_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q17_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q17-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Good use of the center equipment and tools</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q18[]" type="radio" id="job_q18_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q18_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q18[]" type="radio" id="job_q18_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q18_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q18[]" type="radio" id="job_q18_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q18_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q18[]" type="radio" id="job_q18_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q18_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q18[]" type="radio" id="job_q18_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q18_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q18-->
                                                                            <div class="row border-bottom">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Approach to work</h3></div>
                                                                            </div><!--end row cat1-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Planning & Organization</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q19[]" type="radio" id="job_q19_a" value="5" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q19_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q19[]" type="radio" id="job_q19_b" value="4" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q19_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q19[]" type="radio" id="job_q19_c" value="3" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q19_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q19[]" type="radio" id="job_q19_d" value="2" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q19_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q19[]" type="radio" id="job_q19_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q19_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q19-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18">Flexible/adaptable</div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q20[]" type="radio" id="job_q20_a" value="5" class="with-gap radio-col-indigo" />
                                                                                    <label for="job_q20_a">Excellent</label>
                                                                                </div>
                                                                                <div class="col-lg-2 col-xs-18">
                                                                                    <input name="job_q20[]" type="radio" id="job_q20_b" value="4" class="with-gap radio-col-indigo" />
                                                                                    <label for="job_q20_b">Very Good</label>
                                                                                </div>
                                                                                 <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q20[]" type="radio" id="job_q20_c" value="3" class="with-gap radio-col-indigo" />
                                                                                    <label for="job_q20_c">Good</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q20[]" type="radio" id="job_q20_d" value="2" class="with-gap radio-col-indigo" />
                                                                                    <label for="job_q20_d">Fair</label>
                                                                                </div>
                                                                                <div class="col-lg-1 col-xs-18">
                                                                                    <input name="job_q20[]" type="radio" id="job_q20_e" value="1" class="with-gap radio-col-indigo" checked />
                                                                                    <label for="job_q20_e">Weak</label>
                                                                                </div>
                                                                            </div><!--end row q20-->
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Total/Remark</h3></div>
                                                                                <div class="col-lg-5">
                                                                                    <label><h3><span id="totalScore2">10</span> - <span id="totalRemarks2">Weak</span></h3></label>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="row border-bottom m-t-5">
                                                                                <div class="col-lg-5 col-xs-18"><h3>Grand Total/Remark</h3></div>
                                                                                <div class="col-lg-5">
                                                                                    <label><h3><span id="grandTotal"></span> - <span id="grandRemarks"></span></h3></label>
                                                                                </div>
                                                                            </div><!--end row total-->
                                                                        </div>

                                                                        <div class="text-xs-right">
                                                                            <button type="submit" name="submitWorkingAttribute" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Save</button>
                                                                            <a href="" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Reset</a>
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
                                                            $appraisal_hod_id = $_GET['id'];
                                                            $sdn = new DbaseManipulation;
                                                            $rows = $sdn->readData("SELECT * FROM appraisal_trainings WHERE appraisal_type_description_id = 5 AND appraisal_type_id = $appraisal_hod_id"); //4 is fixed for hos
                                                            if($sdn->totalCount != 0) {
                                                                $tobeVisible2 = '';
                                                            } else {
                                                                $tobeVisible2 = '[To be filled by the AD/DEAN]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success">
                                                            <h4 class="card-title">SUMMARY OF STAFF DEVELOPMENT NEEDS <i><?php echo $tobeVisible2; ?></i></h4>
                                                            <h6 class="card-subtitle">These list will be sent to <span class="font-weight-bold">Staff Development Unit (SDU)</span></h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['submitStaffDevelopment'])) {
                                                                    $appraisalYear = $helper->getAppraisalYear('appraisal_year');
                                                                    $fields = array();
                                                                    $fields = [
                                                                        'appraisal_type_description_id'=>5,
                                                                        'appraisal_type_id'=>$_GET['id'],
                                                                        'staff_id'=>$staff_id,
                                                                        'development_needed'=>$_POST['textarea1'],
                                                                        'submitted_by'=>$staffId,
                                                                        'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                        'appraisal_year'=>$appraisalYear
                                                                    ];
                                                                    if($helper->insert("appraisal_trainings",$fields)) {
                                                                        if($_POST['textarea2'] != '') {
                                                                            $fields2 = [
                                                                                'appraisal_type_description_id'=>5,
                                                                                'appraisal_type_id'=>$_GET['id'],
                                                                                'staff_id'=>$staff_id,
                                                                                'development_needed'=>$_POST['textarea2'],
                                                                                'submitted_by'=>$staffId,
                                                                                'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                'appraisal_year'=>$appraisalYear
                                                                            ];
                                                                            $helper->insert("appraisal_trainings",$fields2);
                                                                        }
                                                                        if($_POST['textarea3'] != '') {
                                                                            $fields3 = [
                                                                                'appraisal_type_description_id'=>5,
                                                                                'appraisal_type_id'=>$_GET['id'],
                                                                                'staff_id'=>$staff_id,
                                                                                'development_needed'=>$_POST['textarea3'],
                                                                                'submitted_by'=>$staffId,
                                                                                'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                'appraisal_year'=>$appraisalYear
                                                                            ];
                                                                            $helper->insert("appraisal_trainings",$fields3);
                                                                        }
                                                                        if($_POST['textarea4'] != '') {
                                                                            $fields4 = [
                                                                                'appraisal_type_description_id'=>5,
                                                                                'appraisal_type_id'=>$_GET['id'],
                                                                                'staff_id'=>$staff_id,
                                                                                'development_needed'=>$_POST['textarea4'],
                                                                                'submitted_by'=>$staffId,
                                                                                'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                'appraisal_year'=>$appraisalYear
                                                                            ];
                                                                            $helper->insert("appraisal_trainings",$fields4);
                                                                        }
                                                                        if($_POST['textarea5'] != '') {
                                                                            $fields5 = [
                                                                                'appraisal_type_description_id'=>5,
                                                                                'appraisal_type_id'=>$_GET['id'],
                                                                                'staff_id'=>$staff_id,
                                                                                'development_needed'=>$_POST['textarea5'],
                                                                                'submitted_by'=>$staffId,
                                                                                'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                'appraisal_year'=>$appraisalYear
                                                                            ];
                                                                            $helper->insert("appraisal_trainings",$fields5);
                                                                        }
                                                                        ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModalStaffDev').modal('show');
                                                                            });
                                                                        </script>
                                                                        <?php
                                                                    }
                                                                }
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
                                                                } else {
                                                                    ?>                                                            
                                                                    <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <div class="col-sm-10">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="textarea1" rows="2" id="textarea" class="form-control" required data-validation-required-message="Please enter at least one course and training program. Put Not Applicable if you don't want to." title="Recommended courses and training programs"></textarea>
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
                                                                            <div class="col-sm-10">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="textarea2" rows="2" id="textarea" class="form-control" title="Recommended courses and training programs"></textarea>
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
                                                                            <div class="col-sm-10">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="textarea3" rows="2" id="textarea" class="form-control" title="Recommended courses and training programs"></textarea>
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
                                                                            <div class="col-sm-10">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="textarea4" rows="2" id="textarea" class="form-control" title="Recommended courses and training programs"></textarea>
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
                                                                            <div class="col-sm-10">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="textarea5" rows="2" id="textarea" class="form-control" title="Recommended courses and training programs"></textarea>
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
                                                                        <div class="form-group row m-b-0">
                                                                            <div class="col-sm-10">
                                                                                <button type="submit" name="submitStaffDevelopment" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Save</button>
                                                                                <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
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
                                                <div class="tab-pane p-20" id="Observation" role="tabpanel">
                                                    <div class="card">
                                                        <?php 
                                                            $appraisal_hod_id = $_GET['id'];
                                                            $hosObs = new DbaseManipulation;
                                                            $row = $hosObs->singleReadFullQry("SELECT TOP 1 * FROM appraisal_hos_observation WHERE appraisal_type_description_id = 5 AND appraisal_type_id = $appraisal_hod_id"); //4 is fixed for HoS
                                                            if($hosObs->totalCount != 0) {
                                                                $tobeVisible3 = '';
                                                            } else {
                                                                $tobeVisible3 = '[To be filled by the AD/DEAN]';
                                                            }
                                                        ?>
                                                        <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Observation of Official <i><?php echo $tobeVisible3 ?></i></h4></div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['submitDeanObservation'])) {
                                                                    function array_push_assoc2($array, $key, $value){
                                                                       $array[$key] = $value;
                                                                       return $array;
                                                                    }
                                                                    $fields = array();
                                                                    $fields = [
                                                                        'appraisal_type_description_id'=>5,
                                                                        'appraisal_type_id'=>$_GET['id'],
                                                                        'staff_id'=>$staff_id,
                                                                        'strengths'=>$_POST['strenghts'],
                                                                        'weaknessess'=>$_POST['weaknessess'],
                                                                        'threats'=>$_POST['threats'],
                                                                        'recommendation'=>$_POST['recommendation'],
                                                                        'recommendation_to_college_admin'=>$_POST['recommendation_to_college_admin'],
                                                                        'other_comments'=>$_POST['other_comments'],
                                                                        'submitted_by'=>$staffId,
                                                                        'date_submitted'=>date('Y-m-d H:i:s',time())
                                                                    ];

                                                                    foreach ($_POST['styled_radio_opinion_hos'] as $hosOpinion){
                                                                        $fields = array_push_assoc2($fields, 'hos_opinion', $hosOpinion);
                                                                    }
                                                                    //print_r($fields);
                                                                    if($helper->insert("appraisal_hos_observation",$fields)) { //Even though Dean/AD is the one logged in here, save it in appraisal_hos_observation, just use the appraisal_type_description_id = 5 if you want to filter the observation of the AD/Dean
                                                                        //$staff_position_id = $helper->employmentIDs($staff_id,'position_id');
                                                                        $submit = new DbaseManipulation;
                                                                        $row = $submit->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM appraisal_approval_sequence as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                                        $sequence_no = $row['sequence_no'];
                                                                        $sequence_no_next = $row['sequence_no'] + 1;
                                                                        $approver_id = $row['approver_id'];
                                                                        $sql = "UPDATE appraisal_hod SET status = 'Approved by the Dean', current_approver = $approver_id, current_sequence = $sequence_no_next WHERE id = ".$_GET['id'];
                                                                        $helper->executeSQL($sql);
                                                                        $get = new DbaseManipulation;
                                                                        $rowREqNo = $get->singleReadFullQry("SELECT TOP 1 requestNo FROM appraisal_hod WHERE id = ".$_GET['id']);
                                                                        $newReqNo = $rowREqNo['requestNo'];

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
                                                                        $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                                        $message .= "<h3>NCT-HRMS 3.0 STAFF APPRAISAL DETAILS</h3>";
                                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Approved by the Dean</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>Approved by the Dean</td></tr>";
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
                                                                                'moduleName'=>'HOD - Staff Appraisal Approved By The Dean',
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
                                                                                        $('#myModalDeanObservation').modal('show');
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
                                                                                'moduleName'=>'HOD - Staff Appraisal Approved By The Dean',
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
                                                                                        $('#myModalHoSObservation').modal('show');
                                                                                    });
                                                                                </script>
                                                                            <?php
                                                                        }    
                                                                    }
                                                                }
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
                                                                            <label  class="col-sm-3 control-label">AD/DEAN Opinion</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <?php 
                                                                                        $rowsHoS = $helper->readData("SELECT * FROM appraisal_hod_dean_recommendation ORDER BY id");
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
                                                                } else {    
                                                                    ?>
                                                                    <form class="form-horizontal" action="" method="POST" novalidate>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Strengths</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="strenghts" rows="3" id="textarea" class="form-control" required data-validation-required-message="Please enter Strengths"></textarea>
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
                                                                                        <textarea name="weaknessess" rows="3" id="textarea" class="form-control" required data-validation-required-message="Please enter Weaknesses/Gaps"></textarea>
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
                                                                                        <textarea name="threats" rows="3" id="textarea" class="form-control" required data-validation-required-message="Please enter Threats"></textarea>
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
                                                                                        <textarea name="recommendation" rows="3" id="textarea" class="form-control" required data-validation-required-message="Please enter Threats"></textarea>
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
                                                                                        <textarea name="other_comments" rows="3" id="textarea" class="form-control" ></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-comment"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label" for="inputWarning1"><span class="text-danger">*</span> Recommendation to the College Administration</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea name="recommendation_to_college_admin" rows="3" id="textarea" class="form-control" required data-validation-required-message="Please enter Recommendation to the College Administration"></textarea id="inputWarning1">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-comment"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-control-feedback">This entry is confidential. It will not show to staff.</div>    
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label">AD/DEAN Opinion</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                <fieldset>
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="1" name="styled_radio_opinion_hos[]" required id="styled_radio_opinion_hos1" class="custom-control-input"><span class="custom-control-label">His/her qualifications and abilities do not support him/her to have higher responsibilities.</span> </label>
                                                                                </fieldset>
                                                                                <fieldset>
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="2" name="styled_radio_opinion_hos[]" id="styled_radio_opinion_hos2" class="custom-control-input"><span class="custom-control-label">He/she is in a position that matches his/her abilities.</span> </label>
                                                                                </fieldset>
                                                                                <fieldset>
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="3" name="styled_radio_opinion_hos[]" id="styled_radio_opinion_hos3" class="custom-control-input"><span class="custom-control-label">He/she has mastered his/her recent work and his/her abilities qualify him/her to have more responsibilities.</span> </label>
                                                                                </fieldset>                                                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-0">
                                                                            <div class="offset-sm-3 col-sm-10">
                                                                                <button type="submit" name="submitDeanObservation" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Appraisal</button>
                                                                                <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
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
                                                    <?php 
                                                        $chk = $helper->singleReadFullQry("SELECT TOP 1 * FROM appraisal_approval_sequence WHERE approver_id = $myPositionId");
                                                        if($helper->totalCount != 0) {
                                                            if(isset($_POST['deanApproval'])) {
                                                                function array_push_assoc3($array, $key, $value){
                                                                   $array[$key] = $value;
                                                                   return $array;
                                                                }
                                                                $fields = array();
                                                                $fields = [
                                                                    'appraisal_id'=>$_GET['id'],
                                                                    'appraisal_type_description_id'=>5,
                                                                    'staff_id'=>$staff_id,
                                                                    'comment'=>$_POST['deanComment'],
                                                                    'submitted_by'=>$staffId,
                                                                    'date_submitted'=>date('Y-m-d H:i:s')
                                                                ];
                                                                $fieldsappraisal_hod_observation = array();
                                                                $fieldsappraisal_hod_observation = [
                                                                    'appraisal_id'=>$_GET['id'],
                                                                    'appraisal_type_description_id'=>5,
                                                                    'staff_id'=>$staff_id,
                                                                    'comment'=>$_POST['agree_with_hod_comment'],
                                                                    'submitted_by'=>$staffId,
                                                                    'date_submitted'=>date('Y-m-d H:i:s')
                                                                ];

                                                                foreach ($_POST['styled_radio_opinion_agree'] as $agree_with_hod){
                                                                    $fieldsappraisal_hod_observation = array_push_assoc3($fieldsappraisal_hod_observation, 'agree_with_hos', $agree_with_hod);
                                                                }
                                                                if($helper->insert("appraisal_dean_observation",$fields)) {
                                                                    $submit = new DbaseManipulation;
                                                                    $submit->insert("appraisal_hod_observation",$fieldsappraisal_hod_observation);
                                                                    $sql = "UPDATE appraisal_hod SET status = 'Completed' WHERE id = ".$_GET['id'];
                                                                    $helper->executeSQL($sql);                                                                    
                                                                    $contact_details = new DbaseManipulation;
                                                                    $gsm = $contact_details->getContactInfo(1,$staff_id,'data');
                                                                    $staff_email = $contact_details->getContactInfo(2,$staff_id,'data');
                                                                    $get = new DbaseManipulation;
                                                                    $rowREqNo = $get->singleReadFullQry("SELECT TOP 1 requestNo FROM appraisal_hod WHERE id = ".$_GET['id']);
                                                                    $newReqNo = $rowREqNo['requestNo'];
                                                                    $appName = $get->getStaffName($staff_id,'firstName','secondName','thirdName','lastName');
                                                                    $getIdInfo = new DbaseManipulation;
                                                                    $staff_dept_id = $helper->employmentIDs($staff_id,'department_id');
                                                                    $email_department = $getIdInfo->fieldNameValue("department",$staff_dept_id,"name");
                                                                    $from_name = 'hrms@nct.edu.om';
                                                                    $from = 'HRMS - 3.0';
                                                                    $subject = 'NCT-HRMD STAFF APPRAISAL APPROVAL BY '.strtoupper($logged_name);
                                                                    $message = '<html><body>';
                                                                    $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
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
                                                                            'moduleName'=>'HOS - Staff Appraisal Approved By The Dean',
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
                                                                                    $('#myModalDeanApproval').modal('show');
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
                                                                            'moduleName'=>'HOS - Staff Appraisal Approved By The Dean',
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
                                                                                    $('#myModalDeanApproval').modal('show');
                                                                                });
                                                                            </script>
                                                                        <?php
                                                                    }    
                                                                }
                                                            }
                                                            ?>
                                                            <?php 
                                                                $appraisal_hod_id = $_GET['id'];
                                                                $dean = new DbaseManipulation;
                                                                $deanRow = $dean->singleReadFullQry("SELECT TOP 1 * FROM appraisal_dean_observation WHERE appraisal_type_description_id = 5 AND appraisal_id = $appraisal_hod_id"); //5 is fixed for hoD
                                                                if($dean->totalCount != 0) {
                                                                    $tobeVisible5 = '';
                                                                } else {
                                                                    $tobeVisible5 = '[To be filled by the ADAA/College Dean]';
                                                                }

                                                                $hoDObs = new DbaseManipulation;
                                                                $rowHoD = $hoDObs->singleReadFullQry("SELECT TOP 1 * FROM appraisal_hos_observation WHERE appraisal_type_description_id = 5 AND appraisal_type_id = $appraisal_hod_id"); //5 is fixed for hoD
                                                            ?>
                                                            <div class="card">
                                                                <div class="card-header bg-light-info p-b-0 p-t-5"><h4 class="card-title font-weight-bold">Asst. Dean/College Dean Approval <i><?php echo $tobeVisible5; ?></i></h4></div>
                                                                <div class="card-body">
                                                                        <?php 
                                                                            if($hoDObs->totalCount != 0) {
                                                                                ?>
                                                                                <form class="form-horizontal">
                                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                                        <label  class="col-sm-2 control-label">AD/DEAN Opinion</label>
                                                                                        <div class="col-sm-9">
                                                                                            <div class="controls">
                                                                                            <?php 
                                                                                                $rowsHoS = $helper->readData("SELECT * FROM appraisal_hod_dean_recommendation ORDER BY id");
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
                                                                <div class="card-body">
                                                                    <?php 
                                                                        if($dean->totalCount != 0) {
                                                                            ?>
                                                                            <form class="form-horizontal">
                                                                                <div class="form-group row m-b-5 m-t-0">
                                                                                    <label  class="col-sm-2 control-label">Are You Agree with the AD/DEAN?</label>
                                                                                    <div class="col-sm-9">
                                                                                        <div class="controls">
                                                                                            <?php
                                                                                                $agree = new DbaseManipulation;
                                                                                                $rowAgree = $agree->singleReadFullQry("SELECT * FROM appraisal_hod_observation WHERE appraisal_type_description_id = 5 AND appraisal_id = $appraisal_hod_id"); 
                                                                                                if($rowAgree['agree_with_hos'] == 'YES') {
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
                                                                                                <textarea class="form-control" readonly><?php echo $rowAgree['comment']; ?></textarea>
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
                                                                                    <label  class="col-sm-2 control-label">Are You Agree with the AD/DEAN?</label>
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
                                                                                                <textarea name="agree_with_hod_comment" rows="3" class="form-control" required data-validation-required-message="Please enter your brief justification">Yes I agree.</textarea>
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
                <div class="modal fade" id="myModalGeneral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>HOS's general attribute score has been submitted successfully! <br><br>Click on Attributes tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalWorking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>HOS's working attribute score has been submitted successfully! <br><br>Click on Attributes tab to see the information you have saved.</h5>
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
                <div class="modal fade" id="myModalDeanObservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                <div class="modal fade" id="myModalDeanApproval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Staff appraisal has been submitted, processed and completed successfully! <br><br>Click on Approval tab to see the information you have saved.</h5>
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