<?php    
    include('include_headers.php');
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Attendance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Attendance </li>
                                        <li class="breadcrumb-item">My Attendance </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <?php
                                            $basic_info = new DBaseManipulation;
                                            $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
                                            if(isset($_POST['searchByDate'])){
                                                $myAttendance = new DBaseManipulation;
                                                $startDate =  $myAttendance->cleanString($_POST['startDate']);
                                                $endDate = $myAttendance->cleanString($_POST['endDate']);
                                                $searched = true;
                                            } else {
                                                $searched = false;
                                            }
                                            
                                        ?>
                                        <form action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Date</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control daterange" />
                                                        <input type="hidden" name="startDate" class="form-control startDate" />
                                                        <input type="hidden" name="endDate" class="form-control endDate" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button name="searchByDate" class="btn btn-success waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-18">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Information!</h4>
                                        <small>Select starting and ending date in the date range picker and then click on Search Button.</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row"><!--for search results-->
                                <div class="col-lg-12 col-xs-18"><!---start for list div-->
                                    <div class="card">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <h4 class="card-title">Search Result</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="m-b-0">Staff : <span class="text-primary"><?php echo trim($info['staffName']); ?> [<?php echo $info['staffId']; ?>]</span></p>
                                                    <p class="m-b-0">Sponsor : <span class="text-primary"><?php echo $info['sponsor']; ?></span></p>
                                                    <p class="m-b-0">Department : <span class="text-primary"><?php echo $info['department']; ?></span></p>
                                                </div>
                                                <?php
                                                    if($searched) {
                                                ?>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Start Date : <span class="text-primary"><?php echo date("d/m/Y",strtotime($startDate)); ?></span></p>
                                                            <p class="m-b-0">End Date : <span class="text-primary"><?php echo date("d/m/Y",strtotime($endDate)); ?></span></p>
                                                            <p class="m-b-0">Num. of Working Days : <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Present : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Under Time : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Over Time : <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Absent : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Short Leave : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">On Leave :<span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Missing Time : <span class="text-primary"></span></p>      
                                                        </div>
                                                <?php
                                                    } else {
                                                ?>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Start Date : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">End Date : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Num. of Working Days : <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Present : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Under Time : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Over Time : <span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Absent : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">Short Leave : <span class="text-primary"></span></p>
                                                            <p class="m-b-0">On Leave :<span class="text-primary"></span></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p class="m-b-0">Missing Time : <span class="text-primary"></span></p>      
                                                        </div>
                                                <?php
                                                    }
                                                ?>        
                                            </div><!--end row-->
                                        </div><!--end card header-->
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>    
                                                            <th>Date</th>
                                                            <th>Time-In</th>
                                                            <th>Time-Out</th>
                                                            <th>Number of Hours</th>
                                                            <th>Overtime</th>
                                                            <th>Attendance Status</th>
                                                            <th>Leave Application</th>
                                                            <th>Application Number</th>
                                                            <th>Application Date</th>
                                                            <th>Application Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>21/01/2018</td>
                                                            <td>07:52:50</td>
                                                            <td>14:43:30</td>
                                                            <td>06:50:40</td>
                                                            <td>N/A</td>
                                                            <td><span class="bg-undertime">Under Time</span></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>21/01/2018</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>N/A</td>
                                                            <td><span class="bg-absent">Absent</span></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>21/01/2018</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>N/A</td>
                                                            <td><span class="bg-onleave">On Leave</span></td>
                                                            <td>Short Leave</td>
                                                            <td><span class="text-primary">SHL-2798760 </span></td>
                                                            <td>05/11/2018</td>
                                                            <td>For Approval - HoS - Computer Services Section</td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="bg-present">Present</span></td>
                                                            <td><span class="bg-absent">Absent</span></td>
                                                            <td><span class="bg-onleave">On Leave</span></td>
                                                            <td><span class="bg-undertime">Under Time</span></td>
                                                            <td><span class="bg-overtime">Over Time</span></td>
                                                            <td><span class="bg-weekend">Weekend</span></td>
                                                            <td><span class="bg-missingtime">Missing Time</span></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                        </div><!--end card body-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-6-->
                            </div><!--end row for search results-->
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
                    // Material Date picker    
                    $(function() {
                    $('.daterange').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $(".startDate").val(start.format('YYYY-MM-DD'));
                        $('.endDate').val(end.format('YYYY-MM-DD'));
                        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                    });
                    });                            

                    //$('.daterange').daterangepicker();
                    $('.daterange').keypress(function(e) {
                        e.preventDefault();
                    });
                </script>
            </body>

</html>