<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $id = $helper->cleanString($_GET['id']);
        $cStaffId = $helper->cleanString($_GET['sid']);
        $row = $helper->singleReadFullQry("SELECT * FROM clearance WHERE id = $id AND staffId = '$cStaffId'");
        if($helper->totalCount == 0) 
            $loggedAllowed = false;
        else 
            $loggedAllowed = true;

        $isApprover = new DBaseManipulation;
        $isApproverRow = $isApprover->singleReadFullQry("SELECT * FROM clearance_approval_status WHERE clearance_id = $id AND approverStaffId = '$staffId'");
        if($isApprover->totalCount == 0)
            $loggedAllowed = false;
        else 
            $loggedAllowed = true;
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead')) ? true : false;
        if($allowed){   
            $requestNo = $row['requestNo'];
            $cDate = date('d/m/Y',strtotime($row['dateCreated']));
            if($row['isCleared'] == 1)
                $cStat = 'Cleared';
            else
                $cStat = 'On Process';

            $currentFlag = $isApproverRow['current_flag'];
            $processId = $isApproverRow['clearance_process_id'];                              
            ?>  
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Clearance Exit Interview</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Clearance </li>
                                        <li class="breadcrumb-item">Exit Interview</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <?php 
                                            if(isset($_POST['submit'])) {
                                                function array_push_assoc($array, $key, $value){
                                                   $array[$key] = $value;
                                                   return $array;
                                                }
                                                $fields = array();
                                                $requestNo = $_POST['requestNo'];
                                                $fields = [
                                                    'requestNo'=>$requestNo,
                                                    'staffId'=>$cStaffId,
                                                    'dateSubmitted'=>date('Y-m-d H:i:s')
                                                ];
                                                foreach ($_POST['checkBoxA'] as $chkBoxA){
                                                    $fields = array_push_assoc($fields, 'reasonForLeavingTick'.$chkBoxA, 1);
                                                }
                                                foreach ($_POST['checkBoxB'] as $chkBoxB){
                                                    $fields = array_push_assoc($fields, 'dissatisfiedDueToTick'.$chkBoxB, 1);
                                                }

                                                foreach ($_POST['theJobRdo1'] as $theJobRdo1){
                                                    $fields = array_push_assoc($fields, 'theJobRdo1', $theJobRdo1);
                                                }
                                                foreach ($_POST['theJobRdo2'] as $theJobRdo2){
                                                    $fields = array_push_assoc($fields, 'theJobRdo2', $theJobRdo2);
                                                }
                                                foreach ($_POST['theJobRdo3'] as $theJobRdo3){
                                                    $fields = array_push_assoc($fields, 'theJobRdo3', $theJobRdo3);
                                                }
                                                foreach ($_POST['theJobRdo4'] as $theJobRdo4){
                                                    $fields = array_push_assoc($fields, 'theJobRdo4', $theJobRdo4);
                                                }
                                                foreach ($_POST['theJobRdo5'] as $theJobRdo5){
                                                    $fields = array_push_assoc($fields, 'theJobRdo5', $theJobRdo5);
                                                }
                                                foreach ($_POST['theJobRdo6'] as $theJobRdo6){
                                                    $fields = array_push_assoc($fields, 'theJobRdo6', $theJobRdo6);
                                                }
                                                foreach ($_POST['theJobRdo7'] as $theJobRdo7){
                                                    $fields = array_push_assoc($fields, 'theJobRdo7', $theJobRdo7);
                                                }

                                                foreach ($_POST['theSupRdo1'] as $theSupRdo1){
                                                    $fields = array_push_assoc($fields, 'theSupRdo1', $theSupRdo1);
                                                }
                                                foreach ($_POST['theSupRdo2'] as $theSupRdo2){
                                                    $fields = array_push_assoc($fields, 'theSupRdo2', $theSupRdo2);
                                                }
                                                foreach ($_POST['theSupRdo3'] as $theSupRdo3){
                                                    $fields = array_push_assoc($fields, 'theSupRdo3', $theSupRdo3);
                                                }
                                                foreach ($_POST['theSupRdo4'] as $theSupRdo4){
                                                    $fields = array_push_assoc($fields, 'theSupRdo4', $theSupRdo4);
                                                }
                                                foreach ($_POST['theSupRdo5'] as $theSupRdo5){
                                                    $fields = array_push_assoc($fields, 'theSupRdo5', $theSupRdo5);
                                                }
                                                foreach ($_POST['theSupRdo6'] as $theSupRdo6){
                                                    $fields = array_push_assoc($fields, 'theSupRdo6', $theSupRdo6);
                                                }
                                                foreach ($_POST['theSupRdo7'] as $theSupRdo7){
                                                    $fields = array_push_assoc($fields, 'theSupRdo7', $theSupRdo7);
                                                }
                                                foreach ($_POST['theSupRdo8'] as $theSupRdo8){
                                                    $fields = array_push_assoc($fields, 'theSupRdo8', $theSupRdo8);
                                                }
                                                foreach ($_POST['theSupRdo9'] as $theSupRdo9){
                                                    $fields = array_push_assoc($fields, 'theSupRdo9', $theSupRdo9);
                                                }
                                                foreach ($_POST['theSupRdo10'] as $theSupRdo10){
                                                    $fields = array_push_assoc($fields, 'theSupRdo10', $theSupRdo10);
                                                }
                                                foreach ($_POST['theSupRdo11'] as $theSupRdo11){
                                                    $fields = array_push_assoc($fields, 'theSupRdo11', $theSupRdo11);
                                                }
                                                foreach ($_POST['theSupRdo12'] as $theSupRdo12){
                                                    $fields = array_push_assoc($fields, 'theSupRdo12', $theSupRdo12);
                                                }
                                                foreach ($_POST['theSupRdo13'] as $theSupRdo13){
                                                    $fields = array_push_assoc($fields, 'theSupRdo13', $theSupRdo13);
                                                }

                                                foreach ($_POST['theColRdo1'] as $theColRdo1){
                                                    $fields = array_push_assoc($fields, 'theColRdo1', $theColRdo1);
                                                }
                                                foreach ($_POST['theColRdo2'] as $theColRdo2){
                                                    $fields = array_push_assoc($fields, 'theColRdo2', $theColRdo2);
                                                }
                                                foreach ($_POST['theColRdo3'] as $theColRdo3){
                                                    $fields = array_push_assoc($fields, 'theColRdo3', $theColRdo3);
                                                }
                                                foreach ($_POST['theColRdo4'] as $theColRdo4){
                                                    $fields = array_push_assoc($fields, 'theColRdo4', $theColRdo4);
                                                }
                                                foreach ($_POST['theColRdo5'] as $theColRdo5){
                                                    $fields = array_push_assoc($fields, 'theColRdo5', $theColRdo5);
                                                }
                                                foreach ($_POST['theColRdo6'] as $theColRdo6){
                                                    $fields = array_push_assoc($fields, 'theColRdo6', $theColRdo6);
                                                }
                                                foreach ($_POST['theColRdo7'] as $theColRdo7){
                                                    $fields = array_push_assoc($fields, 'theColRdo7', $theColRdo7);
                                                }
                                                foreach ($_POST['theColRdo8'] as $theColRdo8){
                                                    $fields = array_push_assoc($fields, 'theColRdo8', $theColRdo8);
                                                }
                                                foreach ($_POST['theColRdo9'] as $theColRdo9){
                                                    $fields = array_push_assoc($fields, 'theColRdo9', $theColRdo9);
                                                }

                                                $fields = array_push_assoc($fields, 'generalComment1', $_POST['generalComment1']);
                                                $fields = array_push_assoc($fields, 'generalComment2', $_POST['generalComment2']);
                                                $fields = array_push_assoc($fields, 'generalComment3', $_POST['generalComment3']);
                                                $fields = array_push_assoc($fields, 'generalComment4', $_POST['generalComment4']);
                                                $fields = array_push_assoc($fields, 'generalComment5', $_POST['generalComment5']);
                                                $fields = array_push_assoc($fields, 'generalComment6', $_POST['generalComment6']);
                                                $fields = array_push_assoc($fields, 'generalComment7', $_POST['generalComment7']);

                                                $save = new DBaseManipulation;
                                                if($save->insert("exit_interview_final",$fields)) {
                                                    ?>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#myModal').modal('show');
                                                        });
                                                    </script>
                                                    <?php
                                                }
                                                
                                            }
                                        ?>
                                        <form method="POST" action="" novalidate>
                                            <input type="hidden" value="<?php echo $requestNo; ?>" name="requestNo" >
                                            <div class="card-header bg-light-yellow">
                                                <h4 class="card-title font-weight-bold">Exit Interview Questionnaire</h4>
                                                <div class="row">
                                                    <?php
                                                        $basic_info = new DBaseManipulation;
                                                        $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, s.gender, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.joinDate, n.name as nationality, q.name as qualification FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id LEFT OUTER JOIN nationality as n ON n.id = s.nationality_id LEFT OUTER JOIN qualification as q ON q.id = e.qualification_id WHERE s.staffId = '$cStaffId' AND e.isCurrent = 1 and e.status_id = 1");
                                                    ?>
                                                    <div class="col-lg-3">
                                                        <p class="m-b-0">Staff ID: <span class="text-primary"><?php echo $info['staffId']; ?></span></p>
                                                        <p class="m-b-0">Staff Name: <span class="text-primary"><?php echo $info['staffName']; ?></span></p>
                                                        <p class="m-b-0">Job Title : <span class="text-primary"><?php echo $info['jobtitle']; ?></span></p>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p class="m-b-0">Department: <span class="text-primary"><?php echo $info['department']; ?></span></p>
                                                        <p class="m-b-0">Section: <span class="text-primary"><?php echo $info['section']; ?></span></p>
                                                        <p class="m-b-0">Qualification: <span class="text-primary"><?php echo $info['qualification']; ?></span></p>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p class="m-b-0">Sponsor: <span class="text-primary"><?php echo $info['sponsor']; ?></span></p>
                                                        <p class="m-b-0">Join Date: <span class="text-primary"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></p>
                                                        <p class="m-b-0">Nationality: <span class="text-primary"><?php echo $info['nationality']; ?></span></p>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p class="m-b-0">Clearance ID: <span class="badge badge-primary"><?php echo $requestNo; ?></span></p>
                                                        <p class="m-b-0">Clearance Date: <span class="text-primary"><?php echo $cDate; ?></span></p>
                                                        <p class="m-b-0">Clearance Status: <span class="text-primary"><?php echo $cStat; ?></span></p>
                                                    </div>
                                                </div>
                                            </div><!--end card header-->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="card">
                                                            <div class="card-header bg-light-gray p-b-0 p-t-5">
                                                                <h4>Reason For Leaving</h4>
                                                            </div><!--end card header-->
                                                            <div class="card-body">
                                                                <h4 class="card-title">Was your decision to leave NCT influenced by any of the following? Please mark all that apply:</h4>
                                                                <div class="demo-checkbox">
                                                                    <div class="row">
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="1" id="md_checkbox_Relocation" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Relocation">Relocation</label>
                                                                    </div>

                                                                    <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="2" id="md_checkbox_Education" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Education">Returning for education</label>
                                                                    </div>

                                                                     <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="3" id="md_checkbox_Health" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Health">Health/Medical reasons</label>
                                                                     </div>   


                                                                     <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="4" id="md_checkbox_Family" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Family">Family circumstances</label>
                                                                    </div>
                                                                    </div>


                                                                    <div class="row">
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="5" id="md_checkbox_Retirement" class="filled-in chk-col-indigo" checked />
                                                                        <label for="md_checkbox_Retirement">Retirement</label>
                                                                    </div>

                                                                    <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="6" id="md_checkbox_Stop" class="filled-in chk-col-indigo" />
                                                                        <label for="md_checkbox_Stop">Stop working</label>
                                                                        
                                                                    </div>

                                                                    <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="7" id="md_checkbox_Location" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Location">Location/commute</label>
                                                                    </div>

                                                                    <div class="col-lg-2 col-xs-18">
                                                                         <input type="checkbox" name="checkBoxA[]" value="8" id="md_checkbox_Anotherjob" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Anotherjob">Another job</label>
                                                                    </div>


                                                                     <div class="col-lg-2 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxA[]" value="9" id="md_checkbox_Other" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Other">Other</label>
                                                                    </div>
                                                                    </div>
                                                                </div>

                                                                    <hr>

                                                                    <h4 class="card-title">Dissatisfied due to:</h4>
                                                                <div class="demo-checkbox">

                                                                    <div class="row">
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="1" id="md_checkbox_Work" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Work">Type of work</label>
                                                                    </div>

                                                                    <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="2" id="md_checkbox_Job" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Job">Job responsibilities</label>
                                                                    </div>

                                                                     <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="3" id="md_checkbox_Compensation" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Compensation">Compensation</label>
                                                                     </div>   


                                                                     <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="4" id="md_checkbox_Benefits" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Benefits">Benefits</label>
                                                                    </div>
                                                                    </div>


                                                                    <div class="row">
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="5" id="md_checkbox_Supervisor" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Supervisor">Supervisor</label>
                                                                    </div>

                                                                    <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="6" id="md_checkbox_Management" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Management">Management</label>
                                                                        
                                                                    </div>

                                                                     <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="7" id="md_checkbox_Career" class="filled-in chk-col-indigo"  />
                                                                        <label for="md_checkbox_Career">Career opportunities</label>
                                                                    </div>

                                                                    <div class="col-lg-3 col-xs-18">
                                                                        <input type="checkbox" name="checkBoxB[]" value="8" id="md_checkbox_Satisfied" class="filled-in chk-col-indigo" checked />
                                                                        <label for="md_checkbox_Satisfied">I am satisfied</label>
                                                                    </div>

                                                                     
                                                                    </div>
                                                                    </div>
                                                                
                                                            </div><!--end card body-->
                                                        </div><!--end card reason for leaving-->
                                                    </div><!--end col 12-->
                                                </div><!--end row reason for leaving-->
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18"><!---start for list div-->
                                                        <div class="card">
                                                            <div class="card-header bg-light-gray p-b-0 p-t-5">
                                                                <h4>Your Job - How would you rate the following?</h4>
                                                            </div><!--end card header-->
                                                            <div class="card-body">
                                                                <div class="demo-radio-button">


                                                                <div class="row border-bottom">
                                                                    <div class="col-lg-4 col-xs-18">Morale in the department</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo1[]" value="4" type="radio" id="job_q1_a"  class="with-gap radio-col-indigo" checked />
                                                                        <label for="job_q1_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo1[]" value="3" type="radio" id="job_q1_b" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q1_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo1[]" value="2" type="radio" id="job_q1_c" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q1_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo1[]" value="1" type="radio" id="job_q1_d" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q1_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q1-->



                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Cooperation within the department</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo2[]" value="4" type="radio" id="job_q2_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="job_q2_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo2[]" value="3" type="radio" id="job_q2_b" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q2_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo2[]" value="2" type="radio" id="job_q2_c" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q2_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo2[]" value="1" type="radio" id="job_q2_d" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q2_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q2-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Cooperation with other departments</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo3[]" value="4" type="radio" id="job_q3_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="job_q3_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo3[]" value="3" type="radio" id="job_q3_b" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q3_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo3[]" value="3" type="radio" id="job_q3_c" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q3_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo3[]" value="1" type="radio" id="job_q3_d" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q3_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q3-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Orientation to the job</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo4[]" value="4" type="radio" id="job_q4_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="job_q4_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo4[]" value="3" type="radio" id="job_q4_b" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q4_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo4[]" value="2" type="radio" id="job_q4_c" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q4_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo4[]" value="1" type="radio" id="job_q4_d" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q4_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q4-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Adequate training in the job </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo5[]" value="4" type="radio" id="job_q5_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="job_q5_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo5[]" value="3" type="radio" id="job_q5_b" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q5_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo5[]" value="2" type="radio" id="job_q5_c" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q5_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo5[]" value="1" type="radio" id="job_q5_d" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q5_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q5-->



                                                                 <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Communication within the department </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo6[]" value="4" type="radio" id="job_q6_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="job_q6_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo6[]" value="3" type="radio" id="job_q6_b" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q6_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo6[]" value="2" type="radio" id="job_q6_c" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q6_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo6[]" value="1" type="radio" id="job_q6_d" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q6_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q6-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Fair play  </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo7[]" value="4" type="radio" id="job_q7_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="job_q7_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo7[]" value="3" type="radio" id="job_q7_b" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q7_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo7[]" value="2" type="radio" id="job_q7_c" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q7_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theJobRdo7[]" value="1" type="radio" id="job_q7_d" class="with-gap radio-col-indigo" />
                                                                        <label for="job_q7_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q7-->

                                                                </div><!--end demo-radio-button-->


                                                                </div><!--end card body-->
                                                        </div><!--end card Your Job-->
                                                    </div><!--end col 12-->
                                                </div><!--end row Your Job-->
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18"><!---start for list div-->
                                                        <div class="card">
                                                            <div class="card-header bg-light-gray p-b-0 p-t-5">
                                                                <h4>Your Supervisor - How would you rate your supervisor on the following?</h4>
                                                            </div><!--end card header-->
                                                            <div class="card-body">
                                                                <div class="demo-radio-button">


                                                                <div class="row border-bottom">
                                                                    <div class="col-lg-4 col-xs-18">Fair and equal treatment of employees</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo1[]" value="4" type="radio" id="supervisor_q1_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q1_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo1[]" value="3" type="radio" id="supervisor_q1_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q1_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo1[]" value="2" type="radio" id="supervisor_q1_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q1_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo1[]" value="1" type="radio" id="supervisor_q1_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q1_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q1-->



                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Provides recognition on the job</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo2[]" value="4" type="radio" id="supervisor_q2_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q2_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo2[]" value="3" type="radio" id="supervisor_q2_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q2_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo2[]" value="2" type="radio" id="supervisor_q2_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q2_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo2[]" value="1" type="radio" id="supervisor_q2_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q2_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q2-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Resolves complaints and problems </div>
                                                                     <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo3[]" value="4" type="radio" id="supervisor_q3_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q3_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo3[]" value="3" type="radio" id="supervisor_q3_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q3_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo3[]" value="2" type="radio" id="supervisor_q3_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q3_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo3[]" value="1" type="radio" id="supervisor_q3_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q3_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q3-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Follows consistent policies </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo4[]" value="4" type="radio" id="supervisor_q4_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q4_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo4[]" value="3" type="radio" id="supervisor_q4_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q4_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo4[]" value="2" type="radio" id="supervisor_q4_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q4_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo4[]" value="1" type="radio" id="supervisor_q4_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q4_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q4-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Keeps employees informed about what is going on </div>
                                                                     <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo5[]" value="4" type="radio" id="supervisor_q5_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q5_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo5[]" value="3" type="radio" id="supervisor_q5_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q5_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo5[]" value="2" type="radio" id="supervisor_q5_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q5_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo5[]" value="1" type="radio" id="supervisor_q5_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q5_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q5-->



                                                                 <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Encourages feedback/welcomes suggestions</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo6[]" value="4" type="radio" id="supervisor_q6_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q6_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo6[]" value="3" type="radio" id="supervisor_q6_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q6_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo6[]" value="2" type="radio" id="supervisor_q6_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q6_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo6[]" value="1" type="radio" id="supervisor_q6_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q6_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q6-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Shows willingness to admit and correct mistakes</div>
                                                                   <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo7[]" value="4" type="radio" id="supervisor_q7_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q7_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo7[]" value="3" type="radio" id="supervisor_q7_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q7_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo7[]" value="2" type="radio" id="supervisor_q7_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q7_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo7[]" value="1" type="radio" id="supervisor_q7_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q7_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q7-->

                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Support from the Human Resources Department</div>
                                                                   <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo8[]" value="4" type="radio" id="supervisor_q8_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q8_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo8[]" value="3" type="radio" id="supervisor_q8_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q8_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo8[]" value="2" type="radio" id="supervisor_q8_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q8_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo8[]" value="1" type="radio" id="supervisor_q8_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q8_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q8-->

                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Gives instructions clearly </div>
                                                                   <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo9[]" value="4" type="radio" id="supervisor_q9_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q9_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo9[]" value="3" type="radio" id="supervisor_q9_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q9_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo9[]" value="2" type="radio" id="supervisor_q9_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q9_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo9[]" value="1" type="radio" id="supervisor_q9_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q9_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q9-->



                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Gets cooperation</div>
                                                                   <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo10[]" value="4" type="radio" id="supervisor_q10_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q10_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo10[]" value="3" type="radio" id="supervisor_q10_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q10_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo10[]" value="2" type="radio" id="supervisor_q10_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q10_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo10[]" value="1" type="radio" id="supervisor_q10_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q10_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q10-->

                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Shows an interest in individual employees</div>
                                                                   <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo11[]" value="4" type="radio" id="supervisor_q11_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q11_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo11[]" value="3" type="radio" id="supervisor_q11_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q11_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo11[]" value="2" type="radio" id="supervisor_q11_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q11_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo11[]" value="1" type="radio" id="supervisor_q11_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q11_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q11-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Handles pressure/conflict </div>
                                                                   <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo12[]" value="4" type="radio" id="supervisor_q12_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q12_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo12[]" value="3" type="radio" id="supervisor_q12_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q12_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo12[]" value="2" type="radio" id="supervisor_q12_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q12_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo12[]" value="1" type="radio" id="supervisor_q12_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q12_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q12-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Overall effectiveness </div>
                                                                   <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo13[]" value="4" type="radio" id="supervisor_q13_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="supervisor_q13_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo13[]" value="3" type="radio" id="supervisor_q13_b" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q13_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo13[]" value="2" type="radio" id="supervisor_q13_c" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q13_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theSupRdo13[]" value="1" type="radio" id="supervisor_q13_d" class="with-gap radio-col-indigo" />
                                                                        <label for="supervisor_q13_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q13-->

                                                                </div><!--end demo-radio-button-->

                                                                </div><!--end card body-->
                                                        </div><!--end card Your Supervisor-->
                                                    </div><!--end col 12-->
                                                </div><!--end row Your supervisor-->
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="card">
                                                            <div class="card-header bg-light-gray p-b-0 p-t-5">
                                                                <h4>Your College - How would you rate the following?</h4>
                                                            </div><!--end card header-->
                                                            <div class="card-body">
                                                                <div class="demo-radio-button">
                                                                <div class="row border-bottom">
                                                                    <div class="col-lg-4 col-xs-18">Morale as a whole</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo1[]" value="4" type="radio" id="college_q1_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q1_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo1[]" value="3" type="radio" id="college_q1_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q1_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo1[]" value="2" type="radio" id="college_q1_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q1_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo1[]" value="1" type="radio" id="college_q1_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q1_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q1-->



                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Your salary</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo2[]" value="4" type="radio" id="college_q2_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q2_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo2[]" value="3" type="radio" id="college_q2_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q2_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo2[]" value="2" type="radio" id="college_q2_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q2_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo2[]" value="1" type="radio" id="college_q2_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q2_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q2-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Opportunity for advancement/promotion</div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo3[]" value="4" type="radio" id="college_q3_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q3_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo3[]" value="3" type="radio" id="college_q3_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q3_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo3[]" value="2" type="radio" id="college_q3_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q3_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo3[]" value="1" type="radio" id="college_q3_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q3_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q3-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Employee recognition</div>
                                                                     <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo4[]" value="4" type="radio" id="college_q4_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q4_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo4[]" value="3" type="radio" id="college_q4_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q4_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo4[]" value="2" type="radio" id="college_q4_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q4_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo4[]" value="1" type="radio" id="college_q4_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q4_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q4-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Benefits </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo5[]" value="4" type="radio" id="college_q5_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q5_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo5[]" value="3" type="radio" id="college_q5_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q5_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo5[]" value="2" type="radio" id="college_q5_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q5_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo5[]" value="1" type="radio" id="college_q5_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q5_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q5-->



                                                                 <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Physical working conditions </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo6[]" value="4" type="radio" id="college_q6_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q6_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo6[]" value="3" type="radio" id="college_q6_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q6_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo6[]" value="2" type="radio" id="college_q6_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q6_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo6[]" value="1" type="radio" id="college_q6_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q6_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q6-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Equipment provided </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo7[]" value="4" type="radio" id="college_q7_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q7_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo7[]" value="3" type="radio" id="college_q7_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q7_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo7[]" value="2" type="radio" id="college_q7_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q7_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo7[]" value="1" type="radio" id="college_q7_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q7_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q7-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Support from the HoD </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo8[]" value="4" type="radio" id="college_q8_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q8_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo8[]" value="2" type="radio" id="college_q8_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q8_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo8[]" value="2" type="radio" id="college_q8_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q8_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo8[]" value="1" type="radio" id="college_q8_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q8_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q8-->


                                                                <div class="row border-bottom m-t-5">
                                                                    <div class="col-lg-4 col-xs-18">Support from the Human Resources Department </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo9[]" value="4" type="radio" id="college_q9_a" class="with-gap radio-col-indigo" checked />
                                                                        <label for="college_q9_a">Excellent</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo9[]" value="3" type="radio" id="college_q9_b" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q9_b">Good</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo9[]" value="2" type="radio" id="college_q9_c" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q9_c">Fair</label>
                                                                    </div>
                                                                    <div class="col-lg-2 col-xs-18">
                                                                        <input name="theColRdo9[]" value="1" type="radio" id="college_q9_d" class="with-gap radio-col-indigo" />
                                                                        <label for="college_q9_d">Poor</label>
                                                                    </div>
                                                                </div><!--end row q9-->
                                                                </div><!--end demo-radio-button-->
                                                                </div><!--end card body-->
                                                        </div><!--end card college-->
                                                    </div><!--end col 12-->
                                                </div><!--end row college-->
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="form-group">
                                                            <h5 class="text-blue-bright"><span class="text-danger">*</span> Would you want to work here again if a suitable job was available?</h5>
                                                            <div class="controls">
                                                                <textarea class="form-control" id="" name="generalComment1" rows="2" placeholder="Type Details Here" required></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="form-group">
                                                            <h5 class="text-blue-bright"><span class="text-danger">*</span> If you are resigning voluntarily, is there anything NCT could have done to keep you?</h5>
                                                            <div class="controls">
                                                                <textarea class="form-control" id="" name="generalComment2" rows="2" placeholder="Type Details Here" required></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="form-group">
                                                            <h5 class="text-blue-bright"><span class="text-danger">*</span> What did you like most about working in NCT?</h5>
                                                            <div class="controls">
                                                                <textarea class="form-control" id="" name="generalComment3" rows="2" placeholder="Type Details Here" required></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="form-group">
                                                            <h5 class="text-blue-bright"><span class="text-danger">*</span> What did you like least about working in NCT?</h5>
                                                            <div class="controls">
                                                                <textarea class="form-control" id="" name="generalComment4" rows="2" placeholder="Type Details Here" required></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="form-group">
                                                            <h5 class="text-blue-bright"><span class="text-danger">*</span>Did you feel free to discuss problems or complaints with your supervisor?</h5>
                                                            <div class="controls">
                                                                <textarea class="form-control" id="" name="generalComment5" rows="2" placeholder="Type Details Here" required></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="form-group">
                                                            <h5 class="text-blue-bright"><span class="text-danger">*</span> Have you sustained any work related injury or illness, which has not been reported?</h5>
                                                            <div class="controls">
                                                                <textarea class="form-control" id="" name="generalComment6" rows="2" placeholder="Type Details Here" required></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">
                                                        <div class="form-group">
                                                            <h5 class="text-blue-bright"><span class="text-danger">*</span> Other comments or suggestions</h5>
                                                            <div class="controls">
                                                                <textarea class="form-control" id="" name="generalComment7" rows="2" placeholder="Type Details Here" required></textarea>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-xs-18">               
                                                        <div class="text-xs-right">
                                                            <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                            <a href="" class="btn btn-warning waves-effect waves-light"><i class="fa fa-refresh"></i> Reset All</a>
                                                            <!-- <button type="submit" name="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Finalized</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end card body main-->
                                        </form>
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
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Exit interview has been submitted successfully!</h5>
                                <h5>You can now approve the clearance of the staff.</h5>
                                <a href="index.php" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>
</html>