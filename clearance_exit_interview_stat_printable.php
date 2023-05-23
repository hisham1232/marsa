<?php 
    //INSERT INTO access_menu_matrix_sub VALUES (0, 1102, 1, 413047, '2020-06-25 14:07:24', '2020-06-25 14:07:24'); //Replace 1102
    //INSERT INTO access_menu_matrix_sub VALUES (1, 1102, 1, 413047, '2020-06-25 14:07:24', '2020-06-25 14:07:24'); //Replace 1102  
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        //$allowed = true;
        if($allowed){                                 
            ?>
            <body class="fix-header fix-sidebar card-no-border">
                <style>
                    table, th, td {
                      border: 1px solid black;
                      border-collapse: collapse;
                    }
                    th, td {
                      padding: 10px;
                      text-align: left;
                    }
                    #t01 {
                      width: 100%;    
                      background-color: #f1f1c1;
                    }
                </style>
                <!-- <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Clearance Exit Interview Statistics</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance </li>
                                        <li class="breadcrumb-item">Exit Interview Statistics</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card card-body p-b-0">
                                        <form action="" method="POST">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Date</label>
                                                <div class="col-sm-6">
                                                    <input type='text' class="form-control daterange" required data-validation-required-message="Please Select Date" />
                                                    <input type="hidden" name="startDate" class="form-control startDate" />
                                                    <input type="hidden" name="endDate" class="form-control endDate" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-success waves-effect waves-light" name="searchByDate" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search By Date</button>
                                                </div>
                                            </div><!--end form-group-->
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card card-body p-b-0">
                                        <form action="" method="POST">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Staff Name</label>
                                                <div class="col-sm-6">
                                                    <select name="selectStaffId" id="selectStaffId" class="form-control select2" required data-validation-required-message="Please select staff name from the list">
                                                        <option value="">Select Staff Here</option>
                                                        <?php 
                                                            $managers = new DbaseManipulation;
                                                            $sqlCleared = "SELECT c.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName FROM clearance c INNER JOIN staff s ON c.staffId = s.staffId INNER JOIN employmentdetail as e ON e.staff_id = c.staffId WHERE e.isCurrent = 1";
                                                            $rows = $managers->readData($sqlCleared);
                                                            foreach ($rows as $row) {
                                                                ?>
                                                                <option value="<?php echo $row['staffId']; ?>"><?php echo preg_replace('/( )+/', ' ',$row['staffName']); ?></option>
                                                                <?php            
                                                            }    
                                                        ?>
                                                    </select>
                                                    <script type="text/javascript">
                                                        document.getElementById('selectStaffId').value = "<?php echo $_POST['selectStaffId'];?>";
                                                     </script>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-success waves-effect waves-light" name="searchByStaff" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search By Staff</button>
                                                </div>
                                            </div><!--end form-group-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" onclick="generatePDF()">Generate PDF</button>                            
                            <div id="root">
                                <?php 
                                    if(isset($_POST['searchByStaff'])) {
                                        $searchByStaff = 1;
                                        $post_staff_id = $_POST['selectStaffId'];
                                        
                                    } else {
                                        $searchByStaff = 0;
                                    }
                                    if(isset($_POST['searchByDate'])) {
                                        $searchByDate = 1;
                                        $to = $_POST['startDate'];
                                        $from = $_POST['endDate'];
                                    } else {
                                        $searchByDate = 0;
                                    }
                                    if($searchByStaff == 0 && $searchByDate == 0) {
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <h4 class="font-weight-bold text-primary"><img src="hrdlogo_small.png"></h4>
                                                <h4 class="font-weight-bold text-primary">&nbsp</h4>
                                                <h4 class="font-weight-bold text-primary"><center>Clearance Exit Interview Statistics <?php /*for [01-01-2020 to 15-09-2020]*/ ?></center></h4>
                                                <p class="font-weight-bold">Reason For Leaving</p>
                                                <div class="row html2pdf__page-break">
                                                    <div class="col-lg-5"><!--for table-->
                                                        <div class="table-responsive">
                                                            <table cellspacing="5" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Label</th>
                                                                        <th>Questions</th>
                                                                        <th>Count</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $reasonForLeavingCount = new DbaseManipulation;
                                                                    ?>
                                                                    <tr>
                                                                        <td>A</td>
                                                                        <td>Relocation</td>
                                                                        <td id="rfla"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick1','ctr') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>B</td>
                                                                        <td>Returning for education</td>
                                                                        <td id="rflb"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick2','ctr') ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>C</td>
                                                                        <td>Health/Medical reasons</td>
                                                                        <td id="rflc"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick3','ctr') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>D</td>
                                                                        <td>Family circumstances</td>
                                                                        <td id="rfld"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick4','ctr') ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>E</td>
                                                                        <td>Retirement</td>
                                                                        <td id="rfle"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick5','ctr') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>F</td>
                                                                        <td>Stop working</td>
                                                                        <td id="rflf"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick6','ctr') ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>G</td>
                                                                        <td>Location/commute</td>
                                                                        <td id="rflg"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick7','ctr') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>H</td>
                                                                        <td>Another job</td>
                                                                        <td id="rflh"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick8','ctr') ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>I</td>
                                                                        <td>Other</td>
                                                                        <td id="rfli"><?php echo $reasonForLeavingCount->countReasonForLeaving('reasonForLeavingTick9','ctr') ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div><!-- end table-responsive-->
                                                    </div><!--end for for table-->
                                                    <div class="col-lg-6"><!--for chart-->
                                                        <div id="bar-chart-reason" style="width:95%; height:500px;"></div>
                                                    </div><!--end for for chart-->
                                                </div><!--end row for table and chart-->
                                            </div><!--end col 10-->
                                        </div><!--end row Reason For Leaving-->

                                        <div class="row">
                                            <div class="col-lg-10">
                                                <p class="font-weight-bold">Job Dissatisfaction</p>
                                                <div class="row  html2pdf__page-break">
                                                    <div class="col-lg-5"><!--for table-->
                                                        <div class="table-responsive">
                                                            <table cellspacing="5" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Label</th>
                                                                        <th>Questions</th>
                                                                        <th>Count</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $dissatisfaction = new DbaseManipulation;
                                                                    ?>
                                                                    <tr>
                                                                        <td>A</td>
                                                                        <td>Type of work</td>
                                                                        <td id="disa"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick1','ctr2') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>B</td>
                                                                        <td>Job responsibilities</td>
                                                                        <td id="disb"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick2','ctr2') ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>C</td>
                                                                        <td>Compensation</td>
                                                                        <td id="disc"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick3','ctr2') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>D</td>
                                                                        <td>Benefits</td>
                                                                        <td id="disd"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick4','ctr2') ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>E</td>
                                                                        <td>Supervisor</td>
                                                                        <td id="dise"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick5','ctr2') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>F</td>
                                                                        <td>Management</td>
                                                                        <td id="disf"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick6','ctr2') ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>G</td>
                                                                        <td>Career opportunities</td>
                                                                        <td id="disg"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick7','ctr2') ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>H</td>
                                                                        <td>Im Satisfied</td>
                                                                        <td id="dish"><?php echo $dissatisfaction->countDisSatisfaction('dissatisfiedDueToTick8','ctr2') ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div><!-- end table-responsive-->
                                                    </div><!--end for for table-->
                                                    <div class="col-lg-6 col-xs-18"><!--for chart-->
                                                        <div id="bar-chart-dissatisfaction" style="width:95%; height:500px;"></div>
                                                    </div><!--end for for chart-->
                                                </div><!--end row for table and chart-->
                                            </div><!--end col 10-->
                                        </div><!--end row Job Dissatisfaction-->

                                        <div class="row">
                                            <div class="col-lg-10">
                                                <p class="font-weight-bold">Opinion to College </p>
                                                <div class="row html2pdf__page-break">
                                                    <div class="col-lg-5"><!--for table-->
                                                        <div class="table-responsive">
                                                            <table cellspacing="5" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Label</th>
                                                                        <th>Questions</th>
                                                                        <th>Average</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $opinionToJob = new DbaseManipulation;
                                                                        $a4 = $opinionToJob->countOpinionToJob('theJobRdo1',4,'ctrOpinionJob');
                                                                        $a3 = $opinionToJob->countOpinionToJob('theJobRdo1',3,'ctrOpinionJob');
                                                                        $a2 = $opinionToJob->countOpinionToJob('theJobRdo1',2,'ctrOpinionJob');
                                                                        $a1 = $opinionToJob->countOpinionToJob('theJobRdo1',1,'ctrOpinionJob');

                                                                        $b4 = $opinionToJob->countOpinionToJob('theJobRdo2',4,'ctrOpinionJob');
                                                                        $b3 = $opinionToJob->countOpinionToJob('theJobRdo2',3,'ctrOpinionJob');
                                                                        $b2 = $opinionToJob->countOpinionToJob('theJobRdo2',2,'ctrOpinionJob');
                                                                        $b1 = $opinionToJob->countOpinionToJob('theJobRdo2',1,'ctrOpinionJob');

                                                                        $c4 = $opinionToJob->countOpinionToJob('theJobRdo3',4,'ctrOpinionJob');
                                                                        $c3 = $opinionToJob->countOpinionToJob('theJobRdo3',3,'ctrOpinionJob');
                                                                        $c2 = $opinionToJob->countOpinionToJob('theJobRdo3',2,'ctrOpinionJob');
                                                                        $c1 = $opinionToJob->countOpinionToJob('theJobRdo3',1,'ctrOpinionJob');

                                                                        $d4 = $opinionToJob->countOpinionToJob('theJobRdo4',4,'ctrOpinionJob');
                                                                        $d3 = $opinionToJob->countOpinionToJob('theJobRdo4',3,'ctrOpinionJob');
                                                                        $d2 = $opinionToJob->countOpinionToJob('theJobRdo4',2,'ctrOpinionJob');
                                                                        $d1 = $opinionToJob->countOpinionToJob('theJobRdo4',1,'ctrOpinionJob');

                                                                        $e4 = $opinionToJob->countOpinionToJob('theJobRdo5',4,'ctrOpinionJob');
                                                                        $e3 = $opinionToJob->countOpinionToJob('theJobRdo5',3,'ctrOpinionJob');
                                                                        $e2 = $opinionToJob->countOpinionToJob('theJobRdo5',2,'ctrOpinionJob');
                                                                        $e1 = $opinionToJob->countOpinionToJob('theJobRdo5',1,'ctrOpinionJob');

                                                                        $f4 = $opinionToJob->countOpinionToJob('theJobRdo6',4,'ctrOpinionJob');
                                                                        $f3 = $opinionToJob->countOpinionToJob('theJobRdo6',3,'ctrOpinionJob');
                                                                        $f2 = $opinionToJob->countOpinionToJob('theJobRdo6',2,'ctrOpinionJob');
                                                                        $f1 = $opinionToJob->countOpinionToJob('theJobRdo6',1,'ctrOpinionJob');

                                                                        $g4 = $opinionToJob->countOpinionToJob('theJobRdo7',4,'ctrOpinionJob');
                                                                        $g3 = $opinionToJob->countOpinionToJob('theJobRdo7',3,'ctrOpinionJob');
                                                                        $g2 = $opinionToJob->countOpinionToJob('theJobRdo7',2,'ctrOpinionJob');
                                                                        $g1 = $opinionToJob->countOpinionToJob('theJobRdo7',1,'ctrOpinionJob');
                                                                    ?>    
                                                                    <tr>
                                                                        <td>A</td>
                                                                        <td>Morale in the department</td>
                                                                        <?php /*<td><?php echo $a4; ?></td>
                                                                        <td><?php echo $a3; ?></td>
                                                                        <td><?php echo $a2; ?></td>
                                                                        <td><?php echo $a1; ?></td>*/ ?>
                                                                        <td id="oja"><?php echo $a4 + $a3 + $a2 + $a1; ?></td>
                                                                    </tr>

                                                                     <tr>
                                                                        <td>B</td>
                                                                        <td>Cooperation within the department</td>
                                                                        <?php /*<td><?php echo $b4; ?></td>
                                                                        <td><?php echo $b3; ?></td>
                                                                        <td><?php echo $b2; ?></td>
                                                                        <td><?php echo $b1; ?></td>*/ ?>
                                                                        <td id="ojb"><?php echo $b4 + $b3 + $b2 + $b1; ?></td>
                                                                    </tr>

                                                                     <tr>
                                                                        <td>C</td>
                                                                        <td>Cooperation with other departments</td>
                                                                        <?php /*<td><?php echo $c4; ?></td>
                                                                        <td><?php echo $c3; ?></td>
                                                                        <td><?php echo $c2; ?></td>
                                                                        <td><?php echo $c1; ?></td>*/ ?>
                                                                        <td id="ojc"><?php echo $c4 + $c3 + $c2 + $c1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>D</td>
                                                                        <td>Orientation to the job</td>
                                                                        <?php /*<td><?php echo $d4; ?></td>
                                                                        <td><?php echo $d3; ?></td>
                                                                        <td><?php echo $d2; ?></td>
                                                                        <td><?php echo $d1; ?></td>*/ ?>
                                                                        <td id="ojd"><?php echo $d4 + $d3 + $d2 + $d1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>E</td>
                                                                        <td>Adequate training in the job </td>
                                                                        <?php /*<td><?php echo $e4; ?></td>
                                                                        <td><?php echo $e3; ?></td>
                                                                        <td><?php echo $e2; ?></td>
                                                                        <td><?php echo $e1; ?></td>*/ ?>
                                                                        <td id="oje"><?php echo $e4 + $e3 + $e2 + $e1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>F</td>
                                                                        <td>Communication within the department </td>
                                                                        <?php /*<td><?php echo $f4; ?></td>
                                                                        <td><?php echo $f3; ?></td>
                                                                        <td><?php echo $f2; ?></td>
                                                                        <td><?php echo $f1; ?></td>*/ ?>
                                                                        <td id="ojf"><?php echo $f4 + $f3 + $f2 + $f1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>G</td>
                                                                        <td>Fair play</td>
                                                                        <?php /*<td><?php echo $g4; ?></td>
                                                                        <td><?php echo $g3; ?></td>
                                                                        <td><?php echo $g2; ?></td>
                                                                        <td><?php echo $g1; ?></td>*/ ?>
                                                                        <td id="ojg"><?php echo $g4 + $g3 + $g2 + $g1; ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div><!-- end table-responsive-->
                                                    </div><!--end for for table-->
                                        
                                                    <div class="col-lg-6"><!--for chart-->
                                                        <div id="bar-chart-college" style="width:95%; height:500px;"></div>
                                                    </div><!--end for for chart-->
                                                </div><!--end row for table and chart-->
                                            </div><!--end col 10-->
                                        </div><!--end row Opinion to College-->

                                        <div class="row">
                                            <div class="col-lg-10">
                                                <p class="font-weight-bold">Opinion to Your Supervisor</p>
                                                <div class="row html2pdf__page-break">
                                                    <div class="col-lg-6"><!--for table-->
                                                        <div class="table-responsive">
                                                            <table cellspacing="5" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Label</th>
                                                                        <th>Questions</th>
                                                                        <th>Average</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $opinionToSupervisor = new DbaseManipulation;
                                                                        $aa4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo1',4,'ctrOpinionSupervisor');
                                                                        $aa3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo1',3,'ctrOpinionSupervisor');
                                                                        $aa2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo1',2,'ctrOpinionSupervisor');
                                                                        $aa1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo1',1,'ctrOpinionSupervisor');

                                                                        $bb4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo2',4,'ctrOpinionSupervisor');
                                                                        $bb3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo2',3,'ctrOpinionSupervisor');
                                                                        $bb2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo2',2,'ctrOpinionSupervisor');
                                                                        $bb1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo2',1,'ctrOpinionSupervisor');

                                                                        $cc4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo3',4,'ctrOpinionSupervisor');
                                                                        $cc3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo3',3,'ctrOpinionSupervisor');
                                                                        $cc2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo3',2,'ctrOpinionSupervisor');
                                                                        $cc1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo3',1,'ctrOpinionSupervisor');

                                                                        $dd4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo4',4,'ctrOpinionSupervisor');
                                                                        $dd3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo4',3,'ctrOpinionSupervisor');
                                                                        $dd2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo4',2,'ctrOpinionSupervisor');
                                                                        $dd1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo4',1,'ctrOpinionSupervisor');

                                                                        $ee4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo5',4,'ctrOpinionSupervisor');
                                                                        $ee3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo5',3,'ctrOpinionSupervisor');
                                                                        $ee2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo5',2,'ctrOpinionSupervisor');
                                                                        $ee1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo5',1,'ctrOpinionSupervisor');

                                                                        $ff4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo6',4,'ctrOpinionSupervisor');
                                                                        $ff3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo6',3,'ctrOpinionSupervisor');
                                                                        $ff2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo6',2,'ctrOpinionSupervisor');
                                                                        $ff1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo6',1,'ctrOpinionSupervisor');

                                                                        $gg4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo7',4,'ctrOpinionSupervisor');
                                                                        $gg3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo7',3,'ctrOpinionSupervisor');
                                                                        $gg2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo7',2,'ctrOpinionSupervisor');
                                                                        $gg1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo7',1,'ctrOpinionSupervisor');

                                                                        $hh4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo8',4,'ctrOpinionSupervisor');
                                                                        $hh3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo8',3,'ctrOpinionSupervisor');
                                                                        $hh2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo8',2,'ctrOpinionSupervisor');
                                                                        $hh1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo8',1,'ctrOpinionSupervisor');

                                                                        $ii4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo9',4,'ctrOpinionSupervisor');
                                                                        $ii3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo9',3,'ctrOpinionSupervisor');
                                                                        $ii2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo9',2,'ctrOpinionSupervisor');
                                                                        $ii1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo9',1,'ctrOpinionSupervisor');

                                                                        $jj4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo10',4,'ctrOpinionSupervisor');
                                                                        $jj3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo10',3,'ctrOpinionSupervisor');
                                                                        $jj2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo10',2,'ctrOpinionSupervisor');
                                                                        $jj1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo10',1,'ctrOpinionSupervisor');

                                                                        $kk4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo11',4,'ctrOpinionSupervisor');
                                                                        $kk3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo11',3,'ctrOpinionSupervisor');
                                                                        $kk2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo11',2,'ctrOpinionSupervisor');
                                                                        $kk1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo11',1,'ctrOpinionSupervisor');

                                                                        $ll4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo12',4,'ctrOpinionSupervisor');
                                                                        $ll3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo12',3,'ctrOpinionSupervisor');
                                                                        $ll2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo12',2,'ctrOpinionSupervisor');
                                                                        $ll1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo12',1,'ctrOpinionSupervisor');

                                                                        $mm4 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo13',4,'ctrOpinionSupervisor');
                                                                        $mm3 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo13',3,'ctrOpinionSupervisor');
                                                                        $mm2 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo13',2,'ctrOpinionSupervisor');
                                                                        $mm1 = $opinionToSupervisor->countOpinionToSupervisor('theSupRdo13',1,'ctrOpinionSupervisor');
                                                                    ?>
                                                                    <tr>
                                                                        <td>A</td>
                                                                        <td>Fair and equal treatment of employees</td>
                                                                        <?php /*<td><?php echo $aa4; ?></td>
                                                                        <td><?php echo $aa3; ?></td>
                                                                        <td><?php echo $aa2; ?></td>
                                                                        <td><?php echo $aa1; ?></td>*/ ?>
                                                                        <td id="osa"><?php echo $aa4 + $aa3 + $aa2 + $aa1; ?></td>
                                                                    </tr>

                                                                     <tr>
                                                                        <td>B</td>
                                                                        <td>Provides recognition on the job</td>
                                                                        <?php /*<td><?php echo $bb4; ?></td>
                                                                        <td><?php echo $bb3; ?></td>
                                                                        <td><?php echo $bb2; ?></td>
                                                                        <td><?php echo $bb1; ?></td>*/ ?>
                                                                        <td id="osb"><?php echo $bb4 + $bb3 + $bb2 + $bb1; ?></td>
                                                                    </tr>

                                                                     <tr>
                                                                        <td>C</td>
                                                                        <td>Resolves complaints and problems</td>
                                                                        <?php /*<td><?php echo $cc4; ?></td>
                                                                        <td><?php echo $cc3; ?></td>
                                                                        <td><?php echo $cc2; ?></td>
                                                                        <td><?php echo $cc1; ?></td>*/ ?>
                                                                        <td id="osc"><?php echo $cc4 + $cc3 + $cc2 + $cc1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>D</td>
                                                                        <td>Follows consistent policies</td>
                                                                        <?php /*<td><?php echo $dd4; ?></td>
                                                                        <td><?php echo $dd3; ?></td>
                                                                        <td><?php echo $dd2; ?></td>
                                                                        <td><?php echo $dd1; ?></td>*/ ?>
                                                                        <td id="osd"><?php echo $dd4 + $dd3 + $dd2 + $dd1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>E</td>
                                                                        <td>Keeps employees informed about what is going on</td>
                                                                        <?php /*<td><?php echo $ee4; ?></td>
                                                                        <td><?php echo $ee3; ?></td>
                                                                        <td><?php echo $ee2; ?></td>
                                                                        <td><?php echo $ee1; ?></td>*/ ?>
                                                                        <td id="ose"><?php echo $ee4 + $ee3 + $ee2 + $ee1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>F</td>
                                                                        <td>Encourages feedback/welcomes suggestions</td>
                                                                        <?php /*<td><?php echo $ff4; ?></td>
                                                                        <td><?php echo $ff3; ?></td>
                                                                        <td><?php echo $ff2; ?></td>
                                                                        <td><?php echo $ff1; ?></td>*/ ?>
                                                                        <td id="osf"><?php echo $ff4 + $ff3 + $ff2 + $ff1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>G</td>
                                                                        <td>Shows willingness to admit and correct mistakes</td>
                                                                        <?php /*<td><?php echo $gg4; ?></td>
                                                                        <td><?php echo $gg3; ?></td>
                                                                        <td><?php echo $gg2; ?></td>
                                                                        <td><?php echo $gg1; ?></td>*/ ?>
                                                                        <td id="osg"><?php echo $gg4 + $gg3 + $gg2 + $gg1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>H</td>
                                                                        <td>Support from the Human Resources Department</td>
                                                                        <?php /*<td><?php echo $hh4; ?></td>
                                                                        <td><?php echo $hh3; ?></td>
                                                                        <td><?php echo $hh2; ?></td>
                                                                        <td><?php echo $hh1; ?></td>*/ ?>
                                                                        <td id="osh"><?php echo $hh4 + $hh3 + $hh2 + $hh1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>I</td>
                                                                        <td>Gives instructions clearly </td>
                                                                        <?php /*<td><?php echo $ii4; ?></td>
                                                                        <td><?php echo $ii3; ?></td>
                                                                        <td><?php echo $ii2; ?></td>
                                                                        <td><?php echo $ii1; ?></td>*/ ?>
                                                                        <td id="osi"><?php echo $ii4 + $ii3 + $ii2 + $ii1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>J</td>
                                                                        <td>Gets cooperation</td>
                                                                        <?php /*<td><?php echo $jj4; ?></td>
                                                                        <td><?php echo $jj3; ?></td>
                                                                        <td><?php echo $jj2; ?></td>
                                                                        <td><?php echo $jj1; ?></td>*/ ?>
                                                                        <td id="osj"><?php echo $jj4 + $jj3 + $jj2 + $jj1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>K</td>
                                                                        <td>Shows an interest in individual employees</td>
                                                                        <?php /*<td><?php echo $kk4; ?></td>
                                                                        <td><?php echo $kk3; ?></td>
                                                                        <td><?php echo $kk2; ?></td>
                                                                        <td><?php echo $kk1; ?></td>*/ ?>
                                                                        <td id="osk"><?php echo $kk4 + $kk3 + $kk2 + $kk1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>L</td>
                                                                        <td>Handles pressure/conflict </td>
                                                                        <?php /*<td><?php echo $ll4; ?></td>
                                                                        <td><?php echo $ll3; ?></td>
                                                                        <td><?php echo $ll2; ?></td>
                                                                        <td><?php echo $ll1; ?></td>*/ ?>
                                                                        <td id="osl"><?php echo $ll4 + $ll3 + $ll2 + $ll1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>M</td>
                                                                        <td>Overall effectiveness </td>
                                                                        <?php /*<td><?php echo $mm4; ?></td>
                                                                        <td><?php echo $mm3; ?></td>
                                                                        <td><?php echo $mm2; ?></td>
                                                                        <td><?php echo $mm1; ?></td>*/ ?>
                                                                        <td id="osm"><?php echo $mm4 + $mm3 + $mm2 + $mm1; ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div><!-- end table-responsive-->
                                                    </div><!--end for for table-->
                                                    <div class="col-lg-6"><!--for chart-->
                                                        <div id="bar-chart-supervisor" style="width:95%; height:500px;"></div>
                                                    </div><!--end for for chart-->
                                                </div><!--end row for table and chart-->
                                            </div><!--end col 10-->
                                        </div><!--end row Opinion to Your Supervisor-->

                                        <div class="row">
                                            <div class="col-lg-10">
                                                <p class="font-weight-bold text-primary">Opinion to Your Job</p>
                                                <div class="row">
                                                    <div class="col-lg-6"><!--for table-->
                                                        <div class="table-responsive">
                                                            <table cellspacing="0" width="95%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Label</th>
                                                                        <th>Questions</th>
                                                                        <th>Ave.</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                        $opinionToCollege = new DbaseManipulation;
                                                                        $aaa4 = $opinionToCollege->countOpinionToCollege('theColRdo1',4,'ctrOpinionCollege');
                                                                        $aaa3 = $opinionToCollege->countOpinionToCollege('theColRdo1',3,'ctrOpinionCollege');
                                                                        $aaa2 = $opinionToCollege->countOpinionToCollege('theColRdo1',2,'ctrOpinionCollege');
                                                                        $aaa1 = $opinionToCollege->countOpinionToCollege('theColRdo1',1,'ctrOpinionCollege');

                                                                        $bbb4 = $opinionToCollege->countOpinionToCollege('theColRdo2',4,'ctrOpinionCollege');
                                                                        $bbb3 = $opinionToCollege->countOpinionToCollege('theColRdo2',3,'ctrOpinionCollege');
                                                                        $bbb2 = $opinionToCollege->countOpinionToCollege('theColRdo2',2,'ctrOpinionCollege');
                                                                        $bbb1 = $opinionToCollege->countOpinionToCollege('theColRdo2',1,'ctrOpinionCollege');

                                                                        $ccc4 = $opinionToCollege->countOpinionToCollege('theColRdo3',4,'ctrOpinionCollege');
                                                                        $ccc3 = $opinionToCollege->countOpinionToCollege('theColRdo3',3,'ctrOpinionCollege');
                                                                        $ccc2 = $opinionToCollege->countOpinionToCollege('theColRdo3',2,'ctrOpinionCollege');
                                                                        $ccc1 = $opinionToCollege->countOpinionToCollege('theColRdo3',1,'ctrOpinionCollege');

                                                                        $ddd4 = $opinionToCollege->countOpinionToCollege('theColRdo4',4,'ctrOpinionCollege');
                                                                        $ddd3 = $opinionToCollege->countOpinionToCollege('theColRdo4',3,'ctrOpinionCollege');
                                                                        $ddd2 = $opinionToCollege->countOpinionToCollege('theColRdo4',2,'ctrOpinionCollege');
                                                                        $ddd1 = $opinionToCollege->countOpinionToCollege('theColRdo4',1,'ctrOpinionCollege');

                                                                        $eee4 = $opinionToCollege->countOpinionToCollege('theColRdo5',4,'ctrOpinionCollege');
                                                                        $eee3 = $opinionToCollege->countOpinionToCollege('theColRdo5',3,'ctrOpinionCollege');
                                                                        $eee2 = $opinionToCollege->countOpinionToCollege('theColRdo5',2,'ctrOpinionCollege');
                                                                        $eee1 = $opinionToCollege->countOpinionToCollege('theColRdo5',1,'ctrOpinionCollege');

                                                                        $fff4 = $opinionToCollege->countOpinionToCollege('theColRdo6',4,'ctrOpinionCollege');
                                                                        $fff3 = $opinionToCollege->countOpinionToCollege('theColRdo6',3,'ctrOpinionCollege');
                                                                        $fff2 = $opinionToCollege->countOpinionToCollege('theColRdo6',2,'ctrOpinionCollege');
                                                                        $fff1 = $opinionToCollege->countOpinionToCollege('theColRdo6',1,'ctrOpinionCollege');

                                                                        $ggg4 = $opinionToCollege->countOpinionToCollege('theColRdo7',4,'ctrOpinionCollege');
                                                                        $ggg3 = $opinionToCollege->countOpinionToCollege('theColRdo7',3,'ctrOpinionCollege');
                                                                        $ggg2 = $opinionToCollege->countOpinionToCollege('theColRdo7',2,'ctrOpinionCollege');
                                                                        $ggg1 = $opinionToCollege->countOpinionToCollege('theColRdo7',1,'ctrOpinionCollege');

                                                                        $hhh4 = $opinionToCollege->countOpinionToCollege('theColRdo8',4,'ctrOpinionCollege');
                                                                        $hhh3 = $opinionToCollege->countOpinionToCollege('theColRdo8',3,'ctrOpinionCollege');
                                                                        $hhh2 = $opinionToCollege->countOpinionToCollege('theColRdo8',2,'ctrOpinionCollege');
                                                                        $hhh1 = $opinionToCollege->countOpinionToCollege('theColRdo8',1,'ctrOpinionCollege');

                                                                        $iii4 = $opinionToCollege->countOpinionToCollege('theColRdo9',4,'ctrOpinionCollege');
                                                                        $iii3 = $opinionToCollege->countOpinionToCollege('theColRdo9',3,'ctrOpinionCollege');
                                                                        $iii2 = $opinionToCollege->countOpinionToCollege('theColRdo9',2,'ctrOpinionCollege');
                                                                        $iii1 = $opinionToCollege->countOpinionToCollege('theColRdo9',1,'ctrOpinionCollege');
                                                                    ?>
                                                                    <tr>
                                                                        <td>A</td>
                                                                        <td>Morale as a whole</td>
                                                                        <?php /*<td><?php echo $aaa4; ?></td>
                                                                        <td><?php echo $aaa3; ?></td>
                                                                        <td><?php echo $aaa2; ?></td>
                                                                        <td><?php echo $aaa1; ?></td>*/ ?>
                                                                        <td id="oca"><?php echo $aaa4 + $aaa3 + $aaa2 + $aaa1; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>B</td>
                                                                        <td>Your salary</td>
                                                                        <?php /*<td><?php echo $bbb4; ?></td>
                                                                        <td><?php echo $bbb3; ?></td>
                                                                        <td><?php echo $bbb2; ?></td>
                                                                        <td><?php echo $bbb1; ?></td>*/ ?>
                                                                        <td id="ocb"><?php echo $bbb4 + $bbb3 + $bbb2 + $bbb1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>C</td>
                                                                        <td>Opportunity for advancement/promotion</td>
                                                                        <?php /*<td><?php echo $ccc4; ?></td>
                                                                        <td><?php echo $ccc3; ?></td>
                                                                        <td><?php echo $ccc2; ?></td>
                                                                        <td><?php echo $ccc1; ?></td>*/ ?>
                                                                        <td id="occ"><?php echo $ccc4 + $ccc3 + $ccc2 + $ccc1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>D</td>
                                                                        <td>Employee recognition</td>
                                                                        <?php /*<td><?php echo $ddd4; ?></td>
                                                                        <td><?php echo $ddd3; ?></td>
                                                                        <td><?php echo $ddd2; ?></td>
                                                                        <td><?php echo $ddd1; ?></td>*/ ?>
                                                                        <td id="ocd"><?php echo $ddd4 + $ddd3 + $ddd2 + $ddd1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>E</td>
                                                                        <td>Benefits</td>
                                                                        <?php /*<td><?php echo $eee4; ?></td>
                                                                        <td><?php echo $eee3; ?></td>
                                                                        <td><?php echo $eee2; ?></td>
                                                                        <td><?php echo $eee1; ?></td>*/ ?>
                                                                        <td id="oce"><?php echo $eee4 + $eee3 + $eee2 + $eee1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>F</td>
                                                                        <td>Physical working conditions </td>
                                                                        <?php /*<td><?php echo $fff4; ?></td>
                                                                        <td><?php echo $fff3; ?></td>
                                                                        <td><?php echo $fff2; ?></td>
                                                                        <td><?php echo $fff1; ?></td>*/ ?>
                                                                        <td id="ocf"><?php echo $fff4 + $fff3 + $fff2 + $fff1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>G</td>
                                                                        <td>Equipment provided </td>
                                                                        <?php /*<td><?php echo $ggg4; ?></td>
                                                                        <td><?php echo $ggg3; ?></td>
                                                                        <td><?php echo $ggg2; ?></td>
                                                                        <td><?php echo $ggg1; ?></td>*/ ?>
                                                                        <td id="ocg"><?php echo $ggg4 + $ggg3 + $ggg2 + $ggg1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>H</td>
                                                                        <td>Support from the HoD </td>
                                                                        <?php /*<td><?php echo $hhh4; ?></td>
                                                                        <td><?php echo $hhh3; ?></td>
                                                                        <td><?php echo $hhh2; ?></td>
                                                                        <td><?php echo $hhh1; ?></td>*/ ?>
                                                                        <td id="och"><?php echo $hhh4 + $hhh3 + $hhh2 + $hhh1; ?></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>I</td>
                                                                        <td>Support from the Human Resources Department </td>
                                                                        <?php /*<td><?php echo $iii4; ?></td>
                                                                        <td><?php echo $iii3; ?></td>
                                                                        <td><?php echo $iii2; ?></td>
                                                                        <td><?php echo $iii1; ?></td>*/ ?>
                                                                        <td id="oci"><?php echo $iii4 + $iii3 + $iii2 + $iii1; ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div><!-- end table-responsive-->
                                                    </div><!--end for for table-->
                                                    <div class="col-lg-6"><!--for chart-->
                                                    <div id="bar-chart-job" style="width:95%; height:500px;"></div>
                                                    </div><!--end for for chart-->
                                                </div><!--end row for table and chart-->
                                            </div><!--end col 12-->
                                        </div><!--end row Opinion to Your Job-->
                                        <?php 
                                    } else {
                                        if( $searchByStaff == 1) {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <h4 class="font-weight-bold text-primary"><img src="hrdlogo_small.png"></h4>
                                                    <h4 class="font-weight-bold text-primary">&nbsp</h4>
                                                    <h4 class="font-weight-bold text-primary"><center>Clearance Exit Interview Statistics <?php /*for [01-01-2020 to 15-09-2020]*/ ?></center></h4>
                                                    <p class="font-weight-bold">Reason For Leaving</p>
                                                    <div class="row html2pdf__page-break">
                                                        <div class="col-lg-5"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Count</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $reasonForLeavingCount = new DbaseManipulation;
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Relocation</td>
                                                                            <td id="rfla"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick1',$post_staff_id,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B</td>
                                                                            <td>Returning for education</td>
                                                                            <td id="rflb"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick2',$post_staff_id,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>C</td>
                                                                            <td>Health/Medical reasons</td>
                                                                            <td id="rflc"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick3',$post_staff_id,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Family circumstances</td>
                                                                            <td id="rfld"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick4',$post_staff_id,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Retirement</td>
                                                                            <td id="rfle"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick5',$post_staff_id,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Stop working</td>
                                                                            <td id="rflf"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick6',$post_staff_id,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Location/commute</td>
                                                                            <td id="rflg"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick7',$post_staff_id,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Another job</td>
                                                                            <td id="rflh"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick8',$post_staff_id,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>I</td>
                                                                            <td>Other</td>
                                                                            <td id="rfli"><?php echo $reasonForLeavingCount->countReasonForLeavingByStaff('reasonForLeavingTick9',$post_staff_id,'ctr') ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6"><!--for chart-->
                                                            <div id="bar-chart-reason" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Reason For Leaving-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold">Job Dissatisfaction</p>
                                                    <div class="row  html2pdf__page-break">
                                                        <div class="col-lg-5"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Count</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $dissatisfaction = new DbaseManipulation;
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Type of work</td>
                                                                            <td id="disa"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick1',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B</td>
                                                                            <td>Job responsibilities</td>
                                                                            <td id="disb"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick2',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>C</td>
                                                                            <td>Compensation</td>
                                                                            <td id="disc"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick3',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Benefits</td>
                                                                            <td id="disd"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick4',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Supervisor</td>
                                                                            <td id="dise"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick5',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Management</td>
                                                                            <td id="disf"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick6',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Career opportunities</td>
                                                                            <td id="disg"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick7',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Im Satisfied</td>
                                                                            <td id="dish"><?php echo $dissatisfaction->countDisSatisfactionByStaff('dissatisfiedDueToTick8',$post_staff_id,'ctr2') ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6 col-xs-18"><!--for chart-->
                                                            <div id="bar-chart-dissatisfaction" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Job Dissatisfaction-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold">Opinion to College </p>
                                                    <div class="row html2pdf__page-break">
                                                        <div class="col-lg-5"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Average</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $opinionToJob = new DbaseManipulation;
                                                                            $a4 = $opinionToJob->countOpinionToJobByStaff('theJobRdo1',4,$post_staff_id,'ctrOpinionJob');
                                                                            $a3 = $opinionToJob->countOpinionToJobByStaff('theJobRdo1',3,$post_staff_id,'ctrOpinionJob');
                                                                            $a2 = $opinionToJob->countOpinionToJobByStaff('theJobRdo1',2,$post_staff_id,'ctrOpinionJob');
                                                                            $a1 = $opinionToJob->countOpinionToJobByStaff('theJobRdo1',1,$post_staff_id,'ctrOpinionJob');

                                                                            $b4 = $opinionToJob->countOpinionToJobByStaff('theJobRdo2',4,$post_staff_id,'ctrOpinionJob');
                                                                            $b3 = $opinionToJob->countOpinionToJobByStaff('theJobRdo2',3,$post_staff_id,'ctrOpinionJob');
                                                                            $b2 = $opinionToJob->countOpinionToJobByStaff('theJobRdo2',2,$post_staff_id,'ctrOpinionJob');
                                                                            $b1 = $opinionToJob->countOpinionToJobByStaff('theJobRdo2',1,$post_staff_id,'ctrOpinionJob');

                                                                            $c4 = $opinionToJob->countOpinionToJobByStaff('theJobRdo3',4,$post_staff_id,'ctrOpinionJob');
                                                                            $c3 = $opinionToJob->countOpinionToJobByStaff('theJobRdo3',3,$post_staff_id,'ctrOpinionJob');
                                                                            $c2 = $opinionToJob->countOpinionToJobByStaff('theJobRdo3',2,$post_staff_id,'ctrOpinionJob');
                                                                            $c1 = $opinionToJob->countOpinionToJobByStaff('theJobRdo3',1,$post_staff_id,'ctrOpinionJob');

                                                                            $d4 = $opinionToJob->countOpinionToJobByStaff('theJobRdo4',4,$post_staff_id,'ctrOpinionJob');
                                                                            $d3 = $opinionToJob->countOpinionToJobByStaff('theJobRdo4',3,$post_staff_id,'ctrOpinionJob');
                                                                            $d2 = $opinionToJob->countOpinionToJobByStaff('theJobRdo4',2,$post_staff_id,'ctrOpinionJob');
                                                                            $d1 = $opinionToJob->countOpinionToJobByStaff('theJobRdo4',1,$post_staff_id,'ctrOpinionJob');

                                                                            $e4 = $opinionToJob->countOpinionToJobByStaff('theJobRdo5',4,$post_staff_id,'ctrOpinionJob');
                                                                            $e3 = $opinionToJob->countOpinionToJobByStaff('theJobRdo5',3,$post_staff_id,'ctrOpinionJob');
                                                                            $e2 = $opinionToJob->countOpinionToJobByStaff('theJobRdo5',2,$post_staff_id,'ctrOpinionJob');
                                                                            $e1 = $opinionToJob->countOpinionToJobByStaff('theJobRdo5',1,$post_staff_id,'ctrOpinionJob');

                                                                            $f4 = $opinionToJob->countOpinionToJobByStaff('theJobRdo6',4,$post_staff_id,'ctrOpinionJob');
                                                                            $f3 = $opinionToJob->countOpinionToJobByStaff('theJobRdo6',3,$post_staff_id,'ctrOpinionJob');
                                                                            $f2 = $opinionToJob->countOpinionToJobByStaff('theJobRdo6',2,$post_staff_id,'ctrOpinionJob');
                                                                            $f1 = $opinionToJob->countOpinionToJobByStaff('theJobRdo6',1,$post_staff_id,'ctrOpinionJob');

                                                                            $g4 = $opinionToJob->countOpinionToJobByStaff('theJobRdo7',4,$post_staff_id,'ctrOpinionJob');
                                                                            $g3 = $opinionToJob->countOpinionToJobByStaff('theJobRdo7',3,$post_staff_id,'ctrOpinionJob');
                                                                            $g2 = $opinionToJob->countOpinionToJobByStaff('theJobRdo7',2,$post_staff_id,'ctrOpinionJob');
                                                                            $g1 = $opinionToJob->countOpinionToJobByStaff('theJobRdo7',1,$post_staff_id,'ctrOpinionJob');
                                                                        ?>    
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Morale in the department</td>
                                                                            <?php /*<td><?php echo $a4; ?></td>
                                                                            <td><?php echo $a3; ?></td>
                                                                            <td><?php echo $a2; ?></td>
                                                                            <td><?php echo $a1; ?></td>*/ ?>
                                                                            <td id="oja"><?php echo $a4 + $a3 + $a2 + $a1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>B</td>
                                                                            <td>Cooperation within the department</td>
                                                                            <?php /*<td><?php echo $b4; ?></td>
                                                                            <td><?php echo $b3; ?></td>
                                                                            <td><?php echo $b2; ?></td>
                                                                            <td><?php echo $b1; ?></td>*/ ?>
                                                                            <td id="ojb"><?php echo $b4 + $b3 + $b2 + $b1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>C</td>
                                                                            <td>Cooperation with other departments</td>
                                                                            <?php /*<td><?php echo $c4; ?></td>
                                                                            <td><?php echo $c3; ?></td>
                                                                            <td><?php echo $c2; ?></td>
                                                                            <td><?php echo $c1; ?></td>*/ ?>
                                                                            <td id="ojc"><?php echo $c4 + $c3 + $c2 + $c1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Orientation to the job</td>
                                                                            <?php /*<td><?php echo $d4; ?></td>
                                                                            <td><?php echo $d3; ?></td>
                                                                            <td><?php echo $d2; ?></td>
                                                                            <td><?php echo $d1; ?></td>*/ ?>
                                                                            <td id="ojd"><?php echo $d4 + $d3 + $d2 + $d1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Adequate training in the job </td>
                                                                            <?php /*<td><?php echo $e4; ?></td>
                                                                            <td><?php echo $e3; ?></td>
                                                                            <td><?php echo $e2; ?></td>
                                                                            <td><?php echo $e1; ?></td>*/ ?>
                                                                            <td id="oje"><?php echo $e4 + $e3 + $e2 + $e1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Communication within the department </td>
                                                                            <?php /*<td><?php echo $f4; ?></td>
                                                                            <td><?php echo $f3; ?></td>
                                                                            <td><?php echo $f2; ?></td>
                                                                            <td><?php echo $f1; ?></td>*/ ?>
                                                                            <td id="ojf"><?php echo $f4 + $f3 + $f2 + $f1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Fair play</td>
                                                                            <?php /*<td><?php echo $g4; ?></td>
                                                                            <td><?php echo $g3; ?></td>
                                                                            <td><?php echo $g2; ?></td>
                                                                            <td><?php echo $g1; ?></td>*/ ?>
                                                                            <td id="ojg"><?php echo $g4 + $g3 + $g2 + $g1; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                            
                                                        <div class="col-lg-6"><!--for chart-->
                                                            <div id="bar-chart-college" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Opinion to College-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold">Opinion to Your Supervisor</p>
                                                    <div class="row html2pdf__page-break">
                                                        <div class="col-lg-6"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Average</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $opinionToSupervisor = new DbaseManipulation;
                                                                            $aa4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo1',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $aa3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo1',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $aa2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo1',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $aa1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo1',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $bb4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo2',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $bb3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo2',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $bb2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo2',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $bb1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo2',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $cc4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo3',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $cc3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo3',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $cc2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo3',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $cc1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo3',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $dd4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo4',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $dd3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo4',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $dd2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo4',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $dd1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo4',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $ee4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo5',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ee3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo5',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ee2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo5',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ee1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo5',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $ff4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo6',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ff3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo6',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ff2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo6',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ff1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo6',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $gg4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo7',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $gg3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo7',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $gg2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo7',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $gg1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo7',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $hh4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo8',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $hh3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo8',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $hh2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo8',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $hh1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo8',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $ii4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo9',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ii3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo9',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ii2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo9',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ii1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo9',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $jj4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo10',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $jj3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo10',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $jj2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo10',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $jj1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo10',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $kk4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo11',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $kk3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo11',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $kk2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo11',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $kk1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo11',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $ll4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo12',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ll3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo12',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ll2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo12',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $ll1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo12',1,$post_staff_id,'ctrOpinionSupervisor');

                                                                            $mm4 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo13',4,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $mm3 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo13',3,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $mm2 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo13',2,$post_staff_id,'ctrOpinionSupervisor');
                                                                            $mm1 = $opinionToSupervisor->countOpinionToSupervisorByStaff('theSupRdo13',1,$post_staff_id,'ctrOpinionSupervisor');
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Fair and equal treatment of employees</td>
                                                                            <?php /*<td><?php echo $aa4; ?></td>
                                                                            <td><?php echo $aa3; ?></td>
                                                                            <td><?php echo $aa2; ?></td>
                                                                            <td><?php echo $aa1; ?></td>*/ ?>
                                                                            <td id="osa"><?php echo $aa4 + $aa3 + $aa2 + $aa1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>B</td>
                                                                            <td>Provides recognition on the job</td>
                                                                            <?php /*<td><?php echo $bb4; ?></td>
                                                                            <td><?php echo $bb3; ?></td>
                                                                            <td><?php echo $bb2; ?></td>
                                                                            <td><?php echo $bb1; ?></td>*/ ?>
                                                                            <td id="osb"><?php echo $bb4 + $bb3 + $bb2 + $bb1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>C</td>
                                                                            <td>Resolves complaints and problems</td>
                                                                            <?php /*<td><?php echo $cc4; ?></td>
                                                                            <td><?php echo $cc3; ?></td>
                                                                            <td><?php echo $cc2; ?></td>
                                                                            <td><?php echo $cc1; ?></td>*/ ?>
                                                                            <td id="osc"><?php echo $cc4 + $cc3 + $cc2 + $cc1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Follows consistent policies</td>
                                                                            <?php /*<td><?php echo $dd4; ?></td>
                                                                            <td><?php echo $dd3; ?></td>
                                                                            <td><?php echo $dd2; ?></td>
                                                                            <td><?php echo $dd1; ?></td>*/ ?>
                                                                            <td id="osd"><?php echo $dd4 + $dd3 + $dd2 + $dd1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Keeps employees informed about what is going on</td>
                                                                            <?php /*<td><?php echo $ee4; ?></td>
                                                                            <td><?php echo $ee3; ?></td>
                                                                            <td><?php echo $ee2; ?></td>
                                                                            <td><?php echo $ee1; ?></td>*/ ?>
                                                                            <td id="ose"><?php echo $ee4 + $ee3 + $ee2 + $ee1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Encourages feedback/welcomes suggestions</td>
                                                                            <?php /*<td><?php echo $ff4; ?></td>
                                                                            <td><?php echo $ff3; ?></td>
                                                                            <td><?php echo $ff2; ?></td>
                                                                            <td><?php echo $ff1; ?></td>*/ ?>
                                                                            <td id="osf"><?php echo $ff4 + $ff3 + $ff2 + $ff1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Shows willingness to admit and correct mistakes</td>
                                                                            <?php /*<td><?php echo $gg4; ?></td>
                                                                            <td><?php echo $gg3; ?></td>
                                                                            <td><?php echo $gg2; ?></td>
                                                                            <td><?php echo $gg1; ?></td>*/ ?>
                                                                            <td id="osg"><?php echo $gg4 + $gg3 + $gg2 + $gg1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Support from the Human Resources Department</td>
                                                                            <?php /*<td><?php echo $hh4; ?></td>
                                                                            <td><?php echo $hh3; ?></td>
                                                                            <td><?php echo $hh2; ?></td>
                                                                            <td><?php echo $hh1; ?></td>*/ ?>
                                                                            <td id="osh"><?php echo $hh4 + $hh3 + $hh2 + $hh1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>I</td>
                                                                            <td>Gives instructions clearly </td>
                                                                            <?php /*<td><?php echo $ii4; ?></td>
                                                                            <td><?php echo $ii3; ?></td>
                                                                            <td><?php echo $ii2; ?></td>
                                                                            <td><?php echo $ii1; ?></td>*/ ?>
                                                                            <td id="osi"><?php echo $ii4 + $ii3 + $ii2 + $ii1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>J</td>
                                                                            <td>Gets cooperation</td>
                                                                            <?php /*<td><?php echo $jj4; ?></td>
                                                                            <td><?php echo $jj3; ?></td>
                                                                            <td><?php echo $jj2; ?></td>
                                                                            <td><?php echo $jj1; ?></td>*/ ?>
                                                                            <td id="osj"><?php echo $jj4 + $jj3 + $jj2 + $jj1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>K</td>
                                                                            <td>Shows an interest in individual employees</td>
                                                                            <?php /*<td><?php echo $kk4; ?></td>
                                                                            <td><?php echo $kk3; ?></td>
                                                                            <td><?php echo $kk2; ?></td>
                                                                            <td><?php echo $kk1; ?></td>*/ ?>
                                                                            <td id="osk"><?php echo $kk4 + $kk3 + $kk2 + $kk1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>L</td>
                                                                            <td>Handles pressure/conflict </td>
                                                                            <?php /*<td><?php echo $ll4; ?></td>
                                                                            <td><?php echo $ll3; ?></td>
                                                                            <td><?php echo $ll2; ?></td>
                                                                            <td><?php echo $ll1; ?></td>*/ ?>
                                                                            <td id="osl"><?php echo $ll4 + $ll3 + $ll2 + $ll1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>M</td>
                                                                            <td>Overall effectiveness </td>
                                                                            <?php /*<td><?php echo $mm4; ?></td>
                                                                            <td><?php echo $mm3; ?></td>
                                                                            <td><?php echo $mm2; ?></td>
                                                                            <td><?php echo $mm1; ?></td>*/ ?>
                                                                            <td id="osm"><?php echo $mm4 + $mm3 + $mm2 + $mm1; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6"><!--for chart-->
                                                            <div id="bar-chart-supervisor" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Opinion to Your Supervisor-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold text-primary">Opinion to Your Job</p>
                                                    <div class="row">
                                                        <div class="col-lg-6"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="0" width="95%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Ave.</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $opinionToCollege = new DbaseManipulation;
                                                                            $aaa4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo1',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $aaa3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo1',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $aaa2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo1',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $aaa1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo1',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $bbb4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo2',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $bbb3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo2',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $bbb2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo2',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $bbb1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo2',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $ccc4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo3',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $ccc3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo3',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $ccc2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo3',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $ccc1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo3',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $ddd4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo4',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $ddd3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo4',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $ddd2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo4',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $ddd1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo4',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $eee4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo5',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $eee3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo5',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $eee2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo5',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $eee1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo5',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $fff4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo6',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $fff3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo6',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $fff2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo6',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $fff1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo6',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $ggg4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo7',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $ggg3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo7',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $ggg2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo7',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $ggg1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo7',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $hhh4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo8',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $hhh3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo8',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $hhh2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo8',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $hhh1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo8',1,$post_staff_id,'ctrOpinionCollege');

                                                                            $iii4 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo9',4,$post_staff_id,'ctrOpinionCollege');
                                                                            $iii3 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo9',3,$post_staff_id,'ctrOpinionCollege');
                                                                            $iii2 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo9',2,$post_staff_id,'ctrOpinionCollege');
                                                                            $iii1 = $opinionToCollege->countOpinionToCollegeByStaff('theColRdo9',1,$post_staff_id,'ctrOpinionCollege');
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Morale as a whole</td>
                                                                            <?php /*<td><?php echo $aaa4; ?></td>
                                                                            <td><?php echo $aaa3; ?></td>
                                                                            <td><?php echo $aaa2; ?></td>
                                                                            <td><?php echo $aaa1; ?></td>*/ ?>
                                                                            <td id="oca"><?php echo $aaa4 + $aaa3 + $aaa2 + $aaa1; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B</td>
                                                                            <td>Your salary</td>
                                                                            <?php /*<td><?php echo $bbb4; ?></td>
                                                                            <td><?php echo $bbb3; ?></td>
                                                                            <td><?php echo $bbb2; ?></td>
                                                                            <td><?php echo $bbb1; ?></td>*/ ?>
                                                                            <td id="ocb"><?php echo $bbb4 + $bbb3 + $bbb2 + $bbb1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>C</td>
                                                                            <td>Opportunity for advancement/promotion</td>
                                                                            <?php /*<td><?php echo $ccc4; ?></td>
                                                                            <td><?php echo $ccc3; ?></td>
                                                                            <td><?php echo $ccc2; ?></td>
                                                                            <td><?php echo $ccc1; ?></td>*/ ?>
                                                                            <td id="occ"><?php echo $ccc4 + $ccc3 + $ccc2 + $ccc1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Employee recognition</td>
                                                                            <?php /*<td><?php echo $ddd4; ?></td>
                                                                            <td><?php echo $ddd3; ?></td>
                                                                            <td><?php echo $ddd2; ?></td>
                                                                            <td><?php echo $ddd1; ?></td>*/ ?>
                                                                            <td id="ocd"><?php echo $ddd4 + $ddd3 + $ddd2 + $ddd1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Benefits</td>
                                                                            <?php /*<td><?php echo $eee4; ?></td>
                                                                            <td><?php echo $eee3; ?></td>
                                                                            <td><?php echo $eee2; ?></td>
                                                                            <td><?php echo $eee1; ?></td>*/ ?>
                                                                            <td id="oce"><?php echo $eee4 + $eee3 + $eee2 + $eee1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Physical working conditions </td>
                                                                            <?php /*<td><?php echo $fff4; ?></td>
                                                                            <td><?php echo $fff3; ?></td>
                                                                            <td><?php echo $fff2; ?></td>
                                                                            <td><?php echo $fff1; ?></td>*/ ?>
                                                                            <td id="ocf"><?php echo $fff4 + $fff3 + $fff2 + $fff1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Equipment provided </td>
                                                                            <?php /*<td><?php echo $ggg4; ?></td>
                                                                            <td><?php echo $ggg3; ?></td>
                                                                            <td><?php echo $ggg2; ?></td>
                                                                            <td><?php echo $ggg1; ?></td>*/ ?>
                                                                            <td id="ocg"><?php echo $ggg4 + $ggg3 + $ggg2 + $ggg1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Support from the HoD </td>
                                                                            <?php /*<td><?php echo $hhh4; ?></td>
                                                                            <td><?php echo $hhh3; ?></td>
                                                                            <td><?php echo $hhh2; ?></td>
                                                                            <td><?php echo $hhh1; ?></td>*/ ?>
                                                                            <td id="och"><?php echo $hhh4 + $hhh3 + $hhh2 + $hhh1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>I</td>
                                                                            <td>Support from the Human Resources Department </td>
                                                                            <?php /*<td><?php echo $iii4; ?></td>
                                                                            <td><?php echo $iii3; ?></td>
                                                                            <td><?php echo $iii2; ?></td>
                                                                            <td><?php echo $iii1; ?></td>*/ ?>
                                                                            <td id="oci"><?php echo $iii4 + $iii3 + $iii2 + $iii1; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6"><!--for chart-->
                                                        <div id="bar-chart-job" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 12-->
                                            </div><!--end row Opinion to Your Job-->
                                            <?php
                                        }
                                        if( $searchByDate == 1) {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <h4 class="font-weight-bold text-primary"><img src="hrdlogo_small.png"></h4>
                                                    <h4 class="font-weight-bold text-primary">&nbsp</h4>
                                                    <h4 class="font-weight-bold text-primary"><center>Clearance Exit Interview Statistics <?php /*for [01-01-2020 to 15-09-2020]*/ ?></center></h4>
                                                    <p class="font-weight-bold">Reason For Leaving</p>
                                                    <div class="row html2pdf__page-break">
                                                        <div class="col-lg-5"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Count</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $reasonForLeavingCount = new DbaseManipulation;
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Relocation</td>
                                                                            <td id="rfla"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick1',$to,$from,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B</td>
                                                                            <td>Returning for education</td>
                                                                            <td id="rflb"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick2',$to,$from,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>C</td>
                                                                            <td>Health/Medical reasons</td>
                                                                            <td id="rflc"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick3',$to,$from,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Family circumstances</td>
                                                                            <td id="rfld"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick4',$to,$from,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Retirement</td>
                                                                            <td id="rfle"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick5',$to,$from,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Stop working</td>
                                                                            <td id="rflf"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick6',$to,$from,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Location/commute</td>
                                                                            <td id="rflg"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick7',$to,$from,'ctr') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Another job</td>
                                                                            <td id="rflh"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick8',$to,$from,'ctr') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>I</td>
                                                                            <td>Other</td>
                                                                            <td id="rfli"><?php echo $reasonForLeavingCount->countReasonForLeavingByDate('reasonForLeavingTick9',$to,$from,'ctr') ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6"><!--for chart-->
                                                            <div id="bar-chart-reason" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Reason For Leaving-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold">Job Dissatisfaction</p>
                                                    <div class="row  html2pdf__page-break">
                                                        <div class="col-lg-5"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Count</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $dissatisfaction = new DbaseManipulation;
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Type of work</td>
                                                                            <td id="disa"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick1',$to,$from,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B</td>
                                                                            <td>Job responsibilities</td>
                                                                            <td id="disb"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick2',$to,$from,'ctr2') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>C</td>
                                                                            <td>Compensation</td>
                                                                            <td id="disc"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick3',$to,$from,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Benefits</td>
                                                                            <td id="disd"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick4',$to,$from,'ctr2') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Supervisor</td>
                                                                            <td id="dise"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick5',$to,$from,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Management</td>
                                                                            <td id="disf"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick6',$to,$from,'ctr2') ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Career opportunities</td>
                                                                            <td id="disg"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick7',$to,$from,'ctr2') ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Im Satisfied</td>
                                                                            <td id="dish"><?php echo $dissatisfaction->countDisSatisfactionByDate('dissatisfiedDueToTick8',$to,$from,'ctr2') ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6 col-xs-18"><!--for chart-->
                                                            <div id="bar-chart-dissatisfaction" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Job Dissatisfaction-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold">Opinion to College </p>
                                                    <div class="row html2pdf__page-break">
                                                        <div class="col-lg-5"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Average</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $opinionToJob = new DbaseManipulation;
                                                                            $a4 = $opinionToJob->countOpinionToJobByDate('theJobRdo1',4,$to,$from,'ctrOpinionJob');
                                                                            $a3 = $opinionToJob->countOpinionToJobByDate('theJobRdo1',3,$to,$from,'ctrOpinionJob');
                                                                            $a2 = $opinionToJob->countOpinionToJobByDate('theJobRdo1',2,$to,$from,'ctrOpinionJob');
                                                                            $a1 = $opinionToJob->countOpinionToJobByDate('theJobRdo1',1,$to,$from,'ctrOpinionJob');

                                                                            $b4 = $opinionToJob->countOpinionToJobByDate('theJobRdo2',4,$to,$from,'ctrOpinionJob');
                                                                            $b3 = $opinionToJob->countOpinionToJobByDate('theJobRdo2',3,$to,$from,'ctrOpinionJob');
                                                                            $b2 = $opinionToJob->countOpinionToJobByDate('theJobRdo2',2,$to,$from,'ctrOpinionJob');
                                                                            $b1 = $opinionToJob->countOpinionToJobByDate('theJobRdo2',1,$to,$from,'ctrOpinionJob');

                                                                            $c4 = $opinionToJob->countOpinionToJobByDate('theJobRdo3',4,$to,$from,'ctrOpinionJob');
                                                                            $c3 = $opinionToJob->countOpinionToJobByDate('theJobRdo3',3,$to,$from,'ctrOpinionJob');
                                                                            $c2 = $opinionToJob->countOpinionToJobByDate('theJobRdo3',2,$to,$from,'ctrOpinionJob');
                                                                            $c1 = $opinionToJob->countOpinionToJobByDate('theJobRdo3',1,$to,$from,'ctrOpinionJob');

                                                                            $d4 = $opinionToJob->countOpinionToJobByDate('theJobRdo4',4,$to,$from,'ctrOpinionJob');
                                                                            $d3 = $opinionToJob->countOpinionToJobByDate('theJobRdo4',3,$to,$from,'ctrOpinionJob');
                                                                            $d2 = $opinionToJob->countOpinionToJobByDate('theJobRdo4',2,$to,$from,'ctrOpinionJob');
                                                                            $d1 = $opinionToJob->countOpinionToJobByDate('theJobRdo4',1,$to,$from,'ctrOpinionJob');

                                                                            $e4 = $opinionToJob->countOpinionToJobByDate('theJobRdo5',4,$to,$from,'ctrOpinionJob');
                                                                            $e3 = $opinionToJob->countOpinionToJobByDate('theJobRdo5',3,$to,$from,'ctrOpinionJob');
                                                                            $e2 = $opinionToJob->countOpinionToJobByDate('theJobRdo5',2,$to,$from,'ctrOpinionJob');
                                                                            $e1 = $opinionToJob->countOpinionToJobByDate('theJobRdo5',1,$to,$from,'ctrOpinionJob');

                                                                            $f4 = $opinionToJob->countOpinionToJobByDate('theJobRdo6',4,$to,$from,'ctrOpinionJob');
                                                                            $f3 = $opinionToJob->countOpinionToJobByDate('theJobRdo6',3,$to,$from,'ctrOpinionJob');
                                                                            $f2 = $opinionToJob->countOpinionToJobByDate('theJobRdo6',2,$to,$from,'ctrOpinionJob');
                                                                            $f1 = $opinionToJob->countOpinionToJobByDate('theJobRdo6',1,$to,$from,'ctrOpinionJob');

                                                                            $g4 = $opinionToJob->countOpinionToJobByDate('theJobRdo7',4,$to,$from,'ctrOpinionJob');
                                                                            $g3 = $opinionToJob->countOpinionToJobByDate('theJobRdo7',3,$to,$from,'ctrOpinionJob');
                                                                            $g2 = $opinionToJob->countOpinionToJobByDate('theJobRdo7',2,$to,$from,'ctrOpinionJob');
                                                                            $g1 = $opinionToJob->countOpinionToJobByDate('theJobRdo7',1,$to,$from,'ctrOpinionJob');
                                                                        ?>    
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Morale in the department</td>
                                                                            <?php /*<td><?php echo $a4; ?></td>
                                                                            <td><?php echo $a3; ?></td>
                                                                            <td><?php echo $a2; ?></td>
                                                                            <td><?php echo $a1; ?></td>*/ ?>
                                                                            <td id="oja"><?php echo $a4 + $a3 + $a2 + $a1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>B</td>
                                                                            <td>Cooperation within the department</td>
                                                                            <?php /*<td><?php echo $b4; ?></td>
                                                                            <td><?php echo $b3; ?></td>
                                                                            <td><?php echo $b2; ?></td>
                                                                            <td><?php echo $b1; ?></td>*/ ?>
                                                                            <td id="ojb"><?php echo $b4 + $b3 + $b2 + $b1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>C</td>
                                                                            <td>Cooperation with other departments</td>
                                                                            <?php /*<td><?php echo $c4; ?></td>
                                                                            <td><?php echo $c3; ?></td>
                                                                            <td><?php echo $c2; ?></td>
                                                                            <td><?php echo $c1; ?></td>*/ ?>
                                                                            <td id="ojc"><?php echo $c4 + $c3 + $c2 + $c1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Orientation to the job</td>
                                                                            <?php /*<td><?php echo $d4; ?></td>
                                                                            <td><?php echo $d3; ?></td>
                                                                            <td><?php echo $d2; ?></td>
                                                                            <td><?php echo $d1; ?></td>*/ ?>
                                                                            <td id="ojd"><?php echo $d4 + $d3 + $d2 + $d1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Adequate training in the job </td>
                                                                            <?php /*<td><?php echo $e4; ?></td>
                                                                            <td><?php echo $e3; ?></td>
                                                                            <td><?php echo $e2; ?></td>
                                                                            <td><?php echo $e1; ?></td>*/ ?>
                                                                            <td id="oje"><?php echo $e4 + $e3 + $e2 + $e1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Communication within the department </td>
                                                                            <?php /*<td><?php echo $f4; ?></td>
                                                                            <td><?php echo $f3; ?></td>
                                                                            <td><?php echo $f2; ?></td>
                                                                            <td><?php echo $f1; ?></td>*/ ?>
                                                                            <td id="ojf"><?php echo $f4 + $f3 + $f2 + $f1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Fair play</td>
                                                                            <?php /*<td><?php echo $g4; ?></td>
                                                                            <td><?php echo $g3; ?></td>
                                                                            <td><?php echo $g2; ?></td>
                                                                            <td><?php echo $g1; ?></td>*/ ?>
                                                                            <td id="ojg"><?php echo $g4 + $g3 + $g2 + $g1; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                            
                                                        <div class="col-lg-6"><!--for chart-->
                                                            <div id="bar-chart-college" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Opinion to College-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold">Opinion to Your Supervisor</p>
                                                    <div class="row html2pdf__page-break">
                                                        <div class="col-lg-6"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="5" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Average</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $opinionToSupervisor = new DbaseManipulation;
                                                                            $aa4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo1',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $aa3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo1',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $aa2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo1',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $aa1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo1',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $bb4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo2',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $bb3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo2',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $bb2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo2',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $bb1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo2',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $cc4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo3',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $cc3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo3',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $cc2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo3',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $cc1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo3',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $dd4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo4',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $dd3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo4',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $dd2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo4',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $dd1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo4',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $ee4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo5',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $ee3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo5',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $ee2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo5',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $ee1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo5',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $ff4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo6',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $ff3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo6',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $ff2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo6',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $ff1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo6',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $gg4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo7',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $gg3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo7',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $gg2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo7',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $gg1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo7',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $hh4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo8',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $hh3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo8',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $hh2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo8',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $hh1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo8',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $ii4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo9',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $ii3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo9',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $ii2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo9',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $ii1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo9',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $jj4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo10',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $jj3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo10',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $jj2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo10',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $jj1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo10',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $kk4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo11',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $kk3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo11',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $kk2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo11',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $kk1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo11',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $ll4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo12',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $ll3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo12',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $ll2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo12',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $ll1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo12',1,$to,$from,'ctrOpinionSupervisor');

                                                                            $mm4 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo13',4,$to,$from,'ctrOpinionSupervisor');
                                                                            $mm3 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo13',3,$to,$from,'ctrOpinionSupervisor');
                                                                            $mm2 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo13',2,$to,$from,'ctrOpinionSupervisor');
                                                                            $mm1 = $opinionToSupervisor->countOpinionToSupervisorByDate('theSupRdo13',1,$to,$from,'ctrOpinionSupervisor');
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Fair and equal treatment of employees</td>
                                                                            <?php /*<td><?php echo $aa4; ?></td>
                                                                            <td><?php echo $aa3; ?></td>
                                                                            <td><?php echo $aa2; ?></td>
                                                                            <td><?php echo $aa1; ?></td>*/ ?>
                                                                            <td id="osa"><?php echo $aa4 + $aa3 + $aa2 + $aa1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>B</td>
                                                                            <td>Provides recognition on the job</td>
                                                                            <?php /*<td><?php echo $bb4; ?></td>
                                                                            <td><?php echo $bb3; ?></td>
                                                                            <td><?php echo $bb2; ?></td>
                                                                            <td><?php echo $bb1; ?></td>*/ ?>
                                                                            <td id="osb"><?php echo $bb4 + $bb3 + $bb2 + $bb1; ?></td>
                                                                        </tr>

                                                                         <tr>
                                                                            <td>C</td>
                                                                            <td>Resolves complaints and problems</td>
                                                                            <?php /*<td><?php echo $cc4; ?></td>
                                                                            <td><?php echo $cc3; ?></td>
                                                                            <td><?php echo $cc2; ?></td>
                                                                            <td><?php echo $cc1; ?></td>*/ ?>
                                                                            <td id="osc"><?php echo $cc4 + $cc3 + $cc2 + $cc1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Follows consistent policies</td>
                                                                            <?php /*<td><?php echo $dd4; ?></td>
                                                                            <td><?php echo $dd3; ?></td>
                                                                            <td><?php echo $dd2; ?></td>
                                                                            <td><?php echo $dd1; ?></td>*/ ?>
                                                                            <td id="osd"><?php echo $dd4 + $dd3 + $dd2 + $dd1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Keeps employees informed about what is going on</td>
                                                                            <?php /*<td><?php echo $ee4; ?></td>
                                                                            <td><?php echo $ee3; ?></td>
                                                                            <td><?php echo $ee2; ?></td>
                                                                            <td><?php echo $ee1; ?></td>*/ ?>
                                                                            <td id="ose"><?php echo $ee4 + $ee3 + $ee2 + $ee1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Encourages feedback/welcomes suggestions</td>
                                                                            <?php /*<td><?php echo $ff4; ?></td>
                                                                            <td><?php echo $ff3; ?></td>
                                                                            <td><?php echo $ff2; ?></td>
                                                                            <td><?php echo $ff1; ?></td>*/ ?>
                                                                            <td id="osf"><?php echo $ff4 + $ff3 + $ff2 + $ff1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Shows willingness to admit and correct mistakes</td>
                                                                            <?php /*<td><?php echo $gg4; ?></td>
                                                                            <td><?php echo $gg3; ?></td>
                                                                            <td><?php echo $gg2; ?></td>
                                                                            <td><?php echo $gg1; ?></td>*/ ?>
                                                                            <td id="osg"><?php echo $gg4 + $gg3 + $gg2 + $gg1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Support from the Human Resources Department</td>
                                                                            <?php /*<td><?php echo $hh4; ?></td>
                                                                            <td><?php echo $hh3; ?></td>
                                                                            <td><?php echo $hh2; ?></td>
                                                                            <td><?php echo $hh1; ?></td>*/ ?>
                                                                            <td id="osh"><?php echo $hh4 + $hh3 + $hh2 + $hh1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>I</td>
                                                                            <td>Gives instructions clearly </td>
                                                                            <?php /*<td><?php echo $ii4; ?></td>
                                                                            <td><?php echo $ii3; ?></td>
                                                                            <td><?php echo $ii2; ?></td>
                                                                            <td><?php echo $ii1; ?></td>*/ ?>
                                                                            <td id="osi"><?php echo $ii4 + $ii3 + $ii2 + $ii1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>J</td>
                                                                            <td>Gets cooperation</td>
                                                                            <?php /*<td><?php echo $jj4; ?></td>
                                                                            <td><?php echo $jj3; ?></td>
                                                                            <td><?php echo $jj2; ?></td>
                                                                            <td><?php echo $jj1; ?></td>*/ ?>
                                                                            <td id="osj"><?php echo $jj4 + $jj3 + $jj2 + $jj1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>K</td>
                                                                            <td>Shows an interest in individual employees</td>
                                                                            <?php /*<td><?php echo $kk4; ?></td>
                                                                            <td><?php echo $kk3; ?></td>
                                                                            <td><?php echo $kk2; ?></td>
                                                                            <td><?php echo $kk1; ?></td>*/ ?>
                                                                            <td id="osk"><?php echo $kk4 + $kk3 + $kk2 + $kk1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>L</td>
                                                                            <td>Handles pressure/conflict </td>
                                                                            <?php /*<td><?php echo $ll4; ?></td>
                                                                            <td><?php echo $ll3; ?></td>
                                                                            <td><?php echo $ll2; ?></td>
                                                                            <td><?php echo $ll1; ?></td>*/ ?>
                                                                            <td id="osl"><?php echo $ll4 + $ll3 + $ll2 + $ll1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>M</td>
                                                                            <td>Overall effectiveness </td>
                                                                            <?php /*<td><?php echo $mm4; ?></td>
                                                                            <td><?php echo $mm3; ?></td>
                                                                            <td><?php echo $mm2; ?></td>
                                                                            <td><?php echo $mm1; ?></td>*/ ?>
                                                                            <td id="osm"><?php echo $mm4 + $mm3 + $mm2 + $mm1; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6"><!--for chart-->
                                                            <div id="bar-chart-supervisor" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 10-->
                                            </div><!--end row Opinion to Your Supervisor-->

                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <p class="font-weight-bold text-primary">Opinion to Your Job</p>
                                                    <div class="row">
                                                        <div class="col-lg-6"><!--for table-->
                                                            <div class="table-responsive">
                                                                <table cellspacing="0" width="95%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Label</th>
                                                                            <th>Questions</th>
                                                                            <th>Ave.</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $opinionToCollege = new DbaseManipulation;
                                                                            $aaa4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo1',4,$to,$from,'ctrOpinionCollege');
                                                                            $aaa3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo1',3,$to,$from,'ctrOpinionCollege');
                                                                            $aaa2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo1',2,$to,$from,'ctrOpinionCollege');
                                                                            $aaa1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo1',1,$to,$from,'ctrOpinionCollege');

                                                                            $bbb4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo2',4,$to,$from,'ctrOpinionCollege');
                                                                            $bbb3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo2',3,$to,$from,'ctrOpinionCollege');
                                                                            $bbb2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo2',2,$to,$from,'ctrOpinionCollege');
                                                                            $bbb1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo2',1,$to,$from,'ctrOpinionCollege');

                                                                            $ccc4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo3',4,$to,$from,'ctrOpinionCollege');
                                                                            $ccc3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo3',3,$to,$from,'ctrOpinionCollege');
                                                                            $ccc2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo3',2,$to,$from,'ctrOpinionCollege');
                                                                            $ccc1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo3',1,$to,$from,'ctrOpinionCollege');

                                                                            $ddd4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo4',4,$to,$from,'ctrOpinionCollege');
                                                                            $ddd3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo4',3,$to,$from,'ctrOpinionCollege');
                                                                            $ddd2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo4',2,$to,$from,'ctrOpinionCollege');
                                                                            $ddd1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo4',1,$to,$from,'ctrOpinionCollege');

                                                                            $eee4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo5',4,$to,$from,'ctrOpinionCollege');
                                                                            $eee3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo5',3,$to,$from,'ctrOpinionCollege');
                                                                            $eee2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo5',2,$to,$from,'ctrOpinionCollege');
                                                                            $eee1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo5',1,$to,$from,'ctrOpinionCollege');

                                                                            $fff4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo6',4,$to,$from,'ctrOpinionCollege');
                                                                            $fff3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo6',3,$to,$from,'ctrOpinionCollege');
                                                                            $fff2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo6',2,$to,$from,'ctrOpinionCollege');
                                                                            $fff1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo6',1,$to,$from,'ctrOpinionCollege');

                                                                            $ggg4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo7',4,$to,$from,'ctrOpinionCollege');
                                                                            $ggg3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo7',3,$to,$from,'ctrOpinionCollege');
                                                                            $ggg2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo7',2,$to,$from,'ctrOpinionCollege');
                                                                            $ggg1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo7',1,$to,$from,'ctrOpinionCollege');

                                                                            $hhh4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo8',4,$to,$from,'ctrOpinionCollege');
                                                                            $hhh3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo8',3,$to,$from,'ctrOpinionCollege');
                                                                            $hhh2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo8',2,$to,$from,'ctrOpinionCollege');
                                                                            $hhh1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo8',1,$to,$from,'ctrOpinionCollege');

                                                                            $iii4 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo9',4,$to,$from,'ctrOpinionCollege');
                                                                            $iii3 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo9',3,$to,$from,'ctrOpinionCollege');
                                                                            $iii2 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo9',2,$to,$from,'ctrOpinionCollege');
                                                                            $iii1 = $opinionToCollege->countOpinionToCollegeByDate('theColRdo9',1,$to,$from,'ctrOpinionCollege');
                                                                        ?>
                                                                        <tr>
                                                                            <td>A</td>
                                                                            <td>Morale as a whole</td>
                                                                            <?php /*<td><?php echo $aaa4; ?></td>
                                                                            <td><?php echo $aaa3; ?></td>
                                                                            <td><?php echo $aaa2; ?></td>
                                                                            <td><?php echo $aaa1; ?></td>*/ ?>
                                                                            <td id="oca"><?php echo $aaa4 + $aaa3 + $aaa2 + $aaa1; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B</td>
                                                                            <td>Your salary</td>
                                                                            <?php /*<td><?php echo $bbb4; ?></td>
                                                                            <td><?php echo $bbb3; ?></td>
                                                                            <td><?php echo $bbb2; ?></td>
                                                                            <td><?php echo $bbb1; ?></td>*/ ?>
                                                                            <td id="ocb"><?php echo $bbb4 + $bbb3 + $bbb2 + $bbb1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>C</td>
                                                                            <td>Opportunity for advancement/promotion</td>
                                                                            <?php /*<td><?php echo $ccc4; ?></td>
                                                                            <td><?php echo $ccc3; ?></td>
                                                                            <td><?php echo $ccc2; ?></td>
                                                                            <td><?php echo $ccc1; ?></td>*/ ?>
                                                                            <td id="occ"><?php echo $ccc4 + $ccc3 + $ccc2 + $ccc1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>D</td>
                                                                            <td>Employee recognition</td>
                                                                            <?php /*<td><?php echo $ddd4; ?></td>
                                                                            <td><?php echo $ddd3; ?></td>
                                                                            <td><?php echo $ddd2; ?></td>
                                                                            <td><?php echo $ddd1; ?></td>*/ ?>
                                                                            <td id="ocd"><?php echo $ddd4 + $ddd3 + $ddd2 + $ddd1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>E</td>
                                                                            <td>Benefits</td>
                                                                            <?php /*<td><?php echo $eee4; ?></td>
                                                                            <td><?php echo $eee3; ?></td>
                                                                            <td><?php echo $eee2; ?></td>
                                                                            <td><?php echo $eee1; ?></td>*/ ?>
                                                                            <td id="oce"><?php echo $eee4 + $eee3 + $eee2 + $eee1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>F</td>
                                                                            <td>Physical working conditions </td>
                                                                            <?php /*<td><?php echo $fff4; ?></td>
                                                                            <td><?php echo $fff3; ?></td>
                                                                            <td><?php echo $fff2; ?></td>
                                                                            <td><?php echo $fff1; ?></td>*/ ?>
                                                                            <td id="ocf"><?php echo $fff4 + $fff3 + $fff2 + $fff1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>G</td>
                                                                            <td>Equipment provided </td>
                                                                            <?php /*<td><?php echo $ggg4; ?></td>
                                                                            <td><?php echo $ggg3; ?></td>
                                                                            <td><?php echo $ggg2; ?></td>
                                                                            <td><?php echo $ggg1; ?></td>*/ ?>
                                                                            <td id="ocg"><?php echo $ggg4 + $ggg3 + $ggg2 + $ggg1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>H</td>
                                                                            <td>Support from the HoD </td>
                                                                            <?php /*<td><?php echo $hhh4; ?></td>
                                                                            <td><?php echo $hhh3; ?></td>
                                                                            <td><?php echo $hhh2; ?></td>
                                                                            <td><?php echo $hhh1; ?></td>*/ ?>
                                                                            <td id="och"><?php echo $hhh4 + $hhh3 + $hhh2 + $hhh1; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>I</td>
                                                                            <td>Support from the Human Resources Department </td>
                                                                            <?php /*<td><?php echo $iii4; ?></td>
                                                                            <td><?php echo $iii3; ?></td>
                                                                            <td><?php echo $iii2; ?></td>
                                                                            <td><?php echo $iii1; ?></td>*/ ?>
                                                                            <td id="oci"><?php echo $iii4 + $iii3 + $iii2 + $iii1; ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- end table-responsive-->
                                                        </div><!--end for for table-->
                                                        <div class="col-lg-6"><!--for chart-->
                                                        <div id="bar-chart-job" style="width:95%; height:500px;"></div>
                                                        </div><!--end for for chart-->
                                                    </div><!--end row for table and chart-->
                                                </div><!--end col 12-->
                                            </div><!--end row Opinion to Your Job-->
                                            <?php
                                        }    
                                    }
                                ?>        
                            </div>            
                            <footer class="footer">
                                <?php
                                    include('include_footer.php'); 
                                ?>
                            </footer>
                        </div>
                    </div>
                </div>    
    
                <?php include('include_scripts.php'); ?>
                <script>
                    $('#exampleStat1').DataTable({
                        paging: false,
                        dom: 'Bfrltip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                    $('#exampleStat2').DataTable({
                        paging: false,
                        dom: 'Bfrltip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                    $('#exampleStat3').DataTable({
                        paging: false,
                        dom: 'Bfrltip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                    $('#exampleStat4').DataTable({
                        paging: false,
                        dom: 'Bfrltip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
                </script>
                <!-- Chart JS -->
                <script src="assets/plugins/echarts/echarts-all.js"></script>
                <script src="assets/plugins/echarts/echarts-clearance-reason.js"></script>
                <script src="assets/plugins/echarts/echarts-clearance-dissatisfaction.js"></script>
                <script src="assets/plugins/echarts/echarts-clearance-college.js"></script>
                <script src="assets/plugins/echarts/echarts-clearance-supervisor.js"></script>
                <script src="assets/plugins/echarts/echarts-clearance-job.js"></script>    
                <!---this is for convert to pdf part https://github.com/eKoopmans/html2pdf.js-->
                <script src="js/html2pdf.bundle.js"></script> <!-- Resource JavaScript -->
                    <script>
                      function generatePDF() {
                        // Get the element.
                        var element = document.getElementById('root');
                        // Generate the PDF.
                        html2pdf().from(element).set({
                          margin: 0.5,
                          filename: 'ClearanceExitInterViewStatistics.pdf',
                          //pagebreak: legacy,
                          html2canvas: { scale: 1 },
                          jsPDF: {orientation: 'landscape', unit: 'in', format: 'letter', compressPDF: true}
                          //jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
                        }).save();
                      }
                    </script>
                <!---end for is for convert to pdf part https://github.com/eKoopmans/html2pdf.js-->
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>