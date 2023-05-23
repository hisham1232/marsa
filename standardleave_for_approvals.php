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
                        <h3 class="text-themecolor m-b-0 m-t-0">Approve Leave Request List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</a></li>
                            <li class="breadcrumb-item">Standard Leave</li>
                            <li class="breadcrumb-item">Approve Leave Request List</li>
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
                    

                    <div class="col-lg-12"><!---start for list div-->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">STANDARD LEAVE REQUEST(S) to be Approve by [Current User Name]</h4>
                                <h6 class="card-subtitle">Arabic Text Here....</h6>
                                <div class="table-responsive">
                                    <table id="example23" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Request ID</th>
                                                <th>Staff ID</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Section</th>
                                                <th>Sponsor</th>
                                                <th>Leave Category</th>
                                                <th>Apllication Date</th>
                                                <th>No. of Days</th>
                                                <th>Last Status</th>
                                                <th>Reason</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="standardleave_application.php">OLT-1019828</a></td>
                                                <td><a href="standardleave_application.php">12345678</a></td>
                                                <td>Staff Name Here</td>
                                                <td>Information Technology</td>
                                                <td>Math Section</td>
                                                <td>TATI</td>
                                                <td>Absent Without Pay بدون راتب</td>
                                                <td>21/10/2018</td>
                                                <td>3</td>
                                                <td>Approved - HoD - Human Resource</td>
                                                <td>Reason Here</td>
                                            </tr>
                                             <tr>
                                                <td><a href="standardleave_application.php">OLT-1019828</a></td>
                                                <td><a href="standardleave_application.php">123456</td>
                                                <td>Staff Name Here</td>
                                                <td>Business Department</td>
                                                <td>Human Resource Section</td>
                                                <td>Al-Nawa</td>
                                                <td>Internal داخلية</td>
                                                <td>21/10/2018</td>
                                                <td>3</td>
                                                <td>Approved - HoD - Human Resource</td>
                                                <td>Reason Here</td>
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
</body>
</html>