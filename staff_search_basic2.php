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
                                                                        <input type="text" class="form-control daterange" />
                                                                        <input type="hidden" name="startDate" class="form-control startDate" />
                                                                        <input type="hidden" name="endDate" class="form-control endDate" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Visa Expiration</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="visa_expiration_date" id="visa_expiration_date" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 text-right control-label col-form-label">Passport Expiration</label>
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
                                                                        <select name="maritalStatus" id="maritalStatus" class="form-control">
                                                                            <option value=""></option>
                                                                            <option value="Single">Single</option>
                                                                            <option value="Single">Married</option>
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
                                                            <label class="col-sm-4 text-right control-label col-form-label">Department</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                         <select name="department_id" id="department_id" class="form-control">
                                                                            <option value=""></option>
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
                                                                         <select name="section_id" id="section_id" class="form-control">
                                                                            <option value=""></option>
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
                                                                        <select name="specialization_id" id="specialization_id" class="form-control">
                                                                            <option value=""></option>
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
                                                                        <select name="jobtitle_id" id="jobtitle_id" class="form-control">
                                                                            <option value=""></option>
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
                                                                        <select name="position_id" id="position_id" class="form-control">
                                                                        <option value=""></option>
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
                                                            <label class="col-sm-4 text-right control-label col-form-label">Qualification</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="qualification_id" id="qualification_id" class="form-control">
                                                                            <option value=""></option>
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
                                                            <label class="col-sm-4 text-right control-label col-form-label">Nationality</label>
                                                            <div class="col-sm-8">
                                                                <div class="controls">
                                                                    <div class="input-group">
                                                                        <select name="nationality_id" id="nationality_id" class="form-control">
                                                                            <option value=""></option>
                                                                            <?php 
                                                                                $rows = $dropdown->readData("SELECT id, name FROM nationality ORDER BY id");
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
                                                                        <select name="sponsor_id" id="sponsor_id" class="form-control">
                                                                            <option value=""></option>
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
                                                                        <select name="salarygrade_id" id="salarygrade_id" class="form-control">
                                                                            <option value=""></option>
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
                                                                        <select name="status_id" id="status_id" class="form-control">
                                                                            <option value=""></option>
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
                                                </div><!--end row for form-->  
                                            </form>
                                        </div><!--end card body-->
                                    </div><!--end card for outline-info--> 

                                    <div><hr></div>       

                               <div class="card card-outline-info">
                                  <h5 class="card-header m-b-0 text-white">Search Result</h5>
                                  <div class="card-body">
                                    <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Staff ID</th>
                                                            <th>Civil ID</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            if(isset($_POST['submit'])) {
                                                                    $sql = "SELECT s.id, s.staffId, s.civilId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id WHERE e.isCurrent = 1";

                                                                    

                                                                    if ($_POST['status_id'] != '') {
                                                                        $sql .= " AND e.status_id = ".$_POST['status_id'];
                                                                    }

                                                                    if ($_POST['gender'] != '') {
                                                                        $sql .= " AND s.gender = '".$_POST['gender']."'";
                                                                    }

                                                                    if ($_POST['maritalStatus'] != '') {
                                                                        $sql .= " AND s.maritalStatus = '".$_POST['maritalStatus']."'";
                                                                    }

                                                                    if ($_POST['startDate'] != '') {
                                                                        $sql .= " AND s.joinDate >= '".$_POST['startDate']."' AND s.joinDate <= '".$_POST['endDate']."'";
                                                                    }

                                                                    echo $sql;

                                                                    $data = new DbaseManipulation;
                                                                    $rows = $data->readData($sql); // WHERE e.isCurrent = 1 AND e.status_id = 1 means all active staff
                                                                    foreach ($rows as $row) {
                                                                        ?>
                                                                        <tr class="clickable-row" data-href='staff_details.php?id=<?php echo $row['id']; ?>'>
                                                                            <td><?php echo $row['staffId']; ?></td>
                                                                            <td><?php echo $row['civilId']; ?></td>
                                                                            <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $data->getContactInfo(2,$row['staffId'],'data'); ?></td>
                                                                        </tr>
                                                                        <?php 
                                                                    }
                                                            } else {
                                                                    $data = new DbaseManipulation;
                                                                    $rows = $data->readData("SELECT s.id, s.staffId, s.civilId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id"); // WHERE e.isCurrent = 1 AND e.status_id = 1 means all active staff
                                                                    foreach ($rows as $row) {
                                                                        ?>
                                                                        <tr class="clickable-row" data-href='staff_details.php?id=<?php echo $row['id']; ?>'>
                                                                            <td><?php echo $row['staffId']; ?></td>
                                                                            <td><?php echo $row['civilId']; ?></td>
                                                                            <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                            <td><?php echo $row['department']; ?></td>
                                                                            <td><?php echo $data->getContactInfo(2,$row['staffId'],'data'); ?></td>
                                                                        </tr>
                                                                        <?php 
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