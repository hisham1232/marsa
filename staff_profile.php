<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
            $dropdown = new DbaseManipulation;                                 
            $header_info = new DbaseManipulation;
            if(isset($_GET['id'])) { 
                if($_GET['id'] == $primary_staff_id) {
                    $id = $header_info->cleanString($_GET['id']);
                    $info = $header_info->singleReadFullQry("
                    SELECT s.id, s.staffId, s.civilId, s.ministryStaffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.salutation, s.firstName, s.secondName, s.thirdName, s.lastName, concat(s.firstNameArabic,' ',s.secondNameArabic,' ',s.thirdNameArabic,' ',s.lastNameArabic,' ') as arabicName, s.gender, s.maritalStatus, s.birthdate, s.joinDate, n.name as nationality, s.nationality_id, d.name as department, e.department_id, sc.name as section, e.section_id, j.name as jobtitle, e.jobtitle_id, p.title as staff_position, e.position_id, st.name as status, e.status_id, sp.name as specialization, e.specialization_id, q.name as qualification, e.qualification_id, spo.name as sponsor, e.sponsor_id, slr.name as salarygrade, e.salarygrade_id, e.employmenttype_id 
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
                    WHERE e.isCurrent = 1 AND s.id = $id
                    ");
                    $mobile = $header_info->getContactInfo(1,$info['staffId'],'data');
                    $email_add = $header_info->getContactInfo(2,$info['staffId'],'data');
                    $staff_aydi = $info['staffId'];
                } else {
                    header("Location: not_allowed.php");
                }    
            } else {
                header("Location: not_allowed.php");
            }                                 
?>  
            <body class="fix-header fix-sidebar card-no-border">
                <div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /></svg>
                </div>
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>   
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">Staff Profile</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item active">My Profile</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-xlg-3 col-md-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <center class="m-t-20"> <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$info['staffId'].'.jpg'; ?>" alt="Staff" class="img-circle" height="200px" width="200px" />
                                                <h4 class="card-title m-t-10"><?php echo $info['staffName']; ?></h4>
                                                <h4 class="card-title m-t-10"><?php echo $info['arabicName']; ?></h4>
                                                <h5 class="card-subtitle"><?php echo $info['jobtitle']; ?></h5>
                                                <h5 class="card-subtitle"><?php echo $info['section']; ?></h5>
                                                <h5 class="card-subtitle"><?php echo $info['department']; ?></h5>
                                                <h5 class="card-subtitle"><?php echo $email_add; ?></h5>
                                                <!-- Button trigger modal -->
                                            </center>
                                        </div>
                                        <div><hr></div>
                                        <div class="card-body text-center">
                                            <h6 class="text-muted">Staff ID</h6><h5><?php echo $info['staffId']; ?></h5>
                                            <h6 class="text-muted">GSM</h6><h5><?php echo $mobile; ?></h5>
                                            <h6 class="text-muted">Sponsor</h6><h5><?php echo $info['sponsor']; ?></h5>
                                            <h6 class="text-muted">Join Date</h6><h5><?php echo date('d/m/Y',strtotime($info['joinDate'])); ?></h5>                                
                                            <h6 class="text-muted">Nationality</h6><h5><?php echo $info['nationality']; ?></h5>
                                            <h6 class="text-muted">Gender</h6><h5><?php echo $info['gender']; ?></h5>
                                            <h6 class="text-muted">Marital Status</h6><h5><?php echo $info['maritalStatus']; ?></h5>
                                            <h6 class="text-muted">Date of Birth</h6><h5><?php echo date('d/m/Y',strtotime($info['birthdate'])); ?></h5>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-8 col-xlg-9 col-md-7">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Staff Profile</h4>
                                            <h6 class="card-subtitle">ملف الموظف</h6>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#qualification" role="tab"><span class="hidden-sm-up"><i class="fas fa-graduation-cap"></i></span> <span class="hidden-xs-down">Qualification</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#employment" role="tab"><span class="hidden-sm-up"><i class="ti-briefcase"></i></span> <span class="hidden-xs-down">Employment History</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#work" role="tab"><span class="hidden-sm-up"><i class="fas fa-rocket"></i></span> <span class="hidden-xs-down">Work Experience</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#research" role="tab"><span class="hidden-sm-up"><i class="ti-clipboard"></i></span> <span class="hidden-xs-down">Researches</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#contact" role="tab"><span class="hidden-sm-up"><i class="far fa-address-book"></i></span> <span class="hidden-xs-down">Contacts</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#family" role="tab"><span class="hidden-sm-up"><i class="fas fa-users"></i></span> <span class="hidden-xs-down">Family</span></a> </li>
                                            </ul>
                                            <div class="tab-content tabcontent-border">
                                                <div class="tab-pane active" id="qualification" role="tabpanel">
                                                    <div class="card-body">
                                                        <?php
                                                            $qualification = new DbaseManipulation;
                                                            $rows = $qualification->readData("
                                                            SELECT q.institution, q.graduateYear, q.gpa, q.attachment, d.name as degree, c.name as certificate 
                                                            FROM staffqualification as q 
                                                            LEFT OUTER JOIN degree as d ON d.id = q.degree_id 
                                                            LEFT OUTER JOIN certificate as c ON c.id = q.certificate_id 
                                                            WHERE q.staffId = '$staff_aydi'");
                                                        ?>
                                                        <h4 class="card-title">Educational Background</h4>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                $i = 1;
                                                                if($qualification->totalCount != 0) {
                                                                    foreach($rows as $rowqua){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo $rowqua['degree']." - ".$rowqua['certificate']; ?></h4>
                                                                                <p class="m-b-5"><?php echo strtoupper($rowqua['institution']); ?></p>
                                                                                <div class="comment-footer "> 
                                                                                    <span class="action-icons active">
                                                                                        <a href="javascript:void(0)" title="Year Graduated"><small><i class="ti-calendar"></i></small> <?php echo $rowqua['graduateYear']; ?></a>
                                                                                        <a href="javascript:void(0)" title="GPA"><i class="ti-bar-chart"></i> <?php if($rowqua['gpa'] != '') echo $rowqua['gpa']; else echo "N/A"; ?></a>
                                                                                        <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".masters_modal<?php echo $i; ?>"><i class="ti-files"></i> Attachment</a>
                                                                                        <div class="modal fade masters_modal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title" id="myLargeModalLabel">Qualification Attachment</h4>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="text-align: center;">
                                                                                                            <iframe src="<?php echo $rowqua['attachment']; ?>" width="100%" height="700px"  frameborder="0"></iframe>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                        $i++;
                                                                    }
                                                                } else {
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> Educational Background Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                            
                                                                }    
                                                            ?>
                                                        </div>
                                                        
                                                        <div><hr class="text-primary"></div>
                                                        <?php
                                                            $ec = new DbaseManipulation;
                                                            $rows = $ec->readData("
                                                            SELECT s.certificateNo, s.issuedDate, s.issuedPlace, s.attachment, e.name as extraCertificatesName
                                                            FROM staffextracertificate as s 
                                                            LEFT OUTER JOIN extracertificates as e ON e.id = s.extracertificates_id
                                                            WHERE s.staffId = '$staff_aydi'");
                                                        ?>
                                                        <h4 class="card-title">Extra Certificates</h4>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                $j = 1;
                                                                if($ec->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo $row['extraCertificatesName']; ?></h4>
                                                                                <p class="m-b-5"><?php echo strtoupper($row['certificateNo']); ?></p>
                                                                                <div class="comment-footer "> 
                                                                                    <span class="action-icons active">
                                                                                        <a href="javascript:void(0)" title="Date Issued"><small><i class="ti-calendar"></i></small> <?php echo date('d/m/Y',strtotime($row['issuedDate'])); ?></a>
                                                                                        <a href="javascript:void(0)" title="Place Issued"><i class="ti-location-pin"></i> <?php echo $row['issuedPlace']; ?></a>
                                                                                        <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".masters_modalEC<?php echo $j; ?>"><i class="ti-files"></i> Attachment</a>
                                                                                        <div class="modal fade masters_modalEC<?php echo $j; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title" id="myLargeModalLabel">Qualification Attachment</h4>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="text-align: center;">
                                                                                                            <iframe src="<?php echo $row['attachment']; ?>" width="100%" height="700px"  frameborder="0"></iframe>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                        $j++;
                                                                    }
                                                                } else {
                                                            ?>        
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> Extra Certificates Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane" id="employment" role="tabpanel">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Employment History(NCT)</h4>
                                                        <?php
                                                            $emp = new DbaseManipulation;
                                                            $rows = $emp->readData("SELECT e.staff_id, e.joinDate, e.isCurrent, j.name as jobtitle, d.name as department, s.name as section, p.title as position, sp.name as sponsor
                                                            FROM employmentdetail as e 
                                                            LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
                                                            LEFT OUTER JOIN department as d ON d.id = e.department_id 
                                                            LEFT OUTER JOIN section as s ON s.id = e.section_id 
                                                            LEFT OUTER JOIN staff_position as p ON p.id = e.position_id 
                                                            LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id 
                                                            WHERE e.staff_id = '$staff_aydi' ORDER BY e.id DESC");
                                                        ?>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                $l = 1;
                                                                if($emp->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo $row['jobtitle']; ?></h4>
                                                                                <p class="m-b-5"><?php echo $row['department']; ?> - <?php echo $row['section']; ?></p>
                                                                                <p class="m-b-5"><?php echo $row['position']; ?></p>

                                                                                <div class="comment-footer "> 
                                                                                    <span class="action-icons active">
                                                                                        <a href="javascript:void(0)" title="Employment Status Date"><small><i class="ti-calendar"></i></small> <?php echo date('d/m/Y',strtotime($row['joinDate'])); ?></a>
                                                                                        <a href="javascript:void(0)" title="Sponsor"><i class="ti-anchor"></i> <?php echo $row['sponsor']; ?></a>
                                                                                        <?php
                                                                                            if($row['isCurrent'] == 1) {
                                                                                        ?>
                                                                                                <span class="label label-light-success">Active Job <i class=" ti-check-box"></i></span>
                                                                                        <?php
                                                                                            }
                                                                                        ?>        
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                    }
                                                                } else {    
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> NCT Employment History Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                }
                                                            ?>            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane" id="work" role="tabpanel">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Work Experience</h4>
                                                        <?php
                                                            $xp = new DbaseManipulation;
                                                            $rows = $xp->readData("
                                                            SELECT we.designation, we.organizationName, we.organizationType, we.startDate, we.endDate, we.attachment
                                                            FROM staffworkexperience as we 
                                                            WHERE we.staffId = '$staff_aydi'");
                                                        ?>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                $l = 1;
                                                                if($xp->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo strtoupper($row['designation']); ?></h4>
                                                                                <p class="m-b-5"><?php echo strtoupper($row['organizationName']); ?></p>
                                                                                <div class="comment-footer"> 
                                                                                    <span class="action-icons active">
                                                                                        <a href="javascript:void(0)" title="Employment Date Covered"><small><i class="ti-calendar"></i></small> <?php echo date('d/m/Y',strtotime($row['startDate']))." to ".date('d/m/Y',strtotime($row['endDate'])); ?></a>
                                                                                        <a href="javascript:void(0)" title="Organization Type"><i class="ti-blackboard"></i> <?php echo $row['organizationType']; ?></a>
                                                                                        <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".masters_modalWE<?php echo $l; ?>"><i class="ti-files"></i> Attachment</a>
                                                                                        <div class="modal fade masters_modalWE<?php echo $l; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title" id="myLargeModalLabel">Qualification Attachment</h4>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="text-align: center;">
                                                                                                            <iframe src="<?php echo $row['attachment']; ?>" width="100%" height="700px"  frameborder="0"></iframe>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                        $l++;
                                                                    }
                                                                } else {
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> Work Experience Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    
                                                        <div><hr class="text-primary"></div>
                                                        <h4 class="card-title">Training / Seminar / Conference Attended</h4>
                                                        <?php
                                                            $training = new DbaseManipulation;
                                                            $rows = $training->readData("
                                                            SELECT s.title, s.startDate, s.endDate, s.isSponsoredByCollege, s.inCollege, s.attachment, t.name as trainingtype
                                                            FROM stafftraining as s 
                                                            LEFT OUTER JOIN trainingtype as t ON t.id = s.trainingtype_id
                                                            WHERE s.staffId = '$staff_aydi'");
                                                        ?>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                $m = 1;
                                                                if($training->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo strtoupper($row['title']); ?></h4>
                                                                                <p class="m-b-5"><?php echo strtoupper($row['trainingtype']); ?></p>
                                                                                <div class="comment-footer "> 
                                                                                    <span class="action-icons active">
                                                                                        <a href="javascript:void(0)" title="Date"><small><i class="ti-calendar"></i></small> <?php echo date('d/m/Y',strtotime($row['startDate']))." to ".date('d/m/Y',strtotime($row['endDate'])); ?></a> 
                                                                                        <a href="javascript:void(0)" title="Sponsor by College"><i class="ti-wallet"></i> <?php echo $row['isSponsoredByCollege'] ? "Sponsor by College" : "Not Sponsor by College"; ?> </a>
                                                                                        <a href="javascript:void(0)" title="Place Issue"><i class="ti-location-pin"></i> <?php echo $row['inCollege'] ? "Inside College" : "Outside College"; ?></a>
                                                                                        <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".masters_modalST<?php echo $m; ?>"><i class="ti-files"></i> Attachment</a>
                                                                                        <div class="modal fade masters_modalST<?php echo $m; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title" id="myLargeModalLabel">Seminars/Training Attachment</h4>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="text-align: center;">
                                                                                                            <iframe src="<?php echo $row['attachment']; ?>" width="100%" height="700px"  frameborder="0"></iframe>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                        $m++;
                                                                    }
                                                                } else {
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> Training / Seminar / Conference Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane" id="research" role="tabpanel">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Research and Projects</h4>
                                                        <?php
                                                            $o = 1;
                                                            $research = new DbaseManipulation;
                                                            $rows = $research->readData("SELECT * FROM staffresearch WHERE staffId = '$staff_aydi'");
                                                        ?>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                if($research->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo strtoupper($row['title']); ?></h4>
                                                                                <p class="m-b-5"><?php echo $row['category']; ?></p>
                                                                                <p class="m-b-5"><?php if(strlen($row['subject']) < 1) echo "<span class='text-warning'>Subject not found!</span>"; else echo $row['subject']; ?></p>
                                                                                <p class="m-b-5"><?php if(strlen($row['organization']) < 1) echo "<span class='text-warning'>Organization not found!</span>"; else echo $row['organization']; ?></p>
                                                                                <div class="comment-footer "> 
                                                                                    <span class="action-icons active">
                                                                                        <a href="javascript:void(0)" title="Date"><small><i class="ti-calendar"></i></small> <?php echo date('d/m/Y',strtotime($row['startDate']))." to ".date('d/m/Y',strtotime($row['endDate'])); ?></a>
                                                                                        <a href="javascript:void(0)" title="Place of Research"><i class="ti-location-pin"></i> <?php echo $row['location']; ?></a>
                                                                                        <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".research_modal<?php echo $o; ?>"><i class="ti-files"></i> Attachment</a>

                                                                                        <div class="modal fade research_modal<?php echo $o; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title" id="myLargeModalLabel">Research Attachment</h4>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="text-align: center;">
                                                                                                            <iframe src="<?php echo $row['attachment']; ?>" width="100%" height="700"  frameborder="0"></iframe>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                        $o++;
                                                                    }
                                                                } else {    
                                                            ?>   
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> Research and Projects Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>       
                                                            <?php
                                                                }
                                                            ?>  
                                                        </div>
                                                    
                                                        <div><hr class="text-primary"></div>
                                                        <h4 class="card-title">Published Papers</h4>
                                                        <?php
                                                            $n = 1;
                                                            $publish = new DbaseManipulation;
                                                            $rows = $publish->readData("SELECT * FROM staffpublication WHERE staffId = '$staff_aydi'");
                                                        ?>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                if($publish->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo strtoupper($row['title']); ?></h4>
                                                                                <p class="m-b-5"><?php echo $row['category']; ?></p>
                                                                                <p class="m-b-5"><?php if(strlen($row['name']) < 1) echo "<span class='text-warning'>Name not found!</span>"; else echo $row['name']; ?></p>
                                                                                <p class="m-b-5"><?php if(strlen($row['coAuthors']) < 1) echo "<span class='text-warning'>Co-Authors not found!</span>"; else echo $row['coAuthors']; ?></p>
                                                                                <div class="comment-footer "> 
                                                                                    <span class="action-icons active">
                                                                                        <a href="javascript:void(0)" title="Publication Date"><small><i class="ti-calendar"></i></small> <?php echo date('d/m/Y',strtotime($row['publishDate'])); ?></a> 
                                                                                        <a href="javascript:void(0)" title="Publication Place"><i class="ti-location-pin"></i> <?php echo $row['place']; ?></a>
                                                                                        <a href="javascript:void(0)" title="Click to view Attachment"  data-toggle="modal" data-target=".papers_modal<?php echo $n; ?>"><i class="ti-files"></i> Attachment</a>

                                                                                        <div class="modal fade papers_modal<?php echo $n; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title" id="myLargeModalLabel">Published Papers Attachment</h4>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="text-align: center">
                                                                                                            <iframe src="<?php echo $row['attachment']; ?>" width="100%" height="700"  frameborder="0"></iframe>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-info waves-effect text-left" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                        $n++;
                                                                    }
                                                                } else {   
                                                            ?>          
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> Published Paper Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                }
                                                            ?>          
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane" id="contact" role="tabpanel">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Contact Information</h4>
                                                        <?php
                                                            $contact = new DbaseManipulation;
                                                            $rows = $contact->readData("SELECT * FROM contactdetails WHERE staff_id = '$staff_aydi'");
                                                        ?>
                                                        <div class="comment-widgets">
                                                            <?php
                                                                if($contact->totalCount != 0) {
                                                                    
                                                            ?>
                                                                    <div class="d-flex flex-row comment-row">
                                                                        <div class="comment-text active w-100">
                                                                            <h4 class="text-primary"><?php echo $info['staffName']; ?></h4>
                                                                            <div class="comment-footer "> 
                                                                                <span class="action-icons active">
                                                                                <?php
                                                                                    foreach($rows as $row){
                                                                                        if($row['contacttype_id'] == 2 || $row['contacttype_id'] == 3){ //Emails
                                                                                ?>            
                                                                                            <a href="javascript:void(0)" title="E-Mail"><i class="ti-email"></i> <?php echo $row['data']; ?></a><br/>
                                                                                <?php            
                                                                                        } else if ($row['contacttype_id'] == 1){ //Mobile  
                                                                                ?>            
                                                                                            <a href="javascript:void(0)" title="Contact Number"><i class="ti-mobile"></i> <?php echo $row['data']; ?></a><br/>
                                                                                <?php
                                                                                        }    
                                                                                    }
                                                                                ?>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                } else {   
                                                            ?>          
                                                                    <div class="d-flex flex-row comment-row">
                                                                        <div class="comment-text active w-100">
                                                                            <h4 class="text-danger"><i class="ti-info-alt"></i> Contact Information Not Found!</h4>
                                                                            <p class="m-b-5"></p>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                            ?>  
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane" id="family" role="tabpanel">
                                                    <div class="card-body">
                                                        <h4 class="card-title">Family Information</h4>
                                                        <?php
                                                            $family = new DbaseManipulation;
                                                            $rows = $family->readData("SELECT * FROM stafffamily WHERE staffId = '$staff_aydi'");
                                                        ?>
                                                            <div class="comment-widgets">
                                                            <?php
                                                                if($family->totalCount != 0) {
                                                                    foreach($rows as $row){
                                                            ?>
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-primary"><?php echo $row['name']; ?></h4>
                                                                                <h4 class="text-primary"><?php if(strlen($row['arabicName']) < 1) echo "<span class='text-warning'>Arabic name not encoded!</span>"; else echo $row['arabicName']; ?></h4>
                                                                                <div class="comment-footer "> 
                                                                                    <span class="action-icons active">
                                                                                    <a href="javascript:void(0)" title="Relationship"><i class="ti-user"></i> <?php echo $row['relationship']; ?></a>
                                                                                    <a href="javascript:void(0)" title="Civil ID"><i class="fas fa-address-card"></i> <?php if(strlen($row['civilId']) < 1) echo "Civil Id not found!"; else echo $row['civilId']; ?></a>
                                                                                    <a href="javascript:void(0)" title="Birthdate"><i class="ti-calendar"></i> <?php echo date('d/m/Y',strtotime($row['birthdate'])); ?></a>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                    }
                                                                }  else {  
                                                            ?>           
                                                                        <div class="d-flex flex-row comment-row">
                                                                            <div class="comment-text active w-100">
                                                                                <h4 class="text-danger"><i class="ti-info-alt"></i> Family Information Not Found!</h4>
                                                                                <p class="m-b-5"></p>
                                                                            </div>
                                                                        </div>
                                                            <?php
                                                                }
                                                            ?>    
                                                            </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end row-->
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