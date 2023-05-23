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
                        <h3 class="text-themecolor m-b-0 m-t-0">Apply Standard Leave</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Leave Application</li>
                            <li class="breadcrumb-item">Standard Leave Application</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card"><!-- card-outline-success-->
                            <div class="card-header">
                                <div class="row ribbon-vwrapper">
                                    <div class="col-md-4"> 
                                        <div class="d-flex flex-row">
                                            <div class="mr-auto">
                                                <img src="assets/images/users/avatar3.png" style=" width:100px; height:100px; border-radius: 50%" alt="Staff ID"><br>
                                            </div>
                                            <div>
                                                <h5 class="text-primary">Mylyn Nostarez</h5>
                                                <h5><i class="fas fa-address-card text-muted"></i> 408022</h5>
                                                <h5>Education Services Section</h5>
                                                <h5>Educational Technologies Centre</h5>
                                                 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"> 
                                        <div class="d-flex flex-row">
                                            <div>
                                                <h5>Computer Technician</h5>
                                                <h5>Bahwan Cybertek LLC</h5>
                                                <h5>mylyn.nostarez@nct.nct.edu.om</h5>
                                                <h5><i class="fas fa-address-card text-muted"></i> 90802110</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5"> 
                                        <div class="row">
                                            <div class="col-5"> 
                                                <h5>Internal Leave Balance</h5>
                                            </div>
                                            <div class="col-2"><h5>20</h5></div>
                                            <div class="col-5"> 
                                                <h5>رصيد الإجازة الداخلية </h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-5"> 
                                                <h5>Pending (Internal)</h5>
                                            </div>
                                            <div class="col-2"><h5>33</h5></div>
                                            <div class="col-5"> 
                                                <h5>رصيد الإجازة الداخلية<</h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-5"> 
                                                <h5>Emergency Leave Balance</h5>
                                            </div>
                                            <div class="col-2"><h5>3</h5></div>
                                            <div class="col-5"> 
                                                <h5> رصيد الإجازة الطارئة  </h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-5"> 
                                                <h5>Pending (Emergency)</h5>
                                            </div> <!--end col 5-->
                                            <div class="col-2"><h5>1</h5></div>
                                            <div class="col-5"> 
                                                <h5>في الإنتظار(الطارئة)  </h5>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--end row-->
                            </div><!--end card header-->

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6"><!---start short leave application form div-->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Standard Leave Application Form</h3>
                                                        <h6 class="card-subtitle">Arabic Text Here</h6>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <?php 
                                                            $request = new DbaseManipulation;
                                                            $requestNo = $request->leaveRequestNo("STL-","standardleave");
                                                        ?>
                                                        <h3>New Application <span class="badge badge-primary requestNo"><?php echo $requestNo; ?></span></h3>
                                                    </div>
                                                </div>
                                
                                                <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Date Requested <br> عتاريخ الطلب</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="text" class="form-control" readonly value="<?php echo date("d/m/Y"); ?>"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Kind of Leave <br>تاريخ الطلب
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                     <select name="select" id="select" required class="form-control" data-validation-required-message="Please Select Leave Type">
                                                                        <option value="">Select Select Kind of Leave</option>
                                                                        <?php 
                                                                            $request = new DbaseManipulation;
                                                                            $rows = $request->readData("SELECT id, name FROM leavetype ORDER BY id");
                                                                            foreach ($rows as $row) {
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                                                        <?php            
                                                                            }    
                                                                        ?>
                                                                    </select>
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-credit-card"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    
                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Leave Date</label>
                                                        <div class="col-sm-9">
                                                            <div class="input-daterange input-group" id="date-range">
                                                                <input type="text" class="form-control" name="start_date" id="start_date" required data-validation-required-message="Leave Start date is required"/>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text bg-info b-0 text-white">TO</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="end_date" id="end_date" required data-validation-required-message="Leave End date is required"/>
                                                                <div class="input-group-prepend">
                                                                     <span class="input-group-text" id="basic-addon2">
                                                                     <i class="far fa-calendar-alt"></i>
                                                                     </span>
                                                                </div><!--end input-group-prepend-->

                                                            </div><!--end input-daterange-->
                                                        </div><!--end coll--->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Leave Date v2</label>
                                                        <div class="col-sm-9">
                                                            <div class='input-group mb-3'>
                                                                <input type='text' class="form-control daterange" />
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                            <span class="far fa-calendar-alt"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div><!--end coll--->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Begin of Leave <br>تاريخ بدء الإجازة</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="date" class="form-control" placeholder="mm/dd/yyyy" required data-validation-required-message="Leave begin date is required"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>End of Leave <br>تاريخ إنتهاء الإجازة</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="date" class="form-control" placeholder="mm/dd/yyyy" required data-validation-required-message="Leave end date is required"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Number of Days <br> عدد الأيام</label>                  <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-hashtag"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Attachment <br>المرفقات</label>
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
                                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Reasons for Leave <br>سبب الإجازة</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    
                                                                    <textarea  class="form-control" rows="2" required data-validation-required-message="Reasons for Leave is required" minlength="20"></textarea>
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-comment"></i>
                                                                        </span>
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
                                    </div><!--end col6 for leave details-->

                                    <!---------------------------------------------------------------------------------------------------------->
                                    <!---------------------------------------------------------------------------------------------------------->

                                    <div class="col-lg-6"><!---start short leave approval form div-->
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Leave Approval</h3>
                                                        <h6 class="card-subtitle">Arabic Text Here</h6>
                                                    </div>
                                                </div>
                                                <div class="ribbon-vwrapper card">
                                                    <div class="ribbon ribbon-info ribbon-vertical-l">1</div>
                                                    <h3 class="ribbon-content">ESS Head Approval</h3>
                                                    <p class="ribbon-content"><span class="text-muted">Status : <span class="text-primary">Approved</span>
                                                    <span class="text-muted pull-right">September 22, 2018</span></span></p>
                                                    <p class="ribbon-content"><i>A sample text comment during approval.</i></p>
                                                </div>
                                                <div class="ribbon-vwrapper card">
                                                    <div class="ribbon ribbon-info ribbon-vertical-l">2</div>
                                                    <h3 class="ribbon-content">ETC Head of Center Approval</h3>
                                                    <p class="ribbon-content"><span class="text-muted">Status : <span class="text-primary">Approved</span>
                                                    <span class="text-muted pull-right">September 22, 2018</span></span></p>
                                                    <p class="ribbon-content"><i>A sample text comment during approval.</i></p>
                                                </div>
                                                <div class="ribbon-vwrapper card">
                                                    <div class="ribbon ribbon-info ribbon-vertical-l">3</div>
                                                    <h3 class="ribbon-content">ETC Head of Center Approval</h3>
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
                                                    <div class="ribbon ribbon-info ribbon-vertical-l">4</div>
                                                    <h3 class="ribbon-content">Head of HR</h3>
                                                    <p class="ribbon-content"><span class="text-muted">Status : <span class="text-warning">Wating</span></span></p>
                                                </div>                          
                                            </div><!--end card body approval-->
                                        </div><!--end card approval-->
                                    </div><!--end col6 for approval details-->
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