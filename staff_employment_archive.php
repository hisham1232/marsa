<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            $dropdown = new DbaseManipulation;                                 
            $header_info = new DbaseManipulation;
            if(isset($_GET['id'])) { //Mali ito, temporary lang ito muna, ayusin katulad ng ginawa sa HR 2.0
                $id = $header_info->cleanString($_GET['id']);
                $info = $header_info->singleReadFullQry("
                SELECT s.id, s.staffId, s.civilId, s.ministryStaffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.salutation, s.firstName, s.secondName, s.thirdName, s.lastName, s.firstNameArabic, s.secondNameArabic, s.thirdNameArabic, s.lastNameArabic, s.gender, s.maritalStatus, s.birthdate, s.joinDate, n.name as nationality, s.nationality_id, d.name as department, e.department_id, sc.name as section, e.section_id, j.name as jobtitle, e.jobtitle_id, p.title as staff_position, e.position_id, st.name as status, e.status_id, sp.name as specialization, e.specialization_id, q.name as qualification, e.qualification_id, spo.name as sponsor, e.sponsor_id, slr.name as salarygrade, e.salarygrade_id, e.employmenttype_id, pc.name as position_category, e.position_category_id 
                FROM staff as s 
                LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id 
                LEFT OUTER JOIN department as d ON d.id = e.department_id 
                LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id
                LEFT OUTER JOIN staff_position as p ON p.id = e.position_id
                LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id 
                LEFT OUTER JOIN status as st ON st.id = e.status_id 
                LEFT OUTER JOIN specialization as sp ON sp.id = e.specialization_id 
                LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id
                LEFT OUTER JOIN sponsor as spo ON spo.id = e.sponsor_id
                LEFT OUTER JOIN salarygrade as slr ON slr.id = e.salarygrade_id
                LEFT OUTER JOIN position_category as pc ON pc.id = e.position_category_id
                WHERE s.id = $id
                ");
                
                $mobile = $header_info->getContactInfo(1,$info['staffId'],'data');
                $email_add = $header_info->getContactInfo(2,$info['staffId'],'data');
            } else {
                header("Location: staff_list_active.php");
            }
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
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Employment History (NCT)</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Details </li>
                                        <li class="breadcrumb-item">Staff Employment</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                        <div class="card border-success">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="profiletimeline">
                                                        <div class="sl-item">
                                                            <div class="sl-left"> <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$info['staffId'].'.jpg'; ?>" alt="Staff" class="img-circle"/> </div>
                                                            <div class="sl-right">
                                                                <div>
                                                                    <a href="#" class="link"><?php echo $info['staffName']; ?></a> <span class="sl-date text-primary">[Staff ID : <?php echo $info['staffId']; ?>]</span>
                                                                    <div class="like-comm">
                                                                        <a href="javascript:void(0)" class="link m-r-5"><?php echo $info['jobtitle']; ?></a> | 
                                                                        <a href="javascript:void(0)" class="link m-r-5"><?php echo $info['section']; ?></a> |
                                                                        <a href="javascript:void(0)" class="link m-r-5"><?php echo $info['department']; ?></a> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!--end profiletimeline-->
                                                </div>    
                                            </div><!--end row-->
                                        </div><!--end card header-->

                                        <div class="card-body">
                                            <div class="btn-toolbar btn-block" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group" role="group" aria-label="First group">
                                                    <a class="btn btn-secondary" href="staff_details_archive.php?id=<?php echo $id; ?>" title="Click to view Staff Details" role="button"><span class="hidden-sm-up"><i class="fas fa-user-md"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Staff Details</a>

                                                    <a class="btn btn-info" href="?id=<?php echo $id; ?>" title="Click to view Employment History" role="button"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Employment History</a>
                                                    <a class="btn btn-secondary" href="staff_legal_documents.php?id=<?php echo $id; ?>" title="Click to view Legal Documents" role="button"><span class="hidden-sm-up"><i class="far fa-credit-card"></i></span> <span class="hidden-xs-down"> <i class="ti-angle-double-down"></i> Legal Documents</a>
                                                    <a class="btn btn-secondary" href="staff_qualification.php?id=<?php echo $id; ?>" title="Click to view Staff Qualification" role="button"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Qualification</a>
                                                    <a class="btn btn-secondary" href="staff_work_experience.php?id=<?php echo $id; ?>" title="Click to view Staff Work Experience" role="button"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Work Experience</a>
                                                    <a class="btn btn-secondary" href="staff_researches.php?id=<?php echo $id; ?>" title="Click to view Staff Researches" role="button"><span class="hidden-sm-up"><i class="ti-clipboard"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Researches</a>    
                                                    <a class="btn btn-secondary" href="staff_contacts.php?id=<?php echo $id; ?>" title="Click to view Staff Contacts" role="button"><span class="hidden-sm-up"><i class="far fa-address-book"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Contacts</a>    
                                                    <a class="btn btn-secondary" href="staff_family.php?id=<?php echo $id; ?>" title="Click to view Staff Family Information" role="button"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Family Information</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <?php
                                                    if( isset($_GET['id'], $_GET['edit'], $_GET['eid']) ) {
                                                        if($_GET['edit'] == md5('yes')){
                                                ?>
                                                            <div class="col-lg-5">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <?php
                                                                            if(isset($_POST['submitUpdateEmployment'])){
                                                                                $save = new DbaseManipulation; 
                                                                                $eid = $save->cleanString($_GET['eid']);
                                                                                $staff_id = $save->cleanString($_POST['staff_id']);
                                                                                $status_id = $save->cleanString($_POST['status_id']);
                                                                                $department_id = $save->cleanString($_POST['department_id']); //required
                                                                                $section_id = $save->cleanString($_POST['section_id']);
                                                                                $jobtitle_id = $save->cleanString($_POST['jobtitle_id']);
                                                                                $sponsor_id = $save->cleanString($_POST['sponsor_id']);
                                                                                $salarygrade_id = $save->cleanString($_POST['salarygrade_id']);
                                                                                $employmenttype_id = $save->cleanString($_POST['employmenttype_id']);
                                                                                $specialization_id = $save->cleanString($_POST['specialization_id']);
                                                                                $qualification_id = $save->cleanString($_POST['qualification_id']);
                                                                                $position_id = $save->cleanString($_POST['position_id']);
                                                                                $position_category_id = $save->cleanString($_POST['position_category_id']);
                                                                                $joinDate = $save->cleanString($_POST['joinDate']);
                                                                                $joinDate = $save->mySQLDate($joinDate);
                                                                                $registrationCardNo = $save->cleanString($_POST['registrationCardNo']);
                                                                                $isCurrent = $save->cleanString($_POST['isCurrent']);

                                                                                $fields = [
                                                                                    'staff_id'=>$staff_id,
                                                                                    'registrationCardNo'=>$registrationCardNo,
                                                                                    'joinDate'=>$joinDate,
                                                                                    'isCurrent'=>$isCurrent,
                                                                                    'status_id'=>$status_id,
                                                                                    'department_id'=>$department_id,
                                                                                    'section_id'=>$section_id,
                                                                                    'jobtitle_id'=>$jobtitle_id,
                                                                                    'sponsor_id'=>$sponsor_id,
                                                                                    'salarygrade_id'=>$salarygrade_id,
                                                                                    'employmenttype_id'=>$employmenttype_id,
                                                                                    'specialization_id'=>$specialization_id,
                                                                                    'qualification_id'=>$qualification_id,
                                                                                    'position_id'=>$position_id,
                                                                                    'position_category_id'=>$position_category_id
                                                                                ];
                                                                                
                                                                                //Di pwedeng i disable ang isCurrent kasi dapat at least meron isang active.
                                                                                $ministryStaffId = $save->cleanString($_POST['ministryStaffId']);    
                                                                                if($save->update("employmentdetail",$fields,$eid)){
                                                                                    
                                                                                    if($ministryStaffId != ""){
                                                                                        $field = [
                                                                                            'ministryStaffId'=>$ministryStaffId
                                                                                        ];
                                                                                        $save->update("staff",$field,$id);
                                                                                    }
                                                                        ?>
                                                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                                        <p>Staff employment details (department, section, position, job title, etc.) has been changed and updated successfully!</p>
                                                                                    </div>
                                                                        <?php            
                                                                                }         
                                                                            }
                                                                        ?>
                                                                        <div>
                                                                            <div>
                                                                                <?php
                                                                                    $eid = $_GET['eid'];
                                                                                    $info = $header_info->singleReadFullQry("
                                                                                    SELECT s.id, s.staffId, s.civilId, s.ministryStaffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.salutation, s.firstName, s.secondName, s.thirdName, s.lastName, s.firstNameArabic, s.secondNameArabic, s.thirdNameArabic, s.lastNameArabic, s.gender, s.maritalStatus, s.birthdate, s.joinDate, n.name as nationality, s.nationality_id, d.name as department, e.department_id, sc.name as section, e.section_id, j.name as jobtitle, e.jobtitle_id, p.title as staff_position, e.position_id, st.name as status, e.status_id, sp.name as specialization, e.specialization_id, q.name as qualification, e.qualification_id, spo.name as sponsor, e.sponsor_id, slr.name as salarygrade, e.salarygrade_id, e.employmenttype_id, pc.name as position_category, e.position_category_id, e.joinDate as empStatusDate, e.isCurrent
                                                                                    FROM staff as s 
                                                                                    LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id 
                                                                                    LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                                                                    LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                                                                                    LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id
                                                                                    LEFT OUTER JOIN staff_position as p ON p.id = e.position_id
                                                                                    LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id 
                                                                                    LEFT OUTER JOIN status as st ON st.id = e.status_id 
                                                                                    LEFT OUTER JOIN specialization as sp ON sp.id = e.specialization_id 
                                                                                    LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id
                                                                                    LEFT OUTER JOIN sponsor as spo ON spo.id = e.sponsor_id
                                                                                    LEFT OUTER JOIN salarygrade as slr ON slr.id = e.salarygrade_id
                                                                                    LEFT OUTER JOIN position_category as pc ON pc.id = e.position_category_id
                                                                                    WHERE e.id = $eid
                                                                                    ");
                                                                                ?>
                                                                                <div><h3 class="card-title"><i class="fa fa-edit"></i> Edit Employment History Form <span style="float: right"><a href="?id=<?php echo $id; ?>" class="btn btn-info"><i class="fa fa-undo"></i> Back</a></span></h3></div>
                                                                            </div>
                                                                            <form class="form-horizontal p-t-20" id="editEmploymentForm" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Department</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <input type="hidden" name="staff_id" value="<?php echo $info['staffId']; ?>" />
                                                                                                <select name="department_id" class="form-control select2" required data-validation-required-message="Please select department">
                                                                                                    <option value="">Select Department</option>
                                                                                                    <?php 
                                                                                                        $departments = new DbaseManipulation;
                                                                                                        $rows = $departments->readData("SELECT id, name FROM department");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['department_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['department_id']; ?>" selected><?php echo $info['department']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select> 
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Section</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="section_id" class="form-control select2">
                                                                                                    <option value="">Select Section</option>
                                                                                                    <?php 
                                                                                                        $sections = new DbaseManipulation;
                                                                                                        $rows = $sections->readData("SELECT id, name FROM section");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['section_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['section_id']; ?>" selected><?php echo $info['section']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Job Title</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="jobtitle_id" class="form-control select2">
                                                                                                    <option value="">Select Job Title</option>
                                                                                                    <?php 
                                                                                                        $jobs = new DbaseManipulation;
                                                                                                        $rows = $jobs->readData("SELECT id, name FROM jobtitle");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['jobtitle_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['jobtitle_id']; ?>" selected><?php echo $info['jobtitle']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>  
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>College Position</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="position_id" class="form-control select2">
                                                                                                    <option value="">Select College Position</option>
                                                                                                    <?php 
                                                                                                        $staff_position = new DbaseManipulation;
                                                                                                        $rows = $staff_position->readData("SELECT id, code, title FROM staff_position");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['position_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['position_id']; ?>" selected><?php echo $info['staff_position']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>  
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Position Category</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="position_category_id" class="form-control select2">
                                                                                                    <option value="">Select Position Category</option>
                                                                                                    <?php 
                                                                                                        $staff_position_category = new DbaseManipulation;
                                                                                                        $rows = $staff_position_category->readData("SELECT id, name FROM position_category WHERE active = 1 ORDER BY id");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['position_category_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['position_category_id']; ?>" selected><?php echo $info['position_category']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>
                                                                                                 
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Sponsor</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="sponsor_id" class="form-control select2">
                                                                                                    <option value="">Select Sponsor</option>
                                                                                                    <?php 
                                                                                                        $sponsor = new DbaseManipulation;
                                                                                                        $rows = $sponsor->readData("SELECT id, name FROM sponsor");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['sponsor_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['sponsor_id']; ?>" selected><?php echo $info['sponsor']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>            
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right">Salary Grade</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="salarygrade_id" class="form-control select2">
                                                                                                    <option value="0">Select Salary Grade</option>
                                                                                                    <?php 
                                                                                                        $salarygrade = new DbaseManipulation;
                                                                                                        $rows = $salarygrade->readData("SELECT id, name FROM salarygrade");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['salarygrade_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['salarygrade_id']; ?>" selected><?php echo $info['salarygrade']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>                
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right">Specialization</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="specialization_id" class="form-control select2">
                                                                                                    <option value="0">Select Specialization</option>
                                                                                                    <?php 
                                                                                                        $specialization = new DbaseManipulation;
                                                                                                        $rows = $specialization->readData("SELECT id, name FROM specialization");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['specialization_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['specialization_id']; ?>" selected><?php echo $info['specialization']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>                
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right">Qualification</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="qualification_id" class="form-control select2">
                                                                                                    <option value="0">Select Qualification</option>
                                                                                                    <?php 
                                                                                                        $qualification = new DbaseManipulation;
                                                                                                        $rows = $qualification->readData("SELECT id, name FROM qualification");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['qualification_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['qualification_id']; ?>" selected><?php echo $info['qualification']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>                
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Status</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="status_id" class="form-control select2">
                                                                                                    <?php 
                                                                                                        $statuses = new DbaseManipulation;
                                                                                                        $rows = $statuses->readData("SELECT id, name FROM status");
                                                                                                        foreach ($rows as $row) {
                                                                                                            if($info['status_id'] == $row['id']) {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $info['status_id']; ?>" selected><?php echo $info['status']; ?></option>
                                                                                                    <?php            
                                                                                                            } else {
                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                    <?php           
                                                                                                            } 
                                                                                                        }    
                                                                                                    ?>
                                                                                                </select>                
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right">Employment Type</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="employmenttype_id" class="form-control select2">
                                                                                                    <?php
                                                                                                        $employments = array("1", "2");
                                                                                                        foreach ($employments as $row) {
                                                                                                            if($info['employmenttype_id'] == $row) {
                                                                                                                if($info['employmenttype_id'] == 1) {
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $info['employmenttype_id']; ?>" selected><?php echo "Full Time"; ?></option>
                                                                                                    <?php
                                                                                                                } else {        
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $info['employmenttype_id']; ?>" selected><?php echo "Part Time"; ?></option>
                                                                                                    <?php    
                                                                                                                }    
                                                                                                            } else {
                                                                                                                if($info['employmenttype_id'] == 2) {
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $row; ?>"><?php echo "Full Time"; ?></option>
                                                                                                    <?php
                                                                                                                } else {
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $row; ?>"><?php echo "Part Time"; ?></option>
                                                                                                    <?php                
                                                                                                                }                
                                                                                                            }
                                                                                                        }        
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Emp. Status Date</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                            <input type="text" class="form-control" name="joinDate" id="status_date" value="<?php echo date('d/m/Y',strtotime($info['empStatusDate'])); ?>" required data-validation-required-message="Please enter employment status date"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <!-- <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Registration Card</label> -->
                                                                                    <label for="" class="col-sm-4 control-label text-right">Registration Card</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                            <!-- <input type="text" class="form-control" name="reg_card" required data-validation-required-message="Please enter Registration Card No"/> -->
                                                                                            <?php
                                                                                                $sid = $info['staffId'];
                                                                                                $regNo = $header_info->singleReadFullQry("SELECT TOP 1 registrationCardNo FROM employmentdetail WHERE staff_id = '$sid' ORDER BY id DESC");
                                                                                            ?>
                                                                                            <input type="text" class="form-control" name="registrationCardNo" value="<?php echo $regNo['registrationCardNo']; ?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <!-- <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Ministry Staff ID</label> -->
                                                                                    <label for="" class="col-sm-4 control-label text-right">Ministry Staff ID</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                            <!-- <input type="text" class="form-control" name="min_staff_id" required data-validation-required-message="Please enter Ministry Staff ID"/> -->
                                                                                            <input type="text" class="form-control" name="ministryStaffId" value="<?php echo $dropdown->fieldNameValue("staff",$id,"ministryStaffId"); ?>" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Emp. History Status</label>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                                <select name="isCurrent" class="form-control select2" required data-validation-required-message="Please select employment history status">
                                                                                                    <?php
                                                                                                        $employments = array("0", "1");
                                                                                                        foreach ($employments as $row) {
                                                                                                            if($info['isCurrent'] == $row) {
                                                                                                                if($info['isCurrent'] == 1) {
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $info['isCurrent']; ?>" selected><?php echo "Active"; ?></option>
                                                                                                    <?php
                                                                                                                } else {        
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $info['isCurrent']; ?>" selected><?php echo "Not Active"; ?></option>
                                                                                                    <?php    
                                                                                                                }    
                                                                                                            } else {
                                                                                                                if($info['isCurrent'] == 0) {
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $row; ?>"><?php echo "Active"; ?></option>
                                                                                                    <?php
                                                                                                                } else {
                                                                                                    ?>
                                                                                                                    <option value="<?php echo $row; ?>"><?php echo "Not Active"; ?></option>
                                                                                                    <?php                
                                                                                                                }                
                                                                                                            }
                                                                                                        }        
                                                                                                    ?>
                                                                                                </select>  
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row m-b-0">
                                                                                    <div class="offset-sm-4 col-sm-8">
                                                                                        <button type="submit" name="submitUpdateEmployment" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                                        <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
                                                                                    </div>
                                                                                </div>
                                                                            </form><!--end form-->
                                                                        </div>        
                                                                    </div>
                                                                </div>
                                                            </div>        
                                                <?php        
                                                        }   
                                                    } else {
                                                ?>
                                                        <div class="col-lg-5">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <?php
                                                                        if(isset($_POST['submitEmployment'])){
                                                                            $save = new DbaseManipulation; 
                                                                            $staff_id = $save->cleanString($_POST['staff_id']);
                                                                            $status_id = $save->cleanString($_POST['status_id']);
                                                                            $department_id = $save->cleanString($_POST['department_id']); //required
                                                                            $section_id = $save->cleanString($_POST['section_id']);
                                                                            $jobtitle_id = $save->cleanString($_POST['jobtitle_id']);
                                                                            $sponsor_id = $save->cleanString($_POST['sponsor_id']);
                                                                            $salarygrade_id = $save->cleanString($_POST['salarygrade_id']);
                                                                            $employmenttype_id = $save->cleanString($_POST['employmenttype_id']);
                                                                            $specialization_id = $save->cleanString($_POST['specialization_id']);
                                                                            $qualification_id = $save->cleanString($_POST['qualification_id']);
                                                                            $position_id = $save->cleanString($_POST['position_id']);
                                                                            $position_category_id = $save->cleanString($_POST['position_category_id']);
                                                                            $joinDate = $save->cleanString($_POST['joinDate']);
                                                                            $joinDate = $save->mySQLDate($joinDate);
                                                                            $registrationCardNo = $save->cleanString($_POST['registrationCardNo']);
                                                                            $isCurrent = $save->cleanString($_POST['isCurrent']);

                                                                            $fields = [
                                                                                'staff_id'=>$staff_id,
                                                                                'registrationCardNo'=>$registrationCardNo,
                                                                                'joinDate'=>$joinDate,
                                                                                'isCurrent'=>$isCurrent,
                                                                                'status_id'=>$status_id,
                                                                                'department_id'=>$department_id,
                                                                                'section_id'=>$section_id,
                                                                                'jobtitle_id'=>$jobtitle_id,
                                                                                'sponsor_id'=>$sponsor_id,
                                                                                'salarygrade_id'=>$salarygrade_id,
                                                                                'employmenttype_id'=>$employmenttype_id,
                                                                                'specialization_id'=>$specialization_id,
                                                                                'qualification_id'=>$qualification_id,
                                                                                'position_id'=>$position_id,
                                                                                'position_category_id'=>$position_category_id
                                                                            ];
                                                                            $ministryStaffId = $save->cleanString($_POST['ministryStaffId']);
                                                                            if($isCurrent == 1) {
                                                                                $save->executeSQL("UPDATE employmentdetail SET isCurrent = 0 WHERE staff_id = '$staff_id'");
                                                                            }    
                                                                            if($save->insert("employmentdetail",$fields)){
                                                                                if($ministryStaffId != ""){
                                                                                    $field = [
                                                                                        'ministryStaffId'=>$ministryStaffId
                                                                                    ];
                                                                                    $save->update("staff",$field,$id);
                                                                                }
                                                                        ?>
                                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                                            <p>Staff employment details (department, section, position, job title, etc.) has been changed and updated successfully!</p>
                                                                        </div>
                                                                        <?php            
                                                                            }         
                                                                        }
                                                                    ?>
                                                                    <div>
                                                                        <div>
                                                                            <div><h3 class="card-title">Employment History Form <span style="float: right"><button class="btn btn-info btnShowEmploymentForm"><i class="fa fa-edit"></i> Add New</button></span></h3></div>
                                                                        </div>
                                                                        <form class="form-horizontal p-t-20" id="employmentForm" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Department</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="hidden" name="staff_id" value="<?php echo $info['staffId']; ?>" />
                                                                                            <select name="department_id" class="form-control select2" required data-validation-required-message="Please select department">
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Section</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="section_id" class="form-control select2" required data-validation-required-message="Please select section">
                                                                                                <option value="">Select Section</option>
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Job Title</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="jobtitle_id" class="form-control select2" required data-validation-required-message="Please select job title">
                                                                                                <option value="">Select Job Title</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM jobtitle WHERE active = 1 ORDER BY id");
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>College Position</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="position_id" class="form-control select2" required data-validation-required-message="Please select college position">
                                                                                                <option value="">Select College Position</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, code, title FROM staff_position WHERE active = 1 ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>  
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Position Category</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="position_category_id" class="form-control select2" required data-validation-required-message="Please select position category">
                                                                                                <option value="">Select Position Category</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM position_category WHERE active = 1 ORDER BY id");
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Sponsor</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="sponsor_id" class="form-control select2" required data-validation-required-message="Please select sponsor">
                                                                                                <option value="">Select Sponsor</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM sponsor WHERE active = 1 ORDER BY id");
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right">Salary Grade</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="salarygrade_id" class="form-control select2">
                                                                                                <option value="0">Select Salary Grade</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM salarygrade WHERE active = 1 ORDER BY id");
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right">Specialization</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="specialization_id" class="form-control select2">
                                                                                                <option value="0">Select Specialization</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM specialization WHERE active = 1 ORDER BY id");
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right">Qualification</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="qualification_id" class="form-control select2">
                                                                                                <option value="0">Select Qualification</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM qualification WHERE active = 1 ORDER BY id");
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="status_id" class="form-control select2" required data-validation-required-message="Please select status">
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM status WHERE active = 1 ORDER BY id");
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
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right">Employment Type</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="employmenttype_id" class="form-control select2">
                                                                                                <!-- <option value="0">Select Employment</option> -->
                                                                                                <option value="1">Full Time</option>
                                                                                                <option value="2">Part Time</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Emp. Status Date</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                        <input type="text" class="form-control" name="joinDate" id="status_date" required data-validation-required-message="Please enter employment status date"/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <!-- <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Registration Card</label> -->
                                                                                <label for="" class="col-sm-4 control-label text-right">Registration Card</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                        <!-- <input type="text" class="form-control" name="reg_card" required data-validation-required-message="Please enter Registration Card No"/> -->
                                                                                        <?php
                                                                                            $sid = $info['staffId'];
                                                                                            $regNo = $header_info->singleReadFullQry("SELECT TOP 1 registrationCardNo FROM employmentdetail WHERE staff_id = '$sid' ORDER BY id DESC");
                                                                                        ?>
                                                                                        <input type="text" class="form-control" name="registrationCardNo" value="<?php echo $regNo['registrationCardNo']; ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <!-- <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Ministry Staff ID</label> -->
                                                                                <label for="" class="col-sm-4 control-label text-right">Ministry Staff ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                        <!-- <input type="text" class="form-control" name="min_staff_id" required data-validation-required-message="Please enter Ministry Staff ID"/> -->
                                                                                        <input type="text" class="form-control" name="ministryStaffId" value="<?php echo $dropdown->fieldNameValue("staff",$id,"ministryStaffId"); ?>" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row">
                                                                                <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Emp. History Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                        <select name="isCurrent" class="form-control" required data-validation-required-message="Please select employment history status">
                                                                                            <option value="1">Active</option>
                                                                                            <option value="0">Not Active</option>
                                                                                        </select>  
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row m-b-0">
                                                                                <div class="offset-sm-4 col-sm-8">
                                                                                    <button type="submit" name="submitEmployment" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                                    <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
                                                                                </div>
                                                                            </div>
                                                                        </form><!--end form-->
                                                                    </div>        
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                ?>                                                                                                
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->
                                                <div class="col-lg-7">
                                                    <div class="card">
                                                        <div class="card-body">                      
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Employment History Entry List (Inside NCT)</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Job Title</th>
                                                                            <th>Department</th>
                                                                            <th>Start Date</th>
                                                                            <th>Status</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            $staff_id = $info['staffId'];
                                                                            $getEmpHist = new DbaseManipulation;
                                                                            $rows = $getEmpHist->readData("
                                                                            SELECT e.id, e.joinDate as startDate, e.isCurrent, d.name as department, sc.name as section, j.name as jobtitle
                                                                            FROM employmentdetail as e 
                                                                            LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                                                            LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                                                                            LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id
                                                                            WHERE e.staff_id = '$staff_id' ORDER BY e.id DESC
                                                                            ");
                                                                            if($getEmpHist->totalCount != 0) {
                                                                                $no = 1;
                                                                                foreach($rows as $row) {
                                                                                    $aydee = $row['id'];
                                                                        ?>                        
                                                                                    <tr>
                                                                                        <td><?php echo $no.'.'; ?></td>
                                                                                        <td><span class="text-primary font-weight-bold"><?php echo $row['jobtitle']; ?></span></td>
                                                                                        <td><?php echo $row['department']; ?></td>
                                                                                        <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                                        <td>
                                                                                            <?php 
                                                                                                if ($row['isCurrent'] == 1) 
                                                                                                    echo '<span class="text-success font-weight-bold">Active</span>'; 
                                                                                                else 
                                                                                                echo '<span class="text-danger">Not Active</span>';
                                                                                            ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php
                                                                                                //if($row['isCurrent'] == 1)
                                                                                                    echo '<a href="staff_employment_archive.php?id='.$id.'&edit='.md5("yes").'&eid='.$aydee.'" title="Click to edit this information" class="btn btn btn-outline-primary btn-sm" ><i class="fas fa-edit fa-2x"></i></a>';
                                                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                        <?php
                                                                                    $no++;
                                                                                }
                                                                            } else {
                                                                        ?>
                                                                                <tr>
                                                                                    <td colspan="5">No employment history found in the system!</td>
                                                                                </tr>        
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div><!--end table-responsive-->                     
                                                        </div><!--end card list-->
                                                    </div><!--end card approval-->
                                                </div><!--end col-lg-7 for list details-->
                                            </div>
                                        </div>
                                    </div><!--end card card-->
                                </div><!--end col 12-->
                            </div><!--end row-->
                        </div>

                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>  
                <script>
                    $('#status_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>