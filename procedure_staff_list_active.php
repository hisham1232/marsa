<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
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
                        <?php  include('menu_top.php'); ?>   
                    </header>
                        <?php  include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">All Active Staff List (Stored Procedure/NO PARAMS)</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">College Staff </li>
                                        <li class="breadcrumb-item">Active Staff</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">All Active Staff List <small>(Admin/HR Staff Access)</small></h4>
                                            <h6 class="card-subtitle">قائمة الموظفين الذين هم على رأس عملهم</h6>
                                            <div class="table-responsive">
                                                <table id="example23" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Staff ID</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Job Title</th>
                                                            <th>Gender</th>
                                                            <th>Nationality</th>
                                                            <th>GSM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $data = new DbaseManipulation;
                                                            $rows = $data->readData("CALL getActiveStaffOnly()");
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <tr class="clickable-row" data-href='procedure_staff_details.php?id=<?php echo $row['id']; ?>'>
                                                                    <td><?php echo $row['staffId']; ?></td>
                                                                    <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['jobtitle']; ?></td>
                                                                    <td><?php echo $row['gender']; ?></td>
                                                                    <td><?php echo $row['nationality']; ?></td>
                                                                    <td><?php echo $data->getContactInfo(1,$row['staffId'],'data'); ?></td>
                                                                </tr>
                                                        <?php 
                                                            }
                                                        ?>
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
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>