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
                        <h3 class="text-themecolor m-b-0 m-t-0">Update Deligation</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Deligation</li>
                            <li class="breadcrumb-item">Deligation Request List</li>
                            <li class="breadcrumb-item">Update Deligation</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-18"><!---start  form div-->
                                        <div class="card">
                                            <div class="card-header bg-light-danger2 p-b-0 p-t-5">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Deligation Form</h3>
                                                    </div>
                                                    <div class="ml-auto">
                                                         <ul class="list-inline">
                                                            <li class="none">
                                                                <?php 
                                                                    $request = new DbaseManipulation;
                                                                    //$requestNo = $request->leaveRequestNo("XYZ-","standardleave");
                                                                ?>
                                                                <p class="">For Approval 
                                                                    <span class="badge badge-primary requestNo">[DXY-1234]</span>
                                                                </p> </li>
                                                        </ul>
                                                    </div><!--end ml-auto-->
                                                </div><!--end d-flex-->
                                            </div><!-- end card-header-->
                                            <div class="card-body">
                                                
                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Deligated Role</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                     <div class="controls">
                                                            <fieldset>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" value="x" name="styled_checkbox"  data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Choose at least one role." class="custom-control-input"><span class="custom-control-label">Approve Short Leave</span> </label>
                                                            </fieldset>
                                                            <fieldset>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" value="y" name="styled_checkbox" class="custom-control-input"><span class="custom-control-label">Approve Standard Leave</span> </label>
                                                            </fieldset>
                                                            <fieldset>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" value="z" name="styled_checkbox" class="custom-control-input"><span class="custom-control-label">Approve Clearance</span> </label>
                                                            </fieldset>
                                                        </div>

                                                                   
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                     
                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"> Requested By</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="text" class="form-control" readonly> 
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->
                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"> Requested Date</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="text" class="form-control" readonly> 
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"> Deligation Date</label>
                                                        <div class="col-sm-9">
                                                           <div class='input-group mb-3'>
                                                                <input type='text' class="form-control" readonly/>
                                                           </div>
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Deligator Note</label>                  <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    
                                                                    <textarea  class="form-control" readonly rows="2"></textarea>
                                                                    <div class="input-group-prepend">
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Note</label>                  <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    
                                                                    <textarea  class="form-control" required rows="2" required data-validation-required-message="Note is required" minlength="20"></textarea>
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
                                                            <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fas fa-thumbs-up"></i> Accept</button>
                                                            <button type="reset" class="btn btn-danger waves-effect waves-light"><i class="fas fa-thumbs-down"></i> Reject</button>
                                                        </div>
                                                    </div>
                                                </form><!--end form application leave form-->
                                            </div><!--end card body form-->
                                        </div><!--end card form-->
                                    
                        
                    </div><!--end col  for form-->
                     <div class="col-lg-6 col-xs-18">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Information!</h4>
                                        <small>Add note about acceptance of deligation here</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
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