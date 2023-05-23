<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed =  true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            ?>  
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <div class="preloader">
                    <!-- <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg> -->
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Appraisal - Admin Staff</h3>
                                    <ol class="breadcrumb">
                                         <li class="breadcrumb-item">Home</a></li>
                                         <li class="breadcrumb-item"><a href="appraisal_homepage.php" title="Click to View Appraisal Homepage">Appraisal</a> </li>
                                        <li class="breadcrumb-item">Staff Appraisal</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-18">
                                    <div class="card">
                                        <?php
                                            $appraisalYear = $helper->getAppraisalYear('appraisal_year');
                                            $basic_info = new DBaseManipulation;
                                            $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, s.joinDate, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id, e.position_id, nat.name as nationality FROM staff as s INNER JOIN employmentdetail as e ON s.staffId = e.staff_id INNER JOIN department as d ON d.id = e.department_id INNER JOIN section as sc ON e.section_id = sc.id INNER JOIN sponsor as sp ON sp.id = e.sponsor_id INNER JOIN jobtitle as j ON j.id = e.jobtitle_id INNER JOIN nationality as nat ON nat.id = s.nationality_id WHERE s.staffId = '$staffId'");
                                        ?>
                                        <div class="card-header bg-light-success" style="border-bottom: double; border-color: #28a745">
                                            <div class="d-flex no-block align-items-center">
                                                <h4 class="card-title font-weight-bold">Staff Appraisal Form - Admin Staff [<?php echo $appraisalYear; ?>]</h4>
                                                <div class="ml-auto">
                                                    <ul class="list-inline text-right">
                                                        <?php 
                                                            $checkSubmitted =  new DbaseManipulation;
                                                            $currentYear = date('Y');
                                                            if(isset($_GET['y'])) {
                                                                $currentYear = $_GET['y'];
                                                            } else {
                                                                $currentYear = date('Y');
                                                            }
                                                            $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_admin WHERE staff_id = '$staffId' AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                                            if($checkSubmitted->totalCount != 0) {
                                                                $staffStats = 'Submitted ['.date('d/m/Y',strtotime($rec['date_submitted'])).']';
                                                                $requestNo = $rec['requestNo'];
                                                                if($rec['status'] == 'Completed') {
                                                                    $show = 'display: inline';
                                                                } else {
                                                                    $show = 'display: none';
                                                                }
                                                            } else {
                                                                $staffStats = 'Not Started';
                                                                $request = new DbaseManipulation;
                                                                $requestNo = $request->requestNo("ADM-","appraisal_admin");
                                                                $show = 'display: none';
                                                            }
                                                        ?>
                                                        <li>ID/Status <span class="font-weight-bold text-info"><?php echo $requestNo; ?> - <?php echo $rec['status']; ?></span></li>
                                                        <!-- <a style="<?php echo $show; ?>" href="appraisal_adminstaff_view.php?id=<?php echo $rec['id']; ?>&y=<?php echo $_GET['y']; ?>" target="_blank" class="btn btn-sm btn-warning waves-effect waves-light" title="Click to Show the Appraisal Result to Staff"><i class="fas fa-search"></i> View Result</a> -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-2">Name</div>
                                                        <div class="col-md-10"> <span class="font-weight-bold text-info"><?php echo trim($info['staffName']); ?> </span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Section</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"> <?php echo $info['section']; ?> </span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Dept.</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"><?php echo $info['department']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-2">Job Title</div>
                                                        <div class="col-md-10"><span class="font-weight-bold text-info"><?php echo $info['jobtitle']; ?></span></div>
                                                    </div><!--end row-->
                                                </div><!--end col staff-->

                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-4">Gender</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['gender']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-4">Nationality</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['nationality']; ?></span></div>
                                                    </div><!--end row-->
                                                    <div class="row">
                                                        <div class="col-md-4">Sponsor</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo $info['sponsor']; ?></span></div>
                                                    </div><!--end row-->
                                                     <div class="row">
                                                        <div class="col-md-4">Join Date</div>
                                                        <div class="col-md-8"><span class="font-weight-bold text-info"><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></span></div>
                                                    </div><!--end row-->
                                                </div><!--end col -->

                                                <div class="col-md-5">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-2">Staff </div>
                                                        <div class="col-md-6"><?php echo trim($info['staffName']); ?></div>

                                                        <div class="col-md-4"><span class="font-weight-bold text-info"><?php echo $staffStats; ?> </span></div>
                                                    </div><!--end row-->
                                                    <?php
                                                    // echo "ID".$_GET['id'];
                                                        if(isset($_GET['id'])) {
                                                            $id = $_GET['id'];
                                                            $staff_position_id = $info['position_id'];
                                                            $approval = new DbaseManipulation;
                                                            $approvers = $approval->readData("SELECT s.*, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as approverName, p.code as approverTitle FROM  appraisal_approval_sequence as s LEFT OUTER JOIN staff_position as p ON p.id = s.approver_id LEFT OUTER JOIN employmentdetail as e ON e.position_id = s.approver_id LEFT OUTER JOIN staff as ss ON e.staff_id = ss.staffId WHERE s.position_id = $staff_position_id AND e.isCurrent = 1 and e.status_id = 1 and s.active=1 ORDER BY s.sequence_no");
                                                            // print_r($approvers);
                                                           

                                                            
                                                            if($approval->totalCount != 0) {
                                                                if($rec['current_sequence'] == 2 || $rec['current_approver'] == 1) { //Last Approver
                                                                    foreach ($approvers as $row) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                            <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                            <?php 
                                                                                if($row['sequence_no'] == 1) {
                                                                                    ?>
                                                                                    <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate('appraisal_admin_hod_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                    <?php
                                                                                } else if($row['sequence_no'] >= 2) {
                                                                                    if($rec['status'] == 'Completed') {
                                                                                        ?>
                                                                                        <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate2('appraisal_dean_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                        <?php
                                                                                    } else {
                                                                                        ?>
                                                                                        <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                    }        
                                                                } else if($rec['current_sequence'] == 1) { //2nd Approver
                                                                    foreach ($approvers as $row) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                            <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                            <?php 
                                                                                if($row['sequence_no'] == 1) {
                                                                                    ?>
                                                                                    <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                    <?php
                                                                                } else if($row['sequence_no'] == 2) {
                                                                                    ?>
                                                                                    <div class="col-md-4"><span class="font-weight-bold text-info">Pending</span></div>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        <?php
                                                                    }        
                                                                }
                                                            }
                                                        } 
                                                        else
                                                        {
                                                            $sql = "SELECT app.*, p.code as taype FROM appraisal_admin app INNER JOIN staff_position p ON app.position_id = p.id WHERE app.staff_id = $staffId ORDER BY app.appraisal_year DESC";
                                                            $appraisalLists = $helper->readData($sql);
                                                              
                                                              $id =$appraisalLists['0']['id'];
                                                              $staff_position_id = $info['position_id'];
                                                              $approval = new DbaseManipulation;
                                                              $approvers = $approval->readData("SELECT s.*, concat(ss.firstName,' ',ss.secondName,' ',ss.thirdName,' ',ss.lastName) as approverName, p.code as approverTitle FROM  appraisal_approval_sequence as s LEFT OUTER JOIN staff_position as p ON p.id = s.approver_id LEFT OUTER JOIN employmentdetail as e ON e.position_id = s.approver_id LEFT OUTER JOIN staff as ss ON e.staff_id = ss.staffId WHERE s.position_id = $staff_position_id AND e.isCurrent = 1 and e.status_id = 1 and s.active=1 ORDER BY s.sequence_no");
                                                              // print_r($approvers);
  
                                                              
                                                              if($approval->totalCount != 0) {
                                                                  if($rec['current_sequence'] == 2 || $rec['current_approver'] == 1) { //Last Approver
                                                                      foreach ($approvers as $row) {
                                                                          ?>
                                                                          <div class="row">
                                                                              <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                              <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                              <?php 
                                                                                  if($row['sequence_no'] == 1) {
                                                                                      ?>
                                                                                      <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate('appraisal_admin_hod_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                      <?php
                                                                                  } else if($row['sequence_no'] >= 2) {
                                                                                      if($rec['status'] == 'Completed') {
                                                                                          ?>
                                                                                          <div class="col-md-4"><span class="font-weight-bold text-info">Completed [<?php echo date('d/m/Y',strtotime($helper->appraisalGetCompletedDate2('appraisal_dean_observation',$id,$info['staffId'],'date_submitted'))); ?>]</span></div>
                                                                                          <?php
                                                                                      } else {
                                                                                          ?>
                                                                                          <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                          <?php
                                                                                      }
                                                                                  }
                                                                              ?>
                                                                          </div>
                                                                          <?php
                                                                      }        
                                                                  } else if($rec['current_sequence'] == 1) { //2nd Approver
                                                                      foreach ($approvers as $row) {
                                                                          ?>
                                                                          <div class="row">
                                                                              <div class="col-md-2"><?php echo $row['approverTitle']; ?></div>
                                                                              <div class="col-md-6"><?php echo $row['approverName']; ?></div>
                                                                              <?php 
                                                                                  if($row['sequence_no'] == 1) {
                                                                                      ?>
                                                                                      <div class="col-md-4"><span class="font-weight-bold text-info">On Process</span></div>
                                                                                      <?php
                                                                                  } else if($row['sequence_no'] == 2) {
                                                                                      ?>
                                                                                      <div class="col-md-4"><span class="font-weight-bold text-info">Pending</span></div>
                                                                                      <?php
                                                                                  }
                                                                              ?>
                                                                              
                                                                          </div>
                                                                          <?php
                                                                      }        
                                                                  }
                                                              }

                                                            
                                                        }   
                                                    ?>
                                                </div><!--end col status-->
                                            </div><!--end row-->
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-tabs customtab2" role="tablist">
                                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#Qualification" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Qualification</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#StaffTraining" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Staff Training</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#SelfAppraisal" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Self Appraisal</span></a> </li>
                                                <?php
                                            $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_admin WHERE staff_id = '$staffId' AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                            if ($checkSubmitted->totalCount != 0) {
                                                $staffStats = 'Submitted [' . date('d/m/Y', strtotime($rec['date_submitted'])) . ']';
                                                $requestNo = $rec['requestNo'];
                                                if ($rec['status'] == 'Completed') {
                                            ?>
                                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#AppraisalResult" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Appraisal Result</span></a> </li>

                                            <?php
                                                } else {
                                                }
                                            } ?>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane p-20 active" id="Qualification" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                            <h4 class="card-title">Staff Qualification List</h4>
                                                        </div>    
                                                        <div class="card-body">
                                                            <div class="table-responsiveXXX">
                                                                <table class="display nowrap table table-hover table-striped table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Degree</th>
                                                                            <th>Qualification Name</th>
                                                                            <th>University/Country</th>
                                                                            <th>Year</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            $qua = new DBaseManipulation;
                                                                            $rows = $qua->readData("SELECT sq.*, d.name as degree, c.name as certification FROM staffqualification as sq LEFT OUTER JOIN degree as d ON d.id = sq.degree_id LEFT OUTER JOIN certificate as c ON c.id = sq.certificate_id WHERE staffId = '$staffId'");
                                                                            if($qua->totalCount != 0) {
                                                                                $i = 0;
                                                                                foreach ($rows as $row) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                                        <td><span class="text-primary font-weight-bold"><?php echo $row['degree']; ?></span></td>
                                                                                        <td><?php echo $row['certification']; ?></td>
                                                                                        <td><?php echo $row['institution']; ?></td>
                                                                                        <td><?php echo $row['graduateYear']; ?></td>
                                                                                    </tr>
                                                                                <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20" id="StaffTraining" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header bg-light-info p-b-0 p-t-5"><h4 class="card-title font-weight-bold">Training Courses Received by the Employee During This Year الدورات التدريبية التي حصل عليها الموظف خلال هذا العام [<i>To be filled by the employee تعبأ من قبل الموظف</i>]</h4></div>
                                                        <div class="card-body">
                                                            <?php 
                                                                if(isset($_POST['submitTraining'])) {
                                                                    $submit = new DbaseManipulation;
                                                                    $row = $submit->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM appraisal_approval_sequence as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                                    $sequence_no = $row['sequence_no'];
                                                                    $approver_id = $row['approver_id'];
                                                                    $requestIdNumber = $_POST['request_no'];
                                                                    $checkRequest = new DbaseManipulation;
                                                                    $newReqNo = $_POST['request_no'];    
                                                                    // $checkRequest->singleReadFullQry("SELECT TOP 1 id, requestNo FROM appraisal_admin WHERE requestNo = '$requestIdNumber' ORDER BY id DESC");
                                                                    // if($checkRequest->totalCount != 0) {
                                                                    //     $req = new DbaseManipulation;
                                                                    //     $newReqNo = $req->requestNo("ADM-","appraisal_admin");    
                                                                    // } else {
                                                                    //     $newReqNo = $_POST['request_no'];    
                                                                    // }
                                                                    $fields_appraisal_admin = [
                                                                        'requestNo'=>$newReqNo,
                                                                        'staff_id'=>$staffId,
                                                                        'department_id'=>$logged_in_department_id,
                                                                        'section_id'=>$logged_in_section_id,
                                                                        'appraisal_type'=>3,
                                                                        'status'=>'Submitted by the Staff',
                                                                        'position_id'=>$myPositionId,
                                                                        'current_approver'=>$approver_id,
                                                                        'current_sequence'=>$sequence_no,
                                                                        'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                        'appraisal_year'=>date('Y',time())
                                                                    ];
                                                                    if($helper->insert("appraisal_admin",$fields_appraisal_admin)) {
                                                                        $huli = $submit->singleReadFullQry("SELECT TOP 1 id FROM appraisal_admin ORDER BY id DESC");
                                                                        $last_id_appraisal_admin = $huli['id'];
                                                                         $fields_appraisal_admin_training = [
                                                                            'appraisal_type_description_id'=>3,
                                                                            'appraisal_type_id'=>$last_id_appraisal_admin,
                                                                            'staff_id'=>$staffId,
                                                                            'subject'=>$_POST['training_subject1'],
                                                                            'start_date'=>$_POST['startDate1'],
                                                                            'end_date'=>$_POST['endDate1'],
                                                                            'institution'=>$_POST['institution1'],
                                                                            'submitted_by'=>$staffId,
                                                                            'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                            'appraisal_year'=>$appraisalYear
                                                                        ];
                                                                        if($helper->insert("appraisal_admin_training",$fields_appraisal_admin_training)) {
                                                                            if($_POST['training_subject2'] != '') {
                                                                                $fields2 = [
                                                                                    'appraisal_type_description_id'=>3,
                                                                                    'appraisal_type_id'=>$last_id_appraisal_admin,
                                                                                    'staff_id'=>$staffId,
                                                                                    'subject'=>$_POST['training_subject2'],
                                                                                    'start_date'=>$_POST['startDate2'],
                                                                                    'end_date'=>$_POST['endDate2'],
                                                                                    'institution'=>$_POST['institution2'],
                                                                                    'submitted_by'=>$staffId,
                                                                                    'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                    'appraisal_year'=>$appraisalYear
                                                                                ];
                                                                                $helper->insert("appraisal_admin_training",$fields2);
                                                                            }
                                                                            if($_POST['training_subject3'] != '') {
                                                                                $fields3 = [
                                                                                    'appraisal_type_description_id'=>3,
                                                                                    'appraisal_type_id'=>$last_id_appraisal_admin,
                                                                                    'staff_id'=>$staffId,
                                                                                    'subject'=>$_POST['training_subject3'],
                                                                                    'start_date'=>$_POST['startDate3'],
                                                                                    'end_date'=>$_POST['endDate3'],
                                                                                    'institution'=>$_POST['institution3'],
                                                                                    'submitted_by'=>$staffId,
                                                                                    'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                    'appraisal_year'=>$appraisalYear
                                                                                ];
                                                                                $helper->insert("appraisal_admin_training",$fields3);
                                                                            }
                                                                            if($_POST['training_subject4'] != '') {
                                                                                $fields4 = [
                                                                                    'appraisal_type_description_id'=>3,
                                                                                    'appraisal_type_id'=>$last_id_appraisal_admin,
                                                                                    'staff_id'=>$staffId,
                                                                                    'subject'=>$_POST['training_subject4'],
                                                                                    'start_date'=>$_POST['startDate4'],
                                                                                    'end_date'=>$_POST['endDate4'],
                                                                                    'institution'=>$_POST['institution4'],
                                                                                    'submitted_by'=>$staffId,
                                                                                    'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                    'appraisal_year'=>$appraisalYear
                                                                                ];
                                                                                $helper->insert("appraisal_admin_training",$fields4);
                                                                            }
                                                                            if($_POST['training_subject5'] != '') {
                                                                                $fields5 = [
                                                                                    'appraisal_type_description_id'=>3,
                                                                                    'appraisal_type_id'=>$last_id_appraisal_admin,
                                                                                    'staff_id'=>$staffId,
                                                                                    'subject'=>$_POST['training_subject5'],
                                                                                    'start_date'=>$_POST['startDate5'],
                                                                                    'end_date'=>$_POST['endDate5'],
                                                                                    'institution'=>$_POST['institution5'],
                                                                                    'submitted_by'=>$staffId,
                                                                                    'date_submitted'=>date('Y-m-d H:i:s',time()),
                                                                                    'appraisal_year'=>$appraisalYear
                                                                                ];
                                                                                $helper->insert("appraisal_admin_training",$fields5);
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModalStaffTraining').modal('show');
                                                                            });
                                                                        </script>
                                                                        <?php

                                                                    }        
                                                                }
                                                                if($checkSubmitted->totalCount != 0) {
                                                                    $app_type_id = $rec['id'];
                                                                    $rows = $helper->readData("SELECT * FROM appraisal_admin_training WHERE appraisal_type_id = $app_type_id");
                                                                    ?>
                                                                    <form novalidate>
                                                                        <div class="form-group row m-t-0">
                                                                            <label  class="col-sm-5 control-label">The subject of the training course موضوع الدورة التدريبية</label>
                                                                            <label  class="col-sm-3 control-label">Period From/To في الفترة من / إلى </label>
                                                                            <label  class="col-sm-4 control-label">Institute or Institution Name اسم المعهد أو المؤسسة</label>
                                                                        </div>
                                                                        <?php 
                                                                            foreach ($rows as $row) {
                                                                                ?>
                                                                                <div class="form-group row m-b-5 m-t-0">
                                                                                    <div class="col-sm-5">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                               <input type="text" value="<?php echo $row['subject']; ?>" class="form-control" readonly>  
                                                                                           </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                        <div class='input-group mb-3'>
                                                                                            <input type='text' class="form-control" value="<?php echo date('d/m/Y',strtotime($row['start_date'])).' - '.date('d/m/Y',strtotime($row['end_date'])); ?>" readonly />
                                                                                            <div class="input-group-append">
                                                                                                <span class="input-group-text">
                                                                                                    <span class="far fa-calendar-alt"></span>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                               <input type="text" value="<?php echo $row['institution']; ?>" class="form-control" readonly>  
                                                                                           </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        ?>

                                                                        <!-------------start added as of december 31,2020----------------------->
                                                                        <div class="form-group row m-b-0">
                                                        <div class="col-sm-12">
                                                            <h5>The courses and training programs the employee needs that will raise the level of his/her work performance</h5>
                                                                <h3>الدورات والبرامج التدريبية التي يحتاجها الموظف والتي سترفع من مستوى أداء عمله

                                                            </h3>
                                                            <div class="controls">
                                                                <textarea class="textarea_goal1 form-control" rows="3"></textarea>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-------------end added as of december 31,2020----------------------->


                                                                    </form>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                        <div class="form-group row m-t-0">
                                                                            <label  class="col-sm-5 control-label">The subject of the training course موضوع الدورة التدريبية</label>
                                                                            <label  class="col-sm-3 control-label">Period From/To في الفترة من / إلى </label>
                                                                            <label  class="col-sm-4 control-label">Institute or Institution Name اسم المعهد أو المؤسسة</label>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <div class="col-sm-5">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="training_subject1" class="form-control" required data-validation-required-message="Please enter subject of the training course">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class='input-group mb-3'>
                                                                                    <input type='text' class="form-control dateRange1" required data-validation-required-message="Please Select Date" />
                                                                                    <input type="hidden" name="startDate1" class="form-control startDate1" />
                                                                                    <input type="hidden" name="endDate1" class="form-control endDate1" />
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                            <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="institution1" class="form-control" required data-validation-required-message="Institute or Institution Name">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <div class="col-sm-5">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="training_subject2" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class='input-group mb-3'>
                                                                                    <input type='text' class="form-control dateRange2" />
                                                                                    <input type="hidden" name="startDate2" class="form-control startDate2" />
                                                                                    <input type="hidden" name="endDate2" class="form-control endDate2" />
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                            <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="institution2" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <div class="col-sm-5">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="training_subject3" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class='input-group mb-3'>
                                                                                    <input type='text' class="form-control dateRange3" />
                                                                                    <input type="hidden" name="startDate3" class="form-control startDate3" />
                                                                                    <input type="hidden" name="endDate3" class="form-control endDate3" />
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                            <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="institution3" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <div class="col-sm-5">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="training_subject4" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class='input-group mb-3'>
                                                                                    <input type='text' class="form-control dateRange4" />
                                                                                    <input type="hidden" name="startDate4" class="form-control startDate4" />
                                                                                    <input type="hidden" name="endDate4" class="form-control endDate4" />
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                            <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="institution4" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <div class="col-sm-5">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="training_subject5" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <div class='input-group mb-3'>
                                                                                    <input type='text' class="form-control dateRange5" />
                                                                                    <input type="hidden" name="startDate5" class="form-control startDate5" />
                                                                                    <input type="hidden" name="endDate5" class="form-control endDate5" />
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                            <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                       <input type="text" name="institution5" class="form-control">  
                                                                                   </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                        <!-------------start added as of december 31,2020----------------------->


                                                                        <div class="form-group row m-b-0">
                                                        <div class="col-sm-12">
                                                            <h5>The courses and training programs the employee needs that will raise the level of his/her work performance</h5>
                                                                <h3>الدورات والبرامج التدريبية التي يحتاجها الموظف والتي سترفع من مستوى أداء عمله

                                                            </h3>
                                                            <div class="controls">
                                                                <textarea class="textarea_goal1 form-control" rows="3"></textarea>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-------------end added as of december 31,2020----------------------->

                                                                        
                                                                        <div class="form-group row m-b-0">
                                                                            <div class="col-sm-10">
                                                                                <input type="hidden" name="request_no" value="<?php echo $requestNo; ?>">
                                                                                <button type="submit" name="submitTraining" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Save</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <?php
                                                                }
                                                            ?>
                                                            
                                                        </div><!--end card body StaffTraining-->
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-20" id="SelfAppraisal" role="tabpanel">
                                                    <?php 
                                                        if(isset($_POST['submitSelfAppraisal'])) {
                                                            // print_r($_POST);
                                                            $submit = new DbaseManipulation;
                                                            $row = $submit->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM appraisal_approval_sequence as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                        //   echo"<pre>";
                                                        //     print_r($row);
                                                        //     echo"</pre>";

                                                            $sequence_no = $row['sequence_no'];
                                                            $approver_id = $row['approver_id'];
                                                            $checkRequest = new DbaseManipulation;
                                                            $requestIdNumber = $_POST['request_no'];
                                                            $checkRequest->singleReadFullQry("SELECT TOP 1 id, requestNo FROM appraisal_admin WHERE requestNo = '$requestIdNumber' ORDER BY id DESC");
                                                            if($checkRequest->totalCount != 0) {
                                                                $req = new DbaseManipulation;
                                                                $newReqNo = $req->requestNo("ADM-","appraisal_admin"); 
                                                                //    print_r($newReqNo);
                                                            } else {
                                                                $newReqNo = $_POST['request_no'];    
                                                            }
                                                            $app_id = $rec['id'];
                                                            $ga1 = $_POST['ga1'];
                                                            $ga2 = $_POST['ga2'];
                                                            $ga3 = $_POST['ga3'];
                                                            $ga4 = $_POST['ga4'];
                                                            $ga5 = $_POST['ga5'];
                                                            $ga6 = $_POST['ga6'];
                                                            $ga7 = $_POST['ga7'];
                                                            $ga8 = $_POST['ga8'];
                                                            $ga9 = $_POST['ga9'];
                                                            $total = $_POST['total'];
                                                            // echo "total".$_POST['total'];
                                                            $weakness = $_POST['htextarea_weaknesses'];
                                                            $strengths = $_POST['htextarea_strengths'];
                                                            $sql = "UPDATE appraisal_admin SET requestNo = '$newReqNo', ga1 = $ga1, ga2 = $ga2, ga3 = $ga3, ga4 = $ga4, ga5 = $ga5, ga6 = $ga6, ga7 = $ga7, ga8 = $ga8, ga9 = $ga9, total = $total, weakness = N'$weakness', strengths = N'$strengths' WHERE id = $app_id";
                                                            
                                                            if($helper->executeSQL($sql)) {
                                                                
                                                                $contact_details = new DbaseManipulation;
                                                                $gsm = $contact_details->getContactInfo(1,$staffId,'data');
                                                                $getIdInfo = new DbaseManipulation;
                                                                $email_department = $getIdInfo->fieldNameValue("department",$logged_in_department_id,"name");
                                                                $from_name = 'hrms@nct.edu.om';
                                                                $from = 'HRMS - 3.0';
                                                                $subject = 'NCT-HRMD STAFF APPRAISAL SUBMITTED BY '.strtoupper($logged_name);
                                                                $message = '<html><body>';
                                                                $message .= '<img src="http://apps.nct.edu.om/hrmd2/img/hr-logo-email.png" width="419" height="65" />';
                                                                $message .= "<h3>NCT-HRMS 3.0 STAFF APPRAISAL DETAILS</h3>";
                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Submitted By The Staff</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>CURRENT CYCLE STATUS:</strong> </td><td>For Approval Of Direct Manager</td></tr>";
                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>REQUEST NUMBER:</strong> </td><td>".$newReqNo."</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF ID:</strong> </td><td>".$staffId."</td></tr>";
                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>STAFF NAME:</strong> </td><td>".$logged_name."</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>STAFF DEPARTMENT:</strong> </td><td>".$email_department."</td></tr>";
                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>EMAIL ADDRESS:</strong> </td><td>".$logged_in_email."</td></tr>";
                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>MOBILE NUMBER:</strong> </td><td>".$gsm."</td></tr>";
                                                                $message .= "</table>";
                                                                $message .= "</body></html>";
                                                                $to = array();
                                                                $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $approver_id AND isCurrent = 1 AND status_id = 1");
                                                                $nextApproversStaffId = $nextApprover['staff_id'];
                                                                $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');
                                                                array_push($to,$logged_in_email,$nextApproverEmailAdd);
                                                                $emailParticipants = new sendMail;
                                                                $a=1;
                                                                if($emailParticipants->smtpMailer($to,$from_name,$from,$subject,$message)){
                                                                    //Save Email Information in the system_emails table...
                                                                    $from_name = $from_name;
                                                                    $from = $from;
                                                                    $subject = $subject;
                                                                    $message = $message;
                                                                    $transactionDate = date('Y-m-d H:i:s',time());
                                                                    $to = $to;
                                                                    $recipients = implode(', ', $to);
                                                                    $emailFields = [
                                                                        'requestNo'=>$newReqNo,
                                                                        'moduleName'=>'Admin Staff - Staff Appraisal Submitted',
                                                                        'sentStatus'=>'Sent',
                                                                        'recipients'=>$recipients,
                                                                        'fromName'=>$from_name,
                                                                        'comesFrom'=>$from,
                                                                        'subject'=>$subject,
                                                                        'message'=>$message,
                                                                        'createdBy'=>$staffId,
                                                                        'dateEntered'=>$transactionDate,
                                                                        'dateSent'=>$transactionDate
                                                                    ];
                                                                    $saveEmail = new DbaseManipulation;
                                                                    $saveEmail->insert("system_emails",$emailFields);  
                                                                    ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModal').modal('show');
                                                                            });
                                                                        </script>
                                                                    <?php
                                                                } else {
                                                                    //Save Email Information in the system_emails table...
                                                                    $from_name = $from_name;
                                                                    $from = $from;
                                                                    $subject = $subject;
                                                                    $message = $message;
                                                                    $transactionDate = date('Y-m-d H:i:s',time());
                                                                    $to = $to;
                                                                    $recipients = implode(', ', $to);
                                                                    $emailFields = [
                                                                        'requestNo'=>$newReqNo,
                                                                        'moduleName'=>'Admin Staff - Staff Appraisal Submitted',
                                                                        'sentStatus'=>'Failed',
                                                                        'recipients'=>$recipients,
                                                                        'fromName'=>$from_name,
                                                                        'comesFrom'=>$from,
                                                                        'subject'=>$subject,
                                                                        'message'=>$message,
                                                                        'createdBy'=>$staffId,
                                                                        'dateEntered'=>$transactionDate,
                                                                        'dateSent'=>$transactionDate
                                                                    ];
                                                                    $saveEmail = new DbaseManipulation;
                                                                    $saveEmail->insert("system_emails",$emailFields);  
                                                                    ?>
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#myModal').modal('show');
                                                                            });
                                                                        </script>
                                                                    <?php
                                                                } 
                                                            }
                                                        }
                                                        $rowSelfChk = $helper->singleReadFullQry("SELECT TOP 1 * FROM appraisal_admin WHERE staff_id = '$staffId' AND appraisal_year = '$currentYear' AND total > 1 AND ga1 > 1 AND ga2 > 1 AND ga3 > 1 ORDER BY id DESC");
                                                        if($helper->totalCount != 0) {
                                                            ?>
                                                            <form  novalidate>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5">
                                                                        <h4 class="card-title font-weight-bold">General Attribute [<i>To be filled by the employee تعبأ من قبل الموظف</i>]</h4>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label">Evaluation Elements <span style="font-size:18px">عناصر التقويم</span></label>
                                                                            <label  class="col-sm-2 control-label">Maximum Score الدرجة القصوى</label>
                                                                            <label  class="col-sm-2 control-label">Deserved Score الدرجة المستحقة</label>
                                                                        </div>

                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>The level of quality in performing the job duties and responsibilities
<h3>روح المبادرة والابتكار وتنمية المهارات الوظيفة</h3>
                                                                            </label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga1" class="form-control" value="<?php echo $rowSelfChk['ga1']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Initiative, innovation and career development <h3>اتخاذ القرار وتحمل المسؤولية</h3></label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga2" class="form-control" value="<?php echo $rowSelfChk['ga2']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Taking responsibility and demonstrating good behavior <h3>تحمل المسؤولية وحسن التصرف</h3></label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga3" class="form-control" value="<?php echo $rowSelfChk['ga3']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Teamwork and organizing the tasks that assigned to him/her <h3>العمل الجماعي وتنظيم المهام المسنده إليه</h3></label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga4" class="form-control" value="<?php echo $rowSelfChk['ga4']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Accepting guidance and direction <h3>تقبل التوجيه والإرشاد</h3></label>
                                                                            <label  class="col-sm-2 control-label">10</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga5" class="form-control" value="<?php echo $rowSelfChk['ga5']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Commitment to the work system, schedules, and occupational safety <h3>الإلتزام بنظام العمل ومواعيده والسلامة المهنية</h3></label>
                                                                            <label  class="col-sm-2 control-label">10</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga6" class="form-control" value="<?php echo $rowSelfChk['ga6']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Maintaining work confidentiality <h3>المحافظة على سرية العمل</h3></label>
                                                                            <label  class="col-sm-2 control-label">10</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga7" class="form-control" value="<?php echo $rowSelfChk['ga7']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Dealing with others <h3>التعامل مع الآخرين</h3></label>
                                                                            <label  class="col-sm-2 control-label">5</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga8" class="form-control" value="<?php echo $rowSelfChk['ga8']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Paying attention to the general appearance <h3>الاهتمام بالمظهر العام</h3></label>
                                                                            <label  class="col-sm-2 control-label">5</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga9" class="form-control" value="<?php echo $rowSelfChk['ga9']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label">Total</label>
                                                                            <label  class="col-sm-2 control-label">100</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="total" class="form-control" value="<?php echo $rowSelfChk['total']; ?>" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Self Observation [<i>To be filled by the employee تعبأ من قبل الموظف</i>]</h4></div>
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <h5><span class="text-danger">*</span>Your Weaknesses نقاط الضعف لديك</h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_weaknesses form-control" rows="3" readonly><?php echo $rowSelfChk['weakness']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5><span class="text-danger">*</span>Your Strengths نقاط القوة لديك</h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_strengths form-control" rows="3" readonly><?php echo $rowSelfChk['strengths']; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <form id="adminForm" class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5">
                                                                        <h4 class="card-title font-weight-bold">General Attribute [<i>To be filled by the employee تعبأ من قبل الموظف</i>]</h4>
                                                                    </div>
                                                                    <div class="card-body">

                                                                        <div class="form-group has-warning row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label">Evaluation Elements <span style="font-size:18px">عناصر التقويم</span></label>
                                                                            <label  class="col-sm-2 control-label">Maximum Score الدرجة القصوى</label>
                                                                            <label  class="col-sm-2 control-label">Deserved Score الدرجة المستحقة</label>
                                                                        </div>

                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>The level of quality in performing the job duties and responsibilities <h3> مستوى الجودة في أداء واجبات ومسؤوليات الوظيفة</h3></label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="hidden" name="request_no" value="<?php echo $requestNo; ?>">
                                                                                        <input type="text" name="ga1" class="form-control ga1" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="15" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Initiative, innovation and career development <h3>روح المبادرة والابتكار وتنمية المهارات الوظيفة</h3></label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga2" class="form-control ga2" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="15" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Taking responsibility and demonstrating good behavior <h3>تحمل المسؤولية وحسن التصرف</h3></label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga3" class="form-control ga3" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="15" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Teamwork and organizing the tasks that assigned to him/her <h3>العمل الجماعي وتنظيم المهام المسنده إليه</h3></label>
                                                                            <label  class="col-sm-2 control-label">15</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga4" class="form-control ga4" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="15" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Accepting guidance and direction <h3>تقبل التوجيه والإرشاد</h3></label>
                                                                            <label  class="col-sm-2 control-label">10</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga5" class="form-control ga5" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="10" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Commitment to the work system, schedules, and occupational safety <h3>الإلتزام بنظام العمل ومواعيده والسلامة المهنية</h3></label>
                                                                            <label  class="col-sm-2 control-label">10</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga6" class="form-control ga6" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="10" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Maintaining work confidentiality <h3>المحافظة على سرية العمل</h3></label>
                                                                            <label  class="col-sm-2 control-label">10</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga7" class="form-control ga7" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="10" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Dealing with others <h3>التعامل مع الآخرين</h3></label>
                                                                            <label  class="col-sm-2 control-label">5</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga8" class="form-control ga8" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="5" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label"><span class="text-danger">*</span>Paying attention to the general appearance <h3>الاهتمام بالمظهر العام</h3></label>
                                                                            <label  class="col-sm-2 control-label">5</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="ga9" class="form-control ga9" value="0" onkeypress="return isNumberKey(event)" required data-validation-required-message="This field is required" min="0" max="5" data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-6 control-label">Total</label>
                                                                            <label  class="col-sm-2 control-label">100</label>
                                                                            <div class="col-sm-2">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" name="total" class="form-control total" value="0" onkeypress="return isNumberKey(event)" readonly>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-header bg-light-success p-b-0 p-t-5"><h4 class="card-title">Self Observation [<i>To be filled by the employee تعبأ من قبل الموظف</i>]</h4></div>
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <h5><span class="text-danger">*</span>Your Weaknesses نقاط الضعف لديك</h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_weaknesses form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htextarea_weaknesses" class="htextarea_weaknesses">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <h5><span class="text-danger">*</span>Your Strengths نقاط القوة لديك</h5>
                                                                            <div class="controls">
                                                                                <textarea class="textarea_strengths form-control" rows="3" required data-validation-required-message="This field is required"></textarea>
                                                                                <input type="hidden" name="htextarea_strengths" class="htextarea_strengths">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-xs-right">
                                                                    <button type="submit" name="submitSelfAppraisal" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit Appraisal</button>
                                                                    <button type="reset" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Reset</button>
                                                                </div>
                                                            </form>
                                                            <?php
                                                        }    
                                                            ?> 
                                                </div>

                                                <div class="tab-pane p-20" id="AppraisalResult" role="tabpanel">
                                                <?php
                                                // echo $_GET['id'];
                                                $rec = $checkSubmitted->singleReadFullQry("SELECT TOP 1 * FROM appraisal_admin WHERE staff_id = '$staffId' AND appraisal_year = '$currentYear' ORDER BY id DESC");
                                                if ($checkSubmitted->totalCount != 0) {

                                                    if ($rec['status'] == 'Completed') {
                                                ?>

                                                        <div class="card">
                                                            <div class="card-header bg-light-success p-b-0 p-t-5">
                                                                <h4 class="card-title">Staff Appraisal Result </h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="table-responsiveXXX">
                                                                    <div class="row border-bottom ">
                                                                        <div class="card-header bg-light-success ">
                                                                            <h4 class="card-title"> General Attribute <i> </i></h4>
                                                                        </div>

                                                                        <?php

                                                                        $appraisal_admin_id = $_GET['id'];
                                                                        $sdn = new DbaseManipulation;
                                                                        $rows = $sdn->singleReadFullQry("SELECT * FROM appraisal_admin_general_attribute WHERE appraisal_admin_id =  $appraisal_admin_id"); //1 is fixed for technicians
                                                                        ?>
                                                                        <div class="col-lg-4 col-xs-18">
                                                                            <h3>Total/Remark</h3>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <label>
                                                                                <label>
                                                                                    <h3><span id="grandTotalX"><?php echo $rows['total'] ?></span>  </h3>
                                                                                </label>
                                                                            </label>
                                                                        </div>

                                                                    </div>
                                                                    <!--end row total-->
                                                                    <div class="row border-bottom m-t-5">
                                                                        <?php
                                                                        $appraisal_technician_id = $_GET['id'];
                                                                        $hosObs = new DbaseManipulation;
                                                                        $row = $hosObs->singleReadFullQry("SELECT TOP 1 * FROM appraisal_admin_hod_observation WHERE appraisal_type_description_id = 3 AND appraisal_type_id = $appraisal_technician_id"); //1 is fixed for technicians
                                                                        if ($hosObs->totalCount != 0) {
                                                                            $tobeVisible3 = '';
                                                                        } else {
                                                                            $tobeVisible3 = '[To be filled by the HOS]';
                                                                        }
                                                                        ?>
                                                                        <div class="card-header bg-light-success p-b-0 p-t-5">
                                                                            <h4 class="card-title">Observation of Official <i> </i></h4>
                                                                        </div>
                                                                        <div class="card-body">
                                                                        <form novalidate>
                                                                        <div class="form-group row m-b-5 m-t-0">
                                                                            <label  class="col-sm-3 control-label">The courses and training programs the employee needs that will raise the level of his/her work performance  <h3>الدورات والبرامج التدريبية التي يحتاجها الموظف والتي سترفع من مستوى أداء عمله

                                                            </h3></label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="2" class="form-control" readonly><?php echo $row['observation1']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">                                                                                    
                                                                                                  <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">                                                                
                                                                            <div class="offset-sm-3 col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="2" class="form-control" readonly><?php echo $row['observation2']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">                                                                
                                                                            <div class="offset-sm-3 col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="2" class="form-control" readonly><?php echo $row['observation3']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">                                                                
                                                                            <div class="offset-sm-3 col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="2" class="form-control" readonly><?php echo $row['observation4']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row m-b-5 m-t-0">                                                                   
                                                                            <div class="offset-sm-3 col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea rows="2" class="form-control" readonly><?php echo $row['observation5']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <a class="mytooltip" href="javascript:void(0)"> 
                                                                                                    <i class="fas fa-info-circle"></i>
                                                                                                    <span class="tooltip-content5">
                                                                                                        <span class="tooltip-text3">
                                                                                                            <span class="tooltip-inner2">
                                                                                                            Note:<br />
                                                                                                            This entry will be show to staff <br>
                                                                                                            after the whole process of <br>
                                                                                                            the appraisal. 
                                                                                                            </span>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </a>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>                                                      
                                                                            </form>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                            </div>
                                    <?php
                                                    }
                                                } ?>

                                            </div><!--end tab-content-->                                          
                                        </div><!--end card body main-->
                                    </div><!--end card-->            
                                </div><!--end col-lg-12 col-xs-18-->
                            </div><!--end row-->
                        </div>            
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script>
                    function isNumberKey(evt){
                        var charCode = (evt.which) ? evt.which : event.keyCode;
                        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) return false;
                        return true;
                    }
                </script>
                <script src="assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
                <script src="assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>
                 <script type="text/javascript" src="assets/plugins/multiselect/js/jquery.multi-select.js"></script>
                <script>
                    $(document).ready(function() {
                        $('.textarea_weaknesses').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $('.textarea_strengths').wysihtml5({"image":false, "link":false,  "font-styles":false, "emphasis":false});
                        $("#adminForm").submit(function() {
                           var textarea_weaknesses = $('.textarea_weaknesses').val();
                           var textarea_strengths = $('.textarea_strengths').val();
                           $(".htextarea_weaknesses").val(textarea_weaknesses);
                           $(".htextarea_strengths").val(textarea_strengths);
                        });

                        $('input[name=ga1]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga2]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga3]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga4]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga5]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga6]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga7]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga8]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                        $('input[name=ga9]').change(function() { 
                            var total = parseInt($('.ga1').val()) + parseInt($('.ga2').val()) + parseInt($('.ga3').val()) + parseInt($('.ga4').val()) + parseInt($('.ga5').val()) + parseInt($('.ga6').val()) + parseInt($('.ga7').val()) + parseInt($('.ga8').val()) + parseInt($('.ga9').val());
                            $('.total').val(total);
                        });
                    });

                    $('.dateRange1').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $(".startDate1").val(start.format('YYYY-MM-DD'));
                        $('.endDate1').val(end.format('YYYY-MM-DD'));
                    });
                    $('.dateRange2').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $(".startDate2").val(start.format('YYYY-MM-DD'));
                        $('.endDate2').val(end.format('YYYY-MM-DD'));
                    });
                    $('.dateRange3').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $(".startDate3").val(start.format('YYYY-MM-DD'));
                        $('.endDate3').val(end.format('YYYY-MM-DD'));
                    });
                    $('.dateRange4').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $(".startDate4").val(start.format('YYYY-MM-DD'));
                        $('.endDate4').val(end.format('YYYY-MM-DD'));
                    });
                    $('.dateRange5').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $(".startDate5").val(start.format('YYYY-MM-DD'));
                        $('.endDate5').val(end.format('YYYY-MM-DD'));
                    });
                </script>    
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Staff appraisal information has been submitted successfully!<br><br>Click on Self Appraisal tab to see the information you have submitted.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalStaffTraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Staff Training has been submitted successfully! <br><br>Click on Staff Development Needed tab to see the information you have saved.</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
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