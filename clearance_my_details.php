<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        $id = $helper->cleanString($_GET['id']);
        $row = $helper->singleReadFullQry("SELECT * FROM clearance WHERE id = $id AND staffId = '$staffId'");
        if($helper->totalCount == 0) 
            $allowed = false;
        else 
            $allowed = true;
        if($allowed){  
            $requestNo = $row['requestNo'];
            ?>
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Clearance Application Details</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance </li>
                                        <li class="breadcrumb-item">My Clearance Details</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow">
                                            <h4 class="card-title font-weight-bold">Clearance Application Status and History</h4>
                                            <div class="row">
                                                <?php
                                                    $basic_info = new DBaseManipulation;
                                                    $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, s.gender, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.joinDate, n.name as nationality, q.name as qualification FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id WHERE s.staffId = '$staffId' AND e.isCurrent = 1 and e.status_id = 1");
                                                ?>
                                                <div class="col-lg-6">
                                                    <p class="m-b-0">Staff ID: <span class="text-primary"><?php echo $staffId; ?></span></p>
                                                    <p class="m-b-0">Staff Name: <span class="text-primary"><?php echo $info['staffName']; ?></span></p>
                                                    <p class="m-b-0">Department: <span class="text-primary"><?php echo $info['department']; ?></span></p>
                                                    <p class="m-b-0">Section: <span class="text-primary"><?php echo $info['section']; ?></span></p>
                                                    <p class="m-b-0">Job Title: <span class="text-primary"><?php echo $info['jobtitle']; ?></span></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $info['sponsor']; ?></span></p>
                                                    <p class="m-b-0">Qualification: <span class="text-primary"><?php echo $info['qualification']; ?></span></p>
                                                    <p class="m-b-0">Join Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></p>
                                                    <p class="m-b-0">Nationality: <span class="text-primary"><?php echo $info['nationality']; ?></span></p>
                                                    <p class="m-b-0">Gender: <span class="text-primary"><?php echo $info['gender']; ?></span></p>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-24">
                                                        <div class="card">
                                                            <div class="card-header m-b-0 p-b-0">
                                                                <div class="d-flex flex-wrap">
                                                                    <div>
                                                                        <h3 class="card-title">My Clearance Approval Progress History <span class="badge badge-primary"><?php echo $requestNo; ?></span></h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Clearance Section</th>
                                                                                <th>Approver Name</th>
                                                                                <th>Status</th>
                                                                                <th>Notes/Comments</th>
                                                                                <th>Date Updated</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php 
                                                                                $rows = $helper->readData("SELECT cas.*, p.name as clearanceSection, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as approverName FROM clearance_approval_status as cas LEFT OUTER JOIN clearance_process as p ON cas.clearance_process_id = p.id LEFT OUTER JOIN staff as s ON cas.approverStaffId = s.staffId WHERE cas.clearance_id = $id ORDER BY cas.id");
                                                                                $i = 0;
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                                        <td><?php echo $row['clearanceSection']; ?></td>
                                                                                        <td><?php echo $row['approverName']; ?></td>
                                                                                        <td><?php echo $row['status']; ?></td>
                                                                                        <td><?php echo $row['comment']; ?></td>
                                                                                        <td><?php echo date('d/m/Y H:i:s',strtotime($row['dateUpdated'])); ?></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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