<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver') || $helper->isAllowed('Staff')) ? true : false;
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
                                                            <a href="shortleave_application.php" title="Click to Apply Short Leave" class="btn btn-sm bg-light-info waves-effect waves-light text-info" ><i class="far fa-paper-plane"></i> Apply Short Leave</a>
                                                        </li>
                                                        <li>
                                                            <a href="standardleave_application.php" title="Click to Apply Standard Leave" class="btn btn-sm bg-light-info waves-effect waves-light text-info" ><i class="far fa-paper-plane"></i> Apply Standard Leave</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="feeds">
                                                <li>
                                                    <div class="bg-light-info"><i class="far fa-user"></i></div>
                                                    <a href="staff_myprofile.php" class="text-dark" title="Click to view Staff Profile"> My Profile</a></li>
                                                <li>
                                                    <div class="bg-light-info"><i class="far fa-envelope"></i></div><a href="attendance_my_search.php" class="text-dark" title="Click to View Staff Attendance"> My Attendance</a></li>    
                                                <li>
                                                    <div class="bg-light-success"><i class="far fa-folder-open"></i></div><a href="standardleave_my_list.php" class="text-dark" title="Click to View Staff  Standard Leave List"> My Standard Leave List</a></li>
                                                <li>
                                                    <div class="bg-light-success"><i class="far fa-folder-open"></i></div><a href="shortleave_my_list.php" class="text-dark" title="Click to View Staff  Short Leave List"> My Short Leave List</a></li>
                                                
                                                <!-- Links below are not avaible for staff -->
                                                <?php
                                                    if($_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 4 || $_SESSION['user_type'] == 5) {
                                                        $amIShortLeaveApprover =  $helper->isShortLeaveApprover($myPositionId,'position_id');
                                                        $countSL = $helper->singleReadFullQry("SELECT count(id) as sLCount FROM shortleave WHERE currentApproverPositionId = $myPositionId AND currentSeqNumber = 1 AND currentStatus = 'Pending'");

                                                        //$myCurrentSequenceNo = $helper->getMySequenceNo($myPositionId,'sequence_no');
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
                                                        $countSTL = $helper->singleReadFullQry("SELECT count(id) as sTLCount FROM standardleave WHERE current_approver_id = $myPositionId AND currentStatus = 'Pending'");
                                                        ?>        
                                                            <li>
                                                                <div class="bg-light-danger"><i class="fas fa-comments"></i></div> My For Approval Lists
                                                                <span>
                                                                    <!--Short Leave Notification Icon-->
                                                                    <?php
                                                                        if($amIShortLeaveApprover == 1 && $countSL['sLCount'] > 0) { //Listed as short leave approver in approvalsequence_shortleave table > approverInSequence1
                                                                        ?>
                                                                            <a href="shortleave_approve.php" title="Click to View Short Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Short Leave &nbsp;<span class="badge badge-danger"><?php echo $countSL['sLCount']; ?></span></a>&nbsp;&nbsp;
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="shortleave_approve.php" title="Click to View Short Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Short Leave &nbsp;<span class="badge badge-danger"><?php echo $countSL['sLCount']; ?></span></a>&nbsp;&nbsp;
                                                                        <?php    
                                                                        }
                                                                    ?>
                                                                    <!--Standard Leave Notification Icon-->
                                                                    <?php
                                                                        if($amIStandardLeaveApprover == 1 && $countSTL['sTLCount'] > 0) { //Listed as standard leave approver in approvalsequence_standardleave table > approver_id
                                                                        ?>
                                                                            <a href="standardleave_approve.php" title="Click to View Standard Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Standard Leave &nbsp;<span class="badge badge-danger"><?php echo $countSTL['sTLCount']; ?></span></a>&nbsp;&nbsp;
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="standardleave_approve.php" title="Click to View Standard Leave Request" class="btn btn-sm waves-effect waves-light text-danger">Standard Leave &nbsp;<span class="badge badge-danger"><?php echo $countSTL['sTLCount']; ?></span></a>&nbsp;&nbsp;
                                                                        <?php    
                                                                        }
                                                                    ?>
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <div class="bg-light-danger"><i class="fas fa-comments"></i></div> My Task Notification
                                                                <span>
                                                                    <a href="notification_for_approvals.php" title="Click to View Create Account Request" class="btn btn-sm waves-effect waves-light text-danger">Create Account [-]</a>&nbsp;&nbsp;
                                                                    <a href="notification_for_approvals.php" title="Click to View Deactivate Account Request" class="btn btn-sm waves-effect waves-light text-danger">Deactivate Account [-]</a>&nbsp;&nbsp;
                                                                    <a href="notification_for_approvals.php" title="Click to View Clearance Request" class="btn btn-sm waves-effect waves-light text-danger">Clearance Application [-]</a>
                                                                </span>
                                                            </li>
                                                        <?php
                                                    }
                                                ?>        
                                                <!-- Ends Here ... -->        
                                            </ul>     
                                        </div>
                                    </div>
                                </div>
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
                                                                <h6 style="color: #00897B">Remaining Internal Balance [<?php echo $intLeaveBal; ?>]</h6>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
                                                                <h6 class="text-danger"><i class="fa fa-circle font-10"></i> Used Balance [<span class="emUsed"><?php echo abs($emLeavePen); ?></span>]</h6>
                                                            <li>
                                                            <h6 class="text-muted  text-info"><i class="fa fa-circle font-10"></i> Remaining Balance [<span class="emRemaining"><?php echo abs($emerLeaveBal); ?></span>]</h6>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                        $rowJan = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 1");
                                                        $rowFeb = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 2");
                                                        $rowMar = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 3");
                                                        $rowApr = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 4");
                                                        $rowMay = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 5");
                                                        $rowJun = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 6");
                                                        $rowJul = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 7");
                                                        $rowAug = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 8");
                                                        $rowSep = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 9");
                                                        $rowOct = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 10");
                                                        $rowNov = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 11");
                                                        $rowDec = $helper->singleReadFullQry("SELECT count(id) as howMany FROM standardleave WHERE YEAR(dateFiled) = $taon AND MONTH(dateFiled) = 12");        
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
                <script src="js/morris-data-bar-staff.js"></script>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>        
</html>