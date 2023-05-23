<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
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
                    <?php   include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Search Staff</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">College Staff</li>
                                        <li class="breadcrumb-item active">Search Staff</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-outline-info">
                                        <div class="card-header">
                                            <h4 class="m-b-0 text-white">Search Staff Form</h4>
                                        </div>
                                        <div class="card-body">
                                                
                                            <form  class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label"><span class="text-danger">*</span>Title</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="sTitle[]" id="sTitle" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Title">
                                                                            <option value="Mr.">Mr.</option>
                                                                            <option value="Mrs.">Mrs.</option>
                                                                            <option value="Ms.">Ms.</option>
                                                                            <option value="Dr.">Dr.</option>
                                                                        </select>
                                                                        <script type="text/javascript">
                                                                            document.getElementById('sTitle').value = "<?php echo $_POST['sTitle'];?>";
                                                                         </script>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Staff Id</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="sStaffId" id="sStaffId" class="form-control">
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sStaffId').value = "<?php echo $_POST['sStaffId'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Gender</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="gender" id="gender" class="form-control">
                                                                            <option value=""></option>
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('gender').value = "<?php echo $_POST['gender'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Birth Date</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text"  class="form-control" name="birthdate" id="birthday_date"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Join Date</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" value="" class="form-control" name="startDate" id="startDate" placeholder="Start" />
                                                                        <input type="text" value="" class="form-control" name="endDate" id="endDate" placeholder="End" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Visa Expiry</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="visa_expiration_date" id="visa_expiration_date" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Passport Expiry</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="passport_expiration_date" id="passport_expiration_date"/>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Marital Status</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="maritalStatus[]" id="maritalStatus" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Marital Status">
                                                                            <option value="Single">Single</option>
                                                                            <option value="Married">Married</option>
                                                                            <option value="Divorced">Divorced</option>
                                                                            <option value="Widowed">Widowed</option>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('maritalStatus').value = "<?php echo $_POST['maritalStatus'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!--End First Column col-lg-4------------------------------------------->
                                                    
                                                    <!--Second Column col-lg-4---------------------------------------------->
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">First Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="sFirstName" id="sFirstName" class="form-control">
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sFirstName').value = "<?php echo $_POST['sFirstName'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Civil Id</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="sCivilId" id="sCivilId" class="form-control">
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sCivilId').value = "<?php echo $_POST['sCivilId'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Department</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="department_id[]" id="department_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Department">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM department ORDER BY id");
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
                                                        </div>                                                        
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Section</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="section_id[]" id="section_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Section">
                                                                            
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM section ORDER BY id");
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
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Specialization</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="specialization_id[]" id="specialization_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Specialization">
                                                                            
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM specialization ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('specialization_id').value = "<?php echo $_POST['specialization_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Job Title</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="jobtitle_id[]" id="jobtitle_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Job Title">
                                                                           
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM jobtitle ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('jobtitle_id').value = "<?php echo $_POST['jobtitle_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">College Position</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="position_id[]" id="position_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select College Position">
                                                                        <?php 
                                                                            $rows = $dropdown->readData("SELECT id, code, title FROM staff_position ORDER BY id");
                                                                            foreach ($rows as $row) {
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                                                        <?php            
                                                                            }    
                                                                        ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('position_id').value = "<?php echo $_POST['position_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Position Category</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                            <select name="position_category_id[]" id="position_category_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Position Category">
                                                                        <?php 
                                                                            $rows = $dropdown->readData("SELECT id, name FROM position_category WHERE active = 1 ORDER BY id");
                                                                            foreach ($rows as $row) {
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                        <?php            
                                                                            }    
                                                                        ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('position_category_id').value = "<?php echo $_POST['position_category_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Qualification</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="qualification_id[]" id="qualification_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Qualification">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM qualification ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('qualification_id').value = "<?php echo $_POST['qualification_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Second Column col-lg-4------------------------------------------>
                                                    
                                                    <!--Third Column col-lg-4----------------------------------------------->    
                                                    <div class="col-lg-4">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Last Name</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="sLastName" id="sLastName" class="form-control">
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sLastName').value = "<?php echo $_POST['sLastName'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Ministry Id</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" name="sMinistryId" id="sMinistryId" class="form-control">
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sMinistryId').value = "<?php echo $_POST['sMinistryId'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Nationality</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="nationality_id[]" id="nationality_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Nationality">

                                                                            <option value="136">Omani</option>
                                                                            <option value="999">Non-Omani</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM nationality WHERE id <> 136 ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('nationality_id').value = "<?php echo $_POST['nationality_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Sponsor</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="sponsor_id[]" id="sponsor_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Sponsor">
                                                                            <option value="999">All Company</option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM sponsor ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('sponsor_id').value = "<?php echo $_POST['sponsor_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Salary Grade</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="salarygrade_id[]" id="salarygrade_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Salary Grade">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM salarygrade ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('salarygrade_id').value = "<?php echo $_POST['salarygrade_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Employment</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="employmenttype_id" id="employmenttype_id" class="form-control">
                                                                            <option value=""></option>
                                                                            <option value="1">Full Time</option>
                                                                            <option value="2">Part Time</option>
                                                                        </select>
                                                                        <script type="text/javascript">
                                                                            document.getElementById('employmenttype_id').value = "<?php echo $_POST['employmenttype_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Status</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="status_id[]" id="status_id" class="form-control select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Select Status">
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM status ORDER BY id");
                                                                                foreach ($rows as $row) {
                                                                            ?>
                                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                            <?php            
                                                                                }    
                                                                            ?>
                                                                         </select>
                                                                         <script type="text/javascript">
                                                                            document.getElementById('status_id').value = "<?php echo $_POST['status_id'];?>";
                                                                         </script>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                   
                                                        <div class="form-group m-b-0">
                                                            <div class="offset-sm-4 col-sm-8">
                                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                <a href="" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Third Column col-lg-4------------------------------------------->
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div><hr></div>       

                               <div class="card card-outline-info">
                                  <h5 class="card-header m-b-0 text-white">Search Result</h5>
                                  <div class="card-body">
                                    <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>StaffID</th>
                                                            <th>CivilID</th>
                                                            <th>Title</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Designation</th>
                                                            <th>Sponsor Category/Sector</th>
                                                            <th>Sponsor</th>
                                                            <th>Qualification</th>
                                                            <th>Specialization</th>
                                                            <th>Position</th>
                                                            <th>FinancialGrade</th>
                                                            <th>Status</th>
                                                            <th>EmploymentStatus</th>
                                                            <th>Gender</th>
                                                            <th>Nationality A</th>
                                                            <th>Nationality B</th>
                                                            <th>JoinDate</th>
                                                            <th>BirthDate</th>
                                                            <th>Age</th>
                                                            <th>Passport</th>
                                                            <th>Visa</th>
                                                            <th>WorkEmail</th>
                                                            <th>PersonalEmail</th>
                                                            <th>GSM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            if(isset($_POST['submit'])) {
                                                                $sql = "SELECT s.id, s.salutation, s.staffId, s.civilId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                                                s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, 
                                                                q.name as qualification, spc.name as specialization, cp.title as college_position, sps.name as sponsor,
                                                                e.joinDate, s.birthdate, sts.name as status, sg.name as salarygrade, e.employmenttype_id, e.sponsor_id, s.nationality_id
                                                                FROM staff as s 
                                                                LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id 
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                                                LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                                                                LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
                                                                LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id 
                                                                LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id
                                                                LEFT OUTER JOIN specialization as spc ON spc.id = e.specialization_id 
                                                                LEFT OUTER JOIN staff_position as cp ON cp.id = e.position_id
                                                                LEFT OUTER JOIN sponsor as sps ON sps.id = e.sponsor_id 
                                                                LEFT OUTER JOIN status as sts ON sts.id = e.status_id 
                                                                LEFT OUTER JOIN salarygrade as sg ON sg.id = e.salarygrade_id 
                                                                WHERE e.isCurrent = 1 AND ";

                                                                if ($_POST['department_id'] == 0) {
                                                                    $sql .= "e.department_id > 0";
                                                                } else {
                                                                    $departmentIds = array();
                                                                    foreach ($_POST['department_id'] as $selectedDepartmentIds) {
                                                                        array_push($departmentIds,$selectedDepartmentIds);
                                                                    }
                                                                    $departmentIds = implode(', ', $departmentIds);
                                                                	$sql .= "e.department_id IN (".$departmentIds.")";
                                                                }

                                                                if ($_POST['section_id'] != '') {
                                                                    $sectionIds = array();
                                                                    foreach ($_POST['section_id'] as $selectedSectionIds) {
                                                                        array_push($sectionIds,$selectedSectionIds);
                                                                    }
                                                                    $sectionIds = implode(', ', $sectionIds);
                                                                    $sql .= " AND e.section_id IN (".$sectionIds.")";
                                                                }

                                                                if ($_POST['specialization_id'] != '') {
                                                                    $specializationIds = array();
                                                                    foreach ($_POST['specialization_id'] as $selectedSpecializationIds) {
                                                                        array_push($specializationIds,$selectedSpecializationIds);
                                                                    }
                                                                    $specializationIds = implode(', ', $specializationIds);
                                                                    $sql .= " AND e.specialization_id IN (".$specializationIds.")";
                                                                }

                                                                if ($_POST['jobtitle_id'] != '') {
                                                                    $jobTitleIds = array();
                                                                    foreach ($_POST['jobtitle_id'] as $selectedJobTitleIds) {
                                                                        array_push($jobTitleIds,$selectedJobTitleIds);
                                                                    }
                                                                    $jobTitleIds = implode(', ', $jobTitleIds);
                                                                    $sql .= " AND e.jobtitle_id IN (".$jobTitleIds.")";
                                                                }

                                                                if ($_POST['position_id'] != '') {
                                                                    $positionIds = array();
                                                                    foreach ($_POST['position_id'] as $selectedPositionIds) {
                                                                        array_push($positionIds,$selectedPositionIds);
                                                                    }
                                                                    $positionIds = implode(', ', $positionIds);
                                                                    $sql .= " AND e.position_id IN (".$positionIds.")";
                                                                }

                                                                if ($_POST['position_category_id'] != '') {
                                                                    $positionCatIds = array();
                                                                    foreach ($_POST['position_category_id'] as $selectedPositionCatIds) {
                                                                        array_push($positionCatIds,$selectedPositionCatIds);
                                                                    }
                                                                    $positionCatIds = implode(', ', $positionCatIds);
                                                                    $sql .= " AND e.position_category_id IN (".$positionCatIds.")";
                                                                }

                                                                if ($_POST['qualification_id'] != '') {
                                                                    $qualificationIds = array();
                                                                    foreach ($_POST['qualification_id'] as $selectedQualificationIds) {
                                                                        array_push($qualificationIds,$selectedQualificationIds);
                                                                    }
                                                                    $qualificationIds = implode(', ', $qualificationIds);
                                                                    $sql .= " AND e.qualification_id IN (".$qualificationIds.")";
                                                                }

                                                                if ($_POST['nationality_id'] != '') {
                                                                    if($_POST['nationality_id'] == 999)
                                                                        $sql .= " AND s.nationality_id != 136";
                                                                    else 
                                                                        $nationalityIds = array();
                                                                        foreach ($_POST['nationality_id'] as $selectedNationalityIds) {
                                                                            array_push($nationalityIds,$selectedNationalityIds);
                                                                        }
                                                                        $nationalityIds = implode(', ', $nationalityIds);
                                                                        $sql .= " AND s.nationality_id IN (".$nationalityIds.")";
                                                                }

                                                                if ($_POST['sponsor_id'] != '') {
                                                                    if($_POST['sponsor_id'] == 999)
                                                                        $sql .= " AND e.sponsor_id != 1";
                                                                    else
                                                                        $sponsorIds = array();
                                                                        foreach ($_POST['sponsor_id'] as $selectedSponsorIds) {
                                                                            array_push($sponsorIds,$selectedSponsorIds);
                                                                        }
                                                                        $sponsorIds = implode(', ', $sponsorIds);
                                                                        $sql .= " AND e.sponsor_id IN (".$sponsorIds.")";
                                                                }

                                                                if ($_POST['salarygrade_id'] != '') {
                                                                    $salaryGradeIds = array();
                                                                    foreach ($_POST['salarygrade_id'] as $selectedSalaryGradeIds) {
                                                                        array_push($salaryGradeIds,$selectedSalaryGradeIds);
                                                                    }
                                                                    $salaryGradeIds = implode(', ', $salaryGradeIds);
                                                                    $sql .= " AND e.salarygrade_id IN (".$_salaryGradeIds.")";
                                                                }

                                                                if ($_POST['employmenttype_id'] != '') {
                                                                    $sql .= " AND e.employmenttype_id = ".$_POST['employmenttype_id'];
                                                                }

                                                                $statusIds = array();
                                                                foreach ($_POST['status_id'] as $selectedStatusIds) {
                                                                    array_push($statusIds,$selectedStatusIds);
                                                                }
                                                                $statusIds = implode(', ', $statusIds);
                                                                if ($_POST['status_id'] != '') {
                                                                    $sql .= " AND e.status_id IN (".$statusIds.")";
                                                                } else {
                                                                    $sql .= " AND e.status_id = 1";
                                                                }

                                                                if ($_POST['gender'] != '') {
                                                                    $sql .= " AND s.gender = '".$_POST['gender']."'";
                                                                }

                                                                $sMaritalIds = array();
                                                                foreach ($_POST['maritalStatus'] as $selectedsMaritalIds) {
                                                                    array_push($sMaritalIds,$selectedsMaritalIds);
                                                                }
                                                                $sMaritalIds = "'" .implode("', '", $sMaritalIds). "'";
                                                                if ($_POST['maritalStatus'] != '') {
                                                                    $sql .= " AND s.maritalStatus IN (".$sMaritalIds.")";
                                                                }

                                                                if ($_POST['startDate'] != '') {
                                                                    $startDeyt = $helper->mySQLDate($_POST['startDate']);
                                                                    $endDeyt = $helper->mySQLDate($_POST['endDate']);
                                                                    $sql .= " AND s.joinDate >= '".$startDeyt."' AND s.joinDate <= '".$endDeyt."'";
                                                                }
                                                                $sTitleIds = array();
                                                                foreach ($_POST['sTitle'] as $selectedsTitleIds) {
                                                                    array_push($sTitleIds,$selectedsTitleIds);
                                                                }
                                                                $sTitleIds = "'" .implode("', '", $sTitleIds). "'";
                                                                if ($_POST['sTitle'] != '') {
                                                                    $sql .= " AND s.salutation IN (".$sTitleIds.")";
                                                                }
                                                                if ($_POST['sStaffId'] != '') {
                                                                    $sql .= " AND s.staffId = '".$_POST['sStaffId']."'";
                                                                }
                                                                if ($_POST['sFirstName'] != '') {
                                                                    $sql .= " AND s.firstName = '".$_POST['sFirstName']."'";
                                                                }
                                                                if ($_POST['sLastName'] != '') {
                                                                    $sql .= " AND s.lastName = '".$_POST['sLastName']."'";
                                                                }
                                                                if ($_POST['sCivilId'] != '') {
                                                                    $sql .= " AND s.civilId = '".$_POST['sCivilId']."'";
                                                                }
                                                                if ($_POST['sStaffId'] != '') {
                                                                    $sql .= " AND s.staffId = '".$_POST['sStaffId']."'";
                                                                }
                                                                if ($_POST['sMinistryId'] != '') {
                                                                    $sql .= " AND s.ministryStaffId = '".$_POST['sMinistryId']."'";
                                                                }
                                                                //echo $sql;
                                                                $data = new DbaseManipulation;
                                                                $rows = $data->readData($sql); // WHERE e.isCurrent = 1 AND e.status_id = 1 means all active staff
                                                                foreach ($rows as $row) {
                                                                    $age = date('Y',time()) - date('Y',strtotime($row['birthdate']));
                                                                    if($row['employmenttype_id'] == 1)
                                                                        $empType = 'Full Time';
                                                                    else
                                                                        $empType = 'Part Time';

                                                                    if($row['nationality_id'] == 136)
                                                                        $nat = 'Omani';
                                                                    else
                                                                        $nat = 'Non-Omani';
                                                                    if($row['sponsor_id'] == 1)
                                                                        $sponsorCat = 'MOM';    
                                                                    else
                                                                        $sponsorCat = 'Private';

                                                                    ?>
                                                                    <tr class="clickable-row" data-href='staff_details.php?id=<?php echo $row['id']; ?>'>
                                                                        <td><a href="staff_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['staffId']; ?></a></td>
                                                                        <td><?php echo $row['civilId']; ?></td>
                                                                        <td><?php echo $row['salutation']; ?></td>
                                                                        <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                        <td><?php echo $row['department']; ?></td>
                                                                        <td><?php echo $row['section']; ?></td>
                                                                        <td><?php echo $row['jobtitle']; ?></td>
                                                                        <td><?php echo $sponsorCat; ?></td>
                                                                        <td><?php echo $row['sponsor']; ?></td>
                                                                        <td><?php echo $row['qualification']; ?></td>
                                                                        <td><?php echo $row['specialization']; ?></td>
                                                                        <td><?php echo $row['college_position']; ?></td>
                                                                        <td><?php echo $row['salarygrade']; ?></td>
                                                                        <td><?php echo $row['status']; ?></td>
                                                                        <td><?php echo $empType; ?></td>
                                                                        <td><?php echo $row['gender']; ?></td>
                                                                        <td><?php echo $nat; ?></td>
                                                                        <td><?php echo $row['nationality']; ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['joinDate'])); ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['birthdate'])); ?></td>
                                                                        <td><?php echo $age; ?></td>
                                                                        <td><?php echo $data->getPassportNo($row['staffId'],'number'); ?></td>
                                                                        <td><?php echo $data->getVisaNo($row['staffId'],'number'); ?></td>
                                                                        <td><?php echo $data->getContactInfo(2,$row['staffId'],'data'); ?></td>
                                                                        <td><?php echo $data->getContactInfo(3,$row['staffId'],'data'); ?></td>
                                                                        <td><?php echo $data->getContactInfo(1,$row['staffId'],'data'); ?></td>
                                                                    </tr>
                                                                    <?php
                                                                    $age = 0; 
                                                                }
                                                            } else {
                                                                $data = new DbaseManipulation;
                                                                $rows = $data->readData("SELECT s.id, s.salutation, s.staffId, s.civilId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                                                    s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, 
                                                                    q.name as qualification, spc.name as specialization, cp.title as college_position, sps.name as sponsor,
                                                                    e.joinDate, s.birthdate, sts.name as status, sg.name as salarygrade, e.employmenttype_id, e.sponsor_id, s.nationality_id
                                                                    FROM staff as s 
                                                                    LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id 
                                                                    LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                                                    LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                                                                    LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
                                                                    LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id 
                                                                    LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id
                                                                    LEFT OUTER JOIN specialization as spc ON spc.id = e.specialization_id 
                                                                    LEFT OUTER JOIN staff_position as cp ON cp.id = e.position_id
                                                                    LEFT OUTER JOIN sponsor as sps ON sps.id = e.sponsor_id 
                                                                    LEFT OUTER JOIN status as sts ON sts.id = e.status_id 
                                                                    LEFT OUTER JOIN salarygrade as sg ON sg.id = e.salarygrade_id 
                                                                    WHERE e.isCurrent = 1 AND e.status_id = 1");
                                                                foreach ($rows as $row) {
                                                                    $age = date('Y',time()) - date('Y',strtotime($row['birthdate']));
                                                                    if($row['employmenttype_id'] == 1)
                                                                        $empType = 'Full Time';
                                                                    else
                                                                        $empType = 'Part Time';

                                                                    if($row['nationality_id'] == 136)
                                                                        $nat = 'Omani';
                                                                    else
                                                                        $nat = 'Non-Omani';
                                                                    if($row['sponsor_id'] == 1)
                                                                        $sponsorCat = 'MOM';    
                                                                    else
                                                                        $sponsorCat = 'Private';
                                                                    ?>
                                                                    <tr class="clickable-row" data-href='staff_details.php?id=<?php echo $row['id']; ?>'>
                                                                        <td><a href="staff_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['staffId']; ?></a></td>
                                                                        <td><?php echo $row['civilId']; ?></td>
                                                                        <td><?php echo $row['salutation']; ?></td>
                                                                        <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                        <td><?php echo $row['department']; ?></td>
                                                                        <td><?php echo $row['section']; ?></td>
                                                                        <td><?php echo $row['jobtitle']; ?></td>
                                                                        <td><?php echo $sponsorCat; ?></td>
                                                                        <td><?php echo $row['sponsor']; ?></td>
                                                                        <td><?php echo $row['qualification']; ?></td>
                                                                        <td><?php echo $row['specialization']; ?></td>
                                                                        <td><?php echo $row['college_position']; ?></td>
                                                                        <td><?php echo $row['salarygrade']; ?></td>
                                                                        <td><?php echo $row['status']; ?></td>
                                                                        <td><?php echo $empType; ?></td>
                                                                        <td><?php echo $row['gender']; ?></td>
                                                                        <td><?php echo $nat; ?></td>
                                                                        <td><?php echo $row['nationality']; ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['joinDate'])); ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['birthdate'])); ?></td>
                                                                        <td><?php echo $age; ?></td>
                                                                        <td><?php echo $data->getPassportNo($row['staffId'],'number'); ?></td>
                                                                        <td><?php echo $data->getVisaNo($row['staffId'],'number'); ?></td>
                                                                        <td><?php echo $data->getContactInfo(2,$row['staffId'],'data'); ?></td>
                                                                        <td><?php echo $data->getContactInfo(3,$row['staffId'],'data'); ?></td>
                                                                        <td><?php echo $data->getContactInfo(1,$row['staffId'],'data'); ?></td>
                                                                    </tr>
                                                                    <?php 
                                                                    $age = 0;
                                                                }
                                                            }        
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                  </div><!--end card body list-->
                                </div><!--end card for list-->

                                 
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
                        // MAterial Date picker    
                        $('#startDate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                        $('#endDate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                        $('#visa_expiration_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                        $('#birthday_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                        $('#passport_expiration_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                        $('#join_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
                    </script>
                </div>
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>