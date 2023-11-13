<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $gid = $_GET['id'];
        $check = new DbaseManipulation;
        $info = $check->singleReadFullQry("SELECT COUNT(id) as bilang FROM grievance WHERE id = $gid");
        $cateGoryaId = $helper->fieldNameValue('grievance',$gid,'category_id');
        $bilang = $info['bilang'];
        if($bilang > 0)
            $allowed = true;
            //$allowed = (($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) || $staffId == '119084' || $staffId == '121101' || $staffId == '189010') ? true : false;
        else
            $allowed =  false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
?>
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Grievance recommendation has been submitted successfully!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModalAgree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Grievance has been solved and has been submitted successfully!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModalNotAgree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Grievance has been escalated to the next higher authority and has been submitted successfully!</h5>
                                <a href="" class="btn btn-primary"><i class='fa fa-check'></i> OK</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Grievance Application Details</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Staff Grievance</li>
                                        <li class="breadcrumb-item">Grievance Details</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card "><!-- card-outline-success-->
                                         <div class="card-header bg-light-warning3 p-t-5 p-b-0 m-t-0 m-b-0">
                                            <div class="row">
                                               <div class="col-12">
                                                    <div class="d-flex flex-wrap">
                                                        <div><h3 class="card-title">Staff Grievance Form</h3></div>
                                                        <div class="ml-auto">
                                                            <ul class="list-inline">
                                                                <li><h6>Grievance ID [<span class="font-weight-bold"><?php echo $_GET['id']; ?></span>] </h6></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end row-->
                                        </div><!--end card-header-->
                                        <div class="card-body bg-light-warning2">
                                            <div class="row">
                                                <?php
                                                    $infoComplainant = $check->singleReadFullQry("SELECT complainant FROM grievance WHERE id = $gid");
                                                    $complainantId = $infoComplainant['complainant'];
                                                    $staffComplainantId = $complainantId;
                                                    $basic_info = new DBaseManipulation;
                                                    $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$complainantId'");
                                                ?>
                                                <div class="col-lg-6"><!---start about Details of Staff Giving Complaint div-->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Details of Staff Giving Complaint</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="form-horizontal">
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Staff ID Name</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['staffId'].' - '.trim($info['staffName']); ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Department</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['department']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-briefcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Section</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['section']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-suitcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Job Title</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['jobtitle']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-credit-card"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                            
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Sponsor</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['sponsor']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-tags"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                    <?php
                                                                        $contact_details = new DbaseManipulation;
                                                                        $email = $contact_details->getContactInfo(2,$complainantId,'data');
                                                                        $gsm = $contact_details->getContactInfo(1,$complainantId,'data');
                                                                    ?>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">GSM</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $gsm; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-phone"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Email</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $email; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-envelope-open"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!---------------------------------------------------------------------------------------------------------->
                                                <!---------------------------------------------------------------------------------------------------------->

                                                <?php
                                                    $infoResponder = $check->singleReadFullQry("SELECT responder FROM grievance WHERE id = $gid");
                                                    $responderId = $infoResponder['responder'];
                                                    $basic_info = new DBaseManipulation;
                                                    $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id, e.sponsor_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$responderId'");
                                                ?>
                                                <div class="col-lg-6"><!---start about Details of Staff Giving Complaint div-->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Complaint Given Against</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <div class="form-horizontal">
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Staff ID Name</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['staffId'].' - '.trim($info['staffName']); ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-user"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Department</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['department']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-briefcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Section</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['section']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-suitcase"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Job Title</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['jobtitle']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="far fa-credit-card"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                            
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Sponsor</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $info['sponsor']; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-tags"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                    <?php
                                                                        $contact_details = new DbaseManipulation;
                                                                        $email = $contact_details->getContactInfo(2,$responderId,'data');
                                                                        $gsm = $contact_details->getContactInfo(1,$responderId,'data');
                                                                    ?>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">GSM</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $gsm; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-phone"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-3 control-label">Email</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="controls">
                                                                            <div class="input-group">
                                                                                <input type="text" name="" class="form-control" readonly value="<?php echo $email; ?>"> 
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                        <i class="fas fa-envelope-open"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end row for whole about form-->

                                            <div class="row">
                                                <div class="col-lg-12"><!---start about Details of Staff Giving Complaint div-->
                                                    <?php 
                                                        $details = new DbaseManipulation;
                                                        $detail = $details->singleReadFullQry("SELECT * FROM grievance WHERE id = $gid");
                                                        switch($detail['complaint_type']){
                                                            case 1:
                                                                $complaint_type = 'Academic';
                                                            break;
                                                            case 2:
                                                                $complaint_type = 'Administrative';
                                                            break;
                                                            case 3:
                                                                $complaint_type = 'Personal';
                                                            break;
                                                            case 4:
                                                                $complaint_type = 'Others';
                                                            break;
                                                            default:
                                                                $complaint_type = '';
                                                            break;
                                                        }
                                                    ?>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-wrap">
                                                                <div>
                                                                    <h3 class="card-title">Details of Complaint</h3>
                                                                    <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                </div>
                                                            </div>
                                                            <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-2 control-label">Date/Time</label>
                                                                    <div class="col-sm-4">
                                                                        <div class="controls">
                                                                            <input type="text" name="" class="form-control text-form-data-blue" readonly value="<?php echo date('M d, Y h:i:s A',strtotime($detail['date_filed'])); ?>"> 
                                                                        </div>
                                                                    </div>

                                                                    <label  class="col-sm-2 control-label">Academic Year & Semester</label>
                                                                    <div class="col-sm-4">
                                                                        <div class="controls">
                                                                            <input type="text" name="" class="form-control text-form-data-blue" readonly /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-2 control-label">Nature of the complaint</label>
                                                                    <div class="col-sm-4">
                                                                        <div class="controls">
                                                                            <input type="text" name="" class="form-control text-form-data-blue" readonly value="<?php echo $complaint_type; ?>"> 
                                                                        </div>
                                                                    </div>

                                                                    <label  class="col-sm-2 control-label">Status</label>
                                                                    <div class="col-sm-4">
                                                                        <div class="controls">
                                                                            <input type="text" name="" class="form-control text-form-data-blue" readonly value="<?php echo $detail['status']; ?>">              
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row m-b-5 m-t-0">
                                                                    <label  class="col-sm-2 control-label">Grievance Statement</label>
                                                                    <div class="col-sm-10">
                                                                        <div class="controls">
                                                                                <textarea name="textarea" rows="4" id="textarea" class="form-control text-form-data-blue" readonly><?php echo $detail['statement'] ?></textarea>
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
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-t-0 m-b-0">
                                        <div class="card-header bg-light-warning3 p-t-5 p-b-0 m-t-0 m-b-0">
                                            <div class="row">
                                               <div class="col-12">
                                                    <div class="d-flex flex-wrap">
                                                        <div><h3 class="card-title">Staff Grievance Process History</h3></div>
                                                        <div class="ml-auto">
                                                            <ul class="list-inline">
                                                                <li><h6>Grievance ID [<span class="font-weight-bold"><?php echo $gid; ?></span>] </h6></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body bg-light-warning2">
                                            <?php 
                                                $histories = new DbaseManipulation;
                                                $sql = "SELECT h.*, j.name as jobtitle, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as contributor FROM grievance_history as h
                                                    LEFT OUTER JOIN employmentdetail as e ON h.staffId = e.staff_id
                                                    LEFT OUTER JOIN staff as s ON h.staffId = s.staffId
                                                    LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id 
                                                    WHERE h.grievance_id = $gid AND e.isCurrent = 1 ORDER BY h.id";
                                                    //echo $sql;
                                                $rows = $histories->readData($sql);
                                            ?>
                                            <div class="ribbon-wrapper card">
                                                <div class="ribbon ribbon-corner ribbon-info"></div>
                                                <?php 
                                                    foreach($rows as $row) {
                                                        if($row['meeting_date'] == '') {
                                                            $meetingDeyt =  '-';
                                                        } else {
                                                            $meetingDeyt = date('M d, Y',strtotime($row['meeting_date']));
                                                        }
                                                        ?>
                                                        <div class="card-body bg-light p-l-0 p-r-0">
                                                            <div class="profiletimeline">
                                                                <div class="sl-item">
                                                                    <div class="sl-left"> <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$row['staffId'].'.jpg'; ?>" alt="Staff" class="img-circle"> </div>
                                                                    <div class="sl-right m-b-0">
                                                                        <div>
                                                                            <p class="m-b-0 font-weight-bold text-primary"><?php echo $row['jobtitle'] ?> - <?php echo $row['contributor']; ?></p>
                                                                            <p class="m-b-0">Enter Date: <span class="font-weight-bold text-warning"><?php echo date('M d, Y h:i:s A',strtotime($row['dateEntered'])); ?></span></a> 
                                                                                &ensp;&ensp;&ensp;&ensp;&ensp;  Meeting Date: <span class="font-weight-bold text-warning"><?php echo $meetingDeyt; ?></span> &ensp;&ensp;&ensp;&ensp;&ensp;  Decision: <span class="font-weight-bold text-warning"><?php echo $row['decision']; ?></span></p>
                                                                            <br/>
                                                                            <p class="m-b-0 text-justify">
                                                                                <?php echo $row['statement']; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                    }
                                                ?>        
                                            </div>

                                            <div class="ribbon-wrapper card">
                                                <div class="ribbon ribbon-corner ribbon-info"></div>

                                                <!-------THIS FORM IS VISIBLE ONLY TO THE COMPLAINANT-------->
                                                <?php
                                                    $checkGrievance = new DbaseManipulation;
                                                    $g = $checkGrievance->singleReadFullQry("SELECT status FROM grievance WHERE id = $gid");

                                                    if(($staffId == $complainantId) && $g['status'] == 'OPEN') {
                                                        ?>
                                                        <?php 
                                                            if(isset($_POST['submitTwo'])) {                                                                
                                                                $fields = [
                                                                    'grievance_id'=>$gid,
                                                                    'staffId'=>$staffId,
                                                                    'statement'=>$_POST['statementTwo'],
                                                                    'decision'=>$_POST['decision'],
                                                                    'dateEntered'=>date('Y-m-d H:i:s',time())
                                                                ];                                                                
                                                                $save = new DbaseManipulation;
                                                                if($save->insert("grievance_history",$fields)){
                                                                    if($_POST['decision'] == 'Agree') {
                                                                        $update = new DbaseManipulation;
                                                                        $update->executeSQL("UPDATE grievance SET status = 'CLOSED' WHERE id = $gid");

                                                                        $getIdInfo = new DbaseManipulation;
                                                                        $history = $getIdInfo->readData("SELECT * FROM grievance_history WHERE grievance_id = $gid ORDER BY id DESC");
                                                                        $respondentInfo = new DbaseManipulation;
                                                                        $respondentName = $respondentInfo->getStaffName($responderId,'firstName','secondName','thirdName','lastName');
                                                                        $respondentEmail = $helper->getContactInfo(2,$responderId,'data');
                                                                        $respondentgsm = $helper->getContactInfo(1,$responderId,'data');
                                                                        $respondentDepartmentId = $helper->employmentIDs($responderId,'department_id');
                                                                        $respondentDepartment = $helper->fieldNameValue("department",$respondentDepartmentId,"name");

                                                                        $from_name = 'hrms@nct.edu.om';
                                                                        $from = 'HRMS - 3.0';
                                                                        $subject = 'NCT-HRMD GRIEVANCE SOLVED HAS BEEN FILED BY '.strtoupper($logged_name);
                                                                        $message = '<html><body>';
                                                                        $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                        $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE DETAILS</h3>";
                                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Open</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>REQUEST ID:</strong> </td><td>".$gid."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('M d, Y h:i:s A',strtotime($detail['date_filed']))."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT STAFF ID:</strong> </td><td>".$responderId."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT NAME:</strong> </td><td>".$respondentName."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT DEPARTMENT:</strong> </td><td>".$respondentDepartment."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT ADDRESS:</strong> </td><td>".$respondentEmail."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT NUMBER:</strong> </td><td>".$respondentgsm."</td></tr>";
                                                                        $message .= "</table>";
                                                                        $message .= "<hr/>";
                                                                        $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE HISTORIES</h3>";
                                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                        $message .= "<tr style='background:#F8E0E0'>";
                                                                            $message .= "<th><strong>STAFF NAME</strong></th>";
                                                                            $message .= "<th><strong>NOTES/COMMENTS</strong></th>";
                                                                            $message .= "<th><strong>STATUS</strong></th>";
                                                                            $message .= "<th><strong>DATE/TIME</strong></th>";
                                                                        $message .= "</tr>";
                                                                        $ctr = 1; $stripeColor = "";    
                                                                        foreach($history as $row){
                                                                            if($ctr % 2 == 0) {
                                                                                $stripeColor = '#FBEFEF';
                                                                            } else {
                                                                                $stripeColor = '#FBF2EF';
                                                                            }
                                                                            $fullStaffNameEmail = $getIdInfo->getStaffName($row['staffId'],'firstName','secondName','thirdName','lastName');
                                                                            $dateNotesEmail = date('d/m/Y H:i:s',strtotime($row['dateEntered']));
                                                                            $notesEmail = $row['statement'];
                                                                            $statusEmail = $row['decision'];
                                                                            $message .= "
                                                                                <tr style='background:$stripeColor'>
                                                                                    <td style='width:200px'>".$fullStaffNameEmail."</td>
                                                                                    <td style='width:200px'>".$notesEmail."</td>
                                                                                    <td style='width:200px'>".$statusEmail."</td>
                                                                                    <td style='width:200px'>".$dateNotesEmail."</td>
                                                                                </tr>
                                                                            ";
                                                                            $ctr++;
                                                                        }
                                                                        $message .= "</table>";
                                                                        $message .= "<br/>";
                                                                        $message .= "</body></html>";
                                                                        $to = array();

                                                                        $nextApp = new DbaseManipulation;
                                                                        $row = $nextApp->singleReadFullQry("SELECT TOP 1 a.*, sp.title FROM grievance_workflow as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId ORDER BY a.sequence_no");
                                                                        $current_approver_id = $row['approver_id'];
                                                                        
                                                                        $nextApprover = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $current_approver_id AND isCurrent = 1 AND status_id = 1");
                                                                        $nextApproversStaffId = $nextApprover['staff_id'];
                                                                        $nextApproverEmailAdd = $getIdInfo->getContactInfo(2,$nextApproversStaffId,'data');

                                                                        $responderEmail = $contact_details->getContactInfo(2,$responderId,'data');
                                                                        array_push($to,$logged_in_email,$responderEmail,$nextApproverEmailAdd);
                                                                        $emailParticipants = new sendMail;
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
                                                                                'requestNo'=>$gid,
                                                                                'moduleName'=>'Grievance Application Agreed',
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
                                                                                        $('#myModalAgree').modal('show');
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
                                                                                'requestNo'=>$gid,
                                                                                'moduleName'=>'Grievance Application Agreed',
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
                                                                                        $('#myModalAgree').modal('show');
                                                                                    });
                                                                                </script>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        $seqCurrent = $helper->fieldNameValue('grievance',$gid,'current_sequence_no');
                                                                        $catId = $helper->fieldNameValue('grievance',$gid,'category_id');

                                                                        $nextApp = new DbaseManipulation;
                                                                        $sequel = "SELECT TOP 1 a.*, sp.title FROM grievance_workflow as a LEFT OUTER JOIN staff_position as sp ON sp.id = a.approver_id WHERE a.active = 1 AND a.position_id = $myPositionId AND a.sequence_no = $seqCurrent AND a.category_id = $catId ORDER BY a.sequence_no";
                                                                        //echo $sequel; exit;
                                                                        $row = $nextApp->singleReadFullQry($sequel);
                                                                        
                                                                        $current_approver_id = $row['approver_id'];
                                                                        $next_sequence_no = $row['sequence_no'] + 1;
                                                                        $category_id = $row['category_id'];
                                                                        $is_final = $row['is_final'];

                                                                        $oldApprover = $helper->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $current_approver_id AND isCurrent = 1 AND status_id = 1");
                                                                        $OldApproversStaffId = $oldApprover['staff_id'];
                                                                        $OldApproverEmailAdd = $helper->getContactInfo(2,$OldApproversStaffId,'data');

                                                                        if($is_final != 1) {
                                                                            $sql = "SELECT * FROM grievance_workflow WHERE position_id = $myPositionId AND sequence_no = $next_sequence_no AND category_id = $category_id";
                                                                            $getNewApprover = new DbaseManipulation;
                                                                            $newApproverRow = $getNewApprover->singleReadFullQry($sql);
                                                                            $newApproverPositionId = $newApproverRow['approver_id'];
                                                                            $newSequenceNo = $newApproverRow['sequence_no'];

                                                                            $update = new DbaseManipulation;
                                                                            $update->executeSQL("UPDATE grievance SET current_sequence_no = $newSequenceNo, current_approver_id = $newApproverPositionId WHERE id = $gid");
                                                                        }

                                                                        $getIdInfo = new DbaseManipulation;
                                                                        $history = $getIdInfo->readData("SELECT * FROM grievance_history WHERE grievance_id = $gid ORDER BY id DESC");
                                                                        $respondentInfo = new DbaseManipulation;
                                                                        $respondentName = $respondentInfo->getStaffName($responderId,'firstName','secondName','thirdName','lastName');
                                                                        $respondentEmail = $helper->getContactInfo(2,$responderId,'data');
                                                                        $respondentgsm = $helper->getContactInfo(1,$responderId,'data');
                                                                        $respondentDepartmentId = $helper->employmentIDs($responderId,'department_id');
                                                                        $respondentDepartment = $helper->fieldNameValue("department",$respondentDepartmentId,"name");

                                                                        $from_name = 'hrms@nct.edu.om';
                                                                        $from = 'HRMS - 3.0';
                                                                        $subject = 'NCT-HRMD GRIEVANCE UNRESOLVED HAS BEEN FILED BY '.strtoupper($logged_name);
                                                                        $message = '<html><body>';
                                                                        $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                        $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE DETAILS</h3>";
                                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                        $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Open</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>REQUEST ID:</strong> </td><td>".$gid."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('M d, Y h:i:s A',strtotime($detail['date_filed']))."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT STAFF ID:</strong> </td><td>".$responderId."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT NAME:</strong> </td><td>".$respondentName."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT DEPARTMENT:</strong> </td><td>".$respondentDepartment."</td></tr>";
                                                                        $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT ADDRESS:</strong> </td><td>".$respondentEmail."</td></tr>";
                                                                        $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT NUMBER:</strong> </td><td>".$respondentgsm."</td></tr>";
                                                                        $message .= "</table>";
                                                                        $message .= "<hr/>";
                                                                        $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE HISTORIES</h3>";
                                                                        $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                        $message .= "<tr style='background:#F8E0E0'>";
                                                                            $message .= "<th><strong>STAFF NAME</strong></th>";
                                                                            $message .= "<th><strong>NOTES/COMMENTS</strong></th>";
                                                                            $message .= "<th><strong>STATUS</strong></th>";
                                                                            $message .= "<th><strong>DATE/TIME</strong></th>";
                                                                        $message .= "</tr>";
                                                                        $ctr = 1; $stripeColor = "";    
                                                                        foreach($history as $row){
                                                                            if($ctr % 2 == 0) {
                                                                                $stripeColor = '#FBEFEF';
                                                                            } else {
                                                                                $stripeColor = '#FBF2EF';
                                                                            }
                                                                            $fullStaffNameEmail = $getIdInfo->getStaffName($row['staffId'],'firstName','secondName','thirdName','lastName');
                                                                            $dateNotesEmail = date('d/m/Y H:i:s',strtotime($row['dateEntered']));
                                                                            $notesEmail = $row['statement'];
                                                                            $statusEmail = $row['decision'];
                                                                            $message .= "
                                                                                <tr style='background:$stripeColor'>
                                                                                    <td style='width:200px'>".$fullStaffNameEmail."</td>
                                                                                    <td style='width:200px'>".$notesEmail."</td>
                                                                                    <td style='width:200px'>".$statusEmail."</td>
                                                                                    <td style='width:200px'>".$dateNotesEmail."</td>
                                                                                </tr>
                                                                            ";
                                                                            $ctr++;
                                                                        }
                                                                        $message .= "</table>";
                                                                        $message .= "<br/>";
                                                                        $message .= "</body></html>";
                                                                        $to = array();

                                                                                                                                                
                                                                        if($is_final == 0) {
                                                                            $nextApprover2 = $getIdInfo->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $newApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                                                            $nextApproversStaffId2 = $nextApprover2['staff_id'];
                                                                            $nextApproverEmailAdd2 = $getIdInfo->getContactInfo(2,$nextApproversStaffId2,'data');
                                                                            $responderEmail = $contact_details->getContactInfo(2,$responderId,'data');
                                                                            array_push($to,$logged_in_email,$responderEmail,$nextApproverEmailAdd2,$OldApproverEmailAdd);
                                                                        } else {
                                                                            array_push($to,$logged_in_email,$responderEmail,$OldApproverEmailAdd);
                                                                        }
                                                                    
                                                                        $emailParticipants = new sendMail;
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
                                                                                'requestNo'=>$gid,
                                                                                'moduleName'=>'Grievance Application Not-Agree',
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
                                                                                        $('#myModalNotAgree').modal('show');
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
                                                                                'requestNo'=>$gid,
                                                                                'moduleName'=>'Grievance Application Not-Agree',
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
                                                                                        $('#myModalNotAgree').modal('show');
                                                                                    });
                                                                                </script>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }    
                                                        ?>                
                                                            <div class="card-body bg-light p-r-5 p-l-5">
                                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <label  class="col-sm-1 control-label">Staff Name</label>
                                                                        <div class="col-sm-5">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" readonly value="<?php echo $logged_name ?>"> 
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="fas fa-user"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <label  class="col-sm-2 control-label">Job Title</label>
                                                                        <div class="col-sm-4">
                                                                            <div class="controls">
                                                                                    <div class="input-group">
                                                                                    <input type="text" class="form-control" readonly value="<?php echo $info['jobtitle'] ?>"> 
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="far fa-credit-card"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <label  class="col-sm-1 control-label">Decision</label>
                                                                        <div class="col-sm-5">
                                                                            <div class="controls">
                                                                                 <div class="input-group">
                                                                                    <select name="decision" class="form-control" required data-validation-required-message="Please select Decision">
                                                                                        <option value="Agree">Agree</option>
                                                                                        <option value="Not-Agree">Not-Agree</option>
                                                                                        </select>
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="fas fa-flag-checkered"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>                                                                                
                                                                            </div>
                                                                        </div>

                                                                        <label  class="col-sm-2 control-label">Enter Date</label>
                                                                        <div class="col-sm-4">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" readonly value="<?php echo date('M d, Y h:i:s A'); ?>"> 
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="fa fa-calendar"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <label  class="col-sm-1 control-label">Statement</label>
                                                                        <div class="col-sm-11">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <script type="text/javascript">
                                                                                        function success() {
                                                                                            if(document.getElementById("statementTwo").value==="") { 
                                                                                                document.getElementById('submitTwo').disabled = true; 
                                                                                            } else { 
                                                                                                document.getElementById('submitTwo').disabled = false;
                                                                                            }
                                                                                        }
                                                                                    </script>
                                                                                    <textarea name="statementTwo" id="statementTwo" onkeyup="success()" rows="2" class="form-control" required data-validation-required-message="Please enter Statement"></textarea>
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="far fa-comment"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>                                                            
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end form-group row --->
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <div class="offset-sm-1 col-sm-11">
                                                                            <button type="submit" name="submitTwo" id="submitTwo" class="btn btn-info waves-effect waves-light" disabled><i class="fa fa-paper-plane"></i> Submit</button>
                                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        <?php 
                                                    }
                                                ?>

                                                <!-------THIS FORM IS VISIBLE ONLY TO THE HEADS/MODERATORS-------->
                                                <?php 
                                                    $checkVisibility = new DbaseManipulation;
                                                    $sql = "SELECT * FROM grievance_workflow WHERE approver_id = $myPositionId AND category_id = $cateGoryaId";
                                                    $row = $checkVisibility->singleReadFullQry($sql);
                                                    $sequence_no = $row['sequence_no'];
                                                    $checkSequence = new DbaseManipulation;
                                                    $checkSequence->singleReadFullQry("SELECT * FROM grievance WHERE id = $gid AND current_sequence_no = $sequence_no AND status = 'OPEN' AND category_id = $cateGoryaId");
                                                    if($checkSequence->totalCount != 0) {
                                                        ?>
                                                            <div class="card-body bg-light p-r-5 p-l-5">
                                                                <?php 
                                                                    if(isset($_POST['submit1'])) {
                                                                        $fields = [
                                                                            'grievance_id'=>$gid,
                                                                            'staffId'=>$staffId,
                                                                            'meeting_date'=>date('Y-m-d',strtotime($_POST['meeting_date'])),
                                                                            'statement'=>$_POST['statement'],
                                                                            'decision'=>'Recommended',
                                                                            'dateEntered'=>date('Y-m-d H:i:s',time())
                                                                        ];
                                                                        //print_r($fields); exit;
                                                                        $submitRecommendation = new DbaseManipulation;
                                                                        if($submitRecommendation->insert("grievance_history",$fields)){
                                                                                $getIdInfo = new DbaseManipulation;
                                                                                $history = $getIdInfo->readData("SELECT * FROM grievance_history WHERE grievance_id = $gid ORDER BY id DESC");
                                                                                $respondentInfo = new DbaseManipulation;
                                                                                $respondentName = $respondentInfo->getStaffName($responderId,'firstName','secondName','thirdName','lastName');
                                                                                $respondentEmail = $helper->getContactInfo(2,$responderId,'data');
                                                                                $respondentgsm = $helper->getContactInfo(1,$responderId,'data');
                                                                                $respondentDepartmentId = $helper->employmentIDs($responderId,'department_id');
                                                                                $respondentDepartment = $helper->fieldNameValue("department",$respondentDepartmentId,"name");

                                                                                $from_name = 'hrms@nct.edu.om';
                                                                                $from = 'HRMS - 3.0';
                                                                                $subject = 'NCT-HRMD GRIEVANCE RECOMMENDATION HAS BEEN FILED BY '.strtoupper($logged_name);
                                                                                $message = '<html><body>';
                                                                                $message .= '<img src="https://hr.nct.edu.om/img/hr-logo-email.png" width="419" height="65" />';
                                                                                $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE DETAILS</h3>";
                                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                                $message .= "<tr style='background:#E0F8F7; width:400px'><td><strong>STATUS:</strong> </td><td>Open</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB; width:400px'><td><strong>REQUEST ID:</strong> </td><td>".$gid."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>DATE FILED:</strong> </td><td>".date('M d, Y h:i:s A',strtotime($detail['date_filed']))."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT STAFF ID:</strong> </td><td>".$responderId."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT NAME:</strong> </td><td>".$respondentName."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT DEPARTMENT:</strong> </td><td>".$respondentDepartment."</td></tr>";
                                                                                $message .= "<tr style='background:#E0F8F7'><td><strong>RESPONDENT ADDRESS:</strong> </td><td>".$respondentEmail."</td></tr>";
                                                                                $message .= "<tr style='background:#EFFBFB'><td><strong>RESPONDENT NUMBER:</strong> </td><td>".$respondentgsm."</td></tr>";
                                                                                $message .= "</table>";
                                                                                $message .= "<hr/>";
                                                                                $message .= "<h3>NCT-HRMS 3.0 GRIEVANCE HISTORIES</h3>";
                                                                                $message .= '<table style="border-color:#666; width:800px" cellpadding="10">';
                                                                                $message .= "<tr style='background:#F8E0E0'>";
                                                                                    $message .= "<th><strong>STAFF NAME</strong></th>";
                                                                                    $message .= "<th><strong>NOTES/COMMENTS</strong></th>";
                                                                                    $message .= "<th><strong>STATUS</strong></th>";
                                                                                    $message .= "<th><strong>DATE/TIME</strong></th>";
                                                                                $message .= "</tr>";
                                                                                $ctr = 1; $stripeColor = "";    
                                                                                foreach($history as $row){
                                                                                    if($ctr % 2 == 0) {
                                                                                        $stripeColor = '#FBEFEF';
                                                                                    } else {
                                                                                        $stripeColor = '#FBF2EF';
                                                                                    }
                                                                                    $fullStaffNameEmail = $getIdInfo->getStaffName($row['staffId'],'firstName','secondName','thirdName','lastName');
                                                                                    $dateNotesEmail = date('d/m/Y H:i:s',strtotime($row['dateEntered']));
                                                                                    $notesEmail = $row['statement'];
                                                                                    $statusEmail = $row['decision'];
                                                                                    $message .= "
                                                                                        <tr style='background:$stripeColor'>
                                                                                            <td style='width:200px'>".$fullStaffNameEmail."</td>
                                                                                            <td style='width:200px'>".$notesEmail."</td>
                                                                                            <td style='width:200px'>".$statusEmail."</td>
                                                                                            <td style='width:200px'>".$dateNotesEmail."</td>
                                                                                        </tr>
                                                                                    ";
                                                                                    $ctr++;
                                                                                }
                                                                                $message .= "</table>";
                                                                                $message .= "<br/>";
                                                                                $message .= "</body></html>";
                                                                                $to = array();
                                                                                
                                                                                
                                                                                $complainantEmail = $contact_details->getContactInfo(2,$complainantId,'data');
                                                                                array_push($to,$logged_in_email,$complainantEmail);
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
                                                                                        'requestNo'=>$gid,
                                                                                        'moduleName'=>'Grievance Application Recommendation',
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
                                                                                        'requestNo'=>$gid,
                                                                                        'moduleName'=>'Grievance Application Recommendation',
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
                                                                ?>
                                                                <form class="form-horizontal" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <label  class="col-sm-1 control-label">Staff Name</label>
                                                                        <div class="col-sm-5">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <input type="text" name="" class="form-control" readonly value="<?php echo $logged_name ?>"> 
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="fas fa-user"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <label  class="col-sm-2 control-label">Job Title</label>
                                                                        <?php 
                                                                            $staffJobTitleId = $helper->employmentIDs($staffId,'jobtitle_id');
                                                                            $staffJobTitleName = $helper->fieldNameValue("jobtitle",$staffJobTitleId,"name");
                                                                        ?>
                                                                        <div class="col-sm-4">
                                                                            <div class="controls">
                                                                                    <div class="input-group">
                                                                                    <input type="text" name="staffName" class="form-control" readonly value="<?php echo $staffJobTitleName ?>"> 
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="far fa-credit-card"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <label  class="col-sm-1 control-label">Meeting Date</label>
                                                                        <div class="col-sm-5">
                                                                            <div class="controls">
                                                                                 <div class="input-group">
                                                                                    <input type="text" value="<?php echo date('m/d/Y'); ?>" name="meeting_date" id="meeting_date" class="form-control" required data-validation-required-message="Please enter Meeting Date"> 
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="fa fa-calendar-alt"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>                                                                
                                                                            </div>
                                                                        </div>
                                                                        <label  class="col-sm-2 control-label">Enter Date</label>
                                                                        <div class="col-sm-4">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" name="enteredDate" readonly value="<?php echo date('M d, Y h:i:s A'); ?>"> 
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="fa fa-calendar"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <label  class="col-sm-1 control-label">Recommendation</label>
                                                                        <div class="col-sm-11">
                                                                            <div class="controls">
                                                                                <div class="input-group">
                                                                                    <textarea name="statement" rows="2" id="textarea" class="form-control" required data-validation-required-message="Please enter Recommendation or Meeting Summary"></textarea>
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text" id="basic-addon2">
                                                                                            <i class="far fa-comment"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end form-group row --->
                                                                    <div class="form-group row m-b-5 m-t-0">
                                                                        <div class="offset-sm-1 col-sm-11">
                                                                            <button type="submit" name="submit1" class="btn btn-info waves-effect waves-light"><i class="fa fa-paper-plane"></i> Submit</button>
                                                                            <button type="reset" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-retweet"></i> Reset</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        <?php 
                                                    }    
                                                ?>        
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
                <script>
                    // MAterial Date picker    
                    $('#meeting_date').datepicker({ weekStart: 0, time: false,format: 'mm/dd/yyyy' });
                    jQuery('#date-range').datepicker({
                        toggleActive: true
                    });
                </script>
                 
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>