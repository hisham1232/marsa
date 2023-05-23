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
        <?php   include('menu_top.php'); ?>   
        </header>
        <?php   include('menu_left.php'); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Generate Staff ID</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">College Staff</li>
                            <li class="breadcrumb-item">Generate Staff ID</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
                <div class="row">
                    <div class="col-lg-6"><!---start form div-->
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h3 class="card-title">Staff ID Form</h3>
                                        <h6 class="card-subtitle">Arabic Text Here</h6> 
                                    </div>
                                </div>
                                <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Department<br> Arabic Text</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                    <select name="managerId" class="form-control" required data-validation-required-message="Please select department from the list">
                                                        <option value="">Select Department</option>
                                                        <option value="1">Department 1</option>
                                                        <option value="2">Department 2</option>
                                                        <option value="3">Department 3</option>
                                                     </select>   
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label"><span class="text-danger">*</span>Year<br> Arabic Text</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                   <select name="managerId" class="form-control" required data-validation-required-message="Please select year from the list">
                                                        <option value="">Select Year</option>
                                                        <option value="1">2018</option>
                                                        <option value="2">2019</option>
                                                        <option value="3">2020</option>
                                                     </select>   
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                   

                                     <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Last Staff ID<br> Arabic Text</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                   <input type="text" name="last_staff_id" class="form-control" readonly/>  
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Last Staff Name<br> Arabic Text</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                   <input type="text" name="last_staff_name" class="form-control" readonly />  
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                     <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">New Staff ID<br> Arabic Text</label>
                                        <div class="col-sm-9">
                                            <div class="controls">
                                                <div class="input-group">
                                                   <input type="text" name="last_staff_name" class="form-control" readonly />  
                                                </div><!--end input-group-->
                                            </div><!--end controls-->
                                        </div><!--end col-sm-9-->
                                    </div><!--end form-group row --->

                                    

                                    <div class="form-group row m-b-0">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Open modal</button>
                                        </div>
                                    </div>
                                </form><!--end form-->
                            </div><!--end card body-->
                        </div><!--end card-->
                    </div><!--end col-lg-6-->
                    <!------------------------------------------------------------------------>
                    <!------------------------------------------------------------------------>

                    
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