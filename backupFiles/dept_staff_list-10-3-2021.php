<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if($user_type == 3) {
                $filter = ' AND e.department_id = '.$logged_in_department_id;
            } else if ($user_type == 4) {
                $filter = ' AND e.section_id = '.$logged_in_section_id;
            } else {
                $filter = ' AND 1';
            }
            $departmentName = $helper->fieldNameValue("department",$logged_in_department_id,'name');
            $sectionName = $helper->fieldNameValue("section",$logged_in_section_id,'name');                     
            ?>  
            <body class="fix-header fix-sidebar card-no-border">
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                    <?php    include('menu_top.php'); ?>   
                    </header>
                    <?php   include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Staff List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">My Department </li>
                                        <li class="breadcrumb-item">My Staff List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Staff List [<?php echo $departmentName.' / '.$sectionName; ?>]</h4>
                                            <h6 class="card-subtitle">قائمة الموظفين</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Staff ID</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Job Title</th>
                                                            <th>GSM</th>
                                                            <th>Leave Balance</th>
                                                            <th>Time In</th>
                                                            <th>Time Out</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $getTimeIn = new DbaseManipulation;
                                                            $getTimeOut = new DbaseManipulation;
                                                            $data = new DbaseManipulation;
                                                            $ngayonDate = date("Y-m-d",time());
                                                            $rows = $data->readData("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON sc.id = e.section_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id WHERE e.status_id = 1 AND e.isCurrent = 1".$filter);
                                                            foreach ($rows as $row) {
                                                                $staffAydi = $row['staffId'];
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $row['staffId']; ?></td>
                                                                    <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['jobtitle']; ?></td>
                                                                    <td><?php echo $data->getContactInfo(1,$row['staffId'],'data'); ?></td>
                                                                    <td><?php echo $data->getInternalLeaveBalance($row['staffId'],'balance'); ?></td>
                                                                    <td>
                                                                        <?php
                                                                            $rowTime = $getTimeIn->singleReadFullQry("SELECT TOP 1 inTime FROM fpuserlog WHERE userid = '$staffAydi' AND recordDate = '$ngayonDate' AND inEvent = 'IN' ORDER BY recordDate DESC");
                                                                            if($getTimeIn->totalCount != 0) {
                                                                                $oras = date('h:i:s A',strtotime($rowTime['inTime']));
                                                                            } else {
                                                                                $oras = "<span class='text-danger'>No Time-in Found!</span>";
                                                                            }
                                                                            echo $oras;
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                            $rowTimeOut = $getTimeOut->singleReadFullQry("SELECT TOP 1 outTime FROM fpuserlog WHERE userid = '$staffAydi' AND recordDate = '$ngayonDate' AND outEvent = 'OUT' ORDER BY recordDate DESC");
                                                                            if($getTimeOut->totalCount != 0) {
                                                                                $oras2 = date('h:i:s A',strtotime($rowTimeOut['outTime']));
                                                                            } else {
                                                                                $oras2 = "<span class='text-danger'>No Time-out Found!</span>";
                                                                            }
                                                                            echo $oras2;
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="staff_basic_info.php?id=<?php echo $row['id']; ?>" title="Click to view staff profile"><i class="fas fa-briefcase fa-2x text-primary"></i></a>
                                                                        <a href="staff_basic_attendance.php?id=<?php echo $row['staffId']; ?>" title="Click to view staff attendance"><i class="fas fas fa-calendar-alt fa-2x text-green"></i></a>
                                                                        <a href="staff_basic_standardleave.php?id=<?php echo $row['staffId']; ?>" title="Click to view staff standard leave"><i class="fas fa-calculator fa-2x text-warning"></i></a>
                                                                        <a href="staff_basic_shortleave.php?id=<?php echo $row['staffId']; ?>" title="Click to view staff short leave"><i class="fas fa-clock fa-2x text-success"></i></a>
                                                                    </td>
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