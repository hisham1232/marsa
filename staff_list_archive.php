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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Archive Staff List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">College Staff </li>
                                        <li class="breadcrumb-item">Archive Staff</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Archive Staff List <small><!--(Admin/HR Staff Access)--> <span class="text-danger"><i class="fa fa-info-circle"></i> Staff that are NOT ACTIVE in the college. Click on each row if you want to modify a record.</span> </small></h4>
                                            <h6 class="card-subtitle">قائمة الموظفين الذين هم خارج رأس عملهم</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTableListAll" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
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
                                                            //$rows = $data->readData("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id WHERE e.status_id != 1 AND e.isCurrent = 1");
                                                            $rows = $data->readData("SELECT s.id, max(s.staffId) as staffId, max(concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName)) as staffName, max(s.gender) as gender, max(n.name) as nationality, max(d.name) as department, max(sc.name) as section, max(j.name) as jobtitle, max(e.status_id ) as status_id
                                                                FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                                                LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
                                                                LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id WHERE e.status_id != 1 GROUP BY s.id ORDER BY staffName");
                                                            $i = 0;
                                                            foreach ($rows as $row) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo ++$i.'.'; ?></td>
                                                                    <td><a target="_blank" href="staff_details_archive.php?id=<?php echo $row['id']; ?>"><?php echo $row['staffId']; ?></a></td>
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