<?php    
    include('include_headers.php');
    $dropdown = new DbaseManipulation;
    error_reporting(E_ALL);                                 
?>  
<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
        <?php   include('menu_top.php'); ?>   
        </header>
        <?php   include('menu_left.php'); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Add New Staff Record Entry Form</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">College Staff</li>
                            <li class="breadcrumb-item active">Add New Staff</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add New Staff Form</h4>
                            </div>
                            <div class="card-body">
                                <?php 
                                    if(isset($_POST['submitFromGenerateId'])){
                                        $newStaffId = $_POST['bagoId'];
                                        echo $newStaffId;
                                    }    
                                ?>
                                <?php 
                                    if(isset($_POST['submit'])) {
                                        $save = new DbaseManipulation;
                                        
                                        $staffId = $save->cleanString($_POST['staffId']); //required
                                        $civilId = $save->cleanString($_POST['civilId']); //required
                                        $ministryStaffId = $save->cleanString($_POST['ministryStaffId']);

                                        $salutation = $save->cleanString($_POST['salutation']); //required
                                        $firstName = $save->cleanString($_POST['firstName']); //required
                                        $secondName = $save->cleanString($_POST['secondName']);
                                        $thirdName = $save->cleanString($_POST['thirdName']);
                                        $lastName = $save->cleanString($_POST['lastName']); //required

                                        $firstNameArabic = $save->cleanString($_POST['firstNameArabic']);
                                        $secondNameArabic = $save->cleanString($_POST['secondNameArabic']);
                                        $thirdNameArabic = $save->cleanString($_POST['thirdNameArabic']);
                                        $lastNameArabic = $save->cleanString($_POST['lastNameArabic']);    
                                        
                                        $birthdate = $save->cleanString($_POST['birthdate']);
                                        $birthdate = $save->mySQLDate($birthdate);
                                        $gender = $save->cleanString($_POST['gender']);
                                        $joinDate = $save->cleanString($_POST['joinDate']);
                                        $joinDate = $save->mySQLDate($joinDate);
                                        $maritalStatus = $save->cleanString($_POST['maritalStatus']);

                                        $status_id = $save->cleanString($_POST['status_id']);
                                        $nationality_id = $save->cleanString($_POST['nationality_id']);
                                        $department_id = $save->cleanString($_POST['department_id']); //required
                                        $section_id = $save->cleanString($_POST['section_id']);
                                        $specialization_id = $save->cleanString($_POST['specialization_id']);
                                        $jobtitle_id = $save->cleanString($_POST['jobtitle_id']);
                                        $qualification_id = $save->cleanString($_POST['qualification_id']);
                                        $sponsor_id = $save->cleanString($_POST['sponsor_id']);
                                        $salarygrade_id = $save->cleanString($_POST['salarygrade_id']);
                                        $employmenttype_id = $save->cleanString($_POST['employmenttype_id']);
                                        $position_id = $save->cleanString($_POST['position_id']);

                                        $fields = [
                                            'staffId'=>$staffId,
                                            'civilId'=>$civilId,
                                            'ministryStaffId'=>$ministryStaffId,
                                            'salutation'=>$salutation,
                                            'firstName'=>$firstName,
                                            'secondName'=>$secondName,
                                            'thirdName'=>$thirdName,
                                            'lastName'=>$lastName,
                                            'firstNameArabic'=>$firstNameArabic,
                                            'secondNameArabic'=>$secondNameArabic,
                                            'thirdNameArabic'=>$thirdNameArabic,
                                            'lastNameArabic'=>$lastNameArabic,
                                            'birthdate'=>$birthdate,
                                            'gender'=>$gender,
                                            'joinDate'=>$joinDate,
                                            'maritalStatus'=>$maritalStatus,
                                            'status_id'=>$status_id,
                                            'nationality_id'=>$nationality_id,
                                            'department_id'=>$department_id,
                                            'section_id'=>$section_id,
                                            'specialization_id'=>$specialization_id,
                                            'jobtitle_id'=>$jobtitle_id,
                                            'qualification_id'=>$qualification_id,
                                            'sponsor_id'=>$sponsor_id,
                                            'salarygrade_id'=>$salarygrade_id,
                                            'employmenttype_id'=>$employmenttype_id,
                                            'position_id'=>$position_id
                                        ];
                                        //echo $save->displayArr($fields);

                                        if($save->insert("staff",$fields)) {
                                            //1. Inserting info in stafffamily table [This ine should go first since most of the table below will be relevant here using stafffamily_id as foreign key]   


                                            //2. Inserting info in contact details table
                                            $save2 = new DbaseManipulation;    
                                            $gsm = $save2->cleanString($_POST['gsm']); //required, will be saved in contactdetails table
                                            $staff_id = 1; //get the id inserted in the staff table
                                            $contacttype_id = 1;
                                            $stafffamily_id = 1; //get the id inserted in the stafffamily table
                                            $data = $gsm;
                                            $isCurrent = 1;
                                            $isFamily = 0;
                                            
                                            $fields2 = [
                                                'staff_id'=>$staff_id,
                                                'contacttype_id'=>$contacttype_id,
                                                'stafffamily_id'=>$stafffamily_id,
                                                'data'=>$data,
                                                'isCurrent'=>$isCurrent,
                                                'isFamily'=>$isFamily
                                            ];
                                            //$save2->insert("contactdetails",$fields2);

                                            

                                            //3. Inserting Info to passport table (related tin staff and stafffamily table)

                                            //4. Creating default login in users table (related in staff table)

                                            //5. Creating new task
                                ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Success!</h4>
                                                <p>New staff has been added and saved! You may now provide different information related to the staff such as <strong>passport, visa, work experience</strong> etc.</p>
                                            </div>
                                <?php 
                                        }
                                    }
                                ?>    
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
                                                                <option value="M">Male</option>
                                                                <option value="F">Female</option>
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
                                                                <option value="1">Single</option>
                                                                <option value="2">Married</option>
                                                                <option value="3">Divorced</option>
                                                                <option value="4">Widowed</option>

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
                                            <?php /*
                                            <div class="form-group row">
                                                <label class="col-sm-4 text-right control-label col-form-label">Passport Number</label>
                                                <div class="col-sm-8">
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <input type="text" name="passport_number" class="form-control"/>   
                                                        </div><!--end input-group-->
                                                    </div><!--end controls-->
                                                </div><!--end col-sm-8-->
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 text-right control-label col-form-label">Passport Expiration</label>
                                                <div class="col-sm-8">
                                                    <div class="controls">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="passport_expiration_date" id="passport_expiration_date"/>   
                                                        </div><!--end input-group-->
                                                    </div><!--end controls-->
                                                </div><!--end col-sm-8-->
                                            </div>
                                            */ ?>
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
                                                                <<?php 
                                                                    $rows = $dropdown->readData("SELECT id, name FROM employmenttype ORDER BY id");
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
            </div>            
            <footer class="footer">
                <?php
                    include('include_footer.php'); 
                ?>
            </footer>
        </div>
    </div>
    
    <?php
        include('include_scripts.php');
    ?>

        <script>
            // MAterial Date picker    
            $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
            $('#birthday_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
            $('#passport_expiration_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
            $('#join_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
        </script>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
              <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Success</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    New department has been added and saved.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>