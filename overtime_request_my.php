<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff') || $helper->isAllowed('HoD_HoC') || $helper->isAllowed('HoS') || $helper->isAllowed('Approver')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
?>
            <body class="fix-header fix-sidebar card-no-border">
                <?php /*<div class="preloader">
                    <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
                </div>*/ ?>
                <?php
                    $departmentName = $helper->fieldNameValue("department",$logged_in_department_id,'name');
                    $sponsorName = $helper->fieldNameValue("sponsor",$logged_in_sponsor_id,'name');
                ?>
                <div id="main-wrapper">
                    <header class="topbar">
                        <?php include('menu_top.php'); ?>
                    </header>
                    <?php include('menu_left.php'); ?>
                    <div class="page-wrapper">
                        <div class="container-fluid">
                            <div class="row page-titles">
                                <div class="col-md-5 col-8 align-self-center">
                                    <h3 class="text-themecolor m-b-0 m-t-0">My Compensatory Leave Request List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">Home</a></li>
                                        <li class="breadcrumb-item">Compensatory Leave</li>
                                        <li class="breadcrumb-item active">My Compensatory Leave Request List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-light-yellow m-b-0">
                                            <h4 class="card-title">Compensatory Leave Request List Filed By <span class="text-primary">[<?php echo $logged_name.' - '.$departmentName.' - '.$sponsorName; ?>]</span></h4>
                                            <h6>قائمة طلبات العمل الإضافي</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Request ID</th>
                                                            <th>Request Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $rows = $helper->readData("SELECT * FROM internalleaveovertimefiled WHERE createdBy = '$staffId'");
                                                            if($helper->totalCount != 0) {
                                                                $i = 0;
                                                                foreach($rows as $row){
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo ++$i.'.'; ?></td>
                                                                        <td><?php echo $row['requestNo']; ?></td>
                                                                        <td><?php echo date('d/m/Y H:i:s',strtotime($row['dateFiled'])); ?></td>
                                                                        <td><?php echo $helper->overtimeLastStatus($row['requestNo'],'status'); ?></td>
                                                                        <td>
                                                                            <?php /*<a style="cursor:pointer" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" class="btn btn-outline-primary waves-effect waves-light viewDetails" title="Click to View Details"><i class="fas fa-search"></i> View Details</a>*/ ?>
                                                                            <a href="overtime_request_approval.php?id=<?php echo $row['id']; ?>&linkid=<?php echo $linkid; ?>" class="btn btn-outline-info waves-effect waves-light" title="Click to View Approvals"><i class="fas fa-file-alt"></i> View Approvals</a>
                                                                        </td>
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
                            </div>
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
                <!-- <script>
                    $(document).ready(function() {
                        function ajaxLoader(linkPage,variables,divName){
                            $(divName).empty().html("<i class='fa fa-info-circle text-warning'></i> <span class='text-warning'>Processing your action, please wait</span> <img src='scripts/ajax-loader.gif'/>");
                            $.get(linkPage + "?" + variables,function(data){$(divName).html(data);});
                        }
                        $('.viewDetails').click(function(e){
                            var id = $(this).data('id');
                            var requestNo = $(this).data('requestno');
                            var data = {
                                id : id,
                                requestNo : requestNo
                            }
                            $.ajax({
                                url	 : 'ajaxpages/leaves/overtime/overtime_history.php'
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
                </script> -->
            </body>
<?php
        } else {
            include_once('not_allowed.php');
        }
    }
?>            
</html>