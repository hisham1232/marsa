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
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php  include('menu_top.php'); ?>   
                    </header>
                        <?php  include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">All Active Staff List</h3>
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
                                            <h4 class="card-title">All Active Staff List <!-- <small>(Admin/HR Staff Access)</small>--></h4>
                                            <h6 class="card-subtitle">قائمة كل الموظفين الذين هم على رأس عملهم</h6>
                                            <div class="table-responsive">
                                                <table id="dynamicTableListAll" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>StaffID</th>
                                                            <th>CivilID</th>
                                                            <th>Title</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Section</th>
                                                            <th>Designation</th>
                                                            <th>Sponsor Category/Sector</th>
                                                            <th>Sponsor</th>
                                                            <th>Qualification</th>
                                                            <th>Specialization</th>
                                                            <th>Position</th>
                                                            <th>FinancialGrade</th>
                                                            <th>Status</th>
                                                            <th>EmploymentStatus</th>
                                                            <th>Gender</th>
                                                            <th>Nationality A</th>
                                                            <th>Nationality B</th>
                                                            <th>JoinDate</th>
                                                            <th>BirthDate</th>
                                                            <th>Age</th>
                                                            <th>Passport</th>
                                                            <th>Visa</th>
                                                            <th>WorkEmail</th>
                                                            <th>PersonalEmail</th>
                                                            <th>GSM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $data = new DbaseManipulation;
                                                            $rows = $data->readData("SELECT s.id, s.salutation, s.staffId, s.civilId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, 
                                                                s.gender, n.name as nationality, d.name as department, sc.name as section, j.name as jobtitle, 
                                                                q.name as qualification, spc.name as specialization, cp.title as college_position, sps.name as sponsor,
                                                                e.joinDate, s.birthdate, sts.name as status, sg.name as salarygrade, e.employmenttype_id, e.sponsor_id, s.nationality_id
                                                                FROM staff as s 
                                                                LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id 
                                                                LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                                                LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                                                                LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
                                                                LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id 
                                                                LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id
                                                                LEFT OUTER JOIN specialization as spc ON spc.id = e.specialization_id 
                                                                LEFT OUTER JOIN staff_position as cp ON cp.id = e.position_id
                                                                LEFT OUTER JOIN sponsor as sps ON sps.id = e.sponsor_id 
                                                                LEFT OUTER JOIN status as sts ON sts.id = e.status_id 
                                                                LEFT OUTER JOIN salarygrade as sg ON sg.id = e.salarygrade_id 
                                                                WHERE e.isCurrent = 1 AND e.status_id = 1");
                                                            $i = 0;
                                                            foreach ($rows as $row) {
                                                                $age = date('Y',time()) - date('Y',strtotime($row['birthdate']));
                                                                if($row['employmenttype_id'] == 1)
                                                                    $empType = 'Full Time';
                                                                else
                                                                    $empType = 'Part Time';

                                                                if($row['nationality_id'] == 136)
                                                                    $nat = 'Omani';
                                                                else
                                                                    $nat = 'Non-Omani';
                                                                if($row['sponsor_id'] == 1)
                                                                        $sponsorCat = 'MOM';    
                                                                    else
                                                                        $sponsorCat = 'Private';
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo ++$i.'.'; ?></td>
                                                                    <td><a target="_blank" href="staff_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['staffId']; ?></a></td>
                                                                    <td><?php echo $row['civilId']; ?></td>
                                                                    <td><?php echo $row['salutation']; ?></td>
                                                                    <td><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></td>
                                                                    <td><?php echo $row['department']; ?></td>
                                                                    <td><?php echo $row['section']; ?></td>
                                                                    <td><?php echo $row['jobtitle']; ?></td>
                                                                    <td><?php echo $sponsorCat; ?></td>
                                                                    <td><?php echo $row['sponsor']; ?></td>
                                                                    <td><?php echo $row['qualification']; ?></td>
                                                                    <td><?php echo $row['specialization']; ?></td>
                                                                    <td><?php echo $row['college_position']; ?></td>
                                                                    <td><?php echo $row['salarygrade']; ?></td>
                                                                    <td><?php echo $row['status']; ?></td>
                                                                    <td><?php echo $empType; ?></td>
                                                                    <td><?php echo $row['gender']; ?></td>
                                                                    <td><?php echo $nat; ?></td>
                                                                    <td><?php echo $row['nationality']; ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['joinDate'])); ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['birthdate'])); ?></td>
                                                                    <td><?php echo $age; ?></td>
                                                                    <td><?php echo $data->getPassportNo($row['staffId'],'number'); ?></td>
                                                                    <td><?php echo $data->getVisaNo($row['staffId'],'number'); ?></td>
                                                                    <td><?php echo $data->getContactInfo(2,$row['staffId'],'data'); ?></td>
                                                                    <td><?php echo $data->getContactInfo(3,$row['staffId'],'data'); ?></td>
                                                                    <td><?php echo $data->getContactInfo(1,$row['staffId'],'data'); ?></td>
                                                                </tr>
                                                                <?php
                                                                $age = 0; 
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