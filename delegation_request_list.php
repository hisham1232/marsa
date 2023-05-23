<?php    
    include('include_headers.php');
    if(!$helper->isUserLogged()) {
        include_once('not_allowed.php');
    } else {
        //$allowed = ($helper->isAllowed('SuperAdmin') || $helper->isAllowed('HRHead') || $helper->isAllowed('HRStaff')) ? true : false;
        $linkid = $helper->cleanString($_GET['linkid']);
        $allowed = $helper->withAccess($user_type,$linkid);
        if($allowed){                                 
?>
            <body class="fix-header fix-sidebar card-no-border">
                <script src="assets/plugins/jquery/jquery.min.js"></script>
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
                                    <h3 class="text-themecolor m-b-0 m-t-0">Delegation Request List</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item">Delegation</li>
                                        <li class="breadcrumb-item">Delegation Request List</li>
                                    </ol>
                                </div>
                                <?php include('include_time_in_info.php'); ?>
                            </div>
                            <?php
                                if(isset($_POST['approveDelegation'])) {
                                    ?>
                                        <script>
                                            $(document).ready(function() {
                                                $('#myModal').modal('show');
                                            });
                                        </script>
                                    <?php
                                }
                            ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                        $rows = $helper->readData("SELECT d.*, concat(s.firstName,' ',s.secondName,' ',s.thirdName,' ',s.lastName) as delegator, dd.position_id as delegator_position_id FROM delegation as d LEFT OUTER JOIN staff as s ON s.staffId = d.staffIdFrom LEFT OUTER JOIN employmentdetail as dd ON dd.staff_id = d.staffIdFrom WHERE d.status = 'Pending' AND d.staffIdTo = '$staffId' AND dd.isCurrent = 1 AND dd.status_id = 1");
                                        if($helper->totalCount != 0) {
                                            ?>
                                            <div class="card">
                                                <div class="card-header bg-light-success2 p-t-5 p-b-0">
                                                    <h4 class="card-title">Request for Appoval of Delegation List</h4>
                                                    <h6 class="card-subtitle">طلبات إعتماد التفويض</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="dynamicTable" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Request No</th>
                                                                    <th>Delegate By</th>
                                                                    <th>Delegated Role</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Days</th>
                                                                    <th>Note</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    foreach($rows as $row){
                                                                        $roles = "";
                                                                        ?>
                                                                            <tr>
                                                                                <td class="text-primary"><?php echo $row['requestNo']; ?></td>
                                                                                <td><?php echo $row['delegator']; ?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        if($row['shl'] == 1) {
                                                                                            echo "<span class='badge badge-success'>Short Leave Approval</span> ";
                                                                                        }
                                                                                        if($row['stl'] == 1) {
                                                                                            echo "<span class='badge badge-primary'>Standard Leave Approval</span> ";
                                                                                        }
                                                                                        if($row['otl'] == 1) {
                                                                                            echo "<span class='badge badge-warning'>Overtime Leave Approval</span> ";
                                                                                        }
                                                                                        if($row['clr'] == 1) {
                                                                                            echo "<span class='badge badge-danger'>Clearance Approval</span> ";
                                                                                        }
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo date('d/m/Y',strtotime($row['startDate'])); ?></td>
                                                                                <td><?php echo date('d/m/Y',strtotime($row['endDate'])); ?></td>
                                                                                <td>
                                                                                    <?php 
                                                                                        $datetime1 = strtotime($row['startDate']);
                                                                                        $datetime2 = strtotime($row['endDate']);
                                                                                        $interval = $datetime2 - $datetime1;
                                                                                        echo round($interval / (60 * 60 * 24)) + 1;
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $row['reason']; ?></td>
                                                                                <td>
                                                                                    <a href="javascript:;" title="Click to Approve Delegation" class="btn btn btn-outline-primary btn modalViewAction" data-id="<?php echo $row['id']; ?>" data-requestno="<?php echo $row['requestNo']; ?>" data-dpi="<?php echo $row['delegator_position_id']; ?>" role="button" aria-pressed="true"><i class="fas fa-search"></i> View</a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            ?>        
                                            <div class="card">
                                                <div class="card-body bg-light-success2">
                                                    <div class="d-flex flex-wrap">
                                                        <div style="margin:auto !important;">
                                                            <h1 class="text-info" style="font-size: 110px !important; font-weight: 700 !important;line-height: 110px !important; text-align: center !important;">
                                                                <center><i class="fas fa-clipboard-list"></i></center>
                                                            </h1>
                                                            <h2 class="text-danger">NO records waiting for APPROVAL!</h2>
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
                        <footer class="footer">
                            <?php include('include_footer.php'); ?>
                        </footer>
                    </div>
                </div>
                <?php include('include_scripts.php'); ?>
                <script>                    
                    function ajaxLoader(linkPage,variables,divName){
                        $(divName).empty().html("<i class='fa fa-info-circle text-warning'></i> <span class='text-warning'>Processing your action, please wait</span> <img src='scripts/ajax-loader.gif'/>");
                        $.get(linkPage + "?" + variables,function(data){$(divName).html(data);});
                    }                        
                    $('.modalViewAction').click(function(e){
                        var id = $(this).data('id');
                        var requestNo = $(this).data('requestno');
                        var delegatorPositionId = $(this).data('dpi');
                        var data = {
                            id : id,
                            requestNo : requestNo
                        }
                        $.ajax({
                            url	 : 'ajaxpages/delegations/approvals/delegation_approval.php'
                            ,type	 : 'POST'
                            ,dataType: 'json'
                            ,data	 : data
                            ,success : function(e){
                                if(e.error == 1){
                                    bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>An error has been encountered during processing.");
                                } else {
                                    var dialog = bootbox.dialog({
                                        closeButton: false,
                                        size: 'large',
                                        message: e.message,
                                        title: "<p class='text-primary ApprovedConfirmation'><i class='fas fa-info-circle'></i> Delegation Approval</p>",
                                        buttons: {
                                            decline: {
                                                label: '<i class="fas fa-thumbs-down"></i> Decline',
                                                className: 'btn-danger btn-bootbox-decline',
                                                callback: function(result){
                                                    var id = e.id;
                                                    var requestNo = e.requestNo;                                                    
                                                    var delegation_ids = [];
                                                    $.each($("input[name='delegation_task_id']:checked"), function(){            
                                                        delegation_ids.push($(this).val());
                                                    });
                                                    var selected_ids = delegation_ids.join(", ");
                                                    if(selected_ids == '') {
                                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You must check at least one delegated role.");
                                                        return false;
                                                    } else {
                                                        var notes = $('.notesComments').val();
                                                        if(notes == '') {
                                                            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Your notes or comments must not be blank.");
                                                            return false;
                                                        } else {
                                                            ajaxLoader("notification_for_approvals_actions.php","id="+id+"&requestNo="+requestNo+"&selected_ids="+selected_ids+"&notes="+notes+"&action=2&approvalType=dlt",".ApprovedConfirmation");
                                                            $('.btn-bootbox-approve').hide();
                                                            $('.btn-bootbox-decline').hide();
                                                            $('.btn-bootbox-close').hide();
                                                            return false;
                                                        }
                                                    }    
                                                }
                                            },
                                            ok: {
                                                label: '<i class="fas fa-thumbs-up"></i> Approve',
                                                className: 'btn-primary btn-bootbox-approve',
                                                callback: function (result) {
                                                    var id = e.id;
                                                    var requestNo = e.requestNo;                                                    
                                                    var delegation_ids = [];
                                                    $.each($("input[name='delegation_task_id']:checked"), function(){            
                                                        delegation_ids.push($(this).val());
                                                    });
                                                    var selected_ids = delegation_ids.join(", ");
                                                    if(selected_ids == '') {
                                                        bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>You must check at least one delegated role.");
                                                        return false;
                                                    } else {
                                                        var notes = $('.notesComments').val();
                                                        if(notes == '') {
                                                            bootbox.alert("<strong class='text-danger'><i class='fa fa-exclamation-triangle'></i> Unable To Continue!</strong><br/><br/>Your notes or comments must not be blank.");
                                                            return false;
                                                        } else {
                                                            ajaxLoader("notification_for_approvals_actions.php","id="+id+"&requestNo="+requestNo+"&selected_ids="+selected_ids+"&notes="+notes+"&delegatorPositionId="+delegatorPositionId+"&action=1&approvalType=dlt",".ApprovedConfirmation");
                                                            $('.btn-bootbox-approve').hide();
                                                            $('.btn-bootbox-decline').hide();
                                                            $('.btn-bootbox-close').hide();
                                                            return false;
                                                        }
                                                    }                                                                                                        
                                                }
                                            },
                                            cancel: {
                                                label: "<i class='fas fa-times'></i> Close Form",
                                                className: 'btn-warning btn-bootbox-close',
                                                callback: function(){
                                                    console.log('Close Form button clicked');
                                                }
                                            }
                                        }
                                    });
                                }	
                            }
                            ,error	: function(e){
                            }
                        });
                    });
                </script>                        



                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body" style="text-align: center">
                                <h3 class="modal-title text-primary" id="myModalLabel"><i class='fa fa-info-circle'></i> Success</h3>
                                <h5>Delegation has been accepted/approved successfully!</h5>
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