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
                        <h3 class="text-themecolor m-b-0 m-t-0">Leave Approver Settings List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Leave Settings</li>
                            <li class="breadcrumb-item">Leave Approver List</li>
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
                    <div class="col-lg-10 col-xs-18"><!---start for list div-->
                        <div class="card">
                           <div class="card-header bg-light-blue m-b-0 p-b-0">

                                                <div class="d-flex flex-wrap">
                                                    <div>
                                                        <h3 class="card-title">List of all Active Leave Approvers</h3>
                                                        
                                                    </div>
                                                </div>
                                            </div> 
                            <div class="card-body">

                                <!-- Accordion style -->
                        <div id="accordion-style-1">

                            <div class="accordion" id="accordionExample">
                        <!----->
                        <div class="card">
                              <div class="card-header" id="headingOne">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa as fa-key main"></i><i class="fa fa-angle-double-right mr-3"></i>Administrative and Finance 
                                        </button>
                                    </h4>
                                </div><!--end d-flex -->
                            </div><!--end card-header-->
                            <div id="collapseOne" class="collapse fade" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Active Approvers</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td>College Dean</td>
                                            <td id="td-id-1" class="td-class-1"> Dr. Hafidh Taher Barham BaOmar</td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>

                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td>Assistant Dean for Student Affairs</td>
                                            <td id="td-id-1" class="td-class-1"> Dr. Hafidh Taher Barham BaOmar</td>
                                            <td>21/06/2017 10:28:08</td>
                                             <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>

                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td>Assistant Dean for Admin and Financial Affairs</td>
                                            <td id="td-id-1" class="td-class-1"> Mr. Hamed Sultan Nasser Al-Aufi</td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>


                                         <tr id="tr-id-1" class="tr-class-1">
                                            <td>Administrative Affairs</td>
                                            <td id="td-id-1" class="td-class-1"> Mr. Mohammed Salim Mohd. Al-Aabadi, Mr. Said Saud Salim Al-Suleimani</td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!--end table responsive-->
                                    
                                </div><!--end card body for table-->
                            </div><!--end collapseOne id-->
                        </div><!--end card for one entry-->


                        <!------------------------------------->


                        <!----->
                        <div class="card">
                              <div class="card-header" id="headingTwo">
                                <div class="d-flex no-block align-items-center">
                                    <h4 class="card-title">
                                        <button class="btn collapsed btn-link text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                          <i class="fa as fa-key main"></i><i class="fa fa-angle-double-right mr-3"></i>Educational Technologies Centre (ETC) 
                                        </button>
                                    </h4>
                                </div><!--end d-flex -->
                            </div><!--end card-header-->
                            <div id="collapseTwo" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table data-toggle="table"  data-mobile-responsive="true" class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Active Approvers</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td>HOC-Educational Technologies Centre</td>
                                            <td id="td-id-1" class="td-class-1"> Mr. Muhammad Tariq</td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>

                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td>HOS - Computer Services Section</td>
                                            <td id="td-id-1" class="td-class-1">Mr. Said Salim Amur Al-Ramidhi</td>
                                            <td>21/06/2017 10:28:08</td>
                                             <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>

                                        <tr id="tr-id-1" class="tr-class-1">
                                            <td>HOS - Educational Services Section</td>
                                            <td id="td-id-1" class="td-class-1"> Mrs. Maha Said Khalfan Al-Anqoudi</td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>


                                         <tr id="tr-id-1" class="tr-class-1">
                                            <td>HOS - Library Section</td>
                                            <td id="td-id-1" class="td-class-1"> Ms. Zahra Sulaiman Saif Al-Mandhari</td>
                                            <td>21/06/2017 10:28:08</td>
                                            <td><a href="settings_position_approver.php" class="btn btn-sm btn-info waves-effect waves-light" role="button" title="Click to view/edit Position Approver"><span class="text-white"><i class="fa fa-paper-plane"></i> Update List</span></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!--end table responsive-->
                                    
                                </div><!--end card body for table-->
                            </div><!--end collapseOne id-->
                        </div><!--end card for one entry-->


                        <!------------------------------------->
                       
                    </div><!--end for accordion whole-->    
                   </div><!--end for accordion style-->    


                               
                            </div><!--end card body for all-->
                        </div><!--end card-->            
                    </div><!--end col-lg-10-->
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