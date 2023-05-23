<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        $allowed = true;
        //$linkid = $helper->cleanString($_GET['linkid']);
        //$allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $leave = new DbaseManipulation;
                $result = $leave->singleReadFullQry("SELECT s.id, s.requestNo, l.name as leave_type, s.dateFiled, s.startDate, s.endDate, s.total, s.modified, s.currentStatus, s.current_sequence_no, s.reason, s.attachment FROM standardleave as s LEFT OUTER JOIN leavetype as l ON s.leavetype_id = l.id WHERE s.requestNo = '$id' AND s.staff_id = '$staffId'");
                if($leave->totalCount <= 0) {
                    header("Location: standardleave_my_list.php");
                }
            } else {
                header("Location: standardleave_my_list.php");
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Standard Leave Details</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Standard Leave</li>
                                        <li class="breadcrumb-item">My Standard Leave List</li>
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
                                                            <img src="<?php echo 'https://www.nct.edu.om/images/staff-photos/'.$staffId.'.jpg'; ?>" style=" width:100px; height:100px; border-radius: 50%" alt="Staff ID"><br>
                                                        </div>
                                                        <div style="margin-left:20px">
                                                            <?php
                                                                $bal = new DbaseManipulation;
                                                                $basic_info = new DBaseManipulation;
                                                                $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as staffName, s.gender, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");
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
                                                                $email = $contact_details->getContactInfo(2,$staffId,'data');
                                                                $gsm = $contact_details->getContactInfo(1,$staffId,'data');
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
                                                        <?php $intLeaveBal = $bal->getInternalLeaveBalance($staffId,'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $intLeaveBal; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>رصيد الإجازة الداخلية </h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Pending (Internal)</h5>
                                                        </div>
                                                        <?php $intLeavePen = $bal->getInternalLeavePending($staffId,'balance'); ?>
                                                        <div class="col-2"><h5 class="text-primary"><?php echo $intLeavePen; ?></h5></div>
                                                        <div class="col-5"> 
                                                            <h5>رصيد الإجازة الداخلية<</h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Emergency Leave Balance</h5>
                                                        </div>
                                                        <div class="col-2"><h5 class="text-primary">3</h5></div>
                                                        <div class="col-5"> 
                                                            <h5> رصيد الإجازة الطارئة  </h5>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-5"> 
                                                            <h5>Pending (Emergency)</h5>
                                                        </div> <!--end col 5-->
                                                        <div class="col-2"><h5 class="text-primary">1</h5></div>
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
                                                                            <h6 class="card-subtitle">تفاصيل الطلب</h6>
                                                                        </div>
                                                                        <div class="ml-auto">
                                                                            <ul class="list-inline">
                                                                                <li class="none">
                                                                                    <h3 class="text-muted text-success">Request No <span class="badge badge-primary requestNo"><?php echo $result['requestNo']; ?></span></h3>
                                                                                    <input type="hidden" class="request_no" value="<?php echo $result['requestNo']; ?>" />
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-horizontal p-t-5" action="" method="POST" novalidate enctype="multipart/form-data">
                                                                    <div class="form-group row">
                                                                            <label  class="col-sm-3 control-label">Current Status <br> الحالة</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control" readonly value="<?php echo $result['currentStatus']; ?>">
                                                                                        <input type="hidden" class="form-control aydi" value="<?php echo $result['id']; ?>"> 
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="fa fa-chart-line"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label  class="col-sm-3 control-label">Date Requested <br>تاريخ الطلب</label>
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
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Kind of Leave <br>نوع الإجازة
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
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Leave Date <br>تاريخ الإجازة</label>
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
                                                                        <div class="form-group row stateYourReason">
                                                                            <label  class="col-sm-3 control-label"><span class="text-danger">*</span>Why cancel leave? <br>   سبب الغاء الاجازة    </label>
                                                                            <div class="col-sm-9">
                                                                                <div class="controls">
                                                                                    <div class="input-group">
                                                                                        <textarea class="form-control cancelReason" rows="2"></textarea>
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text" id="basic-addon2">
                                                                                                <i class="far fa-envelope"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                            if($result['currentStatus'] == 'Pending' && $result['current_sequence_no'] == 1) { //Only pending leaves can be cancelled.
                                                                        ?>    
                                                                                <div class="form-group row m-b-0">
                                                                                    <div class="offset-sm-3 col-sm-9 actionComplete">
                                                                                        <button name="showCancelApplication" class="btn btn-danger waves-effect waves-light cancelApplication"><i class="fa fa-ban"></i> I want to cancel this application</button>
                                                                                        <button name="proceeedCancelApplication" class="btn btn-info waves-effect waves-light proceeedCancelApplication"><i class="fa fa-paper-plane"></i> Proceed Cancellation</button>
                                                                                        <a href="" class="btn btn-inverse waves-effect waves-light resetCancel"><i class="fa fa-retweet"></i> Reset</a>
                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        ?>        
                                                                    </div>
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
                                                                            <h6 class="card-subtitle">تسلسل إعتماد الإجازة</h6>
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
                                                                    <a href="pdf_single_leave.php?staffId=<?php echo $staffId; ?>&requestNo=<?php echo $id; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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
                    /*RETRIEVING DATA FROM THE SELECT ROWS FUNCTION-------------------------------------------------------------------- */
                    $(document).ready(function () {
                        $('.stateYourReason').hide();
                        $('.proceeedCancelApplication').hide();
                        $('.resetCancel').hide();
                        function ajaxLoader(linkPage,variables,divName){
                            $(divName).empty().html("<i class='fa fa-info-circle text-warning'></i> <span class='text-warning'>Processing your action, please wait </span> <img src='scripts/ajax-loader.gif'/>");
                            $.get(linkPage + "?" + variables,function(data){$(divName).html(data);});
                        }
                        
                        $('.cancelApplication').click(function(){
                            $('.stateYourReason').show();
                            $('.proceeedCancelApplication').show();
                            $('.resetCancel').show();
                            $('.cancelReason').focus();
                            $('.cancelApplication').hide();
                        });
                        $('.proceeedCancelApplication').click(function(){
                            var cancel_reason = $('.cancelReason').val();
                            var id = $('.aydi').val();
                            var request_no = $('.request_no').val();
                            if(cancel_reason == "") {
                                bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Your reason for cancelling leave must not be blank.");                            
                            } else {
                                ajaxLoader("notification_for_approvals_actions.php","id="+id+"&notes="+cancel_reason+"&requestNo="+request_no+"&action=1&approvalType=stlcancel",".actionComplete");
                            }    
                        });
                    });
                    /*-------------------------------------------------------------------------------------------------------------------*/
                </script>  
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>