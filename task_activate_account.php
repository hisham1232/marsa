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
                    <div class="col-md-5 col-sm-12 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Activate Staff Account</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Account Task</li>
                            <li class="breadcrumb-item">Activate Account</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
             <div class="row">
                    <div class="col-lg-6 col-xs-18">
                        <div class="card card-body">
                            <h4 class="box-title m-b-0">1. Search Deparment</h4>
                            <span class="text-muted font-13 font-italic"><em>Select the staff you want to Activate account.</em></span>
                             <form class="form-horizontal m-b-0" action="" method="POST" novalidate enctype="multipart/form-data">

                    <div class="form-group row">
    <label class="col-sm-3 control-label">Select Staff</label>
    <div class="col-sm-6">
        <div class="controls">
        <select class="custom-select select2" required data-validation-required-message="Please select Staff">
                                                                        <option value="">Select Staff</option>
                                                                        <option>112233 - Rolen</option>
                                                                        <option>408022 - Mylyn</option>
                                                                        <option>408024 - Ramil</option>
                                                                        <option>223344 - Maha</option>
                                                                        <option>445566 - Ghaniya</option>
                                                                        </select>
        </div>
</div>
    
    <div class="col-sm-2">
        <button class="btn btn-success waves-effect waves-light"  type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
    </div>
    
  </div><!--end form-group-->

                      
                    </form>
                        </div>
                    </div>
                </div>
            

                <!------------------------------------------------->
                                <div class="row">
                                    <div class="col-lg-6 col-xs-18"><!---start  form div-->
                                        <div class="card">
                                            <div class="card-header bg-light-yellow">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">2. Activate Account Form</h3>
                                                        <h6 class="card-subtitle font-italic">Complete the Activate Account Form and click submit. Once Submitted : <br>1. Staff Account will be put on Active List <br>2. The system will send request to ETC to Activate all related e-service access and e-mail.</h6>
                                                    </div>
                                                </div>

                                            </div>    
                                            <div class="card-body">
                                                
                                                <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Staff ID - Name</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly value="408022 - Mylyn Nostarez"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    
                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Department</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-briefcase"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Job Title</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-book"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Sponsor</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-clipboard-list"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label text-danger">Employment Status</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly value="ANY-NOT ACTIVE"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-flag-checkered text-danger"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->





                                                    
                                              

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label text-danger"><span class="text-danger">*</span>New Status</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                     <input type="text" name="numberofdays" class="form-control" readonly value="Active">
                                                                   <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-question text-danger"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label text-danger"><span class="text-danger">*</span>Reason</label>                  <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    
                                                                    <textarea  class="form-control" required rows="2" required data-validation-required-message="Reasons is required" minlength="20"></textarea>
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-comment text-danger"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                   <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Attachment</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="file" name="attachment" class="form-control"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-file-pdf"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Enter By</label>                  <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Enter Date</label>                  <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <span class="far fa-calendar-alt"></span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->




                                                    

                                                    <div class="form-group row m-b-0">
                                                        <div class="offset-sm-3 col-sm-9">
                                                            <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                        </div>
                                                    </div>
                                                </form><!--end form application leave form-->
                                            </div><!--end card body form-->
                                        </div><!--end card form-->
                                    
                        
                    </div><!--end col 12 for form-->
                </div><!--end row for search-->


            </div><!--end container fluid-->

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