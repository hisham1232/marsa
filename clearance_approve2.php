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
                    <div class="col-md-5 col-xs-18 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Clearance Application</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Clearance </li>
                            <li class="breadcrumb-item">Apply Clearance</li>
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




               




                <div class="row"><!--for result-->
                    <div class="col-lg-12 col-xs-18"><!---start for list div-->
                        <div class="card">
                            <div class="card-header bg-light-yellow">
                                <h4 class="card-title">Clearance Application Form</h4>


                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="m-b-0">Staff ID: <span class="text-primary">408022</span></p>
                                        <p class="m-b-0">Staff Name: <span class="text-primary">Nape Rangagodage Nilwala De Silva</span></p>
                                        <p class="m-b-0">Job Title : <span class="text-primary">Data here </span></p>
                                    </div>

                                    <div class="col-lg-3">
                                        <p class="m-b-0">Department: <span class="text-primary">English Languange Center</span></p>
                                        <p class="m-b-0">Section : <span class="text-primary">Educational Services Section </span></p>
                                        <p class="m-b-0">Qualification : <span class="text-primary">Masters</span></p>
                                    </div><!--end col-->  

                                    <div class="col-lg-2">
                                        <p class="m-b-0">Sponsor: <span class="text-primary">Ministry Of Manpower</span></p>
                                        <p class="m-b-0">Join Date: <span class="text-primary">15/11/2018</span></p>
                                        <p class="m-b-0">Nationality: <span class="text-primary">Filipino</span></p>
                                    </div><!--end col-->    

                                    <div class="col-lg-2">
                                        <p class="m-b-0">Clearance ID:<span class="text-primary">XYZ-123456</span></p>
                                        <p class="m-b-0">Clearance Date :<span class="text-primary">15/11/2018</span></p>
                                        <p class="m-b-0">Clearance Status:<span class="text-primary">On-Process</span></p>
                                    </div><!--end col-->   

                                </div><!--end row-->
                            </div><!--end card header-->
                            <div class="card-body">

                <div class="row">
                    <div class="col-lg-4 col-xs-18"><!---start for form approval-->

                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">Clearance Approval Form</h3>
                                                        <h6 class="card-subtitle font-italic">Fill-up form to Approve/Dis-approve Clearance Application</h6>
                                                    </div>
                                                </div>
                                                <form class="form-horizontal p-t-20" action="" method="POST" novalidate enctype="multipart/form-data">

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Approver</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly value="Nasser Ali Mohammed Al-Abri"> 
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
                                                        <label  class="col-sm-3 control-label">Section</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    <input type="text" name="numberofdays" class="form-control" readonly value="Asst. Dean for Admin and Financial Affairs"> 
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon2">
                                                                            <i class="fas fa-key"></i>
                                                                        </span>
                                                                    </div><!--end input-group-prepend-->
                                                                </div><!--end input-group-->
                                                            </div><!--end controls-->
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->

                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-9">

                                                            <a class="mytooltip" href="javascript:void(0)">
                                                                <span class="text-info"><small><i class="fas fa-list-ol"></i> Clearance Check List</small></span>
                                                                <span class="tooltip-content5">
                                                                    <span class="tooltip-text3">
                                                                        <span class="tooltip-inner2">
                                                                            <p>Administrative Affairs:</p>
                                                                            <ul>
                                                                                <li>Accommodation</li>
                                                                                <li>Furniture</li>
                                                                                <li>Electiricity Bill</li>
                                                                                <li>Water Bill</li>
                                                                                <li>Telephone Bill</li>
                                                                            </ul>

                                                                            <p>College Store:</p>
                                                                            <ul>
                                                                                <li>Personal Official ID</li>
                                                                                <li>Store Dues</li>
                                                                                <li>Office Furniture</li>
                                                                                <li>Equipment</li>
                                                                                <li>Others</li>
                                                                            </ul>

                                                                            <p>Financial Affairs:</p>
                                                                            <ul>
                                                                                <li>Debts</li>
                                                                            </ul>
                                                                        </span>
                                                                    </span>
                                                                </span></a>


                                                            
                                                        </div><!--end col-sm-9-->
                                                    </div><!--end form-group row --->


                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label">Enter Date</label>
                                                        <div class="col-sm-9">
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
                                                    <div class="form-group row">
                                                        <label  class="col-sm-3 control-label text-danger"><span class="text-danger">*</span>Status</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">

                                                                     <select class="custom-select select2" required data-validation-required-message="Please select Clearance Approval Status">
                                                                        <option value="">Select Status</option>
                                                                        <option>Approve</option>
                                                                        <option>Not-Approve</option>
                                                                        </select>
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
                                                        <label  class="col-sm-3 control-label">Comment</label>
                                                        <div class="col-sm-9">
                                                            <div class="controls">
                                                                <div class="input-group">
                                                                    
                                                                    <textarea  class="form-control" rows="2"></textarea>
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

                     </div> <!--end col for approval-->  

                     <div class="col-lg-8 col-xs-18"><!---start for list div-->

                     </div> <!---end for col history--> 
                </div><!--end for row-->      




