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
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
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
                                <div class="col-lg-5 col-xs-18">
                                    <div class="card card-body p-b-0">

                                        <form>

                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Date</label>
                                                <div class="col-sm-6">
                                                    <input type='text' class="form-control daterange" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-success waves-effect waves-light"  type="button" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                </div>
                                            </div><!--end form-group-->
                                        </form>
                                    </div>
                                </div>
                            </div>
<button class="btn btn-primary" onclick="test()">Generate PDF</button>                            
<div id="root">
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
                                <div id="bar-chart-reason" style="width:85%; height:500px;"></div>
                            </div><!--end for for chart-->
                        </div><!--end row for table and chart-->
                    </div><!--end col 10-->
                </div><!--end row reason for leaving-->
                <!---------------------------------------->

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
                                <div id="bar-chart-dissatisfaction" style="width:85%; height:500px;"></div>
                            </div><!--end for for chart-->
                        </div><!--end row for table and chart-->
                    </div><!--end col 10-->
                </div><!--end row Dissatisfied-->
                <!---------------------------------------->

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
                                <div id="bar-chart-college" style="width:85%; height:500px;"></div>
                            </div><!--end for for chart-->
                        </div><!--end row for table and chart-->
                    </div><!--end col 10-->
                </div><!--end row opinion to coll-->
                <!---------------------------------------->

                <div class="row">
                    <div class="col-lg-10">
                        <p class="font-weight-bold">Opinion to Your Supervisor</p>
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
                                <div id="bar-chart-supervisor" style="width:85%; height:500px;"></div>
                            </div><!--end for for chart-->
                        </div><!--end row for table and chart-->
                    </div><!--end col 10-->
                </div><!--end row Supervisor-->
                <!---------------------------------------->

                

                 <div class="row">
                    <div class="col-lg-10">
                        <p class="font-weight-bold text-primary">Opinion to Your Job</p>
                        <div class="row">
                            <div class="col-lg-5"><!--for table-->
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
                            <div id="bar-chart-job" style="width:70%; height:500px;"></div>
                            </div><!--end for for chart-->
                        </div><!--end row for table and chart-->
                    </div><!--end col 12-->
                </div><!--end row Supervisor-->
                <!---------------------------------------->
                </div><!--end for root for converting to pdf-->            
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
                      function test() {
                        // Get the element.
                        var element = document.getElementById('root');
                        // Generate the PDF.
                        html2pdf().from(element).set({
                          margin: 0.5,
                          filename: 'ClearanceExitInterViewStatistics.pdf',
                          //pagebreak: legacy,
                          html2canvas: { scale: 2 },
                          jsPDF: {orientation: 'landscape', unit: 'in', format: 'letter', compressPDF: true}
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