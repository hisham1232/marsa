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
                        <h3 class="text-themecolor m-b-0 m-t-0">Activate Staff Account Details</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Account Task</li>
                            <li class="breadcrumb-item">Activate Account</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>

                <!------------------------------------------------->
                                <div class="row">
                                    <div class="col-lg-6 col-xs-18"><!---start  form div-->
                                        <div class="card">
                                            <div class="card-header bg-light-yellow">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Activate Account Form</h3>
                                                        <h6 class="card-subtitle font-italic">Staff was requested to activate related e-services and e-mail account</h6>
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
                                                        <label  class="col-sm-3 control-label text-danger">OLD Employment Status</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly value="On-Study"> 
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
                                                        <label  class="col-sm-3 control-label text-danger">New Status</label>
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
                                                        <label  class="col-sm-3 control-label text-danger">Reason</label>                  <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    
                                                                    <textarea  class="form-control" required rows="2" disabled data-validation-required-message="Reasons is required" minlength="20">
                                                                        Show the reason to HR Staff / Heaad only
                                                                    </textarea>
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

                                                </form><!--end form application leave form-->
                                            </div><!--end card body form-->
                                        </div><!--end card form-->
                    </div><!--end col 6 for form-->

                    <div class="col-lg-6"><!---start short leave approval form div-->
                                        <div class="card">
                                            <div class="card-header bg-light-yellow">

                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Activate Staff Account Tasks</h3>
                                                        <h6 class="card-subtitle font-italic">Approval Details</h6>
                                                    </div>
                                                    <div class="ml-auto">
                                                       <h3> Task ID : <span class="text-success">asd123</span> Status: <span class="text-success">Completed</span></h3>
                                                        
                                                    </div>
                                                </div>

                                                
                                            </div> 

                                            <div class="card-body">
                                                
                                                <div class="ribbon-vwrapper card">
                                                    <div class="ribbon ribbon-info ribbon-vertical-l"><i class="fa fa-user"></i></div>
                                                    <h3 class="ribbon-content">Change HR Staff Account</h3>
                                                    <p class="ribbon-content"><span class="text-muted">Status : <span class="text-primary">Approved</span>
                                                    <span class="text-muted pull-right">September 22, 2018</span></span></p>
                                                    <p class="ribbon-content"><i>A sample text comment during approval.</i></p>
                                                </div>
                                                <div class="ribbon-vwrapper card">
                                                    <div class="ribbon ribbon-warning ribbon-vertical-l"><i class="fa fa-envelope"></i></div>
                                                    <h3 class="ribbon-content">Activate Email Account</h3>
                                                    <p class="ribbon-content"><span class="text-muted">Status : <span class="text-warning">On-Process</span>
                                                    <span class="text-muted pull-right">Current Date here</span></span></p>
                                                    <form class="form-horizontal m-t-5">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="" placeholder="Type Comment Here...">
                                                        </div><!--end form-group-->
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                            <button type="reset" class="btn btn-danger"><i class="fa fa-thumbs-down"></i> Decline</button>
                                                        </div><!--end form-group-->
                                                    </form>
                                                </div>

                                                <div class="ribbon-vwrapper card">
                                                    <div class="ribbon ribbon-primary ribbon-vertical-l"> <i class="fa fa-sitemap"></i></div>
                                                    <h3 class="ribbon-content">Activate Active Directory Account</h3>
                                                    <p class="ribbon-content"><span class="text-muted">Status : <span class="text-primary">Approved</span>
                                                    <span class="text-muted pull-right">September 22, 2018</span></span></p>
                                                    <p class="ribbon-content"><i>A sample text comment during approval.</i></p>
                                                </div>

                                                <div class="ribbon-vwrapper card">
                                                    <div class="ribbon ribbon-danger ribbon-vertical-l"> <i class="fa fa-key fa-rotate-270"></i></div>
                                                    <h3 class="ribbon-content">Activate System User Type</h3>
                                                    <p class="ribbon-content"><span class="text-muted">Status : <span class="text-primary">Approved</span>
                                                    <span class="text-muted pull-right">September 22, 2018</span></span></p>
                                                    <p class="ribbon-content"><i>A sample text comment during approval.</i></p>
                                                </div>
                                            </div><!--end card body approval-->
                                        </div><!--end card approval-->
                                    </div><!--end col6 for approval details-->


                </div><!--end row -->


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