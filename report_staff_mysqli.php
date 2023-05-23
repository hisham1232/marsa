<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $dropdown = new DbaseManipulation;
?>
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Generate Staff Related Report</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Report Generation</li>
                                        <li class="breadcrumb-item">Staff Report</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    <div class="card">
                                        <div class="card-header bg-light-info">
                                            <div class="d-flex flex-wrap">
                                                <div>
                                                    <h3 class="card-title">Staff Related Record - Generate Report</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <strong><i class="fa fa-info-circle"></i> Step 1: </strong> Check the field name(s) you want to appear in your report.
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-3">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.staffId" name="field_select[]" class="custom-control-input" checked readonly onclick="return false;" onkeydown="e = e || window.event; if(e.keyCode !== 9) return false;" />
                                                                            <span class="custom-control-label">Staff ID</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.civilId" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Civil ID</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.ministryStaffId" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Ministry Staff ID</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="e.registrationCardNo" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Registration Card No</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.firstName" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">First Name</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.secondName" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Second Name</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.thirdName" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Third Name</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.lastName" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Last Name</span>
                                                                        </label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkJoinDate" value="s.joinDate" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Join Date</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="s.birthdate" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Birth Date </span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkGender" value="s.gender" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Gender</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkNationality" value="n.name as nationality" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Nationality</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="cd.data as email" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Email</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="cd2.data as GSM" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">GSM</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkPosition" value="p.title as college_position" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">College Position</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkPositionCat" value="pc.name as position_category" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Position Category</span>
                                                                        </label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkStatus" value="st.name as status" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Status</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkDepartment" value="d.name as department" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Department </span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkSection" value="sec.name as section" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Section</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkJobTitle" value="j.name as jobtitle" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Job Title</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkSponsor" value="spo.name as sponsor" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Sponsor</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkSalaryGrade" value="sry.name as salarygrade" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Salary Grade</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkSpecialization" value="spe.name as specialization" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Specialization</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkQualification" value="q.name as qualification" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Qualification</span>
                                                                        </label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <div class="controls">
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="sv.number as visanumber" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Visa Number</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkVisaCivilExpiry" value="sv2.cExpiryDate as visacivilcardexpiry" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Visa/Civil Id Expiry </span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="sp.number as passportnumber" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Passport Number</span>
                                                                        </label>
                                                                    </fieldset>
                                                                    <fieldset>
                                                                        <label class="custom-control custom-checkbox">
                                                                            <input type="checkbox" id="chkPassportExpiry" value="sp2.expiryDate as passportexpiry" name="field_select[]" class="custom-control-input">
                                                                            <span class="custom-control-label">Passport Expiry</span>
                                                                        </label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row step2">
                                                    <div class="col-sm-12">
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <strong><i class="fa fa-info-circle"></i> Step 2: </strong> Based on field name(s) you've checked, set each filter parameter you prefer. Leave them blank if you don't want to filter the field.
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-3 genderFilter">
                                                        <select name="fGenderFilter" class="form-control">
                                                            <option value="">Select Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 nationalityIdFilter">
                                                        <select name="fNationalityIdFilter" class="form-control">
                                                            <option value="">Select Nationality</option>
                                                            <option value="all-non-omani">All Non-Omani</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, name FROM nationality WHERE active = 1 ORDER BY id");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 positionIdFilter">
                                                        <select name="fPositionIdFilter" class="form-control">
                                                            <option value="">Select College Position</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, code, title FROM staff_position WHERE active = 1 ORDER BY title");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 positionCategoryIdFilter">
                                                        <select name="fpositionCategoryIdFilter" class="form-control">
                                                            <option value="">Select Position Category</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, name FROM position_category WHERE active = 1 ORDER BY name");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 statusFilter">
                                                        <select name="fstatusFilter" class="form-control">
                                                            <option value="">Select Status</option>
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
                                                    <div class="col-sm-3 departmentFilter">
                                                        <select name="fdepartmentFilter" class="form-control">
                                                            <option value="">Select Department</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, name FROM department WHERE active = 1 ORDER BY name");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 sectionFilter">
                                                        <select name="fsectionFilter" class="form-control">
                                                            <option value="">Select Section</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, name FROM section WHERE active = 1 ORDER BY name");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 jobTitleFilter">
                                                        <select name="fjobTitleFilter" class="form-control">
                                                            <option value="">Select Job Title</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, name FROM jobtitle WHERE active = 1 ORDER BY name");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 sponsorFilter">
                                                        <select name="fsponsorFilter" class="form-control">
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
                                                    <div class="col-sm-3 salaryGradeFilter">
                                                        <select name="fsalaryGradeFilter" class="form-control">
                                                            <option value="">Select Salary Grade</option>
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
                                                    <div class="col-sm-3 specializationFilter">
                                                        <select name="fspecializationFilter" class="form-control">
                                                            <option value="">Select Specialization</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, name FROM specialization WHERE active = 1 ORDER BY name");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 qualificationFilter">
                                                        <select name="fqualificationFilter" class="form-control">
                                                            <option value="">Select Qualification</option>
                                                            <?php 
                                                                $rows = $dropdown->readData("SELECT id, name FROM qualification WHERE active = 1 ORDER BY name");
                                                                foreach ($rows as $row) {
                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                            <?php            
                                                                }    
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 joinDateFilterA">
                                                            <select name="fJoinDate" id="fJoinDate" class="form-control">
                                                                <option value="">Select Join Date Condition</option>
                                                                <option value="="> = (Equal To) </option>
                                                                <option value=">"> > (Greater Than) </option>
                                                                <option value=">="> >= (Greater Than OR Equal To) </option>
                                                                <option value="<"> < (Less Than) </option>
                                                                <option value="<="> <= (Less Than OR Equal To) </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3 visaCivilExpiryFilterA">
                                                            <select name="fVisaCivilExpiry" id="fVisaCivilExpiry" class="form-control">
                                                                <option value="">Select Visa/Civil ID Exp. Date Condition</option>
                                                                <option value="="> = (Equal To) </option>
                                                                <option value=">"> > (Greater Than) </option>
                                                                <option value=">="> >= (Greater Than OR Equal To) </option>
                                                                <option value="<"> < (Less Than) </option>
                                                                <option value="<="> <= (Less Than OR Equal To) </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3 passportExpiryFilterA">
                                                            <select name="fpassportExpiry" id="fpassportExpiry" class="form-control">
                                                                <option value="">Select Passport Exp. Date Condition</option>
                                                                <option value="="> = (Equal To) </option>
                                                                <option value=">"> > (Greater Than) </option>
                                                                <option value=">="> >= (Greater Than OR Equal To) </option>
                                                                <option value="<"> < (Less Than) </option>
                                                                <option value="<="> <= (Less Than OR Equal To) </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3 joinDateFilterB">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="joinDatePicker" class="form-control" id="joinDatePicker" placeholder="Join Date" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 visaCivilExpiryFilterB">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="visaCivilDatePicker" class="form-control" id="visaCivilDatePicker" placeholder="Visa/Civil ID Expiry Date" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 passportExpiryFilterB">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="passportDatePicker" class="form-control" id="passportDatePicker" placeholder="Passport Expiry Date" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                <div class="form-group row m-b-0">
                                                    <div class="col-sm-3">
                                                        <button type="submit" name="generate" class="btn btn-info waves-effect waves-light"><i class="fa fa-cogs"></i> Generate</button>
                                                        <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                                if(isset($_POST['generate'])) {
                                                    $fieldNames = array();
                                                    $fields = $_POST['field_select'];
                                                    $condSQL = "";
                                                    foreach ($fields as $field){
                                                        if(!empty($field)) {
                                                            array_push($fieldNames,$field);
                                                        }
                                                    }
                                                    $fieldNamesImploded = implode(', ', $fieldNames);
                                                    $sql = "SELECT ".$fieldNamesImploded;
                                                    $sql .= " FROM staff s";
                                                    $sql .= " INNER JOIN employmentdetail e ON s.staffId = e.staff_id";
                                                    
                                                    foreach($fields as $f){
                                                        //All JOINING TABLES first With No WHERE clauses!
                                                        if($f == "n.name as nationality")
                                                            $condSQL .= " INNER JOIN nationality n ON s.nationality_id = n.id";
                                                        if($f == "cd.data as email")
                                                            $condSQL .= " INNER JOIN contactdetails cd ON s.staffId = cd.staff_id";
                                                        if($f == "cd2.data as GSM")
                                                            $condSQL .= " INNER JOIN contactdetails cd2 ON s.staffId = cd2.staff_id";
                                                        if($f == "p.title as college_position")
                                                            $condSQL .= " LEFT OUTER JOIN staff_position p ON e.position_id = p.id";
                                                        if($f == "pc.name as position_category")
                                                            $condSQL .= " LEFT OUTER JOIN position_category pc ON e.position_category_id = pc.id";
                                                        if($f == "st.name as status")
                                                            $condSQL .= " LEFT OUTER JOIN status st ON e.status_id = st.id";
                                                        if($f == "d.name as department")
                                                            $condSQL .= " LEFT OUTER JOIN department d ON e.department_id = d.id";
                                                        if($f == "sec.name as section")
                                                            $condSQL .= " LEFT OUTER JOIN section sec ON e.section_id = sec.id";
                                                        if($f == "j.name as jobtitle")
                                                            $condSQL .= " LEFT OUTER JOIN jobtitle j ON e.jobtitle_id = j.id";
                                                        if($f == "spo.name as sponsor")
                                                            $condSQL .= " LEFT OUTER JOIN sponsor spo ON e.sponsor_id = spo.id";
                                                        if($f == "sry.name as salarygrade")
                                                            $condSQL .= " LEFT OUTER JOIN salarygrade sry ON e.salarygrade_id = sry.id";
                                                        if($f == "spe.name as specialization")
                                                            $condSQL .= " LEFT OUTER JOIN specialization spe ON e.specialization_id = spe.id";
                                                        if($f == "q.name as qualification")
                                                            $condSQL .= " LEFT OUTER JOIN qualification q ON e.qualification_id = q.id";
                                                        if($f == "sv.number as visanumber")
                                                            $condSQL .= " LEFT OUTER JOIN staffvisa sv ON s.staffId = sv.staffId";
                                                        if($f == "sv2.cExpiryDate as visacivilcardexpiry")
                                                            $condSQL .= " LEFT OUTER JOIN staffvisa sv2 ON s.staffId = sv2.staffId";
                                                        if($f == "sp.number as passportnumber")
                                                            $condSQL .= " LEFT OUTER JOIN staffpassport sp ON s.staffId = sp.staffId";
                                                        if($f == "sp2.expiryDate as passportexpiry")
                                                            $condSQL .= " LEFT OUTER JOIN staffpassport sp2 ON s.staffId = sp2.staffId";   
                                                    }      

                                                    if(isset($_POST['fGenderFilter'])) {
                                                        $gender = $_POST['fGenderFilter'];
                                                    }
                                                    if(isset($_POST['fNationalityIdFilter'])) {
                                                        $nationality_id = $_POST['fNationalityIdFilter'];
                                                        if($nationality_id == "all-non-omani")
                                                            $nationality_id = "999";
                                                    }
                                                    if(isset($_POST['fPositionIdFilter'])) {
                                                        $position_id = $_POST['fPositionIdFilter'];
                                                    }
                                                    if(isset($_POST['fpositionCategoryIdFilter'])) {
                                                        $position_category_id = $_POST['fpositionCategoryIdFilter'];
                                                    }
                                                    if(isset($_POST['fstatusFilter'])) {
                                                        $status_id = $_POST['fstatusFilter'];
                                                    }
                                                    if(isset($_POST['fdepartmentFilter'])) {
                                                        $department_id = $_POST['fdepartmentFilter'];
                                                    }
                                                    if(isset($_POST['fsectionFilter'])) {
                                                        $section_id = $_POST['fsectionFilter'];
                                                    }
                                                    if(isset($_POST['fjobTitleFilter'])) {
                                                        $jobtitle_id = $_POST['fjobTitleFilter'];
                                                    }
                                                    if(isset($_POST['fsponsorFilter'])) {
                                                        $sponsor_id = $_POST['fsponsorFilter'];
                                                    }
                                                    if(isset($_POST['fsalaryGradeFilter'])) {
                                                        $salarygrade_id = $_POST['fsalaryGradeFilter'];
                                                    }
                                                    if(isset($_POST['fspecializationFilter'])) {
                                                        $specialization_id = $_POST['fspecializationFilter'];
                                                    }
                                                    if(isset($_POST['fqualificationFilter'])) {
                                                        $qualification_id = $_POST['fqualificationFilter'];
                                                    }


                                                    if(isset($_POST['fJoinDate'])) {
                                                        $joinDateCond = $_POST['fJoinDate'];
                                                    }
                                                    if(isset($_POST['joinDatePicker'])) {
                                                        if($_POST['joinDatePicker'] == "")
                                                            $joinDate = "";
                                                        else
                                                            $joinDate = $helper->mySQLDate($_POST['joinDatePicker']);
                                                    }
                                                    if(isset($_POST['fVisaCivilExpiry'])) {
                                                        $visaCivilDateCond = $_POST['fVisaCivilExpiry'];
                                                    }
                                                    if(isset($_POST['visaCivilDatePicker'])) {
                                                        if($_POST['visaCivilDatePicker'] == "")
                                                            $visaCivilExpiryDate = "";
                                                        else
                                                            $visaCivilExpiryDate = $helper->mySQLDate($_POST['visaCivilDatePicker']);
                                                    }
                                                    if(isset($_POST['fpassportExpiry'])) {
                                                        $passportDateCond = $_POST['fpassportExpiry'];
                                                    }
                                                    if(isset($_POST['passportDatePicker'])) {
                                                        if($_POST['passportDatePicker'] == "")
                                                            $passportExpiryDate = "";
                                                        else
                                                            $passportExpiryDate = $helper->mySQLDate($_POST['passportDatePicker']);
                                                    }

                                                    $condSQL .= " WHERE ";
                                                    foreach($fields as $f){                                                       
                                                        if($f == "cd.data as email")
                                                            $condSQL .= "cd.contacttype_id = 2 AND cd.isFamily = 'N' AND ";
                                                        if($f == "cd2.data as GSM")
                                                            $condSQL .= "cd2.contacttype_id = 1 AND cd2.isFamily = 'N' AND ";
                                                        if($f == "s.gender")
                                                            if($gender != "")
                                                                $condSQL .= "s.gender = '$gender' AND ";        
                                                        if($f == "n.name as nationality")
                                                            if($nationality_id != "")
                                                                if($nationality_id == "999")
                                                                    $condSQL .= "s.nationality_id != 136 AND ";
                                                                else    
                                                                    $condSQL .= "s.nationality_id = $nationality_id AND";
                                                        if($f == "p.title as college_position")
                                                            if($position_id != "")
                                                                $condSQL .= "e.position_id = $position_id AND ";
                                                        if($f == "pc.name as position_category")
                                                            if($position_category_id != "")
                                                                $condSQL .= "e.position_category_id = $position_category_id AND ";
                                                        if($f == "st.name as status")
                                                            if($status_id != "")
                                                                $condSQL .= "e.status_id = $status_id AND ";
                                                        if($f == "d.name as department")
                                                            if($department_id != "")
                                                                $condSQL .= "e.department_id = $department_id AND ";
                                                        if($f == "sec.name as section")
                                                            if($section_id != "")
                                                                $condSQL .= "e.section_id = $section_id AND ";            
                                                        if($f == "j.name as jobtitle")
                                                            if($jobtitle_id != "")
                                                                $condSQL .= "e.jobtitle_id = $jobtitle_id AND ";
                                                        if($f == "spo.name as sponsor")
                                                            if($sponsor_id != "")
                                                                $condSQL .= "e.sponsor_id = $sponsor_id AND ";
                                                        if($f == "sry.name as salarygrade")
                                                            if($salarygrade_id != "")
                                                                $condSQL .= "e.salarygrade_id = $salarygrade_id AND ";
                                                        if($f == "spe.name as specialization")
                                                            if($specialization_id != "")
                                                                $condSQL .= "e.specialization_id = $specialization_id AND ";
                                                        if($f == "q.name as qualification")
                                                            if($qualification_id != "")
                                                                $condSQL .= "e.qualification_id = $qualification_id AND ";  


                                                        if($f == "s.joinDate")
                                                            if($joinDateCond != "" && $joinDate != "")
                                                                if($joinDateCond == "=")    
                                                                    $condSQL .= "s.joinDate = '$joinDate' AND ";
                                                                else if($joinDateCond == ">")    
                                                                    $condSQL .= "s.joinDate > '$joinDate' AND ";
                                                                else if($joinDateCond == ">=")    
                                                                    $condSQL .= "s.joinDate >= '$joinDate' AND ";            
                                                                else if($joinDateCond == "<")    
                                                                    $condSQL .= "s.joinDate < '$joinDate' AND ";
                                                                else if($joinDateCond == "<=")    
                                                                    $condSQL .= "s.joinDate <= '$joinDate' AND ";
                                                        if($f == "sv2.cExpiryDate as visacivilcardexpiry")
                                                            if($visaCivilDateCond != "" && $visaCivilExpiryDate != "")
                                                                if($visaCivilDateCond == "=")    
                                                                    $condSQL .= "sv2.cExpiryDate = '$visaCivilExpiryDate' AND ";
                                                                else if($visaCivilDateCond == ">")    
                                                                    $condSQL .= "sv2.cExpiryDate > '$visaCivilExpiryDate' AND ";
                                                                else if($visaCivilDateCond == ">=")    
                                                                    $condSQL .= "sv2.cExpiryDate >= '$visaCivilExpiryDate' AND ";            
                                                                else if($visaCivilDateCond == "<")    
                                                                    $condSQL .= "sv2.cExpiryDate < '$visaCivilExpiryDate' AND ";
                                                                else if($visaCivilDateCond == "<=")    
                                                                    $condSQL .= "sv2.cExpiryDate <= '$visaCivilExpiryDate' AND ";
                                                        if($f == "sp2.expiryDate as passportexpiry")
                                                            if($passportDateCond != "" && $passportExpiryDate != "")
                                                                if($passportDateCond == "=")    
                                                                    $condSQL .= "sp2.expiryDate = '$passportExpiryDate' AND ";
                                                                else if($passportDateCond == ">")    
                                                                    $condSQL .= "sp2.expiryDate > '$passportExpiryDate' AND ";
                                                                else if($passportDateCond == ">=")    
                                                                    $condSQL .= "sp2.expiryDate >= '$passportExpiryDate' AND ";            
                                                                else if($passportDateCond == "<")    
                                                                    $condSQL .= "sp2.expiryDate < '$passportExpiryDate' AND ";
                                                                else if($passportDateCond == "<=")    
                                                                    $condSQL .= "sp2.expiryDate <= '$passportExpiryDate' AND ";
                                                    }
                                                    $sql .= $condSQL;
                                                    $sql .= "e.isCurrent = 1 GROUP BY s.staffId";
                                                    //$rows = $helper->readData($sql);
                                                    if($result = mysqli_query($con,$sql) or die(mysqli_error($con))){
                                                        $i = 0;
                                                        ?>
                                                        <div class="table-responsive">
                                                            <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <?php
                                                                            while($fieldinfo = mysqli_fetch_field($result)) {
                                                                                echo '<th>' . $fieldinfo->name . '</th>';
                                                                            }
                                                                            //mysqli_free_result($result);
                                                                        ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        while($row = mysqli_fetch_row($result)){
                                                                            echo '<tr>';
                                                                            $count = count($row);
                                                                            $y = 0;
                                                                            while ($y < $count) {
                                                                                $c_row = current($row);
                                                                                echo '<td>' . $c_row . '</td>';
                                                                                next($row);
                                                                                $y++;
                                                                            }
                                                                            echo '</tr>';
                                                                            $i++;
                                                                        }
                                                                        //mysqli_free_result($result);
                                                                    ?>           
                                                                </tbody>
                                                            </table>
                                                        </div>            
                                                        <?php    
                                                    }
                                                }
                                            ?>
                                                  
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
                    $(".step2").hide();
                    $('#joinDatePicker').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#visaCivilDatePicker').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $('#passportDatePicker').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    $(".genderFilter").hide();
                    $(".nationalityIdFilter").hide();
                    $(".positionIdFilter").hide();
                    $(".positionCategoryIdFilter").hide();
                    $(".statusFilter").hide();
                    $(".departmentFilter").hide();
                    $(".sectionFilter").hide();
                    $(".jobTitleFilter").hide();
                    $(".sponsorFilter").hide();
                    $(".salaryGradeFilter").hide();
                    $(".specializationFilter").hide();
                    $(".qualificationFilter").hide();

                    $(".joinDateFilterA").hide();
                    $(".joinDateFilterB").hide();
                    $(".visaCivilExpiryFilterA").hide();
                    $(".visaCivilExpiryFilterB").hide();
                    $(".passportExpiryFilterA").hide();
                    $(".passportExpiryFilterB").hide();
                    
                    $(document).ready(function(){
                        $('#chkGender').change(function(){
                            if(this.checked)
                                $('.genderFilter, .step2').fadeIn('slow');
                            else
                                $('.genderFilter').fadeOut('slow');
                        });
                        $('#chkNationality').change(function(){
                            if(this.checked)
                                $('.nationalityIdFilter, .step2').fadeIn('slow');
                            else
                                $('.nationalityIdFilter').fadeOut('slow');
                        });
                        $('#chkPosition').change(function(){
                            if(this.checked)
                                $('.positionIdFilter, .step2').fadeIn('slow');
                            else
                                $('.positionIdFilter').fadeOut('slow');
                        });
                        $('#chkPositionCat').change(function(){
                            if(this.checked)
                                $('.positionCategoryIdFilter, .step2').fadeIn('slow');
                            else
                                $('.positionCategoryIdFilter').fadeOut('slow');
                        });
                        $('#chkStatus').change(function(){
                            if(this.checked)
                                $('.statusFilter, .step2').fadeIn('slow');
                            else
                                $('.statusFilter').fadeOut('slow');
                        });
                        $('#chkDepartment').change(function(){
                            if(this.checked)
                                $('.departmentFilter, .step2').fadeIn('slow');
                            else
                                $('.departmentFilter').fadeOut('slow');
                        });
                        $('#chkSection').change(function(){
                            if(this.checked)
                                $('.sectionFilter, .step2').fadeIn('slow');
                            else
                                $('.sectionFilter').fadeOut('slow');
                        });
                        $('#chkJobTitle').change(function(){
                            if(this.checked)
                                $('.jobTitleFilter, .step2').fadeIn('slow');
                            else
                                $('.jobTitleFilter').fadeOut('slow');
                        });
                        $('#chkSponsor').change(function(){
                            if(this.checked)
                                $('.sponsorFilter, .step2').fadeIn('slow');
                            else
                                $('.sponsorFilter').fadeOut('slow');
                        });
                        $('#chkSalaryGrade').change(function(){
                            if(this.checked)
                                $('.salaryGradeFilter, .step2').fadeIn('slow');
                            else
                                $('.salaryGradeFilter').fadeOut('slow');
                        });
                        $('#chkSpecialization').change(function(){
                            if(this.checked)
                                $('.specializationFilter, .step2').fadeIn('slow');
                            else
                                $('.specializationFilter').fadeOut('slow');
                        });
                        $('#chkQualification').change(function(){
                            if(this.checked)
                                $('.qualificationFilter, .step2').fadeIn('slow');
                            else
                                $('.qualificationFilter').fadeOut('slow');
                        });

                        
                        $('#chkJoinDate').change(function(){
                            if(this.checked) {
                                $('.joinDateFilterA, .step2').fadeIn('slow');
                                $('.joinDateFilterB').fadeIn('slow');
                            } else {
                                $('.joinDateFilterA').fadeOut('slow');
                                $('.joinDateFilterB').fadeOut('slow');
                            }    
                        });
                        $('#chkVisaCivilExpiry').change(function(){
                            if(this.checked) {
                                $('.visaCivilExpiryFilterA, .step2').fadeIn('slow');
                                $('.visaCivilExpiryFilterB').fadeIn('slow');
                            } else {
                                $('.visaCivilExpiryFilterA').fadeOut('slow');
                                $('.visaCivilExpiryFilterB').fadeOut('slow');
                            }    
                        });
                        $('#chkPassportExpiry').change(function(){
                            if(this.checked) {
                                $('.passportExpiryFilterA, .step2').fadeIn('slow');
                                $('.passportExpiryFilterB').fadeIn('slow');
                            } else {
                                $('.passportExpiryFilterA').fadeOut('slow');
                                $('.passportExpiryFilterB').fadeOut('slow');
                            }
                        });
                    });
                </script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>