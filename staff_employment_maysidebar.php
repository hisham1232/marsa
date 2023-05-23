<?php    
    include('include_headers.php');                                 
?>  
<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
         <?php    include('menu_top.php'); ?>   
        </header>
        <?php   include('menu_left.php'); ?>
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
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>September 24,2018</small></h6>
                                    <h6 class="m-b-0"><small>Your Time-In Today</small></h6>
                                    <h4 class="m-t-0 text-primary">08:00am</h4>
                                </div>
                                <div class="spark-chart">
                                    <i class="far fa-clock fa-3x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div class="row">
                    <!-- Column -->
                    <div class="col-lg-2 col-xlg-2 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-5"> <img src="assets/images/users/avatar3.png" class="img-circle" width="100" alt="Staff Picture" />
                                    <h5 class="card-title m-t-10">Mylyn Nostarez</h5>
                                    <h5 class="card-title m-t-10">Arabic Name</h5>
                                    <h6 class="card-subtitle">ETC Technician</h6>
                                    <h6 class="card-subtitle">Educational Services Section</h6>
                                    <h6 class="card-subtitle">Educational Technologies Centre</h6>
                                    <h6 class="card-subtitle">mylyn.nostarez@nct.edu.om</h6>
                                </center>
                                <div class="list-group">
                                 <a href="staff_details.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i> Staff Details</a>   
                                <a href="staff_employment.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i> Employment History</a>
                                      <a href="staff_legal_docs.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i> Legal Documents</a>
                                      <a href="staff_qualification.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i>  Qualification</a>
                                      <a href="staff_work_experience.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i>  Work Experience</a>
                                      <a href="staff_researches.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i>Researches</a>
                                      <a href="staff_contacts.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i>Contacts</a>
                                      <a href="staff_family.php" class="list-group-item list-group-item-success"><i class="ti-angle-double-right"></i> Family Information</a>
                                    </div> 
                            </div><!--end card body-->
                        </div><!--end card-->
                    </div><!--end Column for profile -->
                    <!-- Column -->
                    <div class="col-lg-10 col-xlg-10 col-md-8">
                        
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Staff Employment History (NCT)</h4>
                                <h6 class="card-subtitle">Arabic Text</h6>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="card border-success">
                                          <div class="card-header" style="border-bottom: double; border-color: #28a745">Staff Employment Form</div>
                                          <div class="card-body">
                                            <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Department</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="department" class="form-control" required data-validation-required-message="Please select department from the list">
                                                        <option value="">Select Department</option>
                                                        <option value="1">Department 1</option>
                                                        <option value="2">Department 2</option>
                                                        <option value="3">Department 3</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Section</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="section" class="form-control" required data-validation-required-message="Please select section from the list">
                                                        <option value="">Select Section</option>
                                                        <option value="1">Section 1</option>
                                                        <option value="2">Section 2</option>
                                                        <option value="3">Section 3</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                 <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Job Title</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="job_title" class="form-control" required data-validation-required-message="Please select Job Title from the list">
                                                        <option value="">Select Job Title</option>
                                                        <option value="1">Job Title 1</option>
                                                        <option value="2">Job Title 2</option>
                                                        <option value="3">Job Title 3</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                 <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Position</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="position" class="form-control" required data-validation-required-message="Please select Position from the list">
                                                        <option value="">Select Position</option>
                                                        <option value="1">Position 1</option>
                                                        <option value="2">Position 2</option>
                                                        <option value="3">Position 3</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->


                                                 <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Sponsor</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="sponsor" class="form-control" required data-validation-required-message="Please select Sponsor from the list">
                                                        <option value="">Select Sponsor</option>
                                                        <option value="1">Sponsor 1</option>
                                                        <option value="2">Sponsor 2</option>
                                                        <option value="3">Sponsor 3</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->


                                                 <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Salary Grade</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="salary_grade" class="form-control" required data-validation-required-message="Please select Position from the list">
                                                        <option value="">Select Salary Grade</option>
                                                        <option value="1">Salary Grade 1</option>
                                                        <option value="2">Salary Grade 2</option>
                                                        <option value="3">Salary Grade 3</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->


                                                 <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Emp. Type</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="employment_type" class="form-control" required data-validation-required-message="Please select Position from the list">
                                                        <option value="">Select Employment Type</option>
                                                        <option value="1">Employment Type 1</option>
                                                        <option value="2">Employment Type 2</option>
                                                        <option value="3">Employment Type 3</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->


                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Emp. Status Date</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <input type="text" class="form-control" name="status_date" id="status_date" required data-validation-required-message="Please enter Employment Status Date"/>
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Registration Card</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <input type="text" class="form-control" name="reg_card" required data-validation-required-message="Please enter Registration Card No"/>
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Ministry Staff ID</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <input type="text" class="form-control" name="min_staff_id" required data-validation-required-message="Please enter Ministry Staff ID"/>
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Employment Status</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="employment_status" class="form-control" required data-validation-required-message="Please select Employment Status from the list">
                                                        <option value="">Select Employment Status</option>
                                                        <option value="1">Employment Status 1</option>
                                                        <option value="2">Employment Status 2</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                <div class="form-group row">
                                                    <label for="" class="col-sm-4 control-label text-right"><span class="text-danger">*</span>Emp. History Status</label>
                                                    <div class="col-sm-8">
                                                        <div class="controls">
                                                            <div class="input-group">
                                                               <select name="history_status" class="form-control" required data-validation-required-message="Please select Employment History Status from the list">
                                                        <option value="">Select Employment History Status</option>
                                                        <option value="1">Employment History Status 1</option>
                                                        <option value="2">Employment History Status 2</option>
                                                     </select>  
                                                            </div><!--end input-group-->
                                                        </div><!--end controls-->
                                                    </div><!--end col-sm-8-->
                                                </div><!--end form-group row --->

                                                <div class="form-group row m-b-0">
                                                    <div class="offset-sm-4 col-sm-8">
                                                        <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                        <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                        <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Open modal</button>-->
                                                    </div>
                                                </div>
                                            </form><!--end form-->

                                          </div>  <!--end card body for form-->
                                        </div><!--end card-->    
                                    </div><!---end col for form-->


                                <!-------------------------------->    
                                    <div class="col-md-7">
                                        <div class="card border-success">
                                          <div class="card-header" style="border-bottom: double; border-color: #28a745">Staff Employment History (NCT)</div>
                                          <div class="card-body">
                                            <div class="table-responsive">
                                        <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Job Title</th>
                                                <th>Department</th>
                                                <th>Start Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><span class="text-primary font-weight-bold">ETC Technician</span></td>
                                                <td>Educational Technologies Centree</td>
                                                <td>dd/mm/yyyy</td>
                                                <td>Active</td>
                                           </tr>

                                             <tr>
                                                <td>2</td>
                                                <td><span class="text-primary font-weight-bold">ETC Technician</span></td>
                                                <td>Educational Technologies Centree</td>
                                                <td>dd/mm/yyyy</td>
                                                <td>Active</td>
                                           </tr>
                                          
                                        </tbody>
                                    </table>
                                    </div><!--end table-responsive-->
                                          </div><!---end card body-->
                                        </div><!--end card-->
                                    </div><!---end col for list-->
                           </div><!--end card body-->
                        </div><!--end card for whole staff Staff Profile-->        
                    </div><!-- Column end col profiles-->
                
                </div><!--end row-->
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
            $('#status_date').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
        </script>
</body>
</html>