<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Clearance Application</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance </li>
                                        <li class="breadcrumb-item">Apply Clearance</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <h4 class="card-title font-weight-bold">Clearance Application Form</h4>
                                            <div class="row">
                                                <?php
                                                    $basic_info = new DBaseManipulation;
                                                    $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, s.gender, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.joinDate, n.name as nationality, q.name as qualification FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id WHERE s.staffId = '$staffId' AND e.isCurrent = 1 and e.status_id = 1");
                                                ?>
                                                <div class="col-lg-6">
                                                    <p class="m-b-0">Staff ID: <span class="text-primary"><?php echo $staffId; ?></span></p>
                                                    <p class="m-b-0">Staff Name: <span class="text-primary"><?php echo $info['staffName']; ?></span></p>
                                                    <p class="m-b-0">Department: <span class="text-primary"><?php echo $info['department']; ?></span></p>
                                                    <p class="m-b-0">Section: <span class="text-primary"><?php echo $info['section']; ?></span></p>
                                                    <p class="m-b-0">Job Title: <span class="text-primary"><?php echo $info['jobtitle']; ?></span></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $info['sponsor']; ?></span></p>
                                                    <p class="m-b-0">Qualification: <span class="text-primary"><?php echo $info['qualification']; ?></span></p>
                                                    <p class="m-b-0">Join Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></p>
                                                    <p class="m-b-0">Nationality: <span class="text-primary"><?php echo $info['nationality']; ?></span></p>
                                                    <p class="m-b-0">Gender: <span class="text-primary"><?php echo $info['gender']; ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                        <div class="card-header bg-light-blue">
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    print_r($_POST);
                                                    $checkBoxAs = $_POST['checkBoxA'];
                                                    foreach ($checkBoxAs as $chkBoxA){
                                                        echo '<br/>',$chkBoxA;
                                                    }
                                                    $radioAspects11 = $_POST['radioAspect11'];
                                                    foreach ($radioAspects11 as $rdoAspect11){
                                                        echo '<br/>',$rdoAspect11;
                                                    }    
                                                }
                                            ?>
                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-12 control-label"><h3 class="text-primary">Fill Out Exit Interview Form</h3></label>
                                                </div>    
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <p class="text-primary">Feedback from staff plays a crucial role in developing and improving the working environment and the services provided by the college. We would appreciate your objective and honest opinions/suggestions regarding your work experience at the college. Your responses will be treated with total confidence.</p>
                                                    </div>
                                                </div>    
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <span class="text-danger">*</span>A. What is/are the reason/s for leaving the college? Kindly tick the appropriate.
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="a1" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                            <span class="custom-control-label">1. Better Career Opportunity</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="a2" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                            <span class="custom-control-label">2. Better pay and Benefits</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="a3" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                            <span class="custom-control-label">3. Unsuitable Working Environment</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="a4" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                            <span class="custom-control-label">4. Conflict with Superiors</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="a5" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                            <span class="custom-control-label">5. Personal or/and Family reasons</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="a6" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                            <span class="custom-control-label">6. Problems with students and colleagues</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="a7" name="checkBoxA[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one reason for leaving the college." class="custom-control-input">
                                                                            <span class="custom-control-label">7. Others, please specify: <textarea name="reasonCheckBoxA7" class="form-control" rows="2"></textarea></span>
                                                                        </label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <span class="text-danger">*</span>B. Tick the appropriate for the following aspects in each table:
                                                                    <div class="font-weight-bold">1. The Job</div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Aspects</th>
                                                                                <th>Poor</th>
                                                                                <th>Needs Further Improvement</th>
                                                                                <th>Good</th>
                                                                                <th>Excellent</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-left">1.</td>
                                                                                <td class="text-left">Induction program provided</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect11a" name="radioAspect11[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect11b" name="radioAspect11[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect11c" name="radioAspect11[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect11d" name="radioAspect11[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">2.</td>
                                                                                <td class="text-left">Job was challenging</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect12a" name="radioAspect12[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect12b" name="radioAspect12[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect12c" name="radioAspect12[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect12d" name="radioAspect12[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">3.</td>
                                                                                <td class="text-left">Matching with your qualifications and experiences</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect13a" name="radioAspect13[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect13b" name="radioAspect13[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect13c" name="radioAspect13[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect13d" name="radioAspect13[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">4.</td>
                                                                                <td class="text-left">Sufficient opportunities for advancement were given</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect14a" name="radioAspect14[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect14b" name="radioAspect14[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect14c" name="radioAspect14[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect14d" name="radioAspect14[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">5.</td>
                                                                                <td class="text-left">Your skills were effectively used</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect15a" name="radioAspect15[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect15b" name="radioAspect15[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect15c" name="radioAspect15[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect15d" name="radioAspect15[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">6.</td>
                                                                                <td class="text-left">Workload was manageable and fair</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect16a" name="radioAspect16[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect16b" name="radioAspect16[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect16c" name="radioAspect16[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect16d" name="radioAspect16[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">7.</td>
                                                                                <td class="text-left">Sufficient resources and staff were available</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect17a" name="radioAspect17[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect17b" name="radioAspect17[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect17c" name="radioAspect17[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect17d" name="radioAspect17[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">8.</td>
                                                                                <td class="text-left">Appropriate working conditions</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect18a" name="radioAspect18[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 8." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect18b" name="radioAspect18[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 8." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect18c" name="radioAspect18[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 8." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect18d" name="radioAspect18[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 8." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">9.</td>
                                                                                <td class="text-left">Your suggestions and opinions were listened and appreciated by your colleagues</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect19a" name="radioAspect19[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 9." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect19b" name="radioAspect19[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 9." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect19c" name="radioAspect19[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 9." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect19d" name="radioAspect19[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 9." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">10.</td>
                                                                                <td class="text-left">Adequate training and development programs provided</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect110a" name="radioAspect110[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 10." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect110b" name="radioAspect110[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 10." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect110c" name="radioAspect110[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 10." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect110d" name="radioAspect110[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 10." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">11.</td>
                                                                                <td class="text-left">Pay and Benefits</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect111a" name="radioAspect111[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 11." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect111b" name="radioAspect111[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 11." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect111c" name="radioAspect111[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 11." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect111d" name="radioAspect111[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 11." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">12.</td>
                                                                                <td class="text-left">Opportunities for award, promotion and recognition</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect112a" name="radioAspect112[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 12." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect112b" name="radioAspect112[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 12." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect112c" name="radioAspect112[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 12." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect112d" name="radioAspect112[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the job, aspect number 12." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">13.</td>
                                                                                <td class="text-left">What do you think can be improved about this job?</td>
                                                                                <td class="text-left" colspan="4"><textarea name="reasonAspect113" class="form-control" rows="2" required data-validation-required-message="Opinion to improved the job is required"></textarea></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <div class="font-weight-bold">2. The College (NCT)</div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Aspects</th>
                                                                                <th>Poor</th>
                                                                                <th>Needs Further Improvement</th>
                                                                                <th>Good</th>
                                                                                <th>Excellent</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-left">1.</td>
                                                                                <td class="text-left">Communication</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect21a" name="radioAspect21[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect21b" name="radioAspect21[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect21c" name="radioAspect21[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect21d" name="radioAspect21[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">2.</td>
                                                                                <td class="text-left">Work culture</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect22a" name="radioAspect22[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect22b" name="radioAspect22[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect22c" name="radioAspect22[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect22d" name="radioAspect22[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">3.</td>
                                                                                <td class="text-left">Policies and procedures</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect23a" name="radioAspect23[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect23b" name="radioAspect23[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect23c" name="radioAspect23[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect23d" name="radioAspect23[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">4.</td>
                                                                                <td class="text-left">Recognition of high performance</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect24a" name="radioAspect24[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect24b" name="radioAspect24[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect24c" name="radioAspect24[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect24d" name="radioAspect24[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">5.</td>
                                                                                <td class="text-left">College resources and facilities</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect25a" name="radioAspect25[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect25b" name="radioAspect25[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect25c" name="radioAspect25[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect25d" name="radioAspect25[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">6.</td>
                                                                                <td class="text-left">Staff relations</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect26a" name="radioAspect26[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect26b" name="radioAspect26[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect26c" name="radioAspect26[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect26d" name="radioAspect26[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the college, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">7.</td>
                                                                                <td class="text-left">What do you think can be improved by the college?</td>
                                                                                <td class="text-left" colspan="4"><textarea name="reasonAspect27" class="form-control" rows="2" required data-validation-required-message="Opinion to improved the college is required"></textarea></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <div class="font-weight-bold">3. Your Supervisor</div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Aspects</th>
                                                                                <th>Poor</th>
                                                                                <th>Needs Further Improvement</th>
                                                                                <th>Good</th>
                                                                                <th>Excellent</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-left">1.</td>
                                                                                <td class="text-left">Cooperative</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect31a" name="radioAspect31[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect31b" name="radioAspect31[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect31c" name="radioAspect31[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect31d" name="radioAspect31[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">2.</td>
                                                                                <td class="text-left">A good communicator</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect32a" name="radioAspect32[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect32b" name="radioAspect32[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect32c" name="radioAspect32[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect32d" name="radioAspect32[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">3.</td>
                                                                                <td class="text-left">Provide constructive feedback</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect33a" name="radioAspect33[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect33b" name="radioAspect33[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect33c" name="radioAspect33[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect33d" name="radioAspect33[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">4.</td>
                                                                                <td class="text-left">Encourage teamwork and cooperation</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect34a" name="radioAspect34[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect34b" name="radioAspect34[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect34c" name="radioAspect34[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect34d" name="radioAspect34[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">5.</td>
                                                                                <td class="text-left">Problem solver</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect35a" name="radioAspect35[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect35b" name="radioAspect35[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect35c" name="radioAspect35[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect35d" name="radioAspect35[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">6.</td>
                                                                                <td class="text-left">Provide feedback on your appraisal</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect36a" name="radioAspect36[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect36b" name="radioAspect36[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect36c" name="radioAspect36[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect36d" name="radioAspect36[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for your supervisor, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">7.</td>
                                                                                <td class="text-left">What are the suggestions/opinions to your supervisor?</td>
                                                                                <td class="text-left" colspan="4"><textarea name="reasonAspect37" class="form-control" rows="2" required data-validation-required-message="Suggestions/opinions to your supervisor is required"></textarea></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <div class="font-weight-bold">4. The Management</div>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Aspects</th>
                                                                                <th>Poor</th>
                                                                                <th>Needs Further Improvement</th>
                                                                                <th>Good</th>
                                                                                <th>Excellent</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-left">1.</td>
                                                                                <td class="text-left">Effectively communicated management decisions</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect41a" name="radioAspect41[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect41b" name="radioAspect41[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect41c" name="radioAspect41[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect41d" name="radioAspect41[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 1." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">2.</td>
                                                                                <td class="text-left">Give fair and equal treatment</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect42a" name="radioAspect42[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect42b" name="radioAspect42[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect42c" name="radioAspect42[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect42d" name="radioAspect42[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 2." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">3.</td>
                                                                                <td class="text-left">Available to discuss job related concerns and issues</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect43a" name="radioAspect43[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect43b" name="radioAspect43[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect43c" name="radioAspect43[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect43d" name="radioAspect43[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 3." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">4.</td>
                                                                                <td class="text-left">Encourage feedback and suggestions</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect44a" name="radioAspect44[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect44b" name="radioAspect44[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect44c" name="radioAspect44[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect44d" name="radioAspect44[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 4." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">5.</td>
                                                                                <td class="text-left">Provide development opportunities</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect45a" name="radioAspect45[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect45b" name="radioAspect45[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect45c" name="radioAspect45[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect45d" name="radioAspect45[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 5." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">6.</td>
                                                                                <td class="text-left">Maintained a professional relationship with you</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect46a" name="radioAspect46[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect46b" name="radioAspect46[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect46c" name="radioAspect46[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect46d" name="radioAspect46[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 6." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">7.</td>
                                                                                <td class="text-left">Cooperative</td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect47a" name="radioAspect47[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect47b" name="radioAspect47[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect47c" name="radioAspect47[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <label class="custom-control custom-radio">
                                                                                        <input type="radio" value="aspect47d" name="radioAspect47[]" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose one value for the management, aspect number 7." class="custom-control-input">
                                                                                        <span class="custom-control-label"></span>
                                                                                    </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-left">8.</td>
                                                                                <td class="text-left">What are the suggestions/opinions to the management?</td>
                                                                                <td class="text-left" colspan="4"><textarea name="reasonAspect48" class="form-control" rows="2" required data-validation-required-message="Suggestions/opinions to the management is required"></textarea></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <div class="font-weight-bold">5. General Comments</div>
                                                                    <table class="table table-bordered">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>1.</td>
                                                                                <td>In your opinion, what do you value the most and least about working at NCT?<br/>
                                                                                <textarea name="comment51" class="form-control" rows="2" required data-validation-required-message="Please provide an answer to the general comments" minlength="10"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2.</td>
                                                                                <td>What are the main challenges faced and suggestions for improvement?<br/>
                                                                                <textarea name="comment52" class="form-control" rows="2" required data-validation-required-message="Please provide an answer to the general comments" minlength="10"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>3.</td>
                                                                                <td>Any additional comments/suggestions?<br/>
                                                                                <textarea name="comment53" class="form-control" rows="2" required data-validation-required-message="Please provide an answer to the general comments" minlength="10"></textarea>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row m-b-0">
                                                    <div class="col-sm-9">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Exit Interview Form and Generate Clearance Application</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>    
                                        </div>
                                        <div class="card-body">
                                            <div class="message-box contact-box">
                                                <div style="height:20px"></div>
                                                <p>Please take note that upon submitting your clearance, a notification email will be sent to the following department/section to notify them that they need to Approve your clearance application.</p>
                                                <p>The process of approval is <strong>IN NO PARTICULAR ORDER</strong> but still it is depend on the discretion of the approver if he will approve/reject your clearance application.</p>
                                                <h4>Clearance Approvers:</h4>
                                                <ul class="feeds">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <li>
                                                                <div class="bg-primary"><i class="fas fa-clipboard-list text-white"></i></div> Staff Section Head <em><small>(if applicable)</small></em></span>
                                                            </li>
                                                            <li>
                                                                <div class="bg-primary"><i class="fas fa-suitcase text-white"></i></div> Department Head
                                                            </li>
                                                            <li>
                                                                <div class="bg-success"><i class="fas fa-box-open text-white"></i></div> Administrative Affairs
                                                            </li>
                                                            <li>
                                                                <div class="bg-success"><i class="ti-shopping-cart text-white"></i></div> College Store
                                                            </li>
                                                            <li>
                                                                <div class="bg-megna"><i class="far fa-money-bill-alt text-white"></i></div> Financial Affairs
                                                            </li>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <li>
                                                                <div class="bg-info"><i class="fa ti-server text-white"></i></div> HOS - Computer Services Section
                                                            </li>
                                                            <li>
                                                                <div class="bg-info"><i class="ti-book text-white"></i></div> HOS - Library Section
                                                            </li>
                                                            <li>
                                                                <div class="bg-info"><i class="ti-microsoft text-white"></i></div> HOC - Educational Technologies Centre
                                                            </li>
                                                            <li>
                                                                <div class="bg-danger"><i class="fas fa-diagnoses text-white"></i> </div> HOD - Human Resource Department
                                                            </li>
                                                            <li>
                                                                <div class="bg-danger"><i class="ti-wallet text-white"></i></div> Assistant Dean for Admin and Financial Affairs
                                                            </li>
                                                        </div>
                                                    </div>
                                                </ul>
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