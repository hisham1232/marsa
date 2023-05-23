<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $uid = $_GET['uid'];
                $leave = new DbaseManipulation;
                $result = $leave->singleReadFullQry("SELECT s.id, s.requestNo, l.name as leave_type, s.dateFiled, s.startDate, s.endDate, s.total, s.modified, s.currentStatus, s.reason, s.attachment FROM standardleave as s LEFT OUTER JOIN leavetype as l ON l.id = s.leavetype_id WHERE s.requestNo = '$id' AND s.staff_id = '$uid'");                
                if($leave->totalCount <= 0) {
                    header("Location: internal_balance_all_balance.php");
                }
            } else {
                header("Location: internal_balance_all_balance.php");
            }                               
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Standard Leave Details</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Standard Leave</li>
                                        <li class="breadcrumb-item">All Standard Leave List</li>
                                        <li class="breadcrumb-item">Standard Leave Details</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card"><!-- card-outline-success-->
                                        <div class="card-header" style="background-color: #DCE7E6;">
                                            <div class="row">
                                                <div class="col-md-4"> 
                                                    <div class="d-flex flex-row">
                                                        <div class="mr-auto">
                                                            <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$uid.'.jpg'; ?>" style=" width:100px; height:100px; border-radius: 50%" alt="Staff ID"><br>
                                                        </div>
                                                        <div style="margin-left:20px">
                                                            <?php
                                                                $bal = new DbaseManipulation;
                                                                $basic_info = new DBaseManipulation;
                                                                $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$uid'");
                                                            ?>
                                                            <h5 class="text-primary"><?php echo trim($info['staffName']); ?></h5>
                                                            <h5><i class="fas fa-address-card text-muted"></i> <?php echo $info['staffId']; ?></h5>
                                                            <h5><?php echo $info['section']; ?></h5>
                                                            <h5><?php echo $info['department']; ?></h5> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"> 
                                                    <div class="d-flex flex-row">
                                                        <div>
                                                            <h5><?php echo $info['jobtitle']; ?></h5>
                                                            <h5><?php echo $info['sponsor']; ?></h5>
                                                            <?php
                                                                $contact_details = new DbaseManipulation;
                                                                //$email = $contact_details->getContactInfo(2,$staffId,'data');
                                                                //$gsm = $contact_details->getContactInfo(1,$staffId,'data');

                                                                $email = $contact_details->getContactInfo(2,$info['staffId'],'data');
                                                                $gsm = $contact_details->getContactInfo(1,$info['staffId'],'data');
                                                            ?>
                                                            <h5><?php echo $email; ?></h5>
                                                            <h5><i class="fas fa-address-card text-muted"></i> <?php echo $gsm; ?></h5>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6"> 
                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Internal Leave Balance</h5>
                                                        </div>
                                                        <?php $intLeaveBal = $bal->getInternalLeaveBalance($info['staffId'],'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $intLeaveBal; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>رصيد الإجازة الداخلية </h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Pending (Internal)</h5>
                                                        </div>
                                                        <?php $intLeavePen = $bal->getInternalLeavePending($info['staffId'],'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $intLeavePen; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>رصيد الإجازة الداخلية<</h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Emergency Leave Balance</h5>
                                                        </div>
                                                        <?php $emLeaveBal = $bal->getEmergencyLeaveBalance($info['staffId'],'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $emLeaveBal; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5> رصيد الإجازة الطارئة  </h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Pending (Emergency)</h5>
                                                        </div>
                                                        <?php $emLeavePen = $bal->getEmergencyLeavePending($info['staffId'],'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $emLeavePen; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>في الإنتظار(الطارئة)  </h5>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><!--end row-->

                                        </div><!--end card-header-->
                                        <?php
                                            if($leave->totalCount <= 0) {
                                        ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Failure!</h4>
                                                                        <p>Leave details not found! <a href="standardleave_my_list.php" class="btn btn-sm btn-primary"><i class="fa fa-undo"></i> Back To My Standard Leave List</a> or contact the system's administrator.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                        <?php            
                                            } else {
                                        ?>    
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-wrap">
                                                                        <div>
                                                                            <h3 class="card-title">Standard Leave Application Details</h3>
                                                                            <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                        </div>
                                                                        <div class="ml-auto">
                                                                            <ul class="list-inline">
                                                                                <li class="none">
                                                                                    <h3 class="text-muted text-success">Request No <span class="badge badge-primary requestNo"><?php echo $result['requestNo']; ?></span></h3>
                                                                                    <input type="hidden" value="<?php echo $result['id']; ?>" class="leaveMainId">
                                                                                    <input type="hidden" value="<?php echo $result['requestNo']; ?>" class="requestNumber">
                                                                                    <input type="hidden" value="<?php echo $uid; ?>" class="staffId">
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <form class="form-horizontal p-t-5" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                        <div class="form-group row">
                                                                            <label  class="col-sm-3 control-label">Date Requested <br> عتاريخ الطلب</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control" readonly value="<?php echo date('d/m/Y H:i:s',strtotime($result['dateFiled'])); ?>"> 
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-calendar-alt"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Kind of Leave <br>تاريخ الطلب
                                                                            </label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                    <input type="text" class="form-control" readonly value="<?php echo $result['leave_type']; ?>">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-credit-card"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group row">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Leave Date</label>
                                                                            <div class="col-sm-9">
                                                                                <div class='input-group mb-3'>
                                                                                <input type="text" class="form-control" readonly value="<?php echo date('d/m/Y',strtotime($result['startDate']))." to ".date('d/m/Y',strtotime($result['endDate'])); ?>">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text">
                                                                                            <span class="far fa-calendar-alt"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label  class="col-sm-3 control-label">Number of Days <br> عدد الأيام</label>           
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                    <input type="text" class="form-control" readonly value="<?php echo $result['total']; ?>">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="fas fa-hashtag"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                            if($result['attachment'] == "") {
                                                                        ?>
                                                                                <div class="form-group row">
                                                                                    <label  class="col-sm-3 control-label">Attachment <br>المرفقات</label>
                                                                                    <div class="col-sm-9">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                            <input type="text" class="form-control" readonly value="No attachment found.">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text" id="basic-addon2">
                                                                                                        <i class="fas fa-file-pdf"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        <?php        
                                                                            } else {
                                                                        ?>
                                                                                <div class="form-group row">
                                                                                    <label  class="col-sm-3 control-label">Attachment <br>المرفقات</label>
                                                                                    <div class="col-sm-9">
                                                                                        <div class="controls">
                                                                                            <div class="input-group">
                                                                                            <button type="button" data-toggle="modal" data-target="#attachmentModal" data-whatever="@mdo" class="btn btn-info btn-block"><i class="fa fa-search"></i> View Attachment <i class="fas fa-file-pdf"></i></button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-lg">
                                                                                    <div class="modal-content">
                                                                                    <div class="modal-header bg-light-danger2">
                                                                                        <h4 class="modal-title" id="exampleModalLabel1"><i class="fas fa-file-pdf"></i> Leave Attachment</h4>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                    </div>
                                                                                        <div class="modal-body">
                                                                                        <div style="text-align: center;">
                                                                                            <iframe src="<?php echo $result['attachment']; ?>" style="width:100%; height:700px" frameborder="0"></iframe>
                                                                                        </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                                    
                                                                                
                                                                        <?php
                                                                            }
                                                                        ?>                
                                                                        <div class="form-group row">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Reasons for Leave <br>سبب الإجازة</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea class="form-control" rows="2" readonly><?php echo $result['reason']; ?></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-comment"></i>
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

                                                        <!---------------------------------------------------------------------------------------------------------->
                                                        <!---------------------------------------------------------------------------------------------------------->

                                                        <div class="col-lg-6">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-wrap">
                                                                        <div>
                                                                            <h3 class="card-title">Leave Approval Sequence</h3>
                                                                            <h6 class="card-subtitle">Arabic Text Here</h6>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                        $i = 0;
                                                                        $rows = $helper->readData("SELECT * FROM standardleave_history WHERE requestNo = '$id'");
                                                                        if($helper->totalCount != 0) {
                                                                            foreach($rows as $row){
                                                                                ?>
                                                                                <div class="ribbon-vwrapper card">
                                                                                    <div class="ribbon ribbon-info ribbon-vertical-l"><?php echo ++$i; ?></div>
                                                                                    <h3 class="ribbon-content"><em>Status:</em> <?php echo $row['status']; ?></h3>
                                                                                    <span class="text-muted pull-right"><?php echo date('F d, Y H:i:s',strtotime($row['created'])); ?></span></span></p>
                                                                                    <p class="ribbon-content"><i><?php echo $row['notes']; ?>.</i></p>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    ?>        
                                                                </div>
                                                                <div class="card-body">
                                                                        <a href="pdf_single_leave.php?staffId=<?php echo $uid; ?>&requestNo=<?php echo $id; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print (All Approval)</a>
                                                                        <a href="pdf_single_leave2.php?staffId=<?php echo $uid; ?>&requestNo=<?php echo $id; ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print (First and Last Approval)</a>
                                                                        <a class="btn btn-danger text-white btnDelete"><i class="fa fa-trash"></i> Delete This Leave</a>
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

                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script>
                    $('.btnDelete').click(function(){
                        var id = $('.leaveMainId').val();
                        var requestNo = $('.requestNumber').val();
                        var staffId = $('.staffId').val();
                        
                        bootbox.hideAll();
                        bootbox.confirm({
                            message: "<h4 class='text-dark'><i class='fa fa-question-circle'></i> Are you sure?</h4><br/><p>This will <strong>permanently</strong> delete this leave. <br/>Once deleted, you cannot undo it.</p><p><small class='text-danger'>",
                            buttons: {
                                confirm: {
                                    label: '<i class="fas fa-check"></i> Yes',
                                    className: 'btn-danger'
                                },
                                cancel: {
                                    label: '<i class="fas fa-times"></i> No',
                                    className: 'btn-dark'
                                }
                            },
                            callback: function (result) {
                                if(result==true){
                                    var data = {
                                        id      : id,
                                        requestNo: requestNo,
                                        deleting: 'standard_leave'
                                    }
                                    $.ajax({
                                        url  : 'ajaxpages/leaves/standardleave/standardleave_delete.php',
                                        type    : 'POST',
                                        dataType: 'json',
                                        data    : data,
                                        success : function(e){
                                            if(e.errors == 0) {
                                                bootbox.hideAll();
                                                bootbox.alert("<h4>Leave has been deleted!</h4>", function(){ window.location.href = "internal_balance_staff_history.php?id="+staffId; })
                                            } else {
                                                bootbox.hideAll();
                                                bootbox.alert("<h4>Error deleting leave!</h4>", function(){ location.reload(); })
                                            }
                                        }, error  : function(e){}
                                    });
                                }
                            }
                        });
                    });
                </script>  
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>