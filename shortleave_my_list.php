<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed =  true;
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
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Short Leave</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Short Leave</li>
                                        <li class="breadcrumb-item active">My Short Leave</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-xs-18">
                                    <div class="card card-body p-b-0">
                                        <form action="" method="POST" novalidate enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Select Leave Date</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control daterange" />
                                                        <input type="hidden" name="startDate" class="form-control startDate" />
                                                        <input type="hidden" name="endDate" class="form-control endDate" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <button name="searchByDate" class="btn btn-success waves-effect waves-light" type="submit" title="Click to Search"><i class="fas fa-search"></i> Search</button>
                                                    </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-18">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading"><i class="fa fa-info-circle"></i> Information!</h4>
                                        <small>Select starting and ending date in the date range picker and then click on Search Button.</small>
                                        <div style="height:4px"></div>
                                    </div>
                                </div>
                            </div>
                                        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0">
                                            <?php
                                                $basic_info = new DBaseManipulation;        
                                                $info = $basic_info->singleReadFullQry("SELECT s.id, s.staffId, d.name as department, sc.name as section, sp.name as sponsor, j.name as jobtitle, e.status_id FROM staff as s LEFT OUTER JOIN employmentdetail as e ON s.staffId = e.staff_id LEFT OUTER JOIN department as d ON d.id = e.department_id LEFT OUTER JOIN section as sc ON e.section_id = sc.id LEFT OUTER JOIN sponsor as sp ON sp.id = e.sponsor_id LEFT OUTER JOIN jobtitle as j ON j.id = e.jobtitle_id WHERE s.staffId = '$staffId'");

                                                $row = $helper->singleReadFullQry("SELECT id, department_id, position_id, approverInSequence1 FROM approvalsequence_shortleave WHERE active = 1 AND position_id = $myPositionId");
                                                $myApproverPositionId = $row['approverInSequence1'];
                                                //echo $myApproverPositionId; exit;    
                                                $nextApprover = $helper->singleReadFullQry("SELECT TOP 1 staff_id FROM employmentdetail WHERE position_id = $myApproverPositionId AND isCurrent = 1 AND status_id = 1");
                                                $nextApproversStaffId = $nextApprover['staff_id'];
                                                $nextApproverEmailAdd = $helper->getContactInfo(2,$nextApproversStaffId,'data');
                                                
                                            ?>
                                            <input type="hidden" class="approverStaffId" value="<?php echo $nextApproversStaffId; ?>" />
                                            <input type="hidden" class="approverEmail" value="<?php echo $nextApproverEmailAdd; ?>" />
                                            <h4 class="card-title">Short Leave List <span class="text-primary">[<?php echo $logged_name." - ".$info['department']." - ".$info['sponsor']." - ".$info['jobtitle']; ?>]</span></h4>
                                            <h6>قائمة الإجازات القصيرة</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="shortLeaveList" class="display table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Request ID</th>
                                                            <th>Requested Date</th>
                                                            <th>Leave Date</th>
                                                            <th>Start Time</th>
                                                            <th>Return Time</th>
                                                            <th>No. of Hours</th>
                                                            <th>Last Update</th>
                                                            <th>Last Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(isset($_POST['searchByDate'])) {
                                                                $startDate = $_POST['startDate'];
                                                                $endDate = $_POST['endDate'];
                                                                $SQL = "SELECT * FROM shortleave WHERE staff_id = $staffId AND leaveDate >= '$startDate' AND leaveDate <= '$endDate' ORDER BY id DESC";
                                                            } else {
                                                                $SQL = "SELECT * FROM shortleave WHERE staff_id = $staffId ORDER BY id DESC";
                                                            }
                                                            //echo $SQL;
                                                            $rows = $helper->readData($SQL);
                                                            if($helper->totalCount != 0) {
                                                                foreach($rows as $row){
                                                                    ?>
                                                                    <tr id="<?php echo $row['id']; ?>">
                                                                        <td><a class="text-success history" style="cursor:pointer" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>"><?php echo $row['requestNo']; ?></a></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['dateFile'])); ?></td>
                                                                        <td><?php echo date('d/m/Y',strtotime($row['leaveDate'])); ?></td>
                                                                        <td><?php echo $row['startTime']; ?></td>
                                                                        <td><?php echo $row['endTime']; ?></td>
                                                                        <td><?php echo $row['total']; ?></td>
                                                                        <td><?php echo date('d/m/Y H:i:s',strtotime($helper->shortLeaveHistory($row['id'],'modified'))); ?></td>
                                                                        <td><?php echo $helper->shortLeaveHistory($row['id'],'status'); ?></td>
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
                            </div><!--end row for whole-->        
                        </div>            
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                
                <?php
                    include('include_scripts.php');
                ?>

                <script>
                    // Material Date picker    
                    $(function() {
                    $('.daterange').daterangepicker({
                        opens: 'left'
                    }, function(start, end, label) {
                        $(".startDate").val(start.format('YYYY-MM-DD'));
                        $('.endDate').val(end.format('YYYY-MM-DD'));
                        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                    });
                    });                            

                    //$('.daterange').daterangepicker();
                    $('.daterange').keypress(function(e) {
                        e.preventDefault();
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        function ajaxLoader(linkPage,variables,divName){
                            $(divName).empty().html("<i class='fa fa-info-circle text-warning'></i> <span class='text-warning'>Processing your action, please wait</span> <img src='scripts/ajax-loader.gif'/>");
                            $.get(linkPage + "?" + variables,function(data){$(divName).html(data);});
                        }
                        $('.history').click(function(e){
                            var id = $(this).data('id');
                            var requestNo = $(this).data('requestno');
                            var data = {
                                id : id,
                                requestNo : requestNo
                            }
                            $.ajax({
                                url	 : 'ajaxpages/leaves/shortleave/shortleave_history.php'
                                ,type	 : 'POST'
                                ,dataType: 'json'
                                ,data	 : data
                                ,success : function(e){
                                    if(e.error == 1){
                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                    } else {
                                        if(e.status == 'Pending') {
                                            var dialog = bootbox.dialog({
                                                closeButton: false,
                                                size: 'large',
                                                message: e.message,
                                                title: "<p class='processingRequest'><i class='fas fa-info-circle'></i> Short Leave History</p>",
                                                buttons: {
                                                    ok: {
                                                        label: '<i class="fas fa-ban"></i> Cancel This Request',
                                                        className: 'btn-primary btn-bootbox-yes',
                                                        callback: function (result) {
                                                            var id = e.id;
                                                            var requestNo = e.requestNo;
                                                            var approverId = $('.approverStaffId').val();
                                                            var approverEmail = $('.approverEmail').val();
                                                            var notes = $('.notesComments').val();
                                                            if(notes == '') {
                                                                bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Your notes or comments must not be blank.");
                                                                return false;
                                                            } else {
                                                                ajaxLoader("notification_for_approvals_actions.php","id="+id+"&requestNoS="+requestNo+"&approverId="+approverId+"&approverEmail="+approverEmail+"&notes="+notes+"&action=5&approvalType=shl",".processingRequest");
                                                                $('.btn-bootbox-yes').hide();
                                                                $('.btn-bootbox-close').hide();
                                                                return false;
                                                            }
                                                        }                                                        
                                                    },
                                                    cancel: {
                                                        label: "<i class='fas fa-times'></i> Close Form",
                                                        className: 'btn-danger btn-bootbox-close',
                                                        callback: function(){
                                                            console.log('Close Form button clicked');
                                                        }
                                                    }
                                                }
                                            });                                            
                                        } else {
                                            bootbox.alert({
                                                closeButton: false,
                                                size: 'large',
                                                message: e.message,
                                                title: "<span class='text-primary processingRequest'><i class='fa fa-info-circle'></i> Information</span>", 
                                            });
                                        }    
                                    }	
                                }
                                ,error	: function(e){
                                }
                            });
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