<!-- Accordion style -->
<div id="accordion-style-1">
            <div class="row">
                <div class="col-4 mx-auto">
                    

                </div>    <!--end col form--------------->
                <!--------------------------------------->

                <div class="col-8 mx-auto"><!---col for clearance history-->

                    <div class="accordion" id="accordionExample">
                        <!----->
                        <div class="card">
                              <div class="card-header" id="headingOne">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-clipboard-list main"></i><i class="fa fa-angle-double-right mr-3"></i>Staff Section Head 
                                        </button>
                                    </h4>
                                    <div class="ml-auto">
                                        <ul class="list-inline text-right"><li><i class="fas fa-check text-primary"></i> Approved</li></ul>
                                    </div><!--end ml-auto-->
                                </div><!--end d-flex -->
                            </div><!--end card-header-->
                            <div id="collapseOne" class="collapse fade" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Approver Name</th>
                                            <th>Date/Time</th>
                                            <th>Status</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td id="td-id-1" class="td-class-1"> Sultan Saud Nasser Al-Dighaishi </td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td>Approved</td>
                                            <td>An extended Bootstrap table</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                        </div>
                        <!-------------------------------------------------------->
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                            <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                          <i class="fa fa-suitcase main"></i><i class="fa fa-angle-double-right mr-3"></i>Staff Department Head 
                                        </button>
                                    </h4>
                                    <div class="ml-auto">
                                        <ul class="list-inline text-right"><li><i class="fas fa-check text-primary"></i> Approved</li></ul>
                                    </div><!--end ml-auto-->
                                </div><!--end d-flex -->
                            </div><!--end card-header-->
                            <div id="collapseTwo" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Approver Name</th>
                                            <th>Date/Time</th>
                                            <th>Status</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td id="td-id-1" class="td-class-1"> Sultan Saud Nasser Al-Dighaishi </td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td>Approved</td>
                                            <td>An extended Bootstrap table</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                </div><!--cardbody-->
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                          <i class="fa fa-box-open main"></i><i class="fa fa-angle-double-right mr-3"></i>Administrative Affairs 
                                        </button>
                                    </h4>
                                    <div class="ml-auto">
                                        <ul class="list-inline text-right"><li><i class="fas fa-check text-primary"></i> Approved</li></ul>
                                    </div><!--end ml-auto-->
                                </div><!--end d-flex -->
                            </div><!--end card-header-->

                            <div id="collapseThree" class="collapse fade" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">

                                    <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Approver Name</th>
                                            <th>Date/Time</th>
                                            <th>Status</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td id="td-id-1" class="td-class-1"> Sultan Saud Nasser Al-Dighaishi </td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td>Approved</td>
                                            <td>An extended Bootstrap table</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                    
                                </div>
                            </div>
                        </div>
                        <!----------------------------------------------------->
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                          <i class="fa ti-shopping-cart main"></i><i class="fa fa-angle-double-right mr-3"></i>College Store 
                                        </button>
                                    </h4>
                                    <div class="ml-auto">
                                        <ul class="list-inline text-right"><li><i class="fas fa-check text-primary"></i> Approved</li></ul>
                                    </div><!--end ml-auto-->
                                </div><!--end d-flex -->
                            </div><!--end card-header-->
                            <div id="collapseFour" class="collapse fade" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body">
                                     <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Approver Name</th>
                                            <th>Date/Time</th>
                                            <th>Status</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td id="td-id-1" class="td-class-1"> Sultan Saud Nasser Al-Dighaishi </td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td>Approved</td>
                                            <td>An extended Bootstrap table</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <!---------------------------------->


                        <!----------------------------------------------------->
                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                          <i class="fa fa-money-bill-alt main"></i><i class="fa fa-angle-double-right mr-3"></i>Financial Affairs 
                                        </button>
                                    </h4>
                                    <div class="ml-auto">
                                        <ul class="list-inline text-right"><li><i class="fas fa-check text-primary"></i> Approved</li></ul>
                                    </div><!--end ml-auto-->
                                </div><!--end d-flex -->
                            </div><!--end card-header-->
                            <div id="collapseFive" class="collapse fade" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                     <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Approver Name</th>
                                            <th>Date/Time</th>
                                            <th>Status</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td id="td-id-1" class="td-class-1"> Sultan Saud Nasser Al-Dighaishi </td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td>Approved</td>
                                            <td>An extended Bootstrap table</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <!---------------------------------->


                        <!----------------------------------------------------->
                        <div class="card">
                            <div class="card-header" id="headingSix">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                          <i class="fa ti-server main"></i><i class="fa fa-angle-double-right mr-3"></i>HOS - Computer Services Section 
                                        </button>
                                    </h4>
                                    <div class="ml-auto">
                                        <ul class="list-inline text-right"><li><i class="fas fa-check text-primary"></i> Approved</li></ul>
                                    </div><!--end ml-auto-->
                                </div><!--end d-flex -->
                            </div><!--end card-header-->
                            <div id="collapseSix" class="collapse fade" aria-labelledby="headingSix" data-parent="#accordionExample">
                                <div class="card-body">
                                     <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Approver Name</th>
                                            <th>Date/Time</th>
                                            <th>Status</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td id="td-id-1" class="td-class-1"> Sultan Saud Nasser Al-Dighaishi </td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td>Approved</td>
                                            <td>An extended Bootstrap table</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <!---------------------------------->

                    </div>
                </div>  
            </div>
        
    </div>
</div>
                                
                               
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