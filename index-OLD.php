<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed) {
?>
            <body class="fix-header fix-sidebar card-no-border">
                <input type="hidden" class="staffId" value="<?php echo $staffId ?>" />
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
                                <div class="col-md-5 col-sm-12 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0"><i class="fas fa-home"></i> Homepage</h3>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>                        
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                                <h4 class="card-title">My Notification Board</h4>
                                                <div class="ml-auto">
                                                    <ul class="list-inline text-right">
                                                        <li>
                                                            <?php
                                                                $page_id = $helper->pageId('shortleave_application.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <a href="shortleave_application.php?linkid=<?php echo $lid; ?>" title="Click to Apply Short Leave" class="btn btn-sm bg-light-info waves-effect waves-light text-info" ><i class="far fa-paper-plane"></i> Apply Short Leave</a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <?php
                                                                $page_id = $helper->pageId('standardleave_application.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <a href="standardleave_application.php?linkid=<?php echo $lid; ?>" title="Click to Apply Standard Leave" class="btn btn-sm bg-light-info waves-effect waves-light text-info" ><i class="far fa-paper-plane"></i> Apply Standard Leave</a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <?php
                                                                $page_id = $helper->pageId('official_mission_application.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <a href="official_mission_application.php?linkid=<?php echo $lid; ?>" title="Click to File an Official Duty" class="btn btn-sm bg-light-info waves-effect waves-light text-info" ><i class="far fa-paper-plane"></i> File an Official Duty</a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="feeds">
                                                <li>
                                                    <div class="bg-light-info"><i class="far fa-user"></i></div>
                                                    <a href="staff_profile.php?id=<?php echo $primary_staff_id; ?>" class="text-dark" title="Click to view Staff Profile"> My Profile</a></li>
                                                <li>
                                                    <?php
                                                        $page_id = $helper->pageId('attendance_my_attendance.php','id');
                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                        if(is_numeric($lid)) {
                                                            ?>
                                                                <div class="bg-light-info"><i class="far fa-envelope"></i></div><a href="attendance_my_attendance.php?linkid=<?php echo $lid; ?>" class="text-dark" title="Click to View Staff Attendance"> My Attendance</a></li>
                                                            <?php      
                                                        }
                                                    ?>              
                                                <li>
                                                    <?php
                                                        $page_id = $helper->pageId('standardleave_my_list.php','id');
                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                        if(is_numeric($lid)) {
                                                            ?>
                                                                <div class="bg-light-success"><i class="far fa-folder-open"></i></div><a href="standardleave_my_list.php?linkid=<?php echo $lid; ?>" class="text-dark" title="Click to View Staff  Standard Leave List"> My Standard Leave List</a></li>
                                                            <?php      
                                                        }
                                                    ?>    
                                                    
                                                <li>
                                                    <?php
                                                        $page_id = $helper->pageId('shortleave_my_list.php','id');
                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                        if(is_numeric($lid)) {
                                                            ?>
                                                                <div class="bg-light-success"><i class="far fa-folder-open"></i></div><a href="shortleave_my_list.php?linkid=<?php echo $lid; ?>" class="text-dark" title="Click to View Staff  Short Leave List"> My Short Leave List</a></li>
                                                            <?php      
                                                        }
                                                    ?>
                                                <!-- Links below are not available for staff -->
                                                <?php
                                                    if($user_type == 3 || $user_type == 4 || $user_type == 5 || $user_type == 1 || $user_type == 0) {
                                                        $amIShortLeaveApprover =  $helper->isShortLeaveApprover($myPositionId,'position_id');
                                                        $countSL = $helper->singleReadFullQry("SELECT count(id) as sLCount FROM shortleave WHERE currentApproverPositionId = $myPositionId AND currentSeqNumber = 1 AND currentStatus = 'Pending'");

                                                        $rowsSeq = $helper->readData("SELECT DISTINCT(sequence_no) FROM approvalsequence_standardleave WHERE approver_id = $myPositionId");
                                                        if($helper->totalCount != 0) {
                                                            $sequence_numbers = array();
                                                            foreach($rowsSeq as $row){
                                                                array_push($sequence_numbers,$row['sequence_no']);
                                                            }
                                                            $myCurrentSequenceNo = implode(', ', $sequence_numbers);
                                                        } else {
                                                            $myCurrentSequenceNo = 0;
                                                        }   
                                                        $amIStandardLeaveApprover =  $helper->isStandardLeaveApprover($myPositionId,'position_id');
                                                        $countOM = $helper->singleReadFullQry("SELECT count(id) as OMCount FROM standardleave WHERE current_approver_id = $myPositionId AND currentStatus = 'Pending' AND leavetype_id = 13");

                                                        $amIOfficialMissionApprover =  $helper->isStandardLeaveApprover($myPositionId,'position_id');
                                                        $countSTL = $helper->singleReadFullQry("SELECT count(id) as sTLCount FROM standardleave WHERE current_approver_id = $myPositionId AND currentStatus = 'Pending'");

                                                        $amIOvertimeLeaveApprover =  $helper->isOvertimeLeaveApprover($myPositionId,'position_id');
                                                        $countOvertime = $helper->singleReadFullQry("SELECT count(id) as OTCount FROM internalleaveovertime WHERE current_approver_id = $myPositionId AND currentStatus = 'Pending'");
                                                        ?>        
                                                            <li>
                                                                <div class="bg-light-danger"><i class="fas fa-comments"></i></div> My For Approval Lists
                                                                <span>
                                                                    <!--Short Leave Notification Icon-->
                                                                    <?php
                                                                        $page_id = $helper->pageId('shortleave_approve.php','id');
                                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                                        if(is_numeric($lid)) {
                                                                            if($amIShortLeaveApprover == 1 && $countSL['sLCount'] > 0) { //Listed as short leave approver in approvalsequence_shortleave table > approverInSequence1
                                                                            ?>
                                                                                <a href="shortleave_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Short Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Short &nbsp;<span class="badge badge-danger"><?php echo $countSL['sLCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="shortleave_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Short Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Short &nbsp;<span class="badge badge-danger"><?php echo $countSL['sLCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php    
                                                                            }
                                                                        }    
                                                                    ?>
                                                                    <!--Standard Leave Notification Icon-->
                                                                    <?php
                                                                        $page_id = $helper->pageId('standardleave_approve.php','id');
                                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                                        if(is_numeric($lid)) {
                                                                            if($amIStandardLeaveApprover == 1 && $countSTL['sTLCount'] > 0) { //Listed as standard leave approver in approvalsequence_standardleave table > approver_id
                                                                            ?>
                                                                                <a href="standardleave_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Standard Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Standard &nbsp;<span class="badge badge-danger"><?php echo $countSTL['sTLCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="standardleave_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Standard Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Standard &nbsp;<span class="badge badge-danger"><?php echo $countSTL['sTLCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php    
                                                                            }
                                                                        }    
                                                                    ?>
                                                                    <!--Official Mission Notification Icon-->
                                                                    <?php
                                                                        $page_id = $helper->pageId('official_mission_approve.php','id');
                                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                                        if(is_numeric($lid)) {
                                                                            if($amIOfficialMissionApprover == 1 && $countOM['OMCount'] > 0) { //Listed as standard leave approver in approvalsequence_standardleave table > approver_id
                                                                            ?>
                                                                                <a href="official_mission_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Official Mission Request" class="btn btn-sm waves-effect waves-light text-danger">Official Mission &nbsp;<span class="badge badge-danger"><?php echo $countOM['OMCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="official_mission_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Official Mission Request" class="btn btn-sm waves-effect waves-light text-danger">Official Mission &nbsp;<span class="badge badge-danger"><?php echo $countOM['OMCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php    
                                                                            }
                                                                        }    
                                                                    ?>
                                                                    <!--Overtime Leave Notification Icon-->
                                                                    <?php
                                                                        $page_id = $helper->pageId('overtime_approve.php','id');
                                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                                        if(is_numeric($lid)) {
                                                                            if($amIOvertimeLeaveApprover == 1 && $countOvertime['OTCount'] > 0) { //Listed as overtime leave approver in internalleaveovertime_approvalsequence table > approver_id
                                                                            ?>
                                                                                <a href="overtime_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Overtime Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Overtime &nbsp;<span class="badge badge-danger"><?php echo $countOvertime['OTCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <a href="overtime_approve.php?linkid=<?php echo $lid; ?>" title="Click to View Overtime Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Overtime &nbsp;<span class="badge badge-danger"><?php echo $countOvertime['OTCount']; ?></span></a>&nbsp;&nbsp;
                                                                            <?php    
                                                                            }
                                                                        }       
                                                                    ?>
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <div class="bg-light-danger"><i class="fas fa-comments"></i></div> My Task Notification
                                                                <span>
                                                                    <a href="" title="Click to View Create Account Request" class="btn btn-sm waves-effect waves-light text-danger">Create Account [-]</a>&nbsp;&nbsp;
                                                                    <a href="" title="Click to View Deactivate Account Request" class="btn btn-sm waves-effect waves-light text-danger">Deactivate Account [-]</a>&nbsp;&nbsp;

                                                                    <?php 
                                                                        $page_id = $helper->pageId('clearance_my_approvals_list.php','id');
                                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                                        $countCLR = $helper->singleReadFullQry("SELECT count(*) as clearanceCount FROM clearance_approval_status WHERE approverStaffId = '$staffId' AND current_flag = 1");

                                                                    ?>
                                                                    <a href="clearance_my_approvals_list.php?linkid=<?php echo $lid; ?>" title="Click to View Clearance Request Which is For Your Approval" class="btn btn-sm waves-effect waves-light text-danger">Clearance Application &nbsp;<span class="badge badge-danger"><?php echo $countCLR['clearanceCount']; ?></span></a>
                                                                </span>
                                                            </li>
                                                            
                                                        <?php
                                                    }
                                                ?>        
                                                <!-- Ends Here ... -->        
                                            </ul>     
                                        </div><!--end card-body-->
                                    </div><!-- end card-->

                                    <!--start Notification board for HR Staff-->
                                    <?php
                                        if($user_type == 0 || $user_type == 1 || $user_type == 2) { //0 - Super User, 1 - HR Head, 2 - HR Staff
                                    ?>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex no-block align-items-center">
                                                        <h4 class="card-title">HR Staff Notification Board</h4>
                                                        <div class="ml-auto">
                                                            <ul class="list-inline text-right">
                                                                <li>
                                                                    <?php
                                                                        $page_id = $helper->pageId('staff_generate_id.php','id');
                                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                                        if(is_numeric($lid)) {
                                                                            ?>
                                                                                <a href="staff_generate_id.php?linkid=<?php echo $lid; ?>" title="Click to Add New Staff" class="btn btn-sm bg-light-info waves-effect waves-light text-info" ><i class="far fa-paper-plane"></i> Add New Staff</a>
                                                                            <?php      
                                                                        }
                                                                    ?>
                                                                </li>
                                                                <li>
                                                                    <?php
                                                                        $page_id = $helper->pageId('staff_list_active.php','id');
                                                                        $lid = $helper->linkId($page_id,$user_type,'id');
                                                                        if(is_numeric($lid)) {
                                                                            ?>
                                                                                <a href="staff_list_active.php?linkid=<?php echo $lid; ?>" title="Click to View All Active Staff" class="btn btn-sm bg-light-info waves-effect waves-light text-info" ><i class="far fa-paper-plane"></i> All Active Staff</a>
                                                                            <?php      
                                                                        }
                                                                    ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="feeds">
                                                        <li>
                                                            <?php
                                                                $page_id = $helper->pageId('standardleave_all_list.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <div class="bg-light-danger"><i class="far fa-folder-open"></i></div><a href="standardleave_all_list.php?linkid=<?php echo $lid; ?>" class="text-dark" title="Click to View All Standard Leave List"> All Standard Leave Request</a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                            <?php
                                                                $page_id = $helper->pageId('standardleave_list_today.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <span>
                                                                            <a href="standardleave_list_today.php?linkid=<?php echo $lid; ?>" title="Click to New View Standard Leave Request" class="btn btn-sm waves-effect waves-light text-info">New Standard Leave [count today here]</a>
                                                                        </span>
                                                                    <?php      
                                                                }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <?php
                                                                $page_id = $helper->pageId('shortleave_all_list.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <div class="bg-light-danger"><i class="far fa-folder-open"></i></div><a href="shortleave_all_list.php?linkid=<?php echo $lid; ?>" class="text-dark" title="Click to View All Short Leave List"> All Short Leave Request</a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                            <?php
                                                                $page_id = $helper->pageId('shortleave_list_today.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <span>
                                                                            <a href="shortleave_list_today.php?linkid=<?php echo $lid; ?>" title="Click to View New Short Leave Request" class="btn btn-sm waves-effect waves-light text-info">New Short Leave [count today here]</a>
                                                                        </span>
                                                                    <?php      
                                                                }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <div class="bg-light-danger"><i class="far fa-folder-open"></i></div> Document Notification 
                                                            <span>
                                                                <a href="" title="Click to Staff with Document will expire soon" class="btn btn-sm waves-effect waves-light text-info">Document Expiration [3]</a>&nbsp&nbsp
                                                                <a href="" title="Click to View Staff with NO Civil ID" class="btn btn-sm waves-effect waves-light text-danger">Missing Civil ID [3]</a>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <?php
                                                                $page_id = $helper->pageId('internal_balance_all_balance.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <div class="bg-light-info"><i class="fas fa-archive"></i></div><a href="internal_balance_all_balance.php?linkid=<?php echo $lid; ?>" class="text-dark" title="Click to view All Internal Balance"> All Internal Balance</a>
                                                                    <?php      
                                                                }
                                                            ?>    
                                                        </li>
                                                        <li>
                                                            <?php
                                                                $page_id = $helper->pageId('emergency_balance_all_balance.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <div class="bg-light-info"><i class="fas fa-archive"></i></div><a href="emergency_balance_all_balance.php?linkid=<?php echo $lid; ?>" class="text-dark" title="Click to view All Emergency Balance"> All Emergency Balance</a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                        </li>
                                                    </ul>
                                                </div><!--end card-body-->
                                            </div>
                                    <?php
                                        }
                                    ?>        
                                    <!--end Notification board for HR Staff-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center">
                                                <h4 class="card-title">Attendance Calendar</h4>
                                            </div>    
                                            <!-- THE CALENDAR -->
                                            <div id="calendar"></div>
                                        </div><!--end card-body-->
                                    </div>
                                </div><!--end column for notification board-->
                                <div class="col-lg-6">
                                    <?php
                                        $bal = new DbaseManipulation; 
                                        $intLeaveBal = $bal->getInternalLeaveBalance($staffId,'balance');
                                        $intLeavePen = $bal->getInternalLeavePending($staffId,'balance');
                                        $emerLeaveBal = $bal->getEmergencyLeaveBalance($staffId,'balance');
                                        $emLeavePen = $bal->getEmergencyLeavePending($staffId,'balance');
                                        $emergencySummation = abs($emerLeaveBal) + abs($emLeavePen);
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex no-block align-items-center">
                                                        <h4 class="card-title">My Internal Leave Balance</h4>
                                                    </div>
                                                    <div class="usage chartist-chart text-success" style="height:140px; padding-bottom: 25px; padding-top: 25px"></div>
                                                    <div class="text-center m-t-15">
                                                        <ul class="list-inline">
                                                            <li>
                                                            <?php
                                                                $page_id = $helper->pageId('leavebalance_my_internal.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <a href="leavebalance_my_internal.php?linkid=<?php echo $lid; ?>"><h3 style="color: #00897B"><i class="fa fa-chart-bar"></i> Remaining Balance <strong>[<?php echo $intLeaveBal; ?>]</strong></h3></a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div><!--end chard body-->
                                            </div><!--end card for Internal chart-->
                                        </div><!--end col for Internal -->

                                        <div class="col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex no-block align-items-center">
                                                        <h4 class="card-title">My Emergency Leave Balance</h4>
                                                    </div>
                                                    <center>
                                                        <div class="col text-right align-self-center">
                                                            <div class="ct-gauge-chart" style="height: 155px"></div>
                                                        </div>
                                                    </center>
                                                    <div class="text-center">
                                                        <ul class="list-inline">
                                                            <input type="hidden" value="<?php echo $emergencySummation; ?>" class="emTotal" />
                                                            <li>
                                                                <h6 class="text-danger"><i class="fa fa-circle font-10"></i> Used Balance <strong>[<span class="emUsed"><?php echo abs($emLeavePen); ?></span>]</strong></h6>
                                                            <li>
                                                            <?php
                                                                $page_id = $helper->pageId('leavebalance_my_emergency.php','id');
                                                                $lid = $helper->linkId($page_id,$user_type,'id');
                                                                if(is_numeric($lid)) {
                                                                    ?>
                                                                        <a href="leavebalance_my_emergency.php?linkid=<?php echo $lid; ?>"><h3 class="text-muted text-info"><i class="fa fa-circle font-10"></i> Remaining Balance <strong>[<span class="emRemaining"><?php echo abs($emerLeaveBal); ?></span>]</strong></h3></a>
                                                                    <?php      
                                                                }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div><!--end card body-->
                                            </div><!--end card for Emergency chart-->
                                        </div><!--end col for Emergency -->
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex no-block align-items-center">
                                                        <h4 class="card-title">My Leave Chart [<?php echo date("Y"); ?>]</h4>
                                                        <div class="ml-auto">
                                                            <ul class="list-inline text-right">
                                                                <li>
                                                                    <h5 class="m-b-0" style="color: #009efb"><i class="fa fa-circle m-r-5"></i>Standard Leave</h5>
                                                                </li>
                                                                <li>
                                                                    <h5 class="m-b-0" style="color: #55ce63"><i class="fa fa-circle m-r-5"></i>Short Leave</h5>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div id="morris-bar-chart"></div>
                                                    <br/>
                                                    <div class="alert alert-info"><small><i class="fa fa-info-circle"></i> The frequency of counting this statistics is based on the <strong>date of filing</strong> of your leave.</small></div>
                                                    <?php
                                                        $taon = date("Y");
                                                        $rowJan = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 1 AND staff_id = '$staffId'");
                                                        $rowFeb = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 2 AND staff_id = '$staffId'");
                                                        $rowMar = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 3 AND staff_id = '$staffId'");
                                                        $rowApr = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 4 AND staff_id = '$staffId'");
                                                        $rowMay = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 5 AND staff_id = '$staffId'");
                                                        $rowJun = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 6 AND staff_id = '$staffId'");
                                                        $rowJul = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 7 AND staff_id = '$staffId'");
                                                        $rowAug = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 8 AND staff_id = '$staffId'");
                                                        $rowSep = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 9 AND staff_id = '$staffId'");
                                                        $rowOct = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 10 AND staff_id = '$staffId'");
                                                        $rowNov = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 11 AND staff_id = '$staffId'");
                                                        $rowDec = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 12 AND staff_id = '$staffId'");        
                                                    ?>
                                                    <input type="hidden" value="<?php echo $rowJan['howMany']; ?>" class="janSTL" />
                                                    <input type="hidden" value="0" class="janSL" />
                                                    
                                                    <input type="hidden" value="<?php echo $rowFeb['howMany']; ?>" class="febSTL" />
                                                    <input type="hidden" value="0" class="febSL" />

                                                    <input type="hidden" value="<?php echo $rowMar['howMany']; ?>" class="marSTL" />
                                                    <input type="hidden" value="0" class="marSL" />

                                                    <input type="hidden" value="<?php echo $rowApr['howMany']; ?>" class="aprSTL" />
                                                    <input type="hidden" value="0" class="aprSL" />

                                                    <input type="hidden" value="<?php echo $rowMay['howMany']; ?>" class="maySTL" />
                                                    <input type="hidden" value="0" class="maySL" />

                                                    <input type="hidden" value="<?php echo $rowJun['howMany']; ?>" class="junSTL" />
                                                    <input type="hidden" value="0" class="junSL" />

                                                    <input type="hidden" value="<?php echo $rowJul['howMany']; ?>" class="julSTL" />
                                                    <input type="hidden" value="0" class="julSL" />

                                                    <input type="hidden" value="<?php echo $rowAug['howMany']; ?>" class="augSTL" />
                                                    <input type="hidden" value="0" class="augSL" />

                                                    <input type="hidden" value="<?php echo $rowSep['howMany']; ?>" class="sepSTL" />
                                                    <input type="hidden" value="0" class="sepSL" />

                                                    <input type="hidden" value="<?php echo $rowOct['howMany']; ?>" class="octSTL" />
                                                    <input type="hidden" value="0" class="octSL" />

                                                    <input type="hidden" value="<?php echo $rowNov['howMany']; ?>" class="novSTL" />
                                                    <input type="hidden" value="0" class="novSL" />

                                                    <input type="hidden" value="<?php echo $rowDec['howMany']; ?>" class="decSTL" />
                                                    <input type="hidden" value="0" class="decSL" />
                                                </div>
                                            </div><!--end card for bar chard-->
                                        </div>
                                    </div><!--end row-->
                                </div><!-- column for charts-->
                            </div><!--end row-->   
                        </div><!--end container fluid-->

                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>  

                <!--Morris JavaScript -->
                <script src="assets/plugins/raphael/raphael-min.js"></script>
                <script src="assets/plugins/morrisjs/morris.js"></script>
                <script src="assets/plugins/chartist-js/dist/chartist.min.js"></script>
                <script src="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
                <!-- Chartist chart -->
                <script src="assets/plugins/chartist-js/dist/chartist.min.js"></script>
                <script src="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
                <script src="assets/plugins/chartist-js/dist/chartist-init.js"></script>
                <script src="assets/plugins/d3/d3.min.js"></script>
                <script src="assets/plugins/c3-master/c3.min.js"></script>
                <!-- Chart JS -->
                <script src="assets/plugins/echarts/echarts-all.js"></script>
                <script src="assets/plugins/echarts/echarts-init.js"></script>
                <script src="assets/plugins/knob/jquery.knob.js"></script>
                
                <script src="moment/moment.js"></script>
                <script src="fullcalendar/dist/fullcalendar.min.js"></script>
                
                <script>
                    $(function() {
                        $('[data-plugin="knob"]').knob();
                    });
                </script>
                <script src="js/dashboard2.js"></script>
                <script>
                    // ct-gauge-chart --> Emergency Leave Balance
                    var emUsed = $('.emUsed').text();
                    var emRemaining = $('.emRemaining').text();
                    var totalEmergency = $('.emTotal').val();
                    new Chartist.Pie('.ct-gauge-chart', { //Emergency Leave Balance
                        series: [emRemaining, emUsed] // remaining, used
                    }, {
                        donut: true,
                        donutWidth: 35,
                        startAngle: 0,
                        total: totalEmergency, // total emergency balance leave given
                        low: 0,
                        showLabel: true,
                        labelPosition: 'outside',
                        ignoreEmptyValues: true
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        var id = $('.staffId').val();
                        var date = new Date();
                        var d = date.getDate();
                        var m = date.getMonth();
                        var y = date.getFullYear();
                        var calendar = $('#calendar').fullCalendar({
                            editable: true,
                            header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        events: "attendance_load.php?id="+id,
                        });                
                    });
                    </script>    
                <script src="js/morris-data-bar-staff.js"></script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>        
</html>