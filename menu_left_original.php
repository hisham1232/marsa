 <aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a href="index.php" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu"> College Staffs</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="staff_generate_id.php"><i class="ti-link"></i>Generate Staff ID</a></li>
                        <li><a href="staff_add_new.php"><i class="ti-link"></i>Add New Staff</a></li>
                        <li><a href="staff_list_active.php"><i class="ti-link"></i>All Active Staff</a></li>
                        <li><a href="staff_search_basic.php"><i class="ti-link"></i>Search Staff</a></li>
                        <li><a href="staff_search_advance.php"><i class="ti-link"></i>Advance Search Staff</a></li>
                        <li><a href="staff_list_archive.php"><i class="ti-link"></i>Archive Staff</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-briefcase"></i>
                        <span class="hide-menu"> 
                            <?php
                                if($user_type == 3) //HoD/HoC
                                    echo "My Department";
                                else if ($user_type == 4) //HoS
                                    echo "My Section";
                                else
                                    echo "NCT Staff (Temp)";        
                            ?>
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="dept_staff_list.php"><i class="ti-link"></i>Staff List</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-handshake"></i><span class="hide-menu"> Delegations</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="delegation_create.php"><i class="ti-link"></i>Create Delegation</a></li>
                        <li><a href="delegation_request_list.php"><i class="ti-link"></i>Delegation Request List</a></li>
                        <li><a href="delegation_created_list.php"><i class="ti-link"></i>My Created Delegation List</a></li>
                        <li><a href="delegation_appointed.php"><i class="ti-link"></i>My Delegation List</a></li>
                        <li><a href="delegation_list_all.php"><i class="ti-link"></i>ALL Delegation List</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="far fa-id-card"></i><span class="hide-menu"> Short Leave</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="shortleave_application.php"><i class="ti-link"></i>Apply Short Leave</a></li>
                        <li><a href="shortleave_my_list.php"><i class="ti-link"></i>My Short Leave List</a></li>
                        <li><a href="shortleave_approve.php"><i class="ti-link"></i>Approve Short Leave</a></li>
                        <li><a href="shortleave_my_approvals.php"><i class="ti-link"></i>My Approval List</a></li>
                        <li><a href="shortleave_all_list.php"><i class="ti-link"></i>All Short Leave List</a></li>
                        <li><a href="shortleave_search.php"><i class="ti-link"></i>Search Short Leave</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="far fa-newspaper"></i><span class="hide-menu"> Standard Leave</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="standardleave_application.php"><i class="ti-link"></i>Apply Standard Leave</a></li>
                        <li><a href="standardleave_my_list.php"><i class="ti-link"></i>My Standard Leave List</a></li>
                        <li><a href="standardleave_approve.php"><i class="ti-link"></i>Approve Standard Leave</a></li>
                        <li><a href="standardleave_my_approvals.php"><i class="ti-link"></i>My Approval List</a></li>
                        <li><a href="standardleave_all_list.php"><i class="ti-link"></i>All Standard Leave List</a></li>
                        <li><a href="standardleave_add_others.php"><i class="ti-link"></i>Add Staff Other Leave</a></li>
                        <li><a href="standardleave_search.php"><i class="ti-link"></i>Search Standard Leave</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="far fa-money-bill-alt"></i><span class="hide-menu"> My Leave Balance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="leavebalance_my_internal.php"><i class="ti-link"></i>My Internal Leave Bal</a></li>
                        <li><a href="leavebalance_my_emergency.php"><i class="ti-link"></i>My Emergency Leave Bal</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-cubes"></i><span class="hide-menu"> Internal Balance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="internal_balance_all_balance.php"><i class="ti-link"></i>All Internal Balance</a></li>
                        <li><a href="internal_balance_add.php"><i class="ti-link"></i>Add Internal Balance</a></li>
                        <li><a href="internal_balance_add_sponsor.php"><i class="ti-link"></i>Add Internal By Sponsor</a></li>
                        <li><a href="internal_balance_all_added.php"><i class="ti-link"></i>All Added Internal</a></li>
                        <li><a href="internal_balance_minus.php"><i class="ti-link"></i>Minus Internal Balance</a></li>
                        <li><a href="internal_balance_all_minus.php"><i class="ti-link"></i>All Minus Internal</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="far fa-hospital"></i><span class="hide-menu"> Emergency Balance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="emergency_reset.php"><i class="ti-link"></i>Reset Emergency Bal</a></li>
                        <li><a href="emergency_add.php"><i class="ti-link"></i>Add Staff Emergency Bal</a></li>
                        <li><a href="emergency_balance_all_balance.php"><i class="ti-link"></i>All Emergency Balance</a></li>
                        <li><a href="emergency_all_minus.php"><i class="ti-link"></i>All Minus Emergency</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-calendar-alt"></i><span class="hide-menu"> Attendance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="attendance_my_attendance.php"><i class="ti-link"></i>My Attendance</a></li>
                        <li><a href="attendance_search_bystaff.php"><i class="ti-link"></i>Search Staff Attendance</a></li>
                        <li><a href="attendance_all.php"><i class="ti-link"></i>ALL Attendance</a></li>
                        <li><a href="attendance_monthend_report.php"><i class="ti-link"></i>Month-End Report</a></li>
                        <li><a href="attendance_holiday_settings.php"><i class="ti-link"></i>Holiday Settings</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-clock"></i><span class="hide-menu"> Overtime</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="overtime_application.php"><i class="ti-link"></i>Apply Overtime</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-tags"></i><span class="hide-menu"> Account Task</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="task_add_new_account_list.php"><i class="ti-link"></i>Added New Account List</a></li>
                        <li><a href="task_terminate_account.php"><i class="ti-link"></i>Deactivate Account</a></li>
                        <li><a href="task_terminate_account_list.php"><i class="ti-link"></i>Deactivate Account List</a></li>
                        <li><a href="task_activate_account.php"><i class="ti-link"></i>Activate Account</a></li>
                        <li><a href="task_activate_account_list.php"><i class="ti-link"></i>Activate Account List</a></li>
                        <li><a href="task_approvers.php"><i class="ti-link"></i>Task Approvers</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu"> Clearance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="clearance_application.php"><i class="ti-link"></i>Apply Clearance</a></li>
                        <li><a href="clearance_my_applications.php"><i class="ti-link"></i>My Clearance Application</a></li>
                        <li><a href="clearance_my_approvals_list.php"><i class="ti-link"></i>My Clearance Approval List</a></li>
                        <li><a href="clearance_all_application_list.php"><i class="ti-link"></i>All Clearance List</a></li>
                        <li><a href="clearance_approvers.php"><i class="ti-link"></i>Clearance Approvers</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-cogs"></i><span class="hide-menu"> File Maintenance</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="file_department.php"><i class="ti-link"></i> Department</a></li>
                        <li><a href="file_section.php"><i class="ti-link"></i> Section</a></li>
                        <li><a href="file_job_title.php"><i class="ti-link"></i> Job Title</a></li>
                        <li><a href="file_qualification.php"><i class="ti-link"></i> Qualification</a></li>
                        <li><a href="file_degree.php"><i class="ti-link"></i> Degree</a></li>
                        <li><a href="file_specialization.php"><i class="ti-link"></i> Specialization</a></li>
                        <li><a href="file_extra_certificate.php"><i class="ti-link"></i> Extra Certificates</a></li>
                        <li><a href="file_sponsor.php"><i class="ti-link"></i> Sponsor</a></li>
                        <li><a href="file_salary_grade.php"><i class="ti-link"></i> Salary Grade</a></li>
                        <li><a href="file_leave_approver.php"><i class="ti-link"></i> Leave Approver</a></li>
                        <li><a href="file_nationality.php"><i class="ti-link"></i> Nationality</a></li>
                        <li><a href="file_contact.php"><i class="ti-link"></i> Contact Type</a></li>
                        <li><a href="file_status.php"><i class="ti-link"></i> Staff Status</a></li>
                        <li><a href="file_leavetype.php"><i class="ti-link"></i> Leave Type</a></li>
                        <li><a href="file_position.php"><i class="ti-link"></i> College Position</a></li>
                        <li><a href="file_users.php"><i class="ti-link"></i> System Users</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-key"></i><span class="hide-menu"> Leave Settings</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="settings_leave_approvers.php"><i class="ti-link"></i>Approver Settings</a></li>
                        <li><a href="settings_standard_leave_sequence.php"><i class="ti-link"></i>Standard Leave Sequence</a></li>
                        <li><a href="settings_short_leave_sequence.php"><i class="ti-link"></i>Short Leave Sequence</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="#" aria-expanded="false"><i class="fas fa-tasks"></i><span class="hide-menu"> Page Restrictions</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="accesspage_namehere.php"><i class="ti-link"></i>View All Access</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>