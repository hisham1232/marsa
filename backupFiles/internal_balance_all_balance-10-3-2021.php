<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
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
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">All Internal Leave Balance</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Internal Balance</a></li>
                                        <li class="breadcrumb-item">All Internal Balance </li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">List of All Internal Leave Balance</h4>
                                            <h6 class="card-subtitle">قائمة بكل رصيد الإجازات الداخلية</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Staff ID</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Job Title</th>
                                                            <th>Sponsor</th>
                                                            <th>Balance</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 0; 
                                                            $data = new DbaseManipulation;
                                                            $rows = $data->readData("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, d.name as department, sc.name as section, j.name as jobtitle, sp.name as sponsor, e.status_id, e.department_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id WHERE e.status_id = 1 AND e.isCurrent = 1");
                                                            foreach ($rows as $row) {
                                                                $staff_Id = $row['staffId'];
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo ++$i."."; ?></td>
                                                                    <td><?php echo $staff_Id; ?></td>
                                                                    <td><?php echo $row['staffName']; ?></td>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <th><?php echo $row['jobtitle']; ?></th>
                                                                    <td><?php echo $row['sponsor']; ?></td>
                                                                    <td><?php echo $data->getInternalLeaveBalance($staff_Id,'balance'); ?></td>
                                                                    <td>
                                                                        <a href="internal_balance_staff_history.php?id=<?php echo $staff_Id; ?>" title="Click to view balance history"><i class="fas fa-folder-open fa-2x"></i></a>
                                                                        <a href="internal_balance_add.php?uid=<?php echo $staff_Id; ?>&did=<?php echo $row['department_id']; ?>" title="Click to ADD Internal Leave Balance"><i class="fas fa-plus-circle fa-2x"></i></a>
                                                                        <a href="internal_balance_minus.php?uid=<?php echo $staff_Id; ?>&did=<?php echo $row['department_id']; ?>" title="Click to MINUS Internal Leave Balance"><i class="fas fa-minus-circle fa-2x"></i></a>
                                                                    </td>
                                                                </tr>
                                                        <?php 
                                                            }
                                                            $i++;
                                                        ?>        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
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