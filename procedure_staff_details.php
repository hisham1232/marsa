<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            $dropdown = new DbaseManipulation;                                 
            $header_info = new DbaseManipulation;
            if(isset($_GET['id'])) { //Mali ito, temporary lang ito muna, ayusin katulad ng ginawa sa HR 2.0
                $id = $header_info->cleanString($_GET['id']);
                $info = $header_info->singleReadFullQry("CALL getOneActiveStaff($id);");
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Information Details (Stored Procedure/ONE PARAM)</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Staff Details </li>
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
                                                                    <div><a href="#" class="link"><?php echo $info['staffName']; ?></a> <span class="sl-date text-primary">[Staff ID : <?php echo $info['staffId']; ?>]</span>
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
                                                        <a class="btn btn-info" href="staff_details.php" title="Click to view Staff Details" role="button"><span class="hidden-sm-up"><i class="fas fa-user-md"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Staff Details</a>
                                                        <a class="btn btn-secondary" href="staff_employment.php" title="Click to view Employment History" role="button"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Employment History</a>
                                                        <a class="btn btn-secondary" href="staff_legal_documents.php" title="Click to view Legal Documents" role="button"><span class="hidden-sm-up"><i class="far fa-credit-card"></i></span> <span class="hidden-xs-down"> <i class="ti-angle-double-down"></i>Legal Documents</a>
                                                        <a class="btn btn-secondary" href="staff_qualification.php" title="Click to view Staff Qualification" role="button"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Qualification</a>
                                                        <a class="btn btn-secondary" href="staff_work_experience.php" title="Click to view Staff Work Experience" role="button"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Work Experience</a>
                                                        <a class="btn btn-secondary" href="staff_researches.php" title="Click to view Staff Researches" role="button"><span class="hidden-sm-up"><i class="ti-clipboard"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Researches</a>    
                                                        <a class="btn btn-secondary" href="staff_contacts.php" title="Click to view Staff Contacts" role="button"><span class="hidden-sm-up"><i class="far fa-address-book"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Contacts</a>    
                                                        <a class="btn btn-secondary" href="staff_family.php" title="Click to view Staff Family Information" role="button"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Family Information</a>    
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="m-b-0">Staff Details Form</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <form  class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                    <div class="row">
                                                                        <!--First Column col-lg-4-->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Title</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="salutation" class="form-control select2" required data-validation-required-message="Please select title">
                                                                                                <option value="">Select Title</option>
                                                                                                <option value="Mr.">Mr.</option>
                                                                                                <option value="Mrs.">Mrs.</option>
                                                                                                <option value="Ms.">Ms.</option>
                                                                                                <option value="Dr.">Dr.</option>
                                                                                            </select>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>First Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="firstName" class="form-control" required data-validation-required-message="Please enter first name"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Second Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="secondName" class="form-control" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Third Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="thirdName" class="form-control"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Last Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="lastName" class="form-control" required data-validation-required-message="Please enter last name"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic First Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="firstNameArabic" class="form-control" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic Second Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="secondNameArabic" class="form-control" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic Third Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="thirdNameArabic" class="form-control"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Arabic Last Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="lastNameArabic" class="form-control"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                        </div>
                                                                        <!--End First Column col-lg-4-->
                                                                        
                                                                        <!--Second Column col-lg-4-->
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Staff ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="staffId" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="7"/>  
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Civil ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="civilId" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="9"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Ministry ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="ministryStaffId" class="form-control" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Gender</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="gender" class="form-control select2">
                                                                                                <option value="">Select Gender</option>
                                                                                                <option value="Male">Male</option>
                                                                                                <option value="Female">Female</option>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Marital Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="maritalStatus" class="form-control select2">
                                                                                                <option value="">Select Marital Status</option>
                                                                                                <option value="Single">Single</option>
                                                                                                <option value="Married">Married</option>
                                                                                                <option value="Divorced">Divorced</option>
                                                                                                <option value="Widowed">Widowed</option>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Nationality</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="nationality_id" class="form-control select2">
                                                                                                <option value="">Select Nationality</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM nationality ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Birth Date</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text"  class="form-control" name="birthdate" id="birthday_date"/>   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>GSM</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="gsm" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Numeric values only" maxlength="8" />   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Email Address</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="email" class="form-control" data-validation-regex-regex="([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})" data-validation-regex-message="Enter Valid Email">   
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Join Date</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <!--<input type="date"  class="form-control"/>   -->
                                                                                            <input type="text" class="form-control" name="joinDate" id="join_date" required data-validation-required-message="Please enter joining date"/>
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                        </div>
                                                                        <!--End Second Column col-lg-4-->
                                                                        
                                                                        <!--Third Column col-lg-4-->    
                                                                        <div class="col-lg-4">
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Department</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="department_id" class="form-control select2" required data-validation-required-message="Please select department">
                                                                                                <option value="0">Select Department</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM department ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Section</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="section_id" class="form-control select2">
                                                                                                <option value="0">Select Section</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM section ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>  
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Specialization</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="specialization_id" class="form-control select2">
                                                                                                <option value="0">Select Specialization</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM specialization ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Job Title</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="jobtitle_id" class="form-control select2">
                                                                                                <option value="0">Select Job Title</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM jobtitle ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">College Position</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="position_id" class="form-control select2">
                                                                                                <option value="0">Select College Position</option>
                                                                                                <option value="1">College Position 1</option>
                                                                                                <option value="2">College Position 2</option>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Qualification</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="qualification_id" class="form-control select2">
                                                                                                <option value="0">Select Qualification</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM qualification ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Sponsor</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="sponsor_id" class="form-control select2">
                                                                                                <option value="0">Select Sponsor</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM sponsor ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Salary Grade</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="salarygrade_id" class="form-control select2">
                                                                                                <option value="0">Select Salary Grade</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM salarygrade ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Employment</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="employmenttype_id" class="form-control select2">
                                                                                                <option value="0">Select Employment</option>
                                                                                                <option value="1">Full Time</option>
                                                                                                <option value="2">Part Time</option>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 text-right control-label col-form-label">Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="controls">
                                                                                        <div class="input-group">
                                                                                            <select name="status_id" class="form-control select2">
                                                                                                <option value="0">Select Status</option>
                                                                                                <?php 
                                                                                                    $rows = $dropdown->readData("SELECT id, name FROM status ORDER BY id");
                                                                                                    foreach ($rows as $row) {
                                                                                                ?>
                                                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                                                <?php            
                                                                                                    }    
                                                                                                ?>
                                                                                            </select>    
                                                                                        </div><!--end input-group-->
                                                                                    </div><!--end controls-->
                                                                                </div><!--end col-sm-8-->
                                                                            </div>                                   
                                                                            <div class="form-group m-b-0">
                                                                                <div class="offset-sm-4 col-sm-8">
                                                                                    <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                                    <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--End Third Column col-lg-4-->
                                                                    </div><!--end row for form-->  
                                                                </form>
                                                            </div><!--end card body-->
                                                        </div><!--end card for outline-info--> 
                                                    </div>       
                                                </div><!--end row for whole-->   
                                            </div><!--end card body-->
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
                // Material Date picker    
                    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });

                    $('.daterange').daterangepicker();
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>