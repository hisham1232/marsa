<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $gid = $_GET['id'];
        $check = new DbaseManipulation;
        $info = $check->singleReadFullQry("SELECT COUNT(id) as bilang FROM grievance WHERE id = $gid");
        $bilang = $info['bilang'];
        if($bilang > 0)
            $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $staffId == '119084' || $staffId == '121101' || $staffId == '107036') ? true : false;
        else
            $allowed =  false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
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
                                                                $complaint_type = 'Non-Academic';
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
                            <!----------------------------------->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-t-0 m-b-0"><!-- card-outline-success-->
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
            </body>
            <?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>