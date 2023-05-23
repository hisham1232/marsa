 <aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <?php 
                    if($staffId == '107036' || $staffId == '111053' || $staffId == '114080' || $staffId == '413047') {
                        ?>
                        <li>
                            <a href="http://apps.nct.edu.om/hrmd2_old/ajaxpages/logins/byPassLog.php?slid=<?php echo $staffId; ?>" target="_blank"><i class="fas fa-building"></i> Old System</a>
                        </li>
                        <?php
                    }
                ?>
                <li>
                    <a href="index.php?linkid=1"><i class="fas fa-home"></i> Home</a>
                </li>
                <?php
                    $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HoD_HoC') || $staffId == '107034') ? true : false; 
                    if($allowed){
                        ?>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-trophy"></i><span class="hide-menu"> Awarding</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="award_add.php"><i class="ti-link"></i>New Recommendation</a></li>
                                <li><a href="award_my_recommendation.php"><i class="ti-link"></i>My Recommendation List</a></li>
                                <?php 
                                    if($staffId == '119084' || $staffId == '121101' || $staffId == '107036') {
                                    ?>    
                                    <li><a href="award_current_recommendation_list.php"><i class="ti-link"></i>Current Recommendation List</a></li>
                                    <li><a href="award_recommendation_list_readonly.php"><i class="ti-link"></i>Recommendation List - Read Only</a></li>
                                    <li><a href="award_winner_list.php"><i class="ti-link"></i>Winner List</a></li>
                                    <li><a href="award_recommendation_list_all.php"><i class="ti-link"></i>All Recommendation List</a></li>
                                    <li><a href="award_statistics_dept.php"><i class="ti-link"></i>Statistics by Department</a></li>
                                    <li><a href="award_statistics_staff.php"><i class="ti-link"></i>Statistics by Staff</a></li>
                                    <?php 
                                    } else if ($staffId == '107034') {
                                        ?>
                                        <li><a href="award_winner_list.php"><i class="ti-link"></i>Winner List</a></li>
                                        <?php
                                    }
                                ?>    
                                
                                <li><a href="award_about.php"><i class="ti-link"></i>About Awarding</a></li>
                            </ul>
                        </li>
                        <?php 
                    }
                    $allowed2 = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HoD_HoC')) ? true : false;
                    if($allowed2) {
                        ?>
                        <!-- GRIEVANCE MODULE -->
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-envelope"></i><span class="hide-menu"> Staff Grievance</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="grievance_new.php"><i class="ti-link"></i>File A Grievance</a></li>
                                <li><a href="grievance_my_application.php"><i class="ti-link"></i>My Grievance Application</a></li>
                                <li><a href="grievance_my_actions.php"><i class="ti-link"></i>My Grievance Actions</a></li>
                                <li><a href="grievance_list_all.php"><i class="ti-link"></i>All Grievance List</a></li>
                                <li><a href="grievance_stat_type.php"><i class="ti-link"></i>Statistics by Type</a></li>
                                <li><a href="grievance_stat_status.php"><i class="ti-link"></i>Statistics by Status</a></li>
                                <li><a href="grievance_stat_complainant.php"><i class="ti-link"></i>Statistics by Complainant</a></li>
                                <li><a href="grievance_stat_respondent.php"><i class="ti-link"></i>Statistics by Respondent</a></li>
                                <li><a href="grievance_about.php"><i class="ti-link"></i>About Staff Grievance</a></li>
                                
                            </ul>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-envelope"></i><span class="hide-menu"> Staff Grievance</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="grievance_new.php"><i class="ti-link"></i>File A Grievance</a></li>
                                <li><a href="grievance_my_application.php"><i class="ti-link"></i>My Grievance Application</a></li>
                                <li><a href="grievance_my_actions.php"><i class="ti-link"></i>My Grievance Actions</a></li>
                            </ul>
                        </li>
                        <?php
                    }
                ?>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-diagnoses"></i><span class="hide-menu"> Staff Appraisal</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <?php
                            $now_date = date('Y-m-d');
                            $check = new DbaseManipulation;
                            $app = new DbaseManipulation;
                            $row = $app->singleReadFullQry("SELECT TOP 1 * FROM appraisal_type WHERE staff_id = $staffId");
                            if($app->totalCount != 0) {
                                $appraisal_type_id = $row['appraisal_type'];
                                if($appraisal_type_id == 1) {
                                    $rowCheckTech = $check->singleReadFullQry("SELECT * FROM appraisal_settings WHERE self_end >= '$now_date' AND self_start <= '$now_date' AND status = 'OPEN'");
                                    if($check->totalCount != 0) { 
                                        ?>
                                        <li><a href="appraisal_homepage.php"><i class="ti-link"></i>Appraisal Homepage</a></li>
                                        <li><a href="appraisal_technician.php"><i class="ti-link"></i>My Appraisal</a></li>
                                        <?php
                                    }
                                } else if ($appraisal_type_id == 2) {
                                    $rowCheckTech = $check->singleReadFullQry("SELECT * FROM appraisal_settings WHERE self_end >= '$now_date' AND self_start <= '$now_date' AND status = 'OPEN'");
                                    if($check->totalCount != 0) { 
                                        ?>
                                        <li><a href="appraisal_homepage.php"><i class="ti-link"></i>Appraisal Homepage</a></li>
                                        <li><a href="appraisal_lecturer.php"><i class="ti-link"></i>My Appraisal</a></li>
                                        <?php
                                    }
                                } else if ($appraisal_type_id == 3) {
                                    $rowCheckTech = $check->singleReadFullQry("SELECT * FROM appraisal_settings WHERE self_end >= '$now_date' AND self_start <= '$now_date' AND status = 'OPEN'");
                                    if($check->totalCount != 0) { 
                                        ?>
                                        <li><a href="appraisal_homepage.php"><i class="ti-link"></i>Appraisal Homepage</a></li>
                                        <li><a href="appraisal_adminstaff.php"><i class="ti-link"></i>My Appraisal</a></li>
                                        <?php
                                    }
                                } else if ($appraisal_type_id == 4) {
                                    $rowCheckTech = $check->singleReadFullQry("SELECT * FROM appraisal_settings WHERE manager_end >= '$now_date' AND manager_start <= '$now_date' AND status = 'OPEN'");
                                    if($check->totalCount != 0) { 
                                        ?>
                                        <li><a href="appraisal_hos.php"><i class="ti-link"></i>My Appraisal</a></li>
                                        <?php
                                    }
                                } else if ($appraisal_type_id == 5) {
                                    $rowCheckTech = $check->singleReadFullQry("SELECT * FROM appraisal_settings WHERE manager_end >= '$now_date' AND manager_start <= '$now_date' AND status = 'OPEN'");
                                    if($check->totalCount != 0) { 
                                        ?>
                                        <li><a href="appraisal_hods.php"><i class="ti-link"></i>My Appraisal</a></li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li><a href="#"><i class="ti-link"></i>My Appraisal NOT FOUND</a></li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li><a href="#"><i class="ti-link"></i>My Appraisal NOT FOUND X</a></li>
                                <?php
                                    }
                            ?>                        
                        <!-- <li><a href="appraisal_status_list.php"><i class="ti-link"></i>Appraisal Status</a></li> -->
                        <!-- Check dito kung anong klaseng homepage bibigay mo, homepage_hos, homepage_hod, homepage_staff, homepage_dean, etc. -->
                        <?php 
                            if($appraisal_type_id == 1) {
                                ?>
                                <?php
                            } else if($appraisal_type_id == 2) {
                                ?>
                                <?php
                            } else if($appraisal_type_id == 3) {
                                ?>
                                <?php
                            } else if($appraisal_type_id == 4) {
                                ?>
                                <li><a href="appraisal_allstafflist_hos.php"><i class="ti-link"></i>All Appraisal List</a></li>
                                <li><a href="appraisal_homepage_hos.php"><i class="ti-link"></i>Appraisal Homepage</a></li>
                                <?php
                            } else if($appraisal_type_id == 5) {
                                    if($staffId =='107036') {
                                        ?>
                                        <li><a href="appraisal_traininglist.php"><i class="ti-link"></i>Staff Training List</a></li>
                                        <?php 
                                    }
                                    if($myPositionId != 1) {
                                        ?>
                                        <li><a href="appraisal_allstafflist_hod.php"><i class="ti-link"></i>All Appraisal List</a></li>
                                        <li><a href="appraisal_homepage_hod.php"><i class="ti-link"></i>Appraisal Homepage</a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="appraisal_homepage_dean.php"><i class="ti-link"></i>Appraisal Homepage</a></li>
                                        <li><a href="appraisal_allstafflist.php"><i class="ti-link"></i>All Appraisal List</a></li>
                                        <li><a href="appraisal_traininglist.php"><i class="ti-link"></i>Staff Training List</a></li>
                                        <?php
                                    }
                                ?>
                                <?php
                            }
                            ?>
                        <li><a href="appraisal_about.php"><i class="ti-link"></i>About Appraisal</a></li>
                    </ul>
                </li>




                <?php        
                $subMenu = new DbaseManipulation;
                $sql = "SELECT m.id, m.user_type_id, m.menu_left_main_id, m.active, a.menu_name, a.appearance FROM access_menu_matrix as m 
                LEFT OUTER JOIN access_menu_left_main AS a ON a.id = m.menu_left_main_id
                WHERE m.user_type_id = $user_type
                AND m.active = 1 AND a.active = 1 AND m.id != 1
                ORDER BY a.appearance ASC";
                $rowsOut = $helper->readData($sql);
                ?>
                
                <?php
                $approverOnly = new DbaseManipulation;
                foreach($rowsOut as $rowOut){
                    $menu_left_id = $rowOut['menu_left_main_id'];
                    ?>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><?php echo $rowOut['menu_name']; ?></a>
                            <ul aria-expanded="false" class="collapse">
                                <?php
                                    if($menu_left_id == 13) {
                                        $app = $approverOnly->singleReadFullQry("SELECT staff_id FROM taskapprover WHERE staff_id = '$staffId' AND status = 'Active'");
                                        if($approverOnly->totalCount != 0 || $user_type == 0) {
                                            $query = "SELECT sub.*, p.page_name, p.menu_name_sub, p.menu_left_id FROM access_menu_matrix_sub as sub 
                                            LEFT OUTER JOIN access_menu_left_sub as p ON p.id = sub.access_menu_left_sub_id
                                            WHERE sub.user_type_id = $user_type AND p.menu_left_id = $menu_left_id AND sub.active = 1
                                            ORDER BY sub.id ASC";
                                            $rows = $subMenu->readData($query);
                                            foreach($rows as $row) {
                                                ?>
                                                <li><a href="<?php echo $row['page_name']; ?>?linkid=<?php echo $row['id']; ?>" title="<?php echo $row['menu_name_sub']; ?>"><i class="ti-link"></i><?php echo $row['menu_name_sub']; ?></a></li>
                                                <?php
                                            }
                                        }    
                                    } else {
                                        $query = "SELECT sub.*, p.page_name, p.menu_name_sub, p.menu_left_id FROM access_menu_matrix_sub as sub 
                                        LEFT OUTER JOIN access_menu_left_sub as p ON p.id = sub.access_menu_left_sub_id
                                        WHERE sub.user_type_id = $user_type AND p.menu_left_id = $menu_left_id AND sub.active = 1
                                        ORDER BY sub.id ASC";
                                        $rows = $subMenu->readData($query);
                                        foreach($rows as $row) {
                                            ?>
                                            <li><a href="<?php echo $row['page_name']; ?>?linkid=<?php echo $row['id']; ?>" title="<?php echo $row['menu_name_sub']; ?>"><i class="ti-link"></i><?php echo $row['menu_name_sub']; ?></a></li>
                                            <?php
                                        }
                                    }    
                                ?>
                            </ul>
                        </li>
                    <?php
                }
                if($staffId == '196058' || $staffId == '404009') {
                    ?>
                        <li>
                            <a href="attendance_all.php?linkid=42"><i class="fa fa-calendar-alt"></i> Staff Attendance</a>
                        </li>
                        <li>
                            <a href="attendance_search_bystaff.php?linkid=41"><i class="fa fa-user"></i> Attendance By Staff</a>
                        </li>
                    <?php
                }
            ?>   
                        <li>
                            <a href="?logout=true"><i class="fa fa-power-off"></i> Logout</a>
                        </li> 
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>