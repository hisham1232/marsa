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
                        <h3 class="text-themecolor m-b-0 m-t-0">Position Approver Settings</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item">Position Approver Settings</li>
                        </ol>
                    </div>
                    <?php include('include_time_in_info.php'); ?>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-18"><!---start form div-->
                        <div class="card">

                            <div class="card-header bg-light-yellow">
                                               <div class="d-flex flex-wrap">
                                    <div>
                                        <h3 class="card-title">Approver Form for Position <p class="font-weight-bold text-primary">[HOC-Educational Technologies Centre]</p></h3>
                                        <h6 class="card-subtitle">استمارة معتمد المنصب</h6> 
                                    </div>
                                </div>

                                            </div>    

                            <div class="card-body">
                                
                               
                                <form class="form-horizontal p-t-20 p-l-0 p-" action="" method="POST" novalidate enctype="multipart/form-data">

                                                    <div class="form-group row">
                                                        <label  class="col-lg-3 control-label">Approver ID</label>
                                                        <div class="col-lg-9">
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
                                                        </div><!--end col-lg-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-lg-3 control-label"><span class="text-danger">*</span>Staff Name</label>
                                                        <div class="col-lg-9">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                     <select class="custom-select select2" required data-validation-required-message="Please select approver of this section on Task">
                                                                        <option value="">Select Staff</option>
                                                                        <option>112233 - Rolen</option>
                                                                        <option>408022 - Mylyn</option>
                                                                        <option>408024 - Ramil</option>
                                                                        <option>223344 - Maha</option>
                                                                        <option>445566 - Ghaniya</option>
                                                                        </select>
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-lg-9-->
                                                    </div><!--end form-group row --->


                                                     <div class="form-group row">
                                                        <label  class="col-lg-3 control-label"><span class="text-danger">*</span>Status</label>
                                                        <div class="col-lg-9">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                     <select class="custom-select select2" required data-validation-required-message="Please select status">
                                                                        <option value="">Select Status</option>
                                                                        <option>Active</option>
                                                                        <option>Not-Active</option>
                                                                        </select>
                                                                   
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-lg-9-->
                                                    </div><!--end form-group row --->




                                                    <div class="form-group row">
                                                        <label  class="col-lg-3 control-label">Notes / Comments</label>                  <div class="col-lg-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    
                                                                    <textarea  class="form-control" rows="2" required data-validation-required-message="Please enter comment/reason"></textarea>
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="far fa-comment"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-lg-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row">
                                                        <label  class="col-lg-3 control-label">Enter By</label>                  <div class="col-lg-9">
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
                                                        </div><!--end col-lg-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-lg-3 control-label">Enter Date</label>                  <div class="col-lg-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <span class="far fa-calendar-alt"></span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-lg-9-->
                                                    </div><!--end form-group row --->




                                                    

                                                    <div class="form-group row m-b-0">
                                                        <div class="offset-sm-3 col-lg-9">
                                                            <!------->
                                                            <button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                        </div>
                                                    </div>
                                                </form><!--end form form-->
                                            
                            </div><!--end card body-->
                        </div><!--end card-->
                    </div><!--end col-lg-6-->
                    <!------------------------------------------------------------------------>
                    <!------------------------------------------------------------------------>

                    <div class="col-lg-8 col-sm-18"><!---start for list div-->
                        <div class="card">
                             <div class="card-header bg-light-yellow">
                                               <div class="d-flex flex-wrap">
                                    <div>
                                        <h4 class="card-title">List of Approvers for Position [<span class="font-weight-bold text-primary">HOC-Educational Technologies Centre</span>]</h4>
                                <h6 class="card-subtitle">قائمة معتمِدي المنصب</h6>
                                    </div>
                                </div>

                                            </div>  

                            <div class="card-body">
                                
                                <div class="table-responsive">
                                 
                                        <table id="example23" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Staff ID</th>
                                                <th>Approver Name</th>
                                                <th>Status</th>
                                                <th>Enter By</th>
                                                <th>Enter Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>112233</td>
                                                <td><a href="#" title="Click to view/edit Approver Details">Mr. Muhammad Tariq</a></td>
                                                <td>Active</td>
                                                <td>Mr. Sulaiman Huraib Mohammed Al-Owaimiri</td>
                                                <td>20/11/2018 13:56</td>
                                            </tr>
                                             <tr>
                                                <td>112233</td>
                                                <td><a href="#" title="Click to view/edit Approver Details">Mr. Hamed Sultan Nasser Al-Aufi</a></td>
                                                <td>Not-Active</td>
                                                <td>Mr. Sulaiman Huraib Mohammed Al-Owaimiri</td>
                                                <td>12/03/2018 8:20</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!--end table-responsive-->
                            </div><!--end card body-->
                        </div><!--end card-->            
                    </div><!--end col-lg-6-->
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