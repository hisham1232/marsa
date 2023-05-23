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
                        <h3 class="text-themecolor m-b-0 m-t-0">Deligation Request List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item">Deligation</li>
                            <li class="breadcrumb-item">Deligation Request List</li>
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
                                <h4 class="card-title">Deligation Request List</h4>
                                <h6 class="card-subtitle">قائمة طلبات التفويض</h6>
                                <div class="table-responsive">
                                   <table id="example23" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Request ID</th>
                                                                <th>Deligate by Staff</th>
                                                                <th>Department</th>
                                                                <th>Role Deligated To You</th>
                                                                <th>Start Date</th>
                                                                <th>End Date Date</th>
                                                                <th>Days</th>
                                                                <th>Note</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>OLT-1234567</td>
                                                                <td>Staff Name Here</td>
                                                                <td>Information Technology</td>
                                                                <td><span class="text-primary">Approve Standard Leave,Approve Clearance</span></td>
                                                                <td>21/10/2018</td>
                                                                <td>23/10/2018</td>
                                                                <td>3</td>
                                                                <td>text</td>
                                                                 <td><a href="deligation_accept.php" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>OLT-1234567</td>
                                                                <td>Staff Name Here</td>
                                                                <td>Information Technology</td>
                                                                <td><span class="text-primary">Approve Standard Leave,Approve Clearance</span></td>
                                                                <td>21/10/2018</td>
                                                                <td>23/10/2018</td>
                                                                <td>3</td>
                                                                <td>text</td>
                                                                <td><a href="deligation_accept.php" class="btn btn btn-outline-info btn-sm" role="button" aria-pressed="true" title="Click to view details"><i class="fas fa-angle-double-right"></i> View</a>
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>



                                </div><!--end table-responsive-->
                            </div><!--end card body-->
                        </div><!--end card-->            


                        <!---no record --->

                        <div class="card">
                                            <div class="card-body bg-light-warning2">
                                                <div class="d-flex flex-wrap">
                                                    <div style="margin:auto !important;">
                                                        <h1 class="text-info" style="font-size: 110px !important;
    font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                            <center><i class="fas fa-clipboard-list"></i></center>
                                                        </h1>
                                                        <h2 class="text-danger">NO Records for APPROVAL Found!</h2>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    </div><!--end col-lg-12-->
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