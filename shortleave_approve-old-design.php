<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoS')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Approve Short Leave Request</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Short Leave</li>
                                        <li class="breadcrumb-item active">Approve Short Leave</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0">
                                            <?php
                                                $basic_info = new DBaseManipulation;        
                                                $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
                                            ?>
                                            <h4 class="card-title">SHORT LEAVE REQUEST(S) to be Approve by <span class="text-primary">[<?php echo $logged_name." - ".$info['department']." - ".$info['sponsor']." - ".$info['jobtitle']; ?>]</span></h4>
                                            <h6>طلبات الاجازة القصيرة</h6>
                                        </div><!--end header-->

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request ID</th>
                                                            <th>Staff ID</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Sponsor</th>
                                                            <th>Leave Date</th>
                                                            <th>Start Time</th>
                                                            <th>Return Time</th>
                                                            <th>No. of Hours</th>
                                                            <th>Last Update</th>
                                                            <th>Last Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href="shortleave_application.php">OLT-1019828</a></td>
                                                            <td><a href="shortleave_application.php">12345678</a></td>
                                                            <td>Staff Name Here</td>
                                                            <td>Information Technology</td>
                                                            <td>Math Section</td>
                                                            <td>TATI</td>
                                                            <td>22/10/2018</td>
                                                            <td>09:40am</td>
                                                            <td>01:40pm</td>
                                                            <td>3</td>
                                                            <td>24/10/18 10:58:46</td>
                                                            <td>For Approval - HoS - Educational Services Section</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div><!--end table-responsive-->
                                        </div><!--end card body list-->
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                
                <?php include('include_scripts.php'); ?>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>