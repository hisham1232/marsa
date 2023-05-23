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
                                                <div class="sl-left"> <img src="assets/images/users/avatar3.png" alt="Staff" class="img-circle"/> </div>
                                                <div class="sl-right">
                                                    <div><a href="#" class="link">Mylyn Nostarez</a> <span class="sl-date">[Staff ID : 408022]</span>
                                                        <div class="like-comm">
                                                            <a href="javascript:void(0)" class="link m-r-5">Computer Technician</a> 
                                                            <a href="javascript:void(0)" class="link m-r-5">Educational Services Section</a> 
                                                            <a href="javascript:void(0)" class="link m-r-5">Educational Technologies Centres</a> 
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

                                                                <a class="btn btn-secondary" href="staff_details.php" title="Click to view Staff Details" role="button"><span class="hidden-sm-up"><i class="fas fa-user-md"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Staff Details</a>

                                                                <a class="btn btn-info" href="staff_employment.php" title="Click to view Employment History" role="button"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down"><i class="fas fa-edit"></i> Employment History</a>
                                                                
                                                                <a class="btn btn-secondary" href="staff_legal_documents.php" title="Click to view Legal Documents" role="button"><span class="hidden-sm-up"><i class="far fa-credit-card"></i></span> <span class="hidden-xs-down"> <i class="ti-angle-double-down"></i> Legal Documents</a>

                                                                <a class="btn btn-secondary" href="staff_qualification.php" title="Click to view Staff Qualification" role="button"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Qualification</a>

                                                                <a class="btn btn-secondary" href="staff_work_experience.php" title="Click to view Staff Work Experience" role="button"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Work Experience</a>

                                                                <a class="btn btn-secondary" href="staff_researches.php" title="Click to view Staff Researches" role="button"><span class="hidden-sm-up"><i class="ti-clipboard"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Researches</a>    

                                                                <a class="btn btn-secondary" href="staff_contacts.php" title="Click to view Staff Contacts" role="button"><span class="hidden-sm-up"><i class="far fa-address-book"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Contacts</a>    

                                                                <a class="btn btn-secondary" href="staff_family.php" title="Click to view Staff Family Information" role="button"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down"><i class="ti-angle-double-down"></i> Family Information</a>    

                                                            </div>
                                                        </div>
                                <div class="row">
                                    <div class="col-lg-5"><!---start short leave application form div-->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Employment History Form</h3>
                                                   </div>
                                                </div>
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
                                            </div><!--end card body form-->
                                        </div><!--end card form-->
                                    </div><!--end col6 for leave details-->

                                    <!---------------------------------------------------------------------------------------------------------->
                                    <!---------------------------------------------------------------------------------------------------------->

                                    <div class="col-lg-7"><!---start short leave approval form div-->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Employment History List (NCT)</h3>
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
                                                <td>1</td>
                                                <td><span class="text-primary font-weight-bold">ETC Technician</span></td>
                                                <td>Educational Technologies Centree</td>
                                                <td>dd/mm/yyyy</td>
                                                <td>Active</td>
                                           </tr>
                                          
                                        </tbody>
                                    </table>
                                    </div><!--end table-responsive-->                     
                                            </div><!--end card list-->
                                        </div><!--end card approval-->
                                    </div><!--end col6 for list details-->
                                </div><!--end row for whole form-->
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
        // MAterial Date picker    
        $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false,format: 'DD/MM/YYYY' });
        $('#start_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
        $('#end_date').datepicker({ weekStart: 0, time: false,format: 'dd/mm/yyyy' });
        jQuery('#date-range').datepicker({
            toggleActive: true
        });

        $('.daterange').daterangepicker();

        </script>
</body>
</html>