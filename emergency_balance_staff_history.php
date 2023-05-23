<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            $header_info = new DbaseManipulation;
            if(isset($_GET['id'])) { //Mali ito, temporary lang ito muna, ayusin katulad ng ginawa sa HR 2.0
                $id = $header_info->cleanString($_GET['id']);
                $info = $header_info->singleReadFullQry("
                SELECT s.id, s.staffId, s.civilId, s.ministryStaffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.salutation, s.firstName, s.secondName, s.thirdName, s.lastName, s.firstNameArabic, s.secondNameArabic, s.thirdNameArabic, s.lastNameArabic, s.gender, s.maritalStatus, s.birthdate, s.joinDate, n.name as nationality, s.nationality_id, d.name as department, e.department_id, sc.name as section, e.section_id, j.name as jobtitle, e.jobtitle_id, p.title as staff_position, e.position_id, st.name as status, e.status_id, sp.name as specialization, e.specialization_id, q.name as qualification, e.qualification_id, spo.name as sponsor, e.sponsor_id, slr.name as salarygrade, e.salarygrade_id, e.employmenttype_id, pc.name as position_category, e.position_category_id 
                FROM staff as s 
                LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id 
                LEFT OUTER JOIN department as d ON d.id = e.department_id 
                LEFT OUTER JOIN section as sc ON sc.id = e.section_id 
                LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id
                LEFT OUTER JOIN staff_position as p ON p.id = e.position_id
                LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id 
                LEFT OUTER JOIN status as st ON st.id = e.status_id 
                LEFT OUTER JOIN specialization as sp ON sp.id = e.specialization_id 
                LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id
                LEFT OUTER JOIN sponsor as spo ON spo.id = e.sponsor_id
                LEFT OUTER JOIN salarygrade as slr ON slr.id = e.salarygrade_id
                LEFT OUTER JOIN position_category as pc ON pc.id = e.position_category_id
                WHERE e.isCurrent = 1 AND s.staffId = '$id'
                ");
                
                $mobile = $header_info->getContactInfo(1,$info['staffId'],'data');
                $email_add = $header_info->getContactInfo(2,$info['staffId'],'data');
                $data = new DbaseManipulation;
            } else {
                header("Location: emergency_balance_all_balance.php");
            }                                 
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div> -->
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-xs-18 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Emergency Leave Balance History</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Emergency Balance</a></li>
                                        <li class="breadcrumb-item">Staff Emergency Balance History</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header" style="border-bottom: double; border-color: #28a745">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="profiletimeline">
                                                        <div class="sl-item">
                                                            <div class="sl-left"> <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$info['staffId'].'.jpg'; ?>" alt="Staff" class="img-circle"/> </div>
                                                            <div class="sl-right">
                                                                <div>
                                                                    <span class="text-blue h5"><?php echo $info['staffName']; ?></span>
                                                                    <div class="like-comm">
                                                                        <span class="text-dark"> <?php echo $info['jobtitle']; ?> [Staff ID : <?php echo $info['staffId']; ?>]</span>
                                                                    </div>    
                                                                    <div class="like-comm">
                                                                        <span class="text-dark"> <?php echo $info['section']; ?></span>
                                                                        <span class="text-dark"> | <?php echo $info['department']; ?></span>
                                                                    </div>    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="profiletimeline">
                                                        <div class="sl-item">
                                                            <div class="sl-right">
                                                                <div>
                                                                    <span class="text-blue h5">Current Emergency Leave Balance : <?php echo $data->getEmergencyLeaveBalance($info['staffId'],'balance'); ?></span>
                                                                    <div class="like-comm">
                                                                        <span class="text-dark"> Pending Minus : <?php echo $data->getEmergencyLeavePending($info['staffId'],'balance'); ?></span>
                                                                    </div>
                                                                    <div class="like-comm">
                                                                        <span class="text-dark"> Sponsor : <?php echo $info['sponsor']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="intLeaveBalanceHistory" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>    
                                                            <th>Process Date</th>
                                                            <th>Request No</th>
                                                            <th>Status</th>
                                                            <th>Reason</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Added Leave</th>
                                                            <th>Minus Leave</th>
                                                            <th>Balance</th>
                                                            <th>Enter By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $i = 0; 
                                                            $rows = $data->readData("SELECT i.* FROM emergencyleavebalancedetails as i WHERE i.staffId = '$id' ORDER BY i.id");
                                                            $runningBalance = 0;
                                                            foreach ($rows as $row) {
                                                                $staffId = $row['staffId'];
                                                                if ($row['addType'] == 1) 
                                                                    $runningBalance = $runningBalance + $row['total'];
                                                                else
                                                                    $runningBalance = $runningBalance + $row['total'];  
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo ++$i."."; ?></td>
                                                                    <td><?php echo date('d/m/Y h:i:s',strtotime($row['created'])); ?></td>
                                                                    <td>
                                                                        <?php
                                                                            if(strpos($row['emergencyleavebalance_id'], 'STL-') !== false) {
                                                                        ?>
                                                                                <a href="standardleave_details.php?id=<?php echo $row['emergencyleavebalance_id']; ?>&uid=<?php echo $staffId; ?>"><?php echo $row['emergencyleavebalance_id']; ?></a>
                                                                        <?php
                                                                            } else {
                                                                                echo $row['emergencyleavebalance_id'];
                                                                            }
                                                                        ?>        
                                                                    </td>
                                                                    <td><?php echo $row['status']; ?></td>
                                                                    <td><?php echo "<small class='text-primary'>".$row['notes']."</small>"; ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                    <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                    <?php
                                                                        if($row['addType'] <= 2) {	
                                                                    ?>
                                                                            <td><?php echo '+'.$row['total']; ?></td>
                                                                            <td></td>
                                                                            <td><?php echo $runningBalance; ?></td>
                                                                    <?php
                                                                        }
                                                                        if($row['addType'] == 3) {	
                                                                    ?>
                                                                            <td></td>
                                                                            <td><?php echo $row['total']; ?></td>
                                                                            <td><?php echo $runningBalance; ?></td>
                                                                    <?php
                                                                        }
                                                                        // get the name of the staff who enterd the Balance -- Done by: Khamis
                                                                        $EnterByName='';
                                                                        $rows_GetStafName = $data->readData("SELECT CONCAT(firstName,' ',lastName) as Entered_By FROM staff WHERE staff.staffId = '".$row['createdBy']."'");
                                                                        foreach ($rows_GetStafName as $row1) {
                                                                            $EnterByName = $row1['Entered_By'];
                                                                        }
                                                                        ?>
                                                                        <td><?php echo $EnterByName; ?></td>
                                                                   
